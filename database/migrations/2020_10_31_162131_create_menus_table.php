<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fk_parent');
            $table->string('title');
            $table->string('name');
            $table->boolean('is_heading')->default(false);
            $table->boolean('is_active')->default(false);
            $table->string('route');
            $table->string('class_name');
            $table->boolean('is_icon_class')->default(true);
            $table->string('icon');
            $table->integer('level_depth');
            $table->tinyInteger('active')->length(1);
            $table->timestamps();

        });
        DB::statement('ALTER TABLE `menus` CHANGE `class_name` `class_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;');
        DB::statement('ALTER TABLE `menus` CHANGE `icon` `icon` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;'); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
