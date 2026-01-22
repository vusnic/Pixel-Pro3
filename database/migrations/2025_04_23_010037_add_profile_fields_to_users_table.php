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
            // Adicionar campos para perfil do usuário
            $table->string('country_code')->default('+1')->after('phone')->nullable();
            $table->string('company')->nullable()->after('country_code');
            $table->string('job_title')->nullable()->after('company');
            $table->text('bio')->nullable()->after('job_title');
            
            // Campo para verificação de telefone
            $table->boolean('phone_verified')->default(false)->after('email_verified_at');
            $table->timestamp('phone_verified_at')->nullable()->after('phone_verified');
            
            // Campos para controle da conclusão de perfil
            $table->boolean('profile_completed')->default(false)->after('bio');
            $table->integer('profile_completion_percentage')->default(0)->after('profile_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'country_code',
                'company',
                'job_title',
                'bio',
                'phone_verified',
                'phone_verified_at',
                'profile_completed',
                'profile_completion_percentage'
            ]);
        });
    }
};
