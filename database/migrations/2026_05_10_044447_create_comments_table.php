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
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        
        // කුමන ටිකට් පතට අදාළ පිළිතුරක්ද යන්න (Relationship to Ticket)
        $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
        
        // පිළිතුර ලියන පුද්ගලයා (Relationship to User)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // පිළිතුරේ අන්තර්ගතය
        $table->text('body');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
