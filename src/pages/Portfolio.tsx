import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { supabase, type Portfolio } from '../lib/supabase';

export default function PortfolioPage() {
  const [portfolio, setPortfolio] = useState<Portfolio[]>([]);
  const [loading, setLoading] = useState(true);
  const [filter, setFilter] = useState<string>('all');
  const [categories, setCategories] = useState<string[]>([]);

  useEffect(() => {
    loadPortfolio();
  }, []);

  const loadPortfolio = async () => {
    setLoading(true);
    try {
      const { data, error } = await supabase
        .from('portfolios')
        .select('*')
        .order('display_order');

      if (error) throw error;

      if (data) {
        setPortfolio(data);
        const uniqueCategories = Array.from(
          new Set(data.map(p => p.category).filter(Boolean))
        ) as string[];
        setCategories(uniqueCategories);
      }
    } catch (error) {
      console.error('Error loading portfolio:', error);
    } finally {
      setLoading(false);
    }
  };

  const filteredPortfolio = filter === 'all'
    ? portfolio
    : portfolio.filter(p => p.category === filter);

  return (
    <div className="bg-white">
      <section className="py-20 bg-gradient-to-br from-blue-50 to-indigo-100">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <h1 className="text-5xl font-bold text-gray-900 mb-4">
              Our Portfolio
            </h1>
            <p className="text-xl text-gray-600">
              Explore our latest projects and success stories
            </p>
          </div>
        </div>
      </section>

      <section className="py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          {categories.length > 0 && (
            <div className="flex flex-wrap justify-center gap-4 mb-12">
              <button
                onClick={() => setFilter('all')}
                className={`px-6 py-2 rounded-full font-semibold transition-colors ${
                  filter === 'all'
                    ? 'bg-blue-600 text-white'
                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                }`}
              >
                All
              </button>
              {categories.map((category) => (
                <button
                  key={category}
                  onClick={() => setFilter(category)}
                  className={`px-6 py-2 rounded-full font-semibold transition-colors ${
                    filter === category
                      ? 'bg-blue-600 text-white'
                      : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                  }`}
                >
                  {category}
                </button>
              ))}
            </div>
          )}

          {loading ? (
            <div className="text-center py-12">
              <div className="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
          ) : filteredPortfolio.length === 0 ? (
            <div className="text-center py-12">
              <p className="text-gray-600 text-lg">No projects found.</p>
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {filteredPortfolio.map((project) => (
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
                  <div className="mt-4">
                    <p className="text-gray-600 line-clamp-2">{project.description}</p>
                  </div>
                </Link>
              ))}
            </div>
          )}
        </div>
      </section>
    </div>
  );
}
