<?php
include("tope_config.php");
?>
<div id="page">
	<p>
    <h3><?php echo $msgstr["sys_msg"]." &nbsp; <a href=http://wiki.abcdonline.info/OPAC-ABCD_configuraci%C3%B3n#Mensajes_del_sistema target=blank><img src=../images_config/helper_bg.png></a></h2><p>";?>

    <p>
<?php


if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Actualizar"){
	foreach ($_REQUEST as $var=>$value){
		if (trim($value)!=""){
			$code=explode("_",$var);
			if ($code[0]=="conf"){
				if ($code[1]=="lc"){
					if (!isset($cod_idioma[$code[2]])){
						$cod_msg[$code[2]]=$value;
					}
				}else{
					if (!isset($nom_idioma[$code[2]])){
						$nom_msg[$code[2]]=$value;
					}
				}
			}
		}
	}
   	$a=$path."lang/".$_REQUEST["lang"]."/opac.tab";
    $fout=fopen($path."lang/".$_REQUEST["lang"]."/opac.tab","w");
	foreach ($cod_msg as $key=>$value){
  	 	fwrite($fout,$value."=".$nom_msg[$key]."\n");
		echo $value."=".$nom_msg[$key]."<br>";
	}
	fclose($fout);
	echo "<h2>".$_REQUEST["lang"]."/lang.tab"." ".$msgstr["updated"]."</h2>";
	die;
}

$a=$path."lang/".$_SESSION["lang"]."/opac.tab";
echo $a."<br>";
if (file_exists($a)) {
$a=$path."lang/00/opac.tab";


<form name=actualizar method=post>
<?php
$ix=0;
echo "<table>";
foreach ($msgstr as $key=>$value){
	$ix=$ix+1;
	echo "<tr><td><input type=hidden name=conf_lc_".$ix." size=20 value=\"".trim($key)."\">".trim($key)."</td>";
	echo "<td><input type=text name=conf_ln_".$ix." size=100 value=\"".trim($value)."\"></td>";
	echo "</tr>";
}

echo "</table>";
echo "<input type=submit value=\"".$msgstr["save"]."\">";
echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
echo "<input type=hidden name=Opcion value=Actualizar>";
?>
</form>
</div>
<?php

include ("../php/footer.php");
?>

</body
</html>