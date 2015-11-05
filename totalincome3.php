<?php
//retrieves show date from previous page
$date = $_POST['date'];


//### get seat name and price ###//
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
	//query selects seats id(name) and price where date field = 0 
	//(i.e. the seat is booked)
    $query="SELECT seats_id,seats_price FROM tbl_seats WHERE `$date`=0";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetchAll();
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

//define empty array for price
$arrayprices = array('');
//count number of items(seats) in array
$count = count($row);
//loop through all seats
for($i = 0; $i < $count; $i++):
	$price1 = $row[$i][1]; //get seat price for this iteration of [i]
	array_push($arrayprices,$price1); //add seat price to empty array defined earlier
endfor;
//get total price by adding all items(prices) in array
$sum = array_sum($arrayprices);
//get total number of items(seat prices) in array
$count1 = count($row);

?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title> Total Income - Display</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">
    
    <!---display the total number of seats booked and the total price of all 
    seats booked(turnover)---!>
	Total Seats Booked: <?php echo $count1 ?>
	<br />
	<br />
	Total Income: £
	<?php echo $sum ?>
	<br />
	<br />

    </div>
    <div id="clearfootercenter"></div>
  </div>
</div>
<div id="footer">
  <div id="footer-inner">
    <div id="subfooter1">
      <p class="smalltext">
        &copy;&nbsp; Matt Dean &nbsp;2013
      </p>
    </div>
  </div>
</div>
<div id="header">
  <div id="header-inner">
    <div id="subheader2">
      <h1>Starshine Booking System</h1>
      <p> Display Income from Performance</p>
  </div>
</div>
</body>
</html>