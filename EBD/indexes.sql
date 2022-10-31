
--PERFORMANCE INDEXES

CREATE INDEX idx_event_name ON event USING HASH (name);
CREATE INDEX idx_event_startDate ON event USING BTREE (start_date);
CREATE INDEX idx_poll_startAt ON Poll USING BTREE (starts_at);

--FULL TEXT SEARCH INDEXES

CREATE INDEX idx_tag_name ON tag USING GIST (name);
CREATE INDEX idx_user_name ON authorized_user USING GIST (name);
CREATE INDEX idx_event_location ON event USING GIST (location);
