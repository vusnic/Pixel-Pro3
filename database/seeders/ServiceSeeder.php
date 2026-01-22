<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Seed services data
     */
    public function run(): void
    {
        // Web Development
        Service::create([
            'title' => 'Web Development',
            'short_description' => 'Modern, responsive websites optimized for conversion.',
            'description' => 'We create websites that not only look great but also convert visitors into customers. Our development process focuses on performance, security and user experience.',
            'highlights' => json_encode(['Custom Design', 'Responsive', 'SEO Optimized', 'Admin Dashboard']),
            'status' => 'published',
            'price' => 1500,
            'price_period' => 'project',
            'featured' => true,
            'cta_text' => 'Get Quote',
            'order' => 1,
        ]);

        // Mobile App Development
        Service::create([
            'title' => 'Mobile App Development',
            'short_description' => 'Custom iOS and Android apps for your business.',
            'description' => 'We design and develop mobile applications that help your business reach customers on their preferred devices. Our apps are built with modern technologies and best practices.',
            'highlights' => json_encode(['Native Apps', 'Cross-platform', 'User-friendly UI/UX', 'API Integration']),
            'status' => 'published',
            'price' => 3000,
            'price_period' => 'project',
            'featured' => true,
            'cta_text' => 'Get Mobile App',
            'order' => 2,
        ]);
        
        // SEO Services
        Service::create([
            'title' => 'SEO Services',
            'short_description' => 'Improve your search rankings and drive more organic traffic.',
            'description' => 'Our SEO services help your website rank higher in search engines, driving more targeted traffic to your business. We use proven techniques and strategies to improve your online visibility.',
            'highlights' => json_encode(['Keyword Research', 'On-page Optimization', 'Link Building', 'Performance Reporting']),
            'status' => 'published',
            'price' => 750,
            'price_period' => 'month',
            'featured' => false,
            'cta_text' => 'Boost My Rankings',
            'order' => 3,
        ]);
        
        // Social Media Marketing
        Service::create([
            'title' => 'Social Media Marketing',
            'short_description' => 'Engage your audience and build your brand on social platforms.',
            'description' => 'We help businesses establish a strong presence on social media platforms to connect with their audience, build brand awareness, and drive conversions through strategic content and campaigns.',
            'highlights' => json_encode(['Content Creation', 'Community Management', 'Paid Advertising', 'Analytics & Reporting']),
            'status' => 'published',
            'price' => 650,
            'price_period' => 'month',
            'featured' => false,
            'cta_text' => 'Grow My Social Media',
            'order' => 4,
        ]);
        
        // E-commerce Solutions
        Service::create([
            'title' => 'E-commerce Solutions',
            'short_description' => 'Start selling online with a custom e-commerce store.',
            'description' => 'We build custom e-commerce solutions that help businesses sell their products online. Our e-commerce websites are designed for optimal user experience and maximum conversions.',
            'highlights' => json_encode(['Custom Shop Design', 'Payment Gateway Integration', 'Inventory Management', 'Mobile Optimized']),
            'status' => 'published',
            'price' => 2500,
            'price_period' => 'project',
            'featured' => true,
            'cta_text' => 'Start Selling Online',
            'order' => 5,
        ]);
        
        // Web Hosting & Maintenance
        Service::create([
            'title' => 'Web Hosting & Maintenance',
            'short_description' => 'Keep your website secure, updated and running smoothly.',
            'description' => 'Our web hosting and maintenance services ensure your website stays up-to-date, secure, and performing optimally. We handle all the technical aspects so you can focus on your business.',
            'highlights' => json_encode(['Regular Updates', 'Security Monitoring', 'Backup & Recovery', '24/7 Support']),
            'status' => 'published',
            'price' => 150,
            'price_period' => 'month',
            'featured' => false,
            'cta_text' => 'Maintain My Website',
            'order' => 6,
        ]);
    }
} 