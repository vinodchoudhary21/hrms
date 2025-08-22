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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('gender');
            $table->date('dob');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->text('address');
            $table->double('sallery', 10, 2)->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('leave')->nullable();
            $table->dateTime('leave_updated_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
