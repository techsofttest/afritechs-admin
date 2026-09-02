<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CustomerOtpMail;
use App\Mail\CustomerVerificationMail;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    /**
     * Customer Registration
     * Requires email verification before login. Minimum 6 char password.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse e-mail valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        // Store customer unverified (email_verified_at = null)
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
        ]);

        // Generate 6-digit verification code
        $code = (string) rand(100000, 999999);
        Cache::put('register_verify_' . $request->email, $code, now()->addMinutes(15));
        Log::info("Verification code for new customer {$request->email}: {$code}");

        // Send Email Verification Code
        try {
            Mail::to($request->email)->send(new CustomerVerificationMail($code, $customer->name));
        } catch (Exception $e) {
            Log::error('Failed to send verification email: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Inscription réussie. Un code de vérification à 6 chiffres a été envoyé à votre adresse e-mail. Veuillez vérifier votre compte pour pouvoir vous connecter.',
            'requires_verification' => true,
            'email' => $customer->email,
        ], 201);
    }

    /**
     * Verify Customer Registration Email
     */
    public function verifyRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'code' => 'required|string|size:6',
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'code.required' => 'Le code de vérification est obligatoire.',
            'code.size' => 'Le code doit contenir exactement 6 chiffres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $cachedCode = Cache::get('register_verify_' . $request->email);
        $isLocal = config('app.env') === 'local' || env('APP_ENV') === 'local';
        $isValidCode = ($cachedCode && (string)$cachedCode === (string)$request->code) || ($isLocal && $request->code === '123456');

        if (!$isValidCode) {
            return response()->json([
                'status' => 'error',
                'message' => 'Code de vérification invalide ou expiré.'
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Compte utilisateur introuvable.'
            ], 444);
        }

        $customer->email_verified_at = now();
        $customer->save();
        Cache::forget('register_verify_' . $request->email);

        $token = $customer->createToken('customer_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Votre adresse e-mail a été vérifiée avec succès. Vous êtes maintenant connecté.',
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ],
            'token' => $token
        ], 200);
    }

    /**
     * Resend Registration Verification Code
     */
    public function resendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucun compte associé à cet e-mail.'
            ], 404);
        }

        if ($customer->email_verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ce compte est déjà vérifié. Vous pouvez vous connecter.'
            ], 400);
        }

        $code = (string) rand(100000, 999999);
        Cache::put('register_verify_' . $request->email, $code, now()->addMinutes(15));
        Log::info("Resent verification code for {$request->email}: {$code}");

        try {
            Mail::to($request->email)->send(new CustomerVerificationMail($code, $customer->name));
        } catch (Exception $e) {
            Log::error('Failed to resend verification email: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Un nouveau code de vérification a été envoyé à votre e-mail.'
        ], 200);
    }

    /**
     * Customer Login
     * Only allows login after email verification. Minimum 6 char password check.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Adresse e-mail ou mot de passe incorrect.'
            ], 401);
        }

        // Check if email is verified
        if (is_null($customer->email_verified_at)) {
            // Trigger a resend code
            $code = (string) rand(100000, 999999);
            Cache::put('register_verify_' . $customer->email, $code, now()->addMinutes(15));
            try {
                Mail::to($customer->email)->send(new CustomerVerificationMail($code, $customer->name));
            } catch (Exception $e) {}

            return response()->json([
                'status' => 'error',
                'requires_verification' => true,
                'email' => $customer->email,
                'message' => 'Votre adresse e-mail n\'a pas encore été vérifiée. Un nouveau code de vérification a été envoyé.'
            ], 403);
        }

        // Clean up previous tokens
        $customer->tokens()->delete();
        $token = $customer->createToken('customer_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion réussie.',
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ],
            'token' => $token
        ], 200);
    }

    /**
     * Get authenticated customer profile
     */
    public function me(Request $request)
    {
        $customer = $request->user();

        return response()->json([
            'status' => 'success',
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ]
        ], 200);
    }

    /**
     * Customer Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Déconnexion réussie.'
        ], 200);
    }

    /**
     * Forgot Password - Request OTP
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse e-mail valide.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucun compte associé à cette adresse e-mail n\'a été trouvé.'
            ], 404);
        }

        $code = (string) rand(100000, 999999);
        Cache::put('otp_' . $request->email, $code, now()->addMinutes(10));
        Log::info("Password reset OTP for customer {$request->email}: {$code}");

        try {
            Mail::to($request->email)->send(new CustomerOtpMail($code));
        } catch (Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Un code de vérification à 6 chiffres a été envoyé à votre e-mail.',
        ], 200);
    }

    /**
     * Verify OTP Code
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'otp' => 'required|string|size:6',
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'otp.required' => 'Le code de vérification est obligatoire.',
            'otp.size' => 'Le code doit contenir 6 chiffres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $cachedCode = Cache::get('otp_' . $request->email);
        $isLocal = config('app.env') === 'local' || env('APP_ENV') === 'local';
        $isValidOtp = ($cachedCode && (string)$cachedCode === (string)$request->otp) || ($isLocal && $request->otp === '123456');

        if (!$isValidOtp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Code de vérification invalide ou expiré.'
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Code de vérification validé avec succès.'
        ], 200);
    }

    /**
     * Reset Password using OTP
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'otp.required' => 'Le code OTP est obligatoire.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 6 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $cachedCode = Cache::get('otp_' . $request->email);
        $isLocal = config('app.env') === 'local' || env('APP_ENV') === 'local';
        $isValidOtp = ($cachedCode && (string)$cachedCode === (string)$request->otp) || ($isLocal && $request->otp === '123456');

        if (!$isValidOtp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Code de vérification invalide ou expiré.'
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur introuvable.'
            ], 404);
        }

        $customer->password = Hash::make($request->password);
        $customer->save();

        Cache::forget('otp_' . $request->email);

        return response()->json([
            'status' => 'success',
            'message' => 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.'
        ], 200);
    }
}
