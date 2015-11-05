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
//find seatrows
	$query2="SELECT * FROM tbl_theatre";
    $stmt2 = $conn->prepare($query2);
    $stmt2->execute();
    $row2 = $stmt2->fetch();
    $seatrows=$row2['theatre_seatrows'];
//find seatcolumns
$query3="SELECT * FROM tbl_theatre";
    $stmt3 = $conn->prepare($query3);
    $stmt3->execute();
    $row3 = $stmt3->fetch();
    $seatcolumns=$row3['theatre_seatcolumns'];

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}


?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>SADS Booking System</title>
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">

    <table id="seats">
     <?php
     for ($j = 0; $j < $seatrows; $j++):
     ?>
		<tr class="seating">	
			<?php
			for ($i = 0; $i < $seatcolumns; $i++):
			?>
      			<td class="realseat" class="active">
    <?php
  		function toAlpha($data){
    		$alphabet =   array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    		$data=1;
         		return $alphabet[$data];
    	}
	?>
  	</td>
			<?php     	
			endfor;
			?>  
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
      <p>
        &copy; 2012 Matt Dean
      </p>
    </div>
  </div>
</div>
<div id="header">
  <div id="header-inner">
    <div id="subheader1"></div>
    <div class="ohb"><!-- Just a colored div --></div>
    <div id="subheader2">
      <h1>Starshine Booking System</h1>
    </div>
    <div class="ohb"><!-- Just a colored div --></div>
  </div>
</div>
</body>
</html>