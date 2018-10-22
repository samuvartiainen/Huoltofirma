<?php include('server.php');
  if (!isset($_SESSION['tunnus'])) {
  	$_SESSION['msg'] = "Sinun täytyy kirjautua sisään";
  	header('location: kirjautuminen.php');
  }
  if (isset($_GET['kirjulos'])) {
  	session_destroy();
  	unset($_SESSION['tunnus']);
  	header("location: kirjautuminen.php");
  }
$tunnus = $_SESSION["tunnus"];
$query2 = "SELECT * FROM kayttajat WHERE kayttajat.tunnus = '$tunnus'";
$result2 = mysqli_query($db, $query2);

 $query7 = "SELECT tunnus FROM kayttajat"; // kun tietoja muokataan, käyttäjänimeä ei saa löytyä kahta samaa, ettei kirjautuminen mene sekaisin
  $tulos7 = mysqli_query($db, $query7);
  $tuplakayttaja = mysqli_fetch_assoc($tulos7);

  while ($rivi = mysqli_fetch_array($result2, MYSQL_ASSOC)) { 
  $avain = $rivi["id"];
  $ktunnus = $rivi["tunnus"];
  $nimi = $rivi["nimi"];
  $email = $rivi["emailosoite"];
  $kosoite = $rivi["kayntiosoite"];
  $losoite = $rivi["laskutusosoite"];
  $atyyppi = $rivi["asunnontyyppi"];
  $apintaala = $rivi["asunnonpintaala"];
  $tontinkoko = $rivi["tontinkoko"];
  $salasana = $rivi["salasana"];

  }
 ?>
<html>
<head>
  <title>Tunnuksen luonti PHP ja mysql </title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
 <div style='float: right;'><p><strong><a href="omat_tiedot.php"><?php echo $_SESSION['tunnus']; ?></strong><br>
</style> <a href="omat_tiedot.php?kirjulos='1'" style="color: red;">Kirjaudu ulos</a> </p>
</div>
<h3>Täällä voit muokata omia tietoja </h3>
<table>
<thead>
<thead align="left">
<tr>
<th><?php echo "Käyttäjätunnus";?></th><td></td>
<th><?php echo "Nimi";?></th><td></td>
<th><?php echo "Email-osoite";?></th><td></td>
<th><?php echo "Käyntiosoite";?></th><td></td>
<th><?php echo "Laskutusosoite";?></th><td></td>
<th><?php echo "Asunnon tyyppi";?></th><td></td>
<th><?php echo "Asunnon pinta-ala";?></th><td></td>
<th><?php echo "Tontin koko";?></th><td></td>
<th></th>
</thead>
</tr>
<tr><td> <?php echo $ktunnus; ?></td><td></td><td><?php echo $nimi; ?></td><td></td><td> <?php echo $email; ?></td><td></td><td> <?php echo $kosoite; ?></td><td></td><td> <?php echo $losoite; ?></td><td></td>
<td> <?php echo $atyyppi; ?></td><td></td><td> <?php echo $apintaala; ?></td><td></td><td> <?php echo $tontinkoko; ?></td><td></td>
</table><br>
 <form method="post" action="omat_tiedot.php">
	<div class="input-group">
  	  <button type="submit" class="btn" name="muokkaa">Muokkaa</button>
  </div>
	 
<?php 

if(isset($_POST['muokkaa'])) { ?>
<div class="input-group"><br>
Käyttäjätunnus
<input type="text" name="ktunnus2"  size="25" value="<?php echo $ktunnus; ?>"><br>
Nimi
<input type="text" name="nimi2" size="30" value="<?php echo $nimi; ?>"><br>
Email-osoite
<input type="text" name="email2" size="30" value="<?php echo $email; ?>"><br>
Käyntiosoite
<input type="text" name="kosoite2" size="30" value="<?php echo $kosoite; ?>"><br>
Laskutusosoite
<input type="text" name="losoite2" size="30" value="<?php echo $losoite; ?>"><br>
Asunnon tyyppi
<input type="text" name="atyyppi2" size="30" value="<?php echo $atyyppi; ?>"><br>
Asunnon pinta-ala
<input type="text" name="apintaala2" size="10" value="<?php echo $apintaala; ?>"><br>
Tontin koko
<input type="text" name="tontinkoko2" size="10" value="<?php echo $tontinkoko; ?>"><br>
Salasana
<input type="password" name="salasana3" size="20" value="<?php echo $salasana; ?>"><br>
Salasana uudelleen
<input type="password" name="salasana4" size="20" value="<?php echo $salasana; ?>"><br>
<button type="submit" class="btn" name="tallenna">Tallenna tiedot</button>
<button type="submit" class="btn" name="kumoa">Kumoa</button>
 </div>
<?php	   
}
if(isset($_POST['tallenna']))
{ 

$ktunnus2 = mysqli_real_escape_string($db, $_POST['ktunnus2']);
$nimi2 = mysqli_real_escape_string($db, $_POST['nimi2']);
$email2 = mysqli_real_escape_string($db, $_POST['email2']);
$kosoite2 = mysqli_real_escape_string($db, $_POST['kosoite2']);
$losoite2 = mysqli_real_escape_string($db, $_POST['losoite2']);
$atyyppi2 = mysqli_real_escape_string($db, $_POST['atyyppi2']);
$apintaala2 = mysqli_real_escape_string($db, $_POST['apintaala2']);
$tontinkoko2 = mysqli_real_escape_string($db, $_POST['tontinkoko2']);
$salasana3 = mysqli_real_escape_string($db, $_POST['salasana3']);
$salasana4 = mysqli_real_escape_string($db, $_POST['salasana4']);
if ($salasana3 != $salasana4) {
	echo "Salasanassa virhe! Salasanaa ei vaihdettu. ";
}
if(strcasecmp($tuplakayttaja['tunnus'], $ktunnus2) != 0) {
      echo "Käyttäjänimi varattu.";
    }
else {
$query4 = "UPDATE kayttajat SET tunnus = '$ktunnus2', salasana = '$salasana3', nimi = '$nimi2', emailosoite = '$email2', kayntiosoite = '$kosoite2', laskutusosoite = '$losoite2', asunnontyyppi = '$atyyppi2', asunnonpintaala = '$apintaala2', tontinkoko = '$tontinkoko2' where kayttajat.id = '$avain'";
$result4 = mysqli_query($db, $query4);
$_SESSION['tunnus'] = $ktunnus2;
header('location: omat_tiedot.php');
}
}
if(isset($_POST['kumoa'])) {

   header("Location: omat_tiedot.php");
}

?>
</div>

  	<p>
  		<a href="tyotilaukset.php">Työtilauksiin</a>
  	</p>
</div>
</body>
</html>