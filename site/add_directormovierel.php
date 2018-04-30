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
        notify_success("Connected director with id ".$_POST["director"].' with movie with id '.$_POST["movie"]);
    }
    if(isset($_POST['submit']))
    {
       display();
    }
?>

<?php

$directors = get_list_directors();
$directorOptions='';
foreach($directors as $director){
    $newDirector= sprintf('<option value="%u">%s %s (%s)</option>',$director['id'],$director['first'],$director['last'],$director['dob']);
    $directorOptions=$directorOptions.$newDirector;
}

$movies = get_list_movies();
$moviesOptions='';
foreach($movies as $movie){
    $newMovie= sprintf('<option value="%u">%s (%u)</option>',$movie['id'],$movie['title'],$movie['year']);
    $moviesOptions=$moviesOptions.$newMovie;
}



form('<form method="POST" action="add_directormovierel.php">
    <div class="form-group">
        <label for="rating">Movie</label>
        <select class="form-control" name="movie" required>'.$moviesOptions.'
        </select>
    </div>
    <div class="form-group">
        <label for="rating">Director</label>
        <select class="form-control" name="director" required>'.$directorOptions.'
        </select>
    </div>
        <button type="submit" name="submit" class="btn btn-default">Add It!</button>
    </form>'); ?>

<?php footer(); ?>

</body>

</html>





