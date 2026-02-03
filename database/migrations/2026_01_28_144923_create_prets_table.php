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
        Schema::create('prets', function (Blueprint $table) {
            $table->id();
            $table->string('employe');
            $table->string('accessoire');
            $table->timestamp('date_pret')->useCurrent();
            $table->string('numero_serie')->nullable();
            $table->string('technicien');
            $table->dateTime('date_affectation');
            $table->boolean('est_rendu')->default(false); // Pour suivre le statut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prets');
    }
};
