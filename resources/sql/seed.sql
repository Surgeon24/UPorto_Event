-----------------------------------------
-- DROPPING TABLES
-----------------------------------------
-- CASCADE Automatically drop objects that depend on the table
create schema if not exists lbaw22122;

drop type if exists email_t CASCADE;
CREATE DOMAIN  email_t AS VARCHAR(320) NOT NULL CHECK (VALUE LIKE '_%@_%._%');

drop type if exists timestamp_t CASCADE;
CREATE DOMAIN  timestamp_t AS TIMESTAMP NOT NULL DEFAULT NOW();

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
DROP TABLE IF EXISTS password_resets CASCADE;

-----------------------------------------
-- TYPES
-----------------------------------------
drop type if exists REPORT_TYPE;
CREATE TYPE REPORT_TYPE AS ENUM('Spam', 'Nudity or sexual activity', 'Hate speech or symbols', 'Violence or dangerous organisations', 'Bullying or harassment', 'Selling illegal or regulated goods', 'Scams or fraud', 'False information', 'Other');

drop type if exists REPORT_STATUS;
CREATE TYPE REPORT_STATUS AS ENUM('Waiting', 'Ignored', 'Sanctioned');

drop type if exists MEMBER_ROLE;
CREATE TYPE MEMBER_ROLE AS ENUM('Owner', 'Moderator', 'Participant', 'Unconfirmed');



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
    tags VARCHAR DEFAULT(''), -- Comma separated
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












CREATE TABLE password_resets
(
    id               SERIAL PRIMARY KEY,
    email            email_t,
    token            VARCHAR(100),
    created_at       timestamp_t,
    updated_at       timestamp_t,
    CONSTRAINT ck_updated_after_created CHECK ( updated_at >= created_at )
);

-----------------------------------------
-- TRIGGERS
-----------------------------------------

-- Trigger to create a notification when a comment is replied 

-- CREATE OR REPLACE FUNCTION comment_notification() RETURNS trigger AS 
-- $BODY$

-- DECLARE reply_username TEXT = (
--   SELECT name FROM users WHERE id = NEW.user_id
-- );

-- DECLARE parent_id INT = (
--     select user_id from comments where NEW.parent_comment_id = id
-- );

-- DECLARE parent_username TEXT = (
--     select name from users where id = parent_id
-- );

-- DECLARE title_text TEXT = (
--         select concat(reply_username, ' replied to your comment!')
-- );

--         BEGIN
--         IF (NEW.parent_comment_id IS NOT NULL)
--             THEN
--                 WITH INSERTED AS (
--                                         INSERT INTO 
--                     notification(notification_title,notification_date, notification_type, user_id, body)
--                     VALUES(title_text, CURRENT_TIMESTAMP, 'comment', parent_id, NEW.comment_text)
--                                         RETURNING id)
--                                 INSERT INTO 
--                                         comment_notification(id, comment)
--                                         select inserted.id, NEW.id from inserted;
--              END IF;
--                          RETURN new;
        
-- END;
-- $BODY$
-- language plpgsql;
                


-- DROP TRIGGER IF EXISTS trig_comment ON comments;

-- CREATE TRIGGER trig_comment
--      AFTER INSERT OR UPDATE ON comments
--      FOR EACH ROW
--      EXECUTE PROCEDURE comment_notification();
         
         







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

