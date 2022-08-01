<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tues', function (Blueprint $table) {
            $table->id();

            //Foreign keys to ticket and user table
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ticket_id');


            //Ticket cost
            $table->float('cost');

            //Capacity of the ticket
            $table->integer('t_cap');

            //Current reached capacity
            $table->integer('c_cap');

            //Cost * 1.09
            $table->float('vat');

            //Total paid cost
            $table->float('to_cost');

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
        Schema::dropIfExists('tues');
    }
};
