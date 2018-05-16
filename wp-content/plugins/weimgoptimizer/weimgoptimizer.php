<?php
/**
* Plugin Name: optimizador.io
* Plugin URI: https://optimizador.io/
* Description: Optimiza las imágenes de la biblioteca de medios, de forma automática, usando algoritmos de compresión Lossy
* Version: 1.0.21
* Author: David Noguera (webempresa.com)
* Author URI: https://www.webempresa.com/
**/

require_once("includes/constants.php");
require_once("includes/helper.php");
require_once("includes/views.php");


    if ( isset($_GET["weaction"]) && $_GET["weaction"] == "deleteplanlib" ){
        if (isset($_GET["idaction"]) && is_int( (int)$_GET["idaction"] ) ){
			echo '<div id="message" class="notice  notice-error is-dismissible" style="padding:12px;"><span style="font-size:15px;">Eliminada la planificación ' .  (int)$_GET["idaction"] . ' </span></div>';
           	oiwe_deleteActionByImgID( (int)$_GET["idaction"] );
        }

    }


add_action( 'admin_menu', 'oiwe_imgoptimizer_main' );


function oiwe_imgoptimizer_main()
{
 add_menu_page(
 'optimizador.io - Optimizador de imágenes para WordPress', // Title of the page
 'optimizador.io', // Text to show on the menu link
 'manage_options', // Capability requirement to see the link
 'we-img-optimizer',
 'oiwe_view_main', // The 'slug' - file to display when clicking the link
 'dashicons-images-alt2',
 10
 );
}


add_filter( 'wp_generate_attachment_metadata', 'oiwe_filter_wp_generate_attachment_metadata', 10, 2 );

function oiwe_filter_wp_generate_attachment_metadata($metadata, $attachment_id ) {

    $weautoptimize = get_option("weautoptimize");

	if ($weautoptimize != "no"){
			global $wpdb;

            $wpdb->insert(
                $wpdb->prefix . "imgoptimizeractions",
            array(
                'time' => current_time( 'mysql' ),
                'img_id' => $attachment_id,
                'action' => "optimize" ,
                'status' => "pending"
            )
            );
	}


	return $metadata;


};



// TODO: Este hook se ejecuta cuando se sube una imagen

