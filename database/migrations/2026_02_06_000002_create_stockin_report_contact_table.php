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
        Schema::create('stockin_report_contact', function (Blueprint $table) {
            $table->id();
            $table->string('cid');
            $table->date('stockin_date');
            $table->integer('qty');
            $table->timestamps();
            
            $table->foreign('cid')->references('cid')->on('stock_contact')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockin_report_contact');
    }
};
