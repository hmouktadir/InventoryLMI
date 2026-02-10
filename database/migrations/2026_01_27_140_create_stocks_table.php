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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('designation'); // Nom de l'article (ex: Câble HDMI 2m)
            $table->string('categorie');   // (ex: Vidéo, Périphérique, Réseau)
            $table->integer('quantite')->default(0);
            $table->integer('seuil_alerte')->default(5); // Pour avertir quand le stock est bas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
