<?php
//retrieves data from previous page
$showpost = $_POST['showname'];
$datepost = $_POST['date'];

//gets seats chosen as comma seperated string
$selectedpost = $_POST["hiddenF"];
//creates array from string
$arrayselected = explode(",", $selectedpost);
//counts number of items(seats) in array
$selectedpostcount = count($arrayselected);
//arrays must be encoded to be passed through POST
$data=serialize($arrayselected); 
$encoded=htmlentities($data);

//defines array containing all disabled(aisle) seats
$arraydisabled = array('A11','B12','C13','D14','E15','F15','G14','H14','I14',
'J15','K15','A12','B13','C14','D15','E16','F16','G15','H15','I15','J16');
//defines empty array for prices to be added to later
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
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">
   
 <form id="custform" action="complete.php" method="post">
 	<!---table summarises booking details---!> 
	<table class="center" align="center" id="priceinfo">
		<tr>
			<td class="info" colspan="2"><p><b>Reservation Summary</b></p></td> 
			<!---notice double column span---!>
		</tr>
		<tr>
		<!---formatted column headings---!>
			<td class="info"><p><i>Seat</i></p>
			<td class="info"><p><i>Price</i></p>
		</tr>
	 	<?php
	 	//loops through each item(seat) in the array
    	foreach ($arrayselected as $value){
		?>
			<tr>	
				<td class="info">
					<?php
					//displays seatname and "(Disabled)" if seat name is contained in 
					//the array of disabled seats defined earlier
					if (in_array($value,$arraydisabled)) {
					echo $value." (Disabled)";
					}
					//just displays seat name if seat name is not a disabled seat
					else {
					echo $value;
					}
					?>
				</td>
				<!---price information---!>
				<td class="info" class="pricename">
					<?php
				//seat is worth £10 the seat name contains any of the characters A,B or C
					if (ereg("A|B|C",$value)) {
					// adds seat price to empty array defined earlier
					array_push($arrayprices,"10.00"); 
					$price = "£10.00"; //sets value of variable to the correct price tier
					}
					//otherwise does the same for the relevant tier of seat pricing
					elseif (ereg("D|E|F",$value)) {
					array_push($arrayprices,"12.50");
					$price = "£12.50";
					}
					else {
					array_push($arrayprices,"07.25");
					$price = "£7.25";
					}			
					echo $price; //displays the price of the seat
					?>
				</td>
      		</tr>	
		<?php
		}
		?>
	</table>
	
	<!---table containing total price---!>
	<table class="center" align="center" id="priceinfo">
		<tr>
			<td class="info"><p><b>Total Price</b></p></td> 
			<!---single column(span) table---!>
			<td class="info">
				<?php
				//gets total price by adding values pushed the price array
				$pricetotal = array_sum($arrayprices); 
				 //formats total price to have 2 decimal places (currency)
				$totalformat = number_format($pricetotal,$decimals=2);
				//inserts a pound sign in front of the price
				$totalsign = "£".$totalformat; 
				echo $totalsign; //display total price
				//array containing prices must be encoded to be passed through POST
				$data2=serialize($arrayprices); 
				$encoded2=htmlentities($data2);
				?>
				<!---hidden inputs in order to pass data to the next page---!>
				<input type="hidden" name="price" value="<?php echo $totalformat; ?>">
				<input type="hidden" name="seat" value="<?php echo $encoded; ?>">
				<input type="hidden" name="prices" value="<?php echo $encoded2; ?>">
				<input type="hidden" name="date" value="<?php echo $datepost; ?>">
				<input type="hidden" name="showname" value="<?php echo $showpost; ?>">
				
			</td>
		</tr>
	</table>
	
	<!---data entry section - divs ensure correct placement on page---!>
	<div class="styleformouter">
	<div class="styleform">
	<!---labels ensure all fields are lined up vertically and spaced correctly---!>
	<label class="custlabel">*Title: </label>
		<!---dropdown to select title---!>
		<select name="title" id="title">
		<option value="Mr">Mr</option>
		<option value="Mrs">Mrs</option>
		<option value="Ms">Ms</option>
		<option value="Dr">Dr</option>
		<option value="Professor">Professor</option>
		</select>	
		<br />
		<!---named fields and text inputs for the rest of the data required---!>
		<!---all fields requires - form cannot be submitted unless data is present---!>
	<label class="custlabel">*First Name: </label><input type="text" name="firstname" 
	class="details" required="required"/><br />
	<label class="custlabel">*Last Name: </label><input type="text" name="lastname" 
	class="details" required="required"/><br />
	<!---type=email validates the field on before submitting the form
	 - must be a valid email---!>
	<label class="custlabel">*Email: </label><input type="email" name="email" 
	class="details" required="required"/><br />
	<!---maxlength ensures customer can only enter 11 digits, pattern ensures 11 digits 
	are entered(not less), title informs customer of pattern to be matched---!>
	<label class="custlabel">*Home Phone: </label>
		<input type="text" name="homephone" class="details" maxlength="11" 
		required="required" pattern=".{11,11}" 
		title="Enter 11 numeric digits (no special characters)"/><br />
	<label class="custlabel">&nbsp&nbspMobile: </label>
		<input type="text" name="mobile" class="details" maxlength="11" 
		pattern=".{11,11}" 
		title="Enter 11 numeric digits (no special characters)"/><br />
	</div>
	</div>
	

 
 <!---displays a reminder/confirmation of the show and date selected---!>
 <div>
 	<br />
 	Show: <?php echo $showpost; ?>
 	<br />
 	Date: <?php echo $datepost; ?>
 </div> 
 	
	<table class="center" align="center" id="buttons">
		<tr>
		<!---buttons---!>
			<td class="button">
			<!---back button returns user to previous page---!>
			<a href="seatselect.php"><img align="center" alt="backbutton"
			src="images/back.png"
			onmouseover="this.src='images/backMouseOver.png';"
			onmouseout="this.src='images/back.png';"
			</img><a>
			</td>
			<td class="button">
			<!---confirms and validates all details entered and seats selected 
			and passes form data to next page---!>
			<input type="image" name="submit" 
			src="images/confirm.png"
			onmouseover="this.src='images/confirmMouseOver.png';"
			onmouseout="this.src='images/confirm.png';"/>
			</td>
		</tr>
	</table>

 </form>
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
		<p> Please Confirm Reservation and Enter Details</p>
  </div>
</div>
</body>
</html>
