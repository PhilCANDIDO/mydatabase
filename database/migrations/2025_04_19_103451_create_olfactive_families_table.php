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
        Schema::create('olfactive_families', function (Blueprint $table) {
            $table->id();
            $table->string('olfactive_family_name');
            $table->text('olfactive_family_desc')->nullable();
            $table->boolean('olfactive_family_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('olfactive_families');
    }
};