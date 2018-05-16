<?php


/**
 * @param $type
 * @param $msg
 */
function oiwe_log_to_file($type, $msg){

		$path = realpath(dirname(__FILE__));

		$date = date('d/m/Y h:i:s a', time());


       	$log = $date .  " - " . $type . " - " . $msg  . "\n" ;
        file_put_contents($path . DIRECTORY_SEPARATOR . 'weimgoptimizer.log', $log, FILE_APPEND);

}

function oiwe_optimize_image($source){

	global $OIWE_API_URL;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $OIWE_API_URL );
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,  true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $post = file_get_contents($source);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $start = microtime(true);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        oiwe_log_to_file("ERROR", curl_error($ch) );
        return 0;
    }

    curl_close ($ch);
    file_put_contents($source . ".optim" , $result);

	$end = (microtime(true) - $start);

	$size_before = filesize($source);
	$size_after =  filesize($source . ".optim");

	$perct = ( $size_after * 100 ) / $size_before;

	$perct = 100 - $perct ;

    $upload_dir = wp_upload_dir();

	// A $upload_dir["path"] le quito ABSPATH

	$homepath = get_home_path();

	$root_image_dir = str_replace($homepath, '', $upload_dir["path"] ) ;

	$basename = basename($source);

	oiwe_log_to_file("INFO ", "NAME ". $source ." - BEFORE " . $size_before . " - AFTER " . $size_after . " - SAVED ". ( $size_before - $size_after ) ." - TIME " . $end . " - PERCENT " . $perct  );

	copy($source . ".optim", $source );
	unlink( $source . ".optim" );



	$res = array();
	$res["filename"] = $source;
	$res["size_before"] = $size_before;
	$res["size_after"] = $size_after;
	$res["size_saved"] =  $size_before - $size_after ;
	$res["time_spent"] = $end ;
	$res["percent_saved"] = $perct;

	return $res;

}


function oiwe_optimize_image_by_att_id($att_id, $metadata_param = 0){

	$id = intval( $att_id );

	if ($metadata_param == 0){
    	$metadata = wp_get_attachment_metadata( $id );
	}else {
    	$metadata = $metadata_param ;
	}

    if ( ! is_array( $metadata ) ) {
	    //echo "No se ha encontrado metainformacion para el fichero" ;
        return 0;
	}
	$upload_dir = wp_upload_dir();


    $filename = $metadata["file"];
    $fileBasename = basename($filename);

    $subdir = str_replace($fileBasename,"", $filename ) ;
	$total_res = array();

	global $wpdb;
	global $OIWE_TABLENAME;

	$table_name = $wpdb->prefix . $OIWE_TABLENAME ;

	$uuid = uniqid('weimg_') ;


	foreach ($metadata["sizes"] as $key => $value){

		// TODO: Comprobar si los mime/tipes son correctos
		$thumbFile = $upload_dir["basedir"] . DIRECTORY_SEPARATOR . $subdir . $value["file"] ;
		$total_res[$key] = oiwe_optimize_image( $thumbFile );

	    $wpdb->insert(
	        $table_name,
	        array(
	            'time' => current_time( 'mysql' ),
	            'uuid' => $uuid,
	            'meta_id' => $id,
	            'saving' => (int)$total_res[$key]["size_before"] - (int)$total_res[$key]["size_after"] ,
	            'size_before' => (int)$total_res[$key]["size_before"],
	            'size_after' => (int)$total_res[$key]["size_after"],
	            'time_spent' => (int)$total_res[$key]["time_spent"],
	            'percent_saved' => (int)$total_res[$key]["percent_saved"],
	            'thumb_size' => $key ,
	            'img_path' => $total_res[$key]["filename"],
	            'meta_value' => ""
	        )
	    );

	}

	$total_res["we_original_size"] = oiwe_optimize_image( $upload_dir["basedir"] . DIRECTORY_SEPARATOR . $metadata["file"] );


	$wpdb->insert(
	    $table_name,
	    array(
	       	'time' => current_time( 'mysql' ),
	       	'uuid' => $uuid,
	       	'meta_id' => $id,
	       	'saving' => (int)$total_res["we_original_size"]["size_before"] - (int)$total_res["we_original_size"]["size_after"],
	       	'size_before' => (int)$total_res["we_original_size"]["size_before"],
	       	'size_after' => (int)$total_res["we_original_size"]["size_after"] ,
	       	'time_spent' => (int)$total_res["we_original_size"]["time_spent"] ,
	       	'percent_saved' => (int)$total_res["we_original_size"]["percent_saved"],
	       	'thumb_size' => "we_original_size" ,
	       	'img_path' => $total_res["we_original_size"]["filename"],
	       	'meta_value' => ""
	    )
	);


	return $total_res;

}



