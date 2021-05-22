<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('create_by');
            $table->unsignedBigInteger('category_id');
            $table->string('title', 30);
            $table->string('slug')->unique();
            $table->string('sub_title', 60)->unique();
            $table->string('description', 500);
            $table->string('image', 255);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->foreign('create_by')->on('users')->references('id')->cascadeOnDelete();
            $table->foreign('category_id')->on('categories')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
