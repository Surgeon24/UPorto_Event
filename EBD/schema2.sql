CREATE EXTENSION IF NOT EXISTS citext;
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
CREATE EXTENSION IF NOT EXISTS btree_gist;

DROP TABLE IF EXISTS registered_user CASCADE;
DROP TABLE IF EXISTS administrator CASCADE;
DROP TABLE IF EXISTS event CASCADE;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS user_event;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS report_notification;
DROP TABLE IF EXISTS poll_notification;
DROP TABLE IF EXISTS event_notification;
DROP TABLE IF EXISTS comment_notification;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS photo;
DROP TABLE IF EXISTS poll CASCADE;
DROP TABLE IF EXISTS poll_option CASCADE;
DROP TABLE IF EXISTS poll_vote;

drop type if exists REPORT_STATUS;
CREATE TYPE REPORT_STATUS AS ENUM('Going', 'Maybe', 'Cant');

drop type if exists MEMBER_ROLE;
CREATE TYPE MEMBER_ROLE AS ENUM('Owner', 'Moderator', 'Participant');


CREATE TABLE IF NOT EXISTS registered_user(
    ID uuid DEFAULT uuid_generate_v4 () PRIMARY KEY,
    name TEXT DEFAULT 'name' NOT NULL,
    surename TEXT DEFAULT 'family name' NOT NULL,
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
    FOREIGN KEY (admin_id) REFERENCES registered_user(id)
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
    admin_id SERIAL,
    text TEXT NOT NULL,
    report_status REPORT_STATUS,
    FOREIGN KEY (reported_id) REFERENCES registered_user(id),
    FOREIGN KEY (reporter_id) REFERENCES registered_user(id),
    FOREIGN KEY (admin_id) REFERENCES administrator(id)
);



CREATE TABLE IF NOT EXISTS user_event(
    id SERIAL PRIMARY KEY,
    user_id uuid,
    event_id SERIAL,  
    role MEMBER_ROLE,
    accepted BOOLEAN,   -- Needed only in Private events
    -- constraint: user can be registered at the event only once
    UNIQUE (user_id, event_id),  -- combination if user_id and event_id is UNIQUE
    FOREIGN KEY (user_id) REFERENCES registered_user(id),
    FOREIGN KEY (event_id) REFERENCES event(id)
);



-- "comment" is a reserved word in PostgreSQL so I changed it to "comments"
CREATE TABLE IF NOT EXISTS comments(
    id SERIAL PRIMARY KEY,
    comment_text TEXT,
    user_id uuid,
    event_id INT,
    parent_comment_id INT DEFAULT NULL, -- null or -1 if a new comment and comment_id of the parent if a reply
    publish_date DATE DEFAULT (current_date) CHECK (publish_date <= current_date),
    FOREIGN KEY (user_id) REFERENCES registered_user(id),
    FOREIGN KEY (event_id) REFERENCES event(id),
    FOREIGN KEY (parent_comment_id) REFERENCES comments(id)
);




-- CREATE TRIGGER login1 BEFORE INSERT ON
-- Persons FOR EACH ROW trigger1:
-- begin
-- if (OLD.Address = NEW.Address) THEN
--     SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Login istnieje';
-- else    
--     set NEW.Address = concat(LEFT(NEW.Firstname,1), NEW.Lastname);
-- LEAVE trigger1;
-- end if;

-- end;









CREATE TABLE IF NOT EXISTS notification(
    id SERIAL PRIMARY KEY,
    text TEXT NOT NULL,
    date DATE NOT NULL DEFAULT (current_date) CHECK (date <= current_date) ,
    user_id uuid,
    FOREIGN KEY (user_id) REFERENCES registered_user(id)
);








CREATE TABLE IF NOT EXISTS tag(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    color TEXT NOT NULL,
    event_id SERIAL,
    FOREIGN KEY (event_id) REFERENCES event(id)
);
CREATE TABLE IF NOT EXISTS photo(
    id SERIAL PRIMARY KEY,
    upload_date DATE DEFAULT (current_date),
    image_path TEXT UNIQUE,
    event_id SERIAL,
    FOREIGN KEY (event_id) REFERENCES event(id)
);
CREATE TABLE IF NOT EXISTS poll(
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    starts_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP check(starts_at <= CURRENT_TIMESTAMP) NOT NULL,
    end_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL '1 DAY') check(end_at > starts_at) NOT NULL,
    user_id uuid,
    event_id SERIAL,
    FOREIGN KEY (event_id) REFERENCES event(id),
    FOREIGN KEY (user_id) REFERENCES registered_user(id)
);
CREATE TABLE IF NOT EXISTS poll_option(
    id SERIAL PRIMARY KEY,
    option TEXT NOT NULL,
    poll_id SERIAL,
    FOREIGN KEY (poll_id) REFERENCES poll(id)
);
CREATE TABLE IF NOT EXISTS poll_vote(
    vote_id SERIAL PRIMARY KEY,
    user_id uuid,
    option_id SERIAL,
    date DATE NOT NULL,
    FOREIGN KEY (vote_id) REFERENCES poll(id),
    FOREIGN KEY (user_id) REFERENCES registered_user(id),
    FOREIGN KEY (option_id) REFERENCES poll_option(id)
);