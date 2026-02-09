import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { supabase, type Service } from '../lib/supabase';

export default function ServiceDetail() {
  const { id } = useParams<{ id: string }>();
  const [service, setService] = useState<Service | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (id) {
      loadService(id);
    }
  }, [id]);

  const loadService = async (serviceId: string) => {
    setLoading(true);
    try {
      const { data, error } = await supabase
        .from('services')
        .select('*')
        .eq('id', serviceId)
        .single();

      if (error) throw error;
      setService(data);
    } catch (error) {
      console.error('Error loading service:', error);
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    );
  }

  if (!service) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-4xl font-bold text-gray-900 mb-4">Service Not Found</h1>
          <Link to="/services" className="text-blue-600 hover:text-blue-700">
            Back to Services
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="bg-white">
      <section className="py-12 bg-gradient-to-br from-blue-50 to-indigo-100">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <Link to="/services" className="text-blue-600 hover:text-blue-700 inline-flex items-center mb-6">
            <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Services
          </Link>

          <div className="flex items-center mb-4">
            {service.icon && <span className="text-5xl mr-4">{service.icon}</span>}
            <h1 className="text-5xl font-bold text-gray-900">{service.title}</h1>
          </div>
          {service.price_from && (
            <p className="text-2xl text-gray-600">
              Starting from <span className="font-bold text-blue-600">${service.price_from}</span>
            </p>
          )}
        </div>
      </section>

      <section className="py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div className="lg:col-span-2">
              <div className="prose max-w-none">
                <h2 className="text-3xl font-bold text-gray-900 mb-4">About This Service</h2>
                <p className="text-gray-700 text-lg leading-relaxed whitespace-pre-line">
                  {service.description}
                </p>
              </div>

              {service.features && service.features.length > 0 && (
                <div className="mt-8">
                  <h3 className="text-2xl font-bold text-gray-900 mb-6">What's Included</h3>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {service.features.map((feature, idx) => (
                      <div key={idx} className="flex items-start p-4 bg-gray-50 rounded-lg">
                        <svg className="w-6 h-6 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                        </svg>
                        <span className="text-gray-700">{feature}</span>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              <div className="mt-12 bg-blue-50 rounded-lg p-8">
                <h3 className="text-2xl font-bold text-gray-900 mb-4">How It Works</h3>
                <div className="space-y-6">
                  <div className="flex items-start">
                    <div className="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                      1
                    </div>
                    <div>
                      <h4 className="font-bold text-gray-900 mb-1">Consultation</h4>
                      <p className="text-gray-600">We discuss your needs and goals to create a tailored solution</p>
                    </div>
                  </div>
                  <div className="flex items-start">
                    <div className="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                      2
                    </div>
                    <div>
                      <h4 className="font-bold text-gray-900 mb-1">Strategy & Planning</h4>
                      <p className="text-gray-600">We develop a comprehensive plan and timeline for your project</p>
                    </div>
                  </div>
                  <div className="flex items-start">
                    <div className="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                      3
                    </div>
                    <div>
                      <h4 className="font-bold text-gray-900 mb-1">Implementation</h4>
                      <p className="text-gray-600">Our team executes the plan with regular updates and checkpoints</p>
                    </div>
                  </div>
                  <div className="flex items-start">
                    <div className="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                      4
                    </div>
                    <div>
                      <h4 className="font-bold text-gray-900 mb-1">Launch & Support</h4>
                      <p className="text-gray-600">We launch your project and provide ongoing support and optimization</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="lg:col-span-1">
              <div className="bg-gray-50 rounded-lg p-6 sticky top-24">
                <h3 className="text-2xl font-bold text-gray-900 mb-6">Get Started Today</h3>
                <p className="text-gray-600 mb-6">
                  Ready to take your business to the next level? Contact us for a free consultation.
                </p>

                <Link
                  to="/contact"
                  className="block w-full bg-blue-600 text-white text-center px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold mb-4"
                >
                  Request a Quote
                </Link>

                <div className="border-t border-gray-200 pt-6 mt-6">
                  <h4 className="font-semibold text-gray-900 mb-3">Why Choose Us?</h4>
                  <ul className="space-y-2 text-sm text-gray-600">
                    <li className="flex items-start">
                      <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                      </svg>
                      Expert team with years of experience
                    </li>
                    <li className="flex items-start">
                      <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                      </svg>
                      Proven track record of success
                    </li>
                    <li className="flex items-start">
                      <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                      </svg>
                      Dedicated support and maintenance
                    </li>
                    <li className="flex items-start">
                      <svg className="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                      </svg>
                      Competitive pricing
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
