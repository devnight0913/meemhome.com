<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('image_path')->nullable();
            $table->longText('name');
            $table->longText('description')->nullable();
            $table->integer('sort_order')->default(1);
            $table->string('status_id');
            $table->boolean('pos')->default(true);
            $table->boolean('website')->default(true);
            $table->boolean('android_app')->default(true);
            $table->boolean('ios_app')->default(true);
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('keywords')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