function custom_upload_filter( $file ){

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "http://apiv1.optimizador.io:80/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$post = array(
	    "file" => "@" .realpath("/Users/davidnoguera/Downloads/gordas.png")
	);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_POST, 1);

	$headers = array();
	$headers[] = "Content-Type: application/x-www-form-urlencoded";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);


	//	copy($file["tmp_name"], "/path/img.png" ) ;


	if ( $file["type"] == "image/png" || $file["type"] == "image/jpg" || $file["type"] == "image/jpeg" ){
		$log = "-- " . print_r($file, true) . "\n" ;

		// copy($file["tmp_name"], $file["tmp_name"] . ".png" );

		oiwe_optimize_image($file["tmp_name"] );

	}

    return $file;
}



	add_action( 'manage_media_custom_column',
             'oiwe_render_media_column' ,
            10, 2
        );


    function oiwe_render_media_column($column, $id ) {
        if ( "we-img-optimizer" === $column ) {

			$meta_value_result = oiwe_get_meta_value_from_post_id($id);
			if ($meta_value_result[0]->meta_key == "_wp_attached_file" ){
				 if (  !oiwe_endsWith( strtolower($meta_value_result[0]->meta_value ), "png" ) && !oiwe_endsWith( strtolower($meta_value_result[0]->meta_value ), "jpg" ) && !oiwe_endsWith( strtolower($meta_value_result[0]->meta_value ), "jpeg" ) ){
					return ;
				}

			}


			$metadata = wp_get_attachment_metadata( $id );
			if ( ! isset($metadata["sizes"] ) ){
				return;
			}

			$first_size = array();
			$count = 0;

			foreach ($metadata["sizes"] as $size) {

				if ($count == 0){
					$first_size = $size ;
				}

				$count++;
			}

			if (strpos( $first_size["mime-type"], 'gif') !== false) {
			    return ;
			}


			$originalFileName = basename($metadata["file"]) ;
			$path = realpath(dirname(__FILE__));

			if (function_exists("posix_getpwuid") ){

				$user = posix_getpwuid(posix_getuid()) ;
				if ( file_exists( $user["dir"] .  "/.imgoptimizer" ) ) {
				    //  filemtime( $user["dir"] .  "/.imgoptimizer" );
	    		    $timeImgOptimizer = filemtime( $user["dir"] .  "/.imgoptimizer")  ;

					if ( file_exists( $path . DIRECTORY_SEPARATOR . "..". DIRECTORY_SEPARATOR ."..". DIRECTORY_SEPARATOR ."..". DIRECTORY_SEPARATOR ."wp-content". DIRECTORY_SEPARATOR ."uploads" . DIRECTORY_SEPARATOR . $metadata["file"] ) ){
						$timeFile = filemtime( $path . DIRECTORY_SEPARATOR . "..". DIRECTORY_SEPARATOR ."..". DIRECTORY_SEPARATOR ."..". DIRECTORY_SEPARATOR ."wp-content". DIRECTORY_SEPARATOR ."uploads" . DIRECTORY_SEPARATOR . $metadata["file"]  )  ;

						if ($timeFile < $timeImgOptimizer ){
							echo "Optimizado con IMGOptimizer";
							return ;
						}
					}

				}

			}



			$optimizations =  oiwe_get_optimization_data_by_attID($id) ;


			echo "<div class='we-ajax-container' id='we-optimize-container-". $id ."' >";

			if (is_array($optimizations) && isset($optimizations[0]) && !empty($optimizations[0]) ){


				$optimizations_old = $optimizations;

				if (count($optimizations) > 1){
					$optimizations[0] = $optimizations[ count($optimizations) - 1 ];
				}


				add_thickbox();
				echo "<span class='icon dashicons dashicons-yes' style='color:green;'></span> Optimizado <br /><hr />";
				echo "<ul style='margin:0px;padding:0px;'>";
				echo "	<li><b>Reducción</b>: " . floor($optimizations[0]->saving / 1024 ) . " KB (". $optimizations[0]->percent_saved ."%) </li>";
				echo "	<li><b>Antes</b>: " . floor($optimizations[0]->size_before / 1024 ) . " KB </li>";
				echo "	<li><b>Después</b>: " . floor($optimizations[0]->size_after / 1024 ) . " KB </li>";

				if ( file_exists( $path . DIRECTORY_SEPARATOR . "backups" . DIRECTORY_SEPARATOR . $originalFileName ) ){
					$backup_url =  site_url() .  "/wp-content/plugins/weimgoptimizer/backups/" . $originalFileName ;

					echo "	<li><a target='_blank' href='". $backup_url ."'  >Ver backup de la imagen original</a></li>";
				}

				echo "</ul>";
				echo "<hr />";
			 	echo '<a data-id="'. $id .'" href="#TB_inline?width=750&height=450&inlineId=my-content-id'. $id .'" class="thickbox" >Ver Detalles</a>';

				$optDetails = oiwe_get_optimization_byUUID($optimizations[0]->uuid);

				?>
				<div id="my-content-id<?php echo $id; ?>" style="display:none;">

					<h3><?php echo basename($optimizations[0]->img_path ); ?> ( <?php echo $optimizations[0]->time; ?> ) </h3>

					<table style='width:100%;border: 1px solid #e5e5e5;border-collapse: collapse; white-space: nowrap;' >
						<thead>
							<tr>
								<th style="padding: 8px 10px;border-bottom: 1px solid #e5e5e5;font-size: 14px;" >Tipo de miniatura</th>
								<th style="padding: 8px 10px;border-bottom: 1px solid #e5e5e5;font-size: 14px;" >Antes</th>
								<th style="padding: 8px 10px;border-bottom: 1px solid #e5e5e5;font-size: 14px;" >Después</th>
								<th style="padding: 8px 10px;border-bottom: 1px solid #e5e5e5;font-size: 14px;" >Reducción</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0;

								$totalKB = 0;

								foreach ($optDetails as $thumb){
								if ($i % 2 == 0){
									echo '<tr style="background-color:#f9f9f9;padding:8px;"  >';
								}else {
									echo '<tr style="padding:8px;">';
								}
							?>
								<td style="padding:8px;" >
								<?php
									if ( $thumb->thumb_size == "we_original_size" ){
										echo "Original";
									}else {
										echo $thumb->thumb_size;
									}
								?>
								</td>
								<td style="padding:8px;" ><?php echo floor($thumb->size_before / 1024) ?> KB</td>
								<td style="padding:8px;" ><?php echo floor($thumb->size_after / 1024 ) ?> KB</td>
								<td style="padding:8px;" ><?php echo floor($thumb->percent_saved) ?> %</td>
							</tr>
							<?php
								$i++;
								$totalKB += floor($thumb->size_before / 1024) - floor($thumb->size_after / 1024 ) ;
							} ?>
						</tbody>
					</table>
					<p>
						<?php echo "<b>Total Ahorrado:</b> $totalKB KB" ; ?>
					</p>
				</div>
				<?php


			}else {


		        $isPlannedResult = oiwe_isPlanned($id);

		        if ( count($isPlannedResult) <= 0 ) {
					echo "<center  style='padding-top:10px;'><button type='button' class='button button-small button-primary optimize-from-library' data-id='". $id ."' >Optimizar ahora</button></center>";
				}else {
					echo "<center style='padding-top:10px;' ><div class='dashicons dashicons-cloud' ></div> <b>Planificado</b> <br /> <a href='upload.php?weaction=deleteplanlib&idaction=". $id ."'>Cancelar</a> </center>";
				}

			}

			echo "<span class='icon  spinner'></span>";

			echo "<center><img src='images/spinner.gif' alt='spinner' class='wedashspinner' style='display:none;' /><span style='display:none;' class='wedashspinnertext' >Optimizando...</span></center> ";


			echo "</div>";
		}
    }


	add_filter( 'manage_media_columns',
            'oiwe_add_media_columns'
        );

    function oiwe_add_media_columns($columns ) {
	    if ( oiwe_isAPIKeyCreated() ){
	        $columns[ "we-img-optimizer" ] = "Optimización";
		}
        return $columns;
    }


