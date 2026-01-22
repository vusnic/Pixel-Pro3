<?php

namespace App\Console\Commands;

use App\Models\ContractTemplate;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\File;

class ImportContractTemplate extends Command
{
    protected $signature = 'contracts:import-template';
    protected $description = 'Imports the default contract template to the system';

    public function handle()
    {
        $this->info('Importing default contract template...');

        $adminUser = User::where('role', 'admin')->first();
        
        if (!$adminUser) {
            $this->error('Admin user not found. Creating a template with null user.');
        }

        // Criar o arquivo DOCX do modelo de contrato
        $this->createContractDocxTemplate();

        // Pegar o caminho do arquivo
        $templatePath = 'contracts/templates/master_service_agreement_template.docx';
        $fullPath = storage_path('app/' . $templatePath);

        // Verificar se o arquivo já foi criado
        if (!Storage::exists($templatePath)) {
            $this->error('Failed to create the template file! The file does not exist in the expected path.');
            return 1;
        }

        // Verificar se o modelo já existe no banco de dados
        $existingTemplate = ContractTemplate::where('name', 'Master Service Agreement')->first();

        if ($existingTemplate) {
            $this->info('A template with the name "Master Service Agreement" already exists. Updating...');
            
            // Atualizar o modelo existente
            $existingTemplate->update([
                'description' => 'Default service contract template',
                'file_path' => $templatePath,
                'placeholders' => [
                    'ClientName',
                    'ClientAddress',
                    'ServiceType',
                    'ProjectDescription',
                    'StartDate',
                    'DeliveryDate',
                    'TotalValue',
                    'PaymentMethod',
                    'PaymentTerms',
                    'Warranty',
                    'SalesRepName'
                ],
                'is_active' => true,
                'created_by' => $adminUser->id ?? null,
            ]);
            
            $this->info('Contract template updated successfully!');
        } else {
            // Criar o modelo no banco de dados
            ContractTemplate::create([
                'name' => 'Master Service Agreement',
                'description' => 'Default service contract template',
                'file_path' => $templatePath,
                'placeholders' => [
                    'ClientName',
                    'ClientAddress',
                    'ServiceType',
                    'ProjectDescription',
                    'StartDate',
                    'DeliveryDate',
                    'TotalValue',
                    'PaymentMethod',
                    'PaymentTerms',
                    'Warranty',
                    'SalesRepName'
                ],
                'is_active' => true,
                'created_by' => $adminUser->id ?? null,
            ]);
            
            $this->info('Contract template imported successfully!');
        }

        return 0;
    }

    /**
     * Cria um arquivo DOCX com o modelo de contrato
     */
    protected function createContractDocxTemplate()
    {
        // Caminho de destino do arquivo
        $templatePath = storage_path('app/contracts/templates/master_service_agreement_template.docx');
        
        // Verificar se o diretório existe, se não, criar
        $directory = dirname($templatePath);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Criar um novo documento
        $phpWord = new PhpWord();
        
        // Adicionar estilos padrão
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);
        
        // Adicionar seção com layout de página
        $section = $phpWord->addSection([
            'marginLeft' => 1200,
            'marginRight' => 1200,
            'marginTop' => 1200,
            'marginBottom' => 1200,
        ]);
        
        // Estilos para cabeçalhos
        $headerStyle = [
            'bold' => true,
            'size' => 14,
            'spaceAfter' => 120,
        ];
        
        $subheaderStyle = [
            'bold' => true,
            'size' => 12,
            'spaceAfter' => 120,
        ];
        
        // Tabela de cabeçalho
        $table = $section->addTable();
        $table->addRow();
        $cell1 = $table->addCell(4500);
        $cell1->addText('[LOGO AQUI]');
        
        $cell2 = $table->addCell(4500);
        $cell2->addText('PIXEL PRO 3 LLC', ['bold' => true, 'align' => 'right']);
        $cell2->addText('5550 Wild Rose Lane, Suite 400', ['align' => 'right']);
        $cell2->addText('West Des Moines, IA 50266', ['align' => 'right']);
        $cell2->addText('EIN: 99-2598141', ['align' => 'right']);
        $cell2->addText('contact@pixelpro3.com', ['align' => 'right']);
        $cell2->addText('(833) 412-3327', ['align' => 'right']);
        
        // Linha horizontal
        $section->addText('----------------------------------------------------------------------------------------------------------------');
        
        // Título do contrato
        $section->addText('MASTER SERVICE AGREEMENT', ['bold' => true, 'size' => 16, 'allCaps' => true, 'align' => 'center']);
        $section->addTextBreak(1);
        
        // Introdução
        $section->addText('This Master Service Agreement ("Agreement") is made and entered into on {StartDate}, by and between:');
        $section->addTextBreak(1);
        
        $section->addText('Pixel Pro 3 LLC, a limited liability company organized and existing under the laws of the State of Iowa, United States of America, with its principal place of business at 5550 Wild Rose Lane, Suite 400, West Des Moines, IA 50266, EIN 99-2598141, herein referred to as the "Provider",');
        $section->addTextBreak(1);
        
        $section->addText('and');
        $section->addTextBreak(1);
        
        $section->addText('{ClientName}, located at {ClientAddress}, herein referred to as the "Client".');
        $section->addTextBreak(1);
        
