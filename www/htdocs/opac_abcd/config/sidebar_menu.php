<?php
include ("tope_config.php");
/*
if (!isset($_REQUEST["db_path"])){
	$_REQUEST["db_path_desc"]="$db_path";
if (isset($_REQUEST["db_path"])) {
	$_SESSION["db_path_desc"]=$_REQUEST["db_path_desc"];
}
*/
if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];


//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;

/////////////////////////////////////////////////////////////////////

if (!isset($_SESSION["permiso"])){
	session_destroy();
	$msg=$msgstr["invalidright"]." ".$msgstr[$_REQUEST["startas"]];
	echo "
	<html>
	<body>
	<form name=err_msg action=error_page.php method=post>
	<input type=hidden name=error value=\"$msg\">
	";
	echo "
	</form>
	<script>
		document.err_msg.submit()
	</script>
	</body>
	</html>
	";
   	session_destroy();
   	die;
 }
?>
<div id="page" style="margin-top:10px;padding:10px;">
<h3><?php echo $msgstr["sidebar_menu"]?> &nbsp; <a href=http://wiki.abcdonline.info/OPAC-ABCD_Apariencia#Agregar_enlaces_al_men.C3.BA_desplegable_izquierdo target=_blank><img src=../images_config/helper_bg.png></a></h3>
<br>
<?php
$lang=$_REQUEST["lang"];
$Permiso=$_SESSION["permiso"];
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			$x=explode('_',$var);
			if ($x[0]=="side"){
				$side_bar[$x[2]]=trim($value);
				$sec=$x[2];
			}
			if ($x[0]=="lk"){


		}
	}
	ksort($link);
	foreach ($link as $sec=>$value){
		$salida="";
		foreach ($value as $l){
			$salida=$l["nombre"][$sec]."|".$l["link"][$sec]."|";
			if (isset($l["nw"][$sec]) and $l["nw"][$sec]=="Y")
				$salida.=$l["nw"][$sec];
			if ($salida!="") fwrite($fout,$salida."\n");
		}

	fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$file="side_bar.info";
	echo "<form name=side"."Frm method=post xonSubmit=\"return checkform()\">\n";
	echo "<input type=hidden name=db_path value=".$db_path.">";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
   	echo "<input type=hidden name=file value=\"$file\">\n";
   	echo "<input type=hidden name=lang value=\"$lang\">\n";
   	if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$file")){
		$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$file");
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
	}else{
		$fp=array();
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
	}
	$ix=0;
	$ixsec=0;

	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$sec_name="";
					$ix=$ix+1;
					$ix=0;
				echo "<table cellpadding=5>";
				$ixsec=$ixsec+1;
				echo "<input type=text name=side_sec_$ixsec"."_0 size=20 value=\"$sec_name\"></th></tr>";
				echo "<tr><th>".$msgstr["nombre"]."</th><th>".$msgstr["link"]."</th><th>".$msgstr["new_w"]."</th></tr>";
			}else{
				$x=explode('|',$value);
				echo "<tr><td><input type=text size=20 name=lk_nombre_$ixsec"."_$ix value=\"".$x[0]."\"></td>";
				echo "<td><input type=text size=80 name=lk_link_$ixsec"."_$ix value=\"".$x[1]."\"></td>";
				echo "<td>&nbsp; &nbsp; &nbsp; <input type=checkbox name=lk_nw_$ixsec"."_$ix value=\"Y\"";
				if (isset($x[2]) and $x[2]=="Y") echo " checked";
				echo "></td>";
				echo"</tr>";
	echo "<tr><td colspan=3 align=center><br><hr size=2 color=darkblue><br><input type=submit value=\"".$msgstr["send"]."\"></td></tr>";
	echo "</table>";
	echo "</form>";
}


?>

</div>
<br>
<br>
<?php
include ("../php/footer.php");
?>

</body
</html>
<?php
function AgregarLineas($ix,$ixsec){
		echo "<td><input type=text size=80 name=lk_link_$ixsec"."_$ix value=\"\"></td>";
				echo "<td>&nbsp; &nbsp; &nbsp; <input type=checkbox name=lk_nw_$ixsec"."_$ix value=\"Y\"";
				echo "></td>";
				echo"</tr>";