function oiwe_get_optimization_data_by_attID($id){

	global $wpdb;
	global $OIWE_TABLENAME;

	$table_name = $wpdb->prefix . $OIWE_TABLENAME ;

	 $querystr = "
	    SELECT *
	    FROM $table_name
	    WHERE meta_id = $id
        AND thumb_size = 'we_original_size'
		GROUP BY uuid
	    ORDER BY time DESC
	 ";

	$optimizations = $wpdb->get_results($querystr, OBJECT);

	return $optimizations ;
}


function oiwe_get_optimization_list(){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

		$querystr = "
     	SELECT ". $wpdb->prefix . $OIWE_TABLENAME .".* , ". $wpdb->prefix . "postmeta.meta_value AS filename
       	FROM ". $wpdb->prefix . $OIWE_TABLENAME .", ". $wpdb->prefix . "postmeta
        WHERE ". $wpdb->prefix . $OIWE_TABLENAME .".thumb_size = 'we_original_size'
		AND ". $wpdb->prefix . $OIWE_TABLENAME .".meta_id = ". $wpdb->prefix . "postmeta.post_id
        GROUP BY meta_id
        ORDER BY time DESC; ";



	$optimizations = $wpdb->get_results($querystr, OBJECT);

	return $optimizations ;
}

function oiwe_get_optimization_list_limit($limit){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

        $querystr = "
        SELECT ". $wpdb->prefix . $OIWE_TABLENAME .".* , ". $wpdb->prefix . "postmeta.meta_value AS filename
        FROM ". $wpdb->prefix . $OIWE_TABLENAME .", ". $wpdb->prefix . "postmeta
        WHERE ". $wpdb->prefix . $OIWE_TABLENAME .".thumb_size = 'we_original_size'
        AND ". $wpdb->prefix . $OIWE_TABLENAME .".meta_id = ". $wpdb->prefix . "postmeta.post_id
        GROUP BY meta_id
        ORDER BY time DESC
		LIMIT $limit
		; ";


    $optimizations = $wpdb->get_results($querystr, OBJECT);

    return $optimizations ;
}


