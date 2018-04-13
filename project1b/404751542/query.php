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
    $conn=new mysqli($servername,$username,$password,'TEST');
    if($conn->connect_error > 0){
       die("Connect Error");
    }
    echo "Connected!";

    if (!empty($_GET['expr'])) {

      $query = $_GET['expr'];
      $rs=$db->query($query);

    if (!$rs)) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br />";
        exit(1);
    }

    while($row = $rs->fetch_assoc()) {
        $sid = $row['id'];
        print "$id<br />";
        }
        $rs->free();
  }

/*    set_error_handler("error_handler", E_ALL);
    try {
      if (!empty($_GET['expr'])) {
        if(preg_match('/[^0-9\+\-\*\.\/]+/',$_GET['expr'],$matches, PREG_OFFSET_CAPTURE)===1)
          echo 'Invalid Expression!';
        else {
          $sol= eval('return '.$_GET['expr'].';');
          echo $_GET['expr'].'='.$sol;
        }
      }
    } catch (Exception $e) {
      echo 'Invalid Expression!';
    }
    function error_handler($errno, $errstr) {
      throw new ErrorException('', $errno);
    }
    */
  ?>
</html>
