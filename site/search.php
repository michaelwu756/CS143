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

        notify("Searching for ".$_GET["search"]);
        //$title, $year, $rating, $company

    }
    if(isset($_GET['search']))
    {
       display();
    }
?>

<?php footer(); ?>

</body>

</html>