function oiwe_get_optimization_list_pagination($elems, $page , $filter = ""){


    global $wpdb;
    global $OIWE_TABLENAME;

	if ($page == 0) {
		$start = 0;
	}else {
		$start = $elems *  ($page - 1);
	}

	$end = $elems *  $page;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

	//  LIMIT 15 OFFSET 30


	if ($filter == "") {

        $querystr = "
        SELECT ". $wpdb->prefix . $OIWE_TABLENAME .".* , ". $wpdb->prefix . "postmeta.meta_value AS filename
        FROM ". $wpdb->prefix . $OIWE_TABLENAME .", ". $wpdb->prefix . "postmeta
        WHERE ". $wpdb->prefix . $OIWE_TABLENAME .".thumb_size = 'we_original_size'
        AND ". $wpdb->prefix . $OIWE_TABLENAME .".meta_id = ". $wpdb->prefix . "postmeta.post_id
        GROUP BY meta_id
        ORDER BY time DESC
		LIMIT $elems OFFSET $start; ";

		$optimizations = $wpdb->get_results($querystr, OBJECT);

        $querystr = "
		SELECT COUNT(*) AS count FROM ( 
	        SELECT ". $wpdb->prefix . $OIWE_TABLENAME .".*
	        FROM ". $wpdb->prefix . $OIWE_TABLENAME .", ". $wpdb->prefix . "postmeta
	        WHERE ". $wpdb->prefix . $OIWE_TABLENAME .".thumb_size = 'we_original_size'
	        AND ". $wpdb->prefix . $OIWE_TABLENAME .".meta_id = ". $wpdb->prefix . "postmeta.post_id
	        GROUP BY meta_id
	        ORDER BY time DESC 
		) t
		; ";

		$total_count_optimizations =  $wpdb->get_results($querystr, OBJECT);

		$total_count =  $total_count_optimizations[0]->count;



	}else {

        $querystr = "
        SELECT ". $wpdb->prefix . $OIWE_TABLENAME .".* , ". $wpdb->prefix . "postmeta.meta_value AS filename
        FROM ". $wpdb->prefix . $OIWE_TABLENAME .", ". $wpdb->prefix . "postmeta
        WHERE ". $wpdb->prefix . $OIWE_TABLENAME .".thumb_size = 'we_original_size'
		AND ". $wpdb->prefix . $OIWE_TABLENAME .".img_path LIKE '%". $filter ."%'
        AND ". $wpdb->prefix . $OIWE_TABLENAME .".meta_id = ". $wpdb->prefix . "postmeta.post_id
        GROUP BY meta_id
        ORDER BY time DESC
        LIMIT $elems OFFSET $start; ";

		$optimizations = $wpdb->get_results($querystr, OBJECT);

        $querystr = "
		SELECT COUNT(*) AS count FROM (
	        SELECT ". $wpdb->prefix . $OIWE_TABLENAME .".* , ". $wpdb->prefix . "postmeta.meta_value AS filename
	        FROM ". $wpdb->prefix . $OIWE_TABLENAME .", ". $wpdb->prefix . "postmeta
	        WHERE ". $wpdb->prefix . $OIWE_TABLENAME .".thumb_size = 'we_original_size'
	        AND ". $wpdb->prefix . $OIWE_TABLENAME .".img_path LIKE '%". $filter ."%'
	        AND ". $wpdb->prefix . $OIWE_TABLENAME .".meta_id = ". $wpdb->prefix . "postmeta.post_id
	        GROUP BY meta_id
	        ORDER BY time DESC  
		) t
		";

       	$total_count_optimizations = $wpdb->get_results($querystr, OBJECT);
		$total_count =  $total_count_optimizations[0]->count;


	}

    return array($total_count, $optimizations);
}



function oiwe_isPlanned($id){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . "imgoptimizeractions" ;

     $querystr = "
        SELECT *
        FROM $table_name
        WHERE img_id = $id
        AND status = 'pending'
        ORDER BY time DESC
     ";

    $planneds = $wpdb->get_results($querystr, OBJECT);

    return $planneds ;
}


function oiwe_isOptimized ($id){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME;

     $querystr = "
        SELECT *
        FROM $table_name
        WHERE meta_id = $id
        AND thumb_size = 'we_original_size'
        ORDER BY time DESC
     ";

    $optimizeds = $wpdb->get_results($querystr, OBJECT);

    return $optimizeds ;
}




function oiwe_get_optimization_byUUID($uuid){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

   	$querystr = "
        SELECT *
        FROM $table_name
        WHERE uuid = '$uuid' ;
    ";

    $optimizations = $wpdb->get_results($querystr, OBJECT);

    return $optimizations ;
}


//                 $callback($output, $info["url"] , $urls , $info );

