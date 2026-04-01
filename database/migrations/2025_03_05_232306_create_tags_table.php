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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->char('lang_locale',16);
            $table->tinyInteger('active')->default(0);
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('lang_locale')->references('locale')->on('languages');

            $table->unique(['slug', 'lang_locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
