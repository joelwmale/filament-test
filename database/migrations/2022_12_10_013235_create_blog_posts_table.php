<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug');

            $table->string('featured_image')->nullable();

            $table->string('description')->nullable();

            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();

            $table->longText('content')->nullable();
            $table->longText('html')->nullable();

            $table->string('preview_secret')->nullable();

            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->dateTime('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
};
