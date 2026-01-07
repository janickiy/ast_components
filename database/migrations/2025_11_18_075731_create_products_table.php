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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->string('article', 50);
            $table->integer('n_number')->index('n_number');
            $table->string('thumbnail')->nullable();
            $table->string('origin')->nullable();
            $table->unsignedBigInteger('catalog_id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->decimal('price', 10)->nullable();
            $table->boolean('in_stock')->default(1);
            $table->boolean('under_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('slug')->unique();
            $table->string('seo_url_canonical')->nullable();
            $table->string('seo_h1')->nullable();
            $table->boolean('seo_sitemap')->default(1);
            $table->string('image_title')->nullable();
            $table->string('image_alt')->nullable();
            $table->timestamps();

            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
