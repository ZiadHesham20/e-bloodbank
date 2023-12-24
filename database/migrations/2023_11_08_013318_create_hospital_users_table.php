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
        Schema::create('hospital_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('blood_id');
            $table->integer('type'); // if type = 0 -> user request to donate blood -- if type = 1 -> hospital need blood -- if 2 => user need to pay blood
            $table->integer('count')->default(1);
            $table->boolean('done')->default(false);
            $table->timestamps();

            $table->foreign('hospital_id')
            ->references('id')
            ->on('hospitals')
            ->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('blood_id')
            ->references('id')
            ->on('bloods')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_users');
    }
};
