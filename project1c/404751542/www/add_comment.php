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
    <?php heading('Add Comment'); ?>
    <?php
      function display()
      {
        $res = add_review($_POST["name"], $_POST["movie"], $_POST["rating"], $_POST["comment"]);
        notify($res);
        header('Location: browse_movie.php?identifier='.$_POST["movie"]);
      }
      if(isset($_POST['submit']))
      {
        display();
      }
    ?>
    <?php
      $targetID = '';
      if(isset($_GET['movieID']))
      {
        $targetID = $_GET['movieID'];
      }
      $movies = get_list_movies();
      $moviesOptions = '';
      foreach($movies as $movie)
      {
          if($movie['id'] == $targetID)
            $newMovie = sprintf('<option value="%u" selected>%s (%u)</option>', $movie['id'], $movie['title'], $movie['year']);
          else
            $newMovie = sprintf('<option value="%u">%s (%u)</option>', $movie['id'], $movie['title'], $movie['year']);
          $moviesOptions = $moviesOptions.$newMovie;
      }
      form(
        '<form method="POST" action="add_comment.php">
          <div class="form-group">
            <label for="name">Reviewer Name</label>
            <input type="text" class="form-control" placeholder="Jennie" name="name" required>
          </div>
          <div class="form-group">
            <label for="movie">Movie</label>
            <select class="form-control" name="movie" required>'.$moviesOptions.
            '</select>
          </div>
          <div class="form-group">
            <label for="rating">Rating</label>
            <input class="form-control" type="number" name="rating" min="1" max="10" placeholder="5" required>
          </div>
          <div class="form-group">
            <label for="name">Comment</label>
            <input type="text" class="form-control" placeholder="Very sad movie :(" name="comment">
          </div>
          <button type="submit" name="submit" class="btn btn-default">Add It!</button>
        </form>'); ?>
    <?php footer(); ?>
  </body>
</html>