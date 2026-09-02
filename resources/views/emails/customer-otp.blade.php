@extends('emails.layouts.master')

@section('title', 'Réinitialisation de mot de passe - ' . config('app.name', 'Afri-Techs'))

@section('content')
    <h2>Réinitialisation du mot de passe</h2>

    <p>Bonjour,</p>
    <p>Vous avez demandé la réinitialisation de votre mot de passe Afri-Techs. Veuillez utiliser le code à 6 chiffres ci-dessous pour effectuer cette modification. Ce code expire dans 10 minutes.</p>

    <div style="text-align: center; margin: 30px 0;">
        <span style="font-size: 26px; font-weight: bold; font-family: monospace; padding: 15px 25px; background: #f0f7ff; border: 2px dashed #0c2847; border-radius: 8px; color: #0c2847; letter-spacing: 6px;">{{ $code }}</span>
    </div>

    <p style="font-size: 13px; color: #666;">Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet e-mail en toute sécurité.</p>
@endsection
