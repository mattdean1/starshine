<?php
//retrieve show name from previous page
$showpost = $_POST['show'];
//use the try catch routine for error handling
//test db connection - data retrieval
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
	//query selects the production dates for the selected show
    $query="SELECT shows_date, shows_date2 FROM tbl_shows WHERE shows_name = '$showpost'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $date = $stmt->fetchAll();
    $date1 = $date[0]['shows_date'];
    $date2 = $date[0]['shows_date2'];
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Total Income - Date</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
    <script type="text/javascript"></script>
    <script>
    //function submits date form when called on button click
	function submitdate(){
	document.getElementById("dateform").submit();
	}
	</script>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">

	<form id="dateform" action="totalincome3.php" method="post">
    <table class="center" align="center">
		<tr>	
      			<td class="default" id="date">
      			<!---dropdown containing the dates for the selected show---!>
  					<select name="date">
					 <option value="<?php echo $date1 ?>"><?php echo $date1 ?></option>
					 <option value="<?php echo $date2 ?>"><?php echo $date2 ?></option>
  					</select>
				</td>
		</tr>
     </table>
     <!---hidden input so show name can be passed to next page---!>
     <input type="hidden" name="showname" value="<?php echo $showpost; ?>">
     </form>
    
<table class="center" align="center">
		<tr>
			<td class="button">
			<!---back button returns user to previous page---!>
			<a href="totalincome.php"><img align="center" alt="backbutton"
			src="images/back.png"
			onmouseover="this.src='images/backMouseOver.png';"
			onmouseout="this.src='images/back.png';"
			</img><a>
			</td>
			<td class="button">
			<!---submits the form and passes data to the next page -
			 calls the submit date function---!>
			<a><img align="center" alt="submitbutton"
			src="images/submit.png"
			onmouseover="this.src='images/submitMouseOver.png';"
			onmouseout="this.src='images/submit.png';"
			onclick="submitdate();"
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
		<p> Select Date </p>
  </div>
</div>
</body>
</html>
