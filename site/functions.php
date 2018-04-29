<?php
$servername="localhost";
$username="cs143";
$password="";
$database="CS143";

function open_connection() {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

function check_execute($stmt) {
  if (!$stmt->execute())
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
}

//insertion functions
function add_actor($last, $first, $sex, $dob, $dod) {
  $conn = open_connection();

  $stmt = $conn->prepare("UPDATE MaxPersonID SET id = id + 1");
  check_execute($stmt);
  $stmt->close();

  $stmt = $conn->prepare("INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES ((SELECT id FROM MaxPersonID LIMIT 1), ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $last, $first, $sex, $dob, $dod);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function add_director($last, $first, $dob, $dod) {
  $conn = open_connection();

  $stmt = $conn->prepare("UPDATE MaxPersonID SET id = id + 1");
  check_execute($stmt);
  $stmt->close();

  $stmt = $conn->prepare("INSERT INTO Director (id, last, first, dob, dod) VALUES ((SELECT id FROM MaxPersonID LIMIT 1), ?, ?, ?, ?)");
  if($dod==="")
    $dod = null;
  $stmt->bind_param("ssss", $last, $first, $dob, $dod);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function add_movie($title, $year, $rating, $company, $genres) {
  $conn = open_connection();

  $stmt = $conn->prepare("UPDATE MaxMovieID SET id = id + 1");
  check_execute($stmt);
  $stmt->close();

  $stmt = $conn->prepare("INSERT INTO Movie (id, title, year, rating, company) VALUES ((SELECT id FROM MaxMovieID LIMIT 1), ?, ?, ?, ?)");
  $stmt->bind_param("siss", $title, $year, $rating, $company);
  check_execute($stmt);
  $stmt->close();

  $stmt = $conn->prepare("INSERT INTO MovieGenre (mid, genre) VALUES ((SELECT id FROM MaxMovieID LIMIT 1), ?)");
  foreach ($genres as $genre) {
    $stmt->bind_param("s", $genre);
    check_execute($stmt);
  }
  $stmt->close();

  $conn->close();
}

function add_review($name, $movie_id, $rating, $comment) {
  $conn = open_connection();

  $stmt = $conn->prepare("INSERT INTO Review (name, time, mid, rating, comment) VALUES (?, NOW(), ?, ?, ?)");
  $stmt->bind_param("siis", $name, $movie_id, $rating, $comment);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function connect_actor_to_movie($movie_id, $actor_id, $role) {
  $conn = open_connection();

  $stmt = $conn->prepare("INSERT INTO MovieActor (mid, aid, role) VALUES (?, ?, ?)");
  $stmt->bind_param("iis", $movie_id, $actor_id, $role);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function connect_director_to_movie($movie_id, $director_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("INSERT INTO MovieDirector (mid, did) VALUES (?, ?)");
  $stmt->bind_param("ii", $movie_id, $director_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

//retrieval functions
function get_actor_info($actor_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT last, first, sex, dob, dod FROM Actor WHERE id = ? ");
  $stmt->bind_param("i", $actor_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_actor_movies($actor_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT role, title FROM MovieActor JOIN Movie ON mid = id WHERE aid = ?");
  $stmt->bind_param("i", $actor_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_movie_info($movie_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT title, year, rating, company FROM Movie WHERE id = ?");
  $stmt->bind_param("i", $movie_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_movie_actors($movie_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT role, last, first FROM MovieActor JOIN Actor ON aid = id WHERE mid = ?");
  $stmt->bind_param("i", $movie_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_movie_directors($movie_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT last, first FROM MovieDirector JOIN Director ON did = id WHERE mid = ?");
  $stmt->bind_param("i", $movie_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_movie_genres($movie_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT genre FROM MovieGenre WHERE mid = ?");
  $stmt->bind_param("i", $movie_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_movie_reviews($movie_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT name, time, rating, comment FROM Review WHERE mid = ?");
  $stmt->bind_param("i", $movie_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}
//TODO: put not null on rating?
function get_movie_average_score($movie_id) {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT AVG(rating) FROM Review GROUP BY mid HAVING mid = ?");
  $stmt->bind_param("i", $movie_id);
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_list_movies() {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT id, title, year, rating, company FROM Movie");
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_list_actors() {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT id, last, first, sex, dob, dod FROM Actor");
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

function get_list_directors() {
  $conn = open_connection();

  $stmt = $conn->prepare("SELECT id, last, first, dob, dod FROM Director");
  check_execute($stmt);
  $stmt->close();

  $conn->close();
}

//function search_actor($search_string) // select * from Actor where CONCAT(first, " ", last) like '%term1%' and CONCAT(first, " ", last) like '%term2%'
//function search_movie($search_string) // select * from Movie where title like '%term1%' and title like '%term2%'
?>