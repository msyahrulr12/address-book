<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_apis', function (Blueprint $table) {
            $table->id();
            $table->string('api_name', 255);
            $table->text('url');
            $table->text('headers');
            $table->text('queries');
            $table->dateTime('request_datetime');
            $table->longText('request_body');
            $table->dateTime('response_datetime');
            $table->longText('response_body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_apis');
    }
};
