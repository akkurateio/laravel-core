<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Webpatser\Uuid\Uuid;

class CreateAdminAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default('');
            $table->string('name');
            $table->string('slug');
            $table->string('email')->nullable()->unique();
            $table->string('website')->nullable();
            $table->string('internal_reference')->nullable();
            $table->boolean('is_active')->default(1);
            $table->json('params')->nullable();
            $table->foreignId('address_id')->nullable()->constrained('contact_addresses')->onDelete('cascade');
            $table->foreignId('phone_id')->nullable()->constrained('contact_phones')->onDelete('cascade');
            $table->foreignId('email_id')->nullable()->constrained('contact_emails')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('admin_accounts');
            $table->foreignId('country_id')->nullable()->constrained('admin_countries')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('admin_accounts');
    }
}
