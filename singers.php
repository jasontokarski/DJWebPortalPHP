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
			<div class="right">
				<?php
				if(isset($_POST['search_name']))
				{
					$artistName = $_POST['artist_name'];

					$sql2 = "SELECT singer_name FROM singer WHERE singer_name LIKE '%" . $artistName ."%'";
					$query2 = $pdo->query($sql2);
					
					while ($rows = $query2->fetch())
					{
						echo "<br />" . $rows['0'] . " Was found! <br />";
					}

					if($query2->rowCount() < 1)
					{
						echo '<div class="p2">' . "Singer not found!" . "</div>";
					}
				}
				?>
			</div>
			<div class="right">
				<?php
				if(isset($_POST['search_song']))
				{
					$songTitle = $_POST['song_title'];

					$sql2 = "SELECT song_title FROM song WHERE song_title LIKE '%" . $songTitle ."%'";
					$query2 = $pdo->query($sql2);
					
					while ($rows = $query2->fetch())
					{
						echo "<br />" . $rows['0'] . " Was found! <br />";
					}

					if($query2->rowCount() < 1)
					{
						echo '<div class="p2">' . "Song not found!" . "</div>";
					}
				}
				?>
			</div>
			<div class="right">
				<?php
				if(isset($_POST['search_cont']))
				{
					$contributor = $_POST['contribution'];

					$sql2 = "SELECT contributor_name FROM contributor WHERE contributor_name LIKE '%" . $contributor ."%'";
					$query2 = $pdo->query($sql2);
					
					while ($rows = $query2->fetch())
					{
						echo "<br />" . $rows['0'] . " Was found! <br />";
					}

					if($query2->rowCount() < 1)
					{
						echo '<div class="p2">' . "Singer not found!" . "</div>";
					}
				}
				?>
			</div>
			<h2>Choose a Song</h2>
				<p>Enter an artist name, song title, or contributor to a song.</p>
					<div class="form_settings">
						<form action="singers.php" method="post" name="singer_name">
								<p><span>Artist Name:</span><input class="contact" type="text" name="artist_name" value="" /></p>
								<p><input class="submit" type="submit" name="search_name" value="Submit" /></p>
						</form>
						<form action="singers.php" method="post" name="song_title">
							<p><span>Song Title:</span><input class="contact" type="text" name="song_title" value="" /></p>
							<p><input class="submit" type="submit" name="search_song" value="Submit" /></p>
						</form>
						<form action="singers.php" method="post" name="contributor">
							<p><span>Contributor:</span><input class="contact" type="text" name="contribution" value="" /></p>
							<p><input class="submit" type="submit" name="search_cont" value="Submit" /></p>
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
