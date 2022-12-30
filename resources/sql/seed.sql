-----------------------------------------
-- DROPPING TABLES
-----------------------------------------
-- CASCADE Automatically drop objects that depend on the table
create schema if not exists lbaw22122;
--CREATE DOMAIN  email_t AS VARCHAR(320) NOT NULL CHECK (VALUE LIKE '_%@_%._%');
--CREATE DOMAIN  timestamp_t AS TIMESTAMP NOT NULL DEFAULT NOW();

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
DROP TABLE IF EXISTS notifications CASCADE;
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
    status TEXT,
    is_admin BOOLEAN DEFAULT false NOT NULL,
    photo_path TEXT DEFAULT ('/default-profile-photo.webp'),
    remember_token VARCHAR
);



CREATE TABLE administrators(
    user_id INTEGER, 
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);



CREATE TABLE IF NOT EXISTS faqs(
    id SERIAL PRIMARY KEY,
    Q VARCHAR,
    A VARCHAR
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
    start_date DATE DEFAULT (current_date) CHECK (current_date <= start_date) NOT NULL,
    end_date DATE DEFAULT (current_date + INTERVAL '1 DAY') CHECK (start_date <= end_date) NOT NULL,
    is_public BOOLEAN DEFAULT TRUE NOT NULL,
    owner_id INT NOT NULL,
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


CREATE TABLE IF NOT EXISTS comments(
    id SERIAL PRIMARY KEY,
    comment_text TEXT DEFAULT ('Great event!'),
    user_id INT,
    event_id INT,
    parent_comment_id INT DEFAULT NULL, -- null if a new comment and comment_id of the parent if a reply
    comment_date DATE DEFAULT (current_date) CHECK (current_date <= comment_date),
        FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),     -- double reference 
        FOREIGN KEY (parent_comment_id) REFERENCES comments(id)
);





CREATE TABLE IF NOT EXISTS comment_votes(
    id SERIAL PRIMARY KEY,
    user_id INTEGER, 
    comment_id INTEGER,
    type comment_vote NOT NULL DEFAULT ('like'),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE
);





CREATE TABLE IF NOT EXISTS tag(
    id SERIAL PRIMARY KEY,
    event_id INT,
    name varchar NOT NULL,
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






create table IF NOT EXISTS "notifications" (
    "id" uuid not null, 
    "type" varchar(255) not null, 
    "notifiable_type" varchar(255) not null, 
    "notifiable_id" bigint not null, 
    "data" text not null, 
    "read_at" timestamp(0) without time zone null, 
    "created_at" timestamp(0) without time zone null, 
    "updated_at" timestamp(0) without time zone null);  

DROP INDEX IF EXISTS "notifications_notifiable_type_notifiable_id_index" CASCADE;
  create index "notifications_notifiable_type_notifiable_id_index" on "notifications" 
  ("notifiable_type", "notifiable_id");
  alter table "notifications" add primary key ("id");













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

/*
CREATE TABLE password_resets
(
    id               SERIAL PRIMARY KEY,
    email            email_t,
    token            VARCHAR(100),
    created_at       timestamp_t,
    updated_at       timestamp_t,
    CONSTRAINT ck_updated_after_created CHECK ( updated_at >= created_at )
);
*/
-----------------------------------------
-- TRIGGERS
-----------------------------------------

-- Trigger to create a notification when a comment is replied 

CREATE OR REPLACE FUNCTION comment_notification() RETURNS trigger AS 
$BODY$

DECLARE reply_username TEXT = (
  SELECT name FROM users WHERE id = NEW.user_id
);

DECLARE parent_id INT = (
    select user_id from comments where NEW.parent_comment_id = id
);

DECLARE parent_username TEXT = (
    select name from users where id = parent_id
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
             END IF;
                         RETURN new;
        
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
    select name from users where id = NEW.user_id
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
         setweight(to_tsvector('english', NEW.description), 'B') ||
             setweight(to_tsvector('english', NEW.location), 'C')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title OR NEW.description <> OLD.description OR NEW.location <> OLD.location) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.title), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B') ||
                 setweight(to_tsvector('english', NEW.location), 'C')
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




















INSERT INTO faqs(Q, A) VALUES(
    'What is UPorto Event made for?',
    'For creating events'
);

INSERT INTO faqs(Q, A) VALUES(
    'How much does it cost?',
    'UPorto Event is free'
);

INSERT INTO faqs(Q, A) VALUES(
    'When UPorto event was founded?',
    '2022'
);

INSERT INTO faqs(Q, A) VALUES(
    'How long did it take to create UPorto Event?',
    '4 month'
);




