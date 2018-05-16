<?php

/**
 *
 */
function oiwe_view_main(){

	echo '<div class="wrap">';
	echo '	 <h1>Plugin optimizador de imágenes desarrollado por <a target="_blank" href="https://www.webempresa.com" >webempresa.com</a></h1>';

$active_tab = "";

if( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = $_GET[ 'tab' ];
} 

$site_domain = $_SERVER['HTTP_HOST'] ;

?>


        <div id="bwp-donation">
            <form class="paypal-form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <p style="margin-bottom: 3px;">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="LTTC84C826PFQ">
                <input type="hidden" name="lc" value="VN">
                <input type="hidden" name="button_subtype" value="services">
                <input type="hidden" name="no_note" value="0">
                <input type="hidden" name="cn" value="Would you like to say anything to me?">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="rm" value="1">
                <!-- <input type="hidden" name="return" value="https://optimizador.io"> -->
                <input type="hidden" name="currency_code" value="EUR">
                <input type="hidden" name="bn" value="PP-BuyNowBF:icon-paypal.gif:NonHosted">
                <input type="hidden" name="item_name" value="Donar a Optimizador.io" />
                <select name="amount">
                    <option value="1.00">Donar 1 Euro </option>
                    <option value="5.00">Una cerveza (5 Euros)</option>
                    <option value="10.00">1 ronda (10 Euros)</option>
                    <option value="25.00">1 cena (25 Euros) !</option>
                </select>
                <span class="paypal-alternate-input" style="display: none;"></span>
                &nbsp;
                <button class="we-button-paypal button-secondary" type="submit" name="submit">
                    <span class="paypal-via">Vía</span>
                    <span class="paypal-pay">Pay</span><span class="paypal-pal">Pal</span>
                </button>
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </p>
            </form>
        </div>




	<style type="text/css" >

		#we-get-social {
			padding:10px;
			padding-bottom:30px;
		}

		.we-twitter-buttons , .we-fb-buttons , .we-gplus-buttons {
			padding:5px;
			float:left;
		}

	</style>

    <div id="we-get-social" class="postbox">
        <h1 class="hndle"><span>Comparte si te resulta de utilidad <img src="../wp-includes/images/smilies/icon_smile.gif" /> </span></h1>
        <divo class="inside">
            <div id="we-social-buttons" class="clearfix">
                <!-- Twitter buttons -->
                <div class="we-twitter-buttons">
                    <a href="https://twitter.com/share"
                        class="twitter-share-button"
                        data-url="https://optimizador.io/"
                        data-text="Optimiza las imágenes de tu WordPress gratis con este plugin.	"
                        data-via="webempresa"
                        data-hashtags="optimizadorio"
                        data-dnt="true">Tweet</a>
                    <a href="https://twitter.com/webempresa"
                        class="twitter-follow-button"
                        data-show-screen-name="false"
                        data-show-count="true"
                        data-dnt="true">Follow Me!</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </div>
                <!-- Google plus -->
                <div class="we-gplus-buttons">
                    <div class="g-plusone" data-size="medium" data-href="https://optimizador.io/"></div>
                    <script src="https://apis.google.com/js/platform.js" async defer></script>
                </div>

                <!-- Facebook button -->
                <div class="we-fb-buttons">
                    <div class="fb-like"
                        data-href="https://optimizador.io/"
                        data-layout="standard"
                        data-action="like"
                        data-share="true"
			data-show-faces="true">
		     </div>
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.5";
                        fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                </div>
            </div>
        <br style="clear:both" />
        <div class="clear-fix">
            <a href="https://optimizador.io/dejar-testimonio/" target="_blank" ><h1>Dejanos tu testimonio y obten un link para mejorar tu SEO</h1></a>
            <a href="https://optimizador.io/sugerencias-o-dudas/" target="_blank" ><h2>¿Sugerencias o dudas? comunícate con nosotros y te responderemos...</h2></a>
        </div>
        </div>

    </div>

<style type="text/css" >

.we-button-paypal{ 
    color: #003580!important;
    text-shadow: 0 1px 1px #ffcf84!important;
    background: #ffe3b7!important;
    border-color: #ffc975!important;
    box-shadow: 0 1px 0 #ffc975!important;
    font-weight: 600;
}
</style>


