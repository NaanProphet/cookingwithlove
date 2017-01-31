<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
<link rel="apple-touch-icon" href="icon.png"/>

<?php
# Many thanks to: http://www.programmersheaven.com/mb/phpstuff/306021/306021/html-hyperlink-pass-variable-to-php/
$title = $_GET['title'];
echo "<title>$title</title>";

function checkIfOdd($num){
	  return ($num%2) ? TRUE : FALSE;
}

function getFullRecipeName($title){
	$filename = "recipes/" . $title . "/" . $title . "-intro.txt"; // path to intro txt file
	
	$fp = @fopen($filename, 'r'); 
	if ($fp) { 
	 $theList = explode("\n", fread($fp, filesize($filename)));
	}
	
	// Recipe name is the first entry by convention
	return $theList[0];
}

function echoFormatListTags($title, $section, $tag, $highlightGlossary)
{
  	$filename = "recipes/" . $title . "/" . $title . "-" . $section . ".txt"; // path to txt file

	$fp = @fopen($filename, 'r'); 
	if ($fp) { 
	 $theList = explode("\n", fread($fp, filesize($filename)));
	}

	
	$sentinel = 0;
	for ($i = 0; $i < sizeof($theList); $i++) {
		
		if ( $section === "intro" ){
			
			// check if preptime info is reached
			if ( $sentinel == 0 ){
				// nested if, so that once sentinel is reached, will not go back to zero!
				if ( $theList[$i] === "From:"){
					$sentinel = 1;
					$sentinelIndex = $i;

					// if it is, then start the <dd> tag
					echo "\n \n"; // for readibility
					// added other tags for iPhone
					echo "\t<ul class=\"pageitem\"><li class=\"textbox\"<dd>" . "\n";
				}
			}

			// if in title and blockquote area
			if ( $sentinel == 0 ){

				// process first two lines only, regardless of space before
				if ( $i == 0){
					// formatted for iWebkit
					// $listFormatting = "<h2>" . $theList[$i] . "</h2>" . "\n";
					
					// add img tag first
					// class tag so that navigation images don't get doinked up
					$listFormatting = "<ul class=\"pageitem\"><li class=\"textbox\"><div style=\"text-align:center\"><img class=\"recipe\" src=" . "recipes/" . $title . "/" . $title . ".jpg /></div>" . "\n\t";

				}
				else if ( $i == 1){
					// add blockquote second
					$listFormatting = "<blockquote>" . $theList[$i] . "</blockquote></li></ul>" . "\n";

				}
				
			}
			
			// if in preptime info
			else if ( $sentinel == 1 ){

				// even values of array are for the bold case dictionary term tags
				if ( checkifOdd($i-$sentinelIndex) == FALSE ){
					$listFormatting = "\t<dt>" . $theList[$i] . " &nbsp;</dt>" . "\n";
				}

				// odd values of array are for the dictionary definition tags 
				else if ( checkifOdd($i-$sentinelIndex) == TRUE ){
					$listFormatting = "\t<dd>" . $theList[$i] . "</dd>" . "\n";
				}
			}
			
			
			// finally, echo the chosen string!
			
			// following if is necessary so that blockquote doesn't echo twice, during newline b/w sections
			if ( $sentinel == 0 && $i > 1){
				 // don't print anything
			}
			else{
				echo $listFormatting;
			}
						
			//close dd tag if at the last line
			if ( $i == sizeof($theList)-1 ){
				echo "\t</dd></li></ul>" . "\n";
			}
		}

		// if either section is "ingredients" or "directions"
		else {
			
			
			if ( $section === "ingredients" ){
				
				// formatting tag modified for iWebkit
				$listFormatting = "<$tag class=\"menu\"><span class=\"arrow\"></span><span class=\"name\">" . $theList[$i] . "</span></$tag>" . "\n\t";

				// import ingredients as an array, e.g. $words = array('Beet root', 'coconut');
				// Many thanks to: http://www.webmasterworld.com/forum88/938.htm
				$filename2 = $highlightGlossary; // ingredients list, seperated by newline
				$fp2 = @fopen($filename2, 'r'); 
				if ($fp2) { 
				 $ingredients = explode("\n", fread($fp2, filesize($filename2)));

				}

				echo highlightWords($listFormatting, $ingredients); //highlightWords already has echo built-in
			}

			else if ( $section === "directions" ){
				// formatting tag modified for iWebkit
				$listFormatting = "\t\t\t<$tag class=\"textbox\">" . $theList[$i] . "</$tag>" . "\n";
				echo $listFormatting;
			}
		}
				
	}
}


?>

<style type="text/css">

<?php
	// IMPORT THE CORRECT CSS FILE
	
	if (stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone')) {
		# if displaying on iPhone
		$iPhoneYes = TRUE;
		echo "@import url(\"styles/css/uncompressed_style.css\");";
		echo "@import url(\"styles/css/recipes_layout_iphone.css\");";
	}
	else {
		# if not displaying on iPhone
		echo "@import url(\"styles/css/recipes_layout.css\");";
	}
?>

</style>

</head>

<?php

// Many thanks to: http://www.whypad.com/posts/php-proper-case-function/201/
// http://www.hotscripts.com/forums/perl/27670-how-replace-space-_-need-help.html
// and: http://www.phpbuilder.com/board/archive/index.php/t-10260291.html

function highlightWords($string, $words)
{
   foreach ( $words as $word )
   {
		$escapeWord = str_replace(" ", "_", $word); // for words like "beet root", etc.
		$escapeProper = ucfirst($escapeWord); // so that there is consistency in the links, all capitalized
		$properName = ucfirst($word);
      	$string = preg_replace("/($word)/i", "<a href=./ingredients/$escapeProper.html>$properName</a>", $string);
   }
   /*** return the highlighted string ***/
   return $string;
}

?>

<body>

<div id="topbar">
	<?php
	$recipeName = getFullRecipeName($title);
	echo "<div id=\"title\">$recipeName</div>";
	?>

</div>

<div id="content">
	
	<?php
	echoFormatListTags($title, "intro", "", "");
	?>
	
	<!--Ingredients:-->
	<div class="graytitle">Ingredients:</div>
	<ul class="pageitem">

	<?php

	echoFormatListTags($title, "ingredients", "li", "ingredients.txt");

	?>	

	</ul>
	

	<!--Directions:-->
	<span class="graytitle">Directions:</span>
	<ul class="pageitem">
		<li class="textbox">
			<dl> <!-- so as to remove the indent from the "second" list; looks good on iPhone-->
<?php

			echoFormatListTags($title, "directions", "li", "");

?>
			</dl>
		</li>

	</ul>

</div>

	
<?php

/* Not using extros for the moment

# Many thanks to: http://www.webmasterworld.com/php/3535326.htm
$file = "recipes/" . $title . "/" . $title . "-extro.txt";
$handle = fopen($file, "r");
$input = fread($handle, filesize($file));
fclose($handle);
*/


echo "<div id=\"footer\">\n\t";
	# Give credit to iWebkit, if displaying on iPhone
	if ($iPhoneYes){
		#echo "<a class=\"noeffect\" href=\"http://iwebkit.net\">Powered by iWebKit</a>\n";
		echo "Powered by iWebKit\n";
	}
echo "</div>";
?>

</body>
</html>