CREATE EXTENSION IF NOT EXISTS citext;
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

DROP TABLE IF EXISTS RegisteredUser;
DROP TABLE IF EXISTS Administrator;
DROP TABLE IF EXISTS Event;
DROP TABLE IF EXISTS Report;
DROP TABLE IF EXISTS Invite;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Notification;
DROP TABLE IF EXISTS ReportNotification;
DROP TABLE IF EXISTS PollNotification;
DROP TABLE IF EXISTS EventNotification;
DROP TABLE IF EXISTS CommentNotification;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Photo;
DROP TABLE IF EXISTS Poll;
DROP TABLE IF EXISTS PollOption;
DROP TABLE IF EXISTS PollVote;

CREATE TYPE STATUS AS enum ('Going', 'Maybe', 'Cant');
CREATE TYPE MEMBERROLE AS enum ('Owner', 'Moderator', 'Participant');


CREATE TABLE IF NOT EXISTS RegisteredUser(
    ID uuid DEFAULT uuid_generate_v4 () PRIMARY KEY,
	name TEXT DEFAULT 'name' NOT NULL,
	surename TEXT DEFAULT 'family name' NOT NULL,
	nickname TEXT UNIQUE NOT NULL,
	password TEXT DEFAULT sha256('DEFAULT_password') NOT NULL,
	email citext UNIQUE NOT NULL,
	date_registered TIMESTAMP DEFAULT current_timestamp NOT NULL,
	last_seen TIMESTAMP,
	birth_date DATE DEFAULT (current_date - INTERVAL '18 YEAR') CHECK LowerOrEqualThanCurrentDatePlus18 (birth_date <= (current_date - INTERVAL '18 YEAR')),
	url URL UNIQUE,
	status TEXT,
	is_admin BOOLEAN DEFAULT false NOT NULL,
	photo_path TEXT	

);
CREATE TABLE IF NOT EXISTS Administrator(
    ID SERIAL PRIMARY KEY,
    FOREIGN KEY (userID) REFERENCES RegisteredUser(ID)
);
CREATE TABLE IF NOT EXISTS Event(
    ID SERIAL PRIMARY KEY,
	name TEXT DEFAULT 'DEFAULT name' NOT NULL,
	description TEXT DEFAULT('FEUP party') NOT NULL,
	start_date TIMESTAMP DEFAULT (to_timestamp('05 Dec 2023 22:00', 'DD Mon YYYY HH24:MI')) NOT NULL,
	is_public BOOLEAN DEFAULT True NOT NULL,
	location TEXT DEFAULT 'Adega Leonor' NOT NULL,
	schedule TEXT ,
    role MEMBERROLE

);
CREATE TABLE IF NOT EXISTS Report(
    ID SERIAL PRIMARY KEY,
    reportedID SERIAL PRIMARY KEY,
    reporterID SERIAL ,
    adminID SERIAL ,
    text TEXT NOT NULL,
    report_status STATUS,

    FOREIGN KEY (reportedID) REFERENCES RegisteredUser(ID),
    FOREIGN KEY (reporterID) REFERENCES RegisteredUser(ID),
    FOREIGN KEY (adminID) REFERENCES Administrator(ID),
);
CREATE TABLE IF NOT EXISTS Invite(
    ID SERIAL PRIMARY KEY,
    userID SERIAL,
    eventID SERIAL,
    accepted BOOLEAN,
    FOREIGN KEY (userID) REFERENCES RegisteredUser(ID),
    FOREIGN KEY (eventID) REFERENCES Event(ID)
);
CREATE TABLE IF NOT EXISTS Comment(
    ID SERIAL PRIMARY KEY,
    publish_date DATE DEFAULT (current_date) CHECK LowerOrEqualThanCurrentDate (publish_date <= current_date),
    userID SERIAL,
    eventID SERIAL,
    commentID SERIAL,
    FOREIGN KEY (userID) REFERENCES RegisteredUser(ID),
    FOREIGN KEY (eventID) REFERENCES Event(ID),
    FOREIGN KEY (commentID) REFERENCES Comment(ID)
);
CREATE TABLE IF NOT EXISTS Notification(
    ID SERIAL PRIMARY KEY,
    text TEXT NOT NULL,
    date DATE NOT NULL,
    userID SERIAL,
    FOREIGN KEY (userID) REFERENCES RegisteredUser(ID)
);
CREATE TABLE IF NOT EXISTS ReportNotification(
    reportID SERIAL PRIMARY KEY,
    FOREIGN KEY (reportID) REFERENCES Notification(ID)
);
CREATE TABLE IF NOT EXISTS PollNotification(
    pollID SERIAL PRIMARY KEY,
    FOREIGN KEY (pollID) REFERENCES Notification(ID)
);
CREATE TABLE IF NOT EXISTS EventNotification(
    eventID SERIAL PRIMARY KEY,
    FOREIGN KEY (eventID) REFERENCES Notification(ID)
);
CREATE TABLE IF NOT EXISTS CommentNotification(
    commentID SERIAL PRIMARY KEY,
    FOREIGN KEY (commentID) REFERENCES Notification(ID)
);
CREATE TABLE IF NOT EXISTS Tag(
    ID SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    color TEXT NOT NULL,
    eventID SERIAL,
    FOREIGN KEY (eventID) REFERENCES Event(ID)
);
CREATE TABLE IF NOT EXISTS Photo(
    ID SERIAL PRIMARY KEY,
    upload_date DATE DEFAULT (current_date) ,
    image_path TEXT UNIQUE,
    eventID SERIAL,
    FOREIGN KEY (eventID) REFERENCES Event(ID)
);
CREATE TABLE IF NOT EXISTS Poll(
    ID SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    starts_at DATE DEFAULT (current_date) CHECK LowerThanStartsAt (ends_at < current_date),
    ends_at DATE DEFAULT (starts_at + INTERVAL '1 DAY'),
    userID SERIAL,
    eventID SERIAL,
    FOREIGN KEY (eventID) REFERENCES Event(ID),
    FOREIGN KEY (userID) REFERENCES RegisteredUser(ID)
);
CREATE TABLE IF NOT EXISTS PollOption(
    ID SERIAL PRIMARY KEY,
    option TEXT NOT NULL,
    pollID SERIAL,
    FOREIGN KEY (pollID) REFERENCES Poll(ID)
);
CREATE TABLE IF NOT EXISTS PollVote(
    voteID SERIAL PRIMARY KEY,
    userID SERIAL,
    optionID SERIAL,
    date DATE NOT NULL,
    FOREIGN KEY (voteID) REFERENCES Poll(ID),
    FOREIGN KEY (userID) REFERENCES RegisteredUser(ID)
    FOREIGN KEY (optionID) REFERENCES PollOption(ID)
);