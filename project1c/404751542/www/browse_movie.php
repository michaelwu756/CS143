<?php
  include("./config.php");
  include("./common.php");
  include("./functions.php");
?>
<html>
  <head>
    <?php headerer(); ?>
  </head>
  <body>
    <?php navigation(); ?>
    <?php
      if(!isset($_GET['identifier']))
        header('Location: search.php');
    ?>
    <?php
      function display()
      {
        $id = $_GET["identifier"];
        $info = get_movie_info($id);
        $actors = get_movie_actors($id);
        $directors = get_movie_directors($id);
        $genres = get_movie_genres($id);
        $reviews = get_movie_reviews($id);
        $ave = get_movie_average_score($id);
        if(empty($ave))
          $ave = 'N/A';

        $genreHTML = '';
        foreach($genres as $genre)
        {
          $newGenre = sprintf('<span class="badge badge-info">%s</span>', $genre);
          $genreHTML = $genreHTML.$newGenre;
        }

        $subtitle = 'Rated '.$info['rating'];
        if(!empty($info['company']))
          $subtitle = $subtitle.' - Produced by '.$info['company'];
        if(array_key_exists('0', $directors))
          $subtitle = $subtitle.' - Directed by ';
        foreach($directors as $director)
          $subtitle = $subtitle.' '.$director['first'].' '.$director['last'].',';
        $subtitle = rtrim($subtitle, ',');

        $actorsHTML = '';
        foreach($actors as $actor)
        {
          $newActor = sprintf('<li class="list-group-item"><a href="browse_actor.php?identifier=%u">%s %s</a> as %s</li>', $actor['id'], $actor['first'], $actor['last'], $actor['role']);
          $actorsHTML = $actorsHTML.$newActor;
        }

        $reviewsHTML = '';
        if(!array_key_exists('0', $reviews))
            $reviewsHTML='No Reviews for this movie!';
        foreach($reviews as $review)
        {
          $datetime = new DateTime($review['time']);
          $prettydate = $datetime->format('M d, Y | g:i:s A');
          $singleReview = sprintf('<li class="list-group-item"> %s on %s - %s <span class="badge badge-primary badge-pill">%s</span></li>', $review['name'], $prettydate, $review['comment'], $review['rating']);
          $reviewsHTML = $reviewsHTML.$singleReview;
        }

        print
          '<div class="jumbotron jumbotron-fluid ">
            <div class="container">
              <h1 class="display-4">'.$info['title'].' ('.$info['year'].')</h1>
              <h3 >'.$subtitle.'</h3>'.$genreHTML.'
            </div>
          </div>';
        print '<div class="container ">';
        print '<h1>Actors in this Movie</h1>';
        print '<ul class="list-group">'.$actorsHTML.'</ul>';
        print '<hr/>';
        print '<h1>Reviews for this Movie</h1>';
        print
          '<div style="margin-bottom:10px;">
            <p> Average score: '.$ave.'</p>
            <a href=add_comment.php?movieID='. $id .'> Leave review! </a>
          </div>';
        print '<ul class="list-group">'.$reviewsHTML.'</ul>';
        print '</div>';
      }
      if(isset($_GET['identifier']))
      {
        if($info == get_movie_info($_GET["identifier"]))
        {
          heading("Movie not found!");
        }
        else
        {
          display();
        }
      }
    ?>
    <?php footer(); ?>
  </body>
</html>