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
        Schema::create('salle_equipements', function (Blueprint $table) {
            $table->id();
            $table->string('nom_salle'); // ex: Salle 102, Labo Info
            $table->string('materiel');  // ex: Vidéoprojecteur, PC Fixe
            $table->string('numero_serie')->nullable();
            $table->string('etat')->default('Fonctionnel'); // Fonctionnel, En panne, À remplacer
            $table->string('technicien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salle_equipements');
    }
};
