/*
  # Create leads table

  1. New Tables
    - `leads`
      - `id` (bigint, primary key, auto-increment)
      - `name` (text)
      - `email` (text)
      - `phone` (text, nullable)
      - `country_code` (text, default '+1')
      - `website` (text, nullable)
      - `message` (text, nullable)
      - `source` (text, default 'website')
      - `status` (text, default 'new')
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)

  2. Security
    - Enable RLS on `leads` table
    - Add policy for public to create leads (contact forms)
    - Add policy for authenticated admins to manage leads
*/

-- Create leads table
CREATE TABLE IF NOT EXISTS leads (
  id bigserial PRIMARY KEY,
  name text NOT NULL,
  email text NOT NULL,
  phone text,
  country_code text DEFAULT '+1' NOT NULL,
  website text,
  message text,
  source text DEFAULT 'website' NOT NULL,
  status text DEFAULT 'new' NOT NULL,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create indexes
CREATE INDEX IF NOT EXISTS leads_status_idx ON leads(status);
CREATE INDEX IF NOT EXISTS leads_created_at_idx ON leads(created_at DESC);
CREATE INDEX IF NOT EXISTS leads_email_idx ON leads(email);

-- Enable RLS
ALTER TABLE leads ENABLE ROW LEVEL SECURITY;

-- RLS Policies
CREATE POLICY "Anyone can create leads"
  ON leads FOR INSERT
  TO anon, authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can view all leads"
  ON leads FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Authenticated users can update leads"
  ON leads FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete leads"
  ON leads FOR DELETE
  TO authenticated
  USING (true);