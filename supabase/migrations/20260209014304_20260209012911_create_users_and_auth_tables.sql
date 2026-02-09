/*
  # Create users and authentication tables

  1. New Tables
    - `users`
      - `id` (bigint, primary key, auto-increment)
      - `name` (text)
      - `email` (text, unique)
      - `email_verified_at` (timestamptz, nullable)
      - `password` (text)
      - `remember_token` (text, nullable)
      - `role` (text, default 'user')
      - `refresh_token` (text, nullable)
      - `phone` (text, nullable)
      - `avatar` (text, nullable)
      - `bio` (text, nullable)
      - `phone_verified_at` (timestamptz, nullable)
      - `created_at` (timestamptz, default now)
      - `updated_at` (timestamptz, default now)
    
    - `password_reset_tokens`
      - `email` (text, primary key)
      - `token` (text)
      - `created_at` (timestamptz, nullable)
    
    - `sessions`
      - `id` (text, primary key)
      - `user_id` (bigint, nullable, foreign key to users)
      - `ip_address` (text, nullable)
      - `user_agent` (text, nullable)
      - `payload` (text)
      - `last_activity` (bigint)

  2. Security
    - Enable RLS on `users` table
    - Add policies for authenticated users to read their own data
    - Add policies for admins to manage users
    - Password reset tokens are public for reset functionality
    - Sessions are managed by the application
*/

-- Create users table
CREATE TABLE IF NOT EXISTS users (
  id bigserial PRIMARY KEY,
  name text NOT NULL,
  email text UNIQUE NOT NULL,
  email_verified_at timestamptz,
  password text NOT NULL,
  remember_token text,
  role text DEFAULT 'user' NOT NULL,
  refresh_token text,
  phone text,
  avatar text,
  bio text,
  phone_verified_at timestamptz,
  created_at timestamptz DEFAULT now() NOT NULL,
  updated_at timestamptz DEFAULT now() NOT NULL
);

-- Create password reset tokens table
CREATE TABLE IF NOT EXISTS password_reset_tokens (
  email text PRIMARY KEY,
  token text NOT NULL,
  created_at timestamptz
);

-- Create sessions table
CREATE TABLE IF NOT EXISTS sessions (
  id text PRIMARY KEY,
  user_id bigint REFERENCES users(id) ON DELETE CASCADE,
  ip_address text,
  user_agent text,
  payload text NOT NULL,
  last_activity bigint NOT NULL
);

-- Create index on sessions
CREATE INDEX IF NOT EXISTS sessions_user_id_idx ON sessions(user_id);
CREATE INDEX IF NOT EXISTS sessions_last_activity_idx ON sessions(last_activity);

-- Enable RLS
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE password_reset_tokens ENABLE ROW LEVEL SECURITY;
ALTER TABLE sessions ENABLE ROW LEVEL SECURITY;

-- RLS Policies for users
CREATE POLICY "Users can view own profile"
  ON users FOR SELECT
  TO authenticated
  USING (id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can update own profile"
  ON users FOR UPDATE
  TO authenticated
  USING (id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint)
  WITH CHECK (id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Admins can view all users"
  ON users FOR SELECT
  TO authenticated
  USING ((current_setting('request.jwt.claims', true)::json->>'role')::text = 'admin');

CREATE POLICY "Admins can update all users"
  ON users FOR UPDATE
  TO authenticated
  USING ((current_setting('request.jwt.claims', true)::json->>'role')::text = 'admin')
  WITH CHECK ((current_setting('request.jwt.claims', true)::json->>'role')::text = 'admin');

CREATE POLICY "Admins can delete users"
  ON users FOR DELETE
  TO authenticated
  USING ((current_setting('request.jwt.claims', true)::json->>'role')::text = 'admin');

-- RLS Policies for password_reset_tokens (public for reset functionality)
CREATE POLICY "Anyone can create password reset tokens"
  ON password_reset_tokens FOR INSERT
  TO anon, authenticated
  WITH CHECK (true);

CREATE POLICY "Anyone can read password reset tokens"
  ON password_reset_tokens FOR SELECT
  TO anon, authenticated
  USING (true);

CREATE POLICY "Anyone can delete password reset tokens"
  ON password_reset_tokens FOR DELETE
  TO anon, authenticated
  USING (true);

-- RLS Policies for sessions
CREATE POLICY "Users can view own sessions"
  ON sessions FOR SELECT
  TO authenticated
  USING (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can insert own sessions"
  ON sessions FOR INSERT
  TO authenticated
  WITH CHECK (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can update own sessions"
  ON sessions FOR UPDATE
  TO authenticated
  USING (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint)
  WITH CHECK (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);

CREATE POLICY "Users can delete own sessions"
  ON sessions FOR DELETE
  TO authenticated
  USING (user_id = (current_setting('request.jwt.claims', true)::json->>'sub')::bigint);