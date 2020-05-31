<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->morphs('changeable');
            $table->string('type')->nullable();
            $table->string('content');
            $table->schemalessAttributes('meta');
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
        Schema::dropIfExists('change_events');
    }
}
