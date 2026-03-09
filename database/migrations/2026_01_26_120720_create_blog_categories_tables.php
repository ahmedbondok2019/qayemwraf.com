<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('view_index')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('lang_id');
            $table->timestamps();
        });

        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('blog_category_id')->nullable()->constrained()->onDelete('set null');
                $table->integer('view_index')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('blogs', function (Blueprint $table) {
                $table->foreignId('blog_category_id')->nullable()->after('id')->constrained()->onDelete('set null');
            });
        }

        if (!Schema::hasTable('blog_translations')) {
            Schema::create('blog_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('blog_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->string('slug');
                $table->string('image')->nullable();
                $table->text('tags')->nullable();
                $table->longText('description')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->string('Author')->nullable();
                $table->string('lang_id');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_translations');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_category_translations');
        Schema::dropIfExists('blog_categories');
    }
};
