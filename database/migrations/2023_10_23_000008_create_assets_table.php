<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number')->nullable();
            $table->string('name')->nullable();
            $table->string('ip')->nullable();
            $table->longText('notes')->nullable();
            $table->datetime('date_service')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
