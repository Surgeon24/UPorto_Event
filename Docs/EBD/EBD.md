# EBD: Database Specification Component

***UPortoEvent*** will able all students of "Universidade do Porto" to explore all sorts of events inside their academic environment. Therefore in these three artifacts we will present our Database for this project. This way you'll see how your data will be stored.

## A4: Conceptual Data Model

In A4 we will take over our first database topic. This will cover the **Class Diagram** which compiles all entities, attributes and relations of our database, in order to store efficiently all website information.

### 1. Class diagram

![A4-UML_Diagram](images/A4-UPortoEvent.jpg)

### 2. Additional Business Rules
 
- BR01 : Only registred users who participate on the event can make comments and answer to polls.
- BR02 : Only event creators can delete or cancel the event. So event moderators, can´t.
- BR03 : Only Participants of an specific event can vote in polls
- BR04 : Only Event Moderators can invite users to an event
---


## A5: Relational Schema, validation and schema refinement

In A5 we are going to interpretate de UML diagram into the Relational Schema, so that SQL code turns out better. This more specific model represets out data base less abstract in a more concise way.

### 1. Relational Schema

| Relation reference | Relation Compact Notation                        |
| ------------------ | ------------------------------------------------ |
| R01                | authorized_user(<ins>user_id</ins>, name **NN**, surname **NN**, nickname **NN**, password **NN**, email **UK** **NN**, date_registered, last_seen **NN**, birth_date **NN**, url **UK** **NN**, status, is_admin, photo_path ) |
| R02                | event(<ins>event_id</ins>, name **NN**, descriprion **NN**, start_date **NN**, location **NN**, schedule **NN**, role **DF** 'participant' **CK** (role **IN** member_role)) ) |
| R03                | notification(<ins>notification_id</ins>, text **NN**, date **NN**, #user_id → authorized_user **NN** ) |
| R04                | photo(<ins>photo_id</ins>, upload_date **NN**, image_path **NN**, #event_id → Event ) |
| R05				 | poll(<ins>poll_id</ins>, title **NN**, content **NN**, start_date **NN**, end_date **NN**, #user_id → authorized_user **NN**, #event_id → event **NN** ) |
| R06				 | poll_option(<ins>poll_option_id</ins>, option **NN**, #poll_id → poll **NN**) |
| R07   			 | comment(<ins>comment_id</ins>, publish_date **NN**, description **NN**, #comment_id → comment **NN**, #event_id → event **NN**, #user_id → authorized_user **NN** ) |
| R08    			 | tag(<ins>tag_id</ins>, name **NN**, color **NN**, #event_id → event **NN** ) |
| R09  			     | poll_vote(<ins>vote_id</ins>, date **NN**, #user_id → authorized_user **NN**, #poll_option_id → poll_option **NN** ) |
| R10 				 | report(<ins>report_id</ins>, text **NN**, report_status **DF** 'waiting' **CK** (report_status **IN** report_status), report_type **DF** 'Spam' **CK** (report_type **IN** report_type), reported → authorized_user **NN**, reporter → authorized_user **NN**, manages → administrator **NN**) |
| R11                | user_event(<ins>user_id → authorized_user</ins>,<ins>event_id → event</ins>, accepted) |
| R12                | administrator(<ins>#user_id → authorized_user</ins>) |

### 2. Domains

| Domain Name  | Domain Specification           |
| -----------  | ------------------------------ |
| member_role   | ENUM ('owner', 'moderator', 'participant') |
| report_type | ENUM ('Spam', 'Nudity or sexual activity', 'Hate speech or symbols', 'Violence or dangerous organisations', 'Bullying or harassment', 'Selling illegal or regulated goods', 'Scams or fraud', 'False information') |
| report_status | ENUM('waiting', 'ignored', 'sanctioned')|

### 3. Schema validation

| **TABLE R01**   | authorized_user     |
| --------------  | ---                |
| **Keys**        | { user_id }, { email }, {url}  |
| **Functional Dependencies:** |       |
| FD0101          | user_id → {name, surname, nickname, password, email, date_registered, last_seen, birth_date, url, status, is_admin, photo_path} |
| FD0102          | email → {user_id, name, surname, nickname, password, date_registered, last_seen, birth_date, url, status, is_admin, photo_path} |
| FD0103          | url → {user_id, name, surname, nickname, password, email, date_registered, last_seen, birth_date, status, is_admin, photo_path}  |         |
| **NORMAL FORM** | BCNF               |


| **TABLE R02**   | event              |
| --------------  | ---                |
| **Keys**        | {event_id}         |
| **Functional Dependencies:** |       |
| FD0201          | event_id → {name, descriprion, start_date, location, schedule} |
| **NORMAL FORM** | BCNF               |


| **TABLE R03**   | notification       |
| --------------  | ---                |
| **Keys**        | {notification_id}  |
| **Functional Dependencies:** |       |
| FD0301          | notification_id → {text, date, user_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R04**   | photo              |
| --------------  | ---                |
| **Keys**        | { photo_id}        |
| **Functional Dependencies:** |       |
| FD0401          | photo_id → {upload_date, image_path, event_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R05**   | poll               |
| --------------  | ---                |
| **Keys**        | { poll_id }        |
| **Functional Dependencies:** |       |
| FD0501          | poll_id → {title, content, start_date, end_date, user_id, event_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R06**   | poll_option         |
| --------------  | ---                |
| **Keys**        | { poll_option_id }     |
| **Functional Dependencies:** |       |
| FD0601          | poll_option_id → {option, poll_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R07**   | comments            |
| --------------  | ---                |
| **Keys**        | { comment_id } |
| **Functional Dependencies:** |       |
| FD0701          | comment_id → {publish_date, description, comment_id, event_id, user_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R08**   | tag                |
| --------------  | ---                |
| **Keys**        | { tag_id } |
| **Functional Dependencies:** |       |
| FD0801          | tag_id → {name, color, event_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R09**   | poll_vote               |
| --------------  | ---                |
| **Keys**        | { vote_id } |
| **Functional Dependencies:** |       |
| FD0901          | vote_id → {date, user_id, poll_option_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R10**   | report             |
| --------------  | ---                |
| **Keys**        | { report_id }|
| **Functional Dependencies:** |       |
| FD1001          | report_id → {text, report_status, report_type, reported, reporter, manages} |
| **NORMAL FORM** | BCNF               |


| **TABLE R11**   | user_event         |
| --------------  | ---                |
| **Keys**        | { user_id }, { event_id }  |
| **Functional Dependencies:** |       |
| FD1701          | user_id, member_role, event_id → {accepted} |
| **NORMAL FORM** | BCNF               |


| **TABLE R12**   | administrator      |
| --------------  | ---                |
| **Keys**        | { user_id }        |
| **Functional Dependencies:** |       |
| FD1801          | none               |
| **NORMAL FORM** | BCNF               |

The Schema is already in BCNF. Every relation is in BCNF (Boyce-Codd Normal Form).

### Annex A. SQL Code
The SQL script that contains the creation statements, cleans up the current database state (Drops).

**A.1 Database Schema**
~~~~sql
-----------------------------------------
-- EXTENSIONS
-----------------------------------------

CREATE EXTENSION IF NOT EXISTS citext;


-----------------------------------------
-- DROPPING TABLES
-----------------------------------------
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
drop type if exists REPORT_STATUS;
CREATE TYPE REPORT_STATUS AS ENUM('Spam', 'Nudity or sexual activity', 'Hate speech or symbols', 'Violence or dangerous organisations', 'Bullying or harassment', 'Selling illegal or regulated goods', 'Scams or fraud', 'False information');

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


CREATE TABLE IF NOT EXISTS comments(
    id SERIAL PRIMARY KEY,
    comment_text TEXT DEFAULT ('Great event!'),
    user_id uuid,
    event_id INT,
    parent_comment_id INT DEFAULT NULL, -- null if a new comment and comment_id of the parent if a reply
    comment_date DATE DEFAULT (current_date) CHECK (comment_date <= current_date),
		FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),   
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
    vote_id SERIAL PRIMARY KEY,
    user_id uuid,
	event_id INT,
    option_id INT,
    date DATE NOT NULL,
    FOREIGN KEY (vote_id) REFERENCES poll(id),
    FOREIGN KEY (user_id, event_id) REFERENCES user_event (user_id, event_id),  
    FOREIGN KEY (option_id) REFERENCES poll_option(id)
);


~~~~


## A6: Indexes, triggers, transactions and database population

This artifact contains information about workload of the  database, the identification and characterisation of the indexes, triggers and transaction to support the data integrity rules and the physical schema of the complete database.

### 1. Database Workload
 
Understanding the potential load on databases and the speed of their growth will help creating well structured and dedicated database design for fast and stable work of the service. Database workload includes an estimate of the number of tuples for each relation and the estimated growth.\
The designation 1+ means several, 10+ means tens, 100+ means hundreds, and so on.

| **Relation reference** | **Relation Name** | **Order of magnitude**        | **Estimated growth** |
| ------------------ | ------------- | ------------------------- | -------- |
| R01  | authorized_user 	| 10.000+   | 10+  |
| R02  | event          	| 1.000+ 	| 1+   |
| R03  | notification   	| 10.000+	| 10+  |
| R04  | photo          	| 10.000+	| 10+  |
| R05  | poll		    	| 1.000+ 	| 1+   |
| R06  | poll_option     	| 1.000+ 	| 1+   |
| R07  | comment        	| 10.000+ 	| 10+  |
| R08  | tag        		| 1000+		| 1+   |
| R09  | vote        		| 1.000+ 	| 1+   |
| R10  | report      		| 100+		| 1+   |
| R11  | user_event    		| 10.000+   | 10+  |
| R12  | administrator      | 10+       | 1+   |


### 2. Proposed Indices

Indexes are used to improve database performance by allowing the database server to work with certain rows much faster. Once an index is created, the system must keep it in sync with the table, which increases the load on data processing operations. Because indexes add to the load on the database system, we should try not to overuse them.

#### 2.1. Performance Indices

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | authorized_user    				       |
| **Attribute**       | surname								   |
| **Type**            | b-tree             					   |
| **Cardinality**     | high                                   |
| **Clustering**      | No                                     |
| **Justification**   | The'authorized_user' table has a huge wokrload. Index ensures fast counting of the number of users by surname.     |
| **SQL code**		  |`CREATE INDEX IF NOT EXISTS idx_id_user ON authorized_user USING BTREE(surename);` |





| **Index**           | IDX02                                  |
| ---                 | ---                                    |
| **Relation**        | user_event    						   |
| **Attribute**       | event_id							   |
| **Type**            | hash             					   |
| **Cardinality**     | medium                                 |
| **Clustering**      | No                                     |
| **Justification**   | The main purpose of this index is to ease the search of people associated with an specific event, during search equality (=) will be used. `select user_id from user_event where event_id = 1;`       | 
| **SQL code**		  |`CREATE INDEX IF NOT EXISTS idx_event_user on user_event USING hash(event_id);` |



| **Index**           | IDX03                                            |
| ---                 | ---                                              |
| **Relation**        | poll_vote    							         |
| **Attribute**       | id								                 |
| **Type**            | hash             					             |
| **Cardinality**     | medium                                           |
| **Clustering**      | No                                               |
| **Justification**   | This index lets us count all the votes for a specific poll. `select select count(*) from poll_vote where poll_id = 1;` equality operator is used, hence the hash index type is suggested.       |
| **SQL code**		  |`CREATE INDEX IF NOT EXISTS idx_poll_vote on poll_vote USING hash(id);` |



#### 2.2. Full-text Search Indices 

| **Index**           | IDX11                                  |
| ---                 | ---                                    |
| **Relation**        | event    |
| **Attribute**       | name, description, location   |
| **Type**            | GIN              |
| **Clustering**      | NO                |
| **Justification**   | To provide full-text search features search for events based on name, description and location. The index type is GIN because the indexed fields are not expected to change often.   |

SQL IDX11 CODE:
~~~~sql
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

~~~~


| **Index**           | IDX12                                  |
| ---                 | ---                                    |
| **Relation**        | tag    |
| **Attribute**       | name   |
| **Type**            | GIST              |
| **Clustering**      | NO                |
| **Justification**   | To improve overall performance of full-text searches while searching for events by tags; GiST better for dynamic data   |
| **SQL code**        |`CREATE INDEX IF NOT EXISTS idx_tag_name ON tag USING GIST (name);`   |


### 3. Triggers
 

| **Trigger**      | TRIGGER01                              |
| ---              | ---                                    |
| **Description**  | Sends a notification after user submits a report to assure him it's delivered. |

SQL TRIGGER01 CODE:
~~~~sql
CREATE OR REPLACE FUNCTION report_notification() RETURNS trigger AS $report_notification$ 
BEGIN 
	INSERT INTO 
	notification(user_id, notification_type, notification_date, notification_text) 
	select NEW.reporter_id, 'report', NEW.report_date, 'Thank you for your report. 
	We will check information given as fast as possible. Report status: ' || NEW.report_status || ' Message: ' || NEW.report_text from report; 
RETURN new; 
END; 
$report_notification$ 
language plpgsql; 
				
DROP TRIGGER IF EXISTS trig_report ON public.report; 
											
CREATE TRIGGER trig_report					
AFTER INSERT ON report						
FOR EACH ROW								
EXECUTE PROCEDURE report_notification();` 
~~~~

| **Trigger**      | TRIGGER02                              |
| ---              | ---                                    |
| **Description**  | Sends a notification after a new poll is created|

SQL TRIGGER02 CODE:
~~~~sql
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
~~~~


| **Trigger**      | TRIGGER03                              |
| ---              | ---                                    |
| **Description**  | Sends a notification when a user joins an event. |

SQL TRIGGER03 CODE:
~~~~sql 
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
~~~~

| **Trigger**      | TRIGGER04                              |
| ---              | ---                                    |
| **Description**  | Sends a notification to the creator of a comment when a comment is replied by another user. |

SQL TRIGGER03 CODE:
~~~~sql 
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
~~~~


| **Trigger**      | TRIGGER05                              |
| ---              | ---                                    |
| **Description**  | When name/surename inserted into authorized_user table, the trigger capitalizes the fisrt letter. |
| **Priority US**  | Medium                                 |


### 4. Transactions
 
> Transactions needed to assure the integrity of the data.  

| SQL Reference   | TRAN01                      |
| --------------- | ----------------------------------- |
| Description     | Create a new event          |
| Justification   | When user tries to create a new event it's important to use a transaction to ensure that all the code executes without errors. If an error occurs, a ROLLBACK is issued (when the insertion of new event fails or creation of new line in the user_event). The isolation level is Repeatable Read, because, otherwise, there is a chance that event_update table can be changed by other function and as a result, inconsistent data would be stored.  |
| Isolation level | REPEATABLE READ |

~~~~sql
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
-- event
INSERT INTO event (name, description, start_date, is_public, location)
 VALUES ($name, $description, GETDATE(), $is_public, $location);

-- user_event
INSERT INTO user_event (role, accepted)
 VALUES ('Owner', TRUE);

END TRANSACTION; 
~~~~


### Annex A. SQL Code
SQL script in included. It cintains the creation statements, cleans up the current database state 'The SQL script is cleaned (e.g. excluded from export comments)' - don't understand what does it mean. Indexes, triggers, transactions and database population - to be provided at A6.

## A.1 Database Schema

The SQL creation script is expanded in the A6 to include indexes, triggers, and transactions.

~~~~sql
-----------------------------------------
-- EXTENSIONS
-----------------------------------------

-- The citext module provides a case-insensitive character string type. 
-- Essentially, it internally calls lower when comparing values.
-- https://www.postgresql.org/docs/current/citext.html
CREATE EXTENSION IF NOT EXISTS citext;


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
CREATE INDEX IF NOT EXISTS idx_id_user ON authorized_user USING BTREE(surename);

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

		 
~~~~~

### A.2. Database population

In this section the population of each table of our Database is defined

~~~~sql
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (1, 'Heddi', 'Minichillo', 'hminichillo0', '3JZ7phQwF', 'hminichillo0@qq.com', '10/5/2022', '10/21/2022', '5/30/1971', 'profile page url', 'massa volutpat convallis morbi odio odio elementum eu interdum eu tincidunt in', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/KZSURBVDjLpVPdS5NRGP+97tVpw9nm5tpShiSsFhMMImiCQlAOk+im7Ma6UKK86g+oCMKwgi66CLuQ7rqqBRVRQS2aFIFeCA7xQjC3qbkcus/345zTc5aNoqALX3h4znPO+X085z1HEU');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (2, 'Sonni', 'Doogan', 'sdoogan1', 'TzHLPf', 'sdoogan1@angelfire.com', '10/5/2022', '10/25/2022', '7/1/1967', 'profile page url', 'ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae nulla dapibus dolor vel est donec odio justo', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/GASURBVDjLxVO7agJRED3XN4gPkEWwET/AysoqoE3+wcIPCEvEVsgnhJXgF4j+QraJLFjkAyxEsFCwsBYU32bPyF7WkEDAIs');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (3, 'Fons', 'Bavin', 'fbavin2', '7UHNVxcrgB', 'fbavin2@stumbleupon.com', '10/5/2022', '10/13/2022', '3/2/1970', 'profile page url', 'sapien a libero nam dui proin leo odio porttitor id consequat in consequat', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/JpSURBVDjLpZNNSJRhEMd/z7vr9m7t2oopZl/UoVWpQ0RC0EFL6FAQ4a0OXbrVLaJDEdStjhEUFQVBHaIuSocIomtWJvYFRhb51eqaH7vu7vu8zzvTQbENvDkwDAzMj+E//zGqymrCY5URBx');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (4, 'Arin', 'Malarkey', 'amalarkey3', 'HbcArCz2IH', 'amalarkey3@marriott.com', '10/3/2022', '10/11/2022', '4/10/2013', 'profile page url', 'iaculis diam erat fermentum justo nec condimentum neque sapien placerat', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/NsSURBVDjLdZNrTNNnGMWb+M3wRaObc/plSxYToiZzc94quCGCVRfMnwYtUiyuUhUQKqtcCmhatAgEaKlcBNFSBYQ5lSIgQ0GFttRCL0BBoAVUVFKo/UtLBXJsiZp5+3CS98N7fjnnyf');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (5, 'Jeth', 'Munkley', 'jmunkley4', 'pYuzuOcBBNb', 'jmunkley4@comcast.net', '10/4/2022', '10/18/2022', '12/25/2008', 'profile page url', 'dolor vel est donec odio justo sollicitudin ut suscipit a feugiat et eros vestibulum ac est', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/H8SURBVDjLjZPLaxNRFIfHLrpx10WbghXxH7DQx6p14cadiCs31Y2LLizYhdBFWyhYaFUaUxLUQFCxL61E+0gofWGLRUqGqoWp2JpGG8g4ybTJJJm8689');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (6, 'Yolanda', 'Martinson', 'ymartinson5', 'eYZtk9yc', 'ymartinson5@gizmodo.com', '10/5/2022', '10/18/2022', '7/7/1973', 'profile page url', 'nisl aenean lectus pellentesque eget nunc donec quis orci eget orci vehicula condimentum', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/JcSURBVDjLjZJNSFRRFIC/N29m1PEHNSUc/5WUoj+zAXe6ctmiQNtEFIWLoAhXbYcWkZCge2vTqghKyk2oREVa1hAI6SINQhpRGs3Gee++e0+LGZ9jtuhw');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (7, 'Gerick', 'Monnelly', 'gmonnelly6', 'SDAfzq3N', 'gmonnelly6@unc.edu', '10/7/2022', '10/19/2022', '5/16/1992', 'profile page url', 'feugiat non pretium quis lectus suspendisse potenti in eleifend quam a odio in', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/MLSURBVDjLXZNbSBRRHMaHSHrpKehCYTch06AoTEiyy0MPEVFIUbYkqOFmgoZZBK2uli3VlrHeVitzUzPqoTT00VoqLe1CIomL3XPD3dnZ2ZnZcXac2fk6M+VY/eF3OPzP//vg');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (8, 'Chaddie', 'Bernardet', 'cbernardet7', 'MrsN1ike', 'cbernardet7@imgur.com', '10/3/2022', '10/13/2022', '6/1/2000', 'profile page url', 'justo etiam pretium iaculis justo in hac habitasse platea dictumst etiam faucibus cursus', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/JQSURBVDjLpVNNaBNBFH6RTVNimmQtpg1EpCFVXONPTD1UViQeoihIPXgXURTFXjyKiAh6EkFEFCweCiKIh4IWWqihULC2aRpqC62bSlqRQjZ6CEm6OzOb9');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (9, 'Silvano', 'Mudd', 'smudd8', 'JXbttY5Uyln', 'smudd8@vk.com', '10/5/2022', '10/26/2022', '4/24/1969', 'profile page url', 'amet cursus id turpis integer aliquet massa id lobortis convallis tortor risus dapibus', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/H5SURBVDjLpZK/a5NhEMe/748kRqypmqQQgz/oUPUPECpCoEVwyNStIA6COFR33boIjg6mg4uL0k0EO1RFISKImkHQxlbQRAsx0dgKJm/e53nunnOwViR5leJnuZs+973jHBHB/+D/+++//EtQ7n0/sOTe0/+/+');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (10, 'Morgen', 'Diperaus', 'mdiperaus9', 'LwnOnfcEt', 'mdiperaus9@jugem.jp', '10/7/2022', '10/20/2022', '7/1/1991', 'profile page url', 'pharetra magna ac consequat metus sapien ut nunc vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/IiSURBVDjLpdNdSFNhGAdw6baL7qUuuonA6Cojoiw6qwth0VUsDIxKggohIXGtpA+1DxQhwoltsXKjNpbruC9q5jypMwf2sdlqbc120ixzfqzV8L');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (11, 'Abdel', 'Putten', 'aputtena', 'DU6v1vdv0t', 'aputtena@skype.com', '10/4/2022', '10/15/2022', '2/21/1961', 'profile page url', 'nascetur ridiculus mus vivamus vestibulum sagittis sapien cum sociis natoque penatibus et magnis dis parturient montes', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/JUSURBVDjLpVPNaxNBFP8lqY1JSJOGFBtSU11BaEulUUFB7EUalB70kINCQfBv8FgNgvRUJCdPUj36FxgqKahpi18NSQXBikRbE6UfYpNtsruzO+ubTTa/');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (12, 'Mame', 'Portch', 'mportchb', 'liLZ6WRhYM', 'mportchb@amazon.de', '10/6/2022', '10/30/2022', '1/29/2011', 'profile page url', 'dolor morbi vel lectus in quam fringilla rhoncus mauris enim leo rhoncus sed vestibulum', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/HwSURBVDjLpZM9a1RBFIafM/fevfcmC7uQjWEjUZKAYBHEVEb/gIWFjVVSWEj6gI0/wt8gprPQykIsTP5BQLAIhBVBzRf52Gw22bk7c8YiZslugggZppuZ55z3nfdICIHrrBhg+ePaa1WZPyk0s+6KWwM1');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (13, 'Hobey', 'Passler', 'hpasslerc', 'APtUOoadJMi', 'hpasslerc@bloglines.com', '10/6/2022', '10/16/2022', '9/1/1998', 'profile page url', 'pellentesque quisque porta volutpat erat quisque erat eros viverra eget congue', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/JhSURBVDjLdZPda85hGMc/v+f5Pc8e2wE2QtiMyZh5K4RSpCkHxJnkSElOxJFy4kDyF3DopR15yUst2pRpJw4cSJLETCTb0mxre57f775eHPyevdBcdXfV3X19ru/36rojd+fwuZtt7n7PYQRnt+O4A++/////+/++iWE7x71UVj//bxZ+4+=');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (14, 'Kippy', 'Juris', 'kjurisd', 'v39vTDY', 'kjurisd@smugmug.com', '10/2/2022', '10/22/2022', '6/26/1960', 'profile page url', 'volutpat convallis morbi odio odio elementum eu interdum eu tincidunt in leo maecenas pulvinar lobortis est phasellus sit amet', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/HVSURBVDjLjZPLaiJBFIZNHmJWCeQdMuT1Mi/gYlARBRUkao+abHUhmhgU0QHtARVxJ0bxhvfGa07Of5Iu21yYFPyLrqrz1f');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (15, 'Caro', 'Singleton', 'csingletone', 'Xbzmg3r', 'csingletone@huffingtonpost.com', '10/4/2022', '10/24/2022', '8/7/1961', 'profile page url', 'a suscipit nulla elit ac nulla sed vel enim sit', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/HlSURBVDjLpVPLShxBFD3T3WOUUUGYByhkI+50o6Bmo3ErAVG3Qvb5giyThets8gmC+DYQzEaGBMUnBhQRJAEXQuZJ8Mlodz28t6rbGY2b4IXqU1XcOvfc01UxrTWeEx5/ptbOssQzILVylVKQChCMkucagrA6JKTQtK+uJyc6Gg2B0npwvLfJ+Z/KH2Z+J+/+/+/+Q6ZHT+==');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (16, 'Truda', 'Daouse', 'tdaousef', 'BDxHfMRw', 'tdaousef@usatoday.com', '10/5/2022', '10/21/2022', '7/17/1999', 'profile page url', 'elementum ligula vehicula consequat morbi a ipsum integer a nibh in quis justo maecenas', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/KxSURBVDjLdZNfSFNRHMc3FVNEBTWFFH0wTAVf9NEeiiLNh+ohKZIykKSHegssJXqZVFbiKsOUNAkhMu7wz8zgqjk3LndbOnVuorPdbboZsc0/zKs4+XbOdU4jPfC9v3PO73w/53cu58gAyKhIk+/++/YAAAAABJRU5ErkJggg==');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (17, 'Burr', 'MacAnellye', 'bmacanellyeg', 'g4JykWT9Z', 'bmacanellyeg@squidoo.com', '10/5/2022', '10/23/2022', '10/19/1976', 'profile page url', 'dapibus duis at velit eu est congue elementum in hac habitasse', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/JtSURBVDjLjdNNSJRBHMfx7zzP7uKTGtLqSoeCCEKigiBQI0qkpEuHTp4svXjyYp2COhedDTok9g577aAlhtUhPBi+RLVlaBhr69uumuvus8/M/DusbikdnNvAzPDhP7+fEhHGx8cv/+Tyq');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (18, 'Griff', 'Vaszoly', 'gvaszolyh', 'zZbKF3ouMf5k', 'gvaszolyh@blogtalkradio.com', '10/7/2022', '10/15/2022', '3/6/1970', 'profile page url', 'eu orci mauris lacinia sapien quis libero nullam sit amet turpis elementum ligula vehicula consequat morbi a ipsum integer a', false, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/BIG/KROKHVOPF8X5rCeIv1BuMMK1GOI02nyZsiH769DVcBYXRsrWzGeocTz1x2ht0VtXxKj/Jl+v1y0dCg/vVMl4daXKg');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (19, 'Olly', 'Cannon', 'ocannoni', 'DDvhooOxf', 'ocannoni@spotify.com', '10/5/2022', '10/30/2022', '3/23/1992', 'profile page url', 'eget eros elementum pellentesque quisque porta volutpat erat quisque erat eros viverra eget congue eget semper rutrum nulla nunc', true, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/+StHUkxruBPY+0KY8f38oWX/byvNAdluHNLeOxDB+uyQQfPCWZ3NT69BYJWkjxjnB1o9Fv/ASQ5s+ABz8i2AAAAAElFTkSuQmCC');
insert into authorized_user (ID, name, surname, nickname, password, email, date_registered, last_Seen, birth_date, url, status, is_admin, photo_path) values (20, 'Ulberto', 'Skedge', 'uskedgej', '9oc7AOA0NURJ', 'uskedgej@harvard.edu', '10/2/2022', '10/15/2022', '8/22/1966', 'profile page url', 'interdum mauris ullamcorper purus sit amet nulla quisque arcu libero rutrum ac lobortis vel dapibus at diam nam tristique', true, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/xtj6g96fXTpPmtUIcEiedj5PLhQIShTHiyw6N+/zdxuGro3uMwpf+/sQnDg0Jp+wram5p62xp4ZajgDxnOwLBuU5OArcSCxZEJwGn');

insert into event (event_id, name, description, start_date, location, schedule) values (1, 'Dia da Universidade', 'description of the event', '6/16/2022', 'Nesebar', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (2, 'Planta o Futuro', 'description of the event', '3/4/2022', 'Chon Buri', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (3, 'Mostra da U.Porto', 'description of the event', '8/13/2022', 'Bouças', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (4, 'Planta o Futuro', 'description of the event', '6/8/2022', 'El Hajeb', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (5, 'Eventos das faculdades', 'description of the event', '7/20/2022', 'Xinji', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (6, 'Tomorrow Summit 2020', 'description of the event', '5/13/2022', 'Panggulan', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (7, 'Eventos das faculdades', 'description of the event', '3/10/2022', 'Khorramdarreh', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (8, 'Eventos das faculdades', 'description of the event', '8/9/2022', 'Wucheng', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (9, 'Tomorrow Summit 2020', 'description of the event', '6/25/2022', 'Leworook', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (10, 'Eventos estudantis', 'description of the event', '6/27/2022', 'Chezhan', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (11, 'XIV Edição da Semana da Saúde', 'description of the event', '2/13/2022', 'Chatian', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (12, 'XIV Edição da Semana da Saúde', 'description of the event', '8/13/2022', 'Concepción', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (13, 'Pitch Bootcamp FAP', 'description of the event', '8/6/2022', 'Zhangzhu', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (14, 'Sessão de boas-vindas', 'description of the event', '8/13/2022', 'Mauraro', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (15, 'eflexARTE', 'description of the event', '7/27/2022', 'Ciwidara', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (16, 'Queima das Fitas do Porto 2020', 'description of the event', '9/4/2022', 'Livramento do Brumado', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (17, 'Escola de Líderes Diogo VasconcelosFAP', 'description of the event', '9/10/2022', 'Tanahwangko', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (18, 'Pitch Bootcamp FAP', 'description of the event', '10/30/2022', 'Batasan', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (19, 'Universidade Júnior', 'description of the event', '5/4/2022', 'Pulosari', 'event specification');
insert into event (event_id, name, description, start_date, location, schedule) values (20, 'Tomorrow Summit 2020', 'description of the event', '1/9/2022', 'Salimbalan', 'event specification');

insert into notification (notifications_id, text, date, ID) values (1, 'Poll Notification', '1/18/2022', 14);
insert into notification (notifications_id, text, date, ID) values (2, 'Report Notification', '5/21/2022', 20);
insert into notification (notifications_id, text, date, ID) values (3, 'Comment Notification', '1/29/2022', 2);
insert into notification (notifications_id, text, date, ID) values (4, 'Event Notification', '2/10/2022', 14);
insert into notification (notifications_id, text, date, ID) values (5, 'Comment Notification', '3/17/2022', 20);
insert into notification (notifications_id, text, date, ID) values (6, 'Event Notification', '2/19/2022', 8);
insert into notification (notifications_id, text, date, ID) values (7, 'Report Notification', '9/15/2022', 11);
insert into notification (notifications_id, text, date, ID) values (8, 'Report Notification', '8/5/2022', 10);
insert into notification (notifications_id, text, date, ID) values (9, 'Comment Notification', '2/10/2022', 8);
insert into notification (notifications_id, text, date, ID) values (10, 'Report Notification', '4/28/2022', 4);
insert into notification (notifications_id, text, date, ID) values (11, 'Report Notification', '9/12/2022', 8);
insert into notification (notifications_id, text, date, ID) values (12, 'Event Notification', '3/27/2022', 8);
insert into notification (notifications_id, text, date, ID) values (13, 'Comment Notification', '7/21/2022', 1);
insert into notification (notifications_id, text, date, ID) values (14, 'Report Notification', '12/22/2021', 20);
insert into notification (notifications_id, text, date, ID) values (15, 'Poll Notification', '2/28/2022', 8);
insert into notification (notifications_id, text, date, ID) values (16, 'Comment Notification', '9/30/2022', 12);
insert into notification (notifications_id, text, date, ID) values (17, 'Poll Notification', '3/31/2022', 10);
insert into notification (notifications_id, text, date, ID) values (18, 'Report Notification', '8/8/2022', 6);
insert into notification (notifications_id, text, date, ID) values (19, 'Event Notification', '4/14/2022', 5);
insert into notification (notifications_id, text, date, ID) values (20, 'Poll Notification', '7/18/2022', 19);

insert into photo (id, upload_date, image_path, event_id) values (1, '5/2/2022', 'SodalesScelerisqueMauris.jpeg', 1);
insert into photo (id, upload_date, image_path, event_id) values (2, '9/7/2022', 'ViverraDapibusNulla.png', 2);
insert into photo (id, upload_date, image_path, event_id) values (3, '4/14/2022', 'QuamTurpis.png', 3);
insert into photo (id, upload_date, image_path, event_id) values (4, '2/13/2022', 'SemperSapienA.doc', 4);
insert into photo (id, upload_date, image_path, event_id) values (5, '8/31/2022', 'Et.png', 5);
insert into photo (id, upload_date, image_path, event_id) values (6, '12/1/2021', 'InHac.ppt', 6);
insert into photo (id, upload_date, image_path, event_id) values (7, '6/16/2022', 'OdioCurabiturConvallis.ppt', 7);
insert into photo (id, upload_date, image_path, event_id) values (8, '3/28/2022', 'SedInterdumVenenatis.xls', 8);
insert into photo (id, upload_date, image_path, event_id) values (9, '8/9/2022', 'Dignissim.avi', 9);
insert into photo (id, upload_date, image_path, event_id) values (10, '9/6/2022', 'AmetConsectetuer.ppt', 10);
insert into photo (id, upload_date, image_path, event_id) values (11, '10/1/2022', 'Volutpat.jpeg', 11);
insert into photo (id, upload_date, image_path, event_id) values (12, '2/7/2022', 'NullaQuisque.jpeg', 12);
insert into photo (id, upload_date, image_path, event_id) values (13, '3/14/2022', 'TellusNullaUt.ppt', 13);
insert into photo (id, upload_date, image_path, event_id) values (14, '5/10/2022', 'NasceturRidiculus.ppt', 14);
insert into photo (id, upload_date, image_path, event_id) values (15, '1/28/2022', 'In.mp3', 15);
insert into photo (id, upload_date, image_path, event_id) values (16, '5/17/2022', 'Orci.mpeg', 16);
insert into photo (id, upload_date, image_path, event_id) values (17, '12/26/2021', 'PotentiCrasIn.ppt', 17);
insert into photo (id, upload_date, image_path, event_id) values (18, '3/29/2022', 'OdioCrasMi.mp3', 18);
insert into photo (id, upload_date, image_path, event_id) values (19, '5/31/2022', 'EtCommodo.xls', 19);
insert into photo (id, upload_date, image_path, event_id) values (20, '12/25/2021', 'UtDolorMorbi.gif', 20);
insert into photo (id, upload_date, image_path, event_id) values (21, '10/6/2022', 'AmetConsectetuerAdipiscing.mp3', 21);
insert into photo (id, upload_date, image_path, event_id) values (22, '12/6/2021', 'Donec.pdf', 22);
insert into photo (id, upload_date, image_path, event_id) values (23, '2/20/2022', 'FelisSed.avi', 23);
insert into photo (id, upload_date, image_path, event_id) values (24, '6/10/2022', 'Sollicitudin.xls', 24);
insert into photo (id, upload_date, image_path, event_id) values (25, '11/21/2021', 'VolutpatSapienArcu.ppt', 25);
insert into photo (id, upload_date, image_path, event_id) values (26, '10/19/2022', 'PorttitorLacusAt.avi', 26);
insert into photo (id, upload_date, image_path, event_id) values (27, '8/28/2022', 'Phasellus.jpeg', 27);
insert into photo (id, upload_date, image_path, event_id) values (28, '7/8/2022', 'Cursus.pdf', 28);
insert into photo (id, upload_date, image_path, event_id) values (29, '10/2/2022', 'Aenean.xls', 29);
insert into photo (id, upload_date, image_path, event_id) values (30, '3/30/2022', 'MassaQuis.doc', 30);
insert into photo (id, upload_date, image_path, event_id) values (31, '5/31/2022', 'DapibusDolorVel.jpeg', 31);
insert into photo (id, upload_date, image_path, event_id) values (32, '9/27/2022', 'Orci.mp3', 32);
insert into photo (id, upload_date, image_path, event_id) values (33, '9/30/2022', 'NequeLibero.tiff', 33);
insert into photo (id, upload_date, image_path, event_id) values (34, '3/7/2022', 'NonLectusAliquam.doc', 34);
insert into photo (id, upload_date, image_path, event_id) values (35, '8/7/2022', 'Magna.jpeg', 35);
insert into photo (id, upload_date, image_path, event_id) values (36, '3/19/2022', 'PotentiCras.mov', 36);
insert into photo (id, upload_date, image_path, event_id) values (37, '4/10/2022', 'PrimisInFaucibus.mpeg', 37);
insert into photo (id, upload_date, image_path, event_id) values (38, '7/17/2022', 'UtMauris.tiff', 38);
insert into photo (id, upload_date, image_path, event_id) values (39, '1/26/2022', 'Vestibulum.mp3', 39);
insert into photo (id, upload_date, image_path, event_id) values (40, '6/11/2022', 'Urna.ppt', 40);
insert into photo (id, upload_date, image_path, event_id) values (41, '7/9/2022', 'Curabitur.xls', 41);
insert into photo (id, upload_date, image_path, event_id) values (42, '6/8/2022', 'QuamPharetra.doc', 42);
insert into photo (id, upload_date, image_path, event_id) values (43, '9/2/2022', 'PortaVolutpat.txt', 43);
insert into photo (id, upload_date, image_path, event_id) values (44, '1/4/2022', 'Justo.mp3', 44);
insert into photo (id, upload_date, image_path, event_id) values (45, '10/14/2022', 'NuncCommodo.avi', 45);
insert into photo (id, upload_date, image_path, event_id) values (46, '4/10/2022', 'FelisEuSapien.mov', 46);
insert into photo (id, upload_date, image_path, event_id) values (47, '5/5/2022', 'VestibulumVestibulum.txt', 47);
insert into photo (id, upload_date, image_path, event_id) values (48, '10/29/2022', 'Vestibulum.tiff', 48);
insert into photo (id, upload_date, image_path, event_id) values (49, '10/16/2022', 'Orci.tiff', 49);
insert into photo (id, upload_date, image_path, event_id) values (50, '7/3/2022', 'PhasellusId.avi', 50);

insert into poll (id, title, content, starts_at, end_at, event_id) values (1, '8/8/2022', 'Durable Medical Equipment', '9/19/2022', '4/10/2022', 1);
insert into poll (id, title, content, starts_at, end_at, event_id) values (2, '12/5/2021', 'TCA', '10/19/2022', '5/9/2022', 2);
insert into poll (id, title, content, starts_at, end_at, event_id) values (3, '7/29/2022', 'RF Test', '9/26/2022', '10/2/2022', 3);
insert into poll (id, title, content, starts_at, end_at, event_id) values (4, '10/3/2022', 'Long-term Customer Relationships', '1/16/2022', '2/25/2022', 4);
insert into poll (id, title, content, starts_at, end_at, event_id) values (5, '6/29/2022', 'RPAS', '10/20/2022', '12/20/2021', 5);
insert into poll (id, title, content, starts_at, end_at, event_id) values (6, '5/6/2022', 'IEC 61850', '12/7/2021', '7/8/2022', 6);
insert into poll (id, title, content, starts_at, end_at, event_id) values (7, '10/26/2022', 'Staff Development', '3/22/2022', '7/21/2022', 7);
insert into poll (id, title, content, starts_at, end_at, event_id) values (8, '7/23/2022', 'Lloyds', '10/29/2022', '12/22/2021', 8);
insert into poll (id, title, content, starts_at, end_at, event_id) values (9, '6/5/2022', 'XNA', '4/17/2022', '5/3/2022', 9);
insert into poll (id, title, content, starts_at, end_at, event_id) values (10, '8/4/2022', 'Basic HTML', '1/23/2022', '5/31/2022', 10);
insert into poll (id, title, content, starts_at, end_at, event_id) values (11, '7/8/2022', 'Dynamics', '11/9/2021', '1/10/2022', 11);
insert into poll (id, title, content, starts_at, end_at, event_id) values (12, '9/21/2022', 'Workforce Management', '5/1/2022', '12/12/2021', 12);
insert into poll (id, title, content, starts_at, end_at, event_id) values (13, '1/8/2022', 'WFC', '7/4/2022', '12/22/2021', 13);
insert into poll (id, title, content, starts_at, end_at, event_id) values (14, '2/4/2022', 'International Sales', '4/9/2022', '12/6/2021', 14);
insert into poll (id, title, content, starts_at, end_at, event_id) values (15, '6/16/2022', 'Oil Industry', '5/27/2022', '3/11/2022', 15);
insert into poll (id, title, content, starts_at, end_at, event_id) values (16, '1/13/2022', 'Jenkins', '12/30/2021', '2/13/2022', 16);
insert into poll (id, title, content, starts_at, end_at, event_id) values (17, '2/13/2022', 'PPPoE', '7/6/2022', '3/6/2022', 17);
insert into poll (id, title, content, starts_at, end_at, event_id) values (18, '8/15/2022', 'TV Production', '1/9/2022', '10/18/2022', 18);
insert into poll (id, title, content, starts_at, end_at, event_id) values (19, '5/21/2022', 'GSM', '6/1/2022', '12/1/2021', 19);
insert into poll (id, title, content, starts_at, end_at, event_id) values (20, '11/28/2021', 'Flight Training', '3/28/2022', '11/6/2021', 20);

insert into poll_option (id, option, poll_id) values (1, 'Bamity', 1);
insert into poll_option (id, option, poll_id) values (2, 'Asoka', 2);
insert into poll_option (id, option, poll_id) values (3, 'Y-find', 3);
insert into poll_option (id, option, poll_id) values (4, 'Namfix', 4);
insert into poll_option (id, option, poll_id) values (5, 'Toughjoyfax', 5);
insert into poll_option (id, option, poll_id) values (6, 'Zontrax', 6);
insert into poll_option (id, option, poll_id) values (7, 'Bigtax', 7);
insert into poll_option (id, option, poll_id) values (8, 'Hatity', 8);
insert into poll_option (id, option, poll_id) values (9, 'Tin', 9);
insert into poll_option (id, option, poll_id) values (10, 'Transcof', 10);
insert into poll_option (id, option, poll_id) values (11, 'Zaam-Dox', 11);
insert into poll_option (id, option, poll_id) values (12, 'Sub-Ex', 12);
insert into poll_option (id, option, poll_id) values (13, 'Kanlam', 13);
insert into poll_option (id, option, poll_id) values (14, 'Duobam', 14);
insert into poll_option (id, option, poll_id) values (15, 'Bitchip', 15);
insert into poll_option (id, option, poll_id) values (16, 'Alphazap', 16);
insert into poll_option (id, option, poll_id) values (17, 'Tresom', 17);
insert into poll_option (id, option, poll_id) values (18, 'Zamit', 18);
insert into poll_option (id, option, poll_id) values (19, 'Fintone', 19);
insert into poll_option (id, option, poll_id) values (20, 'Solarbreeze', 20);

insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (1, '15KkGGtTei9TvmpYYZEZgQ9ADEDapEA9pj', 1, 1, 1, '8/30/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (2, '1Ejp62ojhnxWKUsRanrrM6FBw7GvsMNLc4', 2, 2, 2, '9/4/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (3, '1LPP7ngej9oWsyzMp7ye5XPDukfMbBN3Ko', 3, 3, 3, '11/18/2021');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (4, '1DvfCLHPDQ7dhzCM4CMY9ezaWSxkusJbRa', 4, 4, 4, '7/27/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (5, '1LbQRHbzS8oWqanZE8RqQBoxoKdR5atcES', 5, 5, 5, '9/8/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (6, '1GUBeYYTFZ2CKqUYTBqAaUpSn3TnZPBDqe', 6, 6, 6, '7/23/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (7, '17LP9NrAAfqkGfULKCN6nhWube6JR5ieeN', 7, 7, 7, '11/2/2021');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (8, '1LLECuRdX4Yvpi7NKNtRcZNcjE5MxzxZJS', 8, 8, 8, '5/6/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (9, '1BtnkPJxSPLioEPg95ZBQacZBLsXtuhkK2', 9, 9, 9, '5/15/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (10, '174ygiz4GNTW918QRGAGjhN3YurZtz8nev', 10, 10, 10, '8/8/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (11, '1LaCAJjt43A6hNdZN4TEc7f7UCJw31qB4X', 11, 11, 11, '12/10/2021');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (12, '1u2hkcmhEkFgskwcNKcAsEDCwTr56GKGJ', 12, 12, 12, '11/3/2021');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (13, '1KrU19d9m4j2dL4fsKo4CW9Nafh8uVNt7g', 13, 13, 13, '2/14/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (14, '1EWEaYqg1QdbpdcggCYV3aBFtTvePCNkFQ', 14, 14, 14, '12/17/2021');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (15, '1PCRP7uMvuYBCgHnzqnqCDzShMpSLmRPqx', 15, 15, 15, '9/27/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (16, '1aK3eUWnzUwyfjQogRjU5BtaR1v5EWz5D', 16, 16, 16, '1/1/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (17, '1PeXAPSEWbKB4gUqh79hnmKfQCcH4XRXmH', 17, 17, 17, '8/2/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (18, '1FVsGjzrrcNpttfLjhc46kuLPfFdGN29Zd', 18, 18, 18, '1/29/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (19, '15u1Xbvv9APP3VewxBWVdya8yykqE5AmHU', 19, 19, 19, '7/18/2022');
insert into comment (id, comment_text, ID, event_id, parent_comment_id, comment_date) values (20, '1mZpjVBMQ4T7LTADoEY9PbEUGLcSFeEih', 20, 20, 20, '4/14/2022');

insert into tag (id, name, color, event_id) values (1, 'Alphazap', 'Puce', 1);
insert into tag (id, name, color, event_id) values (2, 'Cardguard', 'Red', 2);
insert into tag (id, name, color, event_id) values (3, 'Job', 'Aquamarine', 3);
insert into tag (id, name, color, event_id) values (4, 'Konklab', 'Red', 4);
insert into tag (id, name, color, event_id) values (5, 'Quo Lux', 'Green', 5);
insert into tag (id, name, color, event_id) values (6, 'Prodder', 'Green', 6);
insert into tag (id, name, color, event_id) values (7, 'Viva', 'Fuscia', 7);
insert into tag (id, name, color, event_id) values (8, 'Matsoft', 'Violet', 8);
insert into tag (id, name, color, event_id) values (9, 'Redhold', 'Puce', 9);
insert into tag (id, name, color, event_id) values (10, 'Voltsillam', 'Aquamarine', 10);
insert into tag (id, name, color, event_id) values (11, 'Quo Lux', 'Crimson', 11);
insert into tag (id, name, color, event_id) values (12, 'Latlux', 'Blue', 12);
insert into tag (id, name, color, event_id) values (13, 'Trippledex', 'Purple', 13);
insert into tag (id, name, color, event_id) values (14, 'Trippledex', 'Blue', 14);
insert into tag (id, name, color, event_id) values (15, 'Wrapsafe', 'Maroon', 15);
insert into tag (id, name, color, event_id) values (16, 'Alphazap', 'Pink', 16);
insert into tag (id, name, color, event_id) values (17, 'Fintone', 'Fuscia', 17);
insert into tag (id, name, color, event_id) values (18, 'Wrapsafe', 'Green', 18);
insert into tag (id, name, color, event_id) values (19, 'Sonair', 'Orange', 19);
insert into tag (id, name, color, event_id) values (20, 'Asoka', 'Fuscia', 20);

insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (1, 1, 1, 1, 1, '11/23/2021');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (2, 2, 2, 2, 2, '6/13/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (3, 3, 3, 3, 3, '9/23/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (4, 4, 4, 4, 4, '4/20/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (5, 5, 5, 5, 5, '5/31/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (6, 6, 6, 6, 6, '11/15/2021');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (7, 7, 7, 7, 7, '2/7/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (8, 8, 8, 8, 8, '5/3/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (9, 9, 9, 9, 9, '5/21/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (10, 10, 10, 10, 10, '3/17/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (11, 11, 11, 11, 11, '10/5/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (12, 12, 12, 12, 12, '9/17/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (13, 13, 13, 13, 13, '12/29/2021');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (14, 14, 14, 14, 14, '11/6/2021');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (15, 15, 15, 15, 15, '1/19/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (16, 16, 16, 16, 16, '11/17/2021');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (17, 17, 17, 17, 17, '11/30/2021');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (18, 18, 18, 18, 18, '12/18/2021');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (19, 19, 19, 19, 19, '6/28/2022');
insert into poll_vote (id, poll_id, ID, event_id, option_id, date) values (20, 20, 20, 20, 20, '1/6/2022');

insert into report (id, reported_id, reporter_id, admin_id, report_text, report_date, report_type, report_status) values (1, 1, 1, 1, 'visualize rich convergence', '5/31/2022', 'Hate speech or symbols', 'Waiting');
insert into report (id, reported_id, reporter_id, admin_id, report_text, report_date, report_type, report_status) values (2, 2, 2, 2, 'cultivate real-time synergies', '4/6/2022', 'Nudity or sexual activity', 'Ignored');
insert into report (id, reported_id, reporter_id, admin_id, report_text, report_date, report_type, report_status) values (3, 3, 3, 3, 'streamline plug-and-play applications', '3/10/2022', 'Nudity or sexual activity', 'Ignored');

insert into administrator(ID) values(19);
insert into administrator(ID) values(20);

~~~~~~



## Revision history

1. A6-1 was changed.
2. All names were changed according to the underscore notation (name, long_name). registered_user was chaged to authorized_user
3. report/comment/poll/event notification-tables were removed - added triggers instead. Guests-table removed.  David. 
4. UML simplified, indexes started.
5. Added description to many items. Added 6 new indexes (the description of some indexes needs improvement). Existing indexes are also left.
***
GROUP21122, 12/10/2022

* João Sousa, up201904739@up.pt    
* Mikhail Ermolaev, up202203498@up.pt
* David Burchakov, up202203777@up.pt
* Válter Castro, up201706546@up.pt
