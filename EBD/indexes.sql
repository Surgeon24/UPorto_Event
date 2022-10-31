
--PERFORMANCE INDEXES

<<<<<<< HEAD
CREATE INDEX idx_event_name ON event USING HASH (name);
CREATE INDEX idx_event_startDate ON event USING BTREE (start_date);

=======
CREATE INDEX IF NOT EXISTS idx_event_name ON event USING HASH (name);
CREATE INDEX IF NOT EXISTS idx_event_start_date ON event USING BTREE (start_date);
CREATE INDEX IF NOT EXISTS idx_poll_start_at ON Poll USING BTREE (starts_at);
>>>>>>> 54dbd6f2b854292c42e532cfa16853b8d14beb5b

--FULL TEXT SEARCH INDEXES

CREATE INDEX IF NOT EXISTS idx_tag_name ON tag USING GIST (name);
CREATE INDEX IF NOT EXISTS idx_user_name ON authorized_user USING GIST (name);
CREATE INDEX IF NOT EXISTS idx_event_location ON event USING GIST (location);
