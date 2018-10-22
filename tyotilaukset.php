<?php 
ob_start();
include('server.php');
  if (!isset($_SESSION['tunnus'])) {
  	$_SESSION['msg'] = "Sinun täytyy kirjautua sisään";
  	header('location: kirjautuminen.php');
  }
  if (isset($_GET['kirjulos'])) {
  	session_destroy();
  	unset($_SESSION['tunnus']);
  	header("location: kirjautuminen.php");
  }
 // Luodaan työtilauksia varten tilaustiedot -taulu, jos sitä ei vielä ole olemassa
 $taulu2 = "tilaustiedot";
$tauluquery2 = "SELECT ID FROM '$taulu2'"; 
$tulostaulu2 = mysqli_query($db, $tauluquery2);
 if(empty($tulostaulu2)) {

$luotaulu2 = "CREATE TABLE IF NOT EXISTS `$taulu2` (
			`id` int(11) unsigned NOT NULL auto_increment,
			`tunnus` varchar(255) NOT NULL default '',
			`tilaaja` varchar(255) NOT NULL default '',
			`kuvaus` varchar(255) NOT NULL default '',
			`tilauspvm` DATE,
			`aloituspvm` DATE,
			`valmistumispvm` DATE,
			`hyvaksymispvm` DATE,
			`kommentti` varchar(255) NOT NULL DEFAULT '',
			`tyotunnit` varchar(255) NOT NULL DEFAULT '',
			`tarvikkeet` varchar(255) NOT NULL DEFAULT '',
			`kustannusarvio` varchar(255) NOT NULL DEFAULT '',
			`status` varchar(255) NOT NULL DEFAULT '',
			PRIMARY KEY (`id`) 
			)";
mysqli_query($db, $luotaulu2);
 }
 
 // Haetaan tilaajan nimi kayttajat-taulusta
 $tilaajannimi = "";
 $kaytquery1 = "SELECT nimi FROM kayttajat INNER JOIN tilaustiedot on kayttajat.tunnus = tilaustiedot.tunnus"; 
 $kayttulos1 = mysqli_query($db, $kaytquery1);
 
 while ($kaytrivi1 = mysqli_fetch_array($kayttulos1, MYSQL_ASSOC)) {
	 $tilaajannimi = $kaytrivi1["nimi"]; 
 }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Omakotiasukas tilaa palveluja kiinteistöhuoltofirmalta</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
 <div style='float: right;'><p><strong><a href="omat_tiedot.php"><?php echo $_SESSION['tunnus']; ?></strong><br>
</style> <a href="omat_tiedot.php?kirjulos='1'" style="color: red;">Kirjaudu ulos</a> </p></div>
<div class="header">
	<h3>Omat työtilaukset</h3>
</div>
<div class="content">
 <table>
