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
<?php heading('Browse Actors'); ?>

<?php

form('<form method="GET" action="browse_actor.php">
    <div class="form-group">
          <input type="search" class="form-control" placeholder="Search..." name="search">
    </div>
        <button type="submit" class="btn btn-default">Browse!</button>
    </form>'); ?>

<?php
    function display()
    {

        notify("Browsing actors for ".$_GET["search"]);
        //$title, $year, $rating, $company
        //add_movie($_POST["lname"], $_POST["fname"], $_POST["sex"], $_POST["dateb"], $_POST["dated"]);

    }
    if(isset($_GET['search']))
    {
       display();
    }
?>

<?php footer(); ?>

</body>

</html>





