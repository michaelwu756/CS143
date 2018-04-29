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
<?php heading('Add Actor/Movie Relation'); ?>

<?php
    function display()
    {

        //$title, $year, $rating, $company
        //add_movie($_POST["lname"], $_POST["fname"], $_POST["sex"], $_POST["dateb"], $_POST["dated"]);
        notify_success("Connected actor ".$_POST["actor"].' with movie '.$_POST["movie"]);
    }
    if(isset($_POST['submit']))
    {
       display();
    }
?>

<?php


form('<form method="POST" action="add_actormovierel.php">
    <div class="form-group">
        <label for="rating">Movie</label>
        <select class="form-control" name="movie" required>
            <option value="NULL">NULL</option>
        </select>
    </div>
    <div class="form-group">
        <label for="rating">Actor</label>
        <select class="form-control" name="actor" required>
            <option value="NULL">NULL</option>
        </select>
    </div>
    <div class="form-group">
          <label for="DOB">Date of Birth</label>
          <input type="text" class="form-control" placeholder="bystander" name="role">
    </div>
        <button type="submit" name="submit" class="btn btn-default">Add It!</button>
    </form>'); ?>

<?php footer(); ?>

</body>

</html>





