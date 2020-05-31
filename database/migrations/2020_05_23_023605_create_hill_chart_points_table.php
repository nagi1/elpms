<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHillChartPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hill_chart_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hill_chart_id');
            $table->unsignedBigInteger('model_id')->nullable();
            $table->boolean('enabled')->default(false);
            $table->string('color')->default('#000');
            $table->text('link')->nullable();
            $table->integer('size')->default(10);
            $table->decimal('x', 18, 14)->default(0.00);
            $table->decimal('y', 18, 14)->default(0.00);
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
        Schema::dropIfExists('hill_chart_points');
    }
}