<h2 class="nav-tab-wrapper">
    <a href="?page=we-img-optimizer&tab=display_resumen" class="nav-tab <?php echo ( $active_tab == 'display_resumen' || $active_tab == '' ) ? 'nav-tab-active' : ''; ?> ">Resumen</a>
    <a href="?page=we-img-optimizer&tab=display_opciones" class="nav-tab <?php echo $active_tab == 'display_opciones' ? 'nav-tab-active' : ''; ?> ">Opciones</a>
    <a href="?page=we-img-optimizer&tab=display_plan" class="nav-tab <?php echo $active_tab == 'display_plan' ? 'nav-tab-active' : ''; ?>">Planificación</a>
    <a href="?page=we-img-optimizer&tab=display_logs" class="nav-tab <?php echo $active_tab == 'display_logs' ? 'nav-tab-active' : ''; ?>">Logs</a>
    <a href="?page=we-img-optimizer&tab=display_apikey" class="nav-tab <?php echo $active_tab == 'display_apikey' ? 'nav-tab-active' : ''; ?>">Registro de API Key</a>
    <a href="?page=we-img-optimizer&tab=display_help" class="nav-tab <?php echo $active_tab == 'display_help' ? 'nav-tab-active' : ''; ?>"><span class="icon dashicons dashicons-editor-help" ></span> Ayuda</a>
    <a href="?page=we-img-optimizer&tab=display_debug" class="nav-tab <?php echo $active_tab == 'display_debug' ? 'nav-tab-active' : ''; ?>"><span class="icon dashicons dashicons-sos" ></span> Debug</a>
</h2>


