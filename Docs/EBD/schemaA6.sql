-----------------------------------------
-- EXTENSIONS
-----------------------------------------

-- The citext module provides a case-insensitive character string type. 
-- Essentially, it internally calls lower when comparing values.
-- https://www.postgresql.org/docs/current/citext.html
CREATE EXTENSION IF NOT EXISTS citext;
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
CREATE EXTENSION IF NOT EXISTS btree_gist;


-----------------------------------------
-- DROPPING TABLES
-----------------------------------------
-- CASCADE Automatically drop objects that depend on the table
DROP TABLE IF EXISTS authorized_user CASCADE;
DROP TABLE IF EXISTS administrator CASCADE;
DROP TABLE IF EXISTS event CASCADE;
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS user_event CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS photo CASCADE;
DROP TABLE IF EXISTS poll CASCADE;
DROP TABLE IF EXISTS poll_option CASCADE;
DROP TABLE IF EXISTS poll_vote CASCADE;


-----------------------------------------
-- TYPES
-----------------------------------------
drop type if exists REPORT_TYPE;
CREATE TYPE REPORT_TYPE AS ENUM('Spam', 'Nudity or sexual activity', 'Hate speech or symbols', 'Violence or dangerous organisations', 'Bullying or harassment', 'Selling illegal or regulated goods', 'Scams or fraud', 'False information');

drop type if exists REPORT_STATUS;
CREATE TYPE REPORT_STATUS AS ENUM('Waiting', 'Ignored', 'Sanctioned');

drop type if exists MEMBER_ROLE;
CREATE TYPE MEMBER_ROLE AS ENUM('Owner', 'Moderator', 'Participant');


drop type if exists TYPE_NOTIFICATION;
CREATE TYPE TYPE_NOTIFICATION AS ENUM('comment', 'event', 'poll', 'report');


-----------------------------------------
-- TABLES
-----------------------------------------

CREATE TABLE IF NOT EXISTS authorized_user(
    ID uuid DEFAULT uuid_generate_v4 () PRIMARY KEY,
    name TEXT DEFAULT 'name' NOT NULL,
    surname TEXT DEFAULT 'family name' NOT NULL,
    nickname TEXT UNIQUE NOT NULL,
    password TEXT DEFAULT sha256('DEFAULT_password') NOT NULL,
    email citext UNIQUE NOT NULL,
    date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    last_seen TIMESTAMP,
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
    admin_id uuid,
    FOREIGN KEY (admin_id) REFERENCES authorized_user(id)
);



CREATE TABLE IF NOT EXISTS event(
    id SERIAL PRIMARY KEY,
    name TEXT DEFAULT 'DEFAULT name' NOT NULL,
    description TEXT DEFAULT('FEUP party') NOT NULL,
    start_date TIMESTAMP DEFAULT (
        to_timestamp('05 Dec 2023 22:00', 'DD Mon YYYY HH24:MI')
    ) NOT NULL,
    is_public BOOLEAN DEFAULT TRUE NOT NULL,
    location TEXT DEFAULT 'Adega Leonor' NOT NULL
);


CREATE TABLE IF NOT EXISTS report(
    id SERIAL PRIMARY KEY,
    reported_id uuid,
    reporter_id uuid,
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
    user_id uuid,
    event_id INT,  
    role MEMBER_ROLE,
    accepted BOOLEAN,   -- used only in private events
    UNIQUE (user_id, event_id),  -- combination of user_id and event_id is UNIQUE because user can be registered at the event only once
    FOREIGN KEY (user_id) REFERENCES authorized_user(id),
    FOREIGN KEY (event_id) REFERENCES event(id)
);


-- word "comments" was used because "comment" is a reserved word in PostgreSQL 
-- inspirations: https://stackoverflow.com/questions/55074867/posts-comments-replies-and-likes-database-schema
CREATE TABLE IF NOT EXISTS comments(
    id SERIAL PRIMARY KEY,
    comment_text TEXT DEFAULT ('Great event!'),
    user_id uuid,
    event_id INT,
    parent_comment_id INT DEFAULT NULL, -- null if a new comment and comment_id of the parent if a reply
    comment_date DATE DEFAULT (current_date) CHECK (comment_date <= current_date),
        FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),     -- double reference 
        FOREIGN KEY (parent_comment_id) REFERENCES comments(id)
);


CREATE TABLE IF NOT EXISTS notification(
    id SERIAL PRIMARY KEY,
        user_id uuid,
        notification_type type_notification NOT NULL,
    notification_text TEXT NOT NULL DEFAULT ('text'),
    notification_date DATE NOT NULL DEFAULT (current_date) CHECK (notification_date <= current_date),
    FOREIGN KEY (user_id) REFERENCES authorized_user(id)
);


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
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    starts_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP check(starts_at <= CURRENT_TIMESTAMP) NOT NULL,
    end_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL '1 DAY') check(end_at > starts_at) NOT NULL,
    event_id INT,
    FOREIGN KEY (event_id) REFERENCES event(id)
);


CREATE TABLE IF NOT EXISTS poll_option(
    id SERIAL PRIMARY KEY,
    option TEXT NOT NULL,
    poll_id INT,
    FOREIGN KEY (poll_id) REFERENCES poll(id)
);


