<?php get_header(); ?>

  <div class="blog container">
  	<div class="blog">
  		<div class="blog-entries">
  			<?php
        global $query_string;

        $query_args = explode("&", $query_string);
        $search_query = array();

        if( strlen($query_string) > 0 ) {
        	foreach($query_args as $key => $string) {
        		$query_split = explode("=", $string);
        		$search_query[$query_split[0]] = urldecode($query_split[1]);
        	} // foreach
        } //if

        $loop = new WP_Query($search_query);
        if ( have_posts() ) :
        	while ( have_posts() ) : the_post();
        		while ( $loop->have_posts() ) : $loop->the_post(); ?>
              <?php get_search_form(); ?>
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

        	endwhile;
        else :
          get_search_form();
        	?>
          <div class="clearfix"></div>
          <div class="no-results">
            <img src="<?php bloginfo('template_directory'); ?>/images/no-results.svg" alt="" />
            <p>
              No hay resultados. Intenta con otras palabras.
            </p>
          </div>
          <?php
        endif;
  			?>
  		</div>
  		<!-- /blog-entries -->
  	</div>
  </div>

<?php get_footer(); ?>
