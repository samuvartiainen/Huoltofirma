<?php
session_start();

$tunnus = "";
$errors = array(); 
$db = mysqli_connect('localhost', 'root', '', '');
// LUODAAN kanta jos sitä ei vielä ole 'rekisterointi' nimellä. Yhdistetään kantaan
$dbcheck = mysqli_select_db($db, 'rekisterointi');
if(!$dbcheck){
$dbluo = "CREATE DATABASE IF NOT EXISTS rekisterointi";
mysqli_query($db, $dbluo);
}
$db = mysqli_connect('localhost', 'root', '', 'rekisterointi');
if(!$db) {
	die("Yhdistäminen epäonnistui " . mysql_error());
}

// Rekisteröidy nappi
if (isset($_POST['rekisteroidy'])) {
  // Input valuet rekisterointi.php sivun formista
  $tunnus = mysqli_real_escape_string($db, $_POST['tunnus']);
  $salasana_1 = mysqli_real_escape_string($db, $_POST['salasana_1']);
  $salasana_2 = mysqli_real_escape_string($db, $_POST['salasana_2']);
  $nimi = mysqli_real_escape_string($db, $_POST['nimi']);
  $kayntiosoite = mysqli_real_escape_string($db, $_POST['kayntiosoite']);
  $laskutusosoite = mysqli_real_escape_string($db, $_POST['laskutusosoite']);
  $puhelinnumero = mysqli_real_escape_string($db, $_POST['puhelinnumero']);
  $emailosoite= mysqli_real_escape_string($db, $_POST['emailosoite']);
  $asunnontyyppi = mysqli_real_escape_string($db, $_POST['asunnontyyppi']);
  $asunnonpintaala = mysqli_real_escape_string($db, $_POST['asunnonpintaala']);
  $tontinkoko = mysqli_real_escape_string($db, $_POST['tontinkoko']);
  
  // tarkistetaan että form täytetty oikein
  if (empty($tunnus)) { array_push($errors, "Käyttäjätunnus vaadittu"); }
  if (empty($salasana_1)) { array_push($errors, "Salasana vaadittu"); }
  if ($salasana_1 != $salasana_2) {
	array_push($errors, "Salasanat eivät täsmää!");
  }
  if (empty($nimi)) { array_push($errors, "Nimi vaadittu"); }
  if (empty($kayntiosoite)) { array_push($errors, "Käyntiosoite vaadittu"); }
  if (empty($laskutusosoite)) { array_push($errors, "Laskutusosoite vaadittu"); }
  if (empty($puhelinnumero)) { array_push($errors, "Puhelinnumero vaadittu"); }
  if (empty($emailosoite)) { array_push($errors, "Email-osoite vaadittu"); }
  
  // Varmistetaan ettei kannassa ole jo samaa käyttäjänimeä
  $tunnusquery = "SELECT * FROM kayttajat WHERE tunnus='$tunnus' LIMIT 1";
  $tunnustulos = mysqli_query($db, $tunnusquery);
  $olikotunnus = mysqli_fetch_assoc($tunnustulos);
  
  if ($olikotunnus) { // Jos käyttäjätunnus on olemassa
    if ($olikotunnus['tunnus'] === $tunnus) {
      array_push($errors, "Käyttäjätunnus on jo olemassa!");
    }

  }
// Luodaan käyttäjiä varten kayttajat -taulu
$taulu1 = "kayttajat";
$checkquery1 = "SELECT ID FROM '$taulu1'"; 
$tulostaulu1 = mysqli_query($db, $checkquery1);
 if(empty($tulostaulu1)) {

$luotaulu1 = "CREATE TABLE IF NOT EXISTS `$taulu1` (
			`id` int(11) unsigned NOT NULL auto_increment,
			`tunnus` varchar(255) NOT NULL default '',
			`nimi` varchar(255) NOT NULL default '',
			`salasana` varchar(255) NOT NULL default '',
			`kayntiosoite` varchar(255) NOT NULL default '',
			`emailosoite` varchar(255) NOT NULL default '',
			`laskutusosoite` varchar(255) NOT NULL default '',
			`asunnontyyppi` varchar(255) NOT NULL DEFAULT '',
			`asunnonpintaala` varchar(255) NOT NULL default '',
			`tontinkoko` varchar(255) NOT NULL default '',
			PRIMARY KEY (`id`) 
			)";
mysqli_query($db, $luotaulu1);
 }
 
  // Jos ei tullut erroreita, voi rekisteröityä
  if (count($errors) == 0) {
  	$salasana = $salasana_1;

  	$rekquery = "INSERT INTO kayttajat (tunnus, nimi, salasana, kayntiosoite, emailosoite, laskutusosoite, 
				asunnontyyppi, asunnonpintaala, tontinkoko) 
				VALUES('$tunnus', '$nimi', '$salasana', '$kayntiosoite', '$emailosoite', '$laskutusosoite', '$asunnontyyppi',
				'$asunnonpintaala', '$tontinkoko')";
  	mysqli_query($db, $rekquery);
  	$_SESSION['tunnus'] = $tunnus;
  	header('location: tyotilaukset.php');
  }
}
// kirjautuminen.php sivun kirjaudu -painike
if (isset($_POST['kirjaudu'])) {
  $tunnus = mysqli_real_escape_string($db, $_POST['tunnus']);
  $salasana = mysqli_real_escape_string($db, $_POST['salasana']);

  if (empty($tunnus)) {
  	array_push($errors, "Käyttäjätunnus vaadittu");
  }
  if (empty($salasana)) {
  	array_push($errors, "Salasana vaadittu");
  }

  if (count($errors) == 0) {
  	$kquery = "SELECT * FROM kayttajat WHERE tunnus='$tunnus' AND salasana='$salasana'";
  	$ktulos = mysqli_query($db, $kquery);
  	if (mysqli_num_rows($ktulos) == 1) {
  	  $_SESSION['tunnus'] = $tunnus;
  	  header('location: tyotilaukset.php');
  	}else {
  		array_push($errors, "Väärä käyttäjätunnus/salasana yhdistelmä");
  	}
  }
}

?>