INSERT INTO event(title, description, tags, start_date, owner_id, location) VALUES (
    'FEUP CAFE',
    'Convivio entre estudantes da FEUP',
    'Food, Lisbon',
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













---------------------------------------------------------------------------------------------------------

-- EVENT

---------------------------------------------------------------------------------------------------------



insert into event (title, description, tags, owner_id, location) values ('To Live and Die in L.A.', 'Action|Crime|Drama|Thriller', 'Syria', 1, '1 David Road');
insert into event (title, description, tags, owner_id, location) values ('Bonhoeffer: Agent of Grace', 'Drama', 'Russia', 1, '5171 Esch Crossing');
insert into event (title, description, tags, owner_id, location) values ('Toy Story 2', 'Adventure|Animation|Children|Comedy|Fantasy', 'Kyrgyzstan', 1, '81 Porter Point');
insert into event (title, description, tags, owner_id, location) values ('Hiding Out', 'Comedy', 'China', 1, '50 Ridge Oak Terrace');
insert into event (title, description, tags, owner_id, location) values ('Barber of Siberia, The (Sibirskij tsiryulnik)', 'Drama|Romance', 'Indonesia', 1, '483 Cambridge Avenue');
insert into event (title, description, tags, owner_id, location) values ('Wesley Willis: The Daddy of Rock ''n'' Roll', 'Documentary', 'Russia', 1, '51655 Prentice Plaza');
insert into event (title, description, tags, owner_id, location) values ('Apocalypto', 'Adventure|Drama|Thriller', 'Ethiopia', 1, '25108 Sunbrook Lane');
insert into event (title, description, tags, owner_id, location) values ('Lilian''s Story', 'Drama', 'Russia', 1, '7904 Bobwhite Trail');
insert into event (title, description, tags, owner_id, location) values ('Che: Part Two', 'Drama|War', 'Macedonia', 1, '33 Lyons Junction');
insert into event (title, description, tags, owner_id, location) values ('Agenda: Grinding America Down', 'Documentary', 'China', 1, '9289 3rd Road');
insert into event (title, description, tags, owner_id, location) values ('Polar Express, The', 'Adventure|Animation|Children|Fantasy|IMAX', 'China', 1, '75 Rieder Crossing');
insert into event (title, description, tags, owner_id, location) values ('Song to Remember, A', 'Drama', 'Malaysia', 1, '5 Arapahoe Crossing');
insert into event (title, description, tags, owner_id, location) values ('Revenge of the Nerds III: The Next Generation', 'Comedy', 'Tanzania', 1, '4 Center Street');
insert into event (title, description, tags, owner_id, location) values ('Carancho', 'Crime|Drama|Romance', 'Portugal', 1, '5 Portage Plaza');
insert into event (title, description, tags, owner_id, location) values ('All I Desire', 'Drama|Romance', 'Czech Republic', 1, '58073 Oneill Parkway');
insert into event (title, description, tags, owner_id, location) values ('Garfield: A Tail of Two Kitties', 'Animation|Children|Comedy', 'Portugal', 1, '43108 Vidon Parkway');
insert into event (title, description, tags, owner_id, location) values ('Jodhaa Akbar', 'Drama|Musical|Romance|War', 'China', 1, '57 Cardinal Park');
insert into event (title, description, tags, owner_id, location) values ('Birthday Girl', 'Drama|Romance', 'Germany', 1, '019 Sheridan Drive');
insert into event (title, description, tags, owner_id, location) values ('Immigrant, The', 'Drama|Romance', 'Argentina', 1, '4 Orin Parkway');
insert into event (title, description, tags, owner_id, location) values ('Cat People', 'Drama|Horror|Romance|Thriller', 'Nigeria', 1, '57 Oak Valley Terrace');
insert into event (title, description, tags, owner_id, location) values ('Project X', 'Comedy', 'China', 1, '86 Sullivan Trail');
insert into event (title, description, tags, owner_id, location) values ('Patton Oswalt: Werewolves and Lollipops', 'Comedy', 'Portugal', 1, '26 Petterle Hill');
insert into event (title, description, tags, owner_id, location) values ('Dark, The', 'Horror|Mystery|Thriller', 'Mongolia', 1, '7030 Victoria Center');
insert into event (title, description, tags, owner_id, location) values ('Midnight Movies: From the Margin to the Mainstream', 'Documentary', 'China', 1, '05 Kennedy Court');
insert into event (title, description, tags, owner_id, location) values ('Devil''s Playground', 'Documentary', 'Indonesia', 1, '53 Waywood Parkway');




---------------------------------------------------------------------------------------------------------

-- USERS

---------------------------------------------------------------------------------------------------------



insert into users (id, name, firstname, lastname, password, email, url) values (51, 'Surgeon', 'Michael', 'Ermolaev', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'ermol24@icloud.com', '/etc/public/images/mike.jpg');

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