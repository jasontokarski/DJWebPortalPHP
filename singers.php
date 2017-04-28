<!DOCTYPE HTML>
<html>
<?php include("dbvar.php"); ?>

<head>
	<title>CSCI 466</title>
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<script>
function cancelSelection()
{
	document.forms['form_cancel'].submit();
}

function selectSong( singer_id, file_id, song_title, version, singerFound )
{
	document.getElementById('forms_singer_id').value = singer_id;
	document.getElementById('forms_file_id').value = file_id;
	document.getElementById('forms_song_title').value = song_title;
	document.getElementById('forms_version').value = version;
	document.getElementById('forms_singerFound').value = singerFound;
	document.forms['form_selected'].submit();
}

</script>

<?php
	    
    // print queue list using table
    function print_song_list( $rows, $singer_id, $call_query )
    {

			echo <<<_SELECTED
							<form action="singers.php" method="post" name="form_selected">
								<input type="hidden" id="forms_singer_id" name="singer_id" value="" />
								<input type="hidden" id="forms_file_id" name="file_id" value="" />
								<input type="hidden" id="forms_song_title" name="song_title" value="" />
								<input type="hidden" id="forms_version" name="version" value="" />
								<input type="hidden" id="forms_singerFound" name="singerFound" value="" />
							</form>
_SELECTED;

			echo "<table style=\"width:100%; border-spacing:0;\">";
			
			// column header
			if( $rows[0] )
			{
				echo "<tr>";
				foreach( $rows[0] as $key => $val )
				{
				    if( $key == "contributor_name" || 
				    	$key == "role" ||
				    	$key == "song_title" ||
				    	$key == "artist_name" ||
				    	$key == "version" )
				    {
						echo "<th align='left'>";
						echo $key . "&nbsp;&nbsp;";
						echo "</th>";
					}
				}
				echo "</tr>";
			}

			// data
			foreach( $rows as $row )
			{
				$file_id = 0;
				$song_title = '';
				$version = '';
				echo "<tr>";
				foreach( $row as $colname => $colvalue )
				{
				    if( $colname == "file_id" )
				    {
				    	$file_id = $colvalue;
				    }
					else if( $colname == "temp_song_title" )
					{
						$song_title = $colvalue;
					}
					else if( $colname == "temp_version" )
					{
						$version = $colvalue;
					}
				    else if( ( $call_query == 3 && $colname == "contributor_name" ) ||
				    	( $call_query == 2 && $colname == "song_title" ) ||
				    	( $call_query == 1 && $colname == "artist_name" ) )
				    {
						echo "<td>";
						//echo "<a href=\"javascript:selectSong( $singer_id, $file_id, '$song_title', '$version', 1 );\">";
						echo "<a href=\"javascript:selectSong(" . $singer_id . ", " . 
							$file_id . ", '" . $song_title . "', '" . $version . "', 1);\">";
						echo $colvalue;
						echo "</a>";
						echo "&nbsp;&nbsp;" . "</td>\n";
					}
					else if( $colname=="contributor_name" || 
						$colname == "role" ||
						$colname == "song_title" ||
						$colname == "artist_name" ||
						$colname == "version" )
					{
						echo "<td>";
						echo $colvalue . "&nbsp;&nbsp;";
						echo "</td>\n";
					}
				}
				echo "</tr>";
			}
			
			echo "</table>\n";
    }

?>

<?php
	$singerFound = 0;
	if( array_key_exists( "singerFound", $_POST ) )
	{
		$singerFound = $_POST["singerFound"];
	}		
	$notFound = 0;
	$file_id = 0;
	if( array_key_exists( "file_id", $_POST ) )
	{
		$file_id = $_POST["file_id"];
	}
	$searchResult = array();
	$singer_id = 0;
	if( array_key_exists( "singer_id", $_POST ) )
	{
		$singer_id = $_POST["singer_id"];
	}
	$song_title = '';
	if( array_key_exists( "song_title", $_POST ) )
	{
		$song_title = $_POST["song_title"];
	}
	$version = '';
	if( array_key_exists( "version", $_POST ) )
	{
		$version = $_POST["version"];
	}
?>

