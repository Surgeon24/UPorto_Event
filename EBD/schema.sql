-- in order to import the file, in Query Tool click the left-most icon 
-- 'open file' (alt+O), choose the file and execute

-- The citext module provides a case-insensitive character string type. 
-- Essentially, it internally calls lower when comparing values.
-- https://www.postgresql.org/docs/current/citext.html
CREATE EXTENSION IF NOT EXISTS citext;

-- Lets us create UUIDs, instead of SERIAL ids
-- https://www.geeksforgeeks.org/postgresql-uuid-data-type/
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Q - questions to the teacher

drop table if exists notification;
drop table IF EXISTS event_photo;
drop table IF EXISTS user_photo;

--!!! I should do the right order of dropping/creating

DROP TABLE IF EXISTS event;

DROP TABLE IF EXISTS registered_users;
create table registered_users(
	-- Q uuid - do we need it, is it ok?
	user_id uuid DEFAULT uuid_generate_v4 () PRIMARY KEY,
	name VARCHAR default 'name' NOT NULL,
	surename VARCHAR default 'family name' NOT NULL,
	nickname VARCHAR UNIQUE NOT NULL,
	password text default sha256('default_password') NOT NULL,
	email citext UNIQUE NOT NULL,
	birth_date date default (current_date - INTERVAL '18 YEAR') CHECK (birth_date <= (current_date - INTERVAL '18 YEAR')),
	date_registered TIMESTAMP default current_timestamp NOT NULL,
	-- Q last log in. Good?
	last_seen TIMESTAMP,
	url text UNIQUE,
	status text,
	is_admin BOOLEAN DEFAULT false NOT NULL	
);


DROP TABLE IF EXISTS event;
create table event(
	event_id SERIAL PRIMARY KEY,
	event_name VARCHAR default 'default name' NOT NULL,
	-- default (to_char(CURRENT_TIMESTAMP, 'DD Mon YYYY HH24:MI')) NEED TO CHOOSE - CONSULT WITH TEACHER
	-- not sure about date format
	event_date TIMESTAMP default (to_timestamp('05 Dec 2023 22:00', 'DD Mon YYYY HH24:MI')) NOT NULL,
	-- only registered users can go
	participant_id uuid,  -- FOREIGN KEY? taken from registered_users table
	creator_id uuid UNIQUE,  -- FOREIGN KEY? taken from registered_users table
	description text default('FEUP party') NOT NULL,
	is_public BOOLEAN,	  -- not sure of what it does
	
	FOREIGN KEY (participant_id) REFERENCES registered_users (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE,
	FOREIGN KEY (creator_id) REFERENCES registered_users (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE
	
);


drop table if exists poll;
create table poll(
	title text default 'title' NOT NULL,
	host_name text default 'host name?' NOT NULL,
	question text DEFAULT 'questions?' NOT NULL,
	starts_at TIMESTAMP default (CURRENT_TIMESTAMP) NOT NULL,
	end_at TIMESTAMP default (CURRENT_TIMESTAMP + INTERVAL '1 DAY') NOT NULL
);


drop table if exists location;

create table location(
	name text default 'Adega Leonor' NOT NULL
);



drop table if exists rating;
CREATE TABLE rating(
	comment_id SERIAL,
	publish_date TIMESTAMP default current_timestamp check(publish_date <= CURRENT_TIMESTAMP) NOT NULL,
	-- rating from 1 to 5 stars
	rate integer check(rate > 0 AND rate <= 5) NOT NULL,
	description text DEFAULT null
);



DROP TYPE IF EXISTS notification_type;
CREATE TYPE notification_type AS ENUM ('Reminder', 'Report', 'Comment');

CREATE TABLE notification(
	notification_id SERIAL PRIMARY KEY,
	user_id uuid,
	description text,
	notification_date timestamp default current_timestamp,
	type notification_type,

	FOREIGN KEY (user_id) REFERENCES registered_users (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE
);





-- Q should we have two table for event and user photos each?



create table user_photo(
	user_photo_id SERIAL,
	file bytea,
	added_on timestamp default current_timestamp,
	added_by uuid,

	-- Q should we have 'image_path' row?
	
	FOREIGN KEY (added_by) REFERENCES registered_users (user_id)
																		ON DELETE CASCADE
																		ON UPDATE CASCADE
	);




create table event_photo(
	event_photo_id SERIAL,
	file bytea,
	added_on timestamp default current_timestamp,
	-- creator
	added_by uuid,

	FOREIGN KEY (added_by) REFERENCES event (creator_id)
									ON DELETE CASCADE
									ON UPDATE CASCADE
);
