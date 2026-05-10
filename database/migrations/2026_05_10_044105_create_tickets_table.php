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
   
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        // ටිකට් එක අයිති පරිශීලකයා (User Relationship) [cite: 25]
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        $table->string('subject'); // [cite: 15]
        $table->text('description'); // [cite: 15]
        $table->string('category'); // [cite: 15]
        
        // Priority සහ Status සඳහා Enum භාවිතා කිරීම [cite: 15, 16]
        $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
        $table->enum('status', ['Open', 'In Progress', 'Resolved'])->default('Open');
        
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
