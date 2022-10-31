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
| R01                | authorised_user(<ins>user_id</ins>, name **NN**, surname **NN**, nickname **NN**, password **NN**, email **UK** **NN**, date_registered, last_seen **NN**, birth_date **NN**, url **UK** **NN**, status, is_admin, photo_path ) |
| R02                | event(<ins>event_id</ins>, name **NN**, descriprion **NN**, start_date **NN**, location **NN**, schedule **NN**, role **DF** 'participant' **CK** (role **IN** member_role)) ) |
| R03                | notification(<ins>notification_id</ins>, text **NN**, date **NN**, #user_id → authorised_user **NN** ) |
| R04                | photo(<ins>photo_id</ins>, upload_date **NN**, image_path **NN**, #event_id → Event ) |
| R05				 | poll(<ins>poll_id</ins>, title **NN**, content **NN**, start_date **NN**, end_date **NN**, #user_id → authorised_user **NN**, #event_id → event **NN** ) |
| R06				 | poll_option(<ins>poll_option_id</ins>, option **NN**, #poll_id → poll **NN**) |
| R07   			 | comment(<ins>comment_id</ins>, publish_date **NN**, description **NN**, #comment_id → comment **NN**, #event_id → event **NN**, #user_id → authorised_user **NN** ) |
| R08    			 | tag(<ins>tag_id</ins>, name **NN**, color **NN**, #event_id → event **NN** ) |
| R09  			     | poll_vote(<ins>vote_id</ins>, date **NN**, #user_id → authorised_user **NN**, #poll_option_id → poll_option **NN** ) |
| R10 				 | report(<ins>report_id</ins>, text **NN**, report_status **DF** 'waiting' **CK** (report_status **IN** report_status), reported → authorised_user **NN**, reporter → authorised_user **NN**, manages → administrator **NN**) |
| R11                | user_event(<ins>user_id → authorised_user</ins>,<ins>event_id → event</ins>, accepted) |
| R12                | administrator(<ins>#user_id → authorised_user</ins>) |

### 2. Domains

| Domain Name  | Domain Specification           |
| -----------  | ------------------------------ |
| member_role   | ENUM ('owner', 'moderator', 'participant') |
| report_status | ENUM ('Spam', 'Nudity or sexual activity', 'Hate speech or symbols', 'Violence or dangerous organisations', 'Bullying or harassment', 'Selling illegal or regulated goods', 'Scams or fraud', 'False information') |

### 3. Schema validation

| **TABLE R01**   | authorised_user     |
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
| FD1001          | report_id → {text, report_status, reported, reporter, manages} |
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



## A6: Indexes, triggers, transactions and database population

> This artifact ................ 

### 1. Database Workload
 
Understanding the potential load on databases and the speed of their growth will help creating well structured and dedicated database design for fast and stable work of the service. Database workload includes an estimate of the number of tuples for each relation and the estimated growth.\
The designation 1+ means several, 10+ means tens, 100+ means hundreds, and so on.

| **Relation reference** | **Relation Name** | **Order of magnitude**        | **Estimated growth** |
| ------------------ | ------------- | ------------------------- | -------- |
| R01  | authorised_user 	| 10.000+   | 10+  |
| R02  | event          	| 1.000+ 	| 1+   |
| R03  | notification   	| 10.000+	| 10+  |
| R04  | photo          	| 10.000+	| 10+  |
| R05  | poll		    	| 1.000+ 	| 1+   |
| R06  | poll_option     	| 1.000+ 	| 1+   |
| R07  | comment        	| 10.000+ 	| 10+ |
| R08  | tag        		| 1000+		| 1+   |
| R09  | vote        		| 1.000+ 	| 1+   |
| R10  | report      		| 100+		| 1+   |
| R11  | user_event    		| 10.000+   | 10+  |
| R12  | administrator      | 10+       | 1+   |


### 2. Proposed Indices

#### 2.1. Performance Indices
 
> Indices proposed to improve performance of the identified queries.

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | authorised_user    							   |
| **Attribute**       | id								   |
| **Type**            | b-tree             					   |
| **Cardinality**     | high                                 |
| **Clustering**      | No                                     |
| **Justification**   | 'authorised_user' table has a huge wokrload. The id field is accessed frequently and has a uuid representation, which might slow down the searching process.      |
 
**SQL code**
~~~~
CREATE INDEX IF NOT EXISTS idx_id_user ON registered_user USING BTREE(id);
~~~~


| **Index**           | IDX02                                  |
| ---                 | ---                                    |
| **Relation**        | user_event    							   |
| **Attribute**       | event_id								   |
| **Type**            | b-tree             					   |
| **Cardinality**     | medium                                 |
| **Clustering**      | No                                     |
| **Justification**   | 'user_event' table is accessed very often.       |
 
**SQL code**
~~~~
CREATE INDEX IF NOT EXISTS idx_notification ON notification USING BTREE(notification_date);
~~~~

#### 2.2. Full-text Search Indices 

> The system being developed must provide full-text search features supported by PostgreSQL. Thus, it is necessary to specify the fields where full-text search will be available and the associated setup, namely all necessary configurations, indexes definitions and other relevant details.  

| **Index**           | IDX11                                  |
| ---                 | ---                                    |
| **Relation**        | event    |
| **Attribute**       | name   |
| **Type**            | GIN              |
| **Clustering**      | Clustering of the index                |
| **Justification**   | Indexing this table would allow users searching for events based on name fast.   |
| `SQL code`                                                  ||


| **Index**           | IDX12                                  |
| ---                 | ---                                    |
| **Relation**        | comments    |
| **Attribute**       | comment_text   |
| **Type**            | GIN              |
| **Clustering**      | Clustering of the index                |
| **Justification**   | allows users to fastly search comments   |
| `SQL code`                                                  ||


### 3. Triggers
 
> User-defined functions and trigger procedures that add control structures to the SQL language or perform complex computations, are identified and described to be trusted by the database server. Every kind of function (SQL functions, Stored procedures, Trigger procedures) can take base types, composite types, or combinations of these as arguments (parameters). In addition, every kind of function can return a base type or a composite type. Functions can also be defined to return sets of base or composite values.  

| **Trigger**      | TRIGGER01                              |
| ---              | ---                                    |
| **Description**  | Sends a notification after user submits a report to assure him it's delivered. |
~~~~ 
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
| **Description**  | sends a notification after a new poll is created

~~~~
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
~~~~ 
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
~~~~ 
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
2. All names were changed according to the underscore notation (name, long_name). registered_user was chaged to authorised_user
3. report/comment/poll/event notification-tables were removed - added triggers instead. Guests-table removed.  David. 

***
GROUP21122, 12/10/2022

* João Sousa, up201904739@up.pt    
* Mikhail Ermolaev, up202203498@up.pt
* David Burchakov, up202203777@up.pt
* Válter Castro, up201706546@up.pt
