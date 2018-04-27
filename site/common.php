<?php
   // -----------------------------------------------------------------------
    include("./config.php");

    function headerer(){
        print "<title>".$title."</title>\n";
        print '<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="UCLA Coding Competition" />
    <meta name="author" content="" />
    <title>CodeSprint LA</title>
    <!-- Bootstrap core CSS-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <link rel="stylesheet" href="/style.css" >

    ';
    }

   function navigation($from)
   {
    print '

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#"> Code <img src="/images/paw.png" style="padding-left:1px; max-height: 25px;vertical-align: text-top;">  Sprint</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">';

      if ($from != "index")
         print "<li class='nav-item'><a class='nav-link ' href='index.php'> contest </a></li>";
      else print "<li class='nav-item'><a class='nav-link active' href='#'> contest </a></li>";

      if ($from != "scores")
         print "<li class='nav-item'><a class='nav-link' href='scores.php'> scoreboard </a></li>";
      else print "<li class='nav-item'><a class='nav-link active' href='#'> scoreboard </a></li>";

      if ($from != "submit")
         print "<li class='nav-item'><a class='nav-link' href='submit.php'> submissions </a></li>";
      else print "<li class='nav-item'><a class='nav-link active' href='#'> submissions </a></li>";

      if ($from != "clarify")
         print "<li class='nav-item'><a class='nav-link' href='clarify.php'> clarifications </a></li>";
      else print "<li class='nav-item'><a class='nav-link active' href='#'> clarifications </a></li>";

      if ($from != "help")
         print "<li class='nav-item'><a class='nav-link' href='help.php'> help </a></li>";
      else print "<li class='nav-item'><a class='nav-link active' href='#'> help </a></li>";

      print '</ul>';
      print '<ul class="navbar-nav navbar-right">';
      // toggle between displaying "Log In" and "Log Out"
      if (empty($_SESSION["teamid"]))
      {
         if ($from != "login")
            print "<a class='nav-link' href='login.php'>log in</a>";
         else print "<a class='nav-link active' href='#'>log in</a>";
      }
      else
      {
         print "<a class='nav-link' href='login.php'>log out</a>";
      }

      print '</ul>
      </div>
    </nav>';
   }


   function footer()
   {
    print '<hr/>';
      print '<footer class="container py-5">
      <div class="row">
        <div class="col-12 col-md">
          <img src="/images/bear.png" style="margin-bottom:5px"></img>
          <p class="d-block mb-3 text-muted">UCLA CodeSprint 2018<br/>
            Hosted by ACM - ICPC
    </div>

    <div class="col-12 col-md">
          <h5>Credits</h5>
          <p class="d-block mb-3 text-muted">
          Ultra Cool Programming<br/>
           Contest Control Centre v1.8<br/>
        Copyright &copy; 2005-2010<br/>
         By Sonny Chan</p>
    </div>

        <div class="col-12 col-md">
          <h5>Questions?</h5>
          <p class="text-muted">For your questions, comments, and issues...<br/>
            please contact your host today at<br>
            </p>
            <a class="text-muted" href="mailto:'.$email.'">'.$email.'</a>
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
