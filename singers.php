<!DOCTYPE HTML>
<html>
<?php include("dbvar.php"); ?>

<head>
	<title>CSCI 466</title>
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<?php
	$singerFound = 0;
	$notFound = 0;
	$file_id = 0;
	$searchResult = array();
	$singer_id = 0;
	if( array_key_exists( "singer_id", $_POST ) )
	{
		session_start();
		$singer_id = $_POST["singer_id"];
		$_SESSION['singer_id'] = $_POST['singer_id'];
	}
?>

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
				<?php
				if(isset($_POST['search_name']))
				{
					$artistName = $_POST['artist_name'];

					$sql2 = "SELECT song_id, artist_name FROM song WHERE artist_name LIKE '%" . $artistName ."%'";
					$query2 = $pdo->query($sql2);
					
					if($query2->rowCount() > 0)
					{
						array_push($searchResult, $query2->fetch());
						array_push($searchResult, $query2->fetch());
						$singerFound = 1;
					}
					else
					{
						$notFound = 1;
					}
					
					$sql2 = "SELECT file_id FROM karaoke_file WHERE song_id = '" . $searchResult[0][0] . "';";
					$query2 = $pdo->query($sql2);
					if($query2->rowCount() > 0)
					{
						$file_id = $query2->fetch();
					}
				}
				?>
			
				<?php
				if(isset($_POST['search_song']))
				{
					$songTitle = $_POST['song_title'];

					$sql2 = "SELECT song_title FROM song WHERE song_title LIKE '%" . $songTitle ."%'";
					$query2 = $pdo->query($sql2);

					if($query2->rowCount() > 0)
					{
						$searchResult = $query2->fetch();
						$singerFound = 1;
					}
					else
					{
						$notFound = 1;
					}
				}
				?>
			
				<?php
				if(isset($_POST['search_cont']))
				{
					$contributor = $_POST['contribution'];

					$sql2 = "SELECT contributor_name FROM contributor WHERE contributor_name LIKE '%" . $contributor ."%'";
					$query2 = $pdo->query($sql2);
					
					if($query2->rowCount() > 0)
					{
						$searchResult = $query2->fetch();
						$singerFound = 1;
					}
					else
					{
						$notFound = 1;
					}
				}
				?>
				
			<?php
			if(isset($_POST['add_free']))
			{
					date_default_timezone_set('America/Chicago');
					$date = date('m/d/Y h:i:s a', time());
					$sql2 = "INSERT INTO enqueue VALUES ('". $_POST['singer_id'] . "', '" .  $_POST['file_id'] . "', '" . $date . "', '" . 0 . "', '" . 1 . "');";
					//INSERT INTO enqueue VALUES ('1', '1', '1',  '0', '0');
					$query2 = $pdo->query($sql2);
					if($query2)
					{
						echo "Inserted Succesfully!";
					}
					else
					{
						echo "Error on insertion!";
					}
			}
			?>
			
			<?php
			if($singerFound == 1)
			{
				echo '<h2>' . $searchResult[0][1] . ' was found! </h2>';
				echo '<p>ID = ' . $file_id[0] . '</p>';
				echo '
					<div class="form_settings">
						<form action="singers.php" method="post" name="free_queue">
							<input type="hidden" name="singer_id" value="' . $singer_id . '" />
							<input type="hidden" name="file_id" value="' . $file_id[0] . '" />
							<p><input class="submit" type="submit" name="add_free" value="Free Queue" /></p>
						</form>
						<br />
						<form action="singers.php" method="post" name="acc_queue">
							<input type="hidden" name="singer_id" value="' . $singer_id . '" />
							<input type="hidden" name="file_id" value="' . $file_id[0] . '" />
							<p><span>Amount (USD):</span><input class="contact" type="text" name="acc_amount" value="" /></p>
							<p><input class="submit" type="submit" name="add_acc" value="Payed Queue" /></p>
						</form>
					</div>
				';
			}
			
			if($singerFound == 0)
			{
				if($notFound == 1)
				{
						echo '<div class="right"><h2><br /><br /><br /><br />' . "No results found!" . '</h2></div>';
				}
			echo '
			<h2>Choose a Song</h2>
				<p>Enter an artist name, song title, or contributor to a song.</p>
					<div class="form_settings">
						<form action="singers.php" method="post" name="singer_name">
							<p><span>Artist Name:</span><input class="contact" type="text" name="artist_name" value="" /></p>
							<input type="hidden" name="singer_id" value="' . $singer_id . '" />
							<p><input class="submit" type="submit" name="search_name" value="Submit" /></p>
						</form>
						<form action="singers.php" method="post" name="song_title">
							<p><span>Song Title:</span><input class="contact" type="text" name="song_title" value="" /></p>
							<input type="hidden" name="singer_id" value="' . $singer_id . '" />
							<p><input class="submit" type="submit" name="search_song" value="Submit" /></p>
						</form>
						<form action="singers.php" method="post" name="contributor">
							<p><span>Contributor:</span><input class="contact" type="text" name="contribution" value="" /></p>
							<input type="hidden" name="singer_id" value="' . $singer_id . '" />
							<p><input class="submit" type="submit" name="search_cont" value="Submit" /></p>
						</form>
					</div>
			<p><br />NOTE: Only one field needs to be entered.</p>
			';
			}
			?>
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
