
--PERFORMANCE INDEXES

CREATE INDEX idx_event_name ON event USING HASH (name);

--This index is related to the name of an event and is to be executed 
--many times so it must be fast; doesn’t support range query support; 
--cardinality is medium meaning it’s a good candidate for clustering.


CREATE INDEX idx_event_startDate ON event USING BTREE (start_date);

--This index is for searching an event according to is start_date and is to be executed 
--many times so it must be fast. B-tree is a good candidate for clustering to 
--allow for quick range queries; Cardinality is medium



--FULL TEXT SEARCH INDEXES

CREATE INDEX IF NOT EXISTS idx_tag_name ON tag USING GIST (name);


--To improve overall performance of full-text searches while searching for tags by name; GiST better for dynamic data


CREATE INDEX IF NOT EXISTS idx_user_name ON authorized_user USING GIST (name);


--To improve overall performance of full-text searches while searching for users by name; GiST better for dynamic data


CREATE INDEX IF NOT EXISTS idx_event_location ON event USING GIST (location);


--To improve overall performance of full-text searches while searching for event by location; GiST better for dynamic data