<?php  if ( $active_tab == 'display_resumen' || $active_tab == '' ) { ?>
<!-- BEGIN RESUMEN TAB -->
	
	<br />
	<br />

	<?php 

		if ( isset($_GET["action"]) && $_GET["action"] == "optimizeall" ){
			// TODO: Not implemented
			oiwe_optimizeAllGallery();
		}

		$num_total_imgs =  oiwe_img_count();
		$num_originasize_optimizadas = oiwe_originasize_optimizadas();

		if ($num_total_imgs > 0) {
			$porcentage_galeria_optimizada = ( count($num_originasize_optimizadas) * 100 ) / $num_total_imgs ;
		}else {
			$porcentage_galeria_optimizada = 100;
		}

		// $total_img_optimizadas =  oiwe_total_img_optimizadas();
		    $weCountObj = oiwe_total_img_optimizadas_count();
    		$total_img_optimizadas =  $weCountObj[0]->count  ;


		$num_totalkb_saving =  oiwe_num_totalkb_saving();
		$num_percentage_average_saving = oiwe_num_percentage_average_saving();
	?>


    <h5 style="width:33%;text-align:center;float:left;">
		<span class="icon dashicons dashicons-admin-media" style="font-size:50px;margin-bottom:30px;;"></span> <hr />  
			<span style="font-size:25px;" ><?php echo $num_total_imgs ; ?></span> <hr /> 
			<span style="font-size:15px;" >Total de imágenes en la Galería</span>
	</h5>

    <h5 style="width:33%;text-align:center;float:left;">
        <span class="icon dashicons dashicons-format-gallery" style="font-size:50px;margin-bottom:30px;;"></span> <hr />
            <span style="font-size:25px;" ><?php echo count( $num_originasize_optimizadas); ?></span> <hr />
            <span style="font-size:15px;" >Imagenes de la Galería Optimizadas</span>
    </h5>

    <h5 style="width:33%;text-align:center;float:left;">
        <span class="icon dashicons dashicons-images-alt2" style="font-size:50px;margin-bottom:30px;;"></span> <hr />
            <span style="font-size:25px;" ><?php echo  $total_img_optimizadas; ?></span> <hr />
            <span style="font-size:15px;" >Total imágenes Optimizadas (miniaturas + originales)</span>
    </h5>


	<br style="clear:both;" />

	<?php 
		$thumbs = "";
		$thumbs = round($porcentage_galeria_optimizada) >= 50 ? "up" : "down";
	?>

    <h5 style="width:33%;text-align:center;float:left;">
        <span class="icon dashicons dashicons-admin-generic" style="font-size:50px;margin-bottom:30px;;"></span> <hr />
            <span style="font-size:25px;" ><?php echo  round($num_totalkb_saving[0]->saving / 1024 / 1024); ?>MB</span> <hr />
            <span style="font-size:15px;" >Total MB ahorrados</span>
    </h5>


    <h5 style="width:33%;text-align:center;float:left;">
        <span class="icon dashicons dashicons-thumbs-<?php echo $thumbs ; ?>" style="font-size:50px;margin-bottom:30px;"></span> <hr />
            <span style="font-size:25px;" ><?php echo round($porcentage_galeria_optimizada) ; ?> %</span> <br /> <hr />
            <span style="font-size:15px;" >Porcentaje de la Galería Optimizada</span>
    </h5>

    <h5 style="width:33%;text-align:center;float:left;">
        <span class="icon dashicons dashicons-smiley" style="font-size:50px;margin-bottom:30px;"></span> <hr />
            <span style="font-size:25px;" ><?php echo round($num_percentage_average_saving[0]->percent) ; ?> %</span> <br /> <hr />
            <span style="font-size:15px;" >Porcentaje medio de mejora</span>
    </h5>

	<br style="clear:both;margin-top:50px;" />


	<?php
	/*
		if ($num_total_imgs > count($num_originasize_optimizadas) ){
			echo "<br />";
			echo "<br />";
			echo "<center>";
			echo '<a href="admin.php?page=we-img-optimizer&tab=display_resumen&action=optimizeall" class="button-primary" >Planificar optimización de todas las imágenes de la galería</a>';
			echo "<center/>";
			echo "<br />";

		}
	*/
	?>


	<br style="clear:both;margin-top:50px;" />

	<!--input type="text" data-fgColor="#C00" data-bgColor="#e5e5e5"  readonly="readonly" value="<?php echo round($num_percentage_average_saving[0]->percent) ; ?> %" class="dial" --> 

	<h3>Últimas 5 imágenes optimizadas</h3>

	<?php

	    // $data_array =  oiwe_get_optimization_list();
	    $data_array = oiwe_get_optimization_list_limit(5);
	    $path = get_home_path();
	    $upload_dir = wp_upload_dir();
	    $siteurl = get_site_url();
	?>
<table class="wp-list-table widefat fixed posts">
  <col width="17%">
  <col width="28%">
  <col width="28%">
  <col width="19%">
  <col width="8%">

    <thead>
	<tr>
            <th>Fecha Optimización </th>
            <th>Nombre </th>
            <th>Imagen </th>
            <th>Detalles </th>
            <th>% Mejora</th>
        </tr>
    </thead>
    <tfoot>
	<tr>
            <th>Fecha Optimización</th>
            <th>Nombre </th>
            <th>Imagen </th>
            <th>Detalles </th>
            <th>% Mejora</th>
        </tr>
    </tfoot>
    <tbody>

			<?php

    		if( !empty( $data_array ) ) :
        	$i = 0;

	        foreach( $data_array as $row ){
	            $imgPath = str_replace($path,"",$row->img_path);
	            $i++;


	            $style="";

	            if ($i % 2 == 0){
	                $style="";
	            }else{
	                $style="background-color:#f9f9f9;padding:8px;";
	            }

			?>
                <tr style="<?php echo $style ; ?>">
                    <td><?php echo $row->time ; ?>  </td>
                    <td><a href="<?php echo $upload_dir["baseurl"] . "/" . $row->filename ; ?>" target="_blank" > <?php echo basename($upload_dir["baseurl"] . "/" . $row->filename ) ; ?> </a> </td>
                    <td style="text-align:center;"><a href="<?php echo $upload_dir["baseurl"] . "/" . $row->filename ; ?>" target="_blank" ><img width="140" src="<?php echo $upload_dir["baseurl"]  . "/" . $row->filename ; ?>" /></a></td>
                    <td>
                        <ul style="padding:0px;margin:0px;" >
                        <?php
                        echo "<li><b>Antes:</b> " . round($row->size_before/1024)   . " KB</li>" ;
                        echo "<li><b>Después:</b> " . round($row->size_after / 1024)    . " KB </li>" ;
                        echo "<li><b>Ahorro:</b> " . round($row->saving/1024)       . " KB</li>";
                        ?>
                        </ul>
                    </td>
                    <td><?php echo $row->percent_saved ; ?>%</td>
                </tr>

	<?php

		}


	endif;
	?>



	</tbody>
</table>


<h3>Planificaciones pendientes</h3>

<?php
	$data_array2 = oiwe_get_pendingtask_list();

?>

<table class="wp-list-table widefat fixed posts">

    <thead>
	    <tr>
            <th>Fecha Planificación</th>
            <th>ID de Imagen </th>
            <th>Estado </th>
        </tr>
    </thead>
    <tfoot>
    <tr>
            <th>Fecha Planificación</th>
            <th>ID de Imagen </th>
            <th>Estado </th>
        </tr>
    </tfoot>
    <tbody>

<?php
	if( !empty( $data_array2 ) ){
	    $i = 0;

            foreach( $data_array2 as $row ){
                $imgPath = str_replace($path,"",$row->img_path);
                $i++;

                if ($i > 5){
                    break;
                }

                $style="";

                if ($i % 2 == 0){
                    $style="";
                }else{
                    $style="background-color:#f9f9f9;padding:8px;";
                }
?>

		<tr style="<?php echo $style;  ?>" >
			<td><?php echo $row->time ; ?></td>
			<td><?php echo $row->img_id ; ?></td>
			<td><?php echo $row->status ; ?></td>
		</tr>
<?php
			}

	}else {

		echo "<tr>";
        echo "    <td colspan='3'>No hay optimizaciones pendientes..</td>";
        echo "</tr>";

	}
?>

	</tbody>
</table>




<!-- END RESUMEN TAB -->
<?php  } ?>



