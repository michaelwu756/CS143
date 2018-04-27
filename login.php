<?php
   include("config.php");
   include("common.php");
?>

<html>

<head>

    <?php headerer($g_pagetitle.' - Log In'); ?>
</head>

<body>

<?php navigation("login"); ?>

<div class='container text-center' style='padding-top:5em;'>


<?php
   // must do a quick pre-authentication so that navigation bar shows correctly
   $team       = $_POST["team"];
   $password   = $_POST["password"];

   // authenticate the team
   if ($team && $password)
   {
      if (array_key_exists($team, $g_teams) && $g_teams[$team] == $password) {
         $_SESSION["teamid"] = $team;
         $_SESSION["password"] = $password;
      }
   }
   // otherwise log the team out
   else if (isset($_SESSION["teamid"]))
   {
      $team = $_SESSION["teamid"];
      unset($_SESSION["teamid"]);
      unset($_SESSION["password"]);
      unset($_SESSION["language"]);
      $loggedout = true;
   }
?>



<?php


   // if on the POST, a team and password was entered
   if ($team && $password)
   {
      // authenticate the team
      if (array_key_exists($team, $g_teams) && $g_teams[$team] == $password)
      {
         //$_SESSION["teamid"] = $team;



         print '<div class="alert alert-success" role="alert">Now logged in as '.$team.'.</div>';
      }
      else
      {
         if (array_key_exists($team, $g_teams))
            print '<div class="alert alert-danger" role="alert">Incorrect password!</div>';
         else
            print '<div class="alert alert-danger" role="alert">Unknown team name!</div>';
      }
   }
   // otherwise, we are attempting to log out
   else if ($loggedout)
   {
    print '<div class="alert alert-success" role="alert">Team '.$team.' is now logged out.</div>';

   }

    print '<form class="border text-left" style="max-width:500px;margin:auto; padding:2em;background:white;" name="login" method="post" action="login.php">
<div align="center"><h3 >Team Log In</h3>';

   if (empty($_SESSION["teamid"]))
   {

      print '<p><i>Warning: Team name is <b>case-sensitive</b>!!!</i></p></div>
 <div class="form-group">
    <label class="form-label">Team</label>
     <input class="form-control" type="text" name="team"/>
   </div>
 <div class="form-group">
    <label class="form-label">Password</label>
     <input class="form-control" type="password" name="password"/>
   </div>

<div align="center">
<button type="submit" class="btn btn-secondary" value="submit" >Log Me In!</button>
</div>';
   }

      print "</form>";
?>

</div>

</div>

<?php footer($contest->chost); ?>

</body>

</html>