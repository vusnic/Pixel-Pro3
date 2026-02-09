/*
  # Create portfolios and services tables

  1. New Tables
    - `portfolios`
      - `id` (bigint, primary key, auto-increment)
      - `title` (text)
      - `description` (text)
      - `image_path` (text, nullable)
      - `category` (text, default 'web')
      - `technologies` (text, nullable)
      - `client_name` (text, nullable)
      - `project_url` (text, nullable)
      - `completion_date` (date, nullable)
      - `highlights` (text, nullable)
      - `order` (integer, default 0)
      - `featured` (boolean, default false)
      - `status` (text, default 'published')
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)
    
    - `services`
      - `id` (bigint, primary key, auto-increment)
      - `title` (text)
      - `short_description` (text)
      - `description` (text)
      - `price` (numeric, nullable)
      - `price_period` (text, nullable)
      - `image_path` (text, nullable)
      - `highlights` (jsonb, nullable)
      - `order` (integer, default 0)
      - `featured` (boolean, default false)
      - `status` (text, default 'draft')
      - `cta_text` (text, nullable)
      - `cta_url` (text, nullable)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)

  2. Security
    - Enable RLS on both tables
    - Add policies for public to read published items
    - Add policies for authenticated admins to manage items
*/

-- Create portfolios table
CREATE TABLE IF NOT EXISTS portfolios (
  id bigserial PRIMARY KEY,
  title text NOT NULL,
  description text NOT NULL,
  image_path text,
  category text DEFAULT 'web' NOT NULL,
  technologies text,
  client_name text,
  project_url text,
  completion_date date,
  highlights text,
  "order" integer DEFAULT 0 NOT NULL,
  featured boolean DEFAULT false NOT NULL,
  status text DEFAULT 'published' NOT NULL,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create services table
CREATE TABLE IF NOT EXISTS services (
  id bigserial PRIMARY KEY,
  title text NOT NULL,
  short_description text NOT NULL,
  description text NOT NULL,
  price numeric(10, 2),
  price_period text,
  image_path text,
  highlights jsonb,
  "order" integer DEFAULT 0 NOT NULL,
  featured boolean DEFAULT false NOT NULL,
  status text DEFAULT 'draft' NOT NULL,
  cta_text text,
  cta_url text,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create indexes
CREATE INDEX IF NOT EXISTS portfolios_status_idx ON portfolios(status);
CREATE INDEX IF NOT EXISTS portfolios_category_idx ON portfolios(category);
CREATE INDEX IF NOT EXISTS portfolios_featured_idx ON portfolios(featured);
CREATE INDEX IF NOT EXISTS portfolios_order_idx ON portfolios("order");

CREATE INDEX IF NOT EXISTS services_status_idx ON services(status);
CREATE INDEX IF NOT EXISTS services_featured_idx ON services(featured);
CREATE INDEX IF NOT EXISTS services_order_idx ON services("order");

-- Enable RLS
ALTER TABLE portfolios ENABLE ROW LEVEL SECURITY;
ALTER TABLE services ENABLE ROW LEVEL SECURITY;

-- RLS Policies for portfolios
CREATE POLICY "Anyone can view published portfolios"
  ON portfolios FOR SELECT
  TO anon, authenticated
  USING (status = 'published');

CREATE POLICY "Authenticated users can view all portfolios"
  ON portfolios FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Authenticated users can insert portfolios"
  ON portfolios FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update portfolios"
  ON portfolios FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete portfolios"
  ON portfolios FOR DELETE
  TO authenticated
  USING (true);

-- RLS Policies for services
CREATE POLICY "Anyone can view published services"
  ON services FOR SELECT
  TO anon, authenticated
  USING (status = 'published');

CREATE POLICY "Authenticated users can view all services"
  ON services FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Authenticated users can insert services"
  ON services FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update services"
  ON services FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete services"
  ON services FOR DELETE
  TO authenticated
  USING (true);