
--PERFORMANCE INDEXES

CREATE INDEX idx_event_name ON Event USING HASH (name);
CREATE INDEX idx_event_startDate ON Event USING BTREE (start_date);
CREATE INDEX idx_poll_startAt ON Event USING BTREE (starts_at);

--FULL TEXT SEARCH INDEXES

CREATE INDEX idx_tag_name ON Tag USING GIST (name);
CREATE INDEX idx_poll_title ON Poll USING GIST (title);
CREATE INDEX idx_event_location ON Event USING GIST (location);
