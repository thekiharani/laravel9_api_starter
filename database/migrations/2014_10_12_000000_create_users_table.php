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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('surname')->nullable();
            $table->string('other_names')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->nullable()->unique();
            $table->string('password');
            $table->timestamp('account_verified_at')->nullable();
            $table->string('security_code')->nullable();
            $table->json('meta')->nullable();
            $table->uuid('author_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('author_id')->change()->constrained('users')
                ->cascadeOnUpdate()->nullOnDelete();
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
};
