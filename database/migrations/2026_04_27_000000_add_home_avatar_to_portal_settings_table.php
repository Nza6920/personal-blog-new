<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portal_settings', function (Blueprint $table) {
            $table->string('home_avatar')->nullable()->after('home_bio');
        });
    }

    public function down(): void
    {
        Schema::table('portal_settings', function (Blueprint $table) {
            $table->dropColumn('home_avatar');
        });
    }
};
