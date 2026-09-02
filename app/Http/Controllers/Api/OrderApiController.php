<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\QuoteRequestMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    /**
     * Place a new quote/order request and send admin email notification
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255',
            'phone' => 'required|string|min:6|max:30|regex:/^[0-9\-\+\s\(\)]+$/',
            'company' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'address' => 'required|string|min:3|max:500',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:30',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable',
            'items.*.name' => 'nullable|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'nullable|numeric|min:0',
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse e-mail valide.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.regex' => 'Le format du numéro de téléphone est invalide.',
            'country.required' => 'Le pays est obligatoire.',
            'address.required' => 'L\'adresse est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
            'items.required' => 'Votre panier ne contient aucun article.',
            'items.min' => 'Veuillez ajouter au moins un article pour effectuer une demande.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Structure address JSON
            $addressJson = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company ?? '',
                'country' => $request->country ?? 'Guinée',
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state ?? '',
                'zip' => $request->zip ?? '',
            ];

            // Create primary Order record
            $order = Order::create([
                'order_number' => 'PENDING-' . microtime(true) . '-' . rand(1000, 9999),
                'customer_name' => trim($request->first_name . ' ' . $request->last_name),
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'subtotal' => 0,
                'discount_total' => 0,
                'tax_total' => 0,
                'shipping_total' => 0,
                'total' => 0,
                'currency' => $request->currency ?? 'EUR',
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'pending',
                'billing_address' => $addressJson,
                'shipping_address' => $addressJson,
                'notes' => $request->notes ?? 'From Website',
                'placed_at' => now(),
                'country' => $request->country ?? 'Guinée',
            ]);

            // Generate sequential Order/Quote number based on table ID
            $order->order_number = 'AFRI-Q-' . str_pad((string) $order->id, 5, '0', STR_PAD_LEFT);
            $order->save();

            $subtotal = 0;

            foreach ($request->items as $itemData) {
                $productIdentifier = $itemData['product_id'] ?? null;
                $product = null;

                if ($productIdentifier) {
                    $product = Product::where('id', $productIdentifier)
                        ->orWhere('slug', $productIdentifier)
                        ->first();
                }

                $qty = (int) $itemData['qty'];
                $price = (float) ($itemData['price'] ?? 0);
                $itemSubtotal = $price * $qty;

                $title = $itemData['name'] ?? ($product ? $product->title : 'Product');
                $sku = $itemData['sku'] ?? null;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product ? $product->id : null,
                    'variant_id' => $itemData['variant_id'] ?? null,
                    'title' => $title,
                    'sku' => $sku,
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                    'tax' => 0,
                    'total' => $itemSubtotal,
                ]);

                $subtotal += $itemSubtotal;
            }

            $order->subtotal = $subtotal;
            $order->total = $subtotal;
            $order->save();

            DB::commit();

            // Send admin notification email
            try {
                $order->load('items');
                $adminEmail = env('MAIL_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS', 'admin@afritechs.com'));
                Mail::to($adminEmail)->send(new QuoteRequestMail($order));
            } catch (Exception $mailEx) {
                Log::warning('Quote request email failed: ' . $mailEx->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Quote request submitted successfully.',
                'order' => $order
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order creation error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create quote request. ' . $e->getMessage()
            ], 500);
        }
    }
}
