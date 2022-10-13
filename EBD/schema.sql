create table registered_users(
	id SERIAL PRIMARY KEY,
	name VARCHAR default 'name' NOT NULL,
	surename VARCHAR default 'family name' NOT NULL,
	nickname VARCHAR UNIQUE NOT NULL,
	password text default sha256('default_password') NOT NULL,
	email citext UNIQUE NOT NULL,
	dateRegistered TIMESTAMP default current_timestamp NOT NULL,
	lastSeem TIMESTAMP,
	url text UNIQUE,
	isAdmin BOOLEAN DEFAULT false NOT NULL	
);
