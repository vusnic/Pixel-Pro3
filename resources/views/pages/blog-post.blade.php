@extends('layouts.app')

@section('title', $metaTitle ?? $post->title . ' - Pxp3 Blog')

@section('meta')
    <meta name="description" content="{{ $metaDescription ?? $post->excerpt }}">
    <meta name="keywords" content="{{ $post->tags->pluck('name')->implode(', ') }}">
    <meta name="author" content="{{ $post->user->name ?? 'Pxp3' }}">
    
    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:image" content="{{ $post->cover_image_url }}">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->excerpt }}">
    <meta name="twitter:image" content="{{ $post->cover_image_url }}">
@endsection

@section('content')
    <!-- Header with breadcrumb -->
    <div class="bg-dark pt-5 mt-5">
        <div class="container mt-5 px-vw-5">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="py-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-theme-secondary text-decoration-none">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('blog') }}" class="text-theme-secondary text-decoration-none">
                                    Blog
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('blog', ['category' => $post->category->slug]) }}" class="text-tertiary text-decoration-none">
                                    {{ ucfirst($post->category->name) }}
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Header -->
    <div class="bg-dark py-4">
        <div class="container px-vw-5">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <article class="post-header">
                        <!-- Category tag -->
                        <div class="mb-3">
                            <span class="badge bg-tertiary fw-bold fs-6 px-3 py-2">{{ ucfirst($post->category->name) }}</span>
                        </div>

                        <!-- Main title -->
                        <h1 class="display-4 fw-bold mb-4 lh-1">{{ $post->title }}</h1>

                        <!-- Subtitle/excerpt -->
                        <h2 class="fs-3 fw-normal text-theme-secondary mb-4 lh-base">{{ $post->excerpt }}</h2>

                        <!-- Author and publication info -->
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-4 text-theme-secondary">
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold">By {{ $post->user->name ?? 'Pxp3 Team' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt me-2" viewBox="0 0 16 16">
                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                                <span>Web Development Blog</span>
                            </div>
                        </div>

                        <!-- Date and reading time -->
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-4 text-theme-secondary fs-6">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3 me-2" viewBox="0 0 16 16">
                                    <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                                </svg>
                                <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                <span class="mx-2">{{ $post->published_at ? $post->published_at->format('g:i A') : $post->created_at->format('g:i A') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock me-2" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                </svg>
                                <span>{{ $post->reading_time }} min read</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye me-2" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                                <span>{{ number_format($post->views) }} views</span>
                            </div>
                        </div>

                        <!-- Tags -->
                        @if($post->tags->count() > 0)
                        <div class="mb-4">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <span class="badge bg-theme-primary border border-tertiary text-theme-secondary fs-7 px-2 py-1">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </article>
                </div>

                <!-- Sidebar with social sharing -->
                <div class="col-12 col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <!-- Social share buttons -->
                        <div class="bg-dark border border-secondary rounded-3 p-4 mb-4">
                            <h6 class="mb-3">Share this article:</h6>
                            <div class="d-flex align-items-center gap-3">
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="text-theme-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                    </svg>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="text-theme-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="text-theme-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Quick info -->
                        <div class="bg-dark border border-secondary rounded-3 p-4">
                            <h6 class="mb-3">Article Info</h6>
                            <div class="small text-theme-secondary">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Category:</span>
                                    <span class="text-tertiary">{{ ucfirst($post->category->name) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Published:</span>
                                    <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Reading time:</span>
                                    <span>{{ $post->reading_time }} min</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Views:</span>
                                    <span>{{ number_format($post->views) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Image -->
    @if($post->cover_image)
    <div class="bg-dark pb-4">
        <div class="container px-vw-5">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $post->cover_image) }}" 
                             class="img-fluid w-100 rounded-3" 
                             alt="{{ $post->title }}"
                             style="max-height: 500px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white p-3 rounded-bottom-3">
                            <small class="text-theme-secondary">{{ $post->title }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Post Content -->
    <div class="bg-dark py-5">
        <div class="container px-vw-5">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <article class="blog-post-content">
                        <div class="fs-5 lh-lg">
                            {!! $post->content !!}
                        </div>
                    </article>
                </div>

                <!-- Additional sidebar content could go here -->
                <div class="col-12 col-lg-4">
                    <!-- This space could be used for ads, newsletter signup, etc. -->
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation and Back to Blog -->
    <div class="bg-dark border-top border-secondary py-5">
        <div class="container px-vw-5">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('blog') }}" class="btn btn-outline-light d-inline-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                            </svg>
                            Back to Blog
                        </a>
                        
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-theme-secondary small">Share:</span>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" 
                               target="_blank" class="text-theme-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                </svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" class="text-theme-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                               target="_blank" class="text-theme-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                    <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Posts Section -->
    @if($relatedPosts && $relatedPosts->count() > 0)
    <div class="bg-dark py-5">
        <div class="container px-vw-5">
            <div class="row">
                <div class="col-12 mb-4">
                    <h2 class="h4 mb-4">
                        <span class="text-tertiary">More from</span> {{ ucfirst($post->category->name) }}
                    </h2>
                </div>
                
                @foreach($relatedPosts as $relatedPost)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <article class="related-post-card bg-dark border border-secondary rounded-3 overflow-hidden h-100">
                        <div class="position-relative">
                            @if($relatedPost->cover_image)
                                <img src="{{ asset('storage/' . $relatedPost->cover_image) }}" 
                                     class="img-fluid w-100" 
                                     style="height: 200px; object-fit: cover;" 
                                     alt="{{ $relatedPost->title }}">
                            @else
                                <img src="{{ asset('img/webp/abstract' . (($loop->index % 3) + 4) . '.webp') }}" 
                                     class="img-fluid w-100" 
                                     style="height: 200px; object-fit: cover;" 
                                     alt="{{ $relatedPost->title }}">
                            @endif
                            
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-tertiary fw-semibold">{{ ucfirst($relatedPost->category->name) }}</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="h6 mb-3 lh-base">
                                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-decoration-none text-theme-primary">
                                    {{ $relatedPost->title }}
                                </a>
                            </h3>
                            
                            <div class="d-flex align-items-center justify-content-between text-theme-secondary small">
                                <span>{{ $relatedPost->published_at ? $relatedPost->published_at->format('M d, Y') : $relatedPost->created_at->format('M d, Y') }}</span>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye me-1" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                    {{ number_format($relatedPost->views) }}
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <div class="bg-theme-primary py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-10 text-center">
                    <h2 class="display-5 text-tertiary">Ready to transform your digital business?</h2>
                    <p class="lead text-theme-secondary">
                        Contact us for a free consultation and discover how we can help your company grow in the digital environment.
                    </p>
                    <div class="col-12 text-center mt-5">
                        <a href="{{ route('contact') }}" class="btn btn-xl bg-tertiary d-inline-flex align-items-center">
                            <span>Request a quote</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
.blog-post-content {
    line-height: 1.8;
}

.blog-post-content h2,
.blog-post-content h3,
.blog-post-content h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.blog-post-content p {
    margin-bottom: 1.5rem;
}

.blog-post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
}

.blog-post-content blockquote {
    border-left: 4px solid var(--bs-tertiary);
    background-color: rgba(255, 255, 255, 0.05);
    padding: 1rem 1.5rem;
    margin: 1.5rem 0;
    border-radius: 0 8px 8px 0;
}

.blog-post-content code {
    background-color: rgba(255, 255, 255, 0.1);
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-size: 0.9em;
}

.blog-post-content pre {
    background-color: rgba(255, 255, 255, 0.05);
    padding: 1rem;
    border-radius: 8px;
    overflow-x: auto;
}

.related-post-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.related-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: var(--bs-secondary);
}

.breadcrumb-item.active {
    color: var(--bs-tertiary);
}

.post-header h1 {
    font-weight: 700;
    letter-spacing: -0.02em;
}

.post-header h2 {
    font-weight: 400;
    color: #9ca3af;
}

@media (max-width: 768px) {
    .post-header h1 {
        font-size: 2.5rem;
    }
    
    .post-header h2 {
        font-size: 1.25rem;
    }
}
</style> 