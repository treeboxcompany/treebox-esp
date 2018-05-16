<?php get_header(); ?>

  <div class="blog container">
  	<div class="blog">
  		<div class="blog-entries">
  			<?php
        $catId = get_queried_object_id();
  			$args = array('posts_per_page' => 10, 'cat' => $catId, 'post_type' => 'portfolio');
  			$loop = new WP_Query( $args );
  			while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <div class="blog-entry non-featured">
  					<div class="blog-entry-thumbnail col-sm-7">
              <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            </div>
            <div class="col-sm-5">
              <h2 class="blog-entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    					<div class="blog-entry-meta"><span class="blog-entry-date"><?php the_date(); ?></span> | <span class="blog-entry-author"><?php the_author(); ?></span></div>
    					<div class="blog-entry-content"><?php the_excerpt(); ?></div>
    					<a class="more more-button" href="<?php the_permalink(); ?>">Ver más<span class="icon-next next-more"></span></a>
            </div>
            <div class="clearfix"></div>
  				</div>
  				<!-- /blog-entry -->
  			<?php
  			endwhile;
  			wp_reset_postdata();
  			?>
  		</div>
  		<!-- /blog-entries -->
  	</div>
  </div>

<?php get_footer(); ?>
