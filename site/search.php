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
<?php heading('Search'); ?>

<?php

form('<form method="GET" action="search.php">
    <div class="form-group">
          <input type="search" class="form-control" placeholder="Search..." name="search">
    </div>
        <button type="submit" class="btn btn-default">Search!</button>
    </form>'); ?>

<?php
    function display()
    {

        $query=$_GET['search'];
        $movies=search_movie($query);
        //$actors=search_actor($query);

        $moviesHTML='';
       /* foreach($movies as $movie){
            $newMovie= sprintf('<li class="list-group-item"><a href="browse_movie.php?identifier=%u">%s (%s)</a> as %s</li>',$movie['id'],$movie['title'],$movie['year'],$movie['role']);
            $moviesHTML=$moviesHTML.$newMovie;
        }
*/
        $actorsHTML='';
       /* foreach($actors as $actor){
            $newActor= sprintf('<li class="list-group-item"><a href="browse_actor.php?identifier=%u">%s %s</a> as %s</li>',$actor['id'],$actor['first'],$actor['last'],$actor['role']);
            $actorsHTML=$actorsHTML.$newActor;
        }
*/

         print '<div class="container ">';
         print "<h1>Search results for ".$query."</h1>";
         print '<hr/>';
         print '<h1>Actors Found</h1>';
        print '<ul class="list-group">'.$actorsHTML.'</ul>';
        print '<hr/>';
         print '<h1>Movies Found</h1>';
        print '<ul class="list-group">'.$moviesHTML.'</ul>';
         print '</div>';

    }
    if(isset($_GET['search']))
    {
       display();
    }
?>

<?php footer(); ?>

</body>

</html>





