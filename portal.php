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
					<!--<li><a href="singers.php">Singers</a></li>-->
					<li class="selected"><a href="portal.php">DJ Portal</a></li>
				</ul>
			</div>
		</div>
	<div id="site_content">
		<div id="content">
<form name = "form1" action="#" method = "get">
<script>
function confirmDelete(deleteUrl, name) {
	if (confirm("Are you sure you want to pick \'" + name +  "\' ?")) {
		document.location = deleteUrl;
	}
}
</script>
<?php

    // pop alert box
	function alert( $msg ) 
	{
    	echo "<script type='text/javascript'>alert('$msg');"
    		. "</script>";
	}
	    
    // print queue list using table
    function print_queue_list( $rows, $free_queue )
    {

		if( count( $rows ) == 0 )
		{
			echo "No Exists<br />\n";
		}
		else
		{
			echo "<table style=\"width:100%; border-spacing:0;\">";
			
			// column header
			if( $rows[0] )
			{
				echo "<tr>";
				foreach( $rows[0] as $key => $val )
				{
				    if( $key == "singer_name" || 
				    	$key == "song_title" ||
				    	$key == "version" )
				    {
						echo "<th align='left'>";
						echo $key . "&nbsp;&nbsp;";
						echo "</th>";
					}
					elseif( $key == "amount_paid" ||
				    	$key == "date_added" )
				    {
						echo "<th align='left'>";
						if( !$free_queue )
							echo "<a href=\"javascript:window.location = 'portal.php?sort_kind=" . $key . "';\">";
						echo $key;
						if( !$free_queue )
							echo "</a>";
						echo "&nbsp;&nbsp;";
						echo "</th>";
				    }

				}
				echo "</tr>";
			}

			// data
			foreach( $rows as $row )
			{
				$singer_id = 0;
				$file_id = 0;
    			date_default_timezone_set('America/Chicago');
				$date_added = date('Y-m-d H:i:s');
				echo "<tr>";
				foreach( $row as $colname => $colvalue )
				{
				    if( $colname == "singer_id" )
				    {
				    	$singer_id = $colvalue;
				    }
				    else if( $colname == "file_id" )
				    {
				    	$file_id = $colvalue;
				    }
				    else if( $colname == "date_temp" )
				    {
				    	$date_added = $colvalue;
				    }
				    else if( $colname == "singer_name" )
				    {
						echo "<td>";
						echo "<a href=\"javascript:confirmDelete('portal.php?singer_id=$singer_id&" 
							. "file_id=$file_id&date_added=$date_added', '$colvalue');\">";
						echo $colvalue;
						echo "</a>";
						echo "&nbsp;&nbsp;" . "</td>\n";
					}
					else if( $colname == "song_title" )
					{
						echo "<td>";
						echo $colvalue . "&nbsp;&nbsp;";
						echo "</td>\n";
					}
				    else if( $colname == "version" )
				    {
						echo "<td>" . $colvalue . "&nbsp;&nbsp;" . "</td>\n";
				    }
				    else if( $colname == "amount_paid" )
				    {
						echo "<td>" . $colvalue . "</td>\n";
				    }
				    else if( $colname == "date_added" )
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
        echo "</p>\n";
    }

	$singer_id = 0;
	$file_id = 0;
	$date_added = 0;
	$sort_kind = "";
	if( array_key_exists( "singer_id", $_GET ) )
		$singer_id = $_GET["singer_id"];
	if( array_key_exists( "file_id", $_GET ) )
		$file_id = $_GET["file_id"];
	if( array_key_exists( "date_added", $_GET ) )
		$date_added = $_GET["date_added"];
	if( array_key_exists( "sort_kind", $_GET ) )
		$sort_kind = $_GET["sort_kind"];
		
    try
    {
        $pdo = new PDO( $dsn, $username, $password );
        
        // delete selected record in the queue
		if( $singer_id > 0 )
		{
		
				// check if the record you want to update exists
				$sql = "SELECT * FROM enqueue "
					. "WHERE singer_id = :singer_id AND "
					. "file_id = :file_id AND date_added = :date_added;";
				$stat  = $pdo->prepare( $sql );
				//echo "type: " . gettype( $stat ) . "</br>";
				$succeeded = $stat->execute( array( ":singer_id" => $singer_id ,
					":file_id" => $file_id, ":date_added" => $date_added ) );

        		/*
				if( $succeeded )
					echo "prepare(): Succeeded!</br>" . $sql;
				else
					echo "prepare(): Failed!</br>"; 
				*/

				$rows = $stat->fetchAll(PDO::FETCH_ASSOC);
			
			    // if the flight does not exists, alert
				if( count( $rows ) == 0 )
				{				
					echo "The record you chose does not exist</br>";
				}
				
				// if the flight exits, delete the flight in the DB 
				else
				{
					/*
					// delete the record of the record on the enqueue
					$sql = "DELETE FROM enqueue "
					. "WHERE singer_id = :singer_id AND "
					. "file_id = :file_id AND date_added = :date_added;";
					*/
					// update the record of the passengers on the flight
					$sql = "UPDATE enqueue SET flag = TRUE "
					. "WHERE singer_id = :singer_id AND "
					. "file_id = :file_id AND date_added = :date_added;";
										
					$stat  = $pdo->prepare( $sql );
					//echo "type: " . gettype( $stat ) . "</br>";
					$succeeded = $stat->execute( array( ":singer_id" => $singer_id ,
						":file_id" => $file_id, ":date_added" => $date_added ) );

					if( $succeeded )
					{
						//alert( "Succeeded");
					}
					else
					{
						alert( "Failed");
					}
				}
		}

        
		// accelerated queue
		echo "<b><font color='black'>Accelerated Queue:</font></b><br />\n";
        
		$sql = "SELECT si.singer_id, ka.file_id, q.date_added as date_temp,
			si.singer_name, so.song_title, ka.version, q.amount_paid,
			q.date_added
			FROM enqueue q, karaoke_file ka, singer si, song so
			WHERE q.singer_id = si.singer_id AND q.file_id = ka.file_id 
			AND ka.song_id = so.song_id AND q.flag = FALSE AND q.amount_paid > 0 "
			. ($sort_kind=="date_added"?"ORDER BY q.date_added DESC;":"ORDER BY q.amount_paid DESC;");
        $stat = $pdo->query( $sql );		// return PDOStatement object       	
	
        $rows = $stat->fetchAll(PDO::FETCH_ASSOC);
        
        //print_r( $rows );
        print_queue_list( $rows, false );
        
		// free queue
		echo "<b><font color='black'>Free Queue:</font></b><br />\n";
        
		$sql = "SELECT si.singer_id, ka.file_id, q.date_added as date_temp,
			si.singer_name, so.song_title, ka.version,
			q.date_added			
			FROM enqueue q, karaoke_file ka, singer si, song so
			WHERE q.singer_id = si.singer_id AND q.file_id = ka.file_id 
			AND ka.song_id = so.song_id AND q.flag = FALSE AND q.amount_paid = 0
			ORDER BY q.date_added DESC;";
        $stat = $pdo->query( $sql );		// return PDOStatement object       
        
        $rows = $stat->fetchAll(PDO::FETCH_ASSOC);
        
        //print_r( $rows );
        print_queue_list( $rows, true );
        

    }
    catch( PDOexecption $e )
    {
        echo "DB connection Failed: " . $e->getMessage();
    }
    
?>
			<div class="form_settings">
				<p><input class="submit" type="button" name="refresh" value="Refresh" 
							onclick="javascript:window.location.reload(false);"/></p>
			</div>
</form>
		</div>
	</div>
    <div id="footer">
		<p><a href="index.php">Sign-Up</a> <!--| <a href="singers.php">Singers</a> -->| <a href="portal.php">DJ Portal</a></p>
		<p>CSCI466 Karaoke Group Project</p>
	</div>
	<p>&nbsp;</p>
	</div>
</body>
</html>
