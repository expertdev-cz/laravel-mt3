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
        /*
             ▪ Přidávání / Upravování / Odstraňování – náhledového obrázku //
            ▪ Přidávání / Upravování / Odstraňování – zástupného textu a titulku //
            ▪ Úprava nadpisu //
            ▪ Úprava krátkého popisu //
            ▪ Přidání / Upravování hlavního obsahu článku //
            ▪ Možnost vypnutí tlačítka pro proklik na podstránku //
            ▪ Autor – Autor se bude nastavovat buď ručně nebo automaticky podle toho, který admin je právě přihlášený
            ▪ Datum – Datum zveřejnění se bude nastavovat buď ručně pokud má být článek zveřejněn až v určitém datu nebo se automaticky nastaví dle aktuálního času
         * */

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->char('lang_locale',16);
            $table->unsignedBigInteger('user_id')->default(0)->nullable();
            $table->string('title')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->text('content')->nullable();
            $table->text('tags')->nullable();
            $table->dateTime('publish_time')->nullable();
            $table->integer('show_order')->nullable()->default(99);
            $table->text('another_articles')->nullable();
            $table->timestamps();

            $table->foreign('lang_locale')->references('locale')->on('languages');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unique(['slug', 'lang_locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('articles');
    }
};
