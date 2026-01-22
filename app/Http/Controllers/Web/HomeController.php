<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    public function index()
    {
        // Obtém os projetos em destaque do portfolio
        $featuredPortfolios = \App\Models\Portfolio::where('status', 'published')
            ->where('featured', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        $posts = \App\Models\Post::where('published_at', '!=', null)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        return view('pages.home', [
            'featuredPortfolios' => $featuredPortfolios,
            'posts' => $posts
        ]);
    }

    public function testimonials()
    {
        return view('pages.testimonials');
    }

    public function contact()
    {
        return view('pages.contact');
    }
} 