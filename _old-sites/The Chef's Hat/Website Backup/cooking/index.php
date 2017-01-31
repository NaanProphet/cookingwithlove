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
	<title>The Chef's Hat</title>

	<meta content="keyword1,keyword2,keyword3" name="keywords" />
	<meta content="Description of your site" name="description" />

<?php
	function randomRecipeImage($kind)
	{
		$filename = "./active/" . $kind . ".txt"; // path to txt file containing list of dishes

		$fp = @fopen($filename, 'r'); 
		if ($fp) { 
		 $theList = explode("\n", fread($fp, filesize($filename)));
		}

		// Next, determine the number of recipes in this specific category
		$numKindRecipes = sizeof($theList)/2;
		// Now take a random number in between 1 and number of recipes
		$randomRecipe = rand(1, $numKindRecipes);
		// Now find the respective index
		$indexRecipeShort = 2*($randomRecipe - 1);
		// Retreive folder name based on index
		$nameRandRecipeShort = $theList[$indexRecipeShort];

		// So now we have the folder name;
		// therefore path to pic from root of website is
		$picName = "$nameRandRecipeShort.jpg";
		$picFolder = "./recipes/$nameRandRecipeShort/";
		$picFullPath = $picFolder . $picName;

		// Return this name
		return ($picFullPath);
	}
?>	

</head>

<body>

<div id="topbar">
	<div id="title">Welcome to the Chef's Hat!</div>
</div>

<div id="content">
	<div style="text-align:center"><img src="icon_palace.gif"></div>
	<span class="graytitle">Categories</span>
	<ul class="pageitem">
		<!--
		<li class="textbox">
			<p class="graytitle">Your text</p><p>another paragraph</p>
		</li>
		<li class="textbox">
			<span class="header">A title</span> <p>Your text</p><p>another paragraph</p>
		</li>
		-->
		<li class="menu"> 
			<a href="./generateRecipeMenu.php?kind=pappu">
<?php	
	$imgPath = randomRecipeImage("pappu");
	echo "\t\t\t<img alt=\"Description\" src=\"$imgPath\" />";
			//<img alt="Description" src="thumbs/basics.png" />
?>
			<span class="name">Pappu/Dal/Lentil</span>
			<span class="comment">Comment</span>
			<span class="arrow"></span>
			</a>
		</li>
		<li class="menu"> 
			<a href="./generateRecipeMenu.php?kind=koora">
<?php	
	$imgPath = randomRecipeImage("koora");
	echo "\t\t\t<img alt=\"Description\" src=\"$imgPath\" />";
			//<img alt="Description" src="thumbs/basics.png" />
?>
			<span class="name">Koora/Curry</span>
			<span class="comment">Comment</span>
			<span class="arrow"></span>
			</a>
		</li>
		<li class="menu"> 
			<a href="./generateRecipeMenu.php?kind=pulusu">
<?php	
	$imgPath = randomRecipeImage("pulusu");
	echo "\t\t\t<img alt=\"Description\" src=\"$imgPath\" />";
			//<img alt="Description" src="thumbs/basics.png" />
?>
			<span class="name">Pulusu</span>
			<span class="comment">Comment</span>
			<span class="arrow"></span>
			</a>
		</li>
		<li class="menu"> 
			<a href="./generateRecipeMenu.php?kind=pacchadi">
<?php	
	$imgPath = randomRecipeImage("pacchadi");
	echo "\t\t\t<img alt=\"Description\" src=\"$imgPath\" />";
			//<img alt="Description" src="thumbs/basics.png" />
?>
			<span class="name">Pacchadi/Chutney</span>
			<span class="comment">Comment</span>
			<span class="arrow"></span>
			</a>
		</li>
		<li class="menu"> 
			<a href="./generateRecipeMenu.php?kind=ppacchadi">
<?php	
	$imgPath = randomRecipeImage("ppacchadi");
	echo "\t\t\t<img alt=\"Description\" src=\"$imgPath\" />";
			//<img alt="Description" src="thumbs/basics.png" />
?>
			<span class="name">Perugu Pacchadi</span>
			<span class="comment">Comment</span>
			<span class="arrow"></span>
			</a>
		</li>
		<li class="menu"> 
			<a href="./generateRecipeMenu.php?kind=tiffin">
<?php	
	$imgPath = randomRecipeImage("tiffin");
	echo "\t\t\t<img alt=\"Description\" src=\"$imgPath\" />";
			//<img alt="Description" src="thumbs/basics.png" />
?>
			<span class="name">Tiffin</span>
			<span class="comment">Comment</span>
			<span class="arrow"></span>
			</a>
		</li>
		<li class="menu"> 
			<a href="./generateRecipeMenu.php?kind=essentials">
<?php	
	$imgPath = randomRecipeImage("essentials");
	echo "\t\t\t<img alt=\"Description\" src=\"$imgPath\" />";
			//<img alt="Description" src="thumbs/basics.png" />
?>
			<span class="name">Essentials</span>
			<span class="comment">Perugu, roti...</span>
			<span class="arrow"></span>
			</a>
		</li>
		<li class="menu"> 
			<a href="./generateRecipeMenu.php?kind=specials">
<?php	
	$imgPath = randomRecipeImage("specials");
	echo "\t\t\t<img alt=\"Description\" src=\"$imgPath\" />";
			//<img alt="Description" src="thumbs/basics.png" />
?>
			<span class="name">Specials</span>
			<span class="comment">Comment</span>
			<span class="arrow"></span>
			</a>
		</li>
	</ul>
</div>

<div id="footer">
	Powered by iWebKit
</div>
</body>

</html>
