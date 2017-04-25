<!DOCTYPE HTML>
<html>
<?php include("dbvar.php"); ?>
<head>
	<title>CSCI 466</title>
	<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
<script>
function newSinger()
{
	document.getElementById('new_singer').value = 1;
	document.forms['form1'].submit();
}
function signUpNewSinger()
{
	document.getElementById('new_singer').value = 100;
	document.forms['form1'].submit();
}
function goSingerPage(singer_id)
{
	document.getElementById('singer_id').value = singer_id;
	document.forms['form1'].action = 'singers.php';
	document.forms['form1'].submit();
}
</script>
<?php
	$new_singer = 0;
	$singer_id = 0;
	$singer_name = "";
	if( array_key_exists( "new_singer", $_POST ) )
		$new_singer = $_POST["new_singer"];
	if( array_key_exists( "id", $_POST ) )
		$singer_id = $_POST["id"];
	if( array_key_exists( "name", $_POST ) )
		$singer_name = $_POST["name"];
		
	// when Sign_up, if your name does not exist
	if( $new_singer == 100 && $singer_name == "" )
		$new_singer = 1;
		
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
					<li class="selected"><a href="index.php">Sign-Up</a></li>
					<!--<li><a href="singers.php">Singers</a></li>-->
					<li><a href="portal.php">DJ Portal</a></li>
				</ul>
			</div>
		</div>
    <div id="site_content">
		<div id="content">
			<h2>
			<?php 
	        if( $new_singer == 1 )
				echo "Sign up"; 
	        elseif( $new_singer == 100 )
				echo "Write down the ID, You Need it When Sign-In"; 
			else
				echo "Sign in with Singer Name and ID"; 
			?>
			</h2>
				<form name="form1" action="#" method="post">
						<input type="hidden" name="singer_id" id="singer_id" value="" />
						<input type="hidden" name="new_singer" id="new_singer" value="" />
<?php

    // pop alert box
	function alert( $msg ) 
	{
    	echo "<script type='text/javascript'>alert('$msg');"
    		. "</script>";
	}
		
    try
    {
        $pdo = new PDO( $dsn, $username, $password );
        
        
		// check if the name exists
        if( $new_singer == 100 )
        {
			$sql = "SELECT * FROM singer "
				. "WHERE singer_name = :singer_name;";
			$stat  = $pdo->prepare( $sql );
			//echo "type: " . gettype( $stat ) . "</br>";
			$succeeded = $stat->execute( array( ":singer_name" => $singer_name ) );

			/*
			if( $succeeded )
				echo "prepare(): Succeeded!</br>" . $sql;
			else
				echo "prepare(): Failed!</br>"; 
			*/

			$rows = $stat->fetchAll(PDO::FETCH_ASSOC);
	
			// if the singer does not exists, alert
			if( count( $rows ) > 0 )
			{				
				echo "'" . $singer_name . "' Exists. Try with Other Name";
				$new_singer = 1;
			}
			
		}
					
        // insert new singer and show the 'ID'
        if( $new_singer == 100 )
        {
			$sql = "INSERT singer (singer_name) ".
				"VALUES (:singer_name);";
			$stat  = $pdo->prepare( $sql );
			//echo "type: " . gettype( $stat ) . "</br>";
			$succeeded = $stat->execute( array( ":singer_name" => $singer_name ) );
			if( $succeeded )
			{        

				// $singer_id = mysql_insert_id();
				$singer_id = $pdo->lastInsertId();
											
				echo "'" . $singer_name . "' Has ID'" . $singer_id . "'";
echo <<<_END
				<div class="form_settings">
					<p style="padding-top: 15px"><input class="submit" type="button" name="okay" value="Okay" 
					onclick="javascript:goSingerPage($singer_id);" /></p>
				</div>
_END;
			}
			else
			{
				echo "Failed!</br>"; 
			}
        }
        
        // sign up page
        elseif( $new_singer == 1 )
        {
?>
						<div class="form_settings">
							<p><span>Name:</span><input class="contact" type="text" name="name" value="" /></p>
							<p style="padding-top: 15px"><input class="submit" type="button" name="sign_up" value="Sign up" 
							onclick="javascript:signUpNewSinger();" /></p>
						</div>
<?php
        }
        
        // sign in page
        else
        {
        
			// check singer_id and name
			if( $singer_id > 0 )
			{
		
					// check if the record exists
					$sql = "SELECT * FROM singer "
						. "WHERE singer_id = :singer_id AND "
						. "singer_name = :singer_name;";
					$stat  = $pdo->prepare( $sql );
					//echo "type: " . gettype( $stat ) . "</br>";
					$succeeded = $stat->execute( array( ":singer_id" => $singer_id ,
						":singer_name" => $singer_name ) );

					/*
					if( $succeeded )
						echo "prepare(): Succeeded!</br>" . $sql;
					else
						echo "prepare(): Failed!</br>"; 
					*/

					$rows = $stat->fetchAll(PDO::FETCH_ASSOC);
			
					// if the singer does not exists, alert
					if( count( $rows ) == 0 )
					{				
						alert( "The record you chose does not exist");
					}
				
					// if the singer exits, go to 'singers.php' 
					else
					{
						echo "<script type='text/javascript'>"
							. "document.getElementById('singer_id').value = $singer_id;"
							. "document.forms['form1'].action = 'singers.php';"
							. "document.forms['form1'].submit();"
							. "</script>";
					}
			}
		
?>
			<div class="form_settings">
				<p><span>Name:</span><input class="contact" type="text" name="name" value="" /></p>
				<p><span>Id:</span><input class="contact" type="text" name="id" value="" /></p>
				<p style="padding-top: 15px"><input class="submit" type="submit" value="Sign in" /></p>
				<p style="padding-top: 15px"><input class="submit" type="button" name="new_singer" 
				value="New Singer" onclick="javascript:newSinger();" /></p>
			</div>
<?php
		}

    }
    catch( PDOexecption $e )
    {
        echo "DB connection Failed: " . $e->getMessage();
    }
    
?>
				</form>
			<p><br /><br />
			<?php
			 if( $new_singer == 0 ) 
			 	echo "NOTE: Needed to Fill Both, ID and Name";
			 ?>
			</p>
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
