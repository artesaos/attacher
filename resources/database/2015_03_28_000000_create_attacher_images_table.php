<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttacherImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('attacher_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('imageable_id')->index();
            $table->string('imageable_type')->index();
            $table->string('file_extension');
            $table->string("file_name")->nullable();
            $table->smallInteger("file_size", false, true)->nullable();
            $table->string("mime_type")->nullable();
            $table->timestamp('image_updated_at')->nullable();
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
        Schema::drop('attacher_images');
    }
}
