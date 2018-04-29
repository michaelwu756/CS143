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
<?php heading('Add Director/Movie Relation'); ?>

<?php
    function display()
    {

        //$title, $year, $rating, $company
        //add_movie($_POST["lname"], $_POST["fname"], $_POST["sex"], $_POST["dateb"], $_POST["dated"]);
        notify_success("Connected director ".$_POST["director"].' with movie '.$_POST["movie"]);
    }
    if(isset($_POST['submit']))
    {
       display();
    }
?>

<?php


form('<form method="POST" action="add_directormovierel.php">
    <div class="form-group">
        <label for="rating">Movie</label>
        <select class="form-control" name="movie" required>
            <option value="NULL">NULL</option>
        </select>
    </div>
    <div class="form-group">
        <label for="rating">Director</label>
        <select class="form-control" name="director" required>
            <option value="NULL">NULL</option>
        </select>
    </div>
        <button type="submit" name="submit" class="btn btn-default">Add It!</button>
    </form>'); ?>

<?php footer(); ?>

</body>

</html>





