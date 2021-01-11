<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->default('');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('username')->nullable();
            $table->string('initials')->nullable();
            $table->string('internal_reference')->nullable()->unique();
            $table->text('sign')->nullable();
            $table->enum('gender', ['M','F','N'])->default('N');
            $table->date('birth_date')->nullable();
            $table->string('autologin_token')->nullable()->unique();
            $table->boolean('is_active')->default(0);
            $table->string('activation_token')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->enum('deleted_reason', ['rgpd', 'self'])->nullable();
            $table->foreignId('account_id')->nullable()->constrained('admin_accounts')->onDelete('cascade');
            $table->softDeletes();
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

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
