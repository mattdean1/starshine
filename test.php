<?php
//use the try catch routine for error handling
//test db connection - data retrieval
try {
// connect to the database using the new more secure PDO method
    $conn = new PDO('mysql:host=localhost;dbname=starshine-deanmatt', 'test', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
// fetch the data
    $query="SELECT shows_name, shows_date FROM tbl_shows 
    WHERE shows_date >= CURDATE() ORDER BY shows_date ASC LIMIT 4";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $arrayshows = $stmt->fetchAll();
   // $arrayshows=$row['customer_surname'];
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>TEST</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">

	<form action="dateselect.php" method="post">
		
     </form>
     
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
      <p> Please Select Show </p>
  </div>
</div>
</body>
</html>
