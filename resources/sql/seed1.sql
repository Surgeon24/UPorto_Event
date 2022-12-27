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
DROP TABLE IF EXISTS administrators CASCADE;
DROP TABLE IF EXISTS faqs CASCADE;

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


CREATE TABLE users (
id SERIAL PRIMARY KEY,
photo_path TEXT DEFAULT ('/default-profile-photo.webp'),
name VARCHAR NOT NULL,
email VARCHAR UNIQUE NOT NULL,
password VARCHAR NOT NULL,
remember_token VARCHAR
);

CREATE TABLE administrators(
    user_id INTEGER, 
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

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



CREATE TABLE IF NOT EXISTS comments(
id SERIAL PRIMARY KEY,
comment_text TEXT DEFAULT ('Great event!'),
user_id INT,
event_id INT,
--parent_comment_id INT DEFAULT NULL, -- null if a new comment and comment_id of the parent if a reply
comment_date DATE DEFAULT (current_date) CHECK (comment_date <= current_date),
--FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),     -- double reference 
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (event_id) REFERENCES event(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS comment_votes(
    id SERIAL PRIMARY KEY,
    user_id INTEGER, 
    comment_id INTEGER,
    type comment_vote NOT NULL DEFAULT ('like'),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE
);




CREATE TABLE IF NOT EXISTS faqs(
    id SERIAL PRIMARY KEY,
    Q VARCHAR,
    A VARCHAR
);


INSERT INTO faqs(Q, A) VALUES(
    'What is UPorto Event made for?',
    'For creating events'
);

INSERT INTO faqs(Q, A) VALUES(
    'How much does it cost?',
    'UPorto Event is free'
);

INSERT INTO faqs(Q, A) VALUES(
    'Are you stupid?',
    'No'
);

INSERT INTO faqs(Q, A) VALUES(
    'Are you stupid?',
    'Yes'
);

INSERT INTO users VALUES (
DEFAULT,
'/image.png',
'John Doe',
'admin@example.com',
'$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'
); -- Password is 1234. Generated using Hash::make('1234')

INSERT INTO users VALUES (
DEFAULT,
DEFAULT,
'Doe John',
'user@example.com',
'$2a$12$de8vO5hCTMjKQpHd.OE/R.atg/xpTmVheKs3rTcSIPVvzYjhRKBE6'
); -- Password is 123456

INSERT INTO administrators VALUES (
    1
);

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

