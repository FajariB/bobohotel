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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('thumbnail');
            $table->text('address');
            $table->text('link_gmaps');
            $table->foreignId('city_id')->constrained()->onDetele('cascade');
            $table->foreignId('country_id')->constrained()->onDetele('cascade');
            $table->tinyInteger('star_rating'); //1-5
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
