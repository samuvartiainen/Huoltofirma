<?php 
include('server.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Kiinteistöhuoltofirman käyttämä sovellus, jonka avulla asiakkaiden työtilauksia voidaan hallita.</title>
<link rel="stylesheet" type="text/css" href="style.css">
<div class="header">
<h3>Tarjouspyyntöjen hakuehdot:</h3>
</div>
</head>
<body>
<form method="post" action="huoltofirman_tarjouspyynnot.php">
<div class="input-group">
Asiakas: <input type="text" name="tasiakas" value="<?php ?>"/>  <td><?php // Haetaan asiakkaan oikealla nimellä, ei käyttäjätunnuksella. ?>
<br />
Status: <input type="text" name="tstatus" value="<?php ?>"/><td> <?php // jätetty -status toimii vain pienellä kirjoitettuna, tietokanta on outo ään kanssa. ?>
<br />			
Jättöpvm: <input type="text" name="tjattopvm" value="<?php ?>"/><td> <?php // Haetaan annetun jättöpäivän jälkeisiä tarjouspyyntöjä. ?>
<br />		
<input type="submit" name="haetarj" value="Hae" />
</form>

</div>
<div class="content">
<table>
<thead>
<thead align="left">
<tr>
<th>ID</th><td><th>Tunnus</th><td><th>Tilaaja</th><td><th>Kuvaus</th></td><td><th>Jättöpvm</th></td>
<td><th>Kustannusarvio</th></td><td><th>Vastaamispvm</th></td><td><th>Status </td></tr></th> </head> <tr><td>

<?php 
// KAIKKIEN HAKUKOMBINAATIOIDEN LUONTI

if(isset($_POST["tasiakas"])){
	$tasiakas = $_POST["tasiakas"];
	} else
	$tasiakas = "";
	if(isset($_POST["tstatus"])){
	$tstatus = $_POST["tstatus"];
	}
	else $tstatus ="";
	if(isset($_POST["tjattopvm"])){
	$tjattopvm = date('Y-m-d', strtotime($_POST["tjattopvm"]));
	}
	else{
	$tjattopvm="";
	}
	
	$tquery = "Select * from tarjouspyynnot";
	$tquery4 = "Select * from tarjouspyynnot WHERE tilaaja = '$tasiakas'";
	$tquery5 = "Select * from tarjouspyynnot WHERE STATUS = '$tstatus'";
	$tquery6 = "Select * from tarjouspyynnot WHERE jattopvm >= '$tjattopvm'";
	$tquery7 = "Select * from tarjouspyynnot WHERE tilaaja = '$tasiakas' AND STATUS = '$tstatus'";
	$tquery8 = "Select * from tarjouspyynnot WHERE tilaaja = '$tasiakas' AND jattopvm >= '$tjattopvm'";
	$tquery9 = "Select * from tarjouspyynnot WHERE STATUS = '$tstatus' AND jattopvm >= '$tjattopvm'";
	$tquery10 = "Select * from tarjouspyynnot WHERE tilaaja = '$tasiakas' AND STATUS = '$tstatus' AND jattopvm >= '$tjattopvm'";
	
	
	// suoritetaan kyselyt
	$ttulos = mysqli_query($db, $tquery);
	$ttulos4 = mysqli_query($db, $tquery4);
	$ttulos5 = mysqli_query($db, $tquery5);
	$ttulos6 = mysqli_query($db, $tquery6);
	$ttulos7 = mysqli_query($db, $tquery7);
	$ttulos8 = mysqli_query($db, $tquery8);
	$ttulos9 = mysqli_query($db, $tquery9);
	$ttulos10 = mysqli_query($db, $tquery10);
	// Tarkistetaan onnistuiko kysely (oliko kyselyn syntaksi oikein)
	if ( !$ttulos || !$ttulos4 || !$ttulos5 || !$ttulos6 || !$ttulos7 || !$ttulos8 || !$ttulos9 || !$ttulos10 )
	{
		echo "Kysely epäonnistui " . mysqli_error($db);
	}
	if(isset($_POST["haetarj"]))
	{
	if (isset($_POST["tasiakas"]))
	{
	$trivit4 = array();
	while ($trivi4 = mysqli_fetch_assoc($ttulos4)){
	$trivit4[] = $trivi4;
	}
	}
	if(isset($_POST["tstatus"])){
	$trivit5 = array();
	while ($trivi5 = mysqli_fetch_assoc($ttulos5)){
	$trivit5[] = $trivi5;
	}
	}
	
	if(isset($_POST["tjattopvm"])){
	$trivit6 = array();
	while ($trivi6 = mysqli_fetch_assoc($ttulos6)){
	$trivit6[] = $trivi6;
	}
	}
	
	if (empty($_POST["tasiakas"]) && empty($_POST["tstatus"]) && empty($_POST["tjattopvm"]))
	{	
	$trivit3 = array(); 
	while ($trivi3 = mysqli_fetch_array($ttulos, MYSQL_ASSOC)) 
	{

	$trivit3[] = $trivi3;
	}
	foreach($trivit3 as $trivi3)
	{ 
	?> <tr><td width="11"> <?php echo $trivi3["id"]; ?></td><td></td><td width="60"> <?php echo $trivi3["tunnus"]; ?></td><td></td><td width="80"><?php echo $trivi3["tilaaja"]; ?>
	</td><td></td><td width="150"><?php echo $trivi3["kuvaus"]; ?></td><td></td><td width="70">
	<?php if($trivi3["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi3["jattopvm"])); }?></td><td></td><td width="100"><?php echo $trivi3["kustannusarvio"]; ?>
	</td><td></td><td width="70"><?php if ($trivi3["vastaamispvm"] != NULL) { echo date ('d.m.Y', strtotime($trivi3["vastaamispvm"])); }?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $trivi3["status"] ?> </span> </td><td></td><td>
	<form action="huoltofirman_tarjouspyynnot.php" method="post">
	<div class="input-group">
	<input type="submit" name="tvastaa" value="Vastaa tarjouspyyntöön">	<?php
	echo "<td>" . "<input type=hidden name=hidden4 value=$trivi3[id]>";
	echo "</div>";
	echo "</form>";
	}
	echo "</tr>";
	echo "</td>";
	} 
	
	
	
	elseif (isset($_POST["tasiakas"]) && empty($_POST["tstatus"]) && empty($_POST["tjattopvm"]))
	{ 
	foreach($trivit4 as $trivi4)
	{ 
	?> <tr><td width="11"> <?php echo $trivi4["id"]; ?></td><td></td><td width="60"> <?php echo $trivi4["tunnus"]; ?></td><td></td><td width="80"><?php echo $trivi4["tilaaja"]; ?>
	</td><td></td><td width="150"><?php echo $trivi4["kuvaus"]; ?></td><td></td><td width="70">
	<?php if($trivi4["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi4["jattopvm"])); }?></td><td></td><td width="100"><?php echo $trivi4["kustannusarvio"]; ?>
	</td><td></td><td width="70"><?php if ($trivi4["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi4["vastaamispvm"])); }?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $trivi4["status"] ?> </span> </td><td></td><td>
	<form action="huoltofirman_tarjouspyynnot.php" method="post">
	<div class="input-group">
	<input type="submit" name="tvastaa" value="Vastaa tarjouspyyntöön">	<?php
	echo "<td>" . "<input type=hidden name=hidden4 value=$trivi4[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	
	elseif (empty($_POST["tasiakas"]) && isset($_POST["tstatus"]) && empty($_POST["tjattopvm"]))
	{
	foreach($trivit5 as $trivi5)
	{ 
	?> <tr><td width="11"> <?php echo $trivi5["id"]; ?></td><td></td><td width="60"> <?php echo $trivi5["tunnus"]; ?></td><td></td><td width="80"><?php echo $trivi5["tilaaja"]; ?>
	</td><td></td><td width="150"><?php echo $trivi5["kuvaus"]; ?></td><td></td><td width="70">
	<?php if ($trivi5["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi5["jattopvm"])); }?></td><td></td><td width="100"><?php echo $trivi5["kustannusarvio"]; ?>
	</td><td></td><td width="70"><?php if ($trivi5["vastaamispvm"] != NULL) { echo date ('d.m.Y', strtotime($trivi5["vastaamispvm"])); }?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $trivi5["status"] ?> </span> </td><td></td><td>
	<form action="huoltofirman_tarjouspyynnot.php" method="post">
	<div class="input-group">
	<input type="submit" name="tvastaa" value="Vastaa tarjouspyyntöön">	<?php
	echo "<td>" . "<input type=hidden name=hidden4 value=$trivi5[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	
	elseif (empty($_POST["tasiakas"]) && empty($_POST["tstatus"]) && isset($_POST["tjattopvm"]))
	{
	foreach($trivit6 as $trivi6)
	{ 
	?> <tr><td width="11"> <?php echo $trivi6["id"]; ?></td><td></td><td width="60"> <?php echo $trivi6["tunnus"]; ?></td><td></td><td width="80"><?php echo $trivi6["tilaaja"]; ?>
	</td><td></td><td width="150"><?php echo $trivi6["kuvaus"]; ?></td><td></td><td width="70">
	<?php if ($trivi6["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi6["jattopvm"])); }?></td><td></td><td width="100"><?php echo $trivi6["kustannusarvio"]; ?>
	</td><td></td><td width="70"><?php if($trivi6["vastaamispvm"] != NULL) { echo date ('d.m.Y', strtotime($trivi6["vastaamispvm"])); }?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $trivi6["status"] ?> </span> </td><td></td><td>
	<form action="huoltofirman_tarjouspyynnot.php" method="post">
	<div class="input-group">
	<input type="submit" name="tvastaa" value="Vastaa tarjouspyyntöön">	<?php
	echo "<td>" . "<input type=hidden name=hidden4 value=$trivi6[id]>";
	echo "</div>";
	echo "</form>";
	}
	}

	elseif (isset($_POST["tasiakas"]) && isset($_POST["tstatus"]) && empty($_POST["tjattopvm"]))
	{
	$trivit7 = array();
	while ($trivi7 = mysqli_fetch_assoc($ttulos7)){
	$trivit7[] = $trivi7;
	}
	foreach($trivit7 as $trivi7)
	{ 
	?> <tr><td width="11"> <?php echo $trivi7["id"]; ?></td><td></td><td width="60"> <?php echo $trivi7["tunnus"]; ?></td><td></td><td width="80"><?php echo $trivi7["tilaaja"]; ?>
	</td><td></td><td width="150"><?php echo $trivi7["kuvaus"]; ?></td><td></td><td width="70">
	<?php if($trivi7["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi7["jattopvm"])); }?></td><td></td><td width="100"><?php echo $trivi7["kustannusarvio"]; ?>
	</td><td></td><td width="70"><?php if($trivi7["vastaamispvm"] != NULL) { echo date('d.m.Y', strtotime($trivi7["vastaamispvm"])); }?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $trivi7["status"] ?> </span> </td><td></td><td>
	<form action="huoltofirman_tarjouspyynnot.php" method="post">
	<div class="input-group">
	<input type="submit" name="tvastaa" value="Vastaa tarjouspyyntöön">	<?php
	echo "<td>" . "<input type=hidden name=hidden4 value=$trivi7[id]>";
	echo "</div>";
	echo "</form>";
	}
		
	}

	elseif (isset($_POST["tasiakas"]) && empty($_POST["tstatus"]) && isset($_POST["tjattopvm"]))
	{
	$trivit8 = array();
	while ($trivi8 = mysqli_fetch_assoc($ttulos8)){
	$trivit8[] = $trivi8;
	}
	foreach($trivit8 as $trivi8)
	{ 
	?> <tr><td width="11"> <?php echo $trivi8["id"]; ?></td><td></td><td width="60"> <?php echo $trivi8["tunnus"]; ?></td><td></td><td width="80"><?php echo $trivi8["tilaaja"]; ?>
	</td><td></td><td width="150"><?php echo $trivi8["kuvaus"]; ?></td><td></td><td width="70">
	<?php if ($trivi8["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi8["jattopvm"])); }?></td><td></td><td width="100"><?php echo $trivi8["kustannusarvio"]; ?>
	</td><td></td><td width="70"><?php if ($trivi8["vastaamispvm"] != NULL) { echo date('d.m.Y', strtotime($trivi8["vastaamispvm"])); }?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $trivi8["status"] ?> </span> </td><td></td><td>
	<form action="huoltofirman_tarjouspyynnot.php" method="post">
	<div class="input-group">
	<input type="submit" name="tvastaa" value="Vastaa tarjouspyyntöön">	<?php
	echo "<td>" . "<input type=hidden name=hidden4 value=$trivi8[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	
	elseif (empty($_POST["tasiakas"]) && isset($_POST["tstatus"]) && isset($_POST["tjattopvm"]))
	{
	$trivit9 = array();
	while ($trivi9 = mysqli_fetch_assoc($ttulos9)){
	$trivit9[] = $trivi9;
	}
	foreach($trivit9 as $trivi9)
	{ 
	?> <tr><td width="11"> <?php echo $trivi9["id"]; ?></td><td></td><td width="60"> <?php echo $trivi9["tunnus"]; ?></td><td></td><td width="80"><?php echo $trivi9["tilaaja"]; ?>
	</td><td></td><td width="150"><?php echo $trivi9["kuvaus"]; ?></td><td></td><td width="70">
	<?php if($trivi9["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi9["jattopvm"])); }?></td><td></td><td width="100"><?php echo $trivi9["kustannusarvio"]; ?>
	</td><td></td><td width="70"><?php if($trivi9["vastaamispvm"] != NULL) { echo date('d.m.Y', strtotime($trivi9["vastaamispvm"])); }?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $trivi9["status"] ?> </span> </td><td></td><td>
	<form action="huoltofirman_tarjouspyynnot.php" method="post">
	<div class="input-group">
	<input type="submit" name="tvastaa" value="Vastaa tarjouspyyntöön">	<?php
	echo "<td>" . "<input type=hidden name=hidden4 value=$trivi9[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	
	elseif (isset($_POST["tasiakas"]) && isset($_POST["tstatus"]) && isset($_POST["tjattopvm"]))
	{
	$trivit10 = array();
	while ($trivi10 = mysqli_fetch_assoc($ttulos10)){
	$trivit10[] = $trivi10;
	}
	foreach($trivit10 as $trivi10)
	{ 
	?> <tr><td width="11"> <?php echo $trivi10["id"]; ?></td><td></td><td width="60"> <?php echo $trivi10["tunnus"]; ?></td><td></td><td width="80"><?php echo $trivi10["tilaaja"]; ?>
	</td><td></td><td width="150"><?php echo $trivi10["kuvaus"]; ?></td><td></td><td width="70">
	<?php if($trivi10["jattopvm"] != NULL) { echo date('d.m.Y', strtotime($trivi10["jattopvm"])); }?></td><td></td><td width="100"><?php echo $trivi10["kustannusarvio"]; ?>
	</td><td></td><td width="70"><?php if ($trivi10["vastaamispvm"] != NULL) { echo date('d.m.Y', strtotime($trivi10["vastaamispvm"])); }?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $trivi10["status"] ?> </span> </td><td></td><td>
	<form action="huoltofirman_tarjouspyynnot.php" method="post">
	<div class="input-group">
	<input type="submit" name="tvastaa" value="Vastaa tarjouspyyntöön">	<?php
	echo "<td>" . "<input type=hidden name=hidden4 value=$trivi10[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	} 
?> </tr></table> <?php

// VASTAA TARJOUSPYYNTÖÖN -PAINIKE

if(isset($_POST['tvastaa'])) 
{ 
$vquery1 = "SELECT * FROM tarjouspyynnot WHERE id = '$_POST[hidden4]'";
$vtulos1 = mysqli_query($db, $vquery1);


while ($vrivi1 = mysqli_fetch_array($vtulos1, MYSQL_ASSOC)) { 
  $vkustannusarvio1 = $vrivi1["kustannusarvio"];
  $vavain1 = $vrivi1["id"];
  
?>

<form action="huoltofirman_tarjouspyynnot.php" method="post">
<div class="input-group">
Kustannusarvio: <input type="text" name="vkustannusarvio2"  size="50" value="<?php  ?>">
<input type="hidden" name="vhidden4" value="<?php echo $_POST["hidden4"]; ?>"><br>
<button type="submit" name="vtallenna2">Tallenna vastaus</button>
<button type="submit" name="vkumoa2">Kumoa</button>
<?php 
}
}

if(isset($_POST['vtallenna2']))
{ 
$vhidden4 = mysqli_real_escape_string($db, $_POST['vhidden4']);
$vkustannusarvio2 = mysqli_real_escape_string($db, $_POST['vkustannusarvio2']);

$vquery2= "UPDATE tarjouspyynnot SET kustannusarvio = '$vkustannusarvio2',
			vastaamispvm = CURDATE(), status = 'VASTATTU'
			where tarjouspyynnot.id = '$vhidden4'";
mysqli_query($db, $vquery2);

header("Location: huoltofirman_tarjouspyynnot.php");
}
if(isset($_POST['vkumoa2'])) {
   header("Location: huoltofirman_tarjouspyynnot.php");
	
}



?>
</table>
<p><br>
<a href="kiinteistohuoltofirma.php">Työtilaukset sivulle</a><p></br>
</div>
</form>
	
</body>
</html>