<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('title',250);
            $table->string('code',250);
            $table->text('description');
            $table->smallInteger('category_id')->unsigned();
            $table->mediumInteger('price')->unsigned()->default(0);
            $table->tinyInteger('discount')->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->mediumInteger('quantity')->unsigned()->default(1);
            $table->text('additional_info')->nullable();
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
        Schema::dropIfExists('products');
    }
}
