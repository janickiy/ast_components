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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('phone', 50);
            $table->string('email', 150);
            $table->text('message')->nullable();
            $table->string('nomenclature');
            $table->integer('count');
            $table->tinyInteger('unit')->default(0);
            $table->string('ip', 50)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('attach')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
