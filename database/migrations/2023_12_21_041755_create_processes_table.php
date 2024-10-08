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
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->unsigned()->index();
            $table->foreign('userId')->references('id')->on('users');
            $table->string('processId');
            $table->string('applicationDate');
            $table->string('pendingPayment')->nullable();
            $table->longText('processTitle')->nullable();
            $table->longText('processStatus')->nullable();
            $table->char('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
