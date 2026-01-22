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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->string('name');
            $table->string('client_name');
            $table->string('client_address');
            $table->string('service_type');
            $table->text('project_description');
            $table->date('start_date');
            $table->date('delivery_date');
            $table->decimal('total_value', 10, 2);
            $table->string('payment_method');
            $table->text('payment_terms');
            $table->string('warranty');
            $table->string('sales_rep_name');
            $table->json('form_data')->nullable()->comment('Dados completos do formulário');
            $table->string('file_path')->nullable();
            $table->string('file_type')->default('docx')->comment('Formato do arquivo: docx ou pdf');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('template_id')->references('id')->on('contract_templates');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
