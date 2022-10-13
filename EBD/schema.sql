-- The citext module provides a case-insensitive character string type. 
-- Essentially, it internally calls lower when comparing values.
-- https://www.postgresql.org/docs/current/citext.html
CREATE EXTENSION IF NOT EXISTS citext;

create table registered_users(
	id SERIAL PRIMARY KEY,
	name VARCHAR default 'name' NOT NULL,
	surename VARCHAR default 'family name' NOT NULL,
	nickname VARCHAR UNIQUE NOT NULL,
	password text default sha256('default_password') NOT NULL,
	email citext UNIQUE NOT NULL,
	dateRegistered TIMESTAMP default current_timestamp NOT NULL,
	lastSeem TIMESTAMP,
	url text UNIQUE,
	isAdmin BOOLEAN DEFAULT false NOT NULL	
);
