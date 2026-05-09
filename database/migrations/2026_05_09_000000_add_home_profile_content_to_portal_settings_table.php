<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portal_settings', function (Blueprint $table) {
            $table->string('home_profile_title')->nullable()->after('home_avatar');
            $table->text('home_profile_section')->nullable()->after('home_profile_title');
            $table->json('home_profile_tags')->nullable()->after('home_profile_section');
        });

        $homeConfig = require lang_path('zh_CN/home.php');
        $defaultValues = [
            'home_profile_title' => $homeConfig['profile']['title'],
            'home_profile_section' => $homeConfig['profile']['description'],
            'home_profile_tags' => json_encode($homeConfig['tech_stack']['items'], JSON_UNESCAPED_UNICODE),
            'updated_at' => now(),
        ];

        if (DB::table('portal_settings')->exists()) {
            DB::table('portal_settings')->update($defaultValues);

            return;
        }

        DB::table('portal_settings')->insert([
            ...$defaultValues,
            'created_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('portal_settings', function (Blueprint $table) {
            $table->dropColumn([
                'home_profile_title',
                'home_profile_section',
                'home_profile_tags',
            ]);
        });
    }
};
