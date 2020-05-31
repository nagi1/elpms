<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHillChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hill_charts', function (Blueprint $table) {
            $table->id();
            $table->morphs('chartable');
            $table->unsignedBigInteger('user_id');
            $table->boolean('enabled')->default(false);
            $table->json('svg')->nullable();
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
        Schema::dropIfExists('hill_charts');
    }
}
