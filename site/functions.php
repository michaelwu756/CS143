<?php
$servername="localhost";
//$username="cs143";
//$password="";
$username="root";
$password="donotenter";

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
  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("UPDATE MaxPersonID SET id = id + 1; INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES ((SELECT id FROM MaxPersonID LIMIT 1), ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $last, $first, $sex, $dob, $dod);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function add_director($last, $first, $dob, $dod) {
  global $servername, $username, $password, $database;
  print '123';
  $conn = new mysqli('localhost', 'root', 'donotenter', 'CS143');
  print '123';
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  print '123';
  $stmt = $conn->prepare("UPDATE MaxPersonID SET id = id + 1; INSERT INTO Director (id, last, first, dob, dod) VALUES ((SELECT id FROM MaxPersonID LIMIT 1), ?, ?, ?, ?)");
  $stmt->bind_param("ssss", $last, $first, $dob, $dod);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }
  print '123';

  $stmt->close();
  $conn->close();
  print '123';
}

function add_movie($title, $year, $rating, $company) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("UPDATE MaxMovieID SET id = id + 1; INSERT INTO Movie (id, title, year, rating, company) VALUES ((SELECT id FROM MaxMovieID LIMIT 1), ?, ?, ?, ?)");
  $stmt->bind_param("siss", $title, $year, $rating, $company);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

//TODO: make time current time
function add_review($name, $time, $movie_id, $rating, $comment) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO Review (name, time, mid, rating, comment) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssiis", $name, $time, $movie_id, $rating, $comment);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function connect_actor_to_movie($movie_id, $actor_id, $role) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO MovieActor (mid, aid, role) VALUES (?, ?, ?)");
  $stmt->bind_param("iis", $movie_id, $actor_id, $role);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function connect_director_to_movie($movie_id, $director_id) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO MovieDirector (mid, did) VALUES (?, ?)");
  $stmt->bind_param("ii", $movie_id, $director_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

//retrieval functions
function get_actor_info($actor_id) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT last, first, sex, dob, dod FROM Actor WHERE id = ? ");
  $stmt->bind_param("i", $actor_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function get_actor_movies($actor_id) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT role, title FROM MovieActor JOIN Movie ON mid = id WHERE aid = ?");
  $stmt->bind_param("i", $actor_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function get_movie_info($movie_id) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT title, year, rating, company FROM Movie WHERE id = ?");
  $stmt->bind_param("i", $movie_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function get_movie_actors($movie_id) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT role, last, first FROM MovieActor JOIN Actor ON aid = id WHERE mid = ?");
  $stmt->bind_param("i", $movie_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function get_movie_directors($movie_id) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT last, first FROM MovieDirector JOIN Director ON did = id WHERE mid = ?");
  $stmt->bind_param("i", $movie_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function get_movie_genres($movie_id) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT genre FROM MovieGenre WHERE mid = ?");
  $stmt->bind_param("i", $movie_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

function get_movie_reviews($movie_id) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT name, time, rating, comment FROM Review WHERE mid = ?");
  $stmt->bind_param("i", $movie_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}
//TODO: put not null on rating?
function get_movie_average_score($movie) {
  global $servername, $username, $password, $database;
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT AVG(rating) FROM Review GROUP BY mid HAVING mid = ?");
  $stmt->bind_param("i", $movie_id);
  if (!$stmt->execute()) {
    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}

//function search_actor($search_string) // select * from Actor where CONCAT(first, " ", last) like '%term1%' and CONCAT(first, " ", last) like '%term2%'
//function search_movie($search_string) // select * from Movie where title like '%term1%' and title like '%term2%'
?>