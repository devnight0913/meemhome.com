<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->boolean('is_delivery');
            $table->string('address')->nullable();
            $table->float('delivery_fee', 12, 2);
            $table->float('subtotal', 12, 2);
            $table->float('discount', 12, 2);
            $table->float('total', 12, 2);
            $table->string('comment')->nullable();
            $table->foreignUuid('area_id')->nullable()->constrained();
            $table->foreignUuid('coupon_id')->nullable()->constrained();
            $table->foreignUuid('payment_method_id')->constrained();
            $table->foreignUuid('user_id')->nullable()->constrained();
            $table->foreignId('order_status_id')->constrained();
            $table->foreignId('order_source_id')->constrained();
            $table->softDeletes();
            $table->timestamp('delivered_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
