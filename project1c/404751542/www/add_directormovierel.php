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
    <?php heading('Add Director/Movie Relation'); ?>
    <?php
      function display()
      {
        $res = connect_director_to_movie($_POST["movie"], $_POST["director"]);
        notify($res);
      }
      if(isset($_POST['submit']))
      {
        display();
      }
    ?>
    <?php
      $directors = get_list_directors();
      $directorOptions = '';
      foreach($directors as $director)
      {
        $newDirector = sprintf('<option value="%u">%s %s (%s)</option>', $director['id'], $director['first'], $director['last'], $director['dob']);
        $directorOptions = $directorOptions.$newDirector;
      }
      $movies = get_list_movies();
      $moviesOptions = '';
      foreach($movies as $movie)
      {
          $newMovie = sprintf('<option value="%u">%s (%u)</option>', $movie['id'], $movie['title'], $movie['year']);
          $moviesOptions = $moviesOptions.$newMovie;
      }
      form(
        '<form method="POST" action="add_directormovierel.php">
          <div class="form-group">
              <label for="movie">Movie</label>
              <select class="form-control" name="movie" required>'.$moviesOptions.'
              </select>
          </div>
          <div class="form-group">
              <label for="director">Director</label>
              <select class="form-control" name="director" required>'.$directorOptions.'
              </select>
          </div>
          <button type="submit" name="submit" class="btn btn-default">Add It!</button>
        </form>'); ?>
    <?php footer(); ?>
  </body>
</html>