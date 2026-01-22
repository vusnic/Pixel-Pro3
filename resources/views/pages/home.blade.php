@extends('layouts.app')

@section('title', 'Pxp3 - Home')

@section('styles')
    <style>
        .country-select {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: none;
            height: 60px;
            padding-right: 25px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffffff' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            cursor: pointer;
        }

        .country-select option {
            background-color: #1a1a1a;
            color: #fff;
            padding: 10px;
        }

        .country-select option:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .country-select:focus {
            outline: none;
            box-shadow: none;
            border-color: transparent;
        }

        /* Testimonials Styles */
        .testimonial-card {
            transition: transform 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        .testimonial-card .card {
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .testimonial-card .card:hover {
            border-color: var(--bs-tertiary);
        }

        .testimonial-card .bi-star-fill {
            font-size: 1.2rem;
        }

        .testimonial-card img {
            border: 2px solid var(--bs-tertiary);
        }

        /* Testimonials Section Styles */
        .testimonials-section {
            padding: 150px 0;
        }

        .testimonial-card {
            transition: transform 0.3s ease;
            border-radius: 150px;
            overflow: hidden;
        }

        .testimonial-card .card-body {
            border-radius: 150px;
            box-shadow: 0 75px 226px rgba(17, 17, 17, 0.5);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        .testimonial-card .card {
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .testimonial-card .card:hover {
            border-color: var(--bs-tertiary);
        }

        .testimonial-card .bi-star-fill {
            font-size: 1.2rem;
        }

        .testimonial-card img {
            border: 2px solid var(--bs-tertiary);
        }

        .testimonial-title {
            font-size: 20px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .testimonial-pink {
            background: linear-gradient(45deg, #E91E63, #E91E63);
            position: relative;
            overflow: hidden;
        }

        .testimonial-pink::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0.1;
        }

        .testimonial-text {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 40px;
        }

        .testimonial-author-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
        }

        .testimonial-author-name {
            font-size: 24px;
            font-weight: 300;
            margin-bottom: 5px;
        }

        .testimonial-author-position {
            font-size: 16px;
            opacity: 0.75;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://unpkg.com/imask"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phone');
            const countrySelect = document.querySelector('select[name="country_code"]');

            // Configuração inicial da máscara
            let mask = IMask(phoneInput, {
                mask: '(000) 000-0000',
                lazy: false,
                placeholderChar: '_'
            });

            // Função para atualizar a máscara baseada no código do país
            function updateMask(countryCode) {
                switch (countryCode) {
                    case '+55': // Brasil
                        mask.updateOptions({
                            mask: '(00) 00000-0000',
                            lazy: false,
                            placeholderChar: '_'
                        });
                        break;
                    case '+1': // EUA/Canadá
                        mask.updateOptions({
                            mask: '(000) 000-0000',
                            lazy: false,
                            placeholderChar: '_'
                        });
                        break;
                    case '+44': // Reino Unido
                        mask.updateOptions({
                            mask: '0000 000 0000',
                            lazy: false,
                            placeholderChar: '_'
                        });
                        break;
                    default:
                        mask.updateOptions({
                            mask: '(000) 000-0000',
                            lazy: false,
                            placeholderChar: '_'
                        });
                }
                mask.value = ''; // Limpa o campo quando mudar o código do país
            }

            // Atualiza a máscara quando o código do país muda
            countrySelect.addEventListener('change', function() {
                updateMask(this.value);
            });

            // Atualiza a máscara inicial baseada no código do país selecionado
            updateMask(countrySelect.value);
        });
    </script>
@endsection

@section('content')
    <div class="w-100 overflow-hidden position-relative bg-theme-primary text-theme-primary" data-aos="fade">
        <div id="particles-js" class="position-absolute w-100 h-100 top-0 start-0" style="z-index: 5;"></div>
        <div class="position-absolute w-100 h-100 bg-theme-primary opacity-75 top-0 start-0"
            style="z-index: 2; pointer-events: none;"></div>
        <div class="container py-vh-4 position-relative mt-5 px-vw-5 text-center" style="z-index: 10;">
            <div class="row d-flex align-items-center justify-content-center py-vh-5">
                <div class="col-12 col-xl-10">
                    <h1 class="display-huge mt-3 mb-3 lh-1 fw-bold">We Turn Ideas into</h1>
                    <h1 class="display-huge mt-3 mb-5 lh-1 fw-bold text-tertiary">High-Impact Digital Experiences</h1>
                </div>
                <div class="col-12 col-xl-10">
                    <p class="lead text-theme-secondary mb-4">At Pxp3, we blend cutting-edge design, agile development, and
                        data-driven marketing to create digital solutions that help businesses thrive. From concept to
                        execution, we ensure your brand stands out and converts in the digital world.</p>
                </div>
                <div class="col-12 col-xl-11">
                    <form id="leadForm" class="row g-3 g-md-4 justify-content-center" action="javascript:void(0);">
                        @csrf
                        <input type="hidden" name="source" value="homepage">
                        <div class="col-12 col-xl-3 text-start">
                            <label for="name" class="form-label small text-theme-secondary mb-1">Full Name</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name"
                                placeholder="Your full name" style="min-width: 200px;">
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>
                        <div class="col-12 col-xl-3 text-start">
                            <label for="email" class="form-label small text-theme-secondary mb-1">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                placeholder="Your business email" style="min-width: 200px;">
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>
                        <div class="col-12 col-xl-4 text-start">
                            <label for="phone" class="form-label small text-theme-secondary mb-1">Phone Number</label>
                            <div class="input-group" style="min-width: 300px;">
                                <select class="form-select form-select-lg country-select" name="country_code"
                                    style="max-width: 80px; min-width: 80px;">
                                    <!-- Americas -->
                                    <optgroup label="Americas">
                                        <option value="+1" selected>+1</option>
                                        <option value="+52">+52</option>
                                        <option value="+55">+55</option>
                                        <option value="+54">+54</option>
                                        <option value="+56">+56</option>
                                        <option value="+57">+57</option>
                                    </optgroup>

                                    <!-- Europe -->
                                    <optgroup label="Europe">
                                        <option value="+44">+44</option>
                                        <option value="+34">+34</option>
                                        <option value="+33">+33</option>
                                        <option value="+351">+351</option>
                                        <option value="+49">+49</option>
                                        <option value="+39">+39</option>
                                        <option value="+31">+31</option>
                                    </optgroup>

                                    <!-- Asia -->
                                    <optgroup label="Asia">
                                        <option value="+81">+81</option>
                                        <option value="+86">+86</option>
                                        <option value="+82">+82</option>
                                        <option value="+91">+91</option>
                                    </optgroup>
                                </select>
                                <input type="tel" class="form-control form-control-lg" id="phone" name="phone"
                                    placeholder="(555) 555-5555">
                            </div>
                            <div class="invalid-feedback" id="phone-error"></div>
                        </div>
                        <div class="col-12 col-xl-2">
                            <div class="d-grid h-100 mt-3 mt-xl-0">
                                <button type="submit"
                                    class="btn btn-lg bg-tertiary d-inline-flex align-items-center justify-content-center w-100"
                                    style="height: 60px; margin-top: 34px; min-width: 150px; font-size: 1rem;">
                                    <span>Get Started</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="alert alert-success mt-3 d-none" id="form-success">
                        Thank you for your interest! We will contact you shortly.
                    </div>
                </div>
                <div class="col-12 mt-5">
                    <div class="partners-slider d-flex justify-content-center align-items-center py-2 mt-3">
                        <div class="partner-logo">
                            <img src="{{ asset('img/certificados/google-partner.png') }}" alt="Google Partner"
                                class="img-fluid">
                        </div>
                        <div class="partner-logo">
                            <img src="{{ asset('img/certificados/meta-partner.png') }}" alt="Amazon Ads Verified Partner"
                                class="img-fluid">
                        </div>
                        <div class="partner-logo">
                            <img src="{{ asset('img/certificados/adobe-partner.png') }}" alt="Meta Business Partner"
                                class="img-fluid">
                        </div>
                        <div class="partner-logo">
                            <img src="{{ asset('img/certificados/hubsport-partner.png') }}" alt="Google Partner"
                                class="img-fluid">
                        </div>
                        <div class="partner-logo">
                            <img src="{{ asset('img/certificados/rdstation-partner.png') }}"
                                alt="Amazon Ads Verified Partner" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 position-relative bg-theme-primary text-theme-primary bg-cover d-flex align-items-center">
        <div class="container-fluid px-vw-5">
            <div class="position-absolute w-100 h-50 bg-dark bottom-0 start-0"></div>
            <div class="row d-flex align-items-center position-relative justify-content-center px-0 g-5"
                style="max-width: 1200px; margin: 0 auto;">
                <div class="col-12 col-lg-6 order-1">
                    <div style="max-width: 600px; margin: 0 auto;">
                        <img src="{{ asset('img/section-1/section-1-left.png') }}" alt="abstract image"
                            class="img-fluid position-relative rounded-5" data-aos="fade-up">
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-3 order-2">
                    <div style="max-width: 300px; margin: 0 auto;">
                        <img src="{{ asset('img/section-1/section-1-middle.png') }}" alt="abstract image"
                            class="img-fluid position-relative rounded-5 px-0" data-aos="fade-up"
                            data-aos-duration="2000">
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-3 order-3">
                    <div style="max-width: 300px; margin: 0 auto;">
                        <img src="{{ asset('img/section-1/section-1-right.png') }}" alt="abstract image"
                            class="img-fluid position-relative rounded-5 px-0" data-aos="fade-up"
                            data-aos-duration="3000">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-dark">
        <div class="container px-vw-5 py-vh-5">
            <div class="row d-flex align-items-center">
                <div class="col-12 col-lg-7 text-lg-end" data-aos="fade-right">
                    <span class="h5 text-theme-secondary fw-lighter">What we do</span>
                    <h2 class="display-4">We provide tailored digital solutions to <span class="text-tertiary">accelerate
                            your business growth.</span></h2>
                </div>
                <div class="col-12 col-lg-5" data-aos="fade-left">
                    <h3 class="pt-5">Web Design & Development</h3>
                    <p class="text-theme-secondary">We craft modern, high-performing websites that are visually stunning
                        and optimized for conversions.</p>
                    <a href="{{ route('services') }}"
                        class="link-fancy link-fancy-light d-inline-flex align-items-center">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-arrow-right-circle ms-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </a>
                    <h3 class="border-top border-secondary pt-5 mt-5">Data-Driven Digital Marketing</h3>
                    <p class="text-theme-secondary">We drive targeted traffic and maximize engagement through SEO, paid
                        advertising, and social media strategies.</p>
                    <a href="{{ route('services') }}"
                        class="link-fancy link-fancy-light d-inline-flex align-items-center">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-arrow-right-circle ms-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-theme-primary py-vh-3">
        <div class="container px-vw-5 py-vh-5 mb-5">
            <div class="row d-flex align-items-center text-center text-lg-start">
                <div class="col-12 col-lg-5 me-lg-5 px-5 px-lg-0 mb-4 mb-lg-0">
                    <div class="position-relative">
                        <img class="img-fluid rounded-5 shadow" src="{{ asset('img/about-3.jpg') }}"
                            alt="about us image" loading="lazy" data-aos="zoom-in-right"
                            style="object-fit: cover; width: 100%; max-height: 700px;">
                    </div>
                </div>
                <div class="col-12 col-lg-6 rounded-5 px-4 py-4 mt-5 mt-lg-0" data-aos="fade">
                    <h2 class="display-4 text-theme-secondary mb-4 text-tertiary">About Us</h2>
                    <span class="h5 text-theme-secondary fw-lighter"
                        style="font-family: 'Inter', sans-serif; font-size: 20px; line-height: 1.8;">
                        At Pxp3, we don't just offer digital services—we craft tailored solutions that help businesses grow,
                        engage, and convert. Our team of strategists, developers, and marketers is driven by one
                        mission:<br><br>
                        🚀 Turning ideas into measurable success.<br><br>
                        With years of experience in SEO, web development, and digital marketing, we've helped businesses of
                        all sizes increase visibility, boost engagement, and drive revenue. Whether you're a startup or an
                        established brand, we have the expertise to elevate your online presence.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-dark py-vh-3">
        <div class="container px-vw-5">
            <div class="row d-flex align-items-center">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <span class="h5 text-theme-secondary fw-lighter">Our Portfolio</span>
                    <h2 class="display-4">Recent <span class="text-tertiary">Projects</span></h2>
                </div>
            </div>

            <div class="portfolio-slider position-relative" data-aos="fade-up">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($featuredPortfolios as $portfolio)
                            <div class="swiper-slide">
                                <div class="card bg-transparent card-hover h-100">
                                    <div class="bg-theme-primary rounded-5 p-0 h-100 d-flex flex-column">
                                        <div class="portfolio-img-container">
                                            @if ($portfolio->image_path)
                                                <img src="{{ asset('storage/' . $portfolio->image_path) }}"
                                                    class="img-fluid rounded-5 no-bottom-radius"
                                                    alt="{{ $portfolio->title }}" loading="lazy">
                                            @else
                                                <img src="{{ asset('img/webp/abstract12.webp') }}"
                                                    class="img-fluid rounded-5 no-bottom-radius"
                                                    alt="{{ $portfolio->title }}" loading="lazy">
                                            @endif
                                            <div class="portfolio-category">
                                                <span
                                                    class="badge bg-tertiary rounded-pill">{{ $portfolio->category }}</span>
                                            </div>
                                        </div>
                                        <div class="p-4 p-lg-5 d-flex flex-column flex-grow-1">
                                            <h3 class="fw-lighter mb-3">{{ $portfolio->title }}</h3>
                                            <p class="text-theme-secondary mb-4">
                                                {{ Str::limit($portfolio->description, 120) }}</p>
                                            <div class="mt-auto">
                                                <a href="{{ route('portfolio.show', $portfolio->id) }}"
                                                    class="link-fancy link-fancy-light">View Project</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('portfolio') }}" class="btn btn-outline-tertiary rounded-pill">
                        <span>View All Projects</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container bg-theme-primary px-vw-5 py-vh-5 rounded-5">
        <div class="row gx-3 gx-md-4 gx-lg-5 gy-4 gy-md-5">
            <div class="col-12 col-md-6">
                <div class="card bg-transparent mb-4 mb-md-5" data-aos="zoom-in-up">
                    <div class="bg-dark shadow rounded-5 p-0">
                        <img src="{{ asset('img/dominate-banner.jpg') }}"
                            class="img-fluid rounded-5 no-bottom-radius w-100" loading="lazy">
                        <div class="p-4 p-md-5 p-lg-6">
                            <h2 class="fw-lighter fs-6 fs-md-5 fs-lg-4">Dominate Search Rankings<br>with Our SEO Expertise
                            </h2>
                            <p class="pb-2 pb-md-3 pb-lg-4 text-theme-secondary fs-7 fs-md-6">We optimize your website to
                                rank higher on search engines, bringing more visibility, traffic, and conversions.</p>
                            <a href="{{ route('services') }}" class="link-fancy link-fancy-light fs-7 fs-md-6">Read
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="card bg-transparent" data-aos="zoom-in-up">
                    <div class="bg-dark shadow rounded-5 p-0">
                        <img src="{{ asset('img/apps.jpg') }}" class="img-fluid rounded-5 no-bottom-radius w-100"
                            loading="lazy">
                        <div class="p-4 p-md-5 p-lg-6">
                            <h2 class="fw-lighter fs-6 fs-md-5 fs-lg-4">Engage. Grow. Convert.</h2>
                            <p class="pb-2 pb-md-3 pb-lg-4 text-theme-secondary fs-7 fs-md-6">We create and manage
                                strategic social media strategies to keep your audience engaged and your brand growing.</p>
                            <a href="{{ route('services') }}" class="link-fancy link-fancy-light fs-7 fs-md-6">Read
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="p-4 p-md-5 p-lg-6 pt-0 mt-3 mt-md-4 mt-lg-5 mb-4" data-aos="fade">
                    <span class="h5 text-theme-secondary fw-lighter fs-7 fs-md-6">Our Results</span>
                    <h2 class="text-tertiary fs-5 fs-md-4 fs-lg-3">See How We Drive<br>Real Results</h2>
                </div>
                <div class="card bg-transparent mb-4 mb-md-5 mt-3 mt-md-4 mt-lg-5" data-aos="zoom-in-up">
                    <div class="bg-dark shadow rounded-5 p-0">
                        <img src="{{ asset('img/traffic-banner.jpg') }}"
                            class="img-fluid rounded-5 no-bottom-radius w-100" loading="lazy">
                        <div class="p-4 p-md-5 p-lg-6">
                            <h2 class="fw-lighter fs-6 fs-md-5 fs-lg-4">50% More Traffic in Just<br>3 Months</h2>
                            <p class="pb-2 pb-md-3 pb-lg-4 text-theme-secondary fs-7 fs-md-6">See how we helped a local
                                business achieve remarkable online growth through our proven strategies.</p>
                            <a href="{{ route('portfolio') }}" class="link-fancy link-fancy-light fs-7 fs-md-6">Read
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="card bg-transparent" data-aos="zoom-in-up">
                    <div class="bg-dark shadow rounded-5 p-0">
                        <img src="{{ asset('img/google-card.jpg') }}" class="img-fluid rounded-5 no-bottom-radius w-100"
                            loading="lazy">
                        <div class="p-4 p-md-5 p-lg-6">
                            <h2 class="fw-lighter fs-6 fs-md-5 fs-lg-4">From Zero to Page 1 in 6 Months</h2>
                            <p class="pb-2 pb-md-3 pb-lg-4 text-theme-secondary fs-7 fs-md-6">Our SEO strategies helped a
                                startup rank on Google's first page, driving exponential business growth.</p>
                            <a href="{{ route('portfolio') }}" class="link-fancy link-fancy-light fs-7 fs-md-6">Read
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Testimonials Section -->
    {{-- <div class="bg-dark py-vh-3">
        <div class="container px-vw-5">
            <div class="row gx-5">
                <!-- Left Column - Stacked Testimonials -->
                <div class="col-12 col-lg-6">
                    <!-- Testimonial 1 -->
                    <div class="mb-5" data-aos="fade-up">
                        <div class="card bg-transparent">
                            <div class="card-body card-testimonial bg-theme-primary rounded-5 p-4 p-lg-5 shadow">
                                <div class="mb-4 d-flex gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                </div>
                                <p class="text-theme-secondary mb-5">"Pxp3 has been a game-changer for our business. Their expertise in web development and digital marketing has helped us grow significantly."</p>
                                
                                <hr class="border-secondary my-4">
                                
                                <div class="d-flex align-items-center">
                                    <div class="me-4">
                                        <img src="{{ asset('img/Michael Bauer.png') }}" alt="Michael Bauer" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; object-position: center;">
                                    </div>
                                    <div>
                                        <h3 class="h4 fw-lighter mb-1">Michael Bauer</h3>
                                        <p class="text-theme-secondary mb-0">CEO, XYZ Corp</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div data-aos="fade-up" data-aos-delay="100">
                        <div class="card bg-transparent">
                            <div class="card-body card-testimonial bg-theme-primary rounded-5 p-4 p-lg-5 shadow">
                                <div class="mb-4 d-flex gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                </div>
                                <p class="text-theme-secondary mb-5">"The team at Pxp3 is incredibly professional and knowledgeable. They have helped us achieve our digital marketing goals."</p>
                                
                                <hr class="border-secondary my-4">
                                
                                <div class="d-flex align-items-center">
                                    <div class="me-4">
                                        <img src="{{ asset('img/Emily Thompson.png') }}" alt="Emily Thompson" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; object-position: center;">
                                    </div>
                                    <div>
                                        <h3 class="h4 fw-lighter mb-1">Emily Thompson</h3>
                                        <p class="text-theme-secondary mb-0">COO, ABC Inc.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Title and Pink Testimonial -->
                <div class="col-12 col-lg-6">
                    <div class="mb-5 px-5">
                        <div class="mb-3 mt-5 mt-md-0">
                            <span class="h5 text-theme-secondary fw-lighter">TESTIMONIALS</span>
                        </div>
                        <h2 class="display-4">Invidunt ut labore et dolore<br>magna <span class="text-tertiary">aliquyam erat.</span></h2>
                    </div>

                    <!-- Pink Testimonial -->
                    <div class="mt-5" data-aos="fade-up" data-aos-delay="200">
                        <div class="card bg-transparent">
                            <div class="card-body card-testimonial rounded-5 p-4 p-lg-5 shadow" style="background-color: #E230C6;">
                                <div class="mb-4 d-flex gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-white" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-white" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-white" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-white" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill text-white" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                </div>
                                <p class="text-white mb-5">"Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."</p>
                                
                                <hr class="border-white opacity-25 my-4">
                                
                                <div class="d-flex align-items-center">
                                    <div class="me-4">
                                        <img src="{{ asset('img/Sarah Mitchell.png') }}" alt="Jane Doe" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; object-position: center;">
                                    </div>
                                    <div>
                                        <h3 class="h4 fw-lighter mb-1 text-white">Sarah Mitchell</h3>
                                        <p class="text-white mb-0 opacity-75">COO, The Boo Corp.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Blog Section -->
    <div class="bg-dark py-vh-5" id="blog">
        <div class="container px-vw-5">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <span class="h5 text-theme-secondary fw-lighter">Our Blog</span>
                    <h2 class="display-4">Recent <span class="text-tertiary">Posts</span></h2>
                </div>
                <div class="col-12 mt-5">
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card bg-transparent" data-aos="fade-up">
                                    <img src="{{ $post->cover_image ? asset('storage/' . $post->cover_image) : asset('img/webp/abstract12.webp') }}" class="card-img-top" alt="{{ $post->title }}">
                                    <div class="card-body">
                                        <h3 class="h5 mb-3">
                                            <a href="{{ route('blog.show', $post->slug) }}"
                                                class="text-decoration-none text-theme-primary">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="text-theme-secondary fs-6 mb-3">{{ Str::limit($post->excerpt, 100) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-dark py-vh-5" id="contact">
        <div class="container px-vw-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-8 text-center">
                    <h2 class="display-5 text-tertiary">Let's work together</h2>
                    <p class="lead text-theme-secondary">
                        Contact us to discuss how we can help boost your digital business.
                    </p>
                    <div class="col-12 text-center">
                        <a href="{{ route('contact') }}" class="btn btn-xl bg-tertiary d-inline-flex align-items-center">
                            <span>Contact Us</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
