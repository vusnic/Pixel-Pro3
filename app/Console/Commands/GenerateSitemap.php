<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Models\Portfolio;
use App\Models\Service;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        // Cria um array para armazenar URLs
        $urls = [];

        // Adiciona a página inicial
        $urls[] = [
            'loc' => URL::to('/'),
            'lastmod' => date('Y-m-d'),
            'priority' => '1.0',
            'changefreq' => 'daily'
        ];

        // Rotas estáticas principais
        $staticRoutes = [
            'about' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            'services' => ['priority' => '0.9', 'changefreq' => 'weekly'],
            'portfolio' => ['priority' => '0.9', 'changefreq' => 'weekly'],
            'contact' => ['priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        foreach ($staticRoutes as $route => $settings) {
            $urls[] = [
                'loc' => URL::to($route),
                'lastmod' => date('Y-m-d'),
                'priority' => $settings['priority'],
                'changefreq' => $settings['changefreq']
            ];
        }

        // Adiciona páginas de serviços dinâmicos
        try {
            $services = Service::where('status', 'published')->get();
            foreach ($services as $service) {
                $urls[] = [
                    'loc' => URL::to('services/' . $service->id),
                    'lastmod' => $service->updated_at->format('Y-m-d'),
                    'priority' => '0.8',
                    'changefreq' => 'weekly'
                ];
            }
        } catch (\Exception $e) {
            $this->warn('Não foi possível adicionar os serviços: ' . $e->getMessage());
        }

        // Adiciona páginas de portfólio dinâmicos
        try {
            $portfolioItems = Portfolio::where('status', 'published')->get();
            foreach ($portfolioItems as $item) {
                $urls[] = [
                    'loc' => URL::to('portfolio/' . $item->id),
                    'lastmod' => $item->updated_at->format('Y-m-d'),
                    'priority' => '0.7',
                    'changefreq' => 'monthly'
                ];
            }
        } catch (\Exception $e) {
            $this->warn('Não foi possível adicionar os itens de portfólio: ' . $e->getMessage());
        }

        // Gera o conteúdo XML do sitemap
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($urls as $url) {
            $xml .= '    <url>' . PHP_EOL;
            $xml .= '        <loc>' . $url['loc'] . '</loc>' . PHP_EOL;
            $xml .= '        <lastmod>' . $url['lastmod'] . '</lastmod>' . PHP_EOL;
            $xml .= '        <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
            $xml .= '        <priority>' . $url['priority'] . '</priority>' . PHP_EOL;
            $xml .= '    </url>' . PHP_EOL;
        }

        $xml .= '</urlset>';

        // Salva o arquivo
        try {
            File::put(public_path('sitemap.xml'), $xml);
            $this->info('Sitemap gerado com sucesso: ' . public_path('sitemap.xml'));
            $this->info('Total de URLs: ' . count($urls));
        } catch (\Exception $e) {
            $this->error('Falha ao salvar o sitemap: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
