<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/acquisitions.php");
include("../config.php");
include("../common/header.php");

$base=$arrHttp["base"];
$OS=strtoupper(PHP_OS);
$converter_path=$mx_path;
if (strpos($OS,"WIN")=== false)
{
$converter_path=str_replace('mx.exe','',$converter_path);
$converter_path.=$cisis_ver."mx";
}
else
$converter_path.=$cisis_ver."mx.exe";
$mx_path=$converter_path;
include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
echo "<div style='float:right;'> <a href=\"../dbadmin/menu_mantenimiento.php?base=".$base."&encabezado=s\" class=\"defaultButton backButton\">";
echo "<img 'src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong> back </strong></span>
				</a></div>";
echo "<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">Import ISO: " . $base."
			</div>
			<div class=\"actions\">";
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento_vmxISO_load.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento_vmxISO_load.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: vmxISO_load.php</font>";
?>
</div>
<style type="text/css">
  form {margin:20px;}
</style>
<div class="middle form">
<form action="" method="post" enctype="multipart/form-data">
 <br> <label for="archivo">Choose File:</label>
  <input type="file" name="archivo" id="archivo" />
  <br><br>
  <label>Select the operation</label>
  <select name="OpISO">
  <option>append</option>
  <option>create</option>
  </select>
  <br><br>
  <input type=checkbox name=tolinux value=Y>From windows to linux <br><br>
 <?php
 include("../common/get_post.php");
  $base=$arrHttp["base"];

  echo " <input type=\"hidden\" value=\"$base\" name=\"base\"/>";
  ?>
  <input type="submit" value="Send"/>
  </form>

<?php
include("phpfileuploader/form-simple-upload.php");

$bd=$db_path.$base;
	$op=$_POST['OpISO'];
  if(isset($op))
  {
  $nombre=$_POST["fn"];
  echo "<h3>Process information</h3>";
echo "File upload OK, importing ".$nombre."...";
	 $op=$_POST['OpISO'];

	 $strINV=$mx_path." "."iso=".$db_path."wrk/".$nombre." ".$op."=".$bd."/data/".$base." -all now";
	 echo $strINV ; die;
	 exec($strINV, $output,$t);
	 $straux="";
for($i=0;$i<count($output);$i++)
{
$straux.=$output[$i]."<br>";
}
echo "<br>MX query: ".$strINV;
echo "<br>Process output: ".$straux;
if($t==0)
echo "<br>Process OK!";
else
echo "<br>Process NOT executed!";
if($base=="")
{
echo"<br>NO database selected";
}
}
//echo "<br>"."<a href='../dbadmin/menu_mantenimiento.php?base=&encabezado=s'>Maintenance Menu</a>"."<br>";
?>
<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"?>
</form>
</div>
</div>
<?php
include("../common/footer.php");
echo "</body></html>";

?>