/*
* BULK ACTIONS
*/

add_filter( 'bulk_actions-upload', 'oiwe_register_bulk_img_optimize' );

function oiwe_register_bulk_img_optimize($bulk_actions) {

  if (  oiwe_isAPIKeyCreated() ){
	  $bulk_actions['optimize_selected_separator'] = "--------";
	  $bulk_actions['optimize_selected'] = "Optimizar seleccionados";
	}
  return $bulk_actions;
}

add_filter( 'handle_bulk_actions-upload', 'oiwe_my_bulk_img_optimization', 10, 3 );

function oiwe_my_bulk_img_optimization($redirect_to, $doaction, $post_ids ) {

  if ( $doaction !== 'optimize_selected' ) {
    return $redirect_to;
  }
	$i = 0;

//
// Finalmente hago que todas las optimizaciones se planifiquen..
//
/*  if ( count($post_ids) <= 2 ) {

	  foreach ( $post_ids as $post_id ) {
			$i++;
	    	// Perform action for each post.
			// post_id es attach_id
			we_log_to_file("BULK OPTIMIZATION " . $i . " ============ " , $post_id );

			// TODO:: Hacer esto con tareas en background tipo wpcron
			// optimize_image_by_att_id($post_id);
			optimize_concurrent_image_by_att_id($post_id);


  	}
  	$redirect_to = add_query_arg( 'weimgs_optimized', count( $post_ids ), $redirect_to );
  	return $redirect_to;

  }else {
*/
		// Añadimos los ID de imagen a los action.
	global $wpdb;
	$plannedCount = 0;
    foreach ( $post_ids as $post_id ) {

		$isPlannedResult = oiwe_isPlanned($post_id);

		$isOptimizedResult = oiwe_isOptimized ($post_id);


		if (count($isPlannedResult) <= 0 && count($isOptimizedResult) <= 0 ) {
			$plannedCount += 1;
        	$wpdb->insert(
            	$wpdb->prefix . "imgoptimizeractions",
            array(
                'time' => current_time( 'mysql' ),
                'img_id' => $post_id,
                'action' => "optimize" ,
                'status' => "pending"
            )
        	);

		}

	}

    $redirect_to = add_query_arg( 'weimgs_planned', $plannedCount, $redirect_to );
    return $redirect_to;

/*
	}
*/


}


