<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('numFolder')->nullable();
            $table->string('status')->nullable();
            $table->integer('piece')->nullable();
            $table->integer('achat')->default(0);
            $table->integer('vente')->default(0);
            $table->integer('banque')->default(0);
            $table->integer('facture')->default(0);
            $table->integer('divers')->default(0);
            $table->date('dateArrive')->nullable();
            $table->date('dateScan')->nullable();
            $table->date('dateSaisi')->nullable();
            $table->date('dateIntegration')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folders');
    }
}
