<?php

use App\Models\System\PageRoute;
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
        Schema::create('page_route_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_route_id')->constrained()->cascadeOnDelete();
            $table->foreignId('page_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->string('locale');

            $table->timestamps();
        });

        foreach (PageRoute::query()->where('disable_auto_route', 0)->get() as $pageRoute) {
            DB::table('page_route_urls')->insert([
                'page_route_id' => $pageRoute->id,
                'slug' => $pageRoute->route_path,
                'locale' => $pageRoute->route_lang,
            ]);
        }
        foreach (\App\Models\System\Page::query()->whereNotNull(['page_route_id', 'slug'])->get() as $page) {
            DB::table('page_route_urls')->insert([
                'page_route_id' => $page->page_route_id,
                'page_id' => $page->id,
                'slug' => $page->slug,
                'locale' => $page->lang_locale,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_route_urls');
    }
};
