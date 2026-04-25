<?php

use App\Actions\Topics\CalculateEstimatedReadTime;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->unsignedInteger('estimated_read_time')->nullable()->after('cover_img');
        });

        $calculator = new CalculateEstimatedReadTime;

        DB::table('topics')
            ->select(['id', 'body', 'body_type'])
            ->orderBy('id')
            ->chunkById(100, function ($topics) use ($calculator) {
                foreach ($topics as $topic) {
                    DB::table('topics')
                        ->where('id', $topic->id)
                        ->update([
                            'estimated_read_time' => $calculator->handle($topic->body, $topic->body_type),
                        ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('estimated_read_time');
        });
    }
};
