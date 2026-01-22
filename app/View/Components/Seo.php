<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Seo extends Component
{
    public $title;
    public $description;
    public $keywords;
    public $image;
    public $type;
    public $url;
    
    /**
     * Create a new component instance.
     *
     * @param  string  $title
     * @param  string  $description
     * @param  string  $keywords
     * @param  string  $image
     * @param  string  $type
     * @param  string  $url
     * @return void
     */
    public function __construct(
        $title = null,
        $description = null,
        $keywords = null,
        $image = null,
        $type = 'website',
        $url = null
    ) {
        $this->title = $title ?: 'Pxp3 - Web Design & Development Agency';
        $this->description = $description ?: 'Pxp3 is a professional web design and development agency specializing in modern, responsive websites and applications.';
        $this->keywords = $keywords ?: 'web design, development, ui/ux, responsive, mobile-friendly';
        $this->image = $image ?: asset('img/pixelpro3logo-trans.png');
        $this->type = $type;
        $this->url = $url ?: url()->current();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.seo');
    }
} 