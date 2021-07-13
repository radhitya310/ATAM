<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // // untuk menyambungkan foreign key ke table lain
        // foreign key + constraint untuk table users
        Schema::table('users', function (Blueprint $table) {
            // // $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('role_id')->references('role_id')->on('roles')->nullOnDelete()->cascadeOnUpdate();
        });

        // foreign key + constraint untuk table transactions
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('service_id')->references('service_id')->on('services')->cascadeOnDelete()->cascadeOnUpdate();
        });

        // foreign key + constraint untuk table pets
        Schema::table('pets', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('species_id')->references('species_id')->on('species')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('breed_id')->references('breed_id')->on('breeds')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('sex_id')->references('sex_id')->on('sexs')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('age_id')->references('age_id')->on('ages')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('source_id')->references('source_id')->on('sources')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('vaccine_id')->references('vaccine_id')->on('vaccines')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('sterilization_id')->references('sterilization_id')->on('sterilizations')->nullOnDelete()->cascadeOnUpdate();
        });

        // foreign key + constraint untuk table pets
        Schema::table('adopt_submissions', function (Blueprint $table) {
            $table->foreign('pet_id')->references('pet_id')->on('pets')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id_adopter')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_pet_shops');
    }
}
