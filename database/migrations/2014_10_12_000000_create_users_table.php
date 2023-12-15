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
            $table->string('name');
            $table->unsignedBigInteger('blood_id');
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('age');
            $table->string('phone')->unique();
            $table->boolean('gender')->default(true); // true main male .. false main female
            $table->string('location');
            $table->dateTime('donation_date')->nullable();
            $table->boolean('donatable')->default(0); // 0 -> disable to donate  -- 1 -> able to donate
            $table->integer('role')->default(0);  // 0 -> default user | 1 -> admin | 2 -> super admin.
            $table->integer('points')->default(0);
            $table->boolean('block')->default(false);
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
