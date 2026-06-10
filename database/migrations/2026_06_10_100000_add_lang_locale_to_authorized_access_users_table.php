<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authorized_access_users', function (Blueprint $table) {
            $table->char('lang_locale', 16)->nullable()->after('login');
        });
    }

    public function down(): void
    {
        Schema::table('authorized_access_users', function (Blueprint $table) {
            $table->dropColumn('lang_locale');
        });
    }
};