<thead>
<thead align="left">
<tr>
<th>Tilaajan nimi</th><td><th>Työn kuvaus</th><td><th>Tilauspvm</th></td><td><th>Aloituspvm</th></td><td><th>Valmistumispvm</th></td><td><th>Hyväksymispvm</th></td><td><th>Vapaamuotoinen kommentti <br> kuluneista tarvikkeista</th></td><td><th>Työtunnit</th></td><td><th>Kuluneet työtarvikkeet</th></td><td><th>Kustannusarvio</th></td><td><th>STATUS</td></tr> </head> <tr><td>
<?php 
$tunnus = $_SESSION["tunnus"];
$query6 = "SELECT tilaustiedot.*, kayttajat.nimi FROM tilaustiedot INNER JOIN kayttajat on tilaustiedot.tunnus = kayttajat.tunnus WHERE tilaustiedot.tunnus = '$tunnus'";
$result6 = mysqli_query($db, $query6);
// Käydään läpi ja tulostetaan kaikki käyttäjätunnuksen työtilaukset
  while ($rivi1 = mysqli_fetch_array($result6, MYSQL_ASSOC)) { 
  $avain1 = $rivi1["id"];
  $tunnus1 = $rivi1["tunnus"];
  $tilaaja1 = $rivi1["nimi"];
  $kuvaus1 = $rivi1["kuvaus"];
  $tilauspvm1 = $rivi1["tilauspvm"];
  $aloituspvm1 = $rivi1["aloituspvm"];
  $valmistumispvm1 = $rivi1["valmistumispvm"];
  $hyvaksymispvm1 = $rivi1["hyvaksymispvm"];
  $kommentti1 = $rivi1["kommentti"];
  $tyotunnit1 = $rivi1["tyotunnit"];
  $tarvikkeet1 = $rivi1["tarvikkeet"];
  $kustannusarvio1 = $rivi1["kustannusarvio"];
  $status1 = $rivi1["status"];

		?> <tr><td width="120"> <?php echo $tilaaja1; ?></td><td></td><td width="250"><?php echo $kuvaus1; ?>
		</td><td></td><td width="70"><?php echo date('d.m.Y', strtotime($tilauspvm1)); ?></td><td></td><td width="70">
		<?php if ($aloituspvm1 != NULL) { echo date('d.m.Y', strtotime($aloituspvm1)); }
		else { echo ""; } ?></td><td></td><td width="70"><?php if($valmistumispvm1 != NULL) { echo date('d.m.Y', strtotime($valmistumispvm1)); } else { echo ""; }?>
		</td><td></td><td width="70"><?php if($hyvaksymispvm1 != NULL) { echo date('d.m.Y', strtotime($hyvaksymispvm1)); } else { echo ""; } ?></td><td></td><td width="350">
		<?php echo $kommentti1; ?></td><td></td><td width="70"><?php echo $tyotunnit1; ?></td><td>
		</td><td width="200"><?php echo $tarvikkeet1; ?></td><td></td><td width="200">
		<?php echo $kustannusarvio1; ?></td><td></td><td width="70">
		<span style="color:green;"><?php echo $status1 ?> </span> </td><td></td><td> 
 <form action="tyotilaukset.php" method="post">
<div class="input-group">
<input type="submit" name="mtilaus" value="Muokkaa"></input><input type="submit" name="ptilaus" value="Poista"></input><br>
<input type="submit" name="htilaus" value="Hyväksy työtilaus"> <?php
echo "<td>" . "<input type=hidden name=hidden value=$avain1>"; 
echo "</div>";
echo "</form>";
  }
?>
</table>
<p></p>
 <form method="post" action="tyotilaukset.php">
	<div class="input-group">
  	  <button type="submit" class="btn" name="utilaus">Uusi tilaus</button>
  	</div>
<?php // Uusi tilaus -painike
if(isset($_POST['utilaus'])) { ?> 
<br>
Työn kuvaus
<input type="text" name="kuvaus2" size="60" value="<?php ?>"><br>

<button type="submit" class="btn" name="tallenna2">Tallenna tiedot</button>
<button type="submit" class="btn" name="kumoa2">Kumoa</button>
 </div></form>
<?php	   
}
if(isset($_POST['tallenna2']))
{ 

$kuvaus2 = mysqli_real_escape_string($db, $_POST['kuvaus2']);

$tunnus = $_SESSION["tunnus"];
// kuvaus kenttä on pakollinen
if (empty($kuvaus2)) { echo "Työn kuvaus puuttuu<br>"; }

 
else {
	
$query8 = "INSERT INTO tilaustiedot (tunnus, tilaaja, kuvaus, tilauspvm, status)
			VALUES ('$tunnus', '$tilaajannimi', '$kuvaus2', CURDATE(), 'TILATTU')";
mysqli_query($db, $query8);
header('location: tyotilaukset.php');
}
}
if(isset($_POST['kumoa2'])) {
   header("Location: tyotilaukset.php");
}
 ?>
