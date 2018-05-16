<?php
/* Template Name: Blog Page */
get_header(); ?>

	<div class="blog container">

		<?php get_search_form(); ?>

		<div class="seo-blog  col-12 col-sm-12 col-md-8">
			<h1 class="h1-blog"><?php wp_title();?></h1>
			<h3 class="h3-blog roman">Descubre los insights, técnicas y estrategias del inbound marketing que transformarán tu negocio en una autentica maquina de crecimiento.</h3>
		</div>

		<div class="blog-entries">



			<?php
			$args = array('posts_per_page' => 10);
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); ?>


        <?php if( $loop->current_post == 0) { ?>
          <div class="blog-entry non-featured">

  					<div class="blog-entry-thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>
            

              <div class="padded-content">
                <h2 class="blog-entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      					<div class="blog-entry-meta  col-centered"><span class="blog-entry-date"><?php the_date(); ?></span> | <span class="blog-entry-author col-centered"><?php the_author(); ?></span></div>
      					<div class="blog-entry-content blog-excerpt"><?php the_excerpt(); ?></div>
      					<a class="more more-button" href="<?php the_permalink(); ?>">Ver más<span class="icon-next next-more"></span></a>
              </div>
            
  				</div>
        <?php }else{ ?>
          <div class="blog-entry non-featured">
            <div class="padded-content">
              <div class="blog-entry-thumbnail col-sm-12">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
              </div>
              <div class="col-sm-12">
                <h2 class="blog-entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      					<div class="blog-entry-meta"><span class="blog-entry-date"><?php the_date(); ?></span> | <span class="blog-entry-author"><?php the_author(); ?></span></div>
      					<div class="blog-entry-content"><?php the_excerpt(); ?></div>
      					<a class="more more-button" href="<?php the_permalink(); ?>">Ver más<span class="icon-next next-more"></span></a>
              </div>
              <div class="clearfix"></div>
            </div>
  				</div>
        <?php } ?>
				<!-- /blog-entry -->
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<!-- /blog-entries -->
	</div>

<?php get_footer(); ?>
