@extends('emails.layouts.master')

@section('title', 'Vérification de compte - ' . config('app.name', 'Afri-Techs'))

@section('content')
    <h2>Bienvenue chez Afri-Techs !</h2>

    <p>Bonjour <strong>{{ $name }}</strong>,</p>
    <p>Merci de vous être inscrit. Veuillez utiliser le code de vérification à 6 chiffres ci-dessous pour valider votre adresse e-mail et activer votre compte. Ce code est valide pendant 15 minutes.</p>

    <div style="text-align: center; margin: 30px 0;">
        <span style="font-size: 26px; font-weight: bold; font-family: monospace; padding: 15px 25px; background: #f0f7ff; border: 2px dashed #0c2847; border-radius: 8px; color: #0c2847; letter-spacing: 6px;">{{ $code }}</span>
    </div>

    <p style="font-size: 13px; color: #666;">Si vous n'avez pas créé de compte Afri-Techs, veuillez ignorer cet e-mail.</p>
@endsection
