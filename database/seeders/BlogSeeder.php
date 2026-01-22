<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Design', 'slug' => 'design'],
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Business', 'slug' => 'business'],
            ['name' => 'Marketing', 'slug' => 'marketing'],
            ['name' => 'DevOps', 'slug' => 'devops'],
            ['name' => 'AI & Machine Learning', 'slug' => 'ai-machine-learning'],
            ['name' => 'Cybersecurity', 'slug' => 'cybersecurity'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(['slug' => $categoryData['slug']], $categoryData);
        }

        // Create tags
        $tags = [
            ['name' => 'React', 'slug' => 'react'],
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'CSS', 'slug' => 'css'],
            ['name' => 'UI/UX', 'slug' => 'ui-ux'],
            ['name' => 'Mobile', 'slug' => 'mobile'],
            ['name' => 'API', 'slug' => 'api'],
            ['name' => 'Database', 'slug' => 'database'],
            ['name' => 'SEO', 'slug' => 'seo'],
            ['name' => 'E-commerce', 'slug' => 'e-commerce'],
            ['name' => 'CMS', 'slug' => 'cms'],
            ['name' => 'Vue.js', 'slug' => 'vue-js'],
            ['name' => 'Node.js', 'slug' => 'node-js'],
            ['name' => 'TypeScript', 'slug' => 'typescript'],
            ['name' => 'Docker', 'slug' => 'docker'],
            ['name' => 'AWS', 'slug' => 'aws'],
            ['name' => 'Git', 'slug' => 'git'],
            ['name' => 'Testing', 'slug' => 'testing'],
            ['name' => 'Performance', 'slug' => 'performance'],
            ['name' => 'Security', 'slug' => 'security'],
            ['name' => 'AI', 'slug' => 'ai'],
            ['name' => 'Analytics', 'slug' => 'analytics'],
            ['name' => 'Startup', 'slug' => 'startup'],
        ];

        foreach ($tags as $tagData) {
            Tag::firstOrCreate(['slug' => $tagData['slug']], $tagData);
        }

        // Get or create a user for posts
        $user = User::where('role', 'admin')->first();
        if (!$user) {
            $user = User::first();
        }

        if (!$user) {
            // Create a default admin user if none exists
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@pixelpro3.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // Create sample posts
        $posts = [
            [
                'title' => 'Building Modern Web Applications with Laravel and React',
                'excerpt' => 'Learn how to create powerful web applications by combining Laravel\'s robust backend with React\'s dynamic frontend capabilities.',
                'content' => '<p>In today\'s fast-paced digital world, creating modern web applications requires the right combination of technologies. Laravel and React have emerged as a powerful duo for building scalable, maintainable, and feature-rich web applications.</p>

<h2>Why Laravel and React?</h2>
<p>Laravel provides a solid foundation for your backend with its elegant syntax, powerful ORM, and extensive ecosystem. React, on the other hand, offers a component-based approach to building interactive user interfaces.</p>

<h2>Setting Up Your Development Environment</h2>
<p>Before we dive into coding, let\'s set up our development environment. You\'ll need PHP, Composer, Node.js, and npm installed on your machine.</p>

<h2>Creating the Laravel Backend</h2>
<p>Start by creating a new Laravel project and setting up your API routes, controllers, and models. Laravel\'s Eloquent ORM makes database interactions a breeze.</p>

<h2>Building the React Frontend</h2>
<p>With your backend ready, it\'s time to create your React frontend. Use modern tools like Vite for fast development and build processes.</p>

<h2>Connecting Frontend and Backend</h2>
<p>Learn how to make API calls from React to your Laravel backend, handle authentication, and manage state effectively.</p>

<p>This combination of technologies allows you to build applications that are both powerful and user-friendly, making it an excellent choice for modern web development projects.</p>',
                'category' => 'Web Development',
                'tags' => ['Laravel', 'React', 'PHP', 'JavaScript'],
                'published' => true,
                'published_at' => now()->subDays(5),
                'views' => 1250,
            ],
            [
                'title' => 'The Future of User Interface Design: Trends for 2025',
                'excerpt' => 'Explore the latest UI/UX design trends that will shape the digital landscape in 2025 and beyond.',
                'content' => '<p>As we move into 2025, the world of user interface design continues to evolve at a rapid pace. New technologies, changing user behaviors, and innovative design philosophies are shaping the future of digital experiences.</p>

<h2>Minimalist Design with Purpose</h2>
<p>Minimalism isn\'t going anywhere, but it\'s becoming more purposeful. Every element serves a specific function, and whitespace is used strategically to guide user attention.</p>

<h2>Dark Mode and Adaptive Themes</h2>
<p>Dark mode has become a standard expectation, but the future lies in adaptive themes that change based on time of day, user preferences, and even ambient lighting conditions.</p>

<h2>Micro-interactions and Animations</h2>
<p>Subtle animations and micro-interactions are becoming more sophisticated, providing feedback and creating delightful user experiences without overwhelming the interface.</p>

<h2>Voice and Gesture Interfaces</h2>
<p>With the rise of smart devices and AR/VR technologies, designers are exploring new ways to interact with digital interfaces beyond traditional touch and click.</p>

<h2>Accessibility-First Design</h2>
<p>Inclusive design is no longer an afterthought. Future interfaces will be built with accessibility in mind from the ground up, ensuring everyone can use digital products effectively.</p>

<p>The key to successful UI design in 2025 will be balancing innovation with usability, ensuring that new features enhance rather than complicate the user experience.</p>',
                'category' => 'Design',
                'tags' => ['UI/UX', 'Design'],
                'published' => true,
                'published_at' => now()->subDays(3),
                'views' => 890,
            ],
            [
                'title' => 'API Development Best Practices: Building Robust Backend Services',
                'excerpt' => 'Discover essential best practices for developing secure, scalable, and maintainable APIs that power modern applications.',
                'content' => '<p>Application Programming Interfaces (APIs) are the backbone of modern web applications. They enable different systems to communicate and share data efficiently. Building robust APIs requires careful planning and adherence to best practices.</p>

<h2>RESTful Design Principles</h2>
<p>Follow REST principles to create intuitive and consistent APIs. Use proper HTTP methods, status codes, and resource naming conventions to make your API predictable and easy to use.</p>

<h2>Authentication and Security</h2>
<p>Implement proper authentication mechanisms such as JWT tokens or OAuth. Always validate input data, use HTTPS, and implement rate limiting to protect your API from abuse.</p>

<h2>Error Handling and Responses</h2>
<p>Provide clear, consistent error messages with appropriate HTTP status codes. Include enough information for developers to understand and fix issues without exposing sensitive system details.</p>

<h2>Documentation and Testing</h2>
<p>Comprehensive documentation is crucial for API adoption. Use tools like Swagger or Postman to create interactive documentation, and implement automated testing to ensure reliability.</p>

<h2>Versioning and Backward Compatibility</h2>
<p>Plan for API evolution from the beginning. Implement versioning strategies that allow you to add new features without breaking existing integrations.</p>

<p>By following these best practices, you\'ll create APIs that are not only functional but also maintainable and scalable as your application grows.</p>',
                'category' => 'Web Development',
                'tags' => ['API', 'PHP', 'Laravel', 'Database'],
                'published' => true,
                'published_at' => now()->subDays(7),
                'views' => 756,
            ],
            [
                'title' => 'E-commerce SEO: Optimizing Your Online Store for Search Engines',
                'excerpt' => 'Learn proven strategies to improve your e-commerce site\'s search engine visibility and drive more organic traffic.',
                'content' => '<p>Search engine optimization (SEO) is crucial for e-commerce success. With millions of online stores competing for attention, effective SEO strategies can make the difference between thriving and struggling.</p>

<h2>Keyword Research for Products</h2>
<p>Start with comprehensive keyword research focused on your products. Use tools like Google Keyword Planner, SEMrush, or Ahrefs to identify terms your customers are searching for.</p>

<h2>Product Page Optimization</h2>
<p>Optimize product titles, descriptions, and meta tags with relevant keywords. Use high-quality images with descriptive alt text and implement schema markup for rich snippets.</p>

<h2>Site Structure and Navigation</h2>
<p>Create a logical site structure with clear categories and subcategories. Implement breadcrumb navigation and ensure your site is easily crawlable by search engines.</p>

<h2>Technical SEO for E-commerce</h2>
<p>Focus on site speed, mobile responsiveness, and proper URL structure. Implement canonical tags to avoid duplicate content issues common in e-commerce sites.</p>

<h2>Content Marketing Strategy</h2>
<p>Create valuable content beyond product pages. Blog posts, buying guides, and how-to articles can attract organic traffic and establish your expertise.</p>

<p>Remember, SEO is a long-term strategy. Consistent effort and monitoring will help you build sustainable organic traffic that converts into sales.</p>',
                'category' => 'Marketing',
                'tags' => ['SEO', 'E-commerce', 'Marketing'],
                'published' => true,
                'published_at' => now()->subDays(10),
                'views' => 623,
            ],
            [
                'title' => 'Mobile-First Development: Creating Responsive Web Applications',
                'excerpt' => 'Master the art of mobile-first development and create web applications that work seamlessly across all devices.',
                'content' => '<p>With mobile devices accounting for over half of all web traffic, mobile-first development has become essential rather than optional. This approach ensures your applications provide excellent user experiences regardless of device size.</p>

<h2>Understanding Mobile-First Principles</h2>
<p>Mobile-first design starts with the smallest screen size and progressively enhances the experience for larger screens. This approach forces you to prioritize essential content and functionality.</p>

<h2>Responsive Design Techniques</h2>
<p>Use CSS Grid and Flexbox for flexible layouts, implement fluid typography with viewport units, and create touch-friendly interfaces with appropriate button sizes and spacing.</p>

<h2>Performance Optimization</h2>
<p>Mobile users often have slower connections and less powerful devices. Optimize images, minimize CSS and JavaScript, and implement lazy loading for better performance.</p>

<h2>Touch Interface Considerations</h2>
<p>Design for touch interactions with larger tap targets, consider thumb-friendly navigation patterns, and implement appropriate gesture support for mobile users.</p>

<h2>Testing Across Devices</h2>
<p>Use browser developer tools, real device testing, and tools like BrowserStack to ensure your application works well across different devices and screen sizes.</p>

<p>Mobile-first development isn\'t just about screen size—it\'s about creating focused, performance-optimized experiences that work well everywhere.</p>',
                'category' => 'Web Development',
                'tags' => ['Mobile', 'CSS', 'JavaScript', 'UI/UX'],
                'published' => true,
                'published_at' => now()->subDays(12),
                'views' => 945,
            ],
            [
                'title' => 'Vue.js vs React: Choosing the Right Frontend Framework',
                'excerpt' => 'Compare Vue.js and React to make an informed decision about which frontend framework best suits your project needs.',
                'content' => '<p>Choosing the right frontend framework is crucial for project success. Vue.js and React are two of the most popular choices, each with unique strengths and characteristics.</p>

<h2>Learning Curve and Developer Experience</h2>
<p>Vue.js is known for its gentle learning curve and approachable documentation. React has a steeper learning curve but offers more flexibility once mastered.</p>

<h2>Performance Comparison</h2>
<p>Both frameworks offer excellent performance. React\'s Virtual DOM and Vue\'s reactivity system both provide efficient updates, but implementation details can affect real-world performance.</p>

<h2>Ecosystem and Community</h2>
<p>React has a larger ecosystem and job market, while Vue.js offers a more cohesive, opinionated approach with official solutions for routing and state management.</p>

<h2>Project Requirements</h2>
<p>Consider your team\'s experience, project timeline, and long-term maintenance needs. Vue.js excels for rapid prototyping, while React offers more flexibility for complex applications.</p>

<h2>Making the Right Choice</h2>
<p>The best framework depends on your specific needs, team expertise, and project requirements. Both are excellent choices for modern web development.</p>

<p>Understanding the strengths of each framework will help you make an informed decision that aligns with your project goals and team capabilities.</p>',
                'category' => 'Web Development',
                'tags' => ['Vue.js', 'React', 'JavaScript'],
                'published' => true,
                'published_at' => now()->subDays(1),
                'views' => 432,
            ],
            [
                'title' => 'Docker for Web Developers: Containerizing Your Applications',
                'excerpt' => 'Learn how to use Docker to create consistent development environments and streamline your deployment process.',
                'content' => '<p>Docker has revolutionized how we develop, test, and deploy applications. By containerizing your web applications, you can ensure consistency across different environments and simplify deployment processes.</p>

<h2>Understanding Containers</h2>
<p>Containers package your application with all its dependencies, ensuring it runs consistently across different environments. Unlike virtual machines, containers share the host OS kernel for better performance.</p>

<h2>Creating Your First Dockerfile</h2>
<p>A Dockerfile defines how to build your container image. Start with a base image, install dependencies, copy your application code, and specify how to run your application.</p>

<h2>Docker Compose for Multi-Service Applications</h2>
<p>Use Docker Compose to define and run multi-container applications. Easily orchestrate databases, web servers, and other services with a simple YAML configuration.</p>

<h2>Development Workflow</h2>
<p>Integrate Docker into your development workflow for consistent environments. Use volume mounts for live code reloading and maintain separate configurations for development and production.</p>

<h2>Deployment and Orchestration</h2>
<p>Learn about container registries, deployment strategies, and orchestration platforms like Kubernetes for managing containers at scale.</p>

<p>Docker simplifies development and deployment, making it easier to build and ship applications reliably across different environments.</p>',
                'category' => 'DevOps',
                'tags' => ['Docker', 'DevOps'],
                'published' => true,
                'published_at' => now()->subDays(14),
                'views' => 678,
            ],
            [
                'title' => 'Introduction to AI in Web Development: Enhancing User Experience',
                'excerpt' => 'Discover how artificial intelligence can be integrated into web applications to create smarter, more personalized user experiences.',
                'content' => '<p>Artificial Intelligence is transforming web development, enabling applications to provide more personalized, intelligent, and efficient user experiences. From chatbots to recommendation systems, AI is becoming an integral part of modern web applications.</p>

<h2>AI-Powered Chatbots and Virtual Assistants</h2>
<p>Implement intelligent chatbots that can understand natural language, provide instant customer support, and guide users through complex processes.</p>

<h2>Personalization and Recommendation Engines</h2>
<p>Use machine learning algorithms to analyze user behavior and provide personalized content recommendations, improving engagement and conversion rates.</p>

<h2>Automated Content Generation</h2>
<p>Explore how AI can help generate content, from product descriptions to blog posts, saving time and resources while maintaining quality.</p>

<h2>Image and Voice Recognition</h2>
<p>Integrate computer vision and speech recognition APIs to create more intuitive interfaces that respond to images, voice commands, and gestures.</p>

<h2>Predictive Analytics</h2>
<p>Implement predictive models to anticipate user needs, optimize performance, and make data-driven decisions about your application\'s features and functionality.</p>

<p>AI integration doesn\'t require extensive machine learning expertise. Many cloud services provide ready-to-use APIs that can enhance your web applications with intelligent features.</p>',
                'category' => 'AI & Machine Learning',
                'tags' => ['AI', 'JavaScript', 'API'],
                'published' => true,
                'published_at' => now()->subDays(6),
                'views' => 1120,
            ],
            [
                'title' => 'Web Security Fundamentals: Protecting Your Applications',
                'excerpt' => 'Learn essential security practices to protect your web applications from common vulnerabilities and attacks.',
                'content' => '<p>Web security is not optional in today\'s threat landscape. Understanding common vulnerabilities and implementing proper security measures is crucial for protecting your applications and user data.</p>

<h2>OWASP Top 10 Vulnerabilities</h2>
<p>Familiarize yourself with the most common web application security risks, including injection attacks, broken authentication, and cross-site scripting (XSS).</p>

<h2>Input Validation and Sanitization</h2>
<p>Always validate and sanitize user input on both client and server sides. Use parameterized queries to prevent SQL injection and validate data types and formats.</p>

<h2>Authentication and Authorization</h2>
<p>Implement secure authentication mechanisms with proper password policies, multi-factor authentication, and secure session management.</p>

<h2>HTTPS and Data Encryption</h2>
<p>Use HTTPS for all communications and encrypt sensitive data both in transit and at rest. Implement proper certificate management and security headers.</p>

<h2>Security Testing and Monitoring</h2>
<p>Regularly perform security audits, penetration testing, and vulnerability scans. Implement logging and monitoring to detect and respond to security incidents.</p>

<p>Security is an ongoing process, not a one-time implementation. Stay updated with the latest threats and security best practices to keep your applications secure.</p>',
                'category' => 'Cybersecurity',
                'tags' => ['Security', 'PHP', 'JavaScript'],
                'published' => true,
                'published_at' => now()->subDays(8),
                'views' => 834,
            ],
            [
                'title' => 'TypeScript for JavaScript Developers: A Comprehensive Guide',
                'excerpt' => 'Transition from JavaScript to TypeScript and learn how static typing can improve your development experience and code quality.',
                'content' => '<p>TypeScript has gained massive adoption in the JavaScript community for good reason. By adding static typing to JavaScript, TypeScript helps catch errors early, improves code maintainability, and enhances the development experience.</p>

<h2>Why TypeScript?</h2>
<p>TypeScript provides compile-time error checking, better IDE support with autocomplete and refactoring tools, and improved code documentation through type annotations.</p>

<h2>Basic Types and Interfaces</h2>
<p>Learn about primitive types, arrays, objects, and how to define custom types using interfaces and type aliases. Understand union types and generics for flexible type definitions.</p>

<h2>Functions and Classes</h2>
<p>Explore how TypeScript enhances functions with parameter and return type annotations, and how classes benefit from access modifiers and abstract classes.</p>

<h2>Advanced Features</h2>
<p>Discover advanced TypeScript features like decorators, modules, namespaces, and utility types that can help you write more robust and maintainable code.</p>

<h2>Integration with Frameworks</h2>
<p>Learn how to use TypeScript with popular frameworks like React, Vue.js, and Node.js, taking advantage of strongly typed development environments.</p>

<p>The investment in learning TypeScript pays off quickly with improved development experience, fewer runtime errors, and better code maintainability.</p>',
                'category' => 'Web Development',
                'tags' => ['TypeScript', 'JavaScript'],
                'published' => true,
                'published_at' => now()->subDays(2),
                'views' => 567,
            ],
            [
                'title' => 'Building a Startup Tech Stack: From MVP to Scale',
                'excerpt' => 'Navigate the technology decisions that will shape your startup\'s future, from initial MVP to scaling for millions of users.',
                'content' => '<p>Choosing the right technology stack for your startup is crucial for long-term success. The decisions you make early on will impact your ability to iterate quickly, attract talent, and scale effectively.</p>

<h2>MVP Considerations</h2>
<p>For your minimum viable product, prioritize speed of development and flexibility. Choose technologies your team knows well and that allow for rapid iteration and changes.</p>

<h2>Frontend Technology Choices</h2>
<p>Consider frameworks like React, Vue.js, or Angular for complex applications, or stick with server-side rendering for simpler projects. Progressive Web Apps can provide native-like experiences.</p>

<h2>Backend Architecture</h2>
<p>Choose between monolithic and microservices architectures based on your team size and complexity needs. Consider serverless options for certain use cases to reduce operational overhead.</p>

<h2>Database Decisions</h2>
<p>Start with a relational database like PostgreSQL for most use cases. Consider NoSQL options only when you have specific requirements that relational databases can\'t meet efficiently.</p>

<h2>Scaling Considerations</h2>
<p>Plan for horizontal scaling from the beginning. Use cloud services for infrastructure, implement caching strategies, and design your application to be stateless where possible.</p>

<p>Remember, the best technology stack is one that your team can execute well and that grows with your business needs. Don\'t over-engineer early, but plan for future scalability.</p>',
                'category' => 'Business',
                'tags' => ['Startup', 'Technology'],
                'published' => true,
                'published_at' => now()->subDays(15),
                'views' => 923,
            ],
            [
                'title' => 'Web Performance Optimization: Making Your Site Lightning Fast',
                'excerpt' => 'Master the techniques and tools needed to optimize your website\'s performance and provide exceptional user experiences.',
                'content' => '<p>Website performance directly impacts user experience, search engine rankings, and business metrics. Slow websites lose users and revenue, making performance optimization a critical skill for web developers.</p>

<h2>Performance Metrics That Matter</h2>
<p>Understand Core Web Vitals: Largest Contentful Paint (LCP), First Input Delay (FID), and Cumulative Layout Shift (CLS). These metrics directly impact SEO and user experience.</p>

<h2>Image Optimization</h2>
<p>Images often account for most of a webpage\'s size. Use modern formats like WebP, implement lazy loading, and provide responsive images with different sizes for different devices.</p>

<h2>JavaScript and CSS Optimization</h2>
<p>Minimize and compress your assets, remove unused code, and implement code splitting to load only what\'s needed. Use service workers for caching strategies.</p>

<h2>Server-Side Optimizations</h2>
<p>Implement efficient caching strategies, use Content Delivery Networks (CDNs), enable gzip compression, and optimize database queries to reduce server response times.</p>

<h2>Monitoring and Testing</h2>
<p>Use tools like Lighthouse, WebPageTest, and Real User Monitoring (RUM) to continuously monitor performance and identify optimization opportunities.</p>

<p>Performance optimization is an ongoing process. Regular monitoring and testing ensure your site remains fast as it grows and evolves.</p>',
                'category' => 'Web Development',
                'tags' => ['Performance', 'JavaScript', 'CSS'],
                'published' => true,
                'published_at' => now()->subDays(4),
                'views' => 712,
            ],
            [
                'title' => 'Git Workflow Best Practices for Development Teams',
                'excerpt' => 'Establish effective Git workflows that improve collaboration, code quality, and deployment processes for your development team.',
                'content' => '<p>Effective Git workflows are essential for team collaboration and code quality. The right branching strategy and workflow can prevent conflicts, enable parallel development, and ensure stable releases.</p>

<h2>Choosing a Branching Strategy</h2>
<p>Compare Git Flow, GitHub Flow, and GitLab Flow to find the strategy that best fits your team size, release cycle, and deployment requirements.</p>

<h2>Commit Message Conventions</h2>
<p>Implement consistent commit message formats using conventions like Conventional Commits. Clear commit messages improve code history readability and enable automated tooling.</p>

<h2>Code Review Process</h2>
<p>Establish pull request templates, review guidelines, and automated checks to ensure code quality. Use tools like GitHub Actions or GitLab CI for continuous integration.</p>

<h2>Branch Protection and Policies</h2>
<p>Configure branch protection rules to prevent direct commits to main branches, require reviews, and ensure all checks pass before merging.</p>

<h2>Release Management</h2>
<p>Use semantic versioning, automate changelog generation, and implement proper tagging strategies for clear release tracking and rollback capabilities.</p>

<p>Good Git practices become more important as your team grows. Invest time in establishing clear workflows and guidelines that scale with your organization.</p>',
                'category' => 'Web Development',
                'tags' => ['Git', 'DevOps'],
                'published' => true,
                'published_at' => now()->subDays(11),
                'views' => 445,
            ],
            [
                'title' => 'Modern CSS Techniques: Grid, Flexbox, and Beyond',
                'excerpt' => 'Explore modern CSS layout techniques and properties that make creating responsive, beautiful designs easier than ever.',
                'content' => '<p>CSS has evolved dramatically in recent years, providing powerful layout tools that make responsive design easier and more intuitive. Modern CSS techniques eliminate the need for many JavaScript workarounds.</p>

<h2>CSS Grid vs Flexbox</h2>
<p>Understand when to use CSS Grid for two-dimensional layouts and Flexbox for one-dimensional layouts. Learn how they complement each other in modern web design.</p>

<h2>Custom Properties (CSS Variables)</h2>
<p>Use CSS custom properties to create maintainable stylesheets with dynamic theming capabilities. Implement dark mode toggles and consistent design systems.</p>

<h2>Container Queries</h2>
<p>Move beyond viewport-based media queries with container queries that respond to the size of containing elements, enabling true component-based responsive design.</p>

<h2>Modern Selectors and Pseudo-Classes</h2>
<p>Leverage new selectors like :has(), :is(), and :where() to write more efficient and maintainable CSS. Use logical properties for international layouts.</p>

<h2>CSS-in-JS vs Traditional CSS</h2>
<p>Compare different approaches to styling including traditional CSS, CSS modules, styled-components, and other CSS-in-JS solutions.</p>

<p>Staying current with CSS developments enables you to create better user experiences with less code and greater maintainability.</p>',
                'category' => 'Design',
                'tags' => ['CSS', 'UI/UX'],
                'published' => true,
                'published_at' => now()->subDays(9),
                'views' => 689,
            ],
            [
                'title' => 'Node.js Backend Development: Building Scalable APIs',
                'excerpt' => 'Learn how to build robust, scalable backend services using Node.js, from basic APIs to complex microservices architectures.',
                'content' => '<p>Node.js has become a popular choice for backend development, offering JavaScript developers the ability to use the same language across the entire stack. Its event-driven architecture makes it particularly well-suited for I/O-intensive applications.</p>

<h2>Setting Up a Node.js Project</h2>
<p>Start with proper project structure, dependency management with npm or yarn, and environment configuration. Use tools like nodemon for development and PM2 for production.</p>

<h2>Express.js Framework</h2>
<p>Build RESTful APIs with Express.js, implementing routing, middleware, error handling, and request validation. Learn about security best practices and rate limiting.</p>

<h2>Database Integration</h2>
<p>Connect to databases using ORMs like Sequelize or Prisma, or work directly with database drivers. Implement connection pooling and handle database migrations.</p>

<h2>Authentication and Authorization</h2>
<p>Implement JWT-based authentication, session management, and role-based access control. Use passport.js for social authentication strategies.</p>

<h2>Testing and Deployment</h2>
<p>Write unit and integration tests with Jest or Mocha. Deploy to cloud platforms like AWS, Google Cloud, or Heroku with proper CI/CD pipelines.</p>

<p>Node.js enables rapid development of scalable backend services, making it an excellent choice for modern web applications and APIs.</p>',
                'category' => 'Web Development',
                'tags' => ['Node.js', 'JavaScript', 'API'],
                'published' => true,
                'published_at' => now()->subDays(13),
                'views' => 856,
            ],
            [
                'title' => 'Digital Marketing Analytics: Measuring What Matters',
                'excerpt' => 'Learn how to track, analyze, and optimize your digital marketing efforts using data-driven insights and analytics tools.',
                'content' => '<p>Effective digital marketing requires more than creative campaigns—it demands rigorous measurement and analysis. Understanding your analytics enables data-driven decisions that improve ROI and customer acquisition.</p>

<h2>Setting Up Analytics Properly</h2>
<p>Configure Google Analytics 4, implement proper event tracking, and set up conversion goals. Ensure GDPR compliance and respect user privacy preferences.</p>

<h2>Key Performance Indicators (KPIs)</h2>
<p>Identify the metrics that matter for your business: customer acquisition cost, lifetime value, conversion rates, and engagement metrics. Avoid vanity metrics that don\'t drive business value.</p>

<h2>Attribution Modeling</h2>
<p>Understand how customers interact with your brand across multiple touchpoints. Compare first-click, last-click, and data-driven attribution models to understand campaign effectiveness.</p>

<h2>A/B Testing and Optimization</h2>
<p>Design statistically significant tests for landing pages, email campaigns, and ad creative. Use tools like Google Optimize or Optimizely for systematic testing.</p>

<h2>Reporting and Insights</h2>
<p>Create automated dashboards and reports that provide actionable insights. Use tools like Google Data Studio or Tableau to visualize performance data effectively.</p>

<p>Analytics isn\'t just about collecting data—it\'s about generating insights that drive better marketing decisions and improved business outcomes.</p>',
                'category' => 'Marketing',
                'tags' => ['Analytics', 'Marketing', 'SEO'],
                'published' => true,
                'published_at' => now()->subDays(16),
                'views' => 534,
            ],
            [
                'title' => 'Progressive Web Apps: The Future of Mobile Web',
                'excerpt' => 'Create app-like experiences on the web with Progressive Web Apps that work offline, load instantly, and engage users like native apps.',
                'content' => '<p>Progressive Web Apps (PWAs) bridge the gap between web and native applications, offering app-like experiences that work across all devices and platforms. They represent the future of mobile web development.</p>

<h2>Core PWA Features</h2>
<p>Implement service workers for offline functionality, web app manifests for installation, and push notifications for user engagement. Create experiences that rival native apps.</p>

<h2>Performance and Caching Strategies</h2>
<p>Use the Cache API and service workers to implement sophisticated caching strategies. Ensure your PWA loads instantly and works reliably even with poor network conditions.</p>

<h2>Installation and Engagement</h2>
<p>Enable app installation with web app manifests and customize the installation experience. Implement push notifications and background sync for ongoing user engagement.</p>

<h2>Platform Integration</h2>
<p>Access device APIs for camera, geolocation, and sensors. Integrate with platform features like share targets and file handling to create truly native-like experiences.</p>

<h2>PWA Tools and Frameworks</h2>
<p>Use tools like Workbox for service worker management, Lighthouse for auditing, and frameworks like Ionic or PWA Builder for rapid development.</p>

<p>PWAs offer the reach of the web with the engagement of native apps, making them an ideal solution for businesses looking to maximize their mobile presence.</p>',
                'category' => 'Web Development',
                'tags' => ['Mobile', 'JavaScript', 'Performance'],
                'published' => true,
                'published_at' => now()->subHours(6),
                'views' => 89,
            ],
        ];

        foreach ($posts as $postData) {
            $category = Category::where('name', $postData['category'])->first();
            $tagNames = $postData['tags'];
            
            $post = Post::firstOrCreate(
                ['slug' => Str::slug($postData['title'])],
                [
                    'title' => $postData['title'],
                    'slug' => Str::slug($postData['title']),
                    'excerpt' => $postData['excerpt'],
                    'content' => $postData['content'],
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'published' => $postData['published'],
                    'published_at' => $postData['published_at'],
                    'views' => $postData['views'],
                ]
            );

            // Attach tags
            $tags = Tag::whereIn('name', $tagNames)->pluck('id');
            $post->tags()->sync($tags);
        }

        $this->command->info('Blog data seeded successfully!');
    }
}
