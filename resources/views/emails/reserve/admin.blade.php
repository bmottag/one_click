@component('mail::message')
# Nuevo pago recibido

Se ha confirmado un nuevo pago en el sistema.

### Detalles:
- **Reserva ID:** {{ $reserve->id }}
- **Cliente:** {{ $reserve->name }} ({{ $reserve->email }})
- **Monto:** {{ number_format($reserve->amount_paid, 2) }} {{ $reserve->currency }}
- **Teléfono:** {{ $reserve->contact_number }}
- **Fecha:** {{ $reserve->updated_at->format('d/m/Y H:i') }}

@if(!empty($reserve->service_name))
- **Servicio:** {{ $reserve->service_name }}
@endif

@component('mail::button', ['url' => route('reserve')])
Ver en el panel
@endcomponent

Saludos,  
**Sistema de Reservas**
@endcomponent
