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
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();

            $table->string('phone')->unique()->nullable();
            $table->string('phone_dial_code')->nullable();
            $table->string('phone_iso2')->nullable();

            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_phone_iso2')->nullable();
            $table->string('contact_phone_dial_code')->nullable();

            $table->string('area_id')->nullable();
            $table->string('address')->nullable();

            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();

            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id');
            $table->longText('notes')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
    }
}
