<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_preferences', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('preferenceable_id');
			$table->string('preferenceable_type');
            $table->enum('target', ['both', 'b2c', 'b2b'])->nullable()->default('both');
            $table->integer('pagination')->nullable()->default(config('api.pagination'));
            if (config('laravel-i18n')) {
                $table->foreignId('language_id')->nullable()->constrained('admin_languages');
            }
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
        Schema::dropIfExists('admin_preferences');
    }
}

