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
      {
        $actors = get_list_actors();
        $actorsOptions = '';
        foreach($actors as $actor)
        {
          $newActor = sprintf('<option value="%u">%s %s (%s)</option>', $actor['id'], $actor['first'], $actor['last'], $actor['dob']);
          $actorsOptions = $actorsOptions.$newActor;
        }
        heading('Browse Actor');
        form(
          '<form method="GET" action="browse_actor.php">
            <div class="form-group">
              <label for="identifier">Actor</label>
              <select class="form-control" name="identifier" required>'.$actorsOptions.'
              </select>
            </div>
            <button type="submit" name="submit" class="btn btn-default">Go!</button>
          </form>');
      }
    ?>
    <?php
      function display()
      {
        $id = $_GET["identifier"];
        $info = get_actor_info($id);
        $movies = get_actor_movies($id);

        $subtitle ='Born '.$info['dob'];
        if(!empty($info['dod']))
            $subtitle = $subtitle.' - Died '.$info['dod'];
        $subtitle = $subtitle.' - Sex '.$info['sex'];

        $moviesHTML='';
        foreach($movies as $movie)
        {
          $newMovie = sprintf('<li class="list-group-item"><a href="browse_movie.php?identifier=%u">%s (%s)</a> as %s</li>', $movie['id'], $movie['title'], $movie['year'], $movie['role']);
          $moviesHTML = $moviesHTML.$newMovie;
        }

        print
          '<div class="jumbotron jumbotron-fluid ">
            <div class="container">
              <h1 class="display-4">'.$info['first'].' '.$info['last'].'</h1>
              <h3 >'.$subtitle.'</h3>
            </div>
          </div>';
        print '<div class="container ">';
        print '<h1>Movies with this Actor</h1>';
        print '<ul class="list-group">'.$moviesHTML.'</ul>';
        print '</div>';
      }
      if(isset($_GET['identifier']))
      {
        if($info == get_actor_info($_GET["identifier"]))
        {
          heading("Actor not found!");
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