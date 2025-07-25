<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->string('tipo')->default('USER'); // o enum('tipo', ['ADMIN', 'USER'])->default('USER');
    });
}

public function down()
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->dropColumn('tipo');
    });
}};
