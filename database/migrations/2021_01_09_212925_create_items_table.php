<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained()->onDelete('cascade');
            $table->longText('image_path')->nullable();
            $table->longText('data_sheet_path')->nullable();
            $table->longText('name');
            $table->longText('description')->nullable();
            $table->float('price', 12, 2)->default(0);
            $table->float('discount')->default(0);
            $table->float('cost', 12, 2)->default(0);
            $table->integer('views')->default(0);
            $table->integer('in_stock')->default(0);
            $table->integer('warranty_period')->default(0);
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->boolean('track_stock')->default(false);
            $table->boolean('continue_selling_when_out_of_stock')->default(false);
            $table->integer('status_id');
            $table->boolean('pos')->default(true);
            $table->boolean('website')->default(true);
            $table->boolean('android_app')->default(true);
            $table->boolean('ios_app')->default(true);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
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
        Schema::dropIfExists('items');
    }
}
