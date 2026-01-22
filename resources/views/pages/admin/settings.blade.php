@extends('layouts.admin')

@section('title', 'Settings - Pxp3 Admin')

@section('header', 'Settings')

@section('breadcrumb')
<li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-cog me-2 text-tertiary"></i>
                    Website Settings
                </h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Site Information -->
                    <div class="mb-4 px-0 px-md-5">
                        <h5 class="border-bottom pb-2">
                            <i class="fas fa-globe me-2 text-tertiary mb-0 mb-md-5 mt-0 mt-md-3"></i>
                            Site Information
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_title" class="form-label">Site Title <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" id="site_title" name="site_title" value="Pxp3" required>
                                    </div>
                                    <small class="text-muted">The name of your website</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Site Description <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" id="site_description" name="site_description" value="Web Design & Development Agency" required>
                                    </div>
                                    <small class="text-muted">A short description of your website</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_logo" class="form-label">Site Logo</label>
                                    <input type="file" class="form-control bg-white" id="site_logo" name="site_logo">
                                    <small class="text-muted">Recommended size: 180x50 pixels</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="favicon" class="form-label">Favicon</label>
                                    <input type="file" class="form-control bg-white" id="favicon" name="favicon">
                                    <small class="text-muted">Recommended size: 32x32 pixels</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="mb-4 px-0 px-md-5">
                        <h5 class="border-bottom pb-2 mb-0 mb-md-5 mt-0 mt-md-3">
                            <i class="fas fa-address-card me-2 text-tertiary"></i>
                            Contact Information
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="email" class="form-control bg-white" id="contact_email" name="contact_email" value="info@pixelpro3.com" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" id="contact_phone" name="contact_phone" value="+1 (555) 123-4567" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="contact_address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <textarea class="form-control bg-white" id="contact_address" name="contact_address" rows="2" required>123 Web Street, Digital City, CA 94567</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="mb-4 px-0 px-md-5">
                        <h5 class="border-bottom pb-2 mb-0 mb-md-5 mt-0 mt-md-3">
                            <i class="fas fa-share-alt me-2 text-tertiary"></i>
                            Social Media
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="social_facebook" class="form-label">Facebook</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" id="social_facebook" name="social_facebook" value="https://facebook.com/pixelpro3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="social_twitter" class="form-label">Twitter</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" id="social_twitter" name="social_twitter" value="https://twitter.com/pixelpro3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="social_instagram" class="form-label">Instagram</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" id="social_instagram" name="social_instagram" value="https://instagram.com/pixelpro3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="social_linkedin" class="form-label">LinkedIn</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" id="social_linkedin" name="social_linkedin" value="https://linkedin.com/company/pixelpro3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SEO Settings -->
                    <div class="mb-4 px-0 px-md-5">
                        <h5 class="border-bottom pb-2 mb-0 mb-md-5 mt-0 mt-md-3">
                            <i class="fas fa-search me-2 text-tertiary"></i>
                            SEO Settings
                        </h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white" id="meta_keywords" name="meta_keywords" value="web design, development, ui/ux, responsive, mobile-friendly">
                                    </div>
                                    <small class="text-muted">Separate keywords with commas</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <div class="input-group">
                                        <textarea class="form-control bg-white" id="meta_description" name="meta_description" rows="2">Pxp3 is a professional web design and development agency specializing in modern, responsive websites and applications.</textarea>
                                    </div>
                                    <small class="text-muted">Maximum 160 characters recommended</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input bg-white" id="enable_sitemap" name="enable_sitemap" checked>
                                    <label class="form-check-label" for="enable_sitemap">
                                        <i class="fas fa-sitemap me-1"></i>
                                        Generate sitemap automatically
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-tertiary">
                            <i class="fas fa-save me-1"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-5 border-0 shadow-lg mb-4">
            <div class="card-header bg-tertiary bg-opacity-10 border-0">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-info-circle me-2 text-tertiary"></i>
                    Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="fw-bold">Website Settings Best Practices</h6>
                    <ul class="text-muted mb-0">
                        <li>Keep your site title concise and memorable</li>
                        <li>Write a compelling meta description for better SEO</li>
                        <li>Use high-quality images for logo and favicon</li>
                        <li>Keep contact information up to date</li>
                        <li>Regularly update social media links</li>
                    </ul>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Pro Tip:</strong> A well-optimized meta description can significantly improve your search engine rankings.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 