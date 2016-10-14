<?php
	// header("X-Frame-Options: SAMEORIGIN");
	$dates=gmdate("D, d M Y H:i:s", time()+3600) . " GMT";
	header("Expires: " . $dates);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?php echo $Title; ?> - Laika.pro</title>
	<?php include $Favicon; ?>
	
	<!-- <meta name="yandex-verification" content="7977f67a872b193c" /> -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
	<meta name="description" content="<?php echo $Description; ?>">
	<meta property="og:description" content="<?php echo $Description; ?>">
	<meta property="og:image" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$OgImage; ?>">
	<meta property="og:site_name" content="Laika.Pro">
	<meta property="og:title" content="<?php echo $Title; ?> - Laika.pro">
	<meta property="og:type" content="<?php echo $OgType; ?>">
	<meta property="og:url" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]; ?>">
	<meta itemprop="image" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$OgImage; ?>">
	<meta name="twitter:card" content="summary">
	<!-- <meta name="twitter:site" content="@russiantravelguitar"> -->
	<!-- <meta name="twitter:title" content="<?php echo $Title; ?> - Laika.pro"> -->
	<!-- <meta name="twitter:description" content="<?php echo $Title; ?> - Laika.pro"> -->
	<!-- <meta name="twitter:creator" content="russiantravelguitar"> -->
	<!-- <meta name="twitter:image:src" content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$OgImage; ?>"> -->
	<!-- <meta name="twitter:domain" content="laika.pro"> -->
	
	
	<?php 
		echo "<style>";
		include "css/public/bootstrap.min.css";
		include "css/public/dest.css";
		echo "</style>";
	 ?>
</head>
<body>

	<div id="overlay">

	<?php include $Navigation; ?>

		<div id="content">
			<?php include $Content; ?>
		</div>

	</div>

	<footer>
		<?php include $Footer; ?>
	</footer>

<?php include $Modals; ?>

<?php 
	/*	echo "<style>";
		include "css/public/font-awesome.min.css";
		include "css/owl-carousel/owl.carousel.css";
		include "css/owl-carousel/owl.theme.css";
		include "css/owl-carousel/owl.transitions.css";
		echo "</style>";
	*/ ?>

<script src="/js/jquery.min.js"></script>

</body>
</html>