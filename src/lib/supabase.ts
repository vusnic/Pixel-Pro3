import { createClient } from '@supabase/supabase-js';

const supabaseUrl = import.meta.env.VITE_SUPABASE_URL;
const supabaseAnonKey = import.meta.env.VITE_SUPABASE_ANON_KEY;

if (!supabaseUrl || !supabaseAnonKey) {
  throw new Error('Missing Supabase environment variables');
}

export const supabase = createClient(supabaseUrl, supabaseAnonKey);

export type Lead = {
  id: string;
  name: string;
  email: string;
  phone?: string;
  message?: string;
  source?: string;
  status: string;
  created_at: string;
};

export type Portfolio = {
  id: string;
  title: string;
  description: string;
  image_url?: string;
  category?: string;
  client?: string;
  project_url?: string;
  highlights?: string[];
  is_featured: boolean;
  display_order: number;
  created_at: string;
};

export type Service = {
  id: string;
  title: string;
  description: string;
  icon?: string;
  price_from?: number;
  features?: string[];
  is_featured: boolean;
  display_order: number;
  created_at: string;
};

export type Post = {
  id: string;
  title: string;
  slug: string;
  content: string;
  excerpt?: string;
  featured_image?: string;
  author_id: string;
  category_id?: string;
  status: string;
  published_at?: string;
  created_at: string;
};

export type Category = {
  id: string;
  name: string;
  slug: string;
  description?: string;
};
