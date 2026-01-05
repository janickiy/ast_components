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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('preview');
            $table->text('text');
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->boolean('published')->default(1);
            $table->boolean('promotion')->default(0);
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->string('image_title', 80)->nullable();
            $table->string('image_alt', 80)->nullable();
            $table->string('seo_h1')->nullable();
            $table->string('seo_url_canonical')->nullable();
            $table->boolean('seo_sitemap')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
