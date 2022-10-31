
--PERFORMANCE INDEXES

CREATE INDEX idx_event_name ON event USING HASH (name);
CREATE INDEX idx_event_startDate ON event USING BTREE (start_date);


--FULL TEXT SEARCH INDEXES

CREATE INDEX IF NOT EXISTS idx_tag_name ON tag USING GIST (name);
CREATE INDEX IF NOT EXISTS idx_user_name ON authorized_user USING GIST (name);
CREATE INDEX IF NOT EXISTS idx_event_location ON event USING GIST (location);
