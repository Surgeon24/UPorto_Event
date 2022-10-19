-- in order to import the file, in Query Tool click the left-most icon 
-- 'open file' (alt+O), choose the file and execute

-- The citext module provides a case-insensitive character string type. 
-- Essentially, it internally calls lower when comparing values.
-- https://www.postgresql.org/docs/current/citext.html
CREATE EXTENSION IF NOT EXISTS citext;

-- Lets us create UUIDs, instead of SERIAL ids
-- https://www.geeksforgeeks.org/postgresql-uuid-data-type/
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

--!!! I should do the right order of dropping/creating
drop table if exists poll_vote;
drop table if exists poll;
drop table if exists comment;
drop table if exists notification;
drop table IF EXISTS event_photo;
drop table IF EXISTS user_photo;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS registered_users;
DROP TABLE IF EXISTS guests;

-- Q - questions to the teacher

-- Q - ask about the quize


create table IF NOT EXISTS guests(
	id_guest SERIAL,
	ip text NOT NULL
);


create table IF NOT EXISTS registered_users(
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




create table IF NOT EXISTS event(
	event_id SERIAL PRIMARY KEY,
	event_name VARCHAR default 'default name' NOT NULL,
	-- Q default (to_char(CURRENT_TIMESTAMP, 'DD Mon YYYY HH24:MI')) NEED TO CHOOSE - CONSULT WITH TEACHER
	-- Q not sure about date format
	event_date TIMESTAMP default (to_timestamp('05 Dec 2023 22:00', 'DD Mon YYYY HH24:MI')) NOT NULL,
	participant_id uuid UNIQUE,  -- only registered users can go
	creator_id uuid UNIQUE, 
	location text default 'Adega Leonor' NOT NULL,

	-- might delete undecided
	tag text default '#',
	-- might delete undecided

	description text default('FEUP party') NOT NULL,
	is_public BOOLEAN DEFAULT True NOT NULL,	  -- not sure of what it does
	
	FOREIGN KEY (participant_id) REFERENCES registered_users (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE,
	FOREIGN KEY (creator_id) REFERENCES registered_users (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE
	
);


drop table if exists event_status;
-- table where we store 'Going', 'Maybe', 'Can't answers from participants.
-- Q is there a better way to do it?
drop type if exists status;
-- Q how to write can't?
create type status as enum ('Going', 'Maybe', 'Cant');

create table IF NOT EXISTS event_status(
	participant_id uuid,
	s status default 'Maybe'
);


-- Q is it a rule to have id in every table?
create table IF NOT EXISTS poll(
	poll_id SERIAL,
	event_id int,
	title text default 'title' NOT NULL,
	host_name text default 'host name?' NOT NULL,
	question text DEFAULT 'questions?' NOT NULL,
	-- check that poll doesn't start in the past
	starts_at TIMESTAMP default CURRENT_TIMESTAMP check(starts_at <= CURRENT_TIMESTAMP) NOT NULL,


	-- Q How to do something like   default (starts_at + INTERVAL '1 DAY')?
	end_at TIMESTAMP default (CURRENT_TIMESTAMP + INTERVAL '1 DAY') check(end_at > starts_at) NOT NULL,


	FOREIGN KEY (event_id) REFERENCES event (event_id)
							ON DELETE CASCADE
							ON UPDATE CASCADE
);



-- Q not sure what are we doing here
create table IF NOT EXISTS poll_vote(
	option text
);



-- Q can I use the word `comment` if it's a special word in PostgreSQL?
CREATE TABLE comment(
	comment_id SERIAL,
	event_id int,
	author_id uuid NOT NULL,
	-- unable to publish yesturday
	publish_date TIMESTAMP default current_timestamp check(publish_date <= CURRENT_TIMESTAMP) NOT NULL,
	description text DEFAULT 'your comment here' NOT NULL,

	FOREIGN KEY (event_id) REFERENCES event (event_id)
								ON DELETE CASCADE
								ON UPDATE CASCADE,

	FOREIGN KEY (author_id) REFERENCES event (participant_id)
								ON DELETE CASCADE
								ON UPDATE CASCADE
);


-- Q good idea for notigication type?

DROP TYPE IF EXISTS notification_type;
CREATE TYPE notification_type AS ENUM ('Reminder', 'Report', 'Comment');

CREATE TABLE IF NOT EXISTS notification(
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

-- Q maybe bytea for registered_user and talbe for event?

-- Q should I add automatic trigger that would add empty photo row when user is registered?  

create table IF NOT EXISTS user_photo(
	user_photo_id SERIAL,
	file bytea,
	added_on timestamp default current_timestamp,
	added_by uuid,

	-- Q should we have 'image_path' UNIQUE row?
	
	FOREIGN KEY (added_by) REFERENCES registered_users (user_id)
											ON DELETE CASCADE
											ON UPDATE CASCADE
	);




create table IF NOT EXISTS event_photo(
	event_photo_id SERIAL,
	file bytea,
	added_on timestamp default current_timestamp,
	-- creator
	added_by uuid,

	FOREIGN KEY (added_by) REFERENCES event (creator_id)
									ON DELETE CASCADE
									ON UPDATE CASCADE
);
