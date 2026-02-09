import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { supabase, type Portfolio } from '../lib/supabase';

export default function PortfolioDetail() {
  const { id } = useParams<{ id: string }>();
  const [project, setProject] = useState<Portfolio | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (id) {
      loadProject(id);
    }
  }, [id]);

  const loadProject = async (projectId: string) => {
    setLoading(true);
    try {
      const { data, error } = await supabase
        .from('portfolios')
        .select('*')
        .eq('id', projectId)
        .single();

      if (error) throw error;
      setProject(data);
    } catch (error) {
      console.error('Error loading project:', error);
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

  if (!project) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-4xl font-bold text-gray-900 mb-4">Project Not Found</h1>
          <Link to="/portfolio" className="text-blue-600 hover:text-blue-700">
            Back to Portfolio
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="bg-white">
      <section className="py-12 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <Link to="/portfolio" className="text-blue-600 hover:text-blue-700 inline-flex items-center mb-6">
            <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Portfolio
          </Link>

          <h1 className="text-5xl font-bold text-gray-900 mb-4">{project.title}</h1>
          {project.category && (
            <p className="text-xl text-gray-600 mb-8">{project.category}</p>
          )}
        </div>
      </section>

      <section className="py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div className="lg:col-span-2">
              <img
                src={project.image_url || '/img/abstract1.jpg'}
                alt={project.title}
                className="w-full h-auto rounded-lg shadow-xl mb-8"
              />

              <div className="prose max-w-none">
                <h2 className="text-3xl font-bold text-gray-900 mb-4">About This Project</h2>
                <p className="text-gray-700 text-lg leading-relaxed whitespace-pre-line">
                  {project.description}
                </p>
              </div>

              {project.highlights && project.highlights.length > 0 && (
                <div className="mt-8">
                  <h3 className="text-2xl font-bold text-gray-900 mb-4">Key Highlights</h3>
                  <ul className="space-y-3">
                    {project.highlights.map((highlight, idx) => (
                      <li key={idx} className="flex items-start">
                        <svg className="w-6 h-6 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                        </svg>
                        <span className="text-gray-700">{highlight}</span>
                      </li>
                    ))}
                  </ul>
                </div>
              )}
            </div>

            <div className="lg:col-span-1">
              <div className="bg-gray-50 rounded-lg p-6 sticky top-24">
                <h3 className="text-2xl font-bold text-gray-900 mb-6">Project Details</h3>

                {project.client && (
                  <div className="mb-6">
                    <h4 className="text-sm font-semibold text-gray-500 uppercase mb-2">Client</h4>
                    <p className="text-gray-900">{project.client}</p>
                  </div>
                )}

                {project.category && (
                  <div className="mb-6">
                    <h4 className="text-sm font-semibold text-gray-500 uppercase mb-2">Category</h4>
                    <p className="text-gray-900">{project.category}</p>
                  </div>
                )}

                {project.project_url && (
                  <div className="mb-6">
                    <h4 className="text-sm font-semibold text-gray-500 uppercase mb-2">Website</h4>
                    <a
                      href={project.project_url}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="text-blue-600 hover:text-blue-700 break-all"
                    >
                      {project.project_url}
                    </a>
                  </div>
                )}

                <div className="mt-8 pt-6 border-t border-gray-200">
                  <Link
                    to="/contact"
                    className="block w-full bg-blue-600 text-white text-center px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold"
                  >
                    Start Your Project
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
