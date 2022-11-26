-----------------------------------------
-- DROPPING TABLES
-----------------------------------------
-- CASCADE Automatically drop objects that depend on the table
create schema if not exists lbaw22122;

set search_path=lbaw22122;

DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS authorized_user CASCADE;
DROP TABLE IF EXISTS administrator CASCADE;
DROP TABLE IF EXISTS event CASCADE;
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS user_event CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS photo CASCADE;
DROP TABLE IF EXISTS poll CASCADE;
DROP TABLE IF EXISTS poll_choice CASCADE;
DROP TABLE IF EXISTS poll_vote CASCADE;
DROP TABLE IF EXISTS event_notification CASCADE;
DROP TABLE IF EXISTS comment_notification CASCADE;
DROP TABLE IF EXISTS poll_notification CASCADE;
DROP TABLE IF EXISTS report_notification CASCADE;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS comment_votes CASCADE;

-----------------------------------------
-- TYPES
-----------------------------------------
drop type if exists REPORT_TYPE;
CREATE TYPE REPORT_TYPE AS ENUM('Spam', 'Nudity or sexual activity', 'Hate speech or symbols', 'Violence or dangerous organisations', 'Bullying or harassment', 'Selling illegal or regulated goods', 'Scams or fraud', 'False information', 'Other');

drop type if exists REPORT_STATUS;
CREATE TYPE REPORT_STATUS AS ENUM('Waiting', 'Ignored', 'Sanctioned');

drop type if exists MEMBER_ROLE;
CREATE TYPE MEMBER_ROLE AS ENUM('Owner', 'Moderator', 'Participant');


drop type if exists TYPE_NOTIFICATION;
CREATE TYPE TYPE_NOTIFICATION AS ENUM('comment', 'event', 'poll', 'report');

drop type if exists "comment_vote" CASCADE;
CREATE TYPE "comment_vote" AS ENUM ('like', 'dislike');

-----------------------------------------
-- TABLES
-----------------------------------------

/*

CREATE TABLE IF NOT EXISTS authorized_user(
ID SERIAL PRIMARY KEY,
username TEXT UNIQUE NOT NULL,
firstname TEXT DEFAULT 'Válter Ochôa de Spínola Catanho' NOT NULL,
lastname TEXT DEFAULT 'Castro' NOT NULL,
password TEXT DEFAULT sha256('DEFAULT_password') NOT NULL,
email TEXT UNIQUE NOT NULL,
date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
birth_date DATE DEFAULT (current_date - INTERVAL '18 YEAR') CHECK (
birth_date <= (current_date - INTERVAL '18 YEAR')
),
url TEXT UNIQUE,
status TEXT,
is_admin BOOLEAN DEFAULT false NOT NULL,
photo_path TEXT
);



CREATE TABLE IF NOT EXISTS administrator(
id SERIAL PRIMARY KEY,
admin_id INTEGER,
FOREIGN KEY (admin_id) REFERENCES authorized_user(id)
);

*/

CREATE TABLE IF NOT EXISTS event(
id SERIAL PRIMARY KEY,
title TEXT DEFAULT 'Adega Leonor Party' NOT NULL,
description TEXT DEFAULT('FEUP party') NOT NULL,
start_date TIMESTAMP DEFAULT (
to_timestamp('05 Dec 2023 22:00', 'DD Mon YYYY HH24:MI')
) NOT NULL,
is_public BOOLEAN DEFAULT TRUE NOT NULL,
location TEXT DEFAULT 'Adega Leonor' NOT NULL
);

