<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('car_id')
                ->nullable();
            $table->foreign('car_id')
                ->references('id')
                ->on('cars')
                ->onDelete('restrict');

            $table->unsignedBigInteger('user_id')
                ->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->dateTime('checkout_start_date');
            $table->dateTime('checkout_end_date');
            $table->dateTime('checkin_date')->nullable();
            $table->integer('total_duration')->nullable();
            $table->decimal('total_cost')->nullable();

            $table->string('created_by')->default('system');
            $table->string('updated_by')->nullable();

            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