        // Seções do contrato
        $section->addText('1. PURPOSE AND SCOPE', $headerStyle);
        $section->addText('This Agreement governs the delivery of the services described below, in accordance with the applicable provisions of the Uniform Commercial Code (UCC), the Iowa Code, and federal laws governing commercial transactions in the United States.');
        $section->addTextBreak(1);
        
        $section->addText('- Service Type: {ServiceType}');
        $section->addText('- Project Summary: {ProjectDescription}');
        $section->addTextBreak(1);
        
        $section->addText('This Agreement may also cover additional services as mutually agreed in writing and documented via addendums.');
        $section->addTextBreak(1);
        
        $section->addText('2. TERM AND DURATION', $headerStyle);
        $section->addText('- Effective Date: {StartDate}');
        $section->addText('- Completion Date: {DeliveryDate}');
        $section->addText('- The term may be extended by mutual written agreement.');
        $section->addTextBreak(1);
        
        $section->addText('3. FEES AND PAYMENT', $headerStyle);
        $section->addText('- Total Project Value: ${TotalValue}');
        $section->addText('- Payment Method: {PaymentMethod}');
        $section->addText('- Payment Terms: {PaymentTerms}');
        $section->addTextBreak(1);
        
        $section->addText('All fees shall be paid in U.S. Dollars. Invoices are due within the agreed term, and subject to a 2% late fee per month in case of delay, as permitted under Iowa Code § 535.2(3)(a).');
        $section->addTextBreak(1);
        
        $section->addText('4. WARRANTIES AND SUPPORT', $headerStyle);
        $section->addText('Provider warrants that the services shall be performed in a professional and workmanlike manner in accordance with industry standards and Iowa Code Chapter 554, and agrees to offer a warranty of {Warranty} for the work delivered, starting on the date of handover.');
        $section->addTextBreak(1);
        
        $section->addText('5. INTELLECTUAL PROPERTY RIGHTS', $headerStyle);
        $section->addText('Unless otherwise agreed in writing:');
        $section->addText('- All final deliverables shall become the sole property of the Client upon full payment.');
        $section->addText('- The Provider retains rights to non-exclusive background tools or libraries, unless otherwise agreed.');
        $section->addText('- This clause complies with U.S. Copyright Law - Title 17, U.S. Code.');
        $section->addTextBreak(1);
        
        $section->addText('6. CONFIDENTIALITY', $headerStyle);
        $section->addText('Both parties agree to maintain strict confidentiality of all business, technical, and financial information disclosed, pursuant to Iowa Code § 550 and common law principles of trade secrecy.');
        $section->addTextBreak(1);
        
        $section->addText('7. TERMINATION', $headerStyle);
        $section->addText('Either party may terminate this agreement with 7 days\' written notice, in accordance with Iowa Code § 554.2610, provided that:');
        $section->addText('- Work completed up to termination must be compensated');
        $section->addText('- Deliverables up to that point shall be delivered to the Client');
        $section->addTextBreak(1);
        
        $section->addText('8. INDEMNIFICATION AND LIMITATION OF LIABILITY', $headerStyle);
        $section->addText('Each party agrees to indemnify and hold the other harmless against third-party claims arising from gross negligence or willful misconduct.');
        $section->addText('The Provider\'s total liability shall not exceed the total amount paid under this Agreement, in accordance with UCC § 2-719.');
        $section->addTextBreak(1);
        
        $section->addText('9. GOVERNING LAW AND DISPUTE RESOLUTION', $headerStyle);
        $section->addText('This Agreement shall be governed by and construed under the laws of the State of Iowa, including but not limited to:');
        $section->addText('- Iowa Code - Title XIII (Commerce)');
        $section->addText('- Uniform Commercial Code as adopted by Iowa');
        $section->addText('- Any dispute arising from this Agreement shall be subject to the exclusive jurisdiction of the Polk County District Court, or, if applicable, the U.S. District Court for the Southern District of Iowa.');
        $section->addTextBreak(1);
        
        $section->addText('10. ENTIRE AGREEMENT', $headerStyle);
        $section->addText('This Agreement, including attachments and addendums, constitutes the entire understanding between the parties and supersedes all previous agreements, whether oral or written.');
        $section->addTextBreak(1);
        
        $section->addText('11. SIGNATURES', $headerStyle);
        $section->addTextBreak(1);
        
        $section->addText('IN WITNESS WHEREOF, the parties hereto have executed this Agreement on the date first written above.');
        $section->addTextBreak(2);
        
        $section->addText('Client:');
        $section->addText('Name: {ClientName}');
        $section->addText('Signature: _________________________');
        $section->addText('Date: _________________________');
        $section->addTextBreak(2);
        
        $section->addText('Sales Representative (Pixel Pro 3):');
        $section->addText('Name: {SalesRepName}');
        $section->addText('Signature: _________________________');
        $section->addText('Date: _________________________');
        $section->addTextBreak(2);
        
        $section->addText('Executive Representative (Pixel Pro 3 LLC):');
        $section->addText('Name: Vinicius Assad de Magalhães');
        $section->addText('Title: CEO');
        $section->addText('Signature: _________________________');
        $section->addText('Date: _________________________');
        
        // Salvar o documento
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($templatePath);
        
        $this->info('DOCX template file created successfully: ' . $templatePath);
    }
} 