/*
CREATE TABLE IF NOT EXISTS report(
id SERIAL PRIMARY KEY,
reported_id INT,
reporter_id INT,
admin_id INT,
report_text TEXT NOT NULL,
report_date TIMESTAMP DEFAULT (CURRENT_TIMESTAMP),
report_type REPORT_TYPE,
report_status REPORT_STATUS,
FOREIGN KEY (reported_id) REFERENCES authorized_user(id),
FOREIGN KEY (reporter_id) REFERENCES authorized_user(id),
FOREIGN KEY (admin_id) REFERENCES administrator(id)
);



CREATE TABLE IF NOT EXISTS user_event(
id SERIAL PRIMARY KEY,
user_id INT,
event_id INT,  
role MEMBER_ROLE,
accepted BOOLEAN,   -- used only in private events
UNIQUE (user_id, event_id),  -- combination of user_id and event_id is UNIQUE because user can be registered at the event only once
FOREIGN KEY (user_id) REFERENCES authorized_user(id),
FOREIGN KEY (event_id) REFERENCES event(id)
);
*/

CREATE TABLE users (
id SERIAL PRIMARY KEY,
photo_path TEXT,
name VARCHAR NOT NULL,
email VARCHAR UNIQUE NOT NULL,
password VARCHAR NOT NULL,
remember_token VARCHAR
);
-- word "comments" was used because "comment" is a reserved word in PostgreSQL 
-- inspirations: https://stackoverflow.com/questions/55074867/posts-comments-replies-and-likes-database-schema
CREATE TABLE IF NOT EXISTS comments(
id SERIAL PRIMARY KEY,
comment_text TEXT DEFAULT ('Great event!'),
user_id INT,
event_id INT,
--parent_comment_id INT DEFAULT NULL, -- null if a new comment and comment_id of the parent if a reply
comment_date DATE DEFAULT (current_date) CHECK (comment_date <= current_date),
--FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),     -- double reference 
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (event_id) REFERENCES event(id)
);

CREATE TABLE IF NOT EXISTS comment_votes(
    id SERIAL PRIMARY KEY,
    user_id INTEGER, 
    comment_id INTEGER,
    type comment_vote NOT NULL DEFAULT ('like'),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (comment_id) REFERENCES comments(id) 
);


