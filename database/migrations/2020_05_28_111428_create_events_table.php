<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->timestampTz('starts_at')->default(now());
            $table->timestampTz('ends_at')->default(now());
            $table->string('occurrence')->nullable();
            $table->string('color')->nullable();
            $table->string('status');
            $table->boolean('all_day')->default(false);
            $table->unsignedBigInteger('event_id')->nullable();
            $table->schemalessAttributes('meta');
            $table->softDeletes();
            $table->timestamp('archived_at', 0)->nullable();
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
        Schema::dropIfExists('events');
    }
}
