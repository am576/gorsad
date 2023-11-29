<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->after('description', function ($table) {
                $table->string('type', 32)->default('');
                $table->date('date')->useCurrent();
                $table->unsignedSmallInteger('trees_count')->default(0);
                $table->unsignedInteger('price')->default(0);
            });

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['type','date','trees_count','price']);
        });
    }
}
