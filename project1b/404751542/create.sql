CREATE TABLE MaxPersonID(
       id INT,
       CHECK (id > 0)
) ENGINE=InnoDB;

CREATE TABLE MaxMovieID(
       id INT,
       CHECK (id > 0)
) ENGINE=InnoDB;

CREATE TABLE Movie(
       id INT PRIMARY KEY NOT NULL,
       title VARCHAR(100) NOT NULL,
       year INT NOT NULL,
       rating VARCHAR(10),
       company VARCHAR(50),
       CHECK (id <= (SELECT MAX(id) FROM MaxMovieID)),
       CHECK (rating = "G" OR rating = "PG" OR rating = "PG-13" OR rating = "NC-17" OR rating = "R")
) ENGINE=InnoDB;

CREATE TABLE Actor(
       id INT PRIMARY KEY NOT NULL,
       last VARCHAR(20) NOT NULL,
       first VARCHAR(20) NOT NULL,
       sex VARCHAR(6),
       dob DATE NOT NULL,
       dod DATE,
       CHECK (id <= (SELECT MAX(id) FROM MaxPersonID)),
       CHECK (sex = "Male" OR sex = "Female")
) ENGINE=InnoDB;

CREATE TABLE Director(
       id INT PRIMARY KEY NOT NULL,
       last VARCHAR(20) NOT NULL,
       first VARCHAR(20) NOT NULL,
       dob DATE NOT NULL,
       dod DATE,
       CHECK (id <= (SELECT MAX(id) FROM MaxPersonID))
) ENGINE=InnoDB;

CREATE TABLE MovieGenre(
       mid INT NOT NULL,
       genre VARCHAR(20),
       FOREIGN KEY (mid) references Movie(id)
) ENGINE=InnoDB;

CREATE TABLE MovieDirector(
       mid INT NOT NULL,
       did INT NOT NULL,
       FOREIGN KEY (mid) references Movie(id),
       FOREIGN KEY (did) references Director(id)
) ENGINE=InnoDB;

CREATE TABLE MovieActor(
       mid INT NOT NULL,
       aid INT NOT NULL,
       role VARCHAR(50),
       FOREIGN KEY (mid) references Movie(id),
       FOREIGN KEY (aid) references Actor(id)
) ENGINE=InnoDB;

CREATE TABLE Review(
       name VARCHAR(20),
       time TIMESTAMP NOT NULL,
       mid INT NOT NULL,
       rating INT,
       CHECK (1 <= rating AND rating <=10),
       comment VARCHAR(500),
       FOREIGN KEY (mid) references Movie(id)
) ENGINE=InnoDB;
