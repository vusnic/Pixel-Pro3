<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('status');
            $table->boolean('is_spam')->default(false)->after('ip_address');
            $table->unsignedTinyInteger('spam_score')->default(0)->after('is_spam');
            $table->string('user_agent')->nullable()->after('spam_score');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'is_spam', 'spam_score', 'user_agent']);
        });
    }
};
