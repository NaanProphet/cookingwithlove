<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
<link rel="apple-touch-icon" href="icon.png"/>

<link href="styles/css/style.css" rel="stylesheet" type="text/css" />
<script src="styles/javascript/functions.js" type="text/javascript"></script>

<?php
# Many thanks to: http://www.programmersheaven.com/mb/phpstuff/306021/306021/html-hyperlink-pass-variable-to-php/
$kind = $_GET['kind'];
echo "<title>$kind</title>";
?>




</head>

<body>

<div id="topbar">
	<div id="leftnav">
		<a href="index.php"><img alt="home" src="styles/images/home.png"/></a>
	</div>
</div>

<div id="content">
	<div><img src="icon_palace.gif"></div>
	<br/>
	<span class="graytitle">Dishes</span>
	<ul class="pageitem">
<?php

	function checkIfOdd($num){
		  return ($num%2) ? TRUE : FALSE;
	}
	
	
	function loadActiveRecipes($kind)
	{
		$filename = "./active/" . $kind . ".txt"; // path to txt file containing list of dishes
		
		$fp = @fopen($filename, 'r'); 
		if ($fp) { 
		 $theList = explode("\n", fread($fp, filesize($filename)));
		}
		
		
		for ($i = 0; $i < sizeof($theList); $i++) {
			
			// even values of array are for recipe directory name, by convention
			if ( checkifOdd($i) == FALSE ){
				// e.g. includes zero
				echo "\t<li class=\"menu\">\n\t";
				echo "<a href=\"./generateRecipe.php?title=" . $theList[$i] . "\">\n\t";
				// no need to resize the image -- YAY!
				echo "<img alt=\"" . $theList[$i] . "\" src=\"./recipes/" . $theList[$i] . "/" . $theList[$i] . ".jpg\" />";
			}
			
			// odd values of array are for formatted recipe name, by convention
			else if ( checkifOdd($i-$sentinelIndex) == TRUE ){
				echo "<span class=\"name\">" . $theList[$i] . "</span>\n\t";
				echo "</a>\n\t</li>\n";
			}
		}
	}

	loadActiveRecipes($kind);
?>
		
	</ul>
</div>

<div id="footer">
	Powered by iWebKit
</div>
</body>

</html>