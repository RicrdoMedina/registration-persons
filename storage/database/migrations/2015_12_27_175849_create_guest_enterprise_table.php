<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestEnterpriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_guest', function (Blueprint $table) {
            $table->bigIncrements('id_enterprise_guest');
            $table->bigInteger('guest_id')->unique()->unsigned();
            $table->integer('enterprise_id')->unsigned();
            $table->string('enterpriseOther', 200)->null();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('guest_id')
                  ->references('id')->on('guests')
                  ->onDelete('cascade');
            $table->foreign('enterprise_id')
                  ->references('id_enterprise')->on('enterprises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enterprise_guest');
    }
}
