<?php
   include("./config.php");
   include("./common.php");
?>

<html>

<head>
     <?php headerer(); ?>
</head>


<body >
      <?php navigation(); ?>

<div>


  <div class="jumbotron jumbotron-fluid ">
          <div class="container">
            <h1 class="display-4">Welcome to Rotten Oranges!</h1>
        <p style='margin-top:30px;'>Feel free to add to our database or search for interesting movies!</p>
      </div>
    </div>';

<div class="container ">
  <div class="row ">
    <div class="col-12 col-md">
      <img src="./images/bear.png" style="margin-bottom:5px"></img>
      <p class="d-block mb-3 text-muted">CS143 Movie Database 2018<br/>
        Created by Jennie Zheng and Michael Wu
     </p>
 </div>
</div>


</div>

<?php footer(); ?>

</body>

</html>