$handleRequest = function($salida, $ref , $arr, $info)
{


	$refTempo = explode("ref=", $ref);

	$refTempo2 =  explode( "&" ,  $refTempo[1]  ) ;

	$refBueno =   $refTempo2[0];

	$imgPath = "";
	$wpsize = "";

//	for($j = 0; $j < count($arr); $j++){
    foreach ($arr as $key => $value){
		if (trim(md5( $value )) == trim($refBueno)){

			//echo "La imagen es: "  . $arr[$j]  . " \n ";
			//echo basename($arr[$j]) . " \n";
			$imgPath = $value ;
			$wpsize = $key;
		}
	}

	$size_before = filesize($imgPath);

	// Si Hay opcion de hacer backup de imagenes, se guarda antes de volcarla

    $weautobackup = get_option("weautobackup");

	if ($weautobackup != "no") {

        $path = realpath(dirname(__FILE__));

		if ($wpsize == "we_original_size"){

			if (!file_exists( $path . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "backups"  . DIRECTORY_SEPARATOR . basename($imgPath) ) ){
				copy($imgPath, $path . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "backups"  . DIRECTORY_SEPARATOR . basename($imgPath)  );
			}

		}

	}



	// TODO: Comprobar que el fichero donde se va a volcar el fichro existe...

	rename($imgPath, $imgPath . ".ORIGINAL");

	file_put_contents($imgPath , $salida);


	$fp = fopen($imgPath, "r");
	$fstat = fstat($fp);
	fclose($fp);


	$size_after = $fstat["size"] ;


    $perct = ( $size_after * 100 ) / $size_before;
    $perct = 100 - $perct ;

	$ok = 1;

	if ( $perct < 0 ){
		$ok = 0;
	}

	if ( function_exists("finfo_open") ) {

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimetype = finfo_file($finfo, $imgPath );

		// Comprobamos el mimetype de la imagen optimizada para evitar problemas
		if (strpos($mimetype, 'png') === false && strpos($mimetype, 'jpg') === false && strpos($mimetype, 'jpeg') === false && strpos($mimetype, 'image') === false) {
		    $ok = 0;
		}
		finfo_close($finfo);

	}


    if ( $ok == 0 ){
        $size_after = $size_before;
        $perct = 0;
       	$ok = 0;
        unlink($imgPath);
        rename($imgPath . ".ORIGINAL", $imgPath);
    }else {
        unlink($imgPath . ".ORIGINAL");
    }



    $res = array();
    $res["filename"] = basename($imgPath);
    $res["size_before"] = $size_before;
    $res["size_after"] = $size_after;
    $res["size_saved"] =  $size_before - $size_after ;
    $res["time_spent"] = $info["total_time"] ;


    $res["percent_saved"] = $perct;
    $res["wpsize"] = $wpsize;

	$_SESSION["concurrent_result"][ $wpsize ] = $res ;
	$_SESSION["concurrent_number"] += 1 ;

	global $wpdb;
	global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

    $wpdb->insert(
       	$table_name,
       	array(
            'time' => current_time( 'mysql' ),
            'uuid' => $info["imguuid"] ,
            'meta_id' => $info["imgid"] ,
            'saving' => (int)$res["size_before"] - (int)$res["size_after"],
            'size_before' => (int)$res["size_before"],
            'size_after' => (int)$res["size_after"] ,
            'time_spent' => (int)$res["time_spent"] ,
            'percent_saved' => (int)$res["percent_saved"],
            'thumb_size' => $wpsize ,
            'img_path' => $res["filename"],
            'meta_value' => ""
       	)
    );


	return $res ;

};

global $handleRequest;


function oiwe_optimize_concurrent_image_by_att_id($att_id, $metadata_param = 0 , $source = null){


	$isOptimizedResult = oiwe_isOptimized ($att_id);
	if (count($isOptimizedResult) > 0 ) {
		return false;
	}



	$id = intval( $att_id );

	if ($metadata_param == 0){
    	$metadata = wp_get_attachment_metadata( $id );
	}else {
    	$metadata = $metadata_param ;
	}


    if ( ! is_array( $metadata ) ) {
	    //echo "No se ha encontrado metainformacion para el fichero" ;
        return 0;
	}
	$upload_dir = wp_upload_dir();

    $filename = $metadata["file"];
    $fileBasename = basename($filename);

    $subdir = str_replace($fileBasename,"", $filename ) ;
	$total_res = array();

	global $wpdb;
	global $OIWE_TABLENAME;

	$table_name = $wpdb->prefix . $OIWE_TABLENAME ;

	$uuid = uniqid('conc_' . $id . '_') ;

	$filesArray = array();


	foreach ($metadata["sizes"] as $key => $value){

		// TODO: Comprobar si los mime/tipes son correctos
		$thumbFile = $upload_dir["basedir"] . DIRECTORY_SEPARATOR . $subdir . $value["file"] ;
		// $total_res[$key] = we_optimize_image( $thumbFile );

		$filesArray[$key] = $thumbFile ;

	}

	// $total_res["we_original_size"] = we_optimize_image( $upload_dir["basedir"] . DIRECTORY_SEPARATOR . $metadata["file"] );

	$filesArray["we_original_size"] =   $upload_dir["basedir"] . DIRECTORY_SEPARATOR . $metadata["file"] ;

	global $handleRequest;

	if ($source != null){
		$rollingCurlResult =  oiwe_rolling_curl($filesArray, $handleRequest, $id, $uuid , array("source" => $source) );
	}else {
		$rollingCurlResult =  oiwe_rolling_curl($filesArray, $handleRequest, $id, $uuid  );
	}

	return $rollingCurlResult ;


}



