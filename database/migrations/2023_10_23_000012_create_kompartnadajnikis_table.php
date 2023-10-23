<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompartnadajnikisTable extends Migration
{
    public function up()
    {
        Schema::create('kompartnadajnikis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('ip_user')->unique();
            $table->string('mac')->nullable();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->date('date_soft')->nullable();
            $table->longText('notka')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
