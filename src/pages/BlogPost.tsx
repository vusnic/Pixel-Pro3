import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { supabase, type Post } from '../lib/supabase';

export default function BlogPost() {
  const { slug } = useParams<{ slug: string }>();
  const [post, setPost] = useState<Post | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (slug) {
      loadPost(slug);
    }
  }, [slug]);

  const loadPost = async (postSlug: string) => {
    setLoading(true);
    try {
      const { data, error } = await supabase
        .from('posts')
        .select('*')
        .eq('slug', postSlug)
        .eq('status', 'published')
        .single();

      if (error) throw error;
      setPost(data);
    } catch (error) {
      console.error('Error loading post:', error);
    } finally {
      setLoading(false);
    }
  };

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
    );
  }

  if (!post) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-4xl font-bold text-gray-900 mb-4">Post Not Found</h1>
          <Link to="/blog" className="text-blue-600 hover:text-blue-700">
            Back to Blog
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="bg-white">
      <article className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <Link to="/blog" className="text-blue-600 hover:text-blue-700 inline-flex items-center mb-8">
          <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Back to Blog
        </Link>

        {post.published_at && (
          <p className="text-gray-500 mb-4">
            {formatDate(post.published_at)}
          </p>
        )}

        <h1 className="text-5xl font-bold text-gray-900 mb-8">
          {post.title}
        </h1>

        {post.featured_image && (
          <img
            src={post.featured_image}
            alt={post.title}
            className="w-full h-96 object-cover rounded-lg mb-8 shadow-xl"
          />
        )}

        {post.excerpt && (
          <p className="text-xl text-gray-600 mb-8 leading-relaxed font-medium">
            {post.excerpt}
          </p>
        )}

        <div className="prose prose-lg max-w-none">
          <div
            className="text-gray-700 leading-relaxed whitespace-pre-line"
            dangerouslySetInnerHTML={{ __html: post.content }}
          />
        </div>

        <div className="mt-12 pt-8 border-t border-gray-200">
          <Link
            to="/blog"
            className="text-blue-600 hover:text-blue-700 font-semibold"
          >
            ← Back to all posts
          </Link>
        </div>
      </article>

      <section className="py-12 bg-gray-50">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-gray-900 mb-4">
            Interested in our services?
          </h2>
          <p className="text-xl text-gray-600 mb-8">
            Let's discuss how we can help your business grow
          </p>
          <Link
            to="/contact"
            className="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold"
          >
            Contact Us
          </Link>
        </div>
      </section>
    </div>
  );
}
