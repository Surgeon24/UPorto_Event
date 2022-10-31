SELECT Tag.name ,Event.name, Tag.eventID, Event.ID 
FROM Event, Tag
WHERE Event.ID = Tag.eventID 