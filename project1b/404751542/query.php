<html>
  <p>
    Type a query!
    <br/>
    Example: Select * FROM Actor WHERE id=11;

    <form method="GET">
      <input type="text" name="expr"><br>
      <input type="submit" value="Calculate">
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
    $query = $_GET['expr'];
     
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
  while($row = $rs->fetch_assoc()) {

  $x=array_keys($row);

  if($first){
    foreach ($x as $i){
       print $i . " ";
     }
   $first=FALSE;
  }
  print "<br/>";
  
  foreach($x as $i){
            $res = $row[$i];
            print $res . " ";
       }
       print "<br/>";
  }
  
     $rs->free();
  }
  ?>
</html>
