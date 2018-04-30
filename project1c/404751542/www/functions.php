<?php
  function open_connection()
  {
    $servername = 'localhost';
    $username = 'cs143';
    $password = '';
    $database = 'CS143';
    $conn = new mysqli($servername, $username, $password, $database);

    if($conn->connect_error)
    {
      die('Connection failed: '.$conn->connect_error);
    }
    return $conn;
  }

  function check_execute($conn, $stmt, &$str)
  {
    if(!$stmt->execute())
    {
      $str = 'Execute failed: ('.$conn->errno.') '.$conn->error;
      return true;
    }
    return false;
  }

  //insertion functions
  function add_actor($last, $first, $sex, $dob, $dod)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('UPDATE MaxPersonID SET id = id + 1');
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $stmt = $conn->prepare('INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES ((SELECT id FROM MaxPersonID LIMIT 1), ?, ?, ?, ?, ?)');
    if($dod === '')
      $dod = null;
    $stmt->bind_param('sssss', $last, $first, $sex, $dob, $dod);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $conn->close();
    return 'Added actor '.$first.' '.$last.' sucessfully!';
  }

  function add_director($last, $first, $dob, $dod)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('UPDATE MaxPersonID SET id = id + 1');
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $stmt = $conn->prepare('INSERT INTO Director (id, last, first, dob, dod) VALUES ((SELECT id FROM MaxPersonID LIMIT 1), ?, ?, ?, ?)');
    if($dod === '')
      $dod = null;
    $stmt->bind_param('ssss', $last, $first, $dob, $dod);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $conn->close();
    return 'Added director '.$first.' '.$last.' sucessfully!';
  }

  function add_movie($title, $year, $rating, $company, $genres)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('UPDATE MaxMovieID SET id = id + 1');
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $stmt = $conn->prepare('INSERT INTO Movie (id, title, year, rating, company) VALUES ((SELECT id FROM MaxMovieID LIMIT 1), ?, ?, ?, ?)');
    $stmt->bind_param('siss', $title, $year, $rating, $company);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $stmt = $conn->prepare('INSERT INTO MovieGenre (mid, genre) VALUES ((SELECT id FROM MaxMovieID LIMIT 1), ?)');
    foreach ($genres as $genre)
    {
      $stmt->bind_param('s', $genre);
      if(check_execute($conn, $stmt, $return_str)) return $return_str;
    }
    $stmt->close();

    $conn->close();
    return 'Added movie '.$title.' sucessfully!';
  }

  function add_review($name, $movie_id, $rating, $comment)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('INSERT INTO Review (name, time, mid, rating, comment) VALUES (?, NOW(), ?, ?, ?)');
    $stmt->bind_param('siis', $name, $movie_id, $rating, $comment);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $stmt = $conn->prepare('SELECT title FROM Movie WHERE id = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $row = $stmt->get_result()->fetch_array();
    $title = $row['title'];
    $stmt->close();

    $conn->close();
    return 'Added review for \''.$title.'\' sucessfully!';
  }

  function connect_actor_to_movie($movie_id, $actor_id, $role)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('INSERT INTO MovieActor (mid, aid, role) VALUES (?, ?, ?)');
    $stmt->bind_param('iis', $movie_id, $actor_id, $role);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $stmt = $conn->prepare('SELECT title FROM Movie WHERE id = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $row = $stmt->get_result()->fetch_array();
    $title = $row['title'];
    $stmt->close();

    $stmt = $conn->prepare('SELECT last, first FROM Actor WHERE id = ?');
    $stmt->bind_param('i', $actor_id);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $row = $stmt->get_result()->fetch_array();
    $last = $row['last'];
    $first = $row['first'];
    $stmt->close();

    $conn->close();
    return 'Connected actor \''.$first.' '.$last.'\' to \''.$title.'\' successfully!';
  }

  function connect_director_to_movie($movie_id, $director_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('INSERT INTO MovieDirector (mid, did) VALUES (?, ?)');
    $stmt->bind_param('ii', $movie_id, $director_id);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $stmt->close();

    $stmt = $conn->prepare('SELECT title FROM Movie WHERE id = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $row = $stmt->get_result()->fetch_array();
    $title = $row['title'];
    $stmt->close();

    $stmt = $conn->prepare('SELECT last, first FROM Director WHERE id = ?');
    $stmt->bind_param('i', $director_id);
    if(check_execute($conn, $stmt, $return_str)) return $return_str;
    $row = $stmt->get_result()->fetch_array();
    $last = $row['last'];
    $first = $row['first'];
    $stmt->close();

    $conn->close();
    return 'Connected director \''.$first.' '.$last.'\' to \''.$title.'\' successfully!';
  }

  //retrieval functions
  function get_actor_info($actor_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT last, first, sex, dob, dod FROM Actor WHERE id = ? ');
    $stmt->bind_param('i', $actor_id);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $result = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $result;
  }

  function get_actor_movies($actor_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT id, role, title, year, rating, company FROM MovieActor JOIN Movie ON mid = id WHERE aid = ?');
    $stmt->bind_param('i', $actor_id);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $result;
  }

  function get_movie_info($movie_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT title, year, rating, company FROM Movie WHERE id = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $result = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $result;
  }

  function get_movie_actors($movie_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT id, role, last, first, sex, dob, dod FROM MovieActor JOIN Actor ON aid = id WHERE mid = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $result;
  }

  function get_movie_directors($movie_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT id, last, first, dob, dod FROM MovieDirector JOIN Director ON did = id WHERE mid = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $result;
  }

  function get_movie_genres($movie_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT genre FROM MovieGenre WHERE mid = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $tempRes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $result = array();
    foreach($tempRes as $row)
      $result[] = $row['genre'];
    $stmt->close();

    $conn->close();
    return $result;
  }

  function get_movie_reviews($movie_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT name, time, rating, comment FROM Review WHERE mid = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $result;
  }

  function get_movie_average_score($movie_id)
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT AVG(rating) AS average FROM Review GROUP BY mid HAVING mid = ?');
    $stmt->bind_param('i', $movie_id);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $result = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $result['average'];
  }

  //list functions
  function get_list_movies()
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT id, title, year, rating, company FROM Movie ORDER BY title ASC');
    if(check_execute($conn, $stmt, $return_str)) return null;
    $movies = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $movies;
  }

  function get_list_actors()
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT id, last, first, sex, dob, dod FROM Actor ORDER BY CONCAT(last, " ", first) ASC');
    if(check_execute($conn, $stmt, $return_str)) return null;
    $actors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $actors;
  }

  function get_list_directors()
  {
    $conn = open_connection();
    $return_str = null;

    $stmt = $conn->prepare('SELECT id, last, first, dob, dod FROM Director ORDER BY CONCAT(last, " ", first) ASC');
    if(check_execute($conn, $stmt, $return_str)) return null;
    $directors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $directors;
  }

  //search functions
  function search_actor($search_string)
  {
    $conn = open_connection();
    $return_str = null;

    $search_string = trim($search_string);
    if($search_string === '')
      return null;
    $query = 'SELECT id, last, first, dob, dod FROM Actor WHERE ';
    foreach(explode(' ', $search_string) as $word)
      $query .= 'CONCAT(first, " ", last) LIKE \'%'.$conn->real_escape_string($word).'%\' AND ';
    $query = substr($query, 0, strlen($query)-5);
    $query .= ' ORDER BY CONCAT(first, " ", last) ASC';

    $stmt = $conn->prepare($query);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $actors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $actors;
  }

  function search_movie($search_string)
  {
    $conn = open_connection();
    $return_str = null;

    $search_string = trim($search_string);
    if($search_string === '')
      return null;
    $query = 'SELECT id, title, year, rating, company FROM Movie WHERE ';
    foreach(explode(' ', $search_string) as $word)
      $query .= 'title LIKE \'%'.$conn->real_escape_string($word).'%\' AND ';
    $query = substr($query, 0, strlen($query)-5);
    $query .= ' ORDER BY title ASC';

    $stmt = $conn->prepare($query);
    if(check_execute($conn, $stmt, $return_str)) return null;
    $movies = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $conn->close();
    return $movies;
  }
?>