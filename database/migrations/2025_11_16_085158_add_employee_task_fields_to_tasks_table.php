<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('progress')->default(0)->after('status');
            $table->integer('priority')->default(3)->after('progress'); // 1=High, 2=Medium, 3=Normal, 4=Low, 5=Very Low
            $table->text('notes')->nullable()->after('priority');
            $table->json('extension_request')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['progress', 'priority', 'notes', 'extension_request']);
        });
    }
};