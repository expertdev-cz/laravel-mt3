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
        Schema::create('contact_request', function (Blueprint $table) {
            //main
            $table->id();
            $table->char('lang_locale',16);
            $table->string('page_url', 2048)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('content')->nullable();

            $table->timestamps();

            $table->foreign('lang_locale')->references('locale')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('contact_request');
    }
};
