<?php
class SuperEmptyWidget extends WP_Widget {
    function SuperEmptyWidget() {
        parent::WP_Widget(false, $name = 'Main headline placeholder');
    }

    function widget($args, $instance) {
        extract( $args );
        $content = $instance['content'];
        echo $content;
    }

    function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['content'] = $new_instance['content'];
        return $instance;
    }

    function form($instance) {
        $content = esc_attr($instance['content']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content:'); ?></label>
                  </p>
          <textarea class="widefat" cols="20" rows="16" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>

        <?php
    }

} // class SuperEmptyWidget

// register SuperEmptyWidget widget
add_action('widgets_init', create_function('', 'return register_widget("SuperEmptyWidget");'));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar',
        'before_widget' => '<div class="block %1$s %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

  register_sidebar(array(
        'name' => 'Formulario captcha',
        'id' => 'form-sidebar',
        'before_widget' => '<div class="block %1$s %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

add_theme_support( 'post-thumbnails' );
//set_post_thumbnail_size( 50, 50, true );

add_filter('show_admin_bar', '__return_false');

//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter('pre_user_description', 'wp_filter_kses');
//add sanitization for WordPress posts
add_filter( 'pre_user_description', 'wp_filter_post_kses');

?>
