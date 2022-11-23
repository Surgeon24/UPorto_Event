-----------------------------------------
-- DROPPING TABLES
-----------------------------------------
-- CASCADE Automatically drop objects that depend on the table
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS administrator CASCADE;
DROP TABLE IF EXISTS event CASCADE;
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS user_event CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS photo CASCADE;
DROP TABLE IF EXISTS poll CASCADE;
DROP TABLE IF EXISTS poll_choice CASCADE;
DROP TABLE IF EXISTS event_poll CASCADE;
DROP TABLE IF EXISTS poll_vote CASCADE;
DROP TABLE IF EXISTS event_notification CASCADE;
DROP TABLE IF EXISTS comment_notification CASCADE;
DROP TABLE IF EXISTS poll_notification CASCADE;
DROP TABLE IF EXISTS report_notification CASCADE;
DROP TABLE IF EXISTS notification CASCADE;

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


-----------------------------------------
-- TABLES
-----------------------------------------

CREATE TABLE IF NOT EXISTS users(
    id SERIAL PRIMARY KEY,
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
    FOREIGN KEY (admin_id) REFERENCES users(id)
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


CREATE TABLE IF NOT EXISTS report(
    id SERIAL PRIMARY KEY,
    reported_id INT,
    reporter_id INT,
    admin_id INT,
    report_text TEXT NOT NULL,
        report_date TIMESTAMP DEFAULT (CURRENT_TIMESTAMP),
        report_type REPORT_TYPE,
    report_status REPORT_STATUS,
    FOREIGN KEY (reported_id) REFERENCES users(id),
    FOREIGN KEY (reporter_id) REFERENCES users(id),
    FOREIGN KEY (admin_id) REFERENCES administrator(id)
);



CREATE TABLE IF NOT EXISTS user_event(
    id SERIAL PRIMARY KEY,
    user_id INT,
    event_id INT,  
    role MEMBER_ROLE,
    accepted BOOLEAN,   -- used only in private events
    UNIQUE (user_id, event_id),  -- combination of user_id and event_id is UNIQUE because user can be registered at the event only once
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES event(id)
);


-- word "comments" was used because "comment" is a reserved word in PostgreSQL 
-- inspirations: https://stackoverflow.com/questions/55074867/posts-comments-replies-and-likes-database-schema
CREATE TABLE IF NOT EXISTS comments(
    id SERIAL PRIMARY KEY,
    comment_text TEXT DEFAULT ('Great event!'),
    user_id INT,
    event_id INT,
    parent_comment_id INT DEFAULT NULL, -- null if a new comment and comment_id of the parent if a reply
    comment_date DATE DEFAULT (current_date) CHECK (comment_date <= current_date),
        FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),     -- double reference 
        FOREIGN KEY (parent_comment_id) REFERENCES comments(id)
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
    event_id INT NOT NULL,
    question TEXT DEFAULT('What is your favorite programming language?') NOT NULL,
    starts_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP check(starts_at <= CURRENT_TIMESTAMP) NOT NULL,
    ends_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL '1 DAY') check(ends_at > starts_at) NOT NULL,
    UNIQUE(id, event_id),
    FOREIGN KEY (event_id) REFERENCES event(id)
);


CREATE TABLE IF NOT EXISTS poll_choice(
    id SERIAL PRIMARY KEY,
    poll_id INT,
    choice TEXT NOT NULL,
    UNIQUE(poll_id, id),
    FOREIGN KEY (poll_id) REFERENCES poll(id)
);


CREATE TABLE IF NOT EXISTS event_poll(
    id SERIAL PRIMARY KEY,
    user_id INT,
    event_id INT,
    poll_id INT,
    UNIQUE(user_id, poll_id),
    UNIQUE(user_id, event_id, poll_id),
    FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),     -- double reference 
    FOREIGN KEY (poll_id, event_id) REFERENCES poll (id, event_id) 
);


CREATE TABLE IF NOT EXISTS poll_vote(
    id SERIAL PRIMARY KEY,
    user_id INT,
    event_id INT,
    poll_id INT,
    choice_id INT,
    date TIMESTAMP DEFAULT(CURRENT_TIMESTAMP) NOT NULL,
    UNIQUE (user_id, event_id, poll_id),
    FOREIGN KEY (user_id, event_id, poll_id) REFERENCES event_poll (user_id, event_id, poll_id),
    FOREIGN KEY (choice_id, poll_id) REFERENCES poll_choice (id, poll_id)

);




CREATE TABLE IF NOT EXISTS notification(
    id SERIAL PRIMARY KEY,
    user_id INT,
    notification_type type_notification NOT NULL,
    notification_title TEXT NOT NULL DEFAULT ('Main topic of the notification (header)'),
    body TEXT,  -- is not supposed to be filled for all types of notifications
    notification_date DATE NOT NULL DEFAULT (current_date) CHECK (notification_date <= current_date),
    FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE IF NOT EXISTS comment_notification(
        id      INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE,
    comment INTEGER NOT NULL REFERENCES comments (id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS poll_notification
(
    id      INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE,
    poll        INTEGER NOT NULL REFERENCES poll (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS event_notification
(
    id      INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE,
    event   INTEGER NOT NULL REFERENCES event (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS report_notification
(
    id     INTEGER NOT NULL REFERENCES notification (id) ON DELETE CASCADE,
    report INTEGER NOT NULL REFERENCES report (id) ON DELETE CASCADE
);