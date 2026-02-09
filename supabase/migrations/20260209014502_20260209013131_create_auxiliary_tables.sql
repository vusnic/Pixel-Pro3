/*
  # Create auxiliary tables (tokens, cache, jobs, device_tokens)

  1. New Tables
    - `personal_access_tokens`
      - `id` (bigint, primary key, auto-increment)
      - `tokenable_type` (text)
      - `tokenable_id` (bigint)
      - `name` (text)
      - `token` (text, unique)
      - `abilities` (text, nullable)
      - `last_used_at` (timestamptz, nullable)
      - `expires_at` (timestamptz, nullable)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)
    
    - `cache`
      - `key` (text, primary key)
      - `value` (text)
      - `expiration` (integer)
    
    - `cache_locks`
      - `key` (text, primary key)
      - `owner` (text)
      - `expiration` (integer)
    
    - `jobs`
      - `id` (bigint, primary key, auto-increment)
      - `queue` (text)
      - `payload` (text)
      - `attempts` (smallint)
      - `reserved_at` (integer, nullable)
      - `available_at` (integer)
      - `created_at` (integer)
    
    - `job_batches`
      - `id` (text, primary key)
      - `name` (text)
      - `total_jobs` (integer)
      - `pending_jobs` (integer)
      - `failed_jobs` (integer)
      - `failed_job_ids` (text)
      - `options` (text, nullable)
      - `cancelled_at` (integer, nullable)
      - `created_at` (integer)
      - `finished_at` (integer, nullable)
    
    - `failed_jobs`
      - `id` (bigint, primary key, auto-increment)
      - `uuid` (text, unique)
      - `connection` (text)
      - `queue` (text)
      - `payload` (text)
      - `exception` (text)
      - `failed_at` (timestamptz, default now)
    
    - `device_tokens`
      - `id` (bigint, primary key, auto-increment)
      - `user_id` (bigint, foreign key to users)
      - `token` (text, unique)
      - `device_type` (text, nullable)
      - `device_name` (text, nullable)
      - `is_active` (boolean, default true)
      - `last_used_at` (timestamptz, nullable)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)

  2. Security
    - Enable RLS on all tables
    - Add appropriate policies for each table
*/

-- Create personal_access_tokens table
CREATE TABLE IF NOT EXISTS personal_access_tokens (
  id bigserial PRIMARY KEY,
  tokenable_type text NOT NULL,
  tokenable_id bigint NOT NULL,
  name text NOT NULL,
  token text UNIQUE NOT NULL,
  abilities text,
  last_used_at timestamptz,
  expires_at timestamptz,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create cache table
CREATE TABLE IF NOT EXISTS cache (
  key text PRIMARY KEY,
  value text NOT NULL,
  expiration integer NOT NULL
);

-- Create cache_locks table
CREATE TABLE IF NOT EXISTS cache_locks (
  key text PRIMARY KEY,
  owner text NOT NULL,
  expiration integer NOT NULL
);

-- Create jobs table
CREATE TABLE IF NOT EXISTS jobs (
  id bigserial PRIMARY KEY,
  queue text NOT NULL,
  payload text NOT NULL,
  attempts smallint NOT NULL,
  reserved_at integer,
  available_at integer NOT NULL,
  created_at integer NOT NULL
);

-- Create job_batches table
CREATE TABLE IF NOT EXISTS job_batches (
  id text PRIMARY KEY,
  name text NOT NULL,
  total_jobs integer NOT NULL,
  pending_jobs integer NOT NULL,
  failed_jobs integer NOT NULL,
  failed_job_ids text NOT NULL,
  options text,
  cancelled_at integer,
  created_at integer NOT NULL,
  finished_at integer
);

-- Create failed_jobs table
CREATE TABLE IF NOT EXISTS failed_jobs (
  id bigserial PRIMARY KEY,
  uuid text UNIQUE NOT NULL,
  connection text NOT NULL,
  queue text NOT NULL,
  payload text NOT NULL,
  exception text NOT NULL,
  failed_at timestamptz DEFAULT now() NOT NULL
);

-- Create device_tokens table
CREATE TABLE IF NOT EXISTS device_tokens (
  id bigserial PRIMARY KEY,
  user_id bigint REFERENCES users(id) ON DELETE CASCADE NOT NULL,
  token text UNIQUE NOT NULL,
  device_type text,
  device_name text,
  is_active boolean DEFAULT true NOT NULL,
  last_used_at timestamptz,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create indexes
CREATE INDEX IF NOT EXISTS personal_access_tokens_tokenable_idx ON personal_access_tokens(tokenable_type, tokenable_id);
CREATE INDEX IF NOT EXISTS personal_access_tokens_token_idx ON personal_access_tokens(token);
CREATE INDEX IF NOT EXISTS jobs_queue_idx ON jobs(queue);
CREATE INDEX IF NOT EXISTS device_tokens_user_id_idx ON device_tokens(user_id);
CREATE INDEX IF NOT EXISTS device_tokens_token_idx ON device_tokens(token);
CREATE INDEX IF NOT EXISTS device_tokens_is_active_idx ON device_tokens(is_active);

-- Enable RLS
ALTER TABLE personal_access_tokens ENABLE ROW LEVEL SECURITY;
ALTER TABLE cache ENABLE ROW LEVEL SECURITY;
ALTER TABLE cache_locks ENABLE ROW LEVEL SECURITY;
ALTER TABLE jobs ENABLE ROW LEVEL SECURITY;
ALTER TABLE job_batches ENABLE ROW LEVEL SECURITY;
ALTER TABLE failed_jobs ENABLE ROW LEVEL SECURITY;
ALTER TABLE device_tokens ENABLE ROW LEVEL SECURITY;

-- RLS Policies for personal_access_tokens
CREATE POLICY "Users can view own tokens"
  ON personal_access_tokens FOR SELECT
  TO authenticated
  USING (tokenable_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can insert own tokens"
  ON personal_access_tokens FOR INSERT
  TO authenticated
  WITH CHECK (tokenable_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can delete own tokens"
  ON personal_access_tokens FOR DELETE
  TO authenticated
  USING (tokenable_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

-- RLS Policies for cache (system managed)
CREATE POLICY "Authenticated users can access cache"
  ON cache FOR ALL
  TO authenticated
  USING (true)
  WITH CHECK (true);

-- RLS Policies for cache_locks (system managed)
CREATE POLICY "Authenticated users can access cache locks"
  ON cache_locks FOR ALL
  TO authenticated
  USING (true)
  WITH CHECK (true);

-- RLS Policies for jobs (system managed)
CREATE POLICY "Authenticated users can access jobs"
  ON jobs FOR ALL
  TO authenticated
  USING (true)
  WITH CHECK (true);

-- RLS Policies for job_batches (system managed)
CREATE POLICY "Authenticated users can access job batches"
  ON job_batches FOR ALL
  TO authenticated
  USING (true)
  WITH CHECK (true);

-- RLS Policies for failed_jobs (system managed)
CREATE POLICY "Authenticated users can access failed jobs"
  ON failed_jobs FOR ALL
  TO authenticated
  USING (true)
  WITH CHECK (true);

-- RLS Policies for device_tokens
CREATE POLICY "Users can view own device tokens"
  ON device_tokens FOR SELECT
  TO authenticated
  USING (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can insert own device tokens"
  ON device_tokens FOR INSERT
  TO authenticated
  WITH CHECK (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can update own device tokens"
  ON device_tokens FOR UPDATE
  TO authenticated
  USING (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint)
  WITH CHECK (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can delete own device tokens"
  ON device_tokens FOR DELETE
  TO authenticated
  USING (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);