<?php
//CHANGED
	if (isset($arrHttp["lock"]) and $arrHttp["lock"]=="S"){
    $contenido="";
    $content="";
    $err_wxis="";
    if (isset($_SESSION["MULTIPLE_DB_FORMATS"]) and $_SESSION["MULTIPLE_DB_FORMATS"]=="Y"){
    	if (isset($_SESSION["PREV_DB"]))
    		$prev_db=$_SESSION["PREV_DB"];
    	else
    		$prev_db="";
    	$parms=explode('&',$query);
    	foreach ($parms as $pp){
    			$actual_db=trim(substr($pp,5));
    			break;
    		}
    	if ($actual_db!=$prev_db){
    			foreach ($drb as $value){
    				if (trim($value)!=""){
    						$Wxis=trim(substr($value,9));
    					}
    					if (substr($value,0,10)=="wxis_post="){
    						$wxisUrl=trim(substr($value,10));
    					}
	if (isset($wxisUrl) and $wxisUrl!=""){
		$query.="&path_db=".$db_path;
		$url="$wxisUrl?IsisScript=$IsisScript$query&cttype=s";
		if (file_exists($db_path."par/syspar.par"))
        	$url.="&syspar=$db_path"."par/syspar.par";

		$url_parts = parse_url($url);
		$host = $url_parts["host"];
		$port = ($url_parts["port"]) ? $url_parts["port"] : 80;
		$path = $url_parts["path"];
		$query = $url_parts["query"];
		$timeout = 10;
		$contentLength = strlen($url_parts["query"]);
	// Generate the request header
    	$ReqHeader =
      		"POST $path HTTP/1.0\n".
      		"Host: $host\n".
      		"User-Agent: PostIt\n".
      		"Content-Type: application/x-www-form-urlencoded\n".
      		"Content-Length: $contentLength\n\n".
      		"$query\n";
	// Open the connection to the host
		$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
		//ECHO $host;
	    $result="";
		fputs( $fp, $ReqHeader );
        $inicio_content="";
		if ($fp) {
			while (!feof($fp)){
        	    $a=fgets($fp, 4096);
                //ECho "$a<br>";
                $content.=$a;
                if (trim($a)=="Content-Type: text/html"){
                   	continue;
                if ($inicio_content=="SI"){
						$result .=$a ;
				}
			}
		}

/*		$result=file_get_contents($url);*/        //ESTA FORMA DE LEER NO SE USA PORQUE DA MUCHOS PROBLEMAS CON EL URL
        $con=explode("\n",$result);
        $ix=0;
        $contenido=array();
        foreach ($con as $value) {
           	if (substr($value,0,4)=="WXIS"){
        	$contenido[]=$value;
        }
       if ($err_wxis!="") echo "<font color=red size=+1>$err_wxis</font>";
  }else{

      	$query.="&path_db=".$db_path;
		putenv('REQUEST_METHOD=GET');
		$q=explode("&",$query);
		$query="";

		foreach ($q as $value){
			if (trim($value!="")){
				if ($ix>0){
					$par=substr($value,$ix+1);
					if ($key=="cipar"){
					if ($par!="")
						$query.="&".$key."=".$par;
			}
        if (file_exists($db_path."par/syspar.par"))
        	$query.="&syspar=$db_path"."par/syspar.par";
        echo $query;
		putenv('QUERY_STRING='."?xx=".$query);
	 	exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
	 	$err_wxis="";
	 	foreach ($contenido as $value) {
           	if (substr($value,0,4)=="WXIS"){
           		$err_wxis.=$value."<br>";
           	}
           	//echo "***$value<br>";

        }
       if ($err_wxis!="") {
       		//die;
       	}
 }
 //if (isset($log) and $log=="Y"){
 	if (is_dir($db_path."log") and isset($_SESSION['login'])){
	 	$out=date('Ymd h:i:s A')."\t".$_SESSION['login']."\t".$_SERVER["PHP_SELF"]."\t".$IsisScript."\t".str_replace("\n"," ",urldecode($query))."\n";
		fwrite($fp,$out);
		fclose($fp);
	}
?>