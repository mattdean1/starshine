<?php
//use the try catch routine for error handling
//test db connection - data retrieval
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
	//query selects show names and dates ordered by date
	//show date is not displayed on this page but is used 
	//to put shows in chronological order in the dropdown menu
    $query="SELECT shows_name, shows_date FROM tbl_shows ORDER BY shows_date ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetchAll();
   	$count = count($row);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Total Income - Show</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
    <script>
    //function submits form when called on button click
	function submitshow(){
	document.getElementById("shows").submit();
	}
	</script>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">

	<form  id="shows" action="totalincome2.php" method="post">
		<!---dropdown containing all show names---!>
		Select Show: <select name="show">
			<?php
				//loop through the total number of shows
				for($i = 0; $i < $count; $i++):
				//set variable to the show value in the array for this iteration of [i] 
					$shows = $row[$i][0]; 
					//insert dropdown value for this iteration
					echo "<option value='$shows'>$shows</option>"; 
				endfor;
			?>
  		</select>
     </form>
   <br />
     <table class="center">
     	<tr>
			<td class="button">
			<!---button submits the show choice by calling the submitshow function---!>
			<a><img align="center" alt="submitbutton"
			src="images/submit.png"
			onmouseover="this.src='images/submitMouseOver.png';"
			onmouseout="this.src='images/submit.png';"
			onclick="submitshow();"
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
      <p> Select Show </p>
  </div>
</div>
</body>
</html>