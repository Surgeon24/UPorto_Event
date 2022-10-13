-- The citext module provides a case-insensitive character string type. 
-- Essentially, it internally calls lower when comparing values.
-- https://www.postgresql.org/docs/current/citext.html
CREATE EXTENSION IF NOT EXISTS citext;

-- Lets us create UUIDs, instead of SERIAL ids
-- https://www.geeksforgeeks.org/postgresql-uuid-data-type/
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

DROP TABLE IF EXISTS registered_users;
create table registered_users(
	user_id uuid DEFAULT uuid_generate_v4 () PRIMARY KEY,
	name VARCHAR default 'name' NOT NULL,
	surename VARCHAR default 'family name' NOT NULL,
	nickname VARCHAR UNIQUE NOT NULL,
	password text default sha256('default_password') NOT NULL,
	email citext UNIQUE NOT NULL,
	birth_date date default(current_date - INTERVAL '18 YEAR') NOT NULL,
	date_registered TIMESTAMP default current_timestamp NOT NULL,
	last_seen TIMESTAMP,
	url text UNIQUE,
	status text,
	is_admin BOOLEAN DEFAULT false NOT NULL	
);
