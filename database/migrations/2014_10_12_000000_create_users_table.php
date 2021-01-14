<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->uuid('uuid')->default('');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('username')->nullable();
            $table->string('initials')->nullable();
            $table->string('internal_reference')->nullable()->unique();
            $table->text('sign')->nullable();
            $table->enum('gender', ['M', 'F', 'N'])->default('N');
            $table->date('birth_date')->nullable();
            $table->string('autologin_token')->nullable()->unique();
            $table->boolean('is_active')->default(0);
            $table->string('activation_token')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->enum('deleted_reason', ['rgpd', 'self'])->nullable();
            $table->foreignId('account_id')->nullable()->constrained('admin_accounts')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}