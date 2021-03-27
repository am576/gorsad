<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_icons', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('attribute_id');
            $table->unsignedSmallInteger('attribute_value_id');
            $table->unsignedSmallInteger('image_id');
            $table->unsignedSmallInteger('iconset_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_icons');
    }
}