<?php  if ( $active_tab == 'display_logs' ) { ?>
<!-- BEGIN LOGS TAB -->

<!--form id="posts-filter" action="admin.php?page=we-img-optimizer" method="get"  >

	<div class="tablenav top">
		<input type="search" id="post-search-input" name="s" value="<?php echo $_GET['s'] ?>">
		<input type="text" id="post-search-input" name="page" value="we-img-optimizer" style="display:none;" >
		<input type="text" id="tab" name="tab" value="display_logs" style="display:none;" >
		<input type="submit" name="filtrar" id="post-query-submit" class="button" value="Filtrar">

	</div>

</form-->

<?php


$page_num = ( isset($_GET["pagenum"]) && !empty($_GET["pagenum"]) ) ? (int)$_GET["pagenum"] : 1 ;
$elems_per_page = 15;

$extraparams = "";

if  ( isset($_GET["s"]) && !empty($_GET["s"]) ) {

	$data_array_temp = oiwe_get_optimization_list_pagination($elems_per_page , $page_num , sanitize_file_name($_GET["s"]) );
	$data_array = $data_array_temp[1];
	$data_array_count = $data_array_temp[0] -1;

	$extraparams = "&s=" . $_GET["s"];


}else {

	$data_array_temp = oiwe_get_optimization_list_pagination($elems_per_page , $page_num );
	$data_array = $data_array_temp[1];
	$data_array_count = $data_array_temp[0] -1 ;
}


$total_optimizations = count($data_array);


$first_page = 0;
$num_pages = ceil($data_array_count / $elems_per_page );
$last_page = $num_pages;


$path = get_home_path();
$upload_dir = wp_upload_dir();
$siteurl = get_site_url();

?>



<br >

<div style="width:100%;">

<form id="posts-filter" action="admin.php?page=we-img-optimizer" method="get" style="float:left;"  >

    <div class="tablenav top">
        <input type="search" id="post-search-input" name="s" value="<?php echo $_GET['s'] ?>">
        <input type="text" id="post-search-input" name="page" value="we-img-optimizer" style="display:none;" >
        <input type="text" id="tab" name="tab" value="display_logs" style="display:none;" >
        <input type="submit" name="filtrar" id="post-query-submit" class="button" value="Filtrar">

    </div>

</form>



<div class="tablenav-pages"  style="width:300px;float:right;" ><span class="displaying-num"><?php echo  $data_array_count . " " ; echo $data_array_count > 1 ? "elementos" : "elemento" ; ?></span>  | 

<span class="pagination-links">
<?php if ( $page_num >  0 && $page_num >  1  ){ ?>
	<span class="tablenav-pages-navspan" aria-hidden="true">
	<a class="next-page" href="/wp-admin/admin.php?s&page=we-img-optimizer&tab=display_logs&pagenum=1<?php echo $extraparams ; ?>" ><span class="screen-reader-text">Inicio</span><span aria-hidden="true">
	«
	</a>
	</span>
<?php } ?>
<?php if ( $page_num >  0 && $page_num >  1  ){ ?>
	<span class="tablenav-pages-navspan" aria-hidden="true">
	    <a class="next-page" href="/wp-admin/admin.php?s&page=we-img-optimizer&tab=display_logs&pagenum=<?php echo $page_num - 1 .  $extraparams ; ?>" ><span class="screen-reader-text">Anterior</span><span aria-hidden="true">
	‹
		</a>
	</span>
<?php } ?>

<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Página actual</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $page_num; ?>" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> de <span class="total-pages"><?php echo $num_pages ; ?></span></span></span>
<?php if ( $page_num <  $last_page  ){ ?>
<span class="tablenav-pages-navspan" aria-hidden="true"> <a class="next-page" href="/wp-admin/admin.php?s&page=we-img-optimizer&tab=display_logs&pagenum=<?php echo $page_num + 1 . $extraparams  ; ?>" ><span class="screen-reader-text">Página siguiente</span><span aria-hidden="true">›</span></a> </span>
<?php } ?>
<?php if ( $page_num <  $last_page  ){ ?>
<span class="tablenav-pages-navspan" aria-hidden="true"> <a class="last-page" href="/wp-admin/admin.php?s&page=we-img-optimizer&tab=display_logs&pagenum=<?php echo $last_page . $extraparams ; ?>"><span class="screen-reader-text">Última página</span><span aria-hidden="true">»</span></a> </span>
<?php } ?>
</span></div>

</div>

<div class="tablenav top" >

</div>

<table class="wp-list-table widefat fixed posts">
  <col width="17%">
  <col width="28%">
  <col width="28%">
  <col width="19%">
  <col width="8%">

	<thead>
		<tr>
			<th>Fecha Optimización </th>
			<th>Nombre </th>
			<th>Imagen </th>
			<th>Detalles </th>
			<th>Mejora</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
            <th>Fecha Optimización</th>
            <th>Nombre </th>
            <th>Imagen </th>
            <th>Detalles </th>
            <th>Mejora</th>
        </tr>
	</tfoot>
	<tbody>

<?php 

	if( !empty( $data_array ) ) :

		$i = 0;

		foreach( $data_array as $row ){ 
			$imgPath = str_replace($path,"",$row->img_path);
			$i++;
			$style="";

			if ($i % 2 == 0){
				$style="";
			}else{
				$style="background-color:#f9f9f9;padding:8px;";
			}

		?>


			<?php if (isset($_GET["s"]) && !empty($_GET["s"]) && trim($_GET["s"]) != "" ){ ?>

				<?php if ( strpos($row->img_path, $_GET["s"]) !== false) {  ?>
                <tr style="<?php echo $style ; ?>">
					<td><?php echo $row->time ; ?></td>
					<td><a href="<?php echo $upload_dir["baseurl"] . "/" . $row->filename ; ?>" target="_blank" > <?php echo basename($upload_dir["baseurl"] . "/" . $row->filename ) ; ?></a></td>
					<td> <a href="<?php echo $upload_dir["baseurl"] . "/" . $row->filename ; ?>" target="_blank" > <img width="160" src="<?php echo $upload_dir["baseurl"] . "/" . $row->filename ; ?>" /></a></td>
					<td>
						<ul style="padding:0px;margin:0px;" >
						<?php
						echo "<li><b>Antes:</b> " . round($row->size_before/1024)   . " KB</li>" ;
						echo "<li><b>Después:</b> " . round($row->size_after / 1024) 	. " KB </li>" ;
						echo "<li><b>Ahorro:</b> " . round($row->saving/1024) 		. " KB</li>";
						?>
						</ul>
					</td>
					<td><?php echo $row->percent_saved ; ?>%</td>
				</tr>
				<?php } ?>

			<?php }else{ ?>

				<tr style="<?php echo $style ; ?>">
					<td><?php echo $row->time ; ?>  </td>
                    <td><a href="<?php echo $upload_dir["baseurl"] . "/" . $row->filename ; ?>" target="_blank" > <?php echo basename($upload_dir["baseurl"] . "/" . $row->filename ) ; ?> </a> </td>
                    <td><a href="<?php echo $upload_dir["baseurl"] . "/" . $row->filename ; ?>" target="_blank" ><img width="160" src="<?php echo $upload_dir["baseurl"]  . "/" . $row->filename ; ?>" /></a></td>
                    <td>
                       	<ul style="padding:0px;margin:0px;" >
                        <?php
                        echo "<li><b>Antes:</b> " . round($row->size_before/1024)   . " KB</li>" ;
                        echo "<li><b>Después:</b> " . round($row->size_after / 1024)    . " KB </li>" ;
                        echo "<li><b>Ahorro:</b> " . round($row->saving/1024)       . " KB</li>";
                        ?>
                       	</ul>
                    </td>
					<td><?php echo $row->percent_saved ; ?>%</td>
				</tr>

			<?php } ?>

			<?php
		} // EndForeach
	else : ?>
		<tr>
			<td colspan="3">No hay optimizaciones..</td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>

<!-- END LOGS TAB -->
<?php  } ?>



