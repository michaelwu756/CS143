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
        $res=connect_actor_to_movie($_POST["movie"], $_POST["actor"], $_POST["role"]);
        notify($res);
    }
    if(isset($_POST['submit']))
    {
       display();
    }
?>

<?php
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
        <label for="rating">Movie</label>
        <select class="form-control" name="movie" required>'.$moviesOptions.
    '</select>
    </div>
    <div class="form-group">
        <label for="rating">Actor</label>
        <select class="form-control" name="actor" required>'.$actorsOptions.
 '</select>
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





