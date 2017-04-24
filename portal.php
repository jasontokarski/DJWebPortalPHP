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
          <li><a href="index.php">Singers</a></li>
          <li class="selected"><a href="portal.php">DJ Portal</a></li>
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
        <h2>Song Information</h2>
        <p>Tables should be used to display data and not used for laying out your website:</p>
        <table style="width:100%; border-spacing:0;">
          <tr><th>Free Queue</th><th>Accelerated Queue</th></tr>
          <tr><td>Item 1</td><td>Description of Item 1</td></tr>
          <tr><td>Item 2</td><td>Description of Item 2</td></tr>
          <tr><td>Item 3</td><td>Description of Item 3</td></tr>
          <tr><td>Item 4</td><td>Description of Item 4</td></tr>
        </table>
        <h2>DJ Information</h2>
        <form action="" method="post">
			<div class="form_settings">
				<p><span>Dj Information</span><input type="text" name="name" value="" /></p>
				
				<p><span>Selected</span><input class="checkbox" type="checkbox" name="name" value="" /></p>
				
				<p><span>Queue list</span>
				<select id="id" name="name">
				<option value="1">Example 1</option>
				<option value="2">Example 2</option></select></p>
				<p style="padding-top: 15px"><input class="submit" type="submit" name="name" value="Submit" /></p>
          </div>
        </form>
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
