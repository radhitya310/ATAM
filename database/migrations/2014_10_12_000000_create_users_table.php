<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // $table->id(); //PK
            // $table->bigIncrements('id')->unsigned(); //PK
            $table->integer('id')->autoIncrement()->unsigned(); //PK
            $table->integer('role_id')->nullable()->default(2)->unsigned(); //FK
            $table->string('email')->unique();
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->unique();
            $table->string('address');
            $table->float('longitude');
            $table->float('latitude');
            $table->string('user_photo')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('adopt_submissions', function (Blueprint $table) {
            $table->integer('adopt_submission_id')->autoIncrement()->unsigned(); //PK
            $table->integer('pet_id')->nullable()->unsigned(); //FK
            $table->integer('user_id_adopter')->nullable()->unsigned(); //FK
            $table->string('status')->default('Waiting for Adopt');
            $table->string('question_1');
            $table->string('question_2');
            $table->string('question_3');
            $table->string('question_4');
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('ages', function (Blueprint $table) {
            $table->integer('age_id')->autoIncrement()->unsigned(); //PK
            $table->string('age_category');
            $table->timestamps();
        });

        Schema::create('breeds', function (Blueprint $table) {
            $table->integer('breed_id')->autoIncrement()->unsigned(); //PK
            $table->string('breed_category');
            $table->timestamps();
        });

        Schema::create('pets', function (Blueprint $table) {
            // $table->bigIncrements('pet_id')->unsigned(); //PK
            $table->integer('pet_id')->autoIncrement()->unsigned(); //PK
            $table->integer('user_id')->nullable()->unsigned(); //FK
            $table->integer('species_id')->nullable()->unsigned(); //FK
            $table->integer('breed_id')->nullable()->unsigned(); //FK
            $table->integer('sex_id')->nullable()->unsigned(); //FK
            $table->integer('age_id')->nullable()->unsigned(); //FK
            $table->integer('source_id')->nullable()->unsigned(); //FK
            $table->integer('vaccine_id')->nullable()->unsigned(); //FK
            $table->integer('sterilization_id')->nullable()->unsigned(); //FK
            $table->string('status')->default('Request for Adopt');
            $table->string('pet_name');
            $table->string('pet_description');
            $table->string('pet_image')->nullable();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->integer('role_id')->autoIncrement()->unsigned(); //PK
            // $table->bigIncrements('role_id')->unsigned(); //PK
            $table->string('role_name');
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            // $table->bigIncrements('pet_id')->unsigned(); //PK
            $table->integer('service_id')->autoIncrement()->unsigned(); //PK
            $table->integer('user_id')->nullable()->unsigned(); //FK
            $table->string('service_type');
            $table->string('service_name')->nullable();
            $table->mediumInteger('service_price')->unsigned();
            $table->string('service_post_status')->default('enabled');
            $table->string('doctor_name')->nullable();
            $table->timestamps();
        });

        Schema::create('sexs', function (Blueprint $table) {
            $table->integer('sex_id')->autoIncrement()->unsigned(); //PK
            $table->string('sex_name');
            $table->timestamps();
        });

        Schema::create('sources', function (Blueprint $table) {
            $table->integer('source_id')->autoIncrement()->unsigned(); //PK
            $table->string('source_name');
            $table->timestamps();
        });

        Schema::create('species', function (Blueprint $table) {
            $table->integer('species_id')->autoIncrement()->unsigned(); //PK
            $table->string('species_name');
            $table->timestamps();
        });

        Schema::create('sterilizations', function (Blueprint $table) {
            $table->integer('sterilization_id')->autoIncrement()->unsigned(); //PK
            $table->string('sterilization_status');
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->integer('transaction_id')->autoIncrement()->unsigned(); //PK
            $table->integer('user_id')->nullable()->unsigned(); //FK
            $table->integer('service_id')->nullable()->unsigned(); //FK
            $table->string('transaction_date');
            $table->string('transaction_name');
            $table->smallInteger('quantity')->unsigned();
            $table->integer('total_price')->unsigned();
            $table->string('time');
            $table->string('status')->nullable();
            $table->string('reservation_code')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('vaccines', function (Blueprint $table) {
            $table->integer('vaccine_id')->autoIncrement()->unsigned(); //PK
            $table->string('vaccine_status');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('adopt_submissions');
        Schema::dropIfExists('ages');
        Schema::dropIfExists('breeds');
        Schema::dropIfExists('pets');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('services');
        Schema::dropIfExists('sexs');
        Schema::dropIfExists('sources');
        Schema::dropIfExists('species');
        Schema::dropIfExists('sterilizations');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('vaccines');
    }
}
