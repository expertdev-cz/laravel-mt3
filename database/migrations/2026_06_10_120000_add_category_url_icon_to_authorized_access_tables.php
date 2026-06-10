<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authorized_access_downloads', function (Blueprint $table) {
            $table->text('category')->nullable()->after('folder_id');
        });
    }

    public function down(): void
    {
        Schema::table('authorized_access_downloads', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