INSERT INTO users(name, firstname, lastname, password, email, is_admin,photo_path) VALUES (
    'john_doe228',
    'John',
    'Doe',
    '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
    'admin@example.com',
    true,
    '/image.png'
); -- Password is 1234. Generated using Hash::make('1234')

INSERT INTO users(name, firstname, lastname, password, email, photo_path) VALUES (
    'tvoya_mama',
    'Alex',
    'Ham',
    '$2a$12$de8vO5hCTMjKQpHd.OE/R.atg/xpTmVheKs3rTcSIPVvzYjhRKBE6',
    'user@example.com',
    '/image.png'
); -- Password is 123456

INSERT INTO administrators VALUES (
    1
);

INSERT INTO event(title, description, start_date, owner_id, location) VALUES (
    'FEUP CAFE',
    'Convivio entre estudantes da FEUP',
    current_date,
        1,
    'AEFEUP'
);

INSERT INTO event(title, description, start_date, owner_id, location) VALUES (
    'Jantar Curso LEIC',
    'Convivio entre estudantes do LEIC',
    current_date,
        1,
    'Um sitio fixe'
);













---------------------------------------------------------------------------------------------------------

-- EVENT

---------------------------------------------------------------------------------------------------------



insert into event (id, title, description, owner_id, location) values (30, 'And Then There Were None', 'Crime|Mystery', 1, '29 Sachs Way');
insert into event (id, title, description, owner_id, location) values (31, 'Misérables, Les', 'Drama|Romance', 1, '54762 Maryland Terrace');
insert into event (id, title, description, owner_id, location) values (32, 'Marriage of Maria Braun, The (Ehe der Maria Braun, Die)', 'Drama', 1, '1117 Esker Terrace');
insert into event (id, title, description, owner_id, location) values (33, 'Mad Dogs & Englishmen', 'Documentary|Musical', 1, '37 Arrowood Point');
insert into event (id, title, description, owner_id, location) values (34, 'Wedding in Blood (Noces rouges, Les)', 'Crime|Drama', 1, '5779 Homewood Lane');
insert into event (id, title, description, owner_id, location) values (35, 'Ballroom, The (Chega de Saudade)', 'Drama|Musical|Romance', 1, '8 Randy Junction');
insert into event (id, title, description, owner_id, location) values (36, 'Elite Squad: The Enemy Within (Tropa de Elite 2 - O Inimigo Agora É Outro)', 'Action|Crime|Drama', 1, '8206 Erie Lane');
insert into event (id, title, description, owner_id, location) values (37, 'To Kill a Mockingbird', 'Drama', 1, '946 South Road');
insert into event (id, title, description, owner_id, location) values (38, 'So Normal (Normais, Os)', 'Comedy', 1, '8 Gateway Center');
insert into event (id, title, description, owner_id, location) values (39, 'Murder, My Sweet', 'Crime|Film-Noir|Thriller', 1, '052 Holmberg Street');
insert into event (id, title, description, owner_id, location) values (40, 'Primal Fear', 'Crime|Drama|Mystery|Thriller', 1, '60756 Chinook Road');
insert into event (id, title, description, owner_id, location) values (41, 'Informant', 'Documentary', 1, '66856 Talmadge Crossing');
insert into event (id, title, description, owner_id, location) values (42, 'Amy', 'Comedy|Drama', 1, '3 Summerview Street');
insert into event (id, title, description, owner_id, location) values (43, 'Are We There Yet?', 'Children|Comedy', 1, '9171 Green Ridge Junction');
insert into event (id, title, description, owner_id, location) values (44, 'Kapitalism: Our Improved Formula (Kapitalism - Reteta noastra secreta)', 'Documentary', 1, '6139 Fuller Parkway');
insert into event (id, title, description, owner_id, location) values (45, 'Rally ''Round the Flag, Boys!', 'Comedy', 1, '163 Sundown Alley');
insert into event (id, title, description, owner_id, location) values (46, 'Big Deal on Madonna Street (I Soliti Ignoti)', 'Comedy|Crime', 1, '530 Lunder Junction');
insert into event (id, title, description, owner_id, location) values (47, 'Toothless', 'Children|Comedy', 1, '72 Melody Place');
insert into event (id, title, description, owner_id, location) values (48, 'Thérèse: The Story of Saint Thérèse of Lisieux', 'Drama', 1, '2032 Iowa Place');
insert into event (id, title, description, owner_id, location) values (49, 'Pride and Prejudice', 'Comedy|Drama|Romance', 1, '2762 Havey Road');
insert into event (id, title, description, owner_id, location) values (50, 'Dream Home (Wai dor lei ah yut ho)', 'Horror', 1, '9255 Harper Alley');





---------------------------------------------------------------------------------------------------------

-- USERS

---------------------------------------------------------------------------------------------------------