<!-- BEGIN OPTCIONES TAB -->
<?php  if ( $active_tab == 'display_opciones' ) { 


if ( isset($_POST["Submit"] ) ){

    update_option('weautoptimize', $_POST["weautoptimize"] );
    update_option('weautobackup', $_POST["weautobackup"] );
    update_option('weoptimizethumbs', $_POST["weoptimizethumbs"] );

	echo "<h3 style='color:green;'>Guardado!</h3>";
}

?>

<form id="weautoptimize_form" method="post" name="weautoptimize">
              <?php settings_fields('weimgopt_Options'); ?>

				<?php
					$weautoptimize = get_option("weautoptimize");
					$weautobackup = get_option("weautobackup");
					$weoptimizethumbs = get_option("weoptimizethumbs");
				?>

    <input type="text" id="tab" name="tab" value="display_opciones" style="display:none;" >

    <table class="form-table">

		  <col width="30%">	
		  <col width="20%">
		  <col width="50%">

        <tbody>
        <tr valign="top">
	        <td>
		        <label for="imgopt_autoptimize">Autoptimizar: 	</label>
			</td>
			<td>
				Sí <input type="radio" name="weautoptimize" value="yes" <?php echo $weautoptimize != "no" ? "checked" : "" ;  ?> />
				No <input type="radio" name="weautoptimize" value="no" <?php echo $weautoptimize == "no" ? "checked" : "" ;  ?> />
	        </td>
			<td>
				<i>Se optimizarán todas las imágenes en el momento de ser subidas a WordPress</i>
			</td>
		</tr>
		<tr>
	        <td>
		        <label for="weautobackup">Backup imagenes originales: </label>  
	        </td>
			<td>
                Sí <input type="radio" name="weautobackup" id="weautobackup" value="yes" <?php echo $weautobackup != "no" ? "checked" : "" ;  ?> />
                No <input type="radio" name="weautobackup" id="weautobackup" value="no" <?php echo $weautobackup == "no" ? "checked" : "" ;  ?> />
			</td>
			<td>
				<i>Hacer backup de todas las imágenes en "wp-content/plugins/weimgoptimizer/backups" antes de optimizarlas (Ocupa almacenamiento extra)</i>
			</td>
		</tr>
		<tr>
	        <td>
		        <label for="weoptimizethumbs" >Optimizar Thumbnails: </label>  
	        </td>
			<td>
                Sí <input type="radio" name="weoptimizethumbs" id="weoptimizethumbs" value="yes" <?php echo $weoptimizethumbs != "no" ? "checked" : "" ;  ?> />
                No <input type="radio" name="weoptimizethumbs" id="weoptimizethumbs" value="no" <?php echo $weoptimizethumbs == "no" ? "checked" : "" ;  ?> />
			</td>
			<td>
				<i>Optimizar todas las miniaturas que se generan a partir de la imagen original</i>
			</td>
		</tr>
		<tr colspan="3">
                 <td><input class="button-primary" type="submit" name="Submit" value="Guardar" /></td>
        </tr>
        </tbody>
  </table>
 </form>



<?php } ?>
<!-- END OPCIONES TAB -->

