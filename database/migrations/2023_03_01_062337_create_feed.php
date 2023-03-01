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
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->string('news_id');
            $table->text('title');
            $table->text('abstract');
            $table->text('url');
            $table->text('image')->default(null);
            $table->tinyInteger('is_send')->default('0');
            $table->string('publishedDateTime',50);
            $table->timestamps();
            $table->unique(array('news_id'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
