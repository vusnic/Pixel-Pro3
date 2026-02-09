/*
  # Create contracts tables

  1. New Tables
    - `contract_templates`
      - `id` (bigint, primary key, auto-increment)
      - `name` (text)
      - `description` (text, nullable)
      - `file_path` (text)
      - `placeholders` (jsonb, nullable)
      - `is_active` (boolean, default true)
      - `created_by` (bigint, foreign key to users, nullable)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)
    
    - `contracts`
      - `id` (bigint, primary key, auto-increment)
      - `template_id` (bigint, foreign key to contract_templates)
      - `name` (text)
      - `client_name` (text)
      - `client_address` (text)
      - `service_type` (text)
      - `project_description` (text)
      - `start_date` (date)
      - `delivery_date` (date)
      - `total_value` (numeric)
      - `payment_method` (text)
      - `payment_terms` (text)
      - `warranty` (text)
      - `sales_rep_name` (text)
      - `form_data` (jsonb, nullable)
      - `file_path` (text, nullable)
      - `file_type` (text, default 'docx')
      - `created_by` (bigint, foreign key to users)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)

  2. Security
    - Enable RLS on both tables
    - Add policies for authenticated users to manage templates and contracts
*/

-- Create contract_templates table
CREATE TABLE IF NOT EXISTS contract_templates (
  id bigserial PRIMARY KEY,
  name text NOT NULL,
  description text,
  file_path text NOT NULL,
  placeholders jsonb,
  is_active boolean DEFAULT true NOT NULL,
  created_by bigint REFERENCES users(id) ON DELETE SET NULL,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create contracts table
CREATE TABLE IF NOT EXISTS contracts (
  id bigserial PRIMARY KEY,
  template_id bigint REFERENCES contract_templates(id) ON DELETE RESTRICT NOT NULL,
  name text NOT NULL,
  client_name text NOT NULL,
  client_address text NOT NULL,
  service_type text NOT NULL,
  project_description text NOT NULL,
  start_date date NOT NULL,
  delivery_date date NOT NULL,
  total_value numeric(10, 2) NOT NULL,
  payment_method text NOT NULL,
  payment_terms text NOT NULL,
  warranty text NOT NULL,
  sales_rep_name text NOT NULL,
  form_data jsonb,
  file_path text,
  file_type text DEFAULT 'docx' NOT NULL,
  created_by bigint REFERENCES users(id) ON DELETE RESTRICT NOT NULL,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create indexes
CREATE INDEX IF NOT EXISTS contract_templates_is_active_idx ON contract_templates(is_active);
CREATE INDEX IF NOT EXISTS contract_templates_created_by_idx ON contract_templates(created_by);
CREATE INDEX IF NOT EXISTS contracts_template_id_idx ON contracts(template_id);
CREATE INDEX IF NOT EXISTS contracts_created_by_idx ON contracts(created_by);
CREATE INDEX IF NOT EXISTS contracts_client_name_idx ON contracts(client_name);
CREATE INDEX IF NOT EXISTS contracts_created_at_idx ON contracts(created_at DESC);

-- Enable RLS
ALTER TABLE contract_templates ENABLE ROW LEVEL SECURITY;
ALTER TABLE contracts ENABLE ROW LEVEL SECURITY;

-- RLS Policies for contract_templates
CREATE POLICY "Authenticated users can view active templates"
  ON contract_templates FOR SELECT
  TO authenticated
  USING (is_active = true);

CREATE POLICY "Authenticated users can view all templates"
  ON contract_templates FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Authenticated users can insert templates"
  ON contract_templates FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update templates"
  ON contract_templates FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete templates"
  ON contract_templates FOR DELETE
  TO authenticated
  USING (true);

-- RLS Policies for contracts
CREATE POLICY "Authenticated users can view own contracts"
  ON contracts FOR SELECT
  TO authenticated
  USING (created_by = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Authenticated users can view all contracts"
  ON contracts FOR SELECT
  TO authenticated
  USING (true);

CREATE POLICY "Authenticated users can insert contracts"
  ON contracts FOR INSERT
  TO authenticated
  WITH CHECK (true);

CREATE POLICY "Authenticated users can update contracts"
  ON contracts FOR UPDATE
  TO authenticated
  USING (true)
  WITH CHECK (true);

CREATE POLICY "Authenticated users can delete contracts"
  ON contracts FOR DELETE
  TO authenticated
  USING (true);