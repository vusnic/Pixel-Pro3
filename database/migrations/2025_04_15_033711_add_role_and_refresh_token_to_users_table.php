<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('salesperson')->after('email'); // admin, salesperson, developer
            $table->string('phone')->nullable()->after('role');
            $table->string('profile_photo')->nullable()->after('phone');
            $table->string('refresh_token', 100)->nullable()->after('remember_token');
            $table->timestamp('refresh_token_expiry')->nullable()->after('refresh_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'profile_photo',
                'refresh_token',
                'refresh_token_expiry'
            ]);
        });
    }
};
