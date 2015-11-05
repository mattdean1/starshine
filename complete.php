<?php
//defines array containing disabled seat names
$arraydisabled = array('A11','B12','C13','D14','E15','F15','G14','H14','I14','J15','K15',
'A12','B13','C14','D15','E16','F16','G15','H15','I15','J16');

//gets current date in the format recognised by SQL
$currentdate = date('Y-m-d');

//retrieves data from previous page
$datepost = $_POST['date'];
$showpost = $_POST['showname'];

$seats1 = $_POST["seat"]; //gets seats as encoded array
$seats = unserialize($seats1); //decodes seats array
$seatsimp = implode(',',$seats); //converts seats array to string
$prices1 = $_POST["prices"]; //gets prices as encoded array
$prices = unserialize($prices1); // decodes prices array
$totalprice = $_POST["price"]; //get total price
//get customer data entered on previous page
$title = $_POST["title"];
$name1 = $_POST["firstname"];
$name2 = $_POST["lastname"];
$email = $_POST["email"];
$home = $_POST["homephone"];
$mobile = $_POST["mobile"];


//### set seats to booked ###//
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//loops through all seats in array
	foreach ($seats as $value){
		//query updates the value of the date field where the seat id(name) is the value
		// of the item in the current iteration
		$query = "UPDATE tbl_seats SET `$datepost`=0 WHERE `seats_id`='$value'";
		$stmt = $conn->prepare($query);
    	$stmt->execute();
	}
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
} 


//### check if customer email exists in tbl_customer ###//
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
	//query selects the customer id for the specified customer email
    $query="SELECT pk_customer FROM tbl_customer WHERE customer_email='$email'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetchAll();
    //gets the first value in the array
    $rowpk = $row[0][0];
    //counts the number of items in this value - 1=exists, 0=does not exist
    $rowsum = count($row);

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
//if email does not exist (customer has not made a previous booking):
if ($rowsum==0){
	//* update customer details *//
		try {
		// connect to the database using the new more secure PDO method
			$conn = 
			new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//query inserts new record into table, with fields specified within the first 
			//set of parentheses, and the values to be placed in these
			//fields inside the second set of parentheses
			$query = "INSERT INTO tbl_customer (customer_title,customer_forename,
			customer_surname,customer_homephone,customer_mobile,customer_email)
			VALUES ('$title','$name1','$name2','$home','$mobile','$email')";
			$stmt = $conn->prepare($query);
			$stmt->execute();
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
	//* get pk for customer just added *//
		try {
		// connect to the database using the new more secure PDO method
			$conn = 
			new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
			//query selects the customer id for the specified customer email
			$query=
			"SELECT pk_customer FROM tbl_customer WHERE customer_email='$email'";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$row = $stmt->fetchAll();
			$rowpk = $row[0][0];
		
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
}
//if customer has made a previous booking(email exists), or customer details have 
//been added to the database^^ :
//### update order details ###//
	try {
	// connect to the database using the new more secure PDO method
		$conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//query inserts new record into table, with fields specified within the first 
		//set of parentheses, and the values to be placed in these
		//fields inside the second set of parentheses
		$query = "INSERT INTO tbl_order (order_customerid,order_date,order_totalprice,
		order_showname,order_showdate,order_seatsbooked)
		VALUES ('$rowpk','$currentdate','$totalprice','$showpost',
		'$datepost','$seatsimp')";
		$stmt = $conn->prepare($query);
		$stmt->execute();
	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}

