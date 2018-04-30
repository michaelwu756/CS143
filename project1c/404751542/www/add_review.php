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
<?php heading('Add Review'); ?>

<?php
    function display()
    {
        $res=connect_actor_to_movie($_POST["movie"], $_POST["actor"], $_POST["role"]);
        notify($res);
    }

?>

<?php

if(isset($_POST['submit']))
{
   display();
}

$actors = get_list_actors();
$actorsOptions='';
foreach($actors as $actor){
    $newActor= sprintf('<option value="%u">%s %s (%s)</option>',$actor['id'],$actor['first'],$actor['last'],$actor['dob']);
    $actorsOptions=$actorsOptions.$newActor;
}

$movies = get_list_movies();
$moviesOptions='';
foreach($movies as $movie){
    $newMovie= sprintf('<option value="%u">%s (%u)</option>',$movie['id'],$movie['title'],$movie['year']);
    $moviesOptions=$moviesOptions.$newMovie;
}

form('<form method="POST" action="add_actormovierel.php">
    <div class="form-group">
        <label for="movie">Movie</label>
        <select class="form-control" name="movie" required>'.$moviesOptions.
    '</select>
    </div>
    <div class="form-group">
        <label for="actor">Actor</label>
        <select class="form-control" name="actor" required>'.$actorsOptions.
 '</select>
    </div>
    <div class="form-group">
          <label for="role">Role</label>
          <input type="text" class="form-control" placeholder="bystander" name="role">
    </div>
        <button type="submit" name="submit" class="btn btn-default">Rate It!</button>
    </form>'); ?>

<?php footer(); ?>

</body>

</html>





