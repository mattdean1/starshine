<?php
//use the try catch routine for error handling
//test db connection - data retrieval
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// fetch the data
	// query selects the first 4 show names and dates, sorted by date,
	//where the date of the show is later than today(current date)
    $query="SELECT shows_name, shows_date FROM tbl_shows
    WHERE shows_date >= CURDATE() ORDER BY shows_date ASC LIMIT 4";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    //fetchAll gets the results as an array
    $arrayshows = $stmt->fetchAll();
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
	<!-- define document type e.g. html version etc.
	for compatibility mainly with Internet Explorer -->
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <!--- define html variant to tell browser how to display content --->
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <!---title of the tab-->
  <title>Select Show</title>
  <!---favicon of the tab-->
  <link rel="shortcut icon" href="favicon.ico">
  <!---specifies style sheet to be used-->
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">

	<form action="dateselect.php" method="post">
	 <!---passes information to the next page when submitted-->
    <table class="center" align="center" id="shows">
		<tr>
			<?php
			for ($i = 0; $i < 4; $i++): //repeats 4 times
			?>
				<!---displays a cell with the show name inside-->
      			<td class="default">
      				<!---gets and displays value from array for this iteration-->
  					<input class="shows" type="submit" name="submit"
  					value="<?php echo $arrayshows[$i]['shows_name']?>">
				</td>
			<?php
			endfor;
			?>
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
        &copy;&nbsp; Matt Dean &nbsp;2013 <!---copyright information-->
      </p>
    </div>
  </div>
</div>
<div id="header">
  <div id="header-inner">
    <div id="subheader2">
    <!---headings at the top of the page-->
      <h1>Starshine Booking System</h1>
      <p> Please Select Show </p>
  </div>
</div>
</body>
</html>
