<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrapeVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grape_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version')->required();
            $table->bigInteger('parent_id')->nullable()->default(null);
            $table->string('slug')->required()->unique();
            $table->timestamps();
        });

        Schema::create('grape_versions_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('grape_version_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('grape_version_id')->references('id')->on('grape_versions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grape_versions');
        Schema::dropIfExists('grape_versions_products');

    }
}
