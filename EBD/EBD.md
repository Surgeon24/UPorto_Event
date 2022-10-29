# EBD: Database Specification Component

***UPortoEvent*** will able all students of "Universidade do Porto" to explore all sorts of events inside their academic environment. Therefore in these three artifacts we will present our Database for this project. This way you'll see how your data will be stored.

## A4: Conceptual Data Model

In A4 we will take over our first database topic. This will cover the **Class Diagram** which compiles all entities, attributes and relations of our database, in order to stre efficiently all website information.

### 1. Class diagram

![A4- UML_Diagram](images/A4-%20UPortoEventUML.jpg)

### 2. Additional Business Rules
 
- BR01 : Only registred users who participate on the event can make comments and answer to polls.
- BR02 : Only event creators can delete or cancel the event. So event moderators, can´t.
- BR03 : Only Participants of an specific event can vote in polls
---


## A5: Relational Schema, validation and schema refinement

In A5 we are going to interpretate de UML diagram into the Relational Schema, so that SQL code turns out better. This more specific model represets out data base less abstract in a more concise way.

### 1. Relational Schema

| Relation reference | Relation Compact Notation                        |
| ------------------ | ------------------------------------------------ |
| R01                | RegisteredUser(<ins>user_id</ins>, name **NN**, surname **NN**, nickname **NN**, password **NN**, email **UK** **NN**, date_registered, last_seen **NN**, birth_date **NN**, url **UK** **NN**, status, is_admin, photo_path ) |
| R02                | Event(<ins>event_id</ins>, name **NN**, descriprion **NN**, start_date **NN**, location **NN**, schedule **NN**, role **DF** 'Participant' **CK** (role **IN** MemberRole)) ) |
| R03                | Notification(<ins>notification_id</ins>, text **NN**, date **NN**, #user_id → RegisteredUser **NN** ) |
| R04                | Photo(<ins>photo_id</ins>, upload_date **NN**, image_path **NN**, #event_id → Event ) |
| R05				 | Poll(<ins>poll_id</ins>, title **NN**, content **NN**, start_date **NN**, end_date **NN**, #user_id → RegisteredUser **NN**, #event_id → Event **NN** ) |
| R06				 | PollOption(<ins>pOption_id</ins>, option **NN**, #poll_id → Poll **NN**) |
| R07   			 | Comment(<ins>comment_id</ins>, publish_date **NN**, description **NN**, #comment_id → Comment **NN**, #event_id → Event **NN**, #user_id → RegisteredUser **NN** ) |
| R08    			 | Tag(<ins>tag_id</ins>, name **NN**, color **NN**, #event_id → Event **NN** ) |
| R09  			     | PollVote(<ins>vote_id</ins>, date **NN**, #user_id → RegisteredUser **NN**, #pOption_id → PollOption **NN** ) |
| R10 				 | Report(<ins>report_id</ins>, text **NN**, report_status **DF** 'Waiting' **CK** (Report_status **IN** ReportStatus), reported → RegisteredUser **NN**, reporter → RegisteredUser **NN**, manages → Administrator **NN**) |
| R11  				 | Guest(<ins>guest_id</ins>, ip **NN** **UK**, time **NN**) |
| R12                | Report_Notification(<ins>#notification_id → Notification **NN**</ins>, #report → Report **NN**) |
| R13                | Poll_Notification(<ins>#notification_id → Notification **NN**</ins>, #poll → Poll **NN**) |
| R14                | Event_Notification(<ins>#notification_id → Notification **NN**</ins>, #event → Event **NN**) |
| R15                | Comment_Notification(<ins>#notification_id → Notification **NN**</ins>, #comment → Comment **NN**) |
| R16                | Event_RegisteredUser(<ins>event_id → Event</ins>, <ins>user_id → RegisteredUser</ins>) |
| R17                | Invite(<ins>user_id → Registered_User</ins>,<ins>event_id → Event</ins>, accepted) |
| R18                | Administrator(<ins>#user_id → RegisteredUser</ins>) |

### 2. Domains

| Domain Name  | Domain Specification           |
| -----------  | ------------------------------ |
| MemberRole   | ENUM ('Owner', 'Moderator', 'Participant') |
| ReportStatus | ENUM ('Waiting', 'Ignored', 'Sanctioned') |

### 3. Schema validation

| **TABLE R01**   | RegisteredUser     |
| --------------  | ---                |
| **Keys**        | { user_id }, { email }, {url}  |
| **Functional Dependencies:** |       |
| FD0101          | user_id → {name, surname, nickname, password, email, date_registered, last_seen, birth_date, url, status, is_admin, photo_path} |
| FD0102          | email → {user_id, name, surname, nickname, password, date_registered, last_seen, birth_date, url, status, is_admin, photo_path} |
| FD0103          | url → {user_id, name, surname, nickname, password, email, date_registered, last_seen, birth_date, status, is_admin, photo_path}  |         |
| **NORMAL FORM** | BCNF               |


| **TABLE R02**   | Event              |
| --------------  | ---                |
| **Keys**        | {event_id}         |
| **Functional Dependencies:** |       |
| FD0201          | event_id → {name, descriprion, start_date, location, schedule, role} |
| **NORMAL FORM** | BCNF               |


| **TABLE R03**   | Notification       |
| --------------  | ---                |
| **Keys**        | {notification_id}  |
| **Functional Dependencies:** |       |
| FD0301          | notification_id → {text, date, user_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R04**   | Photo              |
| --------------  | ---                |
| **Keys**        | { photo_id}        |
| **Functional Dependencies:** |       |
| FD0401          | photo_id → {upload_date, image_path, event_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R05**   | Poll               |
| --------------  | ---                |
| **Keys**        | { poll_id }        |
| **Functional Dependencies:** |       |
| FD0501          | poll_id → {title, content, start_date, end_date, user_id, event_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R06**   | PollOption         |
| --------------  | ---                |
| **Keys**        | { pOption_id }     |
| **Functional Dependencies:** |       |
| FD0601          | pOption_id → {option, poll_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R07**   | Comment            |
| --------------  | ---                |
| **Keys**        | { comment_id } |
| **Functional Dependencies:** |       |
| FD0701          | comment_id → {publish_date, description, comment_id, event_id, user_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R08**   | Tag                |
| --------------  | ---                |
| **Keys**        | { tag_id } |
| **Functional Dependencies:** |       |
| FD0801          | tag_id → {name, color, event_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R09**   | PollVote               |
| --------------  | ---                |
| **Keys**        | { vote_id } |
| **Functional Dependencies:** |       |
| FD0901          | vote_id → {date, user_id, pOption_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R10**   | Report             |
| --------------  | ---                |
| **Keys**        | { report_id }|
| **Functional Dependencies:** |       |
| FD1001          | report_id → {text, report_status, reported, reporter, manages} |
| **NORMAL FORM** | BCNF               |


| **TABLE R11**   | Guest              |
| --------------  | ---                |
| **Keys**        | { guest_id }  |
| **Functional Dependencies:** |       |
| FD1101          | guest_id → {ip, time} |
| **NORMAL FORM** | BCNF               |


| **TABLE R12**   | Report_Notification|
| --------------  | ---                |
| **Keys**        | { notification_id }  |
| **Functional Dependencies:** |       |
| FD1201          | notification_id → {report_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R13**   | Poll_Notification  |
| --------------  | ---                |
| **Keys**        | { notification_id }  |
| **Functional Dependencies:** |       |
| FD1301          | notification_id → {poll_id}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R14**   | Event_Notification |
| --------------  | ---                |
| **Keys**        | { notification_id } |
| **Functional Dependencies:** |       |
| FD1401          | notification_id → {event_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R15**   |Comment_Notification|
| --------------  | ---                |
| **Keys**        | { notification_id } |
| **Functional Dependencies:** |       |
| FD1501          | notification_id → {comment_id} |
| **NORMAL FORM** | BCNF               |


| **TABLE R16**   |Event_RegisteredUser|
| --------------  | ---                |
| **Keys**        | { event_id }, { user_id }  |
| **Functional Dependencies:** |       |
| FD1601          | none               |
| **NORMAL FORM** | BCNF               |


| **TABLE R17**   | Invite             |
| --------------  | ---                |
| **Keys**        | { user_id }, { event_id }  |
| **Functional Dependencies:** |       |
| FD1701          | user_id, event_id → {accepted} |
| **NORMAL FORM** | BCNF               |


| **TABLE R18**   | Administrator      |
| --------------  | ---                |
| **Keys**        | { user_id }        |
| **Functional Dependencies:** |       |
| FD1801          | none               |
| **NORMAL FORM** | BCNF               |

The Schema is already in BCNF. Every relation is in BCNF (Boyce-Codd Normal Form).



## A6: Indexes, triggers, transactions and database population

> Brief presentation of the artefact goals.

### 1. Database Workload
 
Understanding the potential load on databases and the speed of their growth will help creating well structured and dedicated database design for fast and stable work of the service. Database workload includes an estimate of the number of tuples for each relation and the estimated growth.\
The designation 1+ means several, 10+ means tens, 100+ means hundreds, and so on.

| **Relation reference** | **Relation Name** | **Order of magnitude**        | **Estimated growth** |
| ------------------ | ------------- | ------------------------- | -------- |
| R01  | RegisteredUser 	| 10.000+   | 10+  |
| R02  | Event          	| 1.000+ 	| 1+   |
| R03  | Notification   	| 10.000+	| 10+  |
| R04  | Photo          	| 10.000+	| 10+  |
| R05  | Poll		    	| 1.000+ 	| 1+   |
| R06  | PollOption     	| 1.000+ 	| 1+   |
| R07  | Comment        	| 100.000+ 	| 100+ |
| R08  | Tag        		| 1000+		| 1+   |
| R09  | Vote        		| 1.000+ 	| 1+   |
| R10  | Report      		| 100+		| 1+   |
| R11  | Guest       		| 1 | - |
| R12  | Report_Notification| 100+ 		| 1+   |
| R13  | Poll_Notification  | 1.000+ 	| 1+   |
| R14  | Event_Notification | 1.000+ 	| 1+   |
| R15  |Comment_Notification| 10.000+ 	| 10+  |
| R16  |Event_RegisteredUser| 100.000+  | 100+ |
| R17  | Invite       		| 10.000+   | 10+  |
| R18  | Administrator      | 10+       | 1+   |


### 2. Proposed Indices

#### 2.1. Performance Indices
 
> Indices proposed to improve performance of the identified queries.

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | Event    							   |
| **Attribute**       | name								   |
| **Type**            | Hash             					   |
| **Cardinality**     | medium                                 |
| **Clustering**      | No                                     |
| **Justification**   | This Index will    |
| `SQL code`                                                  ||


#### 2.2. Full-text Search Indices 

> The system being developed must provide full-text search features supported by PostgreSQL. Thus, it is necessary to specify the fields where full-text search will be available and the associated setup, namely all necessary configurations, indexes definitions and other relevant details.  

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | Relation where the index is applied    |
| **Attribute**       | Attribute where the index is applied   |
| **Type**            | B-tree, Hash, GiST or GIN              |
| **Clustering**      | Clustering of the index                |
| **Justification**   | Justification for the proposed index   |
| `SQL code`                                                  ||


### 3. Triggers
 
> User-defined functions and trigger procedures that add control structures to the SQL language or perform complex computations, are identified and described to be trusted by the database server. Every kind of function (SQL functions, Stored procedures, Trigger procedures) can take base types, composite types, or combinations of these as arguments (parameters). In addition, every kind of function can return a base type or a composite type. Functions can also be defined to return sets of base or composite values.  

| **Trigger**      | TRIGGER01                              |
| ---              | ---                                    |
| **Description**  | Trigger description, including reference to the business rules involved |
| `SQL code`                                             ||

### 4. Transactions
 
> Transactions needed to assure the integrity of the data.  

| SQL Reference   | Transaction Name                    |
| --------------- | ----------------------------------- |
| Justification   | Justification for the transaction.  |
| Isolation level | Isolation level of the transaction. |
| `Complete SQL Code`                                   ||

### Annex A. SQL Code
SQL script in included. It cintains the creation statements, cleans up the current database state 'The SQL script is cleaned (e.g. excluded from export comments)' - don't understand what does it mean. Indexes, triggers, transactions and database population - to be provided at A6.

## A.1 Database Schema

The SQL creation script is expanded in the A6 to include indexes, triggers, and transactions.


~~~~sql
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
DROP TABLE IF EXISTS registered_user;
DROP TABLE IF EXISTS guests;

-- Q - questions to the teacher

-- Q - ask about the quize
-- 25 November


create table IF NOT EXISTS guests(
	id_guest SERIAL,
	ip text NOT NULL
);


create table IF NOT EXISTS registered_user(
	-- Q uuid - do we need it, is it ok? Professor liked it
	user_id uuid DEFAULT uuid_generate_v4 () PRIMARY KEY,
	name VARCHAR default 'name' NOT NULL,
	surename VARCHAR default 'family name' NOT NULL,
	nickname VARCHAR UNIQUE NOT NULL,
	password text default sha256('default_password') NOT NULL,
	email citext UNIQUE NOT NULL,
	birth_date date default (current_date - INTERVAL '18 YEAR') CHECK (birth_date <= (current_date - INTERVAL '18 YEAR')),
	date_registered TIMESTAMP default current_timestamp NOT NULL,
	-- Q last log in. Good?
	-- Yes
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
	
	FOREIGN KEY (participant_id) REFERENCES registered_user (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE,
	FOREIGN KEY (creator_id) REFERENCES registered_user (user_id)
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

	FOREIGN KEY (user_id) REFERENCES registered_user (user_id)
										ON DELETE CASCADE
										ON UPDATE CASCADE
);





-- Q should we have two table for event and user photos each?

-- Q maybe bytea for RegisteredUser and talbe for event?

-- Q should I add automatic trigger that would add empty photo row when user is registered?  

create table IF NOT EXISTS user_photo(
	user_photo_id SERIAL,
	file bytea,
	added_on timestamp default current_timestamp,
	added_by uuid,

	-- Q should we have 'image_path' UNIQUE row?
	
	FOREIGN KEY (added_by) REFERENCES registered_user (user_id)
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

~~~~~




---


## Annex A. SQL Code

> The database scripts are included in this annex to the EBD component.
> The database creation script and the population script should be presented as separate elements.
> The creation script includes the code necessary to build (and rebuild) the database.
> The population script includes an amount of tuples suitable for testing and with plausible values for the fields of the database.
> The complete code of each script must be included in the groups git repository and links added here.

### A.1. Database schema

> The complete database creation must be included here and also as a script in the repository.

### A.2. Database population

> Only a sample of the database population script may be included here, e.g. the first 10 lines. The full script must be available in the repository.

---


## Revision history

1. A6-1 was changed.


***
GROUP21122, 12/10/2022

* João Sousa, up201904739@up.pt    
* Mikhail Ermolaev, up202203498@up.pt
* David Burchakov, up202203777@up.pt
* Válter Castro, up201706546@up.pt