add_action( 'admin_notices', 'oiwe_my_bulk_optimizations_admin_notice' );

function oiwe_my_bulk_optimizations_admin_notice() {
 
	global $pagenow;


   	if ( ! empty( $_REQUEST['weimgs_optimized'] ) ) {
	    $optimized_count = intval( $_REQUEST['weimgs_optimized'] );
	    printf( '<div id="message" class="updated fade" style="padding:15px;" ><span style="font-size:20px;">' . "Optimizadas $optimized_count imágenes" . "</span></div>" );
	}

	if ( ! empty( $_REQUEST['weimgs_planned'] ) ) {
	    $optimized_count = intval( $_REQUEST['weimgs_planned'] );
	    printf( '<div id="message" class="updated fade" style="padding:15px;" ><span style="font-size:20px;">' . "Se ha planificado la optimización de $optimized_count imágenes" . "</span></div>" );
	}

	if ( !oiwe_isAPIKeyCreated() ){
	    echo '<div id="message" class="notice  notice-error is-dismissible" style="padding:12px;" ><span style="font-size:15px;">' . "No has creado una cuenta en <a href='https://optimizador.io/' target='_blank' >optimizador.io</a> aún, obtén un API Key para poder empezar optimizar imágenes, <a href='admin.php?page=we-img-optimizer&tab=display_apikey' >Obtén aquí.</a> </span></div>" ;

	}

	if ( $pagenow != 'upload.php' && $pagenow != 'index.php') {
		return;
	}


	$num_total_imgs =  oiwe_img_count();
    $num_originasize_optimizadas = oiwe_originasize_optimizadas();
    //$num_originasize_optimizadas = oiwe_originasize_optimizadas_count();


	if ($num_total_imgs > 0) {
	    $porcentage_galeria_optimizada = ( count($num_originasize_optimizadas) * 100 ) / $num_total_imgs ;
	}else {
		$porcentage_galeria_optimizada = 100 ;
	}

    // $total_img_optimizadas =  count(oiwe_total_img_optimizadas());
	$weCountObj = oiwe_total_img_optimizadas_count();
    $total_img_optimizadas =  $weCountObj[0]->count ;

	$we_num_totalkb_saving = oiwe_num_totalkb_saving();

    $num_totalkb_saving =  round ( $we_num_totalkb_saving[0]->saving / 1024 / 1024  ) ;

	$we_num_percentage_average_saving = oiwe_num_percentage_average_saving();

    $num_percentage_average_saving = round( $we_num_percentage_average_saving[0]->percent );

	$smily = " <img src='../wp-includes/images/smilies/icon_smile.gif' />";

	if (  oiwe_isAPIKeyCreated() ){

		if ( $num_percentage_average_saving < 13) {
			$smily = "";
		}


	    echo '<div id="message" class="notice notice-info is-dismissible" style="padding:15px;" ><span style="font-size:18px;">' . "<a href='admin.php?page=we-img-optimizer' >optimizador.io</a>: $total_img_optimizadas imágenes optimizadas, ${num_totalkb_saving}MB reducidos , $num_percentage_average_saving% media de mejora en imágenes" . " $smily </span></div>" ;

		$weautoptimize = get_option("weautoptimize");
		if ($weautoptimize == "no"){
		    echo '<div id="message" class="notice  notice-error is-dismissible" style="padding:12px;" ><span style="font-size:15px;">' . "No tienes habilitada la opción de optimizar las imágenes que subas a la galería de forma automática, <a href='admin.php?page=we-img-optimizer&tab=display_opciones' >Cambiar aquí.</a> </span></div>" ;
		}

	}

	?>


<style type="text/css" >

#XHRMessage {
	margin: 15px;
	margin-left:0px;

}

