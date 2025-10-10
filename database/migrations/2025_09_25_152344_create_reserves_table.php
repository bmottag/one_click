<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();

            // Información básica del cliente
            $table->string('name');
            $table->string('email');
            $table->string('contact_number');

            // Fecha y hora de la reserva
            $table->datetime('reserve_date')->nullable();

            // Tipo de servicio
            $table->enum('service', [
                'residential',
                'residential_pack',
                'commercial',
                'longue_distance',
                'installations',
            ]);

            // Dirección de départ (salida)
            $table->string('no_rue_depart');
            $table->string('ville_depart');
            $table->string('code_postal_depart');
            $table->string('etage_depart')->nullable();
            $table->string('pieces_depart')->nullable();

            // Dirección de destination (llegada)
            $table->string('no_rue_destination')->nullable();
            $table->string('ville_destination')->nullable();
            $table->string('code_postal_destination')->nullable();
            $table->string('etage_destination')->nullable();

            // Tipo de instalación (solo si aplica)
            $table->enum('installation_type', ['residentiel', 'commercial'])->nullable();

            // Equipo asignado
            $table->enum('equipe', ['equipe_1', 'equipe_2', 'equipe_3'])->nullable();

            // Descripción adicional
            $table->text('event_description')->nullable();

            // Estado del pago o reserva (opcional, si luego integras pagos)
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'paid'])->default('pending')->nullable();

            // Campos relacionados con Stripe
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('currency', 10)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
