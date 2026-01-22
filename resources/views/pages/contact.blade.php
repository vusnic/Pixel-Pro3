@extends('layouts.app')

@section('title', 'Pxp3 - Contact')

@section('content')
    <div class="w-100 overflow-hidden position-relative bg-theme-primary text-theme-primary" data-aos="fade">
        <div class="position-absolute w-100 h-100 bg-theme-primary opacity-75 top-0 start-0"></div>
        <div class="container py-vh-5 position-relative mt-5 px-vw-5">
            <div class="row d-flex">
                <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                    <span class="h5 text-theme-secondary fw-lighter text-uppercase">GET STARTED</span>
                    <h1 class="display-3 mt-3 mb-4 lh-1 fw-bold">Talk to a Specialist and Discover How We Can Boost Your Business</h1>
                    <p class="lead text-theme-secondary mb-5 fs-4">
                        No strings attached! In our first call, we'll understand your needs and present customized solutions for your business.
                    </p>
                    
                    <div class="rounded-5 overflow-hidden mt-5 d-none d-lg-block">
                        <div class="position-relative">
                            <img src="{{ asset('img/webp/abstract3.webp') }}" alt="Pxp3 Services" width="100%" class="img-fluid rounded-5">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-tertiary opacity-60 rounded-5"></div>
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
                                <h3 class="text-white text-center px-5">Customized digital solutions<br>for your business</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-lg-5 offset-lg-1">
                    <div class="card bg-white rounded-5 border-0 shadow-lg">
                        <div class="card-body p-4 p-md-5">
                            <form id="contactForm" class="needs-validation" action="javascript:void(0);">
                                @csrf
                                <input type="hidden" name="source" value="contact_page">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-medium mb-2 text-dark">Complete name</label>
                                    <input type="text" class="form-control form-control-lg rounded-4 border" id="name" name="name" placeholder="Your full name" required>
                                    <div class="invalid-feedback" id="name-error"></div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-medium mb-2 text-dark">Your e-mail*</label>
                                    <input type="email" class="form-control form-control-lg rounded-4 border" id="email" name="email" placeholder="email@example.com" required>
                                    <div class="invalid-feedback" id="email-error"></div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="phone" class="form-label fw-medium mb-2 text-dark">Phone number*</label>
                                    <div class="row g-0">
                                        <div class="col-4 col-md-3">
                                            <select class="form-select form-select-lg rounded-start-4 rounded-end-0 border-end-0" id="country_code" name="country_code">
                                                <option value="+1" selected>+1</option>
                                                <option value="+44">+44</option>
                                                <option value="+55">+55</option>
                                                <option value="+33">+33</option>
                                                <option value="+49">+49</option>
                                            </select>
                                        </div>
                                        <div class="col-8 col-md-9">
                                            <input type="tel" class="form-control form-control-lg rounded-start-0 rounded-end-4" id="phone" name="phone" placeholder="(000) 000-0000" required autocomplete="tel">
                                            <div class="invalid-feedback" id="phone-error"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="website" class="form-label fw-medium mb-2 text-dark">Do you have a Website?</label>
                                    <input type="url" class="form-control form-control-lg rounded-4 border" id="website" name="website" placeholder="https://www.yourwebsite.com">
                                    <div class="invalid-feedback" id="website-error"></div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="form-label fw-medium mb-2 text-dark">Your message</label>
                                    <textarea class="form-control form-control-lg rounded-4 border" id="message" name="message" placeholder="Tell us about your project..." rows="5"></textarea>
                                    <div class="invalid-feedback" id="message-error"></div>
                                </div>
                                
                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-lg bg-tertiary rounded-4 py-3 text-white text-center fs-5">
                                        Submit
                                    </button>
                                </div>
                            </form>
                            <div class="alert alert-success mt-3 d-none" id="form-success">
                                Thank you for your message! We will contact you shortly.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-dark py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        <div class="col">
                            <div class="d-flex mb-4">
                                <div class="me-3 text-tertiary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="h6 fw-normal text-tertiary">Address</h5>
                                    <p class="text-theme-secondary">5550 Wild Rose Ln #400, West Des Moines, IA 50266, Estados Unidos</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="d-flex mb-4">
                                <div class="me-3 text-tertiary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="h6 fw-normal text-tertiary">Email</h5>
                                    <p class="text-theme-secondary">contact@pixelpro3.com</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="d-flex mb-4">
                                <div class="me-3 text-tertiary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="h6 fw-normal text-tertiary">Phone</h5>
                                    <p class="text-theme-secondary">+1 833-412-3327</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="d-flex mb-4">
                                <div class="me-3 text-tertiary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="h6 fw-normal text-tertiary">Office Hours</h5>
                                    <p class="text-theme-secondary">Monday to Friday: 8am to 5pm</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-theme-primary py-vh-5">
        <div class="container px-vw-5">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-10 text-center">
                    <h2 class="display-5 text-tertiary">Social Media</h2>
                    <p class="lead text-theme-secondary">
                        Follow our work and news through our social media.
                    </p>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="#" class="btn btn-lg btn-outline-light mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                            </svg>
                        </a>
                        <a href="#" class="btn btn-lg btn-outline-light mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                        </a>
                        <a href="#" class="btn btn-lg btn-outline-light mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                            </svg>
                        </a>
                        <a href="#" class="btn btn-lg btn-outline-light mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        switch(countryCode) {
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