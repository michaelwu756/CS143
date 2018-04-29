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
<?php heading('Add Comment'); ?>

<?php
    function display()
    {

        //$title, $year, $rating, $company
        //add_comment($_POST["lname"], $_POST["fname"], $_POST["sex"], $_POST["dateb"], $_POST["dated"]);
        notify_success("Added Review of ".$_POST["rating"]);
    }
    if(isset($_POST['submit']))
    {
       display();
    }
?>

<?php


form('
  <form method="POST" action="add_comment.php">
    <div class="form-group">
    <label for="name">Reviewer Name</label>
    <input type="text" class="form-control" placeholder="Jennie" name="name" required>
  </div>

    <div class="form-group">
      <label for="movie">Movie</label>
      <select class="form-control" name="movie" required>
        <option value="NULL">NULL</option>
      </select>
    </div>

  <div class="form-group">
    <label for="rating">Rating</label>
    <input class="form-control" type="number" name="rating" min="1" max="10" placeholder="5" required>
  </div>

  <div class="form-group">
    <label for="name">Comment</label>
    <input type="text" class="form-control" placeholder="Very sad movie :(" name="comment" required>
  </div>
  <button type="submit" name="submit" class="btn btn-default">Add It!</button>
</form>'); ?>

<?php footer(); ?>

</body>

</html>







