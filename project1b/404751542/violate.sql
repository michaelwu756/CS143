-- VIOLATING CHECK CONSTRAINTS
INSERT INTO MaxPersonID VALUES (-123);
-- id must be positive

INSERT INTO MaxMovieID VALUES (-123);
-- id must be positive

INSERT INTO Review VALUES ('Jennie', '2018-04-15 5:30:24', 2, 9000, 'WOW SO AMAZING');
-- Rating is way too high

INSERT INTO Actor VALUES(99999999, 'Jennie', 'Zheng', 'Female', '1998-03-07', NULL);
-- id greater than MaxMovieID

INSERT INTO Director VALUES(99999999, 'Michael', 'Wu', '1998-06-02', NULL);
-- id greater than MaxMovieID

-- PRIMARY KEY CONSTRAINTS
INSERT INTO Movie VALUES(2, 'Bad Day', 2010, 'PG', 'CS143');
-- The Movie table already has tuple with id = 2

INSERT INTO Actor VALUES(10, 'Jennie', 'Zheng', 'Female', '1998-03-07', NULL);
-- The Actor table already has tuple with id = 10

INSERT INTO Director VALUES(16, 'Michael', 'Wu', '1998-06-02', NULL);
-- The Director table already has tuple with id = 16

-- FOREIGN KEY CONSTRAINTS
INSERT INTO MovieGenre VALUES(10, 'Romance');
-- There exists no such movie with id = 10

INSERT INTO MovieDirector VALUES(10, 16);
-- There exists no such movie with id = 10

INSERT INTO MovieDirector VALUES(2, 10, 'Donald Trump');
-- There exists no such director with id = 10

INSERT INTO MovieActor VALUES(2, 123123, 'Bystander');
-- There exists no such actor with id = 123123

INSERT INTO MovieActor VALUES(10, 10, 'Donald Trump');
-- There exists no such movie with id = 10

INSERT INTO Review VALUES ('Jennie', '2018-04-15 5:30:24', 10, 8, 'WOW SO AMAZING');
-- There is no movie with id = 10
