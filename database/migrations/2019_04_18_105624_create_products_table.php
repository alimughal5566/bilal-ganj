<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bgshop_id');
            $table->string('name',100);
            $table->boolean('is_visible')->nullable()->default(1);
            $table->text('description');
            $table->integer('quantity');
            $table->enum('size',['Small','Medium','Large'])->default('Small');
            $table->enum('condition',['New','Used'])->default('New');
            $table->enum('in_stock',['Yes','No'])->default('Yes');
            $table->double('ucp');
            $table->enum('is_feature',['Yes','No'])->default('No');
            $table->integer('model')->nullable();
            $table->double('discount')->nullable();
            $table->integer('buy_product')->nullable();
            $table->integer('get_product')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('bgshop_id')->references('id')->on('bg_shops')->onDelete('cascade')->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
