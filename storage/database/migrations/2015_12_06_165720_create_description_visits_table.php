<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description_visits', function (Blueprint $table) {
            $table->bigIncrements('id_description_visits');
            $table->bigInteger('id_guest_description')->unsigned();
            $table->bigInteger('id_destination')->unsigned();
            $table->bigInteger('id_type_visit')->unsigned();
            $table->integer('id_motive')->unsigned();
            $table->string('motiveOther', 100)->null();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_guest_description')
                  ->references('id')->on('guests')
                  ->onDelete('cascade');
            $table->foreign('id_destination')
                  ->references('id')->on('destinations')
                  ->onDelete('cascade');
            $table->foreign('id_type_visit')
                  ->references('id')->on('type_visits')
                  ->onDelete('cascade');
            $table->foreign('id_motive')
                  ->references('id')->on('motive_visits')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('description_guests');
    }
}
