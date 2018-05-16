<?php get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div class="work-detail-header" style="background:url(<?php the_post_thumbnail_url(); ?>) no-repeat ;" ></div>

		<div class="work-detail container">
			<h1 class="portfolio-header"><?php the_title(); ?></h1>
  			<p class="category"><a href="<?php echo get_post_meta($post->ID, 'website', true); ?>" target="_blank"><?php echo get_post_meta($post->ID, 'website', true); ?></a></p>
        <?php
          $video = get_post_meta($post->ID, 'video', true);
          if ($video != ''){ ?>
            <div class="video-container"><?php echo get_post_meta($post->ID, 'video', true); ?></div>
      			<!-- /video-container -->
          <?php }
        ?>
  			<div class="work-description"><?php the_content(); ?></div>
  			<!--<div class="images-container"><?php the_post_thumbnail(); ?></div>-->
      <div class="clearfix"></div>
      <div class="navigation">
        <div class="previous-post-link col-xs-6">
          <?php previous_post_link( '%link', 'Trabajo anterior' ); ?>
        </div>
        <div class="next-post-link col-xs-6">
          <?php next_post_link( '%link', 'Siguiente trabajo' ); ?>
        </div>
      </div>
      <div class="clearfix"></div>
		</div>

	<?php endwhile; else : ?>
		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
	<?php endif; ?>

<?php get_footer(); ?>
