<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Omakotiasukas tilaa palveluja kiinteistöhuoltofirmalta</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Rekisteröinti</h2>
  </div>
  <form method="post" action="rekisterointi.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Käyttäjätunnus</label>
  	  <input type="text" name="tunnus" value="<?php ?>"> <?php echo "*"; ?>
  	</div>
  	<div class="input-group">
  	  <label>Salasana</label>
  	  <input type="password" name="salasana_1"> <?php echo "*"; ?>
  	</div>
  	<div class="input-group">
  	  <label>Vahvista salasana</label>
  	  <input type="password" name="salasana_2"> <?php echo "*"; ?>
  	</div>
	<div class="input-group">
  	  <label>Nimi</label>
  	  <input type="text" name="nimi" value=""> <?php echo "*"; ?>
  	</div>
	<div class="input-group">
  	  <label>Käyntiosoite</label>
  	  <input type="text" name="kayntiosoite" value=""> <?php echo "*"; ?>
  	</div>
	<div class="input-group">
  	  <label>Laskutusosoite</label>
  	  <input type="text" name="laskutusosoite" value=""> <?php echo "*"; ?>
  	</div>
	<div class="input-group">
  	  <label>Puhelinnumero</label>
  	  <input type="text" name="puhelinnumero" value=""> <?php echo "*"; ?>
  	</div>
	<div class="input-group">
  	  <label>Email-osoite</label>
  	  <input type="text" name="emailosoite" value=""> <?php echo "*"; ?>
  	</div>
	<div class="input-group">
  	  <label>Asunnon tyyppi</label>
  	  <input type="text" name="asunnontyyppi" value="">
  	</div>
	<div class="input-group">
  	  <label>Asunnon pinta-ala</label>
  	  <input type="text" name="asunnonpintaala" value="">
  	</div>
	<div class="input-group">
  	  <label>Tontin koko </label>
  	  <input type="text" name="tontinkoko" value="">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="rekisteroidy">Rekisteröidy</button>
  	</div>
	
	<p> * Pakollinen tieto </p>	
	
  	<p>
  		Oletko jo rekisteröitynyt? <a href="kirjautuminen.php">Kirjaudu sisään</a>
  	</p>
  </form>
</body>
</html>