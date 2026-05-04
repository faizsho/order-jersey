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
        Schema::table('teams', function (Blueprint $table) {
            $table->string('desain_player')->nullable()->after('status_order');
            $table->string('desain_kiper')->nullable()->after('desain_player');
        });
    }
    /**
     * Reverse the migrations.
     */
public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(['desain_player', 'desain_kiper']);
        });
    }
};
