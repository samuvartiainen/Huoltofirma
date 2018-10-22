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
$db = mysqli_connect('localhost', 'root', '', 'rekisterointi');
$taulu3 = "tarjouspyynnot";
$checkquery3 = "SELECT ID FROM '$taulu3'"; 
$tulostaulu3 = mysqli_query($db, $checkquery3);
 if(empty($tulostaulu3)) {

$luotaulu3 = "CREATE TABLE IF NOT EXISTS `$taulu3` (
			`id` int(11) unsigned NOT NULL auto_increment,
			`tunnus` varchar(255) NOT NULL default '',
			`tilaaja` varchar(255) NOT NULL default '',
			`kuvaus` varchar(255) NOT NULL default '',
			`jattopvm` date,
			`kustannusarvio` varchar(255) NOT NULL default '',
			`vastaamispvm` date,
			`status` varchar(255) NOT NULL DEFAULT '',
			PRIMARY KEY (`id`) 
			)";
mysqli_query($db, $luotaulu3);
 }

 // Haetaan tilaajan nimi kayttajat-taulusta
 $tilaajannimi2 = "";
 $kaytquery2 = "SELECT nimi FROM kayttajat INNER JOIN tarjouspyynnot on kayttajat.tunnus = tarjouspyynnot.tunnus"; 
 $kayttulos2 = mysqli_query($db, $kaytquery2);
 
 while ($kaytrivi2 = mysqli_fetch_array($kayttulos2, MYSQL_ASSOC)) {
	 $tilaajannimi2 = $kaytrivi2["nimi"]; 
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
	<h3>Omat tarjouspyynnöt</h3>
</div>
<div class="content">
 <table>
<thead>
<thead align="left">
<tr>
<th>Tilaaja</th><td><th>Kuvaus</th><td><th>Jättöpvm</th></td><td><th>Kustannusarvio</th></td><td><th>Vastaamispvm</th></td><td><th>Status</th></td> </head>
<?php 

$tunnus = $_SESSION["tunnus"];
$tquery1 = "SELECT * FROM tarjouspyynnot WHERE tarjouspyynnot.tunnus = '$tunnus'";
$ttulos1 = mysqli_query($db, $tquery1);
while ($trivi1 = mysqli_fetch_array($ttulos1, MYSQL_ASSOC)) { 
  $tavain1 = $trivi1["id"];
  $ttilaaja1 = $trivi1["tilaaja"];
  $tkuvaus1 = $trivi1["kuvaus"];
  $tjattopvm1 = $trivi1["jattopvm"];
  $tkustannusarvio1 = $trivi1["kustannusarvio"];
  $tvastaamispvm1 = $trivi1["vastaamispvm"];
  $tstatus1 = $trivi1["status"];


		?> <tr><td width="120"> <?php echo $tilaajannimi2; ?></td><td></td><td width="250"><?php echo $tkuvaus1; ?>
		</td><td></td><td width="100"><?php if ($tjattopvm1 != NULL) { echo date ('d.m.Y', strtotime($tjattopvm1)); } ?></td><td></td><td width="150">
		<?php echo $tkustannusarvio1; ?></td><td></td><td width="100"><?php if ($tvastaamispvm1 != NULL) { echo date ('d.m.Y', strtotime($tvastaamispvm1)); }
		?></td><td></td><td width="70"> <span style="color:green;">
		<?php echo $tstatus1; ?></td><td></td><td>
 <form action="tarjouspyynnot.php" method="post">
<div class="input-group">
<input type="submit" name="mtarjous" value="Muokkaa">
<input type="submit" name="ptarjous" value="Poista">
<input type="submit" name="htarjous" value="Hyväksy tarjouspyyntö">
<input type="submit" name="hylktarjous" value="Hylkää tarjouspyyntö">
 <?php
echo "<td>" . "<input type=hidden name=thidden value=$tavain1>"; 
echo "</div>";
echo "</form>";
  }

?>
</table>

<p></p>
 <form method="post" action="tarjouspyynnot.php">
	<div class="input-group">
  	  <button type="submit" class="btn" name="utarjous">Uusi tarjouspyyntö</button>
  	</div>
<?php if(isset($_POST['utarjous'])) { ?>
<div class="input-group"><br>
Kuvaus työstä:
<input type="text" name="tkuvaus2" size="60" value="<?php ?>"><br>
<button type="submit" class="btn" name="ttallenna2">Tallenna tarjouspyyntö</button>
<button type="submit" class="btn" name="tkumoa2">Kumoa</button>
 </div></form>
<?php	   
}
if(isset($_POST['ttallenna2']))
{ 
$tkuvaus2 = mysqli_real_escape_string($db, $_POST['tkuvaus2']);

$tunnus = $_SESSION["tunnus"];
$tquery2 = "INSERT INTO tarjouspyynnot (tunnus, tilaaja, kuvaus, jattopvm, status)
			VALUES ('$tunnus', '$tilaajannimi2', '$tkuvaus2', CURDATE(), 'jätetty')";
mysqli_query($db, $tquery2);
header('location: tarjouspyynnot.php');

}
if(isset($_POST['tkumoa2'])) {
   header("Location: tarjouspyynnot.php");
}
if(isset($_POST['mtarjous'])) { 
// Ensiksi query jotta saadaan kenttiin vanhat tiedot
$tquery3 = "SELECT * FROM tarjouspyynnot WHERE id ='$_POST[thidden]'";
$ttulos3 = mysqli_query($db, $tquery3);

while ($trivi3 = mysqli_fetch_array($ttulos3, MYSQL_ASSOC)) { 
  $tavain3 = $trivi3["id"];
  $ttilaaja3 = $trivi3["tilaaja"];
  $tkuvaus3 = $trivi3["kuvaus"];
  $tjattopvm3 = $trivi3["jattopvm"];
  $tkustannusarvio3 = $trivi3["kustannusarvio"];
  $tvastaamispvm3 = $trivi3["vastaamispvm"];
  $tstatus3 = $trivi3["status"];
}
// SALLITAAN KÄYTTÄJÄN POISTAA VAIN VASTAAMATTOMAT TARJOUSPYYNNÖT
if(strcasecmp($tstatus3, "jätetty") != 0)
{
echo "<br>Voit muuttaa tarjouspyyntöä vain jos sen status on jätetty.";
exit();
}

 ?>

<p></p>
 <form method="post" action="tarjouspyynnot.php">
<div class="input-group"><br>

Kuvaus
<input type="text" name="tkuvaus4" size="60" value="<?php echo $tkuvaus3; ?>"><br>

<input type="hidden" name="thiddenid" value="<?php echo $tavain3; ?>"><br>
<button type="submit" class="btn" name="ttallenna4">Tallenna tarjous</button>
<button type="submit" class="btn" name="tkumoa4">Kumoa</button>
 </div></form>


<?php	   
}
if(isset($_POST['ttallenna4']))
{ 
$thiddenid = mysqli_real_escape_string($db, $_POST['thiddenid']);
$tkuvaus4 = mysqli_real_escape_string($db, $_POST['tkuvaus4']);

$tunnus = $_SESSION["tunnus"];
$tquery3 = "UPDATE tarjouspyynnot SET kuvaus = '$tkuvaus4',
			jattopvm = CURDATE()
			WHERE tarjouspyynnot.id = '$thiddenid'";
mysqli_query($db, $tquery3);
header('location: tarjouspyynnot.php');

}
if(isset($_POST['tkumoa4'])) {
   header("Location: tarjouspyynnot.php");
}


if(isset($_POST['ptarjous'])) { 
$pquery4 = "SELECT * FROM tarjouspyynnot WHERE tarjouspyynnot.id ='$_POST[thidden]'";
$ptulos4 = mysqli_query($db, $pquery4);

while ($privi4 = mysqli_fetch_array($ptulos4, MYSQL_ASSOC)) { 
  $pavain4 = $privi4["id"];
  $pstatus4 = $privi4["status"];
}
// SALLITAAN KÄYTTÄJÄN POISTAA VAIN VASTAAMATTOMAT TARJOUSPYYNNÖT
if(strcasecmp($pstatus4, "jätetty") == 0)
{

$pquery5 = "DELETE FROM tarjouspyynnot WHERE tarjouspyynnot.id ='$_POST[thidden]'";

$ptulos5 = mysqli_query($db, $pquery5);
header("Location: tarjouspyynnot.php");
}
else {
echo "<br>Tarjouspyyntöä ei voi enää poistaa, sillä sen status on jokin muu kuin jätetty.";
}
}

if(isset($_POST['htarjous'])) { 
$pquery6 = "SELECT * FROM tarjouspyynnot WHERE tarjouspyynnot.id ='$_POST[thidden]'";
$ptulos6 = mysqli_query($db, $pquery6);

while ($privi6 = mysqli_fetch_array($ptulos6, MYSQL_ASSOC)) { 
  $pavain6 = $privi6["id"];
  $pstatus6 = $privi6["status"];
  
  $ptilaaja6 = $privi6["tilaaja"];
  $pkuvaus6 = $privi6["kuvaus"];
  $pjattopvm6 = $privi6["jattopvm"];
  $pkustannusarvio6 = $privi6["kustannusarvio"];
  $pvastaamispvm6 = $privi6["vastaamispvm"];
}
// Sallitaan käyttäjän hyväksyä vain "vastattu" -statuksella oleva tarjouspyyntö
if(strcasecmp($pstatus6, "VASTATTU") == 0)
{
$tunnus = $_SESSION["tunnus"];
$pquery7 = "UPDATE tarjouspyynnot SET status = 'HYVÄKSYTTY' 
			WHERE tarjouspyynnot.id ='$_POST[thidden]'";
// Hyväksytystä tarjouspyynnöstä lähtee työ
$pquery8 = "INSERT INTO tilaustiedot (tunnus, tilaaja, kuvaus, hyvaksymispvm, status)
			VALUES ('$tunnus', '$ptilaaja6', '$pkuvaus6', CURDATE(), 'TILATTU')";
$ptulos7 = mysqli_query($db, $pquery7);
$ptulos8 = mysqli_query($db, $pquery8);
header("Location: tarjouspyynnot.php");
}
else {
echo "<br>Tilausta ei voi hyväksyä, sillä sen status on jokin muu kuin VASTATTU";
}
}
if(isset($_POST['hylktarjous'])) { 
$pquery9 = "SELECT * FROM tarjouspyynnot WHERE tarjouspyynnot.id ='$_POST[thidden]'";
$ptulos9 = mysqli_query($db, $pquery9);

while ($privi9 = mysqli_fetch_array($ptulos9, MYSQL_ASSOC)) { 
  $pavain9 = $privi9["id"];
  $pstatus9 = $privi9["status"];
}
// Sallitaan käyttäjän hylätä vain "vastattu" -statuksella oleva tarjouspyyntö
if(strcasecmp($pstatus9, "VASTATTU") == 0)
{
$tunnus = $_SESSION["tunnus"];
$pquery10 = "UPDATE tarjouspyynnot SET status = 'HYLÄTTY' 
			WHERE tarjouspyynnot.id ='$_POST[thidden]'";
$ptulos10 = mysqli_query($db, $pquery10);

header("Location: tarjouspyynnot.php");
}
else {
echo "<br>Tilausta ei voi hylätä, sillä sen status on jokin muu kuin VASTATTU";
}
}
?>

<p>
  		<a href="tyotilaukset.php">Työtilauksiin</a>
  	</p>
</div>
		
</body>
</html>