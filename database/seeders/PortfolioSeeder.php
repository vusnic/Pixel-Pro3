<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PortfolioSeeder extends Seeder
{
    /**
     * Seed portfolio projects data
     */
    public function run(): void
    {
        // Web Design & Development
        Portfolio::create([
            'title' => 'Modern Corporate Website',
            'description' => 'Complete redesign of XYZ Corp corporate website, focusing on improving user experience, loading speed, and search engine optimization. The project included development of a custom content management system.',
            'image_path' => null, // Default image will be used
            'category' => 'Web Design',
            'technologies' => 'HTML5,CSS3,JavaScript,Laravel,MySQL',
            'client_name' => 'XYZ Corporation',
            'project_url' => 'https://example-xyz-corp.com',
            'completion_date' => Carbon::now()->subMonths(2),
            'highlights' => json_encode([
                '45% increase in conversion rate',
                'Loading time reduced by 60%',
                'CRM systems integration',
                'Custom admin dashboard'
            ]),
            'order' => 1,
            'featured' => true,
            'status' => 'published'
        ]);

        // E-commerce
        Portfolio::create([
            'title' => 'Premium Online Store',
            'description' => 'Development of an e-commerce platform for a luxury products brand, with a focus on premium experience, simplified checkout, and integration with multiple payment methods. Responsive design optimized for mobile devices.',
            'image_path' => null,
            'category' => 'E-commerce',
            'technologies' => 'Laravel,Vue.js,Tailwind CSS,Stripe,PayPal',
            'client_name' => 'Elegance Store',
            'project_url' => 'https://example-elegance.com',
            'completion_date' => Carbon::now()->subMonths(3),
            'highlights' => json_encode([
                '75% increase in online sales',
                '30% reduction in cart abandonment rate',
                'One-page checkout implementation',
                'Personalized recommendation system'
            ]),
            'order' => 2,
            'featured' => true,
            'status' => 'published'
        ]);

        // Mobile App
        Portfolio::create([
            'title' => 'Food Delivery App',
            'description' => 'Creation of a food delivery service app with real-time tracking features, in-app payment, and rating system. The project included development for iOS and Android from a single codebase.',
            'image_path' => null,
            'category' => 'Mobile App',
            'technologies' => 'React Native,Firebase,Node.js,Google Maps API',
            'client_name' => 'DeliveryFast',
            'project_url' => 'https://example-deliveryfast.com',
            'completion_date' => Carbon::now()->subMonths(5),
            'highlights' => json_encode([
                'Over 50,000 downloads on app stores',
                'Integration with restaurant management system',
                'Contactless payment implementation',
                'Real-time delivery tracking'
            ]),
            'order' => 3,
            'featured' => true,
            'status' => 'published'
        ]);

        // SEO & Digital Marketing
        Portfolio::create([
            'title' => 'Digital Marketing Campaign',
            'description' => 'Complete digital marketing strategy for product launch, including SEO, content marketing, paid media campaigns, and conversion optimization. Notable results in terms of lead generation and sales.',
            'image_path' => null,
            'category' => 'Digital Marketing',
            'technologies' => 'Google Ads,Facebook Ads,SEO,Google Analytics,HubSpot',
            'client_name' => 'TechLaunch',
            'project_url' => 'https://example-techlaunch.com',
            'completion_date' => Carbon::now()->subMonths(2),
            'highlights' => json_encode([
                '200% increase in organic traffic',
                '450% ROI on paid campaigns',
                '25% reduction in cost per acquisition',
                '5,000 new qualified leads'
            ]),
            'order' => 4,
            'featured' => true,
            'status' => 'published'
        ]);

        // Branding
        Portfolio::create([
            'title' => 'Complete Rebranding',
            'description' => 'Complete rebranding project for an expanding technology company. Included redesign of visual identity, brand positioning, communication guidelines, and implementation strategy across all digital and physical channels.',
            'image_path' => null,
            'category' => 'Branding',
            'technologies' => 'Adobe Creative Suite,Brand Strategy,Market Research',
            'client_name' => 'Innovate Solutions',
            'project_url' => 'https://example-innovate.com',
            'completion_date' => Carbon::now()->subMonths(4),
            'highlights' => json_encode([
                '35% increase in positive brand perception',
                'Implementation across 20+ different channels',
                'Creation of comprehensive visual identity manual',
                'Internal and external communication strategy'
            ]),
            'order' => 5,
            'featured' => false,
            'status' => 'published'
        ]);

        // UI/UX Design
        Portfolio::create([
            'title' => 'App Interface Redesign',
            'description' => 'Complete redesign of the user interface and experience of a financial app with over 1 million users. The project focused on improving usability, accessibility, and user satisfaction while modernizing the visual aesthetics.',
            'image_path' => null,
            'category' => 'UI/UX Design',
            'technologies' => 'Figma,Adobe XD,User Testing,Design System',
            'client_name' => 'Finance App',
            'project_url' => 'https://example-financeapp.com',
            'completion_date' => Carbon::now()->subMonths(6),
            'highlights' => json_encode([
                '40% increase in user satisfaction',
                '60% reduction in support calls',
                'Development of scalable design system',
                'Implementation of 200+ redesigned screens'
            ]),
            'order' => 6,
            'featured' => false,
            'status' => 'published'
        ]);

        // Content Creation
        Portfolio::create([
            'title' => 'B2B Content Strategy',
            'description' => 'Development and implementation of content strategy for a B2B software company, including blog creation, white papers, case studies, and social media content. Focus on lead generation and industry authority.',
            'image_path' => null,
            'category' => 'Content Marketing',
            'technologies' => 'SEO,Content Marketing,WordPress,HubSpot',
            'client_name' => 'B2B Solutions',
            'project_url' => 'https://example-b2bsolutions.com',
            'completion_date' => Carbon::now()->subMonths(3),
            'highlights' => json_encode([
                '150% increase in qualified leads',
                '80% growth in organic traffic',
                'Development of 25 premium white papers',
                'Marketing automation implementation'
            ]),
            'order' => 7,
            'featured' => false,
            'status' => 'published'
        ]);

        // Project in progress
        Portfolio::create([
            'title' => 'Enterprise Management System',
            'description' => 'Development of a custom ERP system for a manufacturing company, integrating production, inventory, sales, HR, and financial modules. The system aims to unify data and processes to improve operational efficiency.',
            'image_path' => null,
            'category' => 'Enterprise Systems',
            'technologies' => 'Laravel,Vue.js,MySQL,Docker,AWS',
            'client_name' => 'Industrial Manufacturing',
            'project_url' => null,
            'completion_date' => Carbon::now()->addMonths(2),
            'highlights' => json_encode([
                'Automation of critical processes',
                'Real-time indicators dashboard',
                'Integration with legacy systems',
                'Mobile access for external teams'
            ]),
            'order' => 8,
            'featured' => false,
            'status' => 'draft'
        ]);
    }
} 