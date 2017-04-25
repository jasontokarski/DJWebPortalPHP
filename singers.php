<!DOCTYPE HTML>
<html>
<?php include("dbvar.php"); ?>

<head>
	<title>CSCI 466</title>
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
	<div id="main">
		<div id="header">
			<div id="logo">
				<div id="logo_text">
					<h1><a href="index.php">Karaoke<span class="logo_colour">Sign-Up<span></a></h1>
					<h2>Choose a song by artist, title, or contributor!</h2>
				</div>
			</div>
			<div id="menubar">
				<ul id="menu">
					<li><a href="index.php">Sign-Up</a></li>
					<li class="selected"><a href="singers.php">Singers</a></li>
					<li><a href="portal.php">DJ Portal</a></li>
				</ul>
			</div>
		</div>
	<div id="site_content">
		<div id="content">
			<h2>Choose a Song</h2>
				<p>Enter an artist name, song title, or contributor to a song.</p>
					<div class="form_settings">
						<form action="" method="post">
								<p><span>Artist Name:</span><input class="contact" type="text" name="artist_name" value="" /></p>
								<p><input class="submit" type="submit" name="search_song" value="Submit" /></p>
						</form>
						<form action="" method="post">
							<p><span>Song Title:</span><input class="contact" type="text" name="song_title" value="" /></p>
							<p><input class="submit" type="submit" name="search_song" value="Submit" /></p>
						</form>
						<form action="" method="post">
							<p><span>Contributor:</span><input class="contact" type="text" name="song_title" value="" /></p>
							<p><input class="submit" type="submit" name="search_song" value="Submit" /></p>
						</form>
					</div>
			<p><br />NOTE: Only one field needs to be entered.</p>
		</div>
    </div>
    <div id="footer">
		<p><a href="index.php">Sign-Up</a> | <a href="singers.php">Singers</a> | <a href="portal.php">DJ Portal</a></p>
		<p>CSCI466 Karaoke Group Project</p>
	</div>
	<p>&nbsp;</p>
	</div>
</body>
</html>
