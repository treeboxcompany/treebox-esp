

function oiwe_getOptimizeResultTemplate(reduction, percent,  before, after, id){

	var contanerResult = '<span class="icon dashicons dashicons-yes" style="color:green;"></span> Optimizado <br>' + 
							'<hr><ul style="margin:0px;padding:0px;">	' +
							'		<li><b>Reducción</b>: '+ Math.ceil(reduction / 1024) +' Kb ('+ Math.ceil(percent) +'%) </li>	' +
							'		<li><b>Antes</b>: '+ Math.ceil(before / 1024 ) +' Kb </li>	 ' +
							'		<li><b>Después</b>: '+ Math.ceil(after / 1024) +' Kb </li> ' +
							'	</ul> ' +
							'<hr> ' +
							'<!--a data-id="'+ id +'" href="#">Ver Detalles</a-->';

	return contanerResult;

}


  function oiwe_compressImage(el, id) {


//    var container = el.closest('div.we-ajax-container')
//    element.attr('disabled', 'disabled')
//    container.find('span.spinner').removeClass('hidden')
//    container.find('span.dashicons').remove()


	var container = jQuery("#we-optimize-container-" + id );

	jQuery("#we-optimize-container-" + id + " img.wedashspinner" ).show();
	jQuery("#we-optimize-container-" + id + " .wedashspinnertext" ).show();
	jQuery("#we-optimize-container-" + id + " button.optimize-from-library" ).addClass("disabled");
	jQuery("#we-optimize-container-" + id + " button.optimize-from-library" ).hide();

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
       	_nonce: "nonce",
       	action: 'oiwe_compress_image_from_library',
       	id: id
      },
      success: function(data) {

			var template = oiwe_getOptimizeResultTemplate(data.we_original_size.size_saved, data.we_original_size.percent_saved, data.we_original_size.size_before, data.we_original_size.size_after , id);
			jQuery(container).html(template);

			jQuery("#we-optimize-container-" + id + " img.wedashspinner" ).hide();
			jQuery("#we-optimize-container-" + id + " .wedashspinnertext" ).hide();

      },
      error: function() {
		alert("error procesando petición:")
       	jQuery(container).html("ERROR: " + err );
		jQuery("#we-optimize-container-" + id + " img.wedashspinner" ).hide();
		jQuery("#we-optimize-container-" + id + " .wedashspinnertext" ).hide();

      }
    })
  }


	window.onload = function(){
		jQuery(".optimize-from-library").click(function(){
				var id = jQuery(this).attr("data-id");
				oiwe_compressImage(jQuery(this), id);
		});
	}





/* Interceptamos las subidas */

var optimizadorioMsg = '<div id="XHRMessage" class="notice  notice-success is-dismissible" style="padding:12px;"><span style="font-size:15px;"><img src="images/spinner.gif" /> Planificando la optimización de las imágenes con <a href="https://optimizador.io"><b>optimizador.io</b></a> </span></button></div>';

_send = XMLHttpRequest.prototype.send;
XMLHttpRequest.prototype.send = function() {

    var callback = this.onreadystatechange;
    this.onreadystatechange = function() {             
         if (this.readyState == 4) {


			// Comprobamos si this.responseURL contiene "async-upload.php" y mostramos avisos

			var test = this.responseURL;
			if( test.indexOf('async-upload.php') >= 0){

				var elementExists = document.getElementById("XHRMessage");
				if (elementExists == null){
						jQuery( "#wpbody-content" ).prepend( optimizadorioMsg );

						setTimeout(function(){
							jQuery( "#XHRMessage" ).remove();
						}, 15000);
				}
			}

         }

		if (callback != null) {
         callback.apply(this, arguments);
		}
    }

    _send.apply(this, arguments);
}

