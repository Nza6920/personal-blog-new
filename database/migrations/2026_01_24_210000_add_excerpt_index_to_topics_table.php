<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('CREATE INDEX topics_excerpt_index ON topics (excerpt(191))');
            return;
        }

        Schema::table('topics', function (Blueprint $table) {
            $table->index('excerpt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('DROP INDEX topics_excerpt_index ON topics');
            return;
        }

        Schema::table('topics', function (Blueprint $table) {
            $table->dropIndex('topics_excerpt_index');
        });
    }
};
