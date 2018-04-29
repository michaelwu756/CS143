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
<?php heading('Add Movie'); ?>

<?php
    function display()
    {

        //$title, $year, $rating, $company
        //add_movie($_POST["lname"], $_POST["fname"], $_POST["sex"], $_POST["dateb"], $_POST["dated"]);
        notify_success("Added Movie ".$_POST["title"]);
    }
    if(isset($_POST['submit']))
    {
       display();
    }
?>

<?php


form('<form method="POST" action="add_movie.php">
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" class="form-control" placeholder="Titanic" name="title">
    </div>
    <div class="form-group">
      <label for="company">Company</label>
      <input type="text" class="form-control" placeholder="Big Boats Company" name="company">
    </div>
    <div class="form-group">
      <label for="year">Year</label>
      <input type="text" class="form-control" placeholder="1990-03-07" name="year">
    </div>
    <div class="form-group">
        <label for="rating">MPAA Rating</label>
        <select class="form-control" name="rate">
            <option value="G">G</option>
            <option value="NC-17">NC-17</option>
            <option value="PG">PG</option>
            <option value="PG-13">PG-13</option>
            <option value="R">R</option>
        </select>
    </div>

    <div class="form-group">
        <label>Genre:</label>
        <input type="checkbox" name="genre[]" value="Action">Action
        <input type="checkbox" name="genre[]" value="Adult">Adult
        <input type="checkbox" name="genre[]" value="Adventure">Adventure
        <input type="checkbox" name="genre[]" value="Animation">Animation
        <input type="checkbox" name="genre[]" value="Comedy">Comedy
        <input type="checkbox" name="genre[]" value="Crime">Crime
        <input type="checkbox" name="genre[]" value="Documentary">Documentary
        <input type="checkbox" name="genre[]" value="Drama">Drama
        <input type="checkbox" name="genre[]" value="Family">Family
        <input type="checkbox" name="genre[]" value="Fantasy">Fantasy
        <input type="checkbox" name="genre[]" value="Horror">Horror
        <input type="checkbox" name="genre[]" value="Musical">Musical
        <input type="checkbox" name="genre[]" value="Mystery">Mystery
        <input type="checkbox" name="genre[]" value="Romance">Romance
        <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi
        <input type="checkbox" name="genre[]" value="Short">Short
        <input type="checkbox" name="genre[]" value="Thriller">Thriller
        <input type="checkbox" name="genre[]" value="War">War
        <input type="checkbox" name="genre[]" value="Western">Western
    </div>
        <button type="submit" name="submit" class="btn btn-default">Add It!</button>
    </form>'); ?>

<?php footer(); ?>

</body>

</html>





