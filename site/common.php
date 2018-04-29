
<?php
    include("./config.php");


    function headerer(){
        global $title;
        print "<title>".$title."</title>\n";
        print '<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="UCLA Coding Competition" />
    <meta name="author" content="" />
    <title>Movies!</title>
    <!-- Bootstrap core CSS-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <link rel="stylesheet" href="./style.css" >

    ';
    }

   function navigation()
   {
    print '
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">CS143</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Add
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
          <a class="dropdown-item" href="add_actor.php">Actor</a>
          <a class="dropdown-item" href="add_director.php">Director</a>
          <a class="dropdown-item" href="add_movie.php">Movie</a>
          <a class="dropdown-item" href="add_comment.php">Comment</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="add_actormovierel.php">Actor/Movie Relation</a>
          <a class="dropdown-item" href="add_directormovierel.php">Director/Movie Relation</a>
        </div>
      </li>

       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Browse
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
          <a class="dropdown-item" href="browse_actor.php">Actor</a>
          <a class="dropdown-item" href="browse_movie.php">Movie</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
      <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search"/>
      <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>';
   }

   function form($info){
      print '<div class="container">'.$info.'</div>';
   }

  function heading($header)
   {
  print
    '<div class="jumbotron jumbotron-fluid ">
      <div class="container">
        <h1 class="display-4">'.$header.'</h1>
      </div>
    </div>';
   }


  function notify_success($notif)
  {
    print '<div class="container"><div class="alert alert-success" role="alert">'.$notif.'</div></div>';
  }

   function footer()
   {
    print '<hr/>';
      print '<footer class="container py-5">
      <div class="row ">
        <div class="col-12 col-md">
          <img src="./images/bear.png" style="margin-bottom:5px"></img>
          <p class="d-block mb-3 text-muted">CS143 Movies System 2018<br/>
            Created by Jennie Zheng and Michael Wu
         </p>
     </div>
      </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    ';
   }



   // -----------------------------------------------------------------------

   class Clarification
   {
      var $id;
      var $from;
      var $problem;
      var $responded = False;
      var $fresh = False;
      var $question;
      var $answer;

      function Clarification($team, $p, $q)
      {
         $this->id = time();
         $this->from = $team;
         $this->problem = $p;
         $this->question = $q;
      }

      function read($fp)
      {
         $stamp = (int) trim(fgets($fp));
         $team = trim(fgets($fp));
         $p = trim(fgets($fp));
         $r = (boolean) trim(fgets($fp));
         $q = "";
         $a = "";
         if (trim(fgets($fp)) == "{")
            for ($line = fgets($fp); trim($line) != "}"; $line = fgets($fp))
               $q = $q . $line;
         if ($r && trim(fgets($fp)) == "{")
            for ($line = fgets($fp); trim($line) != "}"; $line = fgets($fp))
               $a = $a . $line;

         $c = new Clarification($team, $p, $q);
         $c->id = $stamp;
         $c->responded = $r;
         $c->answer = $a;

         return $c;
      }

      function write($fp)
      {
         if ($fp)
         {
            fputs($fp, $this->id . "\n");
            fputs($fp, $this->from . "\n");
            fputs($fp, $this->problem . "\n");
            fputs($fp, $this->responded . "\n");
            fputs($fp, "{\n" . $this->question . "\n}\n");
            if ($this->responded)
               fputs($fp, "{\n" . $this->answer . "\n}\n");
         }
      }

   }

       // -----------------------------------------------------------------------
?>