<?php  if ( $active_tab == 'display_plan' ) { ?>
<!-- BEGIN PLAN TAB -->

<?php

	if ( isset($_GET["action"]) && $_GET["action"] == "deleteplan" ){
		if (isset($_GET["idaction"]) && is_int( (int)$_GET["idaction"] ) ){

			echo "<h3 style='color:red;' >Eliminada planificación ". (int)$_GET["idaction"] ." </h3>";
			oiwe_deleteActionByID( (int)$_GET["idaction"] );

		}

	}

    $data_array2 = oiwe_get_pendingtask_list();
?>

<br />

<table class="wp-list-table widefat fixed posts">

    <thead>
	<tr>
            <th>Fecha Planificación</th>
            <th>ID de Imagen </th>
            <th>Estado </th>
            <th>Imagen </th>
            <th>Cancelar </th>
        </tr>
    </thead>
    <tfoot>
    <tr>
            <th>Fecha Planificación</th>
            <th>ID de Imagen </th>
            <th>Estado </th>
            <th>Imagen </th>
            <th>Cancelar </th>
        </tr>
    </tfoot>
    <tbody>

<?php
    if( !empty( $data_array2 ) ){
        $i = 0;

            foreach( $data_array2 as $row ){
                $imgPath = str_replace($path,"",$row->img_path);
                $i++;


                $style="";

                if ($i % 2 == 0){
                    $style="";
                }else{
                    $style="background-color:#f9f9f9;padding:8px;";
                }

		$attach = wp_get_attachment_image_src($row->img_id);
?>

        <tr style="<?php echo $style;  ?>" >
            <td><?php echo $row->time ; ?></td>
            <td><?php echo $row->img_id ; ?></td>
            <td><?php echo $row->status ; ?></td>
            <td><img src="<?php echo $attach[0] ; ?>" width="140" /></td>

            <td><a href="admin.php?page=we-img-optimizer&tab=display_plan&action=deleteplan&idaction=<?php echo $row->id ; ?>" >Cancelar</a></td>
        </tr>
<?php
            }

    }else {

	echo "<tr>";
        echo "    <td colspan='3'>No hay optimizaciones pendientes..</td>";
        echo "</tr>";

    }
?>

    </tbody>
</table>


<?php } ?>

