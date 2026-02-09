import { Link } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { supabase, type Portfolio, type Service } from '../lib/supabase';

export default function Home() {
  const [featuredPortfolio, setFeaturedPortfolio] = useState<Portfolio[]>([]);
  const [featuredServices, setFeaturedServices] = useState<Service[]>([]);

  useEffect(() => {
    loadFeaturedItems();
  }, []);

  const loadFeaturedItems = async () => {
    const { data: portfolioData } = await supabase
      .from('portfolios')
      .select('*')
      .eq('is_featured', true)
      .order('display_order')
      .limit(3);

    const { data: servicesData } = await supabase
      .from('services')
      .select('*')
      .eq('is_featured', true)
      .order('display_order')
      .limit(3);

    if (portfolioData) setFeaturedPortfolio(portfolioData);
    if (servicesData) setFeaturedServices(servicesData);
  };

  return (
    <div className="bg-white">
      <section className="relative bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                Transform Your Digital Presence
              </h1>
              <p className="text-xl text-gray-600 mb-8">
                We help businesses grow with cutting-edge digital marketing strategies,
                stunning web design, and powerful development solutions.
              </p>
              <div className="flex flex-col sm:flex-row gap-4">
                <Link
                  to="/contact"
                  className="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors text-center font-semibold"
                >
                  Get Started
                </Link>
                <Link
                  to="/portfolio"
                  className="bg-white text-blue-600 px-8 py-3 rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition-colors text-center font-semibold"
                >
                  View Our Work
                </Link>
              </div>
            </div>
            <div className="hidden lg:block">
              <img
                src="/img/section-1/section-1-middle.png"
                alt="Digital Marketing"
                className="w-full h-auto rounded-lg shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">
              Why Choose PixelPro3?
            </h2>
            <p className="text-xl text-gray-600">
              We deliver results that matter
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="text-center p-6">
              <div className="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg className="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">Fast Delivery</h3>
              <p className="text-gray-600">
                Quick turnaround times without compromising on quality
              </p>
            </div>

            <div className="text-center p-6">
              <div className="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg className="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">Proven Results</h3>
              <p className="text-gray-600">
                Track record of successful projects and satisfied clients
              </p>
            </div>

            <div className="text-center p-6">
              <div className="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg className="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </div>
              <h3 className="text-xl font-bold text-gray-900 mb-2">Expert Team</h3>
              <p className="text-gray-600">
                Experienced professionals dedicated to your success
              </p>
            </div>
          </div>
        </div>
      </section>

      {featuredServices.length > 0 && (
        <section className="py-20 bg-gray-50">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-16">
              <h2 className="text-4xl font-bold text-gray-900 mb-4">
                Our Services
              </h2>
              <p className="text-xl text-gray-600">
                Comprehensive solutions for your digital needs
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {featuredServices.map((service) => (
                <div
                  key={service.id}
                  className="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition-shadow"
                >
                  <h3 className="text-2xl font-bold text-gray-900 mb-4">
                    {service.title}
                  </h3>
                  <p className="text-gray-600 mb-6">
                    {service.description}
                  </p>
                  {service.features && service.features.length > 0 && (
                    <ul className="space-y-2 mb-6">
                      {service.features.slice(0, 3).map((feature, idx) => (
                        <li key={idx} className="flex items-start">
                          <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                          </svg>
                          <span className="text-gray-700">{feature}</span>
                        </li>
                      ))}
                    </ul>
                  )}
                  <Link
                    to={`/services/${service.id}`}
                    className="text-blue-600 hover:text-blue-700 font-semibold"
                  >
                    Learn More →
                  </Link>
                </div>
              ))}
            </div>

            <div className="text-center mt-12">
              <Link
                to="/services"
                className="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold"
              >
                View All Services
              </Link>
            </div>
          </div>
        </section>
      )}

      {featuredPortfolio.length > 0 && (
        <section className="py-20 bg-white">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-16">
              <h2 className="text-4xl font-bold text-gray-900 mb-4">
                Featured Projects
              </h2>
              <p className="text-xl text-gray-600">
                Check out some of our recent work
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {featuredPortfolio.map((project) => (
                <Link
                  key={project.id}
                  to={`/portfolio/${project.id}`}
                  className="group"
                >
                  <div className="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    <img
                      src={project.image_url || '/img/abstract1.jpg'}
                      alt={project.title}
                      className="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                      <div className="p-6 text-white">
                        <h3 className="text-xl font-bold mb-2">{project.title}</h3>
                        {project.category && (
                          <p className="text-sm text-gray-200">{project.category}</p>
                        )}
                      </div>
                    </div>
                  </div>
                </Link>
              ))}
            </div>

            <div className="text-center mt-12">
              <Link
                to="/portfolio"
                className="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold"
              >
                View All Projects
              </Link>
            </div>
          </div>
        </section>
      )}

      <section className="py-20 bg-gradient-to-br from-blue-600 to-indigo-700 text-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-4xl font-bold mb-6">
            Ready to Get Started?
          </h2>
          <p className="text-xl mb-8 text-blue-100">
            Let's discuss how we can help grow your business
          </p>
          <Link
            to="/contact"
            className="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors font-semibold"
          >
            Contact Us Today
          </Link>
        </div>
      </section>
    </div>
  );
}
