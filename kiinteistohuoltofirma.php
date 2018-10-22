<?php 
include('server.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Kiinteistöhuoltofirman käyttämä sovellus, jonka avulla asiakkaiden työtilauksia voidaan hallita.</title>
<link rel="stylesheet" type="text/css" href="style.css">
<div class="header">
<h3>Työtilausten hakuehdot:</h3>
</div>
</head>
<body>
<form method="post" action="kiinteistohuoltofirma.php">
<div class="input-group">
Asiakas: <input type="text" name="haeasiakas" value="<?php ?>"/>
<br />
Status: <input type="text" name="haestatus" value="<?php ?>"/>
<input type="checkbox" name="hylatyt[]" id="hylatyt" value="hylatyt">Näytä vain hylätyt
<br />

Tilauspvm: <input type="text" name="haetilauspvm" value="<?php ?>" />
<br />		
<input type="submit" name="haetilaukset" value="Hae" />
</form>
</div>
<div class="content">
 <table>
<thead>
<thead align="left">
<tr>
<th>Tunnus</th><td><th>Tilaaja</th><td><th>Työn kuvaus</th><td><th>Tilauspvm</th></td><td><th>Aloituspvm</th></td><td><th>Valmistumispvm</th></td><td><th>Hyväksymispvm</th></td><td><th>Vapaamuotoinen kommentti <br> kuluneista tarvikkeista</th></td><td><th>Työtunnit</th></td><td><th>Kuluneet työtarvikkeet</th></td><td><th>Kustannusarvio</th></td><td><th>STATUS</th></td><td><th>Muokkaus napit!</td></tr></th> </head> <tr><td>

<?php 
	// KAIKKIEN HAKUKOMBINAATIOIDEN LUONTI
	if(isset($_POST["haeasiakas"])){
	$haeasiakas = $_POST["haeasiakas"];
	} else
	$haeasiakas = "";
	if(isset($_POST["haestatus"])){
	$haestatus = $_POST["haestatus"];
	}
	else $haestatus ="";
	if(isset($_POST["haetilauspvm"])){
	$haetilauspvm = date('Y-m-d', strtotime($_POST["haetilauspvm"]));
	}
	else{
	$haetilauspvm="";
	}
	
	$hquery = "Select * from tilaustiedot";
	$hquery4 = "Select * from tilaustiedot WHERE tilaaja = '$haeasiakas'";
	$hquery5 = "Select * from tilaustiedot WHERE status = '$haestatus'";
	$hquery6 = "Select * from tilaustiedot WHERE tilauspvm >= '$haetilauspvm'";
	$hquery7 = "Select * from tilaustiedot WHERE tilaaja = '$haeasiakas' AND status = '$haestatus'";
	$hquery8 = "Select * from tilaustiedot WHERE tilaaja = '$haeasiakas' AND tilauspvm >= '$haetilauspvm'";
	$hquery9 = "Select * from tilaustiedot WHERE status = '$haestatus' AND tilauspvm >= '$haetilauspvm'";
	$hquery10 = "Select * from tilaustiedot WHERE tilaaja = '$haeasiakas' AND status = '$haestatus' AND tilauspvm >= '$haetilauspvm'";
	$hquery11 = "Select * from tilaustiedot WHERE status = 'HYLÄTTY'";
	
	// suoritetaan kyselyt
	$htulos = mysqli_query($db, $hquery);
	$htulos4 = mysqli_query($db, $hquery4);
	$htulos5 = mysqli_query($db, $hquery5);
	$htulos6 = mysqli_query($db, $hquery6);
	$htulos7 = mysqli_query($db, $hquery7);
	$htulos8 = mysqli_query($db, $hquery8);
	$htulos9 = mysqli_query($db, $hquery9);
	$htulos10 = mysqli_query($db, $hquery10);
	$htulos11 = mysqli_query($db, $hquery11);
	// Tarkistetaan onnistuiko kysely (oliko kyselyn syntaksi oikein)
	if ( !$htulos || !$htulos4 || !$htulos5 || !$htulos6 || !$htulos7 || !$htulos8 || !$htulos9 || !$htulos10 )
	{
		echo "Kysely epäonnistui " . mysqli_error($db);
	}
	if(isset($_POST["haetilaukset"]))
	{	// HYLÄTYT VALINTA
		if(isset($_POST["hylatyt"]))
		{
			$rivit11 = array(); 
		while ($rivi11 = mysqli_fetch_array($htulos11, MYSQL_ASSOC)) 
		{
			$rivit11[] = $rivi11;
		}
		
		// if ($rivi11[""] != NULL) { echo date('d.m.Y', strtotime(
	foreach($rivit11 as $rivi11)
	{ 
	?> <tr><td width="90"> <?php echo $rivi11["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi11["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi11["kuvaus"]; ?>
	</td><td></td><td width="70"><?php echo date ('d.m.Y', strtotime ($rivi11["tilauspvm"])); ?></td><td></td><td width="70">
	<?php if ($rivi11["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime($rivi11["aloituspvm"])); }?></td><td></td><td width="70"><?php if ($rivi11["valmistumispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi11["valmistumispvm"])); }?>
	</td><td></td><td width="70"><?php if ($rivi11["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi11["hyvaksymispvm"])); }?></td><td></td><td width="300">
	<?php echo $rivi11["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi11["tyotunnit"]; ?></td><td>
	</td><td width="200"><?php echo $rivi11["tarvikkeet"]; ?></td><td></td><td width="200">
	<?php echo $rivi11["kustannusarvio"]; ?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $rivi11["status"] ?> </span> </td><td></td><td>
	<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta">
<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus">	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi11[id]>";
	echo "</div>";
	echo "</form>";
	}
	
		}
		
	elseif(!isset($_POST["hylatyt"]))
	{
	if (isset($_POST["haeasiakas"]))
	{
	$rivit4 = array();
	while ($rivi4 = mysqli_fetch_assoc($htulos4)){
	$rivit4[] = $rivi4;
	}
	}
	if(isset($_POST["haestatus"])){
	$rivit5 = array();
	while ($rivi5 = mysqli_fetch_assoc($htulos5)){
	$rivit5[] = $rivi5;
	}
	}
	
	if(isset($_POST["haetilauspvm"])){
	$rivit6 = array();
	while ($rivi6 = mysqli_fetch_assoc($htulos6)){
	$rivit6[] = $rivi6;
	}
	}
	
	if (empty($_POST["haeasiakas"]) && empty($_POST["haestatus"]) && empty($_POST["haetilauspvm"]))
	{	
	$rivit3 = array(); 
	while ($rivi3 = mysqli_fetch_array($htulos, MYSQL_ASSOC)) 
	{

	$rivit3[] = $rivi3;
	}
	foreach($rivit3 as $rivi3)
	{ 
	if(strcasecmp($rivi3["status"], "HYLÄTTY") != 0) {
	?> <tr><td width="90"> <?php echo $rivi3["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi3["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi3["kuvaus"]; ?>
	</td><td></td><td width="70"><?php echo date ('d.m.Y', strtotime($rivi3["tilauspvm"])); ?></td><td></td><td width="70">
	<?php if ( $rivi3["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime($rivi3["aloituspvm"])); } ?></td><td></td><td width="70"><?php if ($rivi3["valmistumispvm"] != NULL ) { echo date ('d.m.Y', strtotime($rivi3["valmistumispvm"])); }?>
	</td><td></td><td width="70"><?php if ($rivi3["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi3["hyvaksymispvm"])); }?></td><td></td><td width="300">
	<?php echo $rivi3["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi3["tyotunnit"]; ?></td><td>
	</td><td width="200"><?php echo $rivi3["tarvikkeet"]; ?></td><td></td><td width="200">
	<?php echo $rivi3["kustannusarvio"]; ?></td><td></td><td width="70">
	<span style="color:green;"><?php echo $rivi3["status"] ?> </span> </td><td></td><td>
	<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta">
<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus">	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi3[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	echo "</tr>";
	echo "</td>";
	} 
	

	
	elseif (isset($_POST["haeasiakas"]) && empty($_POST["haestatus"]) && empty($_POST["haetilauspvm"]))
	{ 
	foreach($rivit4 as $rivi4)
	{ 
	if(strcasecmp($rivi4["status"], "HYLÄTTY") != 0) {?>
	<tr><td width="120"> <?php echo $rivi4["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi4["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi4["kuvaus"]; ?>
	</td><td></td><td width="70"><?php echo date ('d.m.Y', strtotime($rivi4["tilauspvm"])); ?></td><td></td><td width="70">
		<?php if ($rivi4["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime($rivi4["aloituspvm"])); } ?></td><td></td><td width="70"><?php 
		if ($rivi4["valmistumispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi4["valmistumispvm"])); } ?>
		</td><td></td><td width="70"><?php if ($rivi4["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi4["hyvaksymispvm"])); }?></td><td></td><td width="350">
		<?php echo $rivi4["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi4["tyotunnit"]; ?></td><td>
		</td><td width="200"><?php echo $rivi4["tarvikkeet"]; ?></td><td></td><td width="200">
		<?php echo $rivi4["kustannusarvio"]; ?></td><td></td><td width="70">
		<span style="color:green;"><?php echo $rivi4["status"]; ?> </span> </td><td></td><td>
		<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta">
<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus">	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi4[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	}
	
	elseif (empty($_POST["haeasiakas"]) && isset($_POST["haestatus"]) && empty($_POST["haetilauspvm"]))
	{
	foreach($rivit5 as $rivi5)
	{
	if(strcasecmp($rivi5["status"], "HYLÄTTY") != 0) {		?>
	<tr><td width="120"> <?php echo $rivi5["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi5["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi5["kuvaus"]; ?>
	</td><td></td><td width="70"><?php echo date('d.m.Y', strtotime($rivi5["tilauspvm"])); ?></td><td></td><td width="70">
		<?php if ($rivi5["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime( $rivi5["aloituspvm"])); }?></td><td></td><td width="70"><?php if ($rivi5["valmistumispvm"] != NULL) { echo date('d.m.Y', strtotime( $rivi5["valmistumispvm"])); }?>
		</td><td></td><td width="70"><?php if ($rivi5["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi5["hyvaksymispvm"])); }?></td><td></td><td width="350">
		<?php echo $rivi5["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi5["tyotunnit"]; ?></td><td>
		</td><td width="200"><?php echo $rivi5["tarvikkeet"]; ?></td><td></td><td width="200">
		<?php echo $rivi5["kustannusarvio"]; ?></td><td></td><td width="70">
		<span style="color:green;"><?php echo $rivi5["status"]; ?> </span> </td><td></td><td>
		<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta">
<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus">  	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi5[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	}
	
	elseif (empty($_POST["haeasiakas"]) && empty($_POST["haestatus"]) && isset($_POST["haetilauspvm"]))
	{
	foreach($rivit6 as $rivi6)
	{ 
	if(strcasecmp($rivi6["status"], "HYLÄTTY") != 0) { ?>
	<tr><td width="120"> <?php echo $rivi6["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi6["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi6["kuvaus"]; ?>
	</td><td></td><td width="70"><?php echo date('d.m.Y', strtotime($rivi6["tilauspvm"])); ?></td><td></td><td width="70">
		<?php if ($rivi6["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime( $rivi6["aloituspvm"])); }?></td><td></td><td width="70"><?php if ($rivi6["valmistumispvm"] != NULL) { echo date('d.m.Y', strtotime( $rivi6["valmistumispvm"])); }?>
		</td><td></td><td width="70"><?php if ($rivi6["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime( $rivi6["hyvaksymispvm"])); }?></td><td></td><td width="350">
		<?php echo $rivi6["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi6["tyotunnit"]; ?></td><td>
		</td><td width="200"><?php echo $rivi5["tarvikkeet"]; ?></td><td></td><td width="200">
		<?php echo $rivi6["kustannusarvio"]; ?></td><td></td><td width="70">
		<span style="color:green;"><?php echo $rivi6["status"]; ?> </span> </td><td></td><td>
		<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta">
<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus"> 	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi6[id]>";
	echo "</div>";
	echo "</form>";
	}
	}
	}
	
	elseif (isset($_POST["haeasiakas"]) && isset($_POST["haestatus"]) &&  empty($_POST["haetilauspvm"]))
	{
	$rivit7 = array();
	while ($rivi7 = mysqli_fetch_assoc($htulos7)){
	$rivit7[] = $rivi7;
	}
	foreach($rivit7 as $rivi7)
	{ 
	if(strcasecmp($rivi7["status"], "HYLÄTTY") != 0) { ?>
		<tr><td width="120"> <?php echo $rivi7["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi7["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi7["kuvaus"]; ?>
		</td><td></td><td width="70"><?php echo date ('d.m.Y', strtotime($rivi7["tilauspvm"])); ?></td><td></td><td width="70">
		<?php if ($rivi7["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime( $rivi7["aloituspvm"])); } ?></td><td></td><td width="70"><?php if ($rivi7["valmistumispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi7["valmistumispvm"])); }?>
		</td><td></td><td width="70"><?php if ($rivi7["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi7["hyvaksymispvm"])); }?></td><td></td><td width="350">
		<?php echo $rivi7["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi7["tyotunnit"]; ?></td><td>
		</td><td width="200"><?php echo $rivi7["tarvikkeet"]; ?></td><td></td><td width="200">
		<?php echo $rivi7["kustannusarvio"]; ?></td><td></td><td width="70">
		<span style="color:green;"><?php echo $rivi7["status"]; ?> </span> </td><td></td><td>
		<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta">
<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus">  	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi7[id]>";
	echo "</div>";
	echo "</form>";
		}
	}
	}

	elseif (isset($_POST["haeasiakas"]) && empty($_POST["haestatus"]) &&  isset($_POST["haetilauspvm"]))
	{
	$rivit8 = array();
	while ($rivi8 = mysqli_fetch_assoc($htulos8)){
	$rivit8[] = $rivi8;
	}
	foreach($rivit8 as $rivi8)
	{
	if(strcasecmp($rivi8["status"], "HYLÄTTY") != 0) {		?>
		<tr><td width="120"> <?php echo $rivi8["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi8["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi8["kuvaus"]; ?>
		</td><td></td><td width="70"><?php echo date('d.m.Y', strtotime($rivi8["tilauspvm"])); ?></td><td></td><td width="70">
		<?php if ($rivi8["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime($rivi8["aloituspvm"])); }?></td><td></td><td width="70"><?php if ($rivi8["valmistumispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi8["valmistumispvm"])); }?>
		</td><td></td><td width="70"><?php if ($rivi8["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi8["hyvaksymispvm"])); }?></td><td></td><td width="350">
		<?php echo $rivi8["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi8["tyotunnit"]; ?></td><td>
		</td><td width="200"><?php echo $rivi8["tarvikkeet"]; ?></td><td></td><td width="200">
		<?php echo $rivi8["kustannusarvio"]; ?></td><td></td><td width="70">
		<span style="color:green;"><?php echo $rivi8["status"]; ?> </span> </td><td></td><td>
			<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta">
<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus"> 	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi8[id]>";
	echo "</div>";
	echo "</form>";
		}
	}
	}
	
	elseif (empty($_POST["haeasiakas"]) && isset($_POST["haestatus"]) &&  isset($_POST["haetilauspvm"]))
	{
	$rivit9 = array();
	while ($rivi9 = mysqli_fetch_assoc($htulos9)){
	$rivit9[] = $rivi9;
	}
	foreach($rivit9 as $rivi9)
	{ 
	if(strcasecmp($rivi9["status"], "HYLÄTTY") != 0) { ?>
		<tr><td width="120"> <?php echo $rivi9["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi9["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi9["kuvaus"]; ?>
	</td><td></td><td width="70"><?php echo date('d.m.Y', strtotime($rivi9["tilauspvm"])); ?></td><td></td><td width="70">
		<?php if ($rivi9["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime($rivi9["aloituspvm"])); }?></td><td></td><td width="70"><?php if ($rivi9["valmistumispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi9["valmistumispvm"])); }?>
		</td><td></td><td width="70"><?php if ($rivi9["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi9["hyvaksymispvm"])); }?></td><td></td><td width="350">
		<?php echo $rivi9["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi9["tyotunnit"]; ?></td><td>
		</td><td width="200"><?php echo $rivi9["tarvikkeet"]; ?></td><td></td><td width="200">
		<?php echo $rivi9["kustannusarvio"]; ?></td><td></td><td width="70">
		<span style="color:green;"><?php echo $rivi9["status"]; ?> </span> </td><td></td><td>
			<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta"> 
	<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus"> 	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi9[id]>";
	echo "</div>";
	echo "</form>";
		}
	}
	}
	
	elseif (isset($_POST["haeasiakas"]) && isset($_POST["haestatus"]) &&  isset($_POST["haetilauspvm"]))
	{
	$rivit10 = array();
	while ($rivi10 = mysqli_fetch_assoc($htulos10)){
	$rivit10[] = $rivi10;
	}
	foreach($rivit10 as $rivi10)
	{
	if(strcasecmp($rivi10["status"], "HYLÄTTY") != 0) {		?>
		<tr><td width="120"> <?php echo $rivi10["tunnus"]; ?></td><td></td><td width="120"> <?php echo $rivi10["tilaaja"]; ?></td><td></td><td width="250"><?php echo $rivi10["kuvaus"]; ?>
		</td><td></td><td width="70"><?php echo date('d.m.Y', strtotime($rivi10["tilauspvm"])); ?></td><td></td><td width="70">
		<?php if ($rivi10["aloituspvm"] != NULL) { echo date('d.m.Y', strtotime($rivi10["aloituspvm"])); }?></td><td></td><td width="70"><?php if ($rivi10["valmistumispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi10["valmistumispvm"])); }?>
		</td><td></td><td width="70"><?php if ($rivi10["hyvaksymispvm"] != NULL) { echo date('d.m.Y', strtotime($rivi10["hyvaksymispvm"])); }?></td><td></td><td width="350">
		<?php echo $rivi10["kommentti"]; ?></td><td></td><td width="70"><?php echo $rivi10["tyotunnit"]; ?></td><td>
		</td><td width="200"><?php echo $rivi10["tarvikkeet"]; ?></td><td></td><td width="200">
		<?php echo $rivi10["kustannusarvio"]; ?></td><td></td><td width="70">
		<span style="color:green;"><?php echo $rivi10["status"]; ?> </span> </td><td></td><td> 
			<form action="kiinteistohuoltofirma.php" method="post">
	<div class="input-group">
	<input type="submit" name="muokkaus" value="Muokkaa statusta">
<input type="submit" name="muokkaus2" value="Muokkaa muita tietoja">
<input type="submit" name="muokkaus3" value="Muokkaa salasanaa">
<input type="submit" name="hylkaa" value="Hylkää työtilaus"> 	<?php
	echo "<td>" . "<input type=hidden name=hidden3 value=$rivi10[id]>";
	echo "</div>";
	echo "</form>";
		}
	}
	} 
	}
	}
?> </tr></table> <?php

// MUOKKAA STATUSTA PAINIKE
if(isset($_POST['muokkaus'])) 
{ 
$mquery1 = "SELECT * FROM tilaustiedot WHERE id = '$_POST[hidden3]'";
$mtulos1 = mysqli_query($db, $mquery1);
while ($mrivi1 = mysqli_fetch_array($mtulos1, MYSQL_ASSOC)) { 
  $mstatus = $mrivi1["status"];
  $mavain1 = $mrivi1["id"];
  
if(strcasecmp($mstatus, "TILATTU") == 0)
{
?>
Status:

<form action="kiinteistohuoltofirma.php" method="post">
<div class="input-group">
<input type="text" name="mstatus1"  size="25" value="<?php echo "ALOITETTU"; ?>"><br>
<input type="hidden" name="hiddenid1" value="<?php echo $_POST["hidden3"]; ?>"><br>
<button type="submit" name="tallennastatus1">Tallenna status</button>
<button type="submit" name="kumoastatus1">Kumoa</button>
<?php 
}
}
}
if(isset($_POST['tallennastatus1']))
{ 
$hiddenid1 = mysqli_real_escape_string($db, $_POST['hiddenid1']);
$mstatus1 = mysqli_real_escape_string($db, $_POST['mstatus1']);

$tquery1= "UPDATE tilaustiedot SET aloituspvm = CURDATE(), status = 'ALOITETTU' where tilaustiedot.id = '$hiddenid1'";
mysqli_query($db, $tquery1);

header("Location: kiinteistohuoltofirma.php");
}
if(isset($_POST['kumoastatus1'])) {
   header("Location: kiinteistohuoltofirma.php");
	
}
if(isset($_POST['muokkaus'])) 
{ 
$mquery2 = "SELECT * FROM tilaustiedot WHERE id = '$_POST[hidden3]'";
 $mtulos2 = mysqli_query($db, $mquery2);
while ($mrivi2 = mysqli_fetch_array($mtulos2, MYSQL_ASSOC)) { 
  $mstatus = $mrivi2["status"];
  $mavain2 = $mrivi2["id"];
  
if(strcasecmp($mstatus, "ALOITETTU") == 0)
{
?>
Status:
<form action="kiinteistohuoltofirma.php" method="post">
<div class="input-group">
<input type="text" name="mstatus2"  size="25" value="<?php echo "VALMIS"; ?>"><br>
<input type="hidden" name="hiddenid2" value="<?php echo $_POST["hidden3"]; ?>"><br>
<button type="submit" name="tallennastatus2">Tallenna status</button>
<button type="submit" name="kumoastatus2">Kumoa</button>
<?php 
}
}
}
if(isset($_POST['tallennastatus2']))
{ 
$hiddenid2 = mysqli_real_escape_string($db, $_POST['hiddenid2']);
$mstatus2 = mysqli_real_escape_string($db, $_POST['mstatus2']);

$tquery2= "UPDATE tilaustiedot SET valmistumispvm = CURDATE(), status = 'VALMIS' where tilaustiedot.id = '$hiddenid2'";
mysqli_query($db, $tquery2);

header("Location: kiinteistohuoltofirma.php");
}
if(isset($_POST['kumoastatus2'])) {
   header("Location: kiinteistohuoltofirma.php");
	
}
if(isset($_POST['muokkaus'])) 
{ 
$mquery3 = "SELECT * FROM tilaustiedot WHERE id = '$_POST[hidden3]'";
 $mtulos3 = mysqli_query($db, $mquery3);
while ($mrivi3 = mysqli_fetch_array($mtulos3, MYSQL_ASSOC)) { 
  $mstatus = $mrivi3["status"];
  $mavain3 = $mrivi3["id"];
  
if(strcasecmp($mstatus, "VALMIS") == 0)
{
?>
Status:

<form action="kiinteistohuoltofirma.php" method="post">
<div class="input-group">
<input type="text" name="mstatus3"  size="25" value="<?php echo "ALOITETTU"; ?>"><br>
<input type="hidden" name="hiddenid3" value="<?php echo $_POST["hidden3"]; ?>"><br>
<button type="submit" name="tallennastatus3">Tallenna status</button>
<button type="submit" name="kumoastatus3">Kumoa</button>
<?php 
}
}
}
if(isset($_POST['tallennastatus3']))
{ 
$hiddenid3 = mysqli_real_escape_string($db, $_POST['hiddenid3']);
$mstatus3 = mysqli_real_escape_string($db, $_POST['mstatus3']);

$tquery3= "UPDATE tilaustiedot SET valmistumispvm = '', status = 'ALOITETTU' where tilaustiedot.id = '$hiddenid3'";
mysqli_query($db, $tquery3);

header("Location: kiinteistohuoltofirma.php");
}
if(isset($_POST['kumoastatus3'])) {
   header("Location: kiinteistohuoltofirma.php");
	
}

// MUOKKAA MUITA TIETOJA PAINIKE
if(isset($_POST['muokkaus2'])) 
{ 
$mquery4 = "SELECT * FROM tilaustiedot WHERE id = '$_POST[hidden3]'";
$mtulos4 = mysqli_query($db, $mquery4);
while ($mrivi4 = mysqli_fetch_array($mtulos4, MYSQL_ASSOC)) { 

$mkommentti4 = $mrivi4["kommentti"];
$mtyotunnit4 = $mrivi4["tyotunnit"];
$mtarvikkeet4 = $mrivi4["tarvikkeet"];
{
?>

<form action="kiinteistohuoltofirma.php" method="post">
<div class="input-group">
Kommentti: 
<input type="text" name="mkommentti5"  size="100" value="<?php echo $mkommentti4; ?>"><br>
Käytetty tuntimäärä: <input type="text" name="mtyotunnit5"  size="25" value="<?php echo $mtyotunnit4; ?>"><br>
Käytetyt tarvikkeet: <input type="text" name="mtarvikkeet5"  size="25" value="<?php echo $mtarvikkeet4; ?>"><br>
<input type="hidden" name="hiddenid5" value="<?php echo $_POST["hidden3"]; ?>"><br>
<button type="submit" name="tallennatiedot">Tallenna tiedot</button>
<button type="submit" name="kumoatiedot">Kumoa</button>
<?php 
}
}
}
if(isset($_POST['tallennatiedot']))
{ 
$hiddenid5 = mysqli_real_escape_string($db, $_POST['hiddenid5']);
$mkommentti5 = mysqli_real_escape_string($db, $_POST['mkommentti5']);
$mtyotunnit5 = mysqli_real_escape_string($db, $_POST['mtyotunnit5']);
$mtarvikkeet5 = mysqli_real_escape_string($db, $_POST['mtarvikkeet5']);

$tquery5= "UPDATE tilaustiedot SET kommentti = '$mkommentti5',
			tyotunnit = '$mtyotunnit5', tarvikkeet = '$mtarvikkeet5' 
			where tilaustiedot.id = '$hiddenid5'";
mysqli_query($db, $tquery5);

header("Location: kiinteistohuoltofirma.php");
}
if(isset($_POST['kumoatiedot'])) {
   header("Location: kiinteistohuoltofirma.php");
	
}

// MUOKKAA SALASANAA PAINIKE

if(isset($_POST['muokkaus3'])) 
{ 
$mquery6 = "SELECT * FROM kayttajat INNER JOIN tilaustiedot on kayttajat.tunnus = tilaustiedot.tunnus WHERE tilaustiedot.id = '$_POST[hidden3]'";
$mtulos6 = mysqli_query($db, $mquery6);
while ($mrivi6 = mysqli_fetch_array($mtulos6, MYSQL_ASSOC)) { 
  $msalasana = $mrivi6["salasana"];
  // $mavain1 = $mrivi1["id"];
  
?>

<form action="kiinteistohuoltofirma.php" method="post">
<div class="input-group">
Vaihda käyttäjän salasana  <input type="password" name="msalasana1"  size="25" value="<?php echo $msalasana; ?>"><br>
<input type="hidden" name="hiddenid6" value="<?php echo $_POST["hidden3"]; ?>"><br>
<button type="submit" name="tallennass">Tallenna salasana</button>
<button type="submit" name="kumoass">Kumoa</button>
<?php 
}
}
if(isset($_POST['tallennass']))
{ 
$hiddenid6 = mysqli_real_escape_string($db, $_POST['hiddenid6']);
$msalasana1 = mysqli_real_escape_string($db, $_POST['msalasana1']);

$tquery6= "UPDATE kayttajat INNER JOIN tilaustiedot on kayttajat.tunnus = tilaustiedot.tunnus SET salasana = '$msalasana1' where tilaustiedot.id = '$hiddenid6'";
mysqli_query($db, $tquery6);

header("Location: kiinteistohuoltofirma.php");
}
if(isset($_POST['kumoass'])) {
   header("Location: kiinteistohuoltofirma.php");
}

// HYLKÄÄ TYÖTILAUS PAINIKE
if(isset($_POST['hylkaa'])) 
{ 
$hquery1 = "SELECT * FROM tilaustiedot WHERE id = '$_POST[hidden3]'";
$htulos1 = mysqli_query($db, $hquery1);
while ($hrivi1 = mysqli_fetch_array($htulos1, MYSQL_ASSOC)) { 
  $hstatus = $hrivi1["status"];
  $havain1 = $hrivi1["id"];
} 
$hquery2= "UPDATE tilaustiedot SET status = 'HYLÄTTY' where tilaustiedot.id = '$havain1'";
mysqli_query($db, $hquery2);
header("Location: kiinteistohuoltofirma.php");

}
 ?>
<br><br>
<font size="4"><a href="huoltofirman_tarjouspyynnot.php">Tarjouspyyntöjä hallinnoimaan</a></br></br>
</div>
</form>
	
</body>
</html>