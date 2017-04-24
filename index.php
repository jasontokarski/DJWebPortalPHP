<!DOCTYPE HTML>
<html>

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
          <li class="selected"><a href="index.php">Singers</a></li>
          <li><a href="portal.php">DJ Portal</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
      <div id="content">
	  	<?php
		try{
				$username = 'z1805312';
				$password = '';
				$dsn = 'mysql:host=courses;dbname=z1805312';
				$pdo = new PDO($dsn, $username, $password);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e){
				echo "Couldnt not connect. Error: " . $e->getMessage();
		}
		?>
        <h2>Choose a Song</h2>
			<p>Enter an artist name, song title, or contributor to a song.</p>
				<form action="" method="post">
					<div class="form_settings">
						<p><span>Artist Name:</span><input class="contact" type="text" name="artist_name" value="" /></p>
						<p><span>Song Title:</span><input class="contact" type="text" name="song_title" value="" /></p>
						<p><span>Contributor:</span><textarea class="contact textarea" rows="8" cols="50" name="contributor"></textarea></p>
						<p><span>Contributor:</span>
						<select id="id" name="contributor">
							<option value="1">Example 1</option>
							<option value="2">Example 2</option></select></p>
						<p style="padding-top: 15px"><input class="submit" type="submit" name="search_song" value="Submit" /></p>
					</div>
				</form>
			<p><br /><br />NOTE: Only one field needs to be entered.</p>
      </div>
    </div>
    <div id="footer">
      <p><a href="index.php">Singers</a> | <a href="portal.php">DJ Portal</a></p>
      <p>CSCI466 Karaoke Group Project</p>
    </div>
    <p>&nbsp;</p>
  </div>
</body>
</html>
