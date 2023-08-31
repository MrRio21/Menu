<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('eng_name');
            $table->string('phone');
            $table->string('image');
            $table->string('service_type');
            $table->string('whatsapp');
            $table->string('address')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('theme')->nullable();
            $table->date('opened_from')->nullable();
            $table->date('opened_to')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->string('url')->nullable();
            $table->string('tables')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
};
