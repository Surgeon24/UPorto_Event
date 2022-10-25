CREATE INDEX nickname_registeredUsers ON registered_users USING hash (nickname);
CREATE INDEX eventName_event ON event USING hash (event_name);
CREATE INDEX tag_event ON event USING hash (tag);
CREATE INDEX publishDate_comment ON comment USING hash (publish_date);

--hash 

CREATE INDEX dateRegistered_resgisteredUsers ON registered_users USING btree (date_registered);
CREATE INDEX eventDate_event ON event USING btree (event_date);
CREATE INDEX startsAt_poll ON poll USING btree (starts_at);
CREATE INDEX endAt_poll ON poll USING btree (end_at);
CREATE INDEX notificationDate_notification_type ON notification_type USING btree (notification_date);
CREATE INDEX addedOn_userPhoto ON user_photo USING btree (added_on);
CREATE INDEX addedOn_eventPhoto ON event_photo USING btree (added_on);


--btree

--CREATE INDEX date-registered_resgistered-users ON registered_users USING btree (date_registered);

--gist