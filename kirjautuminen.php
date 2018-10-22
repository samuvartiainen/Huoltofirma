<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Omakotiasukas tilaa palveluja kiinteistöhuoltofirmalta</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Kirjaudu sisään</h2>
  </div>
	 
  <form method="post" action="kirjautuminen.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Käyttäjätunnus</label>
  		<input type="text" name="tunnus" >
  	</div>
  	<div class="input-group">
  		<label>Salasana</label>
  		<input type="password" name="salasana">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="kirjaudu">Kirjaudu</button>
  	</div>
  	<p>
  		Uusi käyttäjä? <a href="rekisterointi.php">Rekisteröidy</a>
  	</p>
  </form>
</body>
</html>