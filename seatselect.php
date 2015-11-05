<?php
//retrieves data posted from previous page
$showpost = $_POST['showname'];
$datepost = $_POST['date'];
//get variables and data from db
//use the try catch routine to handle errors
try {
//connect to the database
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
	//fetch booked seats
    //query selects seat id(name) where the the selected date field = 0 
    //(i.e. the seat is booked)
 	$query="SELECT seats_id FROM tbl_seats WHERE `$datepost`=0";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $seatsbooked = $stmt->fetchAll();
    //defines empty array
    $seatsbookedarr = array('');
    //adds required values to array
    for ($x = 0; $x < 240; $x++):
    		array_push($seatsbookedarr,$seatsbooked[$x][0]);
    endfor;
//find seatrows - query selects everything from tbl_theatre
	$query2="SELECT * FROM tbl_theatre";
    $stmt2 = $conn->prepare($query2);
    $stmt2->execute();
    $row2 = $stmt2->fetch();
    //seatrows extracted from the array
    $seatrows=$row2['theatre_seatrows'];
//find seatcolumns - query selects everything from the table
	$query3="SELECT * FROM tbl_theatre";
    $stmt3 = $conn->prepare($query3);
    $stmt3->execute();
    $row3 = $stmt3->fetch();
    //seatcolumns is extracted from the array
    $seatcolumns=$row3['theatre_seatcolumns']; 
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

//function to convert integer to alpha character
function toAlpha($data){
    $alphabet = 
    array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R',
    'S','T','U','V','W','X','Y','Z');
    return $alphabet[$data];
}  
//array containing non-existent seats (used to specify layout)
$imaginaryseats = array('A0','A1','A2','A3','A18','A19','B0','B1','B2','B19','C0','C1',
'C19','D0','G0','H0','I0','J19','K15','K16','K17','K18','K19');
?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Select Seat(s)</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
  <script type="text/javascript"></script>
  <script>
  //toggles disabledseat background colour
	function changedisabledCell(td)
	{
	//find document nodes by element name
	var node = td;
	//searches all nodes in document once
	while ( (node = node.parentNode) != null )
	{
	//filters nodes by tagname
	if ( node.tagName == "TD" )
	{
	//toggles background colour depending on class of the element
	node.style.backgroundColor = td.checked ? "lightgreen" : "#B6ECFF";
	return;
	}
	}
	}
  </script>
  <script>
  //toggles realseat background colour
	function changeCell(td)
	{
	//finds document nodes by element name
	var node = td;
	//searches all nodes in document once
	while ( (node = node.parentNode) != null )
	{
	//filter nodes by tagname
	if ( node.tagName == "TD" )
	{
	//toggle background depending on class of the element
	node.style.backgroundColor = td.checked ? "lightgreen" : "#FFFFFF";
	return;
	}
	}
	}
  </script>
  <script>
  //resets all seats bg colour
	function resetAll( )
	{
	//gets all "td" elements
	var tds = document.getElementsByTagName("TD");
	//loops for all td elements
	for ( t = 0; t < tds.length; ++t )
	{
	//gets value from td's array for this iteration of [t]
	var td = tds[t];
	//gets "input" elements from "td" being examined in this iteration 
	var cbs = td.getElementsByTagName("INPUT");
	//loops for all input elements
	for ( c = 0; cbs != null && c < cbs.length; ++c )
	{
	//gets value from input's array for this iteration of [c]
	var cb = cbs[c];
	//filters input by checkbox type
	if ( cb.type == "checkbox" )
	{
	//sets checkbox to unchecked
	cb.checked = false;
		//sets background colour depending on class
		if (td.className == "disabledseat")
		{
		td.style.backgroundColor = "#B6ECFF";
		}
		else
		{
		td.style.backgroundColor = "#FFFFFF";
		}
	}
	}
	}
	}
  </script>
  <script>
  //gets all checked boxes (seats) and submits them (called on submit button)
  	//define funtion
	  function submitcheckedboxes() {
	  	//get all input elements from document
	  	var inputs = document.getElementsByTagName("input");
		var cbs = []; //defines empty array for checkboxes
		var checked = []; //defines empty array for checked checkboxes 
		//loops for all input elements
		for (var i = 0; i < inputs.length; i++) {  
			//filters inputs by type
		  if (inputs[i].type == "checkbox") {  
			cbs.push(inputs[i]);  //adds checkbox to array
				//filters checkboxes by value of checked(boolean)
			if (inputs[i].checked) {  
			  checked.push(inputs[i]);  // adds checked checkbox to array
			}  
		  }  
		}
		//defines variable as number of checked boxes
		var nbChecked = checked.length;
		var ckarr = []; //empty array for checked checkboxes values
			//loops for all checked boxes
			for (var j = 0; j < checked.length; j++) {
			// adds value of checked box for this iteration of [j] to array
			ckarr.push(checked[j].value);
			}
			//changes  hidden input to jscript array so php can read
		document.getElementById("hiddenF").value = ckarr; 
		document.getElementById("seatform").submit(); // submits form
	  }
  </script>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">

	<!---displays a representation of the stage---!>
	<table class="center" align="center" id="stage">
		<tr>
			<td class="default">
				<p>Stage</p>
			</td>
		</tr>
	</table>

	<form id="seatform" action="summary.php" method="post">
	<!---hidden inputs so data from previous page can be passed on to the next---!>
	<input type="hidden" name="showname" value="<?php echo $showpost; ?>">
	<input type="hidden" name="date" value="<?php echo $datepost; ?>">
    <table class="center" align="center" id="seats">
    <?php
    // loops through all seating rows
    for ($j = 0; $j < $seatrows; $j++):
    //set counter [k] to 0
    $k = 0;
	?>
		<tr>	
			<?php
			//loops through seat columns 0 to 14
			for ($i = 0; $i < 15; $i++):
			//calls function to convert row counter [j] to corresponding row letter 
			//(var name must contain function name)
			$toAlpha = toAlpha($j);	
			//full var containing function and $i(column number) e.g. A1	
  			$seatname = $toAlpha.$i;	
  				//displays empty cell if seat in this iteration of [j][i] is 
  				//nonexistent in the theatre layout
  				if (in_array($seatname, $imaginaryseats)): 
  				//counter is not progressed - seat names displayed on each row 
  				//must start from 1 (e.g. A1)
			?>
      				<td class="imaginaryseat">&nbsp</td>	
      		<?php
      			else: //if current seat is in the theatre seat layout 
      			$k++; //progress counter (to be used in the seat name displayed)
				$seatdisplay = $toAlpha.$k; //define seat name to be displayed
				//displays non-bookable seat if seat to be displayed is already booked
					if (in_array($seatdisplay, $seatsbookedarr)):
      		?>
      					<td class="unavailableseat"><?php echo $seatdisplay ?></td>
			<?php
				//displays disabled seat if column number = 14 (i.e. is an aisle seat)
					elseif ($i == 14):
			?>
						<!---coloured blue (using css) for easy identification---!>
						<td class="disabledseat"> 
						<!---label ensures entire cell is clickable---!>
						<!---checkbox is hidden through layering in the css style sheet 
						and is given the value of the seat name---!>
						<!---seat name displayed is in a seperate 'div' 
						so it can be positioned correctly inside the cell---!>
  						<label><input type=checkbox onclick="changedisabledCell(this);" 
  						value="<?php echo $seatdisplay ?>">
  						<div class="seatdisplay; seattext"><?php echo $seatdisplay ?>
  						</div></label>
						</td>
			<?php
					//displays regular seat when column number != 14 
					//(i.e. is not an aisle[disabled] seat)
					else:
			?>
					<!---coloured white (using css) for ease of viewing---!>
					<td class="realseat"> 
					<!---elements inside the cell are the same as the disabled seat 
					- see above ^^ ---!>
  					<label><input type=checkbox onclick="changeCell(this);" 
  					value="<?php echo $seatdisplay ?>">
  					<div class="seatdisplay; seattext"><?php echo $seatdisplay ?>
  					</div></label>
					</td>	
			<?php
					endif;	
				endif;
			endfor;
			?>
			<!---emtpy cell to make space between the two blocks of seats---!>
			<td class="seatspacer">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
			<!---*the following approximately 30 lines are the same as above, 
			repeating the process for the second block of seating*---!>
			<?php
			for ($i = 15; $i < $seatcolumns; $i++):
			$toAlpha = toAlpha($j);		
  			$seatname = $toAlpha.$i;
  				if (in_array($seatname, $imaginaryseats)):
			?>
    			<td class="imaginaryseat">&nbsp</td>
      		<?php
      			else:
      			$k++;
				$seatdisplay = $toAlpha.$k;
					if (in_array($seatdisplay, $seatsbookedarr)):
      		?>
      					<td class="unavailableseat"><?php echo $seatdisplay ?></td>
      		<?php
					elseif ($i==15):
			?>
						<td class="disabledseat">
  						<label><input type=checkbox onclick="changedisabledCell(this);" 
  						value="<?php echo $seatdisplay ?>">
  						<div class="seatdisplay; seattext">
  						<?php echo $seatdisplay ?></div></label>
						</td>
			<?php
					else:
			?>
						<td class="realseat">
  						<label><input type=checkbox onclick="changeCell(this);" 
  						value="<?php echo $seatdisplay ?>">
  						<div class="seatdisplay; seattext">
  						<?php echo $seatdisplay ?></div></label>
						</td>
			<?php
					endif;
				endif;    	
			endfor;
			?>
		</tr>
	<?php
	endfor;
	?>
    </table>
    <!---hidden input allows data gathered using the submitcheckedboxes function
     to be passed to the next page---!>
    <!--- value to be changed to jscript array so can be read by php ---!>
    <input type="hidden" id="hiddenF" name="hiddenF" value="">
    </form>

	<!---table displaying key to seat colours---!>
	<table class="center" align="center">
		<tr>
			<td class="info" id="disabledinfo"><p><b>Disabled Seating</b></p></td>
		</tr>
		<tr>
			<td class="info" id="seatselectinfo"><p><b>Selected Seating</b></p></td>
		</tr>
		<tr>
			<td class="info" id="seatunavailableinfo"><p>
			<b>Seating Unavailable</b></p></td>
		</tr>
	</table>
    
    <!---table displaying key to seat prices---!> 
	<table class="center" align="center" id="priceinfo">
		<tr>
			<td class="info" colspan="2"><p><b>Ticket Prices</b></p>
			</td> <!---heading column spans two normal columns---!>
		</tr>
		<tr>
			<td class="info"><p>Rows A to C</p>
			<td class="info"><p>£10.00</p>
		</tr>
		<tr>
			<td class="info"><p>Rows D to F</p>
			<td class="info"><p>£12.50</p>
		</tr>
		<tr>
			<td class="info"><p>Rows G to K</p>
			<td class="info"><p>£7.25</p>
		</tr>
	</table>

	<!---buttons---!>
	<table class="center" align="center">
		<tr>
			<!---button returns user to previous page---!>
			<td class="button">
			<a href="dateselect.php"><img align="center" alt="backbutton"
			src="images/back.png"
			onmouseover="this.src='images/backMouseOver.png';"
			onmouseout="this.src='images/back.png';"
			</img><a>
			</td>
			<!---buttons resets all the selected seats by calling the resetAll function
			 - resets background colour and unchecks all boxes---!>
			<td class="button">
			<a><img align="center" alt="resetbutton"
			src="images/resetseats.png"
			onmouseover="this.src='images/resetseatsMouseOver.png';"
			onmouseout="this.src='images/resetseats.png';"
			onclick="resetAll()"
			</img><a>
			</td>
			<!---buttons confirms seat choice and passes the 
			information to the next page---!>
			<td class="button">
			<a><img align="center" alt="confirmbutton"
			src="images/submit.png"
			onmouseover="this.src='images/submitMouseOver.png';"
			onmouseout="this.src='images/submit.png';"
			onclick="submitcheckedboxes()"
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
<!--- nonbreaking space and regular space in code = 2 spaces either side of name ---!>
        &copy;&nbsp; Matt Dean &nbsp;2013
      </p>
    </div>
  </div>
</div>
<div id="header">
  <div id="header-inner">
    <div id="subheader2">
		<h1>Starshine Booking System</h1>
		<p> Please Select Seat(s) </p>
  </div>
</div>
</body>
</html>
