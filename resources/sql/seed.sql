-----------------------------------------
-- DROPPING TABLES
-----------------------------------------
create schema if not exists lbaw22122;
set search_path=lbaw22122;

drop type if exists email_t CASCADE;
CREATE DOMAIN email_t AS VARCHAR(320) NOT NULL CHECK (VALUE LIKE '_%@_%._%');

drop type if exists timestamp_t CASCADE;
CREATE DOMAIN timestamp_t AS TIMESTAMP NOT NULL DEFAULT NOW();


DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS authorized_user CASCADE;
DROP TABLE IF EXISTS event CASCADE;
DROP TABLE IF EXISTS user_event CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS photo CASCADE;
DROP TABLE IF EXISTS poll CASCADE;
DROP TABLE IF EXISTS event_poll CASCADE;
DROP TABLE IF EXISTS poll_choice CASCADE;
DROP TABLE IF EXISTS poll_vote CASCADE;
DROP TABLE IF EXISTS notifications CASCADE;
DROP TABLE IF EXISTS comment_votes CASCADE;
DROP TABLE IF EXISTS faqs CASCADE;
DROP TABLE IF EXISTS password_resets CASCADE;

-----------------------------------------
-- TYPES
-----------------------------------------

drop type if exists MEMBER_ROLE;
CREATE TYPE MEMBER_ROLE AS ENUM('Owner', 'Moderator', 'Participant', 'Unconfirmed', 'Blocked');



drop type if exists "comment_vote" CASCADE;
CREATE TYPE "comment_vote" AS ENUM ('like', 'dislike');

-----------------------------------------
-- TABLES
-----------------------------------------



CREATE TABLE IF NOT EXISTS users(
    id SERIAL PRIMARY KEY,
    name TEXT UNIQUE NOT NULL,
    firstname TEXT DEFAULT 'Válter Ochôa de Spínola Catanho' NOT NULL,
    lastname TEXT DEFAULT 'Castro' NOT NULL,
    password VARCHAR NOT NULL,
    email TEXT UNIQUE NOT NULL,
    date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    birth_date DATE DEFAULT (current_date - INTERVAL '18 YEAR') CHECK (
        birth_date <= (current_date - INTERVAL '18 YEAR')
    ),
    url TEXT UNIQUE,
    is_banned BOOLEAN DEFAULT false,
    is_admin BOOLEAN DEFAULT false NOT NULL,
    photo_path TEXT DEFAULT ('/default-profile-photo.webp'),
    remember_token VARCHAR
);




CREATE TABLE IF NOT EXISTS faqs(
    id SERIAL PRIMARY KEY,
    Q VARCHAR,
    A VARCHAR
);





CREATE TABLE IF NOT EXISTS event(
    id SERIAL PRIMARY KEY,
    title TEXT DEFAULT 'Adega Leonor Party' NOT NULL,
    description TEXT DEFAULT('FEUP party') NOT NULL,
    tags VARCHAR DEFAULT(''), -- Comma separated
    start_date DATE DEFAULT (current_date) CHECK (current_date <= start_date) NOT NULL,
    end_date DATE DEFAULT (current_date + INTERVAL '1 DAY') CHECK (start_date <= end_date) NOT NULL,
    is_public BOOLEAN DEFAULT TRUE NOT NULL,
    owner_id INT NOT NULL,
    location TEXT DEFAULT 'Adega Leonor' NOT NULL
);



CREATE TABLE IF NOT EXISTS user_event(
    id SERIAL PRIMARY KEY,
    user_id INT,
    event_id INT,  
    role MEMBER_ROLE,
    UNIQUE (user_id, event_id),  -- combination of user_id and event_id is UNIQUE because user can be registered at the event only once
    FOREIGN KEY (user_id) REFERENCES users(id) 
                            ON DELETE CASCADE
                            ON UPDATE CASCADE,
    FOREIGN KEY (event_id) REFERENCES event(id) 
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
);


CREATE TABLE IF NOT EXISTS comments(
    id SERIAL PRIMARY KEY,
    comment_text TEXT DEFAULT ('Great event!'),
    user_id INT,
    event_id INT,
    parent_comment_id INT DEFAULT NULL, -- null if a new comment and comment_id of the parent if a reply
    comment_date DATE DEFAULT (current_date) CHECK (current_date <= comment_date),
    FOREIGN KEY (parent_comment_id) REFERENCES comments(id)
                                        ON DELETE CASCADE
                                        ON UPDATE CASCADE
);





CREATE TABLE IF NOT EXISTS comment_votes(
    id SERIAL PRIMARY KEY,
    user_id INTEGER, 
    comment_id INTEGER,
    type comment_vote NOT NULL DEFAULT ('like'),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (comment_id) REFERENCES comments(id) 
                                ON DELETE CASCADE
);






