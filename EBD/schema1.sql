CREATE EXTENSION IF NOT EXISTS citext;
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
CREATE EXTENSION IF NOT EXISTS btree_gist;

DROP TABLE IF EXISTS RegisteredUser CASCADE;
DROP TABLE IF EXISTS Administrator CASCADE;
DROP TABLE IF EXISTS Event CASCADE;
DROP TABLE IF EXISTS Report;
DROP TABLE IF EXISTS Invite;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Notification CASCADE;
DROP TABLE IF EXISTS ReportNotification;
DROP TABLE IF EXISTS PollNotification;
DROP TABLE IF EXISTS EventNotification;
DROP TABLE IF EXISTS CommentNotification;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Photo;
DROP TABLE IF EXISTS Poll CASCADE;
DROP TABLE IF EXISTS PollOption CASCADE;
DROP TABLE IF EXISTS PollVote;

DO $$ BEGIN
    CREATE TYPE REPORT_STATUS AS ENUM('Going', 'Maybe', 'Cant');
EXCEPTION
    WHEN DUPLICATE_OBJECT THEN NULL;
END $$;

DO $$ BEGIN
    CREATE TYPE MEMBER_ROLE AS ENUM('Owner', 'Moderator', 'Participant');
EXCEPTION
    WHEN DUPLICATE_OBJECT THEN NULL;
END $$;

CREATE TABLE IF NOT EXISTS RegisteredUser(
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
CREATE TABLE IF NOT EXISTS Administrator(
    ID SERIAL PRIMARY KEY,
    adminID uuid DEFAULT uuid_generate_v4 (),
    FOREIGN KEY (adminID) REFERENCES RegisteredUser(ID)
);
CREATE TABLE IF NOT EXISTS Event(
    ID SERIAL PRIMARY KEY,
    name TEXT DEFAULT 'DEFAULT name' NOT NULL,
    description TEXT DEFAULT('FEUP party') NOT NULL,
    start_date TIMESTAMP DEFAULT (
        to_timestamp('05 Dec 2023 22:00', 'DD Mon YYYY HH24:MI')
    ) NOT NULL,
    is_public BOOLEAN DEFAULT TRUE NOT NULL,
    location TEXT DEFAULT 'Adega Leonor' NOT NULL,
    schedule TEXT,
    role MEMBER_ROLE
);
CREATE TABLE IF NOT EXISTS Report(
    ID SERIAL PRIMARY KEY,
    reportedID uuid DEFAULT uuid_generate_v4 (),
    reporterID uuid DEFAULT uuid_generate_v4 (),
    adminID SERIAL,
    text TEXT NOT NULL,
    report_status REPORT_STATUS,
    FOREIGN KEY (reportedID) REFERENCES RegisteredUser(ID),
    FOREIGN KEY (reporterID) REFERENCES RegisteredUser(ID),
    FOREIGN KEY (adminID) REFERENCES Administrator(ID)
);
CREATE TABLE IF NOT EXISTS Invite(
    ID SERIAL PRIMARY KEY,
    userID uuid DEFAULT uuid_generate_v4 (),
    eventID SERIAL,
    accepted BOOLEAN,
    FOREIGN KEY (userID) REFERENCES RegisteredUser(ID),
    FOREIGN KEY (eventID) REFERENCES Event(ID)
);
CREATE TABLE IF NOT EXISTS Comment(
    ID SERIAL PRIMARY KEY,
    publish_date DATE DEFAULT (current_date) CHECK (publish_date <= current_date),
    userID uuid DEFAULT uuid_generate_v4 (),
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
    userID uuid DEFAULT uuid_generate_v4 (),
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
    upload_date DATE DEFAULT (current_date),
    image_path TEXT UNIQUE,
    eventID SERIAL,
    FOREIGN KEY (eventID) REFERENCES Event(ID)
);
CREATE TABLE IF NOT EXISTS Poll(
    ID SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    starts_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP check(starts_at <= CURRENT_TIMESTAMP) NOT NULL,
    end_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL '1 DAY') check(end_at > starts_at) NOT NULL,
    userID uuid DEFAULT uuid_generate_v4 (),
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
    userID uuid DEFAULT uuid_generate_v4 (),
    optionID SERIAL,
    date DATE NOT NULL,
    FOREIGN KEY (voteID) REFERENCES Poll(ID),
    FOREIGN KEY (userID) REFERENCES RegisteredUser(ID),
    FOREIGN KEY (optionID) REFERENCES PollOption(ID)
);