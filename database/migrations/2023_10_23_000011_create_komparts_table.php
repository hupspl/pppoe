<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompartsTable extends Migration
{
    public function up()
    {
        Schema::create('komparts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('ip_user')->unique();
            $table->string('mac')->nullable();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->date('datasoftu')->nullable();
            $table->longText('notka')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