CREATE TABLE IF NOT EXISTS photo(
    id SERIAL PRIMARY KEY,
    upload_date DATE DEFAULT (current_date),
    image_path TEXT UNIQUE,
    event_id INT,
    FOREIGN KEY (event_id) REFERENCES event(id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
);


CREATE TABLE IF NOT EXISTS poll(
    id SERIAL PRIMARY KEY,
    event_id INT NOT NULL,
    question TEXT DEFAULT('What is your favorite programming language?') NOT NULL,
    starts_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP check(starts_at <= CURRENT_TIMESTAMP) NOT NULL,
    ends_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL '1 DAY') check(ends_at > starts_at) NOT NULL,
    UNIQUE(id, event_id),
    FOREIGN KEY (event_id) REFERENCES event(id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
    
);


CREATE TABLE IF NOT EXISTS poll_choice(
    id SERIAL PRIMARY KEY,
    poll_id INT,
    choice TEXT NOT NULL,
    UNIQUE(poll_id, id),
    FOREIGN KEY (poll_id) REFERENCES poll(id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
);


CREATE TABLE IF NOT EXISTS event_poll(
    id SERIAL PRIMARY KEY,
    user_id INT,
    event_id INT,
    poll_id INT,
    UNIQUE(user_id, poll_id),
    UNIQUE(user_id, event_id, poll_id),
    FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id)
                                     ON DELETE CASCADE
                                     ON UPDATE CASCADE,
    FOREIGN KEY (poll_id, event_id) REFERENCES poll (id, event_id) 
                                     ON DELETE CASCADE
                                     ON UPDATE CASCADE
);


CREATE TABLE IF NOT EXISTS poll_vote(
    id SERIAL PRIMARY KEY,
    user_id INT,
    event_id INT,
    poll_id INT,
    choice_id INT,
    date TIMESTAMP DEFAULT(CURRENT_TIMESTAMP) NOT NULL,
    UNIQUE (user_id, event_id, poll_id),
    FOREIGN KEY (user_id, event_id, poll_id) REFERENCES event_poll (user_id, event_id, poll_id)
                                                ON DELETE CASCADE
                                                ON UPDATE CASCADE,
    FOREIGN KEY (choice_id, poll_id) REFERENCES poll_choice (id, poll_id)
                                                ON DELETE CASCADE
                                                ON UPDATE CASCADE

);






create table IF NOT EXISTS "notifications" (
    id uuid not null PRIMARY KEY, 
    type varchar(255) not null, 
    notifiable_type varchar(255) not null, 
    notifiable_id bigint not null, 
    data text not null, 
    read_at timestamp(0) without time zone null, 
    created_at timestamp(0) without time zone null, 
    updated_at timestamp(0) without time zone null,
    FOREIGN KEY (notifiable_id) REFERENCES users(id)
                                    ON DELETE CASCADE
                                    ON UPDATE CASCADE
    );  

    DROP INDEX IF EXISTS "notifications_notifiable_type_notifiable_id_index" CASCADE;
    create index "notifications_notifiable_type_notifiable_id_index" on "notifications" 
                                                ("notifiable_type", "notifiable_id");








CREATE TABLE password_resets
(
    id SERIAL PRIMARY KEY,
    email email_t,
    token VARCHAR(100),
    created_at timestamp_t,
    updated_at timestamp_t,
    CONSTRAINT ck_updated_after_created CHECK ( updated_at >= created_at )
);





-- trigger that inserts data into user_event table after event is created
CREATE OR REPLACE FUNCTION event_creation() RETURNS trigger AS 
$BODY$          
        BEGIN
        INSERT INTO user_event(user_id, event_id, role)
        VALUES(NEW.owner_id, NEW.id, 'Owner');
RETURN new;
END;
$BODY$
language plpgsql;
                
DROP TRIGGER IF EXISTS trig_event_creation ON event;

CREATE TRIGGER trig_event_creation
     AFTER INSERT ON event
     FOR EACH ROW
     EXECUTE PROCEDURE event_creation();



-- -----------------------------------------
-- -- Performance indexes
-- -----------------------------------------

-- IDX01 
-- To make event search by date faster.
DROP INDEX IF EXISTS idx_event_date CASCADE;
CREATE INDEX idx_event_date ON "event" USING btree(start_date);

-- IDX02
DROP INDEX IF EXISTS idx_comment CASCADE;
CREATE INDEX idx_comment ON comments USING btree(event_id, comment_text);



-- -----------------------------------------
-- -- FULL TEXT indexes
-- ----------------------------------------- 
ALTER TABLE event
ADD COLUMN IF NOT EXISTS tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION event_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.title), 'A') ||
         setweight(to_tsvector('english', NEW.tags), 'B') ||
         setweight(to_tsvector('english', NEW.description), 'C') ||
             setweight(to_tsvector('english', NEW.location), 'D')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
    IF (NEW.title <> OLD.title OR NEW.description <> OLD.description OR NEW.location <> OLD.location OR NEW.tags <> OLD.tags) THEN
        NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.title), 'A') ||
            setweight(to_tsvector('english', NEW.tags), 'B') ||
            setweight(to_tsvector('english', NEW.description), 'C') ||
            setweight(to_tsvector('english', NEW.location), 'D')
           );
    END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;