CREATE TABLE IF NOT EXISTS poll_vote(
        id SERIAL PRIMARY KEY,
    poll_id INT,
    user_id uuid,
        event_id INT,
    option_id INT,
    date DATE NOT NULL,
    FOREIGN KEY (poll_id) REFERENCES poll(id),
    FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),     -- double reference 
    FOREIGN KEY (option_id) REFERENCES poll_option(id)
);

-----------------------------------------
-- TRIGGERS
-----------------------------------------

CREATE OR REPLACE FUNCTION comment_notification() RETURNS trigger AS $comment_notification$
        BEGIN
        IF (NEW.parent_comment_id IS NOT NULL)
            THEN
                INSERT INTO 
                    notification(notification_text,notification_date, notification_type, user_id)
                    select NEW.comment_text, NEW.comment_date, 'comment' ,user_id from comments where NEW.parent_comment_id = id;
        END IF;
        RETURN new;
END;
$comment_notification$
language plpgsql;
                
DROP TRIGGER IF EXISTS trig_comment ON public.comments;

CREATE TRIGGER trig_comment
     AFTER INSERT OR UPDATE ON comments
     FOR EACH ROW
     EXECUTE PROCEDURE comment_notification();
         
         
         
         
CREATE OR REPLACE FUNCTION event_notification() RETURNS trigger AS $event_notification$
        BEGIN
               INSERT INTO 
                notification(notification_text,notification_date, notification_type, user_id)
                VALUES('You have just joined new event, welcome!', CURRENT_TIMESTAMP, 'event', NEW.user_id);
        RETURN new;

END;
$event_notification$
language plpgsql;
                
DROP TRIGGER IF EXISTS trig_event ON public.user_event;

CREATE TRIGGER trig_event
     AFTER INSERT OR UPDATE ON user_event
     FOR EACH ROW
     EXECUTE PROCEDURE event_notification();
         
         
         
CREATE OR REPLACE FUNCTION poll_notification() RETURNS trigger AS $poll_notification$
        BEGIN
            INSERT INTO 
                notification(notification_date, notification_type, user_id, notification_text)
                select NEW.starts_at, 'poll', NEW.user_id, 'New poll was created. ' || NEW.title || ' You can vote!' from poll;
    RETURN new;
END;
$poll_notification$
language plpgsql;
                
DROP TRIGGER IF EXISTS trig_poll ON public.poll;

CREATE TRIGGER trig_poll
     AFTER INSERT ON poll
     FOR EACH ROW
     EXECUTE PROCEDURE poll_notification();




CREATE OR REPLACE FUNCTION report_notification() RETURNS trigger AS $report_notification$
        BEGIN
            INSERT INTO 
                notification(user_id, notification_type, notification_date, notification_text)
                select NEW.reporter_id, 'report', NEW.report_date, 'Thank you for your report. We will check information given as fast as possible. Report status: ' || NEW.report_status || ' Message: ' || NEW.report_text from report;
        RETURN new;
END;
$report_notification$
language plpgsql;
                
DROP TRIGGER IF EXISTS trig_report ON public.report;

CREATE TRIGGER trig_report
     AFTER INSERT ON report
     FOR EACH ROW
     EXECUTE PROCEDURE report_notification();

-----------------------------------------
-- Performance indexes
-----------------------------------------

-- e.g to count number of users
DROP INDEX IF EXISTS idx_id_user CASCADE;
CREATE INDEX IF NOT EXISTS idx_id_user ON authorized_user USING BTREE(surname);

-- we will use it to search for people from a specific event, during search equality (=) will be used.
-- select user_id from user_event where event_id = 1;
DROP INDEX IF EXISTS idx_event_user CASCADE;
CREATE INDEX IF NOT EXISTS idx_event_user on user_event USING hash(event_id);


-- lets us count all the votes for a specifit poll.
-- select select count(*) from poll_vote where poll_id = 1;
-- equality operator is used, hence the hash index type is suggested.
DROP INDEX IF EXISTS idx_poll_vote CASCADE;
CREATE INDEX IF NOT EXISTS idx_poll_vote on poll_vote USING hash(id);

-----------------------------------------
-- FULL TEXT indexes
----------------------------------------- 
ALTER TABLE event
ADD COLUMN IF NOT EXISTS tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION event_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B') ||
             setweight(to_tsvector('english', NEW.location), 'C')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.description <> OLD.description OR NEW.location <> OLD.location) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B') ||
                 setweight(to_tsvector('english', NEW.location), 'C')
           );
    END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;


DROP TRIGGER IF EXISTS event_search_update ON public.event;

CREATE TRIGGER event_search_update
 BEFORE INSERT OR UPDATE ON event
 FOR EACH ROW
 EXECUTE PROCEDURE event_search_update();

DROP INDEX IF EXISTS search_idx_event CASCADE;
CREATE INDEX IF NOT EXISTS search_idx_event ON event USING GIN (tsvectors);


--To improve overall performance of full-text searches while searching for tags by name; GiST better for dynamic data
DROP INDEX IF EXISTS idx_tag_name CASCADE;
CREATE INDEX IF NOT EXISTS idx_tag_name ON tag USING GIST (name);