//### commence email  - formatted in html for aesthetics - basically the same content 
//### as the summary table from the previous page
$subject = "Starshine Theatre Booking Confirmation"; //subject
$headers = "From: " . "SADS" . "\r\n"; //header information - from
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; //header information - 
//defines html and character formatting
//message
	$message = "<html><body>";
	//notice inline style (e.g. style="color:#000000;") - since css is not 
	//currently hosted online
	$message .= '<p style="color:#000000;">Dear ' . $title . " " . $name2 . ",</p>"; 
	//notice point(.) between php variables and html message
	$message .= '<p style="color:#000000;">Please bring a copy of this email with 
	you on the night of the performance to guarantee entry.</p>';
	$message .= '<p style="color:#000000;">Thankyou for your booking. 
	Booking details are confirmed below:</p><br />';
	$message .= '<table style="border-collapse:collapse;" cellpadding="10"><tr>';
	$message .= '<td style="border:1px solid black;text-align:center;" colspan="2">';
	$message .= "<p><b>Reservation Summary</b></p></td></tr>";
	$message .= '<tr><td style="border:1px solid black;text-align:center;">
	<p><i>Seat</i></p>';
	$message .= '<td style="border:1px solid black;text-align:center;">
	<p><i>Price</i></p></tr>';
	//loops through each seat booked
	foreach ($seats as $value){
		$message .= 
	'<tr><td style="border:1px solid black;height:25px;text-align:center;padding:2px;">';
		//displays disabled or regular seat information
		if (in_array($value,$arraydisabled)) {
			$message .= "" . $value . "(Disabled)";
			}
			else {
			$message .= "" . $value . "";
			}
		$message .= 
	'</td><td style="border:1px solid black;height:25px;text-align:center;padding:2px;">';
		//displays corresponding price tier
		if (ereg("A|B|C",$value)) {
			$price = "£10.00";
			}
			elseif (ereg("D|E|F",$value)) {
			$price = "£12.50";
			}
			else {
			$price = "£7.25";
			}			
		$message .= "" . $price . "";
		$message .= "</td></tr>";	
	}
	$message .= 
	'</table><br /><table style="border-collapse:collapse;" cellpadding="10"><tr>';
	$message .= '<td style="border:1px solid black;text-align:center;">';
	$message .= "<p><b>Total Price</b></p></td>";
	$message .= '<td style="border:1px solid black;text-align:center;">';
	$message .= "" . $totalprice . "</td></tr></table>";
	$message .= '<br /><table style="border-collapse:collapse;" cellpadding="10"><tr>';
	$message .= '<td style="border:1px solid black;text-align:center;">';
	$message .= "<p><b>Customer ID</b></p></td>";
	$message .= '<td style="border:1px solid black;text-align:center;">';
	$message .= "" . $rowpk . "</td></tr></table>";
	$message .= '<p style="color:#000000;">Show: ' . $showpost . '</p>';
	$message .= '<p style="color:#000000;">Date: ' . $datepost . '</p>';
	$message .= "</body></html>";
	//end email
	

?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Reservation Complete</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
  <script type="text/javascript"></script>
	<script>
	//function closes current tab - to be called on button press
		function closeMe()
		{
		//get current tab - (actually opens another tab, since only tabs 
		//opened by the program can be closed)
		var win = window.open("","_self"); /*url = “” or “about:blank”; 
		//target=”_self”*/ //preceding comment to be used in the event of incompatibility
		//close current tab
		win.close();
		}
	</script>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">
     

	<?php
		//if email is sent sucessfully, display confirmation message
if (mail($email, $subject, $message, $headers)) {
echo "<p>Thankyou ".$title." ".$name2.", your seat(s) have now been booked.<p/><br />";
echo "<p>A confirmation email has been sent to ".$email.".<p/><br /><br /><br />";
echo "This tab may now be closed.";
} 
		//if email is not sent, display error message
		else {
			echo("Booking Failed - Please try again");
		}
	?>

	<table class="center" align="center" id="buttons">
		<tr>
		<!---button closes tab by calling closeme funciton onclick---!>
			<td class="button">
			<a><img align="center" alt="closebutton"
			src="images/close.png"
			onmouseover="this.src='images/closeMouseOver.png';"
			onmouseout="this.src='images/close.png';"
			onclick="closeMe();" 
			</img><a>
			</td>
		</tr>
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
		<p> Reservation Complete </p>
  </div>
</div>
</body>
</html>
