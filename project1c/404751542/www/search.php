<?php
  include("./config.php");
  include("./common.php");
  include("./functions.php");
?>
<html>
  <head>
    <?php headerer(); ?>
  </head>
  <body >
    <?php navigation(); ?>
    <?php
      function display()
      {
        $query = $_GET['search'];
        $movies = search_movie($query);
        $actors = search_actor($query);
        $moviesHTML = '';
        foreach($movies as $movie)
        {
          $newMovie = sprintf('<li class="list-group-item"><a href="browse_movie.php?identifier=%u">%s</a> (%s)</li>', $movie['id'], $movie['title'], $movie['year']);
          $moviesHTML = $moviesHTML.$newMovie;
        }
        $actorsHTML = '';
        foreach($actors as $actor)
        {
          $newActor = sprintf('<li class="list-group-item"><a href="browse_actor.php?identifier=%u">%s %s</a> - Born %s</li>', $actor['id'], $actor['first'], $actor['last'], $actor['dob']);
          $actorsHTML = $actorsHTML.$newActor;
        }
        heading('Search Results for \''.$query.'\'...');
        print '<div class="container ">';
        print '<h1>Actors Found</h1>';
        print '<ul class="list-group">'.$actorsHTML.'</ul>';
        print '<hr/>';
        print '<h1>Movies Found</h1>';
        print '<ul class="list-group">'.$moviesHTML.'</ul>';
        print '</div>';
      }
      if(isset($_GET['search']))
      {
        display();
      }
    ?>
    <?php footer(); ?>
  </body>
</html>