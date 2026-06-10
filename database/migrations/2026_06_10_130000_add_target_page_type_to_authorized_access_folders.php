<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authorized_access_folders', function (Blueprint $table) {
            $table->string('target_page_type', 120)->nullable()->after('page_type');
        });
    }

    public function down(): void
    {
        Schema::table('authorized_access_folders', function (Blueprint $table) {
            $table->dropColumn('target_page_type');
        });
    }
};