<?php  if ( $active_tab == 'display_apikey' ) { ?>

	<?php 

		if ( isset($_GET["action"]) && $_GET["action"] == "resetlicense" ){

			// Reset license
			update_option("weoptimizeapikey", "" );
		}

		if ( isset($_GET["action"]) && $_GET["action"] == "emailvalidate" ){

			$email = trim($_GET["emailvalidate"]);

			$result = json_decode(oiwe_curl_get( "https://optimizador.io/wp-get-api-key-by-email.php" , array( "email" => $email )  ) );

			if ( isset($result->activated) && ( $result->activated == 1 || $result->activated == "1") ){

				if ( oiwe_validateApiKey( $result->apikey ) ){

					update_option("weoptimizeapikey", $result->apikey );

				}

			}else {

                if (  isset($result->error) ) {
                    echo "<p><h1 style='color:red;' >Error: " . $result->error  . "</h1>" ;
                    echo "<h2 style='color:green;'><b>Tienes que dar de alta el email que quieras usar para activar el plugin desde esta url <a href='https://optimizador.io/registro-clave-api/' target=\"_blank\">https://optimizador.io/registro-clave-api</a></b> y recuerda que tendrás que pulsar en el link que te llegará por correo a la dirección de email que pongas.</h2>";
                }else {
                    echo "<h3 style='color:red;' >ERROR: se ha producido un error para validar tu cuenta de correo indícanos tu cuenta de correo desde este formulario para que podamos revisar el problema: </h3>";
                }

                echo "<hr />";


			}

		}


	?>

	<?php 
    $we_api_key = get_option("weoptimizeapikey");

	$valid = false;

	if (!  oiwe_validateApiKey($we_api_key)  ) {
	    $valid = false;
	}else{
	    $valid = true;
	}
	?>


	<?php if (! $valid ) { ?>


	<br />
	<div style="display:block; width:100%;">
		<div style="width:33%;float:left;text-align:center;" >
			<h1>1. Da de alta tu email</h1>
			<p>
			Accede a <a href="https://optimizador.io/registro-clave-api/" target="_blank" >optimizador.io</a> y pon tu email.
			</p>
			<img src="../wp-content/plugins/weimgoptimizer/img/registroemail.png" alt="registroemail.png" />

		</div>
		<div style="width:33%;float:left;text-align:center;" >
			<h1>2. Confirma el email</h1>
			<p>
			Revisa tu bandeja de entrada y confirma el email.
			</p>
			<img src="../wp-content/plugins/weimgoptimizer/img/confirmaemail.png" alt="Valida Email" />

		</div>
		<div style="width:33%;float:left;text-align:center;" >
			<h1>3. Configura tu email en el plugin</h1>
			<p>
			Coloca en este formulario el email que has registrado.
			</p>
	    <p>
	        <form method="get">
	        <input type="text" id="emailvalidate" name="emailvalidate" value="" style="width:200px;padding:10px;" class="input" >
	        <input type="text" id="post-search-input" name="page" value="we-img-optimizer" style="display:none;" >
	        <input type="text" id="tab" name="tab" value="display_apikey" style="display:none;" >
	        <input type="text" id="tab" name="action" value="emailvalidate" style="display:none;" >
	        <input type="submit" name="validar"  class="button" value="Validar correo" style="height:40px;">

	        </form>
	    </p>

		</div>
	</div>
            <div class="clear">
                <br><br>
                <p style="font-size:1.3em;">Si tienes <a href="https://optimizador.io/sugerencias-o-dudas/" target="_blank">Sugerencias o dudas</a> puedes ponerte en contacto con nosotros desde este <a href="https://optimizador.io/sugerencias-o-dudas/" target="_blank">formulario</a>.</p>
            </div>


	<?php }else { ?>

		<br />

		<p>
			<center>
			<b><span style='color:green;font-size:1.8em;'>Validación Correcta</span></b> <br /> <br />
			Tu API Key es:  <b><?php echo $we_api_key ; ?></b>
			<br />
			<br />

       	<form method="get">
        <input type="text" id="post-search-input" name="page" value="we-img-optimizer" style="display:none;" >
        <input type="text" id="tab" name="tab" value="display_apikey" style="display:none;" >
        <input type="text" id="tab" name="action" value="resetlicense" style="display:none;" >
		<input type="submit" style="font-size:1.5em;padding:10px;height:48px;" title="Usar un email nuevo" class="button" value="Borrar licencia" />

		</form>

			</center>

		</p>
	<?php } ?>


<?php } ?>

<?php  if ( $active_tab == 'display_help' ) { ?>
	<style>
		.optimizadoriofaq li{
			margin-top:15px;
		}
	</style>

	<br />
	<p style='text-align:center;'>
	<iframe width="560" height="315" src="https://www.youtube.com/embed/FoFLaFUy4J8" frameborder="0" allowfullscreen></iframe>
	</p>

	<h1>FAQ</h1>
	<p >
		<ol class="optimizadoriofaq" style="font-size:1.2em;" >
			<li><b>He instalado el plugin y no veo donde puedo optimizar mis imágenes</b> <br />
				Las imágenes se pueden optimizar de forma manual desde la <a href="upload.php?mode=list" >Biblioteca de medios</a>. Ten en cuenta que las opciones de optimización solamente aparecen en el modo Lista de la biblioteca de medios. Si pulsas en <a href="upload.php?mode=list" >este mismo enlace</a> puedes acceder
			</li>
			<li>
			 <b>Las imágenes se quedan en modo Planificado, pero nunca se optimizan</b> <br />
				Optimizador.io usa el sistema de wp-cron para optimizar las imágenes en segundo plano sin que tengas que hacerlo de forma manual. Si las imágenes que se quedan planificadas no se optimizan nunca, normalmente será por que no está funcionando wp-cron correctamente. Comprueba que no tengas definida la variable "DISABLE_WP_CRON" a true en tu wp-config.php y si aún así sigue sin funciona, crea una tarea cron en tu panel de control de Hosting. La tarea cron debería ejecutarse una vez cada 5 minutos y tendría que ser del tipo "php /home/CUENTA/public_html/wp-cron.php". IMPORTANTE: tienes que personalizar este código a los datos de tu cuenta.
			</li>
			<li>
			<b>En la biblioteca de medios aparece el texto "Optimizado con IMGOptimizer"</b> <br />
			Esto significa que las imágenes ya están optimizadas con el optimizador de Webempresa <a href="https://www.webempresa.com/hosting/optimizacion-de-imagenes-gratuito-con-imgoptimizer.html">IMGOptimizer</a>. Este es un servicio aparte que optimiza todas las imágenes de la cuenta. Las imágenes que subas a partir de la optimización se optimizarán con el plugin, pero las ya opimizadas no se optimizarán automáticamente por ya estar optimizadas.
			</li>
			<li>
			<b>¿Si subo una imagen, el plugin automáticamente las optimiza? por ejemplo, ¿si yo subo una foto de 3 megas, automáticamente las convierte a una de 80kb?</b> <br />
			Si tienes la <a href="admin.php?page=we-img-optimizer&tab=display_opciones">opción de Autoptimizar</a> marcada como Sí, las imágenes quedan planificadas para ser optimizadas en la siguiente ejecución de wp-cron, que será durante los siguientes 5 minutos.
			</li>
			<li>
			<b>Si yo quiero optimizar las imágenes que ya he subido a lo largo de los meses, donde está el botón de optimizar todas las imágenes o similar</b> <br />
			En este momento no hay aun un botón de "Optimizar todo", pero se puede hacer fácilmente desde la <a href="upload.php?mode=list" >Biblioteca de medios</a>, Seleccionando todas las imágenes y pulsando en las acciones en lote "Optimizar seleccionados".
			</li>
            <li>
                <b>Puedes usar la misma dirección de email para validar el api key en tantos WordPresses como administres.</b>
            </li>
		</ol>
	</p>
	<br />
	<p style="font-size:1.3em;">
	Si tienes <a href="https://optimizador.io/sugerencias-o-dudas/" target="_blank">Sugerencias o dudas</a> puedes ponerte en contacto con nosotros desde este <a href="https://optimizador.io/sugerencias-o-dudas/" target="_blank">formulario</a>.
	</p>

<?php } ?>

