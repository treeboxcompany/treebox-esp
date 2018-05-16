<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
	   
global $wpdb;
global $post;
$title = $_POST['title']; // get the inputted title
$content = $_POST['contenidoReceta']; // get the inputted content
$foto = $_POST['foto'];
$ingredientes = $_POST['ingredientes'];
$preparacion = $_POST['preparacion'];
# run a query to check for a post containing the data that our user is about to submit
# store results in $verifica
$sql = "
SELECT wposts.*
FROM $wpdb->posts wposts
LEFT JOIN $wpdb->postmeta wpostmeta ON wposts.ID = wpostmeta.post_id
LEFT JOIN $wpdb->term_relationships ON (wposts.ID = $wpdb->term_relationships.object_id)
LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
WHERE wposts.post_status = 'publish'
AND wposts.post_title = '$title'
AND wposts.post_content = '$contenidoReceta'
AND wpostmeta.meta_key = 'Foto'
AND wpostmeta.meta_value = '$foto'";
$verifica = $wpdb->get_results($sql);

if( 'POST' == $_SERVER['REQUEST_METHOD'] ) { // if form has been submitted

# some validation
if(empty($title)) {
echo "Please give your post a title<br />";
}
if (empty($content)){
echo "Please write your post's content<br />";
}
if ($categorie == -1){
echo "Please assign a category to your post.<br />";
}
# if there are no similar posts ($verifica is empty) and user filled in the fields, insert post
# also, redirect to the homepage to make sure we don't get 404-ed
if (empty($verifica) && !empty($title) && !empty($content) && $categorie != -1) {
$my_post = array(
'post_title' => $title,
'post_content' => $content,
'post_status' => 'draft',
'post_author' => 1,
'post_type' => 'recetas',
);

add_post_meta($my_post, 'foto', $foto);
wp_redirect( home_url() );
}

# if $verifica is not empty, then we don't insert the post and we display a message
else if( !empty($verifica) ) { echo "You are trying to submit the same post twice! Be nice.";  }

$my_post = wp_insert_post($my_post);

if (!function_exists('wp_generate_attachment_metadata')){
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');
}
if ($_FILES) {
foreach ($_FILES as $file => $array) {
if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
return "upload error : " . $_FILES[$file]['error'];
}
$attach_id = media_handle_upload( $file, $my_post );
}   
}

if ($attach_id > 0){										
$attachment = wp_get_attachment_url($attach_id); // Gets path to attachment
update_post_meta($my_post,'imagen',$attachment);
update_post_meta($my_post,'_thumbnail_id',$attach_id);
update_post_meta($my_post,'ingredientes',$ingredientes);
update_post_meta($my_post,'preparacion',$preparacion);

}
}
?>
<div class="formReceta">
<h2>Sube tu propia receta</h2>
    <form action="" method="post" enctype="multipart/form-data" name="myForm">
        <div class="dato">
            <input type="text" placeholder="Nombre de la receta" name="title" id="title"/>
        </div>
        <div class="dato">
            <h4>Ingredientes</h4>
            <p>Escribe los ingredientes de tu receta</p>
            <textarea name="ingredientes" id="ingredientes"></textarea>
        </div>
        <div class="dato">
            <textarea name="preparacion" id="preparacion" placeholder="preparaci&oacute;n"></textarea>
        </div>
        <div class="dato">
            <textarea name="contenidoReceta" id="contenidoReceta" placeholder="describe tu receta"></textarea>
        </div>
        <div class="dato">
            <h4>Foto o video</h4>
            <p>Agrega una foto o un video a tu receta</p>
            <input type="file" name="thumbnail" id="thumbnail">
        </div>
        <input type="submit" value="Publicar">
    <?php wp_nonce_field( 'myForm' ); ?>
    </form>
</div>			

</body>
</html>