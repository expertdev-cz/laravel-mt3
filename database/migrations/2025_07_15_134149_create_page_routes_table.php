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
        Schema::create('page_routes', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('route_path');
            $table->string('route_method');
            $table->string('route_action');
            $table->string('route_controller');
            $table->string('route_middleware')->nullable();
            $table->string('route_lang');
            $table->tinyInteger('is_active')->default(0);
            $table->boolean('disable_auto_route')->default(0);
            $table->string('template')->nullable();
            $table->foreignId('page_id')->nullable()->constrained('pages')->cascadeOnDelete();
            $table->enum('generated', ['auto', 'manual'])->default('manual');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('page_route_id')->references('id')->on('page_routes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['page_route_id']);
        });

        Schema::dropIfExists('page_routes');
    }
};
