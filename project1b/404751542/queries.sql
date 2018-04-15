/*
first and last name of all actors from "Die another day"
*/
SELECT CONCAT(Actor.first," ", Actor.last) as Actors_In_Die_Another_Day
       FROM Movie, MovieActor, Actor
       where Movie.id = MovieActor.mid and MovieActor.aid = Actor.id
       and Movie.title = "Die Another Day";
/*
number of actors who have acted in at least two movies
*/
SELECT COUNT(aid) as Actors_In_Least_2_Movies
       FROM MovieActor
       WHERE aid IN
         (SELECT aid
       	  FROM MovieActor
      	  GROUP BY aid
       	  HAVING COUNT(mid) > 1 );
/*
Number of directors total
*/
SELECT COUNT(id) as Directors_Total
       FROM Director;