<?php  if ( $active_tab == 'display_debug' ) {
global $wpdb;
global $wp_version;

// https://optimizador.io/wp-get-api-key-by-email.php == Array ( [email] => javier@webempresa.eu )

$salida_curl_servidores_validacion = oiwe_curl_get('https://optimizador.io/wp-get-api-key-by-email.php', array("email" => "inexistentemail@webempresa.eu" ) );


$oiwe_tema_actual = wp_get_theme();
$oiwe_usuario_actual = wp_get_current_user();
$oiwe_uploaddir = wp_get_upload_dir();

    $oiwe_info = array(
            	'Versión WordPress' => $wp_version,
            	'Url Sitio' => site_url(),
            	'Home Path' => get_home_path(),
		'Upload dir' => $oiwe_uploaddir['basedir'],
		'Nombre Usuario' => $oiwe_usuario_actual->display_name,
		'email Usuario' => $oiwe_usuario_actual->user_email,
		'Optimizador API-KEY' => get_option("weoptimizeapikey"),
            	'Versión PHP' => PHP_VERSION,
      		'Servidor Web' => (!empty($_SERVER["SERVER_SOFTWARE"])) ? $_SERVER["SERVER_SOFTWARE"] : 'N/A',
      		'Server OS' => (function_exists('php_uname')) ? utf8_encode(php_uname()) : 'N/A',
            	'Versión MySQL' => $wpdb->db_version(),
            	'Multisitio' => is_multisite() ? 'yes' : 'no',
            	'WP_MEMORY_LIMIT' => WP_MEMORY_LIMIT,
            	'WP_MAX_MEMORY_LIMIT' => WP_MAX_MEMORY_LIMIT,
            	'PHP memory_limit' => ini_get('memory_limit'),
      		'PHP max_execution_time' => ini_get('max_execution_time'),
      		'PHP upload_max_filesize' => ini_get('upload_max_filesize'),
      		'PHP post_max_size' => ini_get('post_max_size'),
      		'WP_DEBUG' => WP_DEBUG,
      		'WordPress Idioma' => get_locale(),
      		'Plugins Activos' => join(", ", get_option('active_plugins')),
		'Tema en uso' => $oiwe_tema_actual->get('Name'). ' (version '.$oiwe_tema_actual->get('Version').')',
		'Resultado Curl test' => $salida_curl_servidores_validacion ,
                );
    ?>
    <br />
    <h1>Información de Debug:</h1>
    <br />
        <textarea name="oiwe_debug" rows="30" cols="200">
        <?php foreach($oiwe_info as $key => $val){
		echo $key ." = ". $val ."\n";
	}
	?>
        </textarea>
	<p>Nuestros técnicos te pueden solicitar esta información para revisar problemas con el plugin.</p>
<?php } ?>

<?php
	/*
	* FINAL FUNCION PRINCIPAL
	*/
	//echo '</div>' ;

	// wp_admin_encolado_scripts_views();
	// add_action( 'admin_enqueue_scripts', 'wp_admin_encolado_scripts_views' );

}