<body>
<?php
    try
    {
        $pdo = new PDO( $dsn, $username, $password );
?>
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

					$call_query = 0;
					
					if(isset($_POST['search_name']))
					{
						$artistName = $_POST['artist_name'];

						$strfound = '%' . $artistName . '%';

						$sql = "SELECT k.file_id, s.song_title as temp_song_title, k.version as temp_version, 
								s.song_title, s.artist_name, k.version 
								FROM song s, karaoke_file k
								WHERE s.artist_name LIKE :strfound 
								AND s.song_id = k.song_id
								ORDER BY s.artist_name;";
								
						$call_query = 1;
					}
					if(isset($_POST['search_song']))
					{
						$songTitle = $_POST['song_title'];
						$strfound = '%' . $songTitle . '%';

						$sql = "SELECT k.file_id, s.song_title as temp_song_title, k.version as temp_version, 
								s.song_title, s.artist_name, k.version 
								FROM song s, karaoke_file k
								WHERE s.song_title LIKE :strfound 
								AND s.song_id = k.song_id
								ORDER BY s.song_title;";
								
						$call_query = 2;
					}
					if(isset($_POST['search_cont']))
					{
						$contributor = $_POST['contribution'];
						$strfound = '%' . $contributor . '%';

						$sql = "SELECT k.file_id, s.song_title as temp_song_title, k.version as temp_version, 
								c.contributor_name, cs.role, s.song_title, s.artist_name, k.version
								FROM contributor c, contributes cs, song s, karaoke_file k
								WHERE c.contributor_name LIKE :strfound 
								AND c.contributor_id = cs.contributor_id
								AND cs.song_id = s.song_id
								AND s.song_id = k.song_id
								ORDER BY c.contributor_name;";
								
						$call_query = 3;
					}
					if( $call_query > 0 )
					{
						$stat  = $pdo->prepare( $sql );
						//echo "type: " . gettype( $stat ) . "</br>";
						$succeeded = $stat->execute( array( ":strfound" => $strfound ) );

						/*
						if( $succeeded )
							echo "prepare(): Succeeded!</br>" . $sql;
						else
							echo "prepare(): Failed!</br>"; 
						*/

						$rows = $stat->fetchAll(PDO::FETCH_ASSOC);
			
						// if the record does not exists
						if( count( $rows ) == 0 )
						{				
							$singerFound = 0;
							$notFound = 1;
						}
				
						// if the record exists, show the list of songs found 
						else
						{
							$singerFound = 10;	// show the list of songs found
							print_song_list( $rows, $singer_id, $call_query );
							
		echo <<<_CANCEL
			<div class="form_settings">
				<form action="singers.php" method="post" name="form_cancel">
				<input type="hidden" name="singer_id" value="$singer_id" />
				<p><input class="submit" type="button" name="cancel" value="Cancel" 
							onclick="javascript:cancelSelection();"/></p>
				</form>
			</div>
_CANCEL;
							
							
						}

					}
				?>
				
			<?php
				if(isset($_POST['add_free']))
				{
						date_default_timezone_set('America/Chicago');
						$date = date('Y-m-d H:i:s', time());
						$sql2 = "INSERT INTO enqueue VALUES ('". $_POST['singer_id'] . "', '" .  $_POST['file_id'] . "', '" . $date . "', '" . 0 . "', '" . 0 . "');";

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
			
				if(isset($_POST['add_acc']))
				{
						date_default_timezone_set('America/Chicago');
						$date = date('Y-m-d H:i:s', time());
						$sql2 = "INSERT INTO enqueue VALUES ('". $_POST['singer_id'] . "', '" .  $_POST['file_id'] . "', '" . $date . "', '" . $_POST['acc_amount'] . "', '" . 0 . "');";

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
				echo '<h2>You Selected \'' . $song_title . '(' . $version . ')\'</h2>';
				echo '<p>Add this song to the free queue or accelerated queue with a payment amount.</p>';
				echo '
					<div class="form_settings">
						<form action="singers.php" method="post" name="free_queue">
							<input type="hidden" name="singer_id" value="' . $singer_id . '" />
							<input type="hidden" name="file_id" value="' . $file_id . '" />
							<p><input class="submit" type="submit" name="add_free" value="Free Queue" /></p>
						</form>
						<br />
						<form action="singers.php" method="post" name="acc_queue">
							<input type="hidden" name="singer_id" value="' . $singer_id . '" />
							<input type="hidden" name="file_id" value="' . $file_id . '" />
							<p><span>Amount (USD):</span><input class="contact" type="text" name="acc_amount" value="" /></p>
							<p><input class="submit" type="submit" name="add_acc" value="Payed Queue" /></p>
						</form>
						<br />
						<form action="singers.php" method="post" name="cancel_queue">
						<input type="hidden" name="singer_id" value="' . $singer_id . '" />
						<p><input class="submit" type="submit" name="cancel" value="Cancel" /></p>
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
<?php
    }
    catch( PDOexecption $e )
    {
        echo "DB connection Failed: " . $e->getMessage();
    }
?>
</body>
</html>
