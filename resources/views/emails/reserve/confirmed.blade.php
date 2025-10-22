@php
\Carbon\Carbon::setLocale('fr');

$serviceText = match($reserve->service) {
    'residential' => 'Déménagement résidentiel',
    'residential_pack' => 'Déménagement résidentiel avec emballage et déballage',
    'commercial' => 'Déménagement commercial',
    'longue_distance' => 'Transport longue distance',
    'installations' => 'Installations spéciales',
    default => 'Service inconnu'
};

$adresseDepart = null;
if(!empty($reserve->no_rue_depart) || !empty($reserve->ville_depart)) {
    $adresseDepart = ($reserve->no_rue_depart ?? '') . ', ' . ($reserve->ville_depart ?? '') . ' ' . ($reserve->code_postal_depart ?? '');
}

$adresseDestination = null;
if(!empty($reserve->no_rue_destination) || !empty($reserve->ville_destination)) {
    $adresseDestination = ($reserve->no_rue_destination ?? '') . ', ' . ($reserve->ville_destination ?? '') . ' ' . ($reserve->code_postal_destination ?? '');
}

$equipeText = match($reserve->equipe ?? '') {
    'equipe_1' => 'Service conducteur seulement',
    'equipe_2' => 'Équipe de 2 personnes',
    'equipe_3' => 'Équipe de 3 personnes',
    'equipe_4' => '2 équipes de 3 personnes',
    default => 'Non assignée'
};
@endphp


@component('mail::message')

# Paiement reçu avec succès !

Bonjour **{{ $reserve->name }}**,

Votre paiement pour la réservation a été confirmé avec succès.


### 🧾 Détails du paiement:
- **Montant :** {{ number_format($reserve->amount_paid, 2, ',', ' ') }} {{ strtoupper($reserve->currency) }}
- **ID de transaction :** {{ $reserve->stripe_payment_intent }}
- **Date du paiement :** {{ optional($reserve->updated_at)->translatedFormat('d F Y à H:i') ?? now()->translatedFormat('d F Y à H:i') }}

### 📅 Détails de la réservation:
- **Date de réservation :** {{ \Carbon\Carbon::parse($reserve->reserve_date)->translatedFormat('d F Y à H:i') }}
- **Service :** {{ $serviceText }}
@if($adresseDepart)- **Adresse de départ:** {{ $adresseDepart }}@endif

@if($adresseDestination)- **Adresse de destination:** {{ $adresseDestination }}@endif

@if($equipeText)- **Équipe assignée:** {{ $equipeText }}@endif


Merci pour votre confiance.  
Nous vous contacterons si des informations supplémentaires sont nécessaires.

Cordialement,  
**L'équipe du support**

@endcomponent
