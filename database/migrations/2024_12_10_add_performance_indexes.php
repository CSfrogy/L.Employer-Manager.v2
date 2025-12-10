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
        // Add indexes to tasks table for faster filtering
        Schema::table('tasks', function (Blueprint $table) {
            $table->index('status');
            $table->index('emp_id');
            $table->fullText(['title', 'content']); // For full-text search
        });

        // Add indexes to employees table for faster searching
        Schema::table('employees', function (Blueprint $table) {
            $table->index('email');
            $table->index('name');
            $table->index('phone');
            $table->index('city');
            $table->fullText(['name', 'email']); // For full-text search
        });

        // Add indexes to admins table
        Schema::table('admins', function (Blueprint $table) {
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['emp_id']);
            $table->dropFullText(['title', 'content']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['name']);
            $table->dropIndex(['phone']);
            $table->dropIndex(['city']);
            $table->dropFullText(['name', 'email']);
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });
    }
};
