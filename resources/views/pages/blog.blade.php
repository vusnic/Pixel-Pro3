@extends('layouts.app')

@section('title', 'Pxp3 - Blog')

@section('content')
    <div class="w-100 overflow-hidden position-relative bg-theme-primary text-theme-primary" data-aos="fade">
        <div class="position-absolute w-100 h-100 bg-theme-primary opacity-75 top-0 start-0"></div>
        <div class="container py-vh-3 position-relative mt-5 px-vw-5 text-center">
            <div class="row d-flex align-items-center justify-content-center py-4">
                <div class="col-12 col-xl-10">
                    <h1 class="display-4 mt-3 mb-3 lh-1 fw-bold text-tertiary">Blog</h1>
                </div>
                <div class="col-12 col-xl-8">
                    <p class="lead text-theme-secondary mb-4">Stay updated with the latest insights and news about web development, design, and technology.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter -->
    @if($categories->count() > 0)
    <div class="bg-dark py-vh-2">
        <div class="container px-vw-5">
            <div class="row">
                <div class="col-12">
                    <div class="blog-filters text-center">
                        <a href="{{ route('blog') }}" class="btn btn-outline-light mb-2 {{ !request()->has('category') ? 'active' : '' }}">All</a>
                        @foreach($categories as $category)
                            <a href="{{ route('blog', ['category' => $category->slug]) }}"
                               class="btn btn-outline-light mb-2 {{ request('category') == $category->slug ? 'active' : '' }}">
                                {{ ucfirst($category->name) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-dark py-vh-4" data-aos="fade">
        <div class="container px-vw-5">
            @if($posts->count() > 0)
                <div class="row g-4">
                    @foreach($posts as $index => $post)
                        @if($index == 0)
                            <!-- Featured Post - Main Highlight -->
                            <div class="col-12 col-lg-8" data-aos="fade-up">
                                <article class="featured-post position-relative overflow-hidden rounded-4 bg-dark border border-secondary">
                                    <div class="position-relative">
                                        @if($post->cover_image)
                                            <img src="{{ asset('storage/' . $post->cover_image) }}" 
                                                 class="img-fluid w-100" 
                                                 style="height: 400px; object-fit: cover;" 
                                                 alt="{{ $post->title }}">
                                        @else
                                            <img src="{{ asset('img/webp/abstract' . (($index % 3) + 4) . '.webp') }}" 
                                                 class="img-fluid w-100" 
                                                 style="height: 400px; object-fit: cover;" 
                                                 alt="{{ $post->title }}">
                                        @endif
                                        
                                        <!-- Gradient overlay -->
                                        <div class="position-absolute bottom-0 start-0 w-100 h-100" 
                                             style="background: linear-gradient(transparent 0%, rgba(0,0,0,0.8) 100%);"></div>
                                        
                                        <!-- Content overlay -->
                                        <div class="position-absolute bottom-0 start-0 w-100 p-4">
                                            <div class="mb-2">
                                                <span class="badge bg-tertiary fs-7 fw-bold">{{ ucfirst($post->category->name) }}</span>
                                                <span class="text-light ms-2 fs-7">
                                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                            <h2 class="text-white mb-3 fw-bold lh-sm">
                                                <a href="{{ route('blog.show', $post->slug) }}" class="text-light text-decoration-none">
                                                    {{ $post->title }}
                                                </a>
                                            </h2>
                                            <p class="text-light mb-3 fs-6">{{ Str::limit($post->excerpt, 120) }}</p>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    @foreach($post->tags->take(3) as $tag)
                                                        <span class="badge bg-dark bg-opacity-50 text-light fs-8">#{{ $tag->name }}</span>
                                                    @endforeach
                                                </div>
                                                <div class="d-flex align-items-center text-light fs-7">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye me-1" viewBox="0 0 16 16">
                                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                    </svg>
                                                    {{ number_format($post->views) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            
                            <!-- Sidebar with secondary posts -->
                            <div class="col-12 col-lg-4">
                                <div class="row g-3">
                                    @foreach($posts->slice(1, 3) as $sidePost)
                                        <div class="col-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                            <article class="side-post bg-dark border border-secondary rounded-3 overflow-hidden">
                                                <div class="row g-0">
                                                    <div class="col-4">
                                                        @if($sidePost->cover_image)
                                                            <img src="{{ asset('storage/' . $sidePost->cover_image) }}" 
                                                                 class="img-fluid w-100 h-100" 
                                                                 style="object-fit: cover; height: 100px;" 
                                                                 alt="{{ $sidePost->title }}">
                                                        @else
                                                            <img src="{{ asset('img/webp/abstract' . (($loop->index % 3) + 4) . '.webp') }}" 
                                                                 class="img-fluid w-100 h-100" 
                                                                 style="object-fit: cover; height: 100px;" 
                                                                 alt="{{ $sidePost->title }}">
                                                        @endif
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="p-3">
                                                            <span class="badge bg-tertiary fs-8 mb-2">{{ ucfirst($sidePost->category->name) }}</span>
                                                            <h6 class="mb-2 lh-sm">
                                                                <a href="{{ route('blog.show', $sidePost->slug) }}" class="text-decoration-none text-theme-primary">
                                                                    {{ Str::limit($sidePost->title, 50) }}
                                                                </a>
                                                            </h6>
                                                            <small class="text-theme-secondary fs-8">
                                                                {{ $sidePost->published_at ? $sidePost->published_at->format('M d, Y') : $sidePost->created_at->format('M d, Y') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <!-- Rest of the posts in grid -->
                @if($posts->count() > 4)
                    <div class="row g-4 mt-4">
                        @foreach($posts->slice(4) as $post)
                            <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <article class="blog-card bg-dark border border-secondary rounded-3 overflow-hidden h-100 position-relative">
                                    <div class="position-relative">
                                        @if($post->cover_image)
                                            <img src="{{ asset('storage/' . $post->cover_image) }}" 
                                                 class="img-fluid w-100" 
                                                 style="height: 200px; object-fit: cover;" 
                                                 alt="{{ $post->title }}">
                                        @else
                                            <img src="{{ asset('img/webp/abstract' . (($loop->index % 3) + 4) . '.webp') }}" 
                                                 class="img-fluid w-100" 
                                                 style="height: 200px; object-fit: cover;" 
                                                 alt="{{ $post->title }}">
                                        @endif
                                        
                                        <!-- Category badge overlay -->
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-tertiary fs-8">{{ ucfirst($post->category->name) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 d-flex flex-column h-100">
                                        <div class="mb-3">
                                            <h5 class="mb-2 lh-sm">
                                                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-theme-primary">
                                                    {{ $post->title }}
                                                </a>
                                            </h5>
                                            <p class="text-theme-secondary fs-6 mb-3">{{ Str::limit($post->excerpt, 100) }}</p>
                                        </div>
                                        
                                        <div class="mt-auto">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <small class="text-theme-secondary fs-7">
                                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                                </small>
                                                <div class="d-flex align-items-center text-theme-secondary fs-7">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye me-1" viewBox="0 0 16 16">
                                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                    </svg>
                                                    {{ number_format($post->views) }}
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex flex-wrap gap-1 mb-3">
                                                @foreach($post->tags->take(3) as $tag)
                                                    <span class="badge bg-dark border border-tertiary fs-8">#{{ $tag->name }}</span>
                                                @endforeach
                                            </div>
                                            
                                            <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-outline-light">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="row">
                    <div class="col-12 text-center" data-aos="fade-up">
                        <div class="alert bg-dark text-theme-secondary p-5 rounded-4 border border-secondary">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-journal-text text-tertiary" viewBox="0 0 16 16">
                                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                                </svg>
                            </div>
                            <h3 class="fw-lighter mb-3">No blog posts found</h3>
                            <p class="mb-0">We're currently updating our blog. Check back soon for new content!</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            @if($posts->count() > 0 && $posts->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    <nav aria-label="Blog pagination">
                        <div class="d-flex gap-2">
                            {{-- Previous Page Link --}}
                            @if ($posts->onFirstPage())
                                <span class="btn btn-outline-secondary disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $posts->previousPageUrl() }}" class="btn btn-outline-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </a>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                @if ($page == $posts->currentPage())
                                    <span class="btn btn-light active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="btn btn-outline-light">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($posts->hasMorePages())
                                <a href="{{ $posts->nextPageUrl() }}" class="btn btn-outline-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </a>
                            @else
                                <span class="btn btn-outline-secondary disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </nav>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

<style>
.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.featured-post {
    transition: transform 0.3s ease;
}

.featured-post:hover {
    transform: translateY(-3px);
}

.side-post {
    transition: transform 0.3s ease;
}

.side-post:hover {
    transform: translateX(5px);
}

.fs-7 {
    font-size: 0.875rem;
}

.fs-8 {
    font-size: 0.75rem;
}

.blog-filters .btn.active {
    background-color: #fff;
    color: #000;
    border-color: #fff;
}
</style> 