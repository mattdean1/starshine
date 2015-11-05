<?php
//use the try catch routine for error handling
//test db connection - data retrieval
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
// fetch the data
    $query="SELECT * FROM tbl_customer";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch();
    $testvar=$row['customer_surname'];
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$selectedpost = $_POST["hiddenF"];
$arrayselected = explode(",", $selectedpost);
$selectedpostcount = count($arrayselected);
//print_r($arrayselected);
$data=serialize($arrayselected); 
$encoded=htmlentities($data);

$arraydisabled = array('A11','B12','C13','D14','E15','F15','G14','H14','I14','J15','K15','A12','B13','C14','D15','E16','F16','G15','H15','I15','J16');
$arrayprices = array('');
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Summary</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
  <script type="text/javascript"></script>
    <script>
	function submitcustdetail(){
	document.getElementById("custform").submit();
	}
	</script>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">
   
 <form id="custform" action="test.php" method="post"> 
  
	<table class="center" align="center" id="priceinfo">
		<tr>
			<td class="info" colspan="2"><p><b>Reservation Summary</b></p></td>
		</tr>
		<tr>
			<td class="info"><p><i>Seat</i></p>
			<td class="info"><p><i>Price</i></p>
		</tr>
	 	<?php
    	foreach ($arrayselected as $value){
		?>
			<tr>	
				<td class="info">
					<?php
					if (in_array($value,$arraydisabled)) {
					echo $value." (Disabled)";
					}
					else {
					echo $value;
					}
					?>
				</td>
				<td class="info" class="pricename">
					<?php
					if (ereg("A|B|C",$value)) {
					array_push($arrayprices,"10.00");
					$price = "£10.00";
					}
					elseif (ereg("D|E|F",$value)) {
					array_push($arrayprices,"12.50");
					$price = "£12.50";
					}
					else {
					array_push($arrayprices,"07.25");
					$price = "£7.25";
					}			
					echo $price;
					?>
				</td>
      		</tr>	
		<?php
		}
		?>
	</table>
	
	<table class="center" align="center" id="priceinfo">
		<tr>
			<td class="info"><p><b>Total Price</b></p></td>
			<td class="info">
				<?php
				$pricetotal = array_sum($arrayprices);
				$totalformat = number_format($pricetotal,$decimals=2);
				$totalsign = "£".$totalformat;
				echo $totalsign;
				$data2=serialize($arrayprices); 
				$encoded2=htmlentities($data2);
				?>
				<input type="hidden" name="price" value="<?php echo $totalformat; ?>">
				<input type="hidden" name="seat" value="<?php echo $encoded; ?>">
				<input type="hidden" name="prices" value="<?php echo $encoded2; ?>">
			</td>
		</tr>
	</table>
	
	<div class="styleformouter">
	<div class="styleform">
	<label class="custlabel">Title: </label>
		<select name="title" id="title">
		<option value="Mr">Mr</option>
		<option value="Mrs">Mrs</option>
		<option value="Ms">Ms</option>
		<option value="Dr">Dr</option>
		</select>	
		<br />
	<label class="custlabel">First Name: </label><input type="text" name="firstname" class="details" /><br />
	<label class="custlabel">Last Name: </label><input type="text" name="lastname" class="details" /><br />
	<label class="custlabel">Email: </label><input type="text" name="email" class="details" /><br />
	<label class="custlabel">Home Phone: </label><input type="text" name="homephone" class="details" /><br />
	<label class="custlabel">Mobile: </label><input type="text" name="mobile" class="details" /><br />
	</div>
	</div>
	
 </form>
 	
 	
	<table class="center" align="center" id="buttons">
		<tr>
			<td class="button">
			<a href="seatselect.php"><img align="center" alt="backbutton"
			src="images/back.png"
			onmouseover="this.src='images/backMouseOver.png';"
			onmouseout="this.src='images/back.png';"
			</img><a>
			</td>
			<td class="button">
			<a><img align="center" alt="confirmbutton"
			src="images/confirm.png"
			onmouseover="this.src='images/confirmMouseOver.png';"
			onmouseout="this.src='images/confirm.png';"
			onclick="submitcustdetail();"
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
        &copy;&nbsp; Matt Dean &nbsp;2012
      </p>
    </div>
  </div>
</div>
<div id="header">
  <div id="header-inner">
    <div id="subheader2">
		<h1>Starshine Booking System</h1>
		<p> Please Confirm Reservation and Enter Details</p>
  </div>
</div>
</body>
</html>
