 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Get Orders - 1</title>
  <link rel="shortcut icon" href="favicon.ico">
  <style type="text/css" media="screen">@import url("css/starshine.css");</style>
    <script>
    //function submits the form - to be called on button click
	function submitdets(){
	document.getElementById("dets").submit();
	}
	</script>
</head>
<body>
<div id="fullheightcontainer">
  <div id="wrapper">
    <div id="clearheadercenter"></div>
    <div id="container-center">

	<form  id="dets" action="getorders2.php" method="post">
	<!---two text inputs for customers' names---!> 
	Customer Forename: <input type="text" name="custname1" class="details" /><br /><br />
	Customer Surname: <input type="text" name="custname2" class="details" />
	<br /><br /><br />
     </form>
     
     <table class="center">
     	<tr>
			<td class="button">
			<!---button submits the form (customer names)---!>
			<a><img align="center" alt="submitbutton"
			src="images/submit.png"
			onmouseover="this.src='images/submitMouseOver.png';"
			onmouseout="this.src='images/submit.png';"
			onclick="submitdets();"
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
      <p> Get Orders from Customer - 1</p>
  </div>
</div>
</body>
</html>