/*

CREATE TABLE IF NOT EXISTS tag(
id SERIAL PRIMARY KEY,
name TEXT NOT NULL,
color TEXT NOT NULL,
event_id INT,
FOREIGN KEY (event_id) REFERENCES event(id)
);


CREATE TABLE IF NOT EXISTS photo(
id SERIAL PRIMARY KEY,
upload_date DATE DEFAULT (current_date),
image_path TEXT UNIQUE,
event_id INT,
FOREIGN KEY (event_id) REFERENCES event(id)
);


CREATE TABLE IF NOT EXISTS poll(
id SERIAL PRIMARY KEY,
event_id INT NOT NULL,
question TEXT DEFAULT('What is your favorite programming language?') NOT NULL,
starts_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP check(starts_at <= CURRENT_TIMESTAMP) NOT NULL,
end_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL '1 DAY') check(end_at > starts_at) NOT NULL,
FOREIGN KEY (event_id) REFERENCES event(id)
);


CREATE TABLE IF NOT EXISTS poll_choice(
id SERIAL PRIMARY KEY,
poll_id INT,
choice TEXT NOT NULL,
UNIQUE(poll_id, id),
FOREIGN KEY (poll_id) REFERENCES poll(id)
);


CREATE TABLE IF NOT EXISTS poll_vote(
id SERIAL PRIMARY KEY,
user_id INT,
event_id INT,
poll_id INT,
choice_id INT,
date TIMESTAMP DEFAULT(CURRENT_TIMESTAMP) NOT NULL,
UNIQUE(poll_id, user_id),
UNIQUE(choice_id, poll_id),
FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),     -- double reference 
FOREIGN KEY (choice_id, poll_id) REFERENCES poll_choice(id, poll_id)           -- double reference
);


CREATE TABLE IF NOT EXISTS notification(
id SERIAL PRIMARY KEY,
user_id INT,
notification_type type_notification NOT NULL,
notification_title TEXT NOT NULL DEFAULT ('Main topic of the notification (header)'),
body TEXT,  -- is not supposed to be filled for all types of notifications
notification_date DATE NOT NULL DEFAULT (current_date) CHECK (notification_date <= current_date),
FOREIGN KEY (user_id) REFERENCES authorized_user(id)
);


CREATE TABLE IF NOT EXISTS comment_notification(
id      INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE,
comment INTEGER NOT NULL REFERENCES comments (id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS poll_notification
(
id      INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE,
poll 		INTEGER NOT NULL REFERENCES poll (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS event_notification
(
id      INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE,
event 	INTEGER NOT NULL REFERENCES event (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS report_notification
(
id     INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE,
report INTEGER NOT NULL REFERENCES report (id) ON DELETE CASCADE
);

-----------------------------------------
-- TRIGGERS
-----------------------------------------

-- Trigger to create a notification when a comment is replied 

CREATE OR REPLACE FUNCTION comment_notification() RETURNS trigger AS 
$BODY$

DECLARE reply_username TEXT = (
SELECT username FROM authorized_user WHERE id = NEW.user_id
);

DECLARE parent_id INT = (
select user_id from comments where NEW.parent_comment_id = id
);

DECLARE parent_username TEXT = (
select username from authorized_user where id = parent_id
);

DECLARE title_text TEXT = (
select concat(reply_username, ' replied to your comment!')
);

BEGIN
IF (NEW.parent_comment_id IS NOT NULL)
THEN
WITH INSERTED AS (
INSERT INTO 
notification(notification_title,notification_date, notification_type, user_id, body)
VALUES(title_text, CURRENT_TIMESTAMP, 'comment', parent_id, NEW.comment_text)
RETURNING id)
INSERT INTO 
comment_notification(id, comment)
select inserted.id, NEW.id from inserted;
RETURN new; 
END IF;

END;
$BODY$
language plpgsql;



DROP TRIGGER IF EXISTS trig_comment ON comments;

CREATE TRIGGER trig_comment
AFTER INSERT OR UPDATE ON comments
FOR EACH ROW
EXECUTE PROCEDURE comment_notification();


-- trigger that welcomes new users after they join an event
CREATE OR REPLACE FUNCTION event_join_notification() RETURNS trigger AS 
$BODY$

DECLARE new_username TEXT = (
select username from authorized_user where id = NEW.user_id
);

DECLARE event_name TEXT = (
select title from event where id = NEW.event_id
);

DECLARE welcome_title TEXT = (
select concat(event_name ,' Event joined!')
);

DECLARE welcome_body TEXT = (
select concat('Welcome, ', new_username, ' ! You have just joined ', event_name, ' !')
);

BEGIN
WITH INSERTED AS (
INSERT INTO 
notification(user_id,notification_type,notification_title, body,  notification_date)
VALUES(NEW.user_id, 'event', welcome_title ,welcome_body ,CURRENT_TIMESTAMP)
RETURNING id)
INSERT INTO event_notification(id, event)
select inserted.id, NEW.event_id from inserted;
RETURN new;
END;
$BODY$
language plpgsql;

DROP TRIGGER IF EXISTS trig_event_join ON user_event;

CREATE TRIGGER trig_event_join
AFTER INSERT OR UPDATE ON user_event
FOR EACH ROW
EXECUTE PROCEDURE event_join_notification();


*/

INSERT INTO users VALUES (
DEFAULT,
'/image.png',
'John Doe',
'admin@example.com',
'$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'
); -- Password is 1234. Generated using Hash::make('1234')

INSERT INTO event VALUES (
DEFAULT,
'FEUP CAFE',
'Convivio entre estudantes da FEUP',
'05 Dec 2023 22:00',
true,
'AEFEUP'
);

INSERT INTO event VALUES (
DEFAULT,
'Jantar Curso LEIC',
'Convivio entre estudantes do LEIC',
'07 Jan 2023 22:30',
true,
'Um sitio fixe'
);  

INSERT INTO comments VALUES (
DEFAULT,
DEFAULT,
1,
1,
DEFAULT
);

INSERT INTO comments VALUES (
DEFAULT,
DEFAULT,
1,
1,
DEFAULT
);