DROP TRIGGER IF EXISTS event_search_update ON event;

CREATE TRIGGER event_search_update
 BEFORE INSERT OR UPDATE ON event
 FOR EACH ROW
 EXECUTE PROCEDURE event_search_update();

DROP INDEX IF EXISTS search_idx_event CASCADE;
CREATE INDEX IF NOT EXISTS search_idx_event ON event USING GIN (tsvectors);








-- search
ALTER TABLE users
ADD COLUMN IF NOT EXISTS tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.lastname), 'B') ||
             setweight(to_tsvector('english', NEW.firstname), 'C')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.lastname <> OLD.lastname OR NEW.firstname <> OLD.firstname) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.lastname), 'B') ||
                 setweight(to_tsvector('english', NEW.firstname), 'C')
           );
    END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;


DROP TRIGGER IF EXISTS user_search_update ON users;

CREATE TRIGGER user_search_update
 BEFORE INSERT OR UPDATE ON users
 FOR EACH ROW
 EXECUTE PROCEDURE user_search_update();

DROP INDEX IF EXISTS search_user_idx CASCADE;
CREATE INDEX IF NOT EXISTS search_user_idx ON users USING GIN (tsvectors);







---------------------------------------------------------------------------------------------------------

-- INSERT

---------------------------------------------------------------------------------------------------------


INSERT INTO faqs(Q, A) VALUES(
    'What is UPorto Event?',
    'UPorto Event is a Portugal-based international web service that focuses on creation 
    and development of small and/or large-scale events mostly connected with U.Porto academic life. '
);

INSERT INTO faqs(Q, A) VALUES(
    'What is UPorto Event made for?',
    'UPorto Event is made for creating students and not only events such as institutional conferences, parties and traditional academic celebrations.'
);

INSERT INTO faqs(Q, A) VALUES(
    'When UPorto event was founded?',
    'It was founded in 2022 as a student project of the University of Porto.'
);

INSERT INTO faqs(Q, A) VALUES(
    'How long did it take to create UPorto Event?',
    '4 month of hard preparing for 7 days work.'
);

INSERT INTO faqs(Q, A) VALUES(
    'What do I need to create event?',
    'You just have to create your own profile. It`s fast and absolutly free!'
);

INSERT INTO faqs(Q, A) VALUES(
    'What information can I find without registrating?',
    'As a guest, you still can search for events, but you need to aftorise to join events, write comments and participate in polls.'
);


INSERT INTO users(name, firstname, lastname, password, email, is_admin,photo_path) VALUES (
    'john_admin',
    'John',
    'Doe',
    '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
    'admin@example.com',
    true,
    '/image.png'
); -- Password is 1234. Generated using Hash::make('1234')

INSERT INTO users(name, firstname, lastname, password, email, photo_path) VALUES (
    'simple_alex',
    'Alex',
    'Ham',
    '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
    'user@example.com',
    '/image.png'
); -- Password is 1234

INSERT INTO users(name, firstname, lastname, password, email, photo_path) VALUES (
    'Bob_moderator',
    'Bob',
    'Billy',
    '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
    'moderator@example.com',
    '/image.png'
); -- Password is 1234

insert into users (name, firstname, lastname, password, email, url) values (
    'Surgeon', 
    'Michael', 
    'Ermolaev', 
    '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 
    'ermol24@icloud.com', 
    '/etc/public/images/mike.jpg'
); -- Password is 1234

INSERT INTO event(title, description, tags, start_date, owner_id, location) VALUES (
    'FEUP CAFE',
    'Convivio entre estudantes da FEUP',
    'Coffee, Porto',
    current_date,
    1,
    'AEFEUP'
);

INSERT INTO event(title, description, tags, start_date, owner_id, location) VALUES (
    'Jantar Curso LEIC',
    'Convivio entre estudantes do LEIC',
    'Porto, Food',
    current_date,
    1,
    'Um sitio fixe'
);


INSERT INTO event(title, description, tags, start_date, owner_id, location) VALUES (
    'Jantar Curso LEIC',
    'Convivio entre estudantes do LEIC',
    'Porto, Food',
    current_date,
    1,
    'Um sitio fixe'
);