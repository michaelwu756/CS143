<?php
$servername="localhost";
$username="cs143";
$password="";
$database="CS143";
function run_query($query){
  global $servername, $username, $password, $database;
  $conn=new mysqli($servername,$username,$password,$database);
  if($conn->connect_error > 0){
    die("Connect Error");
  }
  if(!empty($query)){
    $rs=$conn->query($query);
    if (!$rs) {
      $errmsg = $conn->error;
      echo "Query failed: $errmsg <br />";
      exit(1);
    }
  }
}

//insertion functions
function add_actor($last, $first, $sex, $dob, $dod) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("UPDATE MaxPersonID SET id = id + 1; INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES ((SELECT id FROM MaxPersonID LIMIT 1), ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $last, $first, $sex, $dob, $dod);
  $stmt->execute();

  $stmt->close();
  $conn->close();
}

function add_director($last, $first, $dob, $dod) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("UPDATE MaxPersonID SET id = id + 1; INSERT INTO Director (id, last, first, dob, dod) VALUES ((SELECT id FROM MaxPersonID LIMIT 1), ?, ?, ?, ?)");
  $stmt->bind_param("ssss", $last, $first, $dob, $dod);
  $stmt->execute();

  $stmt->close();
  $conn->close();
}

function add_movie($title, $year, $rating, $company) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("UPDATE MaxMovieID SET id = id + 1; INSERT INTO Movie (id, title, year, rating, company) VALUES ((SELECT id FROM MaxMovieID LIMIT 1), ?, ?, ?, ?)");
  $stmt->bind_param("ssss", $title, $year, $rating, $company);
  $stmt->execute();

  $stmt->close();
  $conn->close();
}

//TODO: make time current time
function add_review($name, $time, $movie, $rating, $comment) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO Review (name, time, mid, rating, comment) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $name, $time, $movie, $rating, $comment);
  $stmt->execute();

  $stmt->close();
  $conn->close();
}

function connect_actor_to_movie($movie, $actor, $role) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO MovieActor (mid, aid, role) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $movie, $actor, $role);
  $stmt->execute();

  $stmt->close();
  $conn->close();
}

function connect_director_to_movie($movie, $director) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO MovieDirector (mid, did) VALUES (?, ?)");
  $stmt->bind_param("ss", $movie, $director);
  $stmt->execute();

  $stmt->close();
  $conn->close();
}

function get_actor_info($actor) // select * from Actor where id = $actor
function get_actor_movies($actor) // join on MovieActor and Movie
function get_movie_info($movie)// select * from Movie where id = $movie
function get_movie_actors($movie) // join on MovieActor and Actor
function get_movie_directors($movie) // join on MovieDirector and Director
function get_movie_genres($movie) // join on MovieGenre
function get_movie_reviews($movie) // join on Review
//TODO: put not null on rating?
function get_movie_average_score($movie) // join on Review, AVG(rating)
function search_actor($term) // select * from Actor where CONCAT(first, " ", last) like '%term1%' and CONCAT(first, " ", last) like '%term2%'
function search_movie($term) // select * from Movie where title like '%term1%' and title like '%term2%'
?>