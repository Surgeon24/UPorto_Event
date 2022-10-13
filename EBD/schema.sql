-- -- The citext module provides a case-insensitive character string type. 
-- -- Essentially, it internally calls lower when comparing values.
-- -- https://www.postgresql.org/docs/current/citext.html
-- CREATE EXTENSION IF NOT EXISTS citext;

-- -- Lets us create UUIDs, instead of SERIAL ids
-- -- https://www.geeksforgeeks.org/postgresql-uuid-data-type/
-- CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- DROP TABLE IF EXISTS registered_users;
-- create table registered_users(
-- 	user_id uuid DEFAULT uuid_generate_v4 () PRIMARY KEY,
-- 	name VARCHAR default 'name' NOT NULL,
-- 	surename VARCHAR default 'family name' NOT NULL,
-- 	nickname VARCHAR UNIQUE NOT NULL,
-- 	password text default sha256('default_password') NOT NULL,
-- 	email citext UNIQUE NOT NULL,
-- 	birth_date date default (current_date - INTERVAL '18 YEAR') CHECK (birth_date <= (current_date - INTERVAL '18 YEAR')),
-- 	date_registered TIMESTAMP default current_timestamp NOT NULL,
-- 	last_seen TIMESTAMP,
-- 	url text UNIQUE,
-- 	status text,
-- 	is_admin BOOLEAN DEFAULT false NOT NULL	
-- );


DROP TABLE IF EXISTS event;
create table event(
	event_id SERIAL PRIMARY KEY,
	event_name VARCHAR default 'default name' NOT NULL,
	-- default (to_char(CURRENT_TIMESTAMP, 'DD Mon YYYY HH24:MI')) NEED TO CHOOSE - CONSULT WITH TEACHER
	-- not sure about date format
	event_date TIMESTAMP default (to_timestamp('05 Dec 2023 22:00', 'DD Mon YYYY HH24:MI')) NOT NULL,
	-- only registered users can go
	participant_id uuid,  -- FOREIGN KEY? taken from registered_users table
	creator_id uuid,      -- FOREIGN KEY? taken from registered_users table
	description text default('FEUP party') NOT NULL,
	is_public BOOLEAN,	  -- not sure of what it does
	
	FOREIGN KEY (participant_id) REFERENCES registered_users (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE,
	FOREIGN KEY (creator_id) REFERENCES registered_users (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE
	
);