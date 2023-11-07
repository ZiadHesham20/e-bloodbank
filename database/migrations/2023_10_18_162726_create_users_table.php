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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blood_id');
            $table->unsignedBigInteger('hospital_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('age');
            $table->string('phone')->unique();
            $table->boolean('gender');
            $table->string('location');
            $table->dateTime('donation_date');
            $table->integer('role')->default(0);  // 0 -> default user | 1 -> admin | 2 -> super admin.
            $table->timestamps();


            $table->foreign('blood_id')->constrained('users_blood_id_foreign')->references('id')->on('bloods')->onDelete('cascade');

            $table->foreign('hospital_id')
            ->constrained('users_hospital_id_foreign')
            ->references('id')
            ->on('hospitals')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