<?php // Muokkaa tilausta -painike
if(isset($_POST['mtilaus'])) { 
// Ensiksi query jotta saadaan kenttiin vanhat tiedot
$query5 = "SELECT * FROM tilaustiedot WHERE tilaustiedot.id ='$_POST[hidden]'";
$result5 = mysqli_query($db, $query5);

while ($rivi5 = mysqli_fetch_array($result5, MYSQL_ASSOC)) { 
  $avain5 = $rivi5["id"];
  $tunnus5 = $rivi5["tunnus"];
  $tilaaja5 = $rivi5["tilaaja"];
  $kuvaus5 = $rivi5["kuvaus"];
  $tilauspvm5 = $rivi5["tilauspvm"];
  $aloituspvm5 = $rivi5["aloituspvm"];
  $valmistumispvm5 = $rivi5["valmistumispvm"];
  $hyvaksymispvm5 = $rivi5["hyvaksymispvm"];
  $kommentti5 = $rivi5["kommentti"];
  $tyotunnit5 = $rivi5["tyotunnit"];
  $tarvikkeet5 = $rivi5["tarvikkeet"];
  $kustannusarvio5 = $rivi5["kustannusarvio"];
  $status5 = $rivi5["status"];
}
// Estetään muokkaus jos status ei ole TILATTU
if(strcasecmp($status5, "TILATTU") != 0){
echo "<br>Tilausta ei voi enää muuttaa, sillä sen status ei ole TILATTU.";
?><p><font size="4"><br><a href="tarjouspyynnot.php">Jätä tarjouspyyntö täällä! </a></p><?php
exit();
}
else
 ?>

<div class="input-group"><br>
Työn kuvaus
<input type="text" name="kuvaus3" size="100" value="<?php echo $kuvaus5; ?>"><br>
<input type="hidden" name="hiddenid" value="<?php echo $avain5; ?>"><br>
<button type="submit" class="btn" name="tallenna3">Tallenna tiedot</button>
<button type="submit" class="btn" name="kumoa3">Kumoa</button>


<?php	   
}
	

$errors2 = array(); 
if(isset($_POST['tallenna3']))
{ 
$hiddenid = mysqli_real_escape_string($db, $_POST['hiddenid']);

$kuvaus3 = mysqli_real_escape_string($db, $_POST['kuvaus3']);

$tunnus = $_SESSION["tunnus"];

// kentät pakollisia

if (empty($kuvaus3)) { array_push($errors2, "Työn kuvaus puuttuu<br>"); }

 // Muokkauksen tallennus ellei tule virheitä
elseif (count($errors2) == 0) {
$query9 = "UPDATE tilaustiedot SET tilaaja = '$tilaajannimi', kuvaus = '$kuvaus3' where tilaustiedot.id = '$hiddenid'";
mysqli_query($db, $query9);
header('location: tyotilaukset.php');
}
else {
	
	echo "Tietoja ei muutettu, täytä kaikki kentät";
}
} // Muokkauksella kumoa nappi
if(isset($_POST['kumoa3'])) {
   header("Location: tyotilaukset.php");
}
// Tilauksen poisto -painike
if(isset($_POST['ptilaus'])) { 
$pquery1 = "SELECT * FROM tilaustiedot WHERE tilaustiedot.id ='$_POST[hidden]'";
$ptulos1 = mysqli_query($db, $pquery1);

while ($privi1 = mysqli_fetch_array($ptulos1, MYSQL_ASSOC)) { 
  $pavain1 = $privi1["id"];
  $pstatus1 = $privi1["status"];
}
// Poisto sallitaan vain TILATTU statuksella oleville tilauksille
if(strcasecmp($pstatus1, "TILATTU") == 0)
{

$pquery2 = "DELETE FROM tilaustiedot WHERE tilaustiedot.id ='$_POST[hidden]'";

$ptulos2 = mysqli_query($db, $pquery2);
header("Location: tyotilaukset.php");
}
else {
echo "<br>Tilausta ei voi enää poistaa, sillä sen status ei ole enää TILATTU.";
}
}
// Hyväksyminen sallitaan vain VALMIS statuksella oleville tilauksille
if(isset($_POST['htilaus'])) { 
$pquery2 = "SELECT * FROM tilaustiedot WHERE tilaustiedot.id ='$_POST[hidden]'";
$ptulos2 = mysqli_query($db, $pquery2);

while ($privi2 = mysqli_fetch_array($ptulos2, MYSQL_ASSOC)) { 
  $pavain2 = $privi2["id"];
  $pstatus2 = $privi2["status"];
}

if(strcasecmp($pstatus2, "VALMIS") == 0)
{

$pquery2 = "UPDATE tilaustiedot set status = 'HYVÄKSYTTY', 
			hyvaksymispvm = CURDATE() 
			where tilaustiedot.id = '$pavain2'";

$ptulos2 = mysqli_query($db, $pquery2);
header("Location: tyotilaukset.php");
}
else {
echo "<br>Tilausta ei voi hyväksyä, ellei sen status ole VALMIS.";
}
}
?>
<p>
	<font size="4"><br><a href="tarjouspyynnot.php">Tarjouspyyntöihin pääset tästä </a></br>
</div>
		
</body>
</html>
