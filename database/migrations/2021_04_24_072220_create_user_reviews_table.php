<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('company_id')->default(0);
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('order_id');
            $table->string('pluses', 500);
            $table->string('minuses', 500);
            $table->string('comment', 2000);
            $table->float('rating')->default('5');
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
        Schema::dropIfExists('user_reviews');
    }
}
