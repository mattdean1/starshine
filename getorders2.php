<?php
//retrieve customer names from previous page
$name1post = $_POST['custname1'];
$name2post = $_POST['custname2'];

//### get customer id for name1 and name2 ###//
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
	//query selects customer id from table where the customer name fields correspond 
	//to the values entered previously
    $query="SELECT pk_customer FROM tbl_customer WHERE customer_forename='$name1post' 
    AND customer_surname='$name2post'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch();
    $custid = $row[0];
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

//### get order details for customer id just found ###//
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
	//select order details from table where the customer id = the one just found
    $query="SELECT order_date,order_totalprice,order_showname,
    order_showdate,order_seatsbooked
    FROM tbl_order WHERE order_customerid='$custid'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row1 = $stmt->fetchAll();
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Get Orders - 2</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">
    
    	<table class="center" align="center" id="orderinfo">
    		<tr>
    		<!---display column headings---!>
				<td class="orderinfo"><p><i>Order Date</i></p>
				<td class="orderinfo"><p><i>Total Price</i></p>
				<td class="orderinfo"><p><i>Show Name</i></p>
				<td class="orderinfo"><p><i>Show Date</i></p>
				<td class="orderinfo"><p><i>Seats Booked</i></p>
			</tr>
		<?php
		//count number of items (seperate orders) in array
			$count = count($row1);
		//loop through all orders
			for($i = 0; $i < $count; $i++):
				//set variable to the order in this iteration of [i]
				$print=$row1[$i];
		?>
				<tr>
					<!---display the order date---!>
					<td class="orderinfo"><?php echo $print[0] ?></td>
					<td class="orderinfo"><?php
					$unformatted = $print[1]; //get the total price in raw number format
					//format price to have 2 decimal places (currency)
					$numberformat = number_format($unformatted,$decimals=2); 
					 //insert pound sign in front of price
					$fullformat = "£".$numberformat;
					echo $fullformat; //display order price
					?></td>
					<!---display the order name, date and seats booked---!>
					<td class="orderinfo"><?php echo $print[2] ?></td>
					<td class="orderinfo"><?php echo $print[3] ?></td>
					<td class="orderinfo"><?php echo $print[4] ?></td>	
				</tr>					
		<?php
			endfor;
		?>
		</table>
    
    
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
      <p> Get Orders from Customer - 2</p>
  </div>
</div>
</body>
</html>