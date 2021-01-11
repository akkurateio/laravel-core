<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_languages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default('');
            $table->string('label')->nullable();
            $table->string('locale');
            $table->string('locale_php');
            $table->integer('priority')->nullable()->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_default')->default(0);
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
        Schema::dropIfExists('admin_languages');
    }
}
