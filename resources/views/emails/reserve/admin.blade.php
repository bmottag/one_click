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

// Price messages mapping
$priceMessages = [
    "residential" => [
        "equipe_1" => "Vous avez sélectionné <strong>Service conducteur seulement</strong>. <br>Le tarif horaire est de <strong>100$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
        "equipe_2" => "Vous avez sélectionné <strong>Équipe de 2 personnes</strong>. <br>Le tarif horaire est de <strong>125$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
        "equipe_3" => "Vous avez sélectionné <strong>Équipe de 3 personnes</strong>. <br>Le tarif horaire est de <strong>150$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
        "equipe_4" => "Vous avez sélectionné <strong>2 équipes de 3 personnes</strong>. <br>Le tarif horaire est de <strong>360$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
    ],
    "residential_pack" => [
        "equipe_2" => "Vous avez sélectionné <strong>Équipe de 2 personnes</strong>. <br>Le tarif horaire est de <strong>125$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
        "equipe_3" => "Vous avez sélectionné <strong>Équipe de 3 personnes</strong>. <br>Le tarif horaire est de <strong>150$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
        "equipe_4" => "Vous avez sélectionné <strong>2 équipes de 3 personnes</strong>. <br>Le tarif horaire est de <strong>360$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
    ],
    "longue_distance" => [
        "equipe_1" => "Vous avez sélectionné <strong>Service conducteur seulement</strong>. <br>Le tarif horaire est de <strong>100$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
        "equipe_2" => "Vous avez sélectionné <strong>Équipe de 2 personnes</strong>. <br>Le tarif horaire est de <strong>125$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
        "equipe_3" => "Vous avez sélectionné <strong>Équipe de 3 personnes</strong>. <br>Le tarif horaire est de <strong>150$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
        "equipe_4" => "Vous avez sélectionné <strong>2 équipes de 3 personnes</strong>. <br>Le tarif horaire est de <strong>360$ / heure</strong>. <br>Le travail minimum est de 3 heures.",
    ],
    "commercial" => [
        "default" => "<strong>Équipe de 3 personnes.</strong> Tarif horaire : <strong>180$ / heure.</strong> <br>Minimum de 3 heures de travail. <br>Cette équipe dispose d'un camion de 22 pieds, et le prix final sera ajusté après une évaluation complète de vos besoins."
    ],
    "installations" => [
        "default" => "Le tarif horaire est de <strong>60$ / heure</strong>. <br>Le travail minimum est de 3 heures. <br>Ce tarif correspond à une équipe de deux personnes. Le prix final sera ajusté après avoir bien évalué vos besoins."
    ]
];

// Determine price message
$priceMessage = '';
if(in_array($reserve->service, ['commercial', 'installations'])) {
    $priceMessage = $priceMessages[$reserve->service]['default'];
} else {
    $priceMessage = $priceMessages[$reserve->service][$reserve->equipe ?? ''] ?? '';
}
@endphp

@component('mail::message')
# Nuevo pago recibido

Se ha confirmado un nuevo pago en el sistema.

### Detalles del pago:
- **Cliente: {{ $reserve->name }} ({{ $reserve->email }})**
- **Reserva ID:** {{ $reserve->id }}
- **Monto:** {{ number_format($reserve->amount_paid, 2) }} {{ $reserve->currency }}
- **Teléfono:** {{ $reserve->contact_number }}
- **Fecha de pago:** {{ $reserve->updated_at->format('d/m/Y H:i') }}

### Détails de la réservation:
- **Date de réservation :** {{ \Carbon\Carbon::parse($reserve->reserve_date)->translatedFormat('d F Y à H:i') }}
- **Service :** {{ $serviceText }}
@if($adresseDepart)- **Adresse de départ:** {{ $adresseDepart }}@endif

@if($adresseDestination)- **Adresse de destination:** {{ $adresseDestination }}@endif

@if($equipeText)- **Équipe assignée:** {{ $equipeText }}@endif

@if($reserve->event_description)- **Détails supplémentaires:** {{ $reserve->event_description }}@endif

### Tarif estimé
{!! $priceMessage !!}

@component('mail::button', ['url' => route('reserve')])
Ver en el panel
@endcomponent

Saludos,  
**Sistema de Reservas**
@endcomponent
