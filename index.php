<html>
<head>
<title>Lou Bega Names Your Baby</title>
<link rel="stylesheet" type="text/css" href="bega.css" />
<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="animateText.js"></script>
</head>
<body>
<div id="begabox">
	<div id="namecontainer"><ul id="babyname"><li><?php
		require_once('config.php');
		$db = mysqli_connect($config_mysqlHost, $config_mysqlUser, $config_mysqlPassword, $config_mysqlDatabase);
		if (mysqli_connect_errno()) echo "Oops I'm broken";
		else
		{
			$q = mysqli_query($db, "select * from babynames order by rand() limit 1");
			$row = mysqli_fetch_assoc($q);
			echo $row['name'];
		}
	?></li></ul></div>
	<div id="star"></div>
</div>
<div id="footer">by <a href="http://twitter.com/brehonia">@brehonia</a><br />for <a href="http://www.stoppodcastingyourself.com">SPY</a><br /><br />using data from <a href="http://introcs.cs.princeton.edu/java/data/">Princeton</a></div>
<script type="text/javascript">
		var noise = new Audio('trumpet.ogg');
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