function oiwe_rolling_curl($urls, $callback, $id, $uuid, $custom_options = null) {

	$resResult = array();

    // make sure the rolling window isn't greater than the # of urls
    $rolling_window = 20;
    $rolling_window = (sizeof($urls) < $rolling_window) ? sizeof($urls) : $rolling_window;

    $master = curl_multi_init();
    $curl_arr = array();

    $headers = array();
    $headers[] = "Content-Type: application/x-www-form-urlencoded";

    $std_options = array(CURLOPT_RETURNTRANSFER => true,
    CURLOPT_BINARYTRANSFER => true,
    CURLOPT_POST => 1,
	CURLOPT_HTTPHEADER => $headers,
    CURLOPT_MAXREDIRS => 3);

    // $options = ($custom_options) ? ($std_options + $custom_options) : $std_options;

	$options = $std_options;

	$site_domain = parse_url( site_url() , PHP_URL_HOST);
	$oiwe_apikey = get_option("weoptimizeapikey");
	$oiwe_wplang = get_locale();

	$i = 0;
	foreach ($urls as $key => $value){
		if ($i > 19){
			break;
		}

//    for ($i = 0; $i < $rolling_window; $i++) {
		$weoptimizethumbs = get_option("weoptimizethumbs");
		if ($weoptimizethumbs == "no"){
			//echo " KEY == $key \n ";
			if ($key != "we_original_size" ){
				continue;
			}
		}

		$sourceparam = "";
	    if ($custom_options != null && isset($custom_options["source"])){
			$sourceparam = "&source=" . $custom_options["source"] ;
        }else{
			$sourceparam = "&source=sync";
		}

		global $PLUGIN_VERSION;
	    $plugin_version = $PLUGIN_VERSION;

		/* OBTENEMOS EL ENDPOINT ACTIVO PARA HA*/

		$ipArray = gethostbynamel("apihav1.optimizador.io");
		shuffle($ipArray);

		$endpoint = "";

		for($i = 0; $i < count($ipArray); $i++){
			$ip = $ipArray[$i];

			// Crear un manejador de cURL
			$ch = curl_init('http://'. $ip .':80/haproxy_test');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,2);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 4); //timeout in seconds

			// Ejecutar
			curl_exec($ch);

			// Comprobar si ocurrió un error
			if (!curl_errno($ch)) {
				$info = curl_getinfo($ch);

				if ( $info["http_code"] == 200 || $info["http_code"] == "200" ){
					// echo " - $ip esta OK \n" ;
					$endpoint = $ip;
				}

			}
			// Cerrar el manejador
			curl_close($ch);
		}


		if ($endpoint == ""){
			return false;
		}

        $ch = curl_init();
        $options[CURLOPT_POSTFIELDS] = file_get_contents( $value );
		$options[CURLOPT_URL] = "http://". $endpoint .":80/?ref=" . md5( $value ) . "&apikey=". $oiwe_apikey . "&lang=" . $oiwe_wplang . "&sitedomain=" . $site_domain . "&plgversion=" .  $plugin_version  . $sourceparam ;

        curl_setopt_array($ch,$options);
        curl_multi_add_handle($master, $ch);
		$i++;
    }

    do {

        while(($execrun = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM);
        if($execrun != CURLM_OK){
            break;
		}
        // a request was just completed -- find out which one
        while($done = curl_multi_info_read($master)) {
            $info = curl_getinfo($done['handle']);
            if ($info['http_code'] == 200)  {

                $output = curl_multi_getcontent($done['handle']);
                // request successful.  process output using the callback function.

				// Añadir ID de Imagen y UUID de Optimización

				$info["imgid"]   = $id  ;
				$info["imguuid"] = $uuid;
				// $info["wpsize"]  = $key ;

	            $resTempo = $callback($output, $info["url"] , $urls , $info );

				$resResult[ $resTempo["wpsize"] ] = $resTempo ;

                // remove the curl handle that just completed
                curl_multi_remove_handle($master, $done['handle']);
            } else {
                // request failed.  add error handling.
            }
        }
    } while ($running);

    curl_multi_close($master);
    return $resResult;
}




function oiwe_get_pendingtask_list(){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . "imgoptimizeractions";

        $querystr = "
        SELECT *
        FROM $table_name
        WHERE status = 'pending'
        ORDER BY time DESC; ";


    $actionList = $wpdb->get_results($querystr, OBJECT);

    return $actionList ;
}

function oiwe_setTaskAsDone ($id){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . "imgoptimizeractions";

	$id = (int)$id ;

	if ( $id == 0 ){
		return false;
	}

        $querystr = "
        UPDATE $table_name
        SET status='done'
        WHERE id = $id ; ";

	$result = $wpdb->get_results($querystr, OBJECT);


    return true ;
}


function oiwe_deleteActionByID($id){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . "imgoptimizeractions";

	if (! is_int($id)){
		return false;
	}

    $id = (int)$id ;

    if ( $id == 0 ){
        return false;
    }

        $querystr = "
        DELETE FROM $table_name
        WHERE id = $id ; ";

    $result = $wpdb->get_results($querystr, OBJECT);

    return true ;

}

function oiwe_deleteActionByImgID($id){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . "imgoptimizeractions";

    if (! is_int($id)){
        return false;
    }

    $id = (int)$id ;

    if ( $id == 0 ){
        return false;
    }

     	$querystr = "
        DELETE FROM $table_name
        WHERE img_id = $id AND status = 'pending' ; ";

    $result = $wpdb->get_results($querystr, OBJECT);

    return true ;

}


function oiwe_img_count(){
/*        $query_img_args = array(
                'post_type' => 'attachment',
                'post_mime_type' =>array(
                                'jpg|jpeg|jpe' => 'image/jpeg',
                                'png' => 'image/png',
                                ),
                'post_status' => 'inherit',
                'posts_per_page' => -1,
                );
        $query_img = new WP_Query( $query_img_args );
        return $query_img->post_count;
*/

	// La implementacion de WP_Query tiene algun problema de rendimiento

    global $wpdb;

	$querystr = "SELECT COUNT(*) as count FROM ". $wpdb->prefix  ."postmeta WHERE meta_value LIKE '%image/jpg%' OR meta_value LIKE '%image/jpeg%' OR meta_value LIKE '%image/png%'";
	$result = $wpdb->get_results($querystr, OBJECT);

	return $result[0]->count;

}



function oiwe_originasize_optimizadas(){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

   	$querystr = "
		SELECT * FROM $table_name
		INNER JOIN ". $wpdb->prefix ."postmeta
		ON $table_name.thumb_size = 'we_original_size'
		AND ". $wpdb->prefix ."postmeta.post_id = $table_name.meta_id
		GROUP BY $table_name.meta_id ; ";



    $result = $wpdb->get_results($querystr, OBJECT);

	return $result;

}

function oiwe_originasize_optimizadas_count(){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

    $querystr = "
		SELECT COUNT(*) AS count FROM (
        SELECT * FROM $table_name
        INNER JOIN ". $wpdb->prefix ."postmeta
        ON $table_name.thumb_size = 'we_original_size'
        AND ". $wpdb->prefix ."postmeta.post_id = $table_name.meta_id
        GROUP BY $table_name.meta_id
		) t ; ";



    $result = $wpdb->get_results($querystr, OBJECT);

    return $result[0]->count;

}




function oiwe_total_img_optimizadas(){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

    $querystr = "
        SELECT * FROM $table_name WHERE saving > 0 ;";

    $result = $wpdb->get_results($querystr, OBJECT);

    return $result;

}

function oiwe_total_img_optimizadas_count(){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

    $querystr = "
        SELECT COUNT(*) as count FROM $table_name WHERE saving > 0 ;";

    $result = $wpdb->get_results($querystr, OBJECT);

    return $result;

}

function oiwe_num_totalkb_saving(){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

    $querystr = "
        SELECT sum(saving) AS saving FROM $table_name
		WHERE saving > 0 ";

    $result = $wpdb->get_results($querystr, OBJECT);

    return $result;


}

function oiwe_num_percentage_average_saving(){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;

    $querystr = "
        SELECT sum(percent_saved) / count(*) AS percent FROM $table_name
       	WHERE saving > 0 ";

    $result = $wpdb->get_results($querystr, OBJECT);

    return $result;

}


function oiwe_get_nlast_optimizations($n){

    global $wpdb;
    global $OIWE_TABLENAME;

    $table_name = $wpdb->prefix . $OIWE_TABLENAME ;
	$querystr = "
				SELECT * FROM $table_name, ". $wpdb->prefix . "postmeta  WHERE thumb_size = 'we_original_size' AND percent_saved >= 20 AND size_after > 5 AND ". $table_name .".meta_id = ". $wpdb->prefix . "postmeta.post_id  AND meta_key = '_wp_attached_file' ORDER BY time DESC LIMIT $n;
				";


    $result = $wpdb->get_results($querystr, OBJECT);

    return $result;

}


function oiwe_get_meta_value_from_post_id($id){

    global $wpdb;

    $table_name = $wpdb->prefix . "postmeta" ;

    $querystr = "SELECT * FROM $table_name WHERE post_id = " . (int)$id ;

    $result = $wpdb->get_results($querystr, OBJECT);

    return $result;

}



function oiwe_optimizeAllGallery(){

		// TODO: No está finalizada esta funcion aun

        $query_img_args = array(
                'post_type' => 'attachment',
                'post_mime_type' =>array(
                                'jpg|jpeg|jpe' => 'image/jpeg',
                                'png' => 'image/png',
                                ),
                'post_status' => 'inherit',
                'posts_per_page' => -1,
                );
        $query_img = new WP_Query( $query_img_args );

		$we_originasize_optimizadas =  oiwe_originasize_optimizadas();

	echo "<pre>". print_r($query_img->posts, true) ."</pre>"; // ID
	echo "<hr />";
	echo "<pre>". print_r($we_originasize_optimizadas, true) ."</pre>"; //  [post_id] => 82



}


function oiwe_curl_get($url, $params){

		if (! is_array($params)){
			return false;
		}

		$query =  http_build_query($params);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url . "?" . $query );
		curl_setopt($ch, CURLOPT_USERAGENT, "Firefox (Optimizador.io)");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

		if($output === false){
		    echo '<span style="color:red;" ><b>Curl error:</b></span> ' . curl_error($ch);
		}


        curl_close($ch);

		return $output ;

}


function oiwe_validateApiKey($key){

    if (!preg_match('/^[a-zA-Z0-9]{6}\-[a-zA-Z0-9]{6}\-[a-zA-Z0-9]{6}\-[a-zA-Z0-9]{6}\-[a-zA-Z0-9]{6}$/',  $key )) {
        return false;
    }else{

		// http://optimizador.io/wp-is-apikey-valid.php?apikey=a5c967-087067-6436eb-0f79a0-5b27e0
		$result = json_decode( oiwe_curl_get("https://optimizador.io/wp-is-apikey-valid.php", array( "apikey" => $key ))  ) ;

		if ( isset($result->status) && ( $result->status == "subscribed" )){

			return true;

		}else {
			return false;
		}

    }

}

function oiwe_isAPIKeyCreated(){

    $we_api_key = get_option("weoptimizeapikey");

    if ( !preg_match('/^[a-zA-Z0-9]{6}\-[a-zA-Z0-9]{6}\-[a-zA-Z0-9]{6}\-[a-zA-Z0-9]{6}\-[a-zA-Z0-9]{6}$/',  $we_api_key  ) ) {
        return false;
    }else{
		return true;
	}

}



function oiwe_startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function oiwe_endsWith($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 || 
    (substr($haystack, -$length) === $needle);
}

