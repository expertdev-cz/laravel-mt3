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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_route_id')->nullable();
            $table->string('url_type')->nullable();
            $table->string('slug')->nullable();
            $table->char('lang_locale',16);
            $table->string('type')->default('text');
            $table->string('title')->nullable();
            $table->text('title_media_json')->nullable();
            $table->text('content')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->text('seo')->nullable();
            $table->timestamps();

            $table->foreign('lang_locale')->references('locale')->on('languages');
            $table->index(['slug', 'lang_locale', 'page_route_id'], 'pages_slug_locale_route_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('pages');
    }
};
