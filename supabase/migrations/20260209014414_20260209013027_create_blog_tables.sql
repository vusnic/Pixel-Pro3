/*
  # Create blog tables (categories, tags, posts, post_tag)

  1. New Tables
    - `categories`
      - `id` (bigint, primary key, auto-increment)
      - `name` (text)
      - `slug` (text, unique)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)
    
    - `tags`
      - `id` (bigint, primary key, auto-increment)
      - `name` (text)
      - `slug` (text, unique)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)
    
    - `posts`
      - `id` (bigint, primary key, auto-increment)
      - `title` (text)
      - `slug` (text, unique)
      - `excerpt` (text, nullable)
      - `content` (text)
      - `cover_image` (text, nullable)
      - `meta_title` (text, nullable)
      - `meta_description` (text, nullable)
      - `user_id` (bigint, foreign key to users)
      - `category_id` (bigint, foreign key to categories)
      - `published` (boolean, default false)
      - `published_at` (timestamptz, nullable)
      - `views` (integer, default 0)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)
    
    - `post_tag`
      - `id` (bigint, primary key, auto-increment)
      - `post_id` (bigint, foreign key to posts)
      - `tag_id` (bigint, foreign key to tags)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)

  2. Security
    - Enable RLS on all tables
    - Add policies for public to read published posts
    - Add policies for authenticated users to manage content
*/

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
  id bigserial PRIMARY KEY,
  name text NOT NULL,
  slug text UNIQUE NOT NULL,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create tags table
CREATE TABLE IF NOT EXISTS tags (
  id bigserial PRIMARY KEY,
  name text NOT NULL,
  slug text UNIQUE NOT NULL,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create posts table
CREATE TABLE IF NOT EXISTS posts (
  id bigserial PRIMARY KEY,
  title text NOT NULL,
  slug text UNIQUE NOT NULL,
  excerpt text,
  content text NOT NULL,
  cover_image text,
  meta_title text,
  meta_description text,
  user_id bigint REFERENCES users(id) ON DELETE CASCADE NOT NULL,
  category_id bigint REFERENCES categories(id) ON DELETE CASCADE NOT NULL,
  published boolean DEFAULT false NOT NULL,
  published_at timestamptz,
  views integer DEFAULT 0 NOT NULL,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create post_tag table
CREATE TABLE IF NOT EXISTS post_tag (
  id bigserial PRIMARY KEY,
  post_id bigint REFERENCES posts(id) ON DELETE CASCADE NOT NULL,
  tag_id bigint REFERENCES tags(id) ON DELETE CASCADE NOT NULL,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL,
  UNIQUE(post_id, tag_id)
);

-- Create indexes
CREATE INDEX IF NOT EXISTS categories_slug_idx ON categories(slug);
CREATE INDEX IF NOT EXISTS tags_slug_idx ON tags(slug);
CREATE INDEX IF NOT EXISTS posts_slug_idx ON posts(slug);
CREATE INDEX IF NOT EXISTS posts_published_published_at_idx ON posts(published, published_at);
CREATE INDEX IF NOT EXISTS posts_category_id_published_idx ON posts(category_id, published);
CREATE INDEX IF NOT EXISTS posts_user_id_idx ON posts(user_id);
CREATE INDEX IF NOT EXISTS post_tag_post_id_idx ON post_tag(post_id);
CREATE INDEX IF NOT EXISTS post_tag_tag_id_idx ON post_tag(tag_id);

-- Enable RLS
ALTER TABLE categories ENABLE ROW LEVEL SECURITY;
ALTER TABLE tags ENABLE ROW LEVEL SECURITY;
ALTER TABLE posts ENABLE ROW LEVEL SECURITY;
ALTER TABLE post_tag ENABLE ROW LEVEL SECURITY;

-- RLS Policies for categories
CREATE POLICY "Anyone can view categories"
  ON categories FOR SELECT
  TO anon, authenticated
  USING (true);

CREATE POLICY "Authenticated users can insert categories"
  ON categories FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update categories"
  ON categories FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete categories"
  ON categories FOR DELETE
  TO authenticated
  USING (true);

-- RLS Policies for tags
CREATE POLICY "Anyone can view tags"
  ON tags FOR SELECT
  TO anon, authenticated
  USING (true);

CREATE POLICY "Authenticated users can insert tags"
  ON tags FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update tags"
  ON tags FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete tags"
  ON tags FOR DELETE
  TO authenticated
  USING (true);

-- RLS Policies for posts
CREATE POLICY "Anyone can view published posts"
  ON posts FOR SELECT
  TO anon, authenticated
  USING (published = true);

CREATE POLICY "Authenticated users can view all posts"
  ON posts FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Authenticated users can insert posts"
  ON posts FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update posts"
  ON posts FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete posts"
  ON posts FOR DELETE
  TO authenticated
  USING (true);

-- RLS Policies for post_tag
CREATE POLICY "Anyone can view post tags"
  ON post_tag FOR SELECT
  TO anon, authenticated
  USING (true);

CREATE POLICY "Authenticated users can insert post tags"
  ON post_tag FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete post tags"
  ON post_tag FOR DELETE
  TO authenticated
  USING (true);