#weoptislider * {box-sizing:border-box}

/* Slideshow container */
#weoptislider .slideshow-container {
  position: relative;
  margin: auto;
}

#weoptislider .mySlides {
    display: none;
}

/* Next & previous buttons */
#weoptislider .prev, #weoptislider .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -22px;
  padding: 16px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
}

/* Position the "next button" to the right */
#weoptislider .next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
#weoptislider .prev:hover, #weoptislider .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
#weoptislider .text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
#weoptislider .numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
#weoptislider .dot {
  cursor:pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

#weoptislider .active, #weoptislider .dot:hover {
  background-color: #717171;
}

/* Fading animation */
#weoptislider .fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}


div.weimgoptimized {
  width:160px;
  height:130px;
  background-repeat:no-repeat;
  background-size:cover;
}

</style>

<script type="text/javascript">

var slideIndex = 0;
function oiwe_showSlides(auto) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    if (slides.length > 0) {
	    for (i = 0; i < slides.length; i++) {
	        slides[i].style.display = "none";
	    }
	    slideIndex++;
	    if (slideIndex > slides.length) {slideIndex = 1}
	    slides[slideIndex-1].style.display = "block";
		if (typeof auto === "undefined" ||  auto == true) {
		    setTimeout(oiwe_showSlides, 25000); 
		}
	}
}

jQuery().ready(function() {
	oiwe_showSlides();
});


</script>

<div id="weoptislider">

	<div class="slideshow-container">

	<?php


		// El Slider solamente saldrá en la Home de wp-admin para que no moleste demasiado
		if ( basename( $_SERVER["SCRIPT_NAME"] )  == "index.php"){
			$resultado = oiwe_get_nlast_optimizations(3);

	        $path = get_home_path();
	        $upload_dir = wp_upload_dir();
	        $siteurl = get_site_url();

			for ($i=0; $i < count($resultado); $i++){
				echo '<div class="mySlides fade notice notice-info" style="display:none;padding:13px;font-size:15px;">';
				echo "<table width='100%' style='line-height:1.5em;' ><tr> <td width='80%' valign='top' > <a style='font-size:1.2em;' href='admin.php?page=we-img-optimizer'  >Últimas 3 imágenes optimizadas por optimizador.io</a> <br /><br /> <b>Fecha:</b> ". $resultado[$i]->time ." <br /><b>Fichero: </b><a target='_blank' href='". $upload_dir["baseurl"] . "/" . $resultado[$i]->meta_value ."'>" . basename($resultado[$i]->img_path) . "</a> <br /> <b>Mejora: </b>" .  $resultado[$i]->percent_saved  . "% <br /> <a style='font-size:0.9em;' onclick='oiwe_showSlides(false);' href='#' >Siguiente &#10095;</a> </td><td align='center'>  	<div class='weimgoptimized' style='background-image:url(" . $upload_dir["baseurl"] . "/" . $resultado[$i]->meta_value .")'></div> </b></td></tr></table>";
				echo '</div>';
			}
		}

	?>

 	</div>

</div>

	<?php

}

/*
* Javascript admin scripts
*/

function oiwe_wp_admin_encolado_scripts(){

	global $PLUGIN_VERSION;

	wp_register_script( 'weimgoptimizer_admin',
	            plugins_url( '/js/admin.js', __FILE__ ),
	            array(), $PLUGIN_VERSION , true
	        );

	wp_enqueue_script('weimgoptimizer_admin');
}

add_action( 'admin_enqueue_scripts', 'oiwe_wp_admin_encolado_scripts' );



/*
*  AJAX HANDLERS
*/

add_action( 'wp_ajax_oiwe_compress_image_from_library',
	'oiwe_compress_image_from_library'
);


function oiwe_compress_image_from_library() {

//    if ( ! check_ajax_referer('xxxxxxxxxx', '_nonce', false) ) {
//	    exit();
//    }

	if ( ! current_user_can( 'upload_files' ) ) {
            echo "No tienes permisos para subir imágenes" ;
            exit();
        }
	if ( empty( $_POST['id'] ) ) {
            echo "No se ha indicado un ID válido" ;
            exit();
        }

		$id = intval( $_POST['id'] );
        $metadata = wp_get_attachment_metadata( $id );
        if ( ! is_array( $metadata ) ) {
            echo "No se ha encontrado metainformacion para el fichero" ;
            exit;
        }


//		FORMA SINCRONA
//
//		$total_res = optimize_image_by_att_id($id);


		$total_res = oiwe_optimize_concurrent_image_by_att_id($id);

		if ($total_res == false){
			$total_res = array( "result" => "Ya optimizado" );
		}

		header('Content-Type: application/json');
		echo json_encode($total_res);

        exit();

}


/*
* TABLE CREATION
*/

// https://codex.wordpress.org/Creating_Tables_with_Plugins

function oiwe_install () {
	global $wpdb;

	$TABLENAME =  "imgoptimizations";

   	$table_name = $wpdb->prefix . $TABLENAME;

	$charset_collate = $wpdb->get_charset_collate();

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


    if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name){

		$sql = "CREATE TABLE $table_name (
		  id int(32) NOT NULL AUTO_INCREMENT,
		  uuid varchar(64) NOT NULL,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  meta_id int(32) NOT NULL,
		  saving int(32) NOT NULL,
		  size_before int(32) NOT NULL,
		  size_after  int(32) NOT NULL,
		  time_spent  int(32) NOT NULL,
		  percent_saved int(32) NOT NULL,
		  thumb_size varchar(128) NOT NULL,
		  img_path varchar(512) DEFAULT '' NOT NULL,
		  meta_value text DEFAULT '' NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";
		dbDelta( $sql );

	}

	$table_name_actions = $wpdb->prefix . "imgoptimizeractions";

    if($wpdb->get_var( "show tables like '$table_name_actions'" ) != $table_name_actions){

	    $sql = "CREATE TABLE $table_name_actions (
	      id int(32) NOT NULL AUTO_INCREMENT,
	      img_id int(32) NOT NULL,
	      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	      action varchar(128) NOT NULL,
	      status varchar(128) NOT NULL,
	      comment varchar(128) NOT NULL,
	      PRIMARY KEY  (id)
	    ) $charset_collate ;";

	    dbDelta( $sql );
	}

}

register_activation_hook( __FILE__, 'oiwe_install' );





/*
* CRON Scheduler
*/



function oiwe_my_cron_schedules($schedules){
    if(!isset($schedules["5min"])){
        $schedules["5min"] = array(
            'interval' => 5*60,
            'display' => __('Once every 5 minutes'));
    }
    if(!isset($schedules["30min"])){
        $schedules["30min"] = array(
            'interval' => 30*60,
            'display' => __('Once every 30 minutes'));
    }
    return $schedules;
}
add_filter('cron_schedules','oiwe_my_cron_schedules');


add_action( 'my_schedule_hook', 'oiwe_my_schedule_function' );

if ( ! wp_next_scheduled( 'my_schedule_hook' ) ) {
	wp_schedule_event(time(), '5min', 'my_schedule_hook' );
}

function oiwe_my_schedule_function(){


	if ( ! oiwe_isAPIKeyCreated() ){
		return ;
	}

    // wp_mail( $to, $subject, $message );

	$actionList = oiwe_get_pendingtask_list();

	if ( count($actionList)  > 0 ){

		$timeToSleep = rand(1,20);

		// echo "Durmiendo $timeToSleep \n";
		sleep( $timeToSleep );
	}

	for( $i = 0; $i < count($actionList); $i++ ){

		if ($i >= 4){
			break;
		}


		$task = $actionList[$i];
		/*
		 stdClass Object
	       	(
	            [id] => 3
	            [img_id] => 100
	            [time] => 2017-11-13 16:48:34
	            [action] => optimize
	            [status] => pending
	            [comment] =>
	       	)
		*/

		$result = oiwe_optimize_concurrent_image_by_att_id($task->img_id, 0 , "wpcron");

		if ($result != false){
			oiwe_setTaskAsDone ($task->id);
			 oiwe_log_to_file("IMG CRON", "Image: " . $task->img_id . ", Task: " . $task->id . ", Done");
		}else {
			oiwe_setTaskAsDone ($task->id);
			 oiwe_log_to_file("IMG CRON", "Image: " . $task->img_id . ", Task: " . $task->id . ", Fail, " . print_r($result, true ) );
		}

	}

}






/*
*	Custom upgrades
*/


function oiwe_check_for_update($transient ) {

    if ( empty( $transient->checked ) ) {
        return $transient;
    }


	if ( !function_exists("plugin_basename") ){
		return $transient;
	}

	//
	// Mejor no usamos get_plugin_data para evitar problemas
	//
	// $plugin_data = get_plugin_data( __FILE__ );
	// $plugin_version = $plugin_data['Version'];

	global $PLUGIN_VERSION;
	$plugin_version = $PLUGIN_VERSION;


	$info = json_decode(file_get_contents("https://optimizador.io/pluginupdates.json") ) ;

	  if (  version_compare( $plugin_version , $info->version, '<') ) {

            $plugin_slug = plugin_basename( __FILE__ );

            $transient->response[$plugin_slug] = (object) array(
                'new_version' => $info->version ,
                'package' => $info->download_url,
                'slug' => $plugin_slug
            );
    }

    return $transient;
}

add_filter( 'pre_set_site_transient_update_plugins', 'oiwe_check_for_update'  );


function oiwe_plugins_api_handler($res, $action, $args ) {
    if ( $action == 'plugin_information' ) {

        if ( isset( $args->slug ) && $args->slug == plugin_basename( __FILE__ ) ) {

			$info = json_decode(file_get_contents("https://optimizador.io/pluginupdates.json") ) ;

            $res = (object) array(
                'name' => $info->name,
                'version' => $info->version ,
                'slug' => $args->slug,
                'download_link' => $info->download_url ,

                'tested' => $info->tested,
                'requires' => $info->requires,
                'last_updated' => $info->last_updated,
                'homepage' => $info->homepage,
				'sections' => array( 'description' => $info->sections->description, 'installation' => $info->sections->installation , 'changelog' => $info->sections->changelog ) ,
                'banners' => array(
                    'low' => $info->banners->low,
                    'high' => $info->banners->high
                ),

                'external' => true
            );
            if ( 1 == 2 ) {
                $res['sections']['changelog'] = "Changelog";
            }
            return $res;
        }
    }
    return false;
}


add_filter( 'plugins_api', 'oiwe_plugins_api_handler' , 10, 3 );



