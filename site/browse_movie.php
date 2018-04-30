<?php
   include("./config.php");
   include("./common.php");
   include("./functions.php"); ?>

<html>

<head>
     <?php headerer(); ?>
</head>

<body >

<?php navigation(); ?>

<?php
    function display2()
    {

        heading('Browse Movies');

        form('<form method="GET" action="browse_movie.php">
        <div class="form-group">
              <input type="search" class="form-control" placeholder="Search..." name="identifier">
        </div>
            <button type="submit" class="btn btn-default">Browse!</button>
        </form>');
    }
    if(!isset($_GET['identifier']))
    {
       display2();
    }
?>

<?php
    function display()
    {
        $id = $_GET["identifier"];
        $info=get_movie_info($id);
        $actors=get_movie_actors($id);
        $directors=get_movie_directors($id);
        $genres=get_movie_genres($id);
        $reviews=get_movie_reviews($id);
        $ave=get_movie_average_score($id);

        $genreHTML='';
        foreach($genres as $genre){
            $newGenre= sprintf('<span class="badge badge-info">%s</span>',$genre);
            $genreHTML=$genreHTML.$newGenre;
        }
        $subtitle='Rated '.$info['rating'];
        if(!empty ($info['company']))
            $subtitle=$subtitle.' - Produced by '.$info['company'];

        if(array_key_exists('0',$directors))
            $subtitle=$subtitle.' - Directed by ';
        foreach($directors as $director){
            $subtitle=$subtitle.' '.$director['first'].' '.$director['last'];
        }

        $actorsHTML='<li class="list-group-item list-group-item-info">Actors in this Movie</li>';
        foreach($actors as $actor){
            $newActor= sprintf('<li class="list-group-item"><a href="browse_actor.php?identifier=%u">%s %s</a> as %s</li>',$actor['id'],$actor['first'],$actor['last'],$actor['role']);
            $actorsHTML=$actorsHTML.$newActor;
        }

        $reviewsHTML='';

        if(!array_key_exists('0',$directors))
            $reviewsHTML='No Reviews for this movie!';
        foreach($reviews as $review){
            $review= sprintf('<li class="list-group-item">%s - %s: %s %s<span class="badge badge-primary badge-pill">%s</span></li>',$review['time'],$review['name'],$actor['comment'],$actor['rating']);
            $reviewsHTML=$reviewsHTML.$review;
        }

        print '<div class="jumbotron jumbotron-fluid ">
          <div class="container">
            <h1 class="display-4">'.$info['title'].' ('.$info['year'].')</h1>
            <h3 >'.$subtitle.'</h3>'.$genreHTML.'
          </div>
        </div>';

         print '<div class="container ">';
         print '<hr/>';
         print '<h1>Actors in this Movie</h1>';
        print '<ul class="list-group">'.$actorsHTML.'</ul>';
        print '<hr/>';
         print '<h1>Reviews for this Movie</h1>';
        print '<ul class="list-group">'.$reviewsHTML.'</ul>';
         print '</div>';


    }
    if(isset($_GET['identifier']))
    {
       display();
    }
?>

<?php footer(); ?>

</body>
</html>





