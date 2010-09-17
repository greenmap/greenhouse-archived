<?php 
global $base_url;
global $i18n_langpath; ?>

<?php
if ($_GET[theme] == 'simple') { include('page-simple.tpl.php');
return;
}
//Instantiate the object to do our testing with.
$uagent_obj = new uagent_info();
$isIphoneTier = $uagent_obj->DetectTierIphone();
$isCssTier = $uagent_obj->DetectTierRichCss();
$isOtherTier = $uagent_obj->DetectTierOtherPhones();
?>


<?php
	$color = 'blue'; //set to blue, black, green, orange, purple, or red
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--page.tpl.php-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>

<?php

//Print the variable part of the URL to the HTML source

if ($isIphoneTier == 1) {

echo '<meta name="viewport" content="width = 320" />';
echo '<meta name="viewport" content="initial-scale=2.3, user-scalable=yes" />';
echo '<style type="text/css">
#container, #rightside, #leftside, #footer_gh, .tabs, .postinfo {
display:none;
} 

body {
background: #ffffff !important;
width:320px !important;
max-width:320px !important;
min-width:320px !important;
}

.links {
font-size:150%;
text-align:left;
width:320px;
margin-top:30px;
}

#content {
width:300px !important;
max-width:320px !important;
min-width:320px !important;
padding-top:0px !important;
margin-left:0px !important;
float:none !important;
} 

#wrap {
width:320px !important;
max-width:320px !important;
min-width:320px !important;
background:none !important;
margin:0px !important;
}

#content h1 {
width:320px;
text-align: center;
line-height:25px;
}
</style>';

}

if ($isCssTier == 1) {

echo '<meta name="viewport" content="width = 320" />';
echo '<meta name="viewport" content="initial-scale=2.3, user-scalable=yes" />';
echo '<style type="text/css">
#container, #rightside, #leftside, #footer_gh, .tabs, .postinfo {
display:none;
} 

body {
background: #ffffff !important;
width:320px !important;
max-width:320px !important;
min-width:320px !important;
}

.links {
font-size:150%;
text-align:left;
width:320px;
margin-top:30px;
}

#content {
width:300px !important;
max-width:320px !important;
min-width:320px !important;
padding-top:0px !important;
margin-left:0px !important;
float:none !important;
} 

#wrap {
width:320px !important;
max-width:320px !important;
min-width:320px !important;
background:none !important;
margin:0px !important;
}

#content h1 {
width:320px;
text-align: center;
line-height:25px;
}
</style>';

}

if ($isOtherTier == 1) {

echo '<meta name="viewport" content="width = 320" />';
echo '<meta name="viewport" content="initial-scale=2.3, user-scalable=yes" />';
echo '<style type="text/css">
#container, #rightside, #leftside, #footer_gh, .tabs, .postinfo {
display:none;
} 

body {
background: #ffffff !important;
width:320px !important;
max-width:320px !important;
min-width:320px !important;
}

.links {
font-size:150%;
text-align:left;
width:320px;
margin-top:30px;
}

#content {
width:300px !important;
max-width:320px !important;
min-width:320px !important;
padding-top:0px !important;
margin-left:0px !important;
float:none !important;
} 

#wrap {
width:320px !important;
max-width:320px !important;
min-width:320px !important;
background:none !important;
margin:0px !important;
}

#content h1 {
width:320px;
text-align: center;
line-height:25px;
}
</style>';

}


?>

  <title><?php print $head_title ?></title>
  <?php print $head ?>
  	<!--[if IE 6]>
<style type="text/css">
#content { margin: -380px; margin-top: 0px; margin-right: 0; margin-left: 50px; left: 130px;}
body {min-width:1000px !important;}
#rightside { width: 165px; }
#sitename {margin-top: 0px !important;}
</style>
<![endif]-->

<!--[if IE 7]>
<style type="text/css">
#mainmenu {margin-top:25px !important;}
#mainmenu .submenu-header .submenu-header ul {
margin-left: 0px !important;
}
#mainmenu #submenu-169 .submenu-header ul {
margin-left: 0px !important;

}
</style>
<![endif]-->

<!--[if IE 8]>
<style type="text/css">
#mainmenu #submenu-169 .submenu-header ul {
float:left;
margin-left: -40px;
}
#mainmenu .submenu-header .submenu-header ul {
left: 100px !important;
top: -23px !important;
}
<![endif]-->
  <?php print $styles ?>
  <style type="text/css" media="all">@import "<?php print $base_url . '/' . $directory . '/colorcss/' . $color ?>.css";</style>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Original design by Andreas Viklund - http://andreasviklund.com / Ported by Matt Koglin - http://antinomia.comn / restyled by Thomas Turnbull - http://wwww.thomasturnbull.com , T� Baybute - http://tebaybute.net , and Akiko Rokube http://rokube.com / for http://www.greenmap.org" />

</head>

<body>
<div id="preloader">
	<img src="img/menu_shadow_up_4.png">
	<img src="img/menu_shadow_down_4.png">
	</div>
	
	<div id="container">
	
		<div id="preheader"><?php // top bar containing language links and search box ?>
		<div id="ogmlink">
<a href="http://www.opengreenmap.org/home" title="<?php print t('Go to Open Green Map') ?>">
<img src="<?php print $base_path ?>images/ogmlink3.png" width="180px" alt="<?php print t('Open Green Map link') ?>" /></a>
		</div>
		<div id="toplogo">
<a href="<?php print $base_path ?>home" title="<?php print t('Home') ?>">
<img src="<?php print $base_path ?>images/toplogo.png" width="160px" alt="<?php print t('Green Map Home') ?>" /></a>
		</div>
			<div id="languagelinks">
				<?php print $languagebar; ?>
			</div>
			
			<div id="searchbox">
				<?php // print $search_box; ?>
			</div>
			
		</div>
		
		<div id="sitename">
			<div id="sitelogo">
				<img src="<?php print $base_path ?>images/greenmap_logo.gif" width="30" height="54" alt="<?php print t('Home') ?>" /></a>
			</div>
			

			<div id="mainmenu">
			
	<ul>
   <?php print greenmapnew_menu_bar(169,2) ?>
   </ul>
			</div>
		</div>

		</div>
				
			</div>

		<div id="wrap">

		<div id="leftside">
				<?php if ($sidebar_left) {
	      print $sidebar_left;
		    } ?>
			</div>
			
				<div id="rightside">
			
				
				<?php if ($sidebar_right) {
				print $sidebar_right;
				} ?>
				</div>


			<div id="content">
				<?php
				if (!$frontpage) {
				  print $breadcrumb;
				}
				?>
				<?php // print $breadcrumb ?>
				<?php if ($title) { ?><h1><?php print $title ?></h1><?php } ?>
				<div class="tabs"><?php print $tabs ?></div>
				<?php print $help ?>
				<?php print $messages ?>
				<?php print $content; ?>
			
<div id="footer_gh">
		<div id="bottomleft">&nbsp;</div>
		<div id="bottomright">&nbsp;</div>
		<?php print $footerlinks; ?>
		&nbsp;
	</div>
		</div>
</div>		


	

	
	<?php print $closure ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-418876-2");
pageTracker._trackPageview();
} catch(err) {}</script> 
</body>
</html>
<!--/page.tpl.php-->
