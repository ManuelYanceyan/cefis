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
        Schema::create('certificados', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->unsignedTinyInteger('tipo_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('evento_id');

            $table->timestamps();

            // foreign keys
            $table->foreign('tipo_id')
                  ->references('id')
                  ->on('tipos');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('evento_id')
                  ->references('id')
                  ->on('eventos'); // 👈 ESTO ERA EL ERROR
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
