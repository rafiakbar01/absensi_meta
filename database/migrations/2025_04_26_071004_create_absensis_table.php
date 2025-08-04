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
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('email');
        $table->string('minat');
        $table->string('no_telpon'); // Changed from int() to string() since phone numbers are better stored as strings
        $table->date('tanggal');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('absensis');
}
};
