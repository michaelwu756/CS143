-- VIOLATING CHECK CONSTRAINTS

INSERT INTO MaxPersonID VALUES (-123);
-- id must be positive
-- not actually enforced by sql

INSERT INTO MaxMovieID VALUES (-123);
-- id must be positive
-- not actually enforced by sql

INSERT INTO Review VALUES ('Jennie', '2018-04-15 5:30:24', 2, 9000, 'WOW SO AMAZING');
-- Rating is way too high
-- not actually enforced by sql

INSERT INTO Actor VALUES(99999999, 'Jennie', 'Zheng', 'Female', '1998-03-07', NULL);
-- id greater than MaxMovieID
-- not actually enforced by sql

INSERT INTO Director VALUES(99999999, 'Michael', 'Wu', '1998-06-02', NULL);
-- id greater than MaxMovieID
-- not actually enforced by sql

-- PRIMARY KEY CONSTRAINTS
INSERT INTO Movie VALUES(2, 'Bad Day', 2010, 'PG', 'CS143');
-- The Movie table already has tuple with id = 2
-- ERROR 1062 (23000) at line 24: Duplicate entry '2' for key 'PRIMARY'

INSERT INTO Actor VALUES(10, 'Jennie', 'Zheng', 'Female', '1998-03-07', NULL);
-- The Actor table already has tuple with id = 10
-- ERROR 1062 (23000) at line 28: Duplicate entry '10' for key 'PRIMARY'

INSERT INTO Director VALUES(16, 'Michael', 'Wu', '1998-06-02', NULL);
-- The Director table already has tuple with id = 16
-- ERROR 1062 (23000) at line 32: Duplicate entry '16' for key 'PRIMARY'

-- FOREIGN KEY CONSTRAINTS
INSERT INTO MovieGenre VALUES(10, 'Romance');
-- There exists no such movie with id = 10
-- ERROR 1452 (23000) at line 37: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO MovieDirector VALUES(10, 16);
-- There exists no such movie with id = 10
-- ERROR 1452 (23000) at line 41: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO MovieDirector VALUES(2, 10);
-- There exists no such director with id = 10
-- ERROR 1452 (23000) at line 45: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))

INSERT INTO MovieActor VALUES(2, 123123, 'Bystander');
-- There exists no such actor with id = 123123
-- ERROR 1452 (23000) at line 49: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))

INSERT INTO MovieActor VALUES(10, 10, 'Donald Trump');
-- There exists no such movie with id = 10
-- ERROR 1452 (23000) at line 53: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO Review VALUES ('Jennie', '2018-04-15 5:30:24', 10, 8, 'WOW SO AMAZING');
-- There is no movie with id = 10
-- ERROR 1452 (23000) at line 57: Cannot add or update a child row: a foreign key constraint fails (`CS143`.`Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
