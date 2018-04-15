<html>
  <p>
    Type a query!
    <br/>
    Example: Select * FROM Actor WHERE id=11;

    <form method="GET">
      <textarea name="query" cols="60" rows="8">SELECT * FROM Actor WHERE id=10</textarea><br />
      <input type="submit" value="Submit">
    </form>
  </p>
  <?php
    $servername="localhost";
    $username="cs143";
    $password="";
    $database="CS143";
    $conn=new mysqli($servername,$username,$password,$database);
    if($conn->connect_error > 0){
       die("Connect Error");
    }
    print "Connected!<br/>";
    $query = $_GET['query'];

  if (!empty($query)) {

  print "Querying ".$query."<br/>";

  $rs=$conn->query($query);

  if (!$rs) {
        $errmsg = $conn->error;
        echo "Query failed: $errmsg <br />";
        exit(1);
  }
  print "Query succeeded! <br/>";
  print "Total results: " . $rs->num_rows . "<br/>";
  $first=TRUE;

 print "<h3>Results from MySQL:</h3>";

  print "<table border=1 cellspacing=1 cellpadding=2> ";
  while($row = $rs->fetch_assoc()) {

  $x=array_keys($row);

      if($first){
          print "<tr align=center>";
          foreach ($x as $i){
               print "<th>" . $i . "</th>";
          }

          $first=FALSE;
          print "</tr>";
          }

      print "<tr align=center>";
      foreach($x as $i){
            $res = $row[$i];
            print "<td>" . $res . "</td>";
      }
      print "</tr>";
  }

     $rs->free();
      }
  print "</table> ";
  ?>
</html>

