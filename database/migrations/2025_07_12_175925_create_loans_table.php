<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('amount');
            $table->float('interest_rate');
            $table->unsignedBigInteger('paid_amount')->default(0);
            $table->enum('status', ['정상', '연체', '완납'])->default('정상');

            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
