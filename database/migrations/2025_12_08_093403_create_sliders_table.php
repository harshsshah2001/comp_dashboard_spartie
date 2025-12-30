<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();

            $table->string('sliderimage');
            $table->string('mobilesliderimage');

            $table->string('sliderheading')->nullable();
            $table->string('headingcolor')->nullable();

            $table->string('slidersubheading')->nullable();
            $table->string('subheadingcolor')->nullable();

            $table->string('sliderdescription')->nullable();
            $table->string('descriptioncolor')->nullable();

            $table->string('buttontext')->nullable();
            $table->string('buttonlink')->nullable();

            $table->string('buttonbgcolor')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