insert into users (id, name, firstname, lastname, password, email, url) values (29, 'cvasyutochkins', 'Chance', 'Vasyutochkin', '4EGiGxZ', 'cvasyutochkins@fda.gov', 'http://dummyimage.com/187x100.png/ff4444/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (30, 'mknollesgreent', 'Margette', 'Knolles-Green', 'JqsLny9', 'mknollesgreent@hhs.gov', 'http://dummyimage.com/137x100.png/cc0000/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (31, 'ethroughtonu', 'Elvina', 'Throughton', 'cgiSwMZnL2', 'ethroughtonu@baidu.com', 'http://dummyimage.com/142x100.png/cc0000/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (32, 'scastellanv', 'Sigismund', 'Castellan', '4bJcPk4BnW0Z', 'scastellanv@cafepress.com', 'http://dummyimage.com/133x100.png/5fa2dd/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (33, 'nblumw', 'Nat', 'Blum', 'PEMVtY', 'nblumw@weebly.com', 'http://dummyimage.com/102x100.png/ff4444/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (34, 'mrussanx', 'Meghan', 'Russan', 'UNTXfXkUi80R', 'mrussanx@foxnews.com', 'http://dummyimage.com/212x100.png/dddddd/000000');
insert into users (id, name, firstname, lastname, password, email, url) values (35, 'jsidawayy', 'Jaymee', 'Sidaway', 'Xpuu0Mzfh', 'jsidawayy@comsenz.com', 'http://dummyimage.com/159x100.png/ff4444/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (36, 'ppendellz', 'Petronia', 'Pendell', 'Qo0jMe6V50wp', 'ppendellz@meetup.com', 'http://dummyimage.com/143x100.png/dddddd/000000');
insert into users (id, name, firstname, lastname, password, email, url) values (37, 'ogood10', 'Oliy', 'Good', 'C897qRxF', 'ogood10@1688.com', 'http://dummyimage.com/222x100.png/ff4444/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (38, 'ccorderoy11', 'Christi', 'Corderoy', 'TG4vr9CPoxX', 'ccorderoy11@blogger.com', 'http://dummyimage.com/145x100.png/5fa2dd/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (39, 'xdemetz12', 'Xylina', 'De Metz', 'Ckd68y7w', 'xdemetz12@comcast.net', 'http://dummyimage.com/178x100.png/ff4444/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (40, 'mjohnke13', 'Minette', 'Johnke', 'oC8ior', 'mjohnke13@dagondesign.com', 'http://dummyimage.com/203x100.png/cc0000/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (41, 'fglaysher14', 'Freddy', 'Glaysher', 'SgOQKP', 'fglaysher14@gizmodo.com', 'http://dummyimage.com/125x100.png/ff4444/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (42, 'hranaghan15', 'Husein', 'Ranaghan', 'JSihzete8LM', 'hranaghan15@barnesandnoble.com', 'http://dummyimage.com/153x100.png/dddddd/000000');
insert into users (id, name, firstname, lastname, password, email, url) values (43, 'cmacginney16', 'Cleve', 'MacGinney', 'ErASWtt', 'cmacginney16@ebay.com', 'http://dummyimage.com/178x100.png/5fa2dd/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (44, 'mconaboy17', 'Marabel', 'Conaboy', 'TCvRIcXrqbiB', 'mconaboy17@rakuten.co.jp', 'http://dummyimage.com/116x100.png/dddddd/000000');
insert into users (id, name, firstname, lastname, password, email, url) values (45, 'cmcmeekin18', 'Carleen', 'McMeekin', 'a0nx5F', 'cmcmeekin18@sphinn.com', 'http://dummyimage.com/215x100.png/dddddd/000000');
insert into users (id, name, firstname, lastname, password, email, url) values (46, 'lpiggen19', 'Linn', 'Piggen', 'EWi3WN5BzDc', 'lpiggen19@etsy.com', 'http://dummyimage.com/167x100.png/5fa2dd/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (47, 'dgopsall1a', 'Devon', 'Gopsall', 'KWj1Bbs4', 'dgopsall1a@imdb.com', 'http://dummyimage.com/111x100.png/cc0000/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (48, 'kburditt1b', 'Keeley', 'Burditt', 'AAqZWWfdvT', 'kburditt1b@nature.com', 'http://dummyimage.com/249x100.png/5fa2dd/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (49, 'dkowal1c', 'Dayle', 'Kowal', 'DGX6bHwp', 'dkowal1c@wordpress.org', 'http://dummyimage.com/155x100.png/cc0000/ffffff');
insert into users (id, name, firstname, lastname, password, email, url) values (50, 'hannand1d', 'Horatio', 'Annand', 'Dob8QtCZU', 'hannand1d@lulu.com', 'http://dummyimage.com/165x100.png/5fa2dd/ffffff');