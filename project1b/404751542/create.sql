CREATE TABLE MaxPersonID(
       id INT,
       CHECK (id > 0) /* id should be positive */
) ENGINE=InnoDB;

CREATE TABLE MaxMovieID(
       id INT,
       CHECK (id > 0) /* id should be positive */
) ENGINE=InnoDB;

CREATE TABLE Movie(
       id INT PRIMARY KEY NOT NULL, /* id is a primary key and cannot be repeatedly inserted  */
       title VARCHAR(100) NOT NULL,
       year INT NOT NULL,
       rating VARCHAR(10),
       company VARCHAR(50),
       CHECK (1 <= id AND id <= (SELECT MAX(id) FROM MaxMovieID)),  /* id should be less than MaxMovieId's id */
       CHECK (rating = "G" OR rating = "PG" OR rating = "PG-13" OR rating = "NC-17" OR rating = "R")
) ENGINE=InnoDB;

CREATE TABLE Actor(
       id INT PRIMARY KEY NOT NULL, /* id is a primary key and cannot be repeatedly inserted  */
       last VARCHAR(20) NOT NULL,
       first VARCHAR(20) NOT NULL,
       sex VARCHAR(6),
       dob DATE NOT NULL,
       dod DATE,
       CHECK (1 <= id AND id <= (SELECT MAX(id) FROM MaxPersonID)), /* id should be less than MaxPersonId's id */
       CHECK (sex = "Male" OR sex = "Female") /* sex should be either Male or Female */
) ENGINE=InnoDB;

CREATE TABLE Director(
       id INT PRIMARY KEY NOT NULL, /* id is a primary key and cannot be repeatedly inserted  */
       last VARCHAR(20) NOT NULL,
       first VARCHAR(20) NOT NULL,
       dob DATE NOT NULL,
       dod DATE,
       CHECK (1<= id AND id <= (SELECT MAX(id) FROM MaxPersonID)) /* id should be less than MaxPersonId's id */
) ENGINE=InnoDB;

CREATE TABLE MovieGenre(
       mid INT NOT NULL,
       genre VARCHAR(20),
       FOREIGN KEY (mid) references Movie(id) /* mid is a foriegn key from Movie.id */
) ENGINE=InnoDB;

CREATE TABLE MovieDirector(
       mid INT NOT NULL,
       did INT NOT NULL,
       FOREIGN KEY (mid) references Movie(id), /* mid is a foriegn key from Movie.id */
       FOREIGN KEY (did) references Director(id) /* did is a foriegn key from Director.id */
) ENGINE=InnoDB;

CREATE TABLE MovieActor(
       mid INT NOT NULL,
       aid INT NOT NULL,
       role VARCHAR(50),
       FOREIGN KEY (mid) references Movie(id), /* mid is a foriegn key from Movie.id */
       FOREIGN KEY (aid) references Actor(id) /* aid is a foriegn key from Actor.id */
) ENGINE=InnoDB;

CREATE TABLE Review(
       name VARCHAR(20),
       time TIMESTAMP NOT NULL,
       mid INT NOT NULL,
       rating INT,
       CHECK (1 <= rating AND rating <=10), /* rating should be between 1 and 10 */
       comment VARCHAR(500),
       FOREIGN KEY (mid) references Movie(id) /* mid is a foriegn key from Movie.id */
) ENGINE=InnoDB;
