<?php
	require_once('config.php');
	
	$output = "";
	$tooltip = "";
	$cssfile = "bega.css";
	$soundfile = "trumpet.ogg";
	$pagetitle = "Lou Bega Names Your Baby";
	$override = false;
	
	$db = mysqli_connect($config_mysqlHost, $config_mysqlUser, $config_mysqlPassword, $config_mysqlDatabase);
	if (mysqli_connect_errno()) $output = "Oops I'm broken";
	else
	{
		if (session_start())
		{
			if (!isset($_SESSION['visitcount']))
			{
				$_SESSION['visitcount'] = 1;
			}
			else
			{
				$_SESSION['visitcount']++;
				if ($_SESSION['visitcount'] == 9)
				{
					if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ipaddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
					else $ipaddr = $_SERVER['REMOTE_ADDR'];
					$ipaddr = mysqli_real_escape_string($db, $ipaddr);
					
					$q = mysqli_query($db, "select * from overrides where ipaddr = '" . $ipaddr . "'");
					if (mysqli_num_rows($q) < 1)
					{
						$override = true;
						mysqli_query($db, "insert into overrides (ipaddr) values ('" . $ipaddr . "')");
					}
				}
			}
		}
		
		$q = mysqli_query($db, "select * from babynames order by rand() limit 1");
		$row = mysqli_fetch_assoc($q);
		$output = $row['name'];
		$tooltip = $row['meaning'];
		if ($override) $output = "DRACUL";
		
		if ($output == "DRACUL")
		{
			$cssfile = "heck.css";
			$soundfile = "eviltrumpet.ogg";
			$pagetitle = "Lou Bega Consumes Your Life Essence";
			$tooltip = "";
		}
	}
?>
<html>
<head>
<title><?php echo $pagetitle; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $cssfile; ?>" />
<link rel="stylesheet" type="text/css" href="external/tooltip/tooltip.css" />
<script type="text/javascript" src="external/jquery/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="external/animateText.js/animateText.min.js"></script>
<script type="text/javascript" src="external/tooltip/tooltip.js"></script>
</head>
<body>
<div id="begabox">
	<div id="namecontainer"<?php if ($tooltip != "") echo ' rel="tooltip" title="'.$tooltip.'"'; ?>><ul id="babyname"><li><?php echo $output; ?></li></ul></div>
	<div id="star"></div>
</div>
<div id="footer">by <a href="http://twitter.com/brehonia">@brehonia</a><br />for <a href="http://www.stoppodcastingyourself.com">SPY</a><br /><br />using data from <a href="http://introcs.cs.princeton.edu/java/data/">Princeton</a></div>
<script type="text/javascript">
		var noise = new Audio('<?php echo $soundfile; ?>');
		noise.play();
		$("#babyname").animateText([{
			offset: 0,
			duration: 1000,
			animation: "rightToLeftStay"
		}],
		{ repeat: 0 },
		{
			"rightToLeftStay": {
				positions: {
					start: {
						width: '100%',
						left: '100%',
						opacity: 0,
						'text-align': 'center'
					},
					0: {
						left: '0%',
						opacity: 1,
						duration: 1200
					}
				}
			}
		});
</script>
</body>
</html>
