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
        Schema::table('website_colors', function (Blueprint $table) {
            $table->string('secondary_text')->nullable()->after('secondary_color');
            $table->string('btn_primary')->nullable()->after('secondary_text');
            $table->string('btn_hover')->nullable()->after('btn_primary');
            $table->string('black')->nullable()->after('btn_hover');
            $table->string('white')->nullable()->after('black');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_colors', function (Blueprint $table) {
            $table->dropColumn(['secondary_text', 'btn_primary', 'btn_hover', 'black', 'white']);
        });
    }
};
