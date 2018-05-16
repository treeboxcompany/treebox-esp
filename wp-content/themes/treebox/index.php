<?php get_header(); ?>
  <div class="main-container container">
  	<div class="intro">
  		<h1 class="section-text col-sm-8 row"><?php dynamic_sidebar( 'Sidebar' ); ?></h1>

      <div class="clearfix"></div>
      <!-- <a href="https://treebox.co/#portfolio" class="button">Conoce nuestro trabajo</a> -->
      <h3 class="roman subtitle">¿Tienes un proyecto para nosotros? <a href="#contact"class="super-link heavy">Hablemos.</a></h3>
  	</div>
  </div>
  <div class="intro-illustration"></div>
	<!-- /intro -->
  <div class="main-container container">
    <div class="down-arrow animated bounce infinite">
      <!-- <h1><img src="<?php bloginfo('template_directory'); ?>/images/icons/scroll-down-icon.svg" alt="" /></h1> -->
    </div>
    <div class="services" id="services">

      <div class=" col-sm-5 ">
        <img src="https://treebox.co/wp-content/themes/treebox/images/satellite.svg" alt="treebox satellite" class="img-clientes-2">
      </div>
      <div class=" col-sm-7">
        <h2 class="">Tus nuevos clientes esperan por ti<span class="yellow samara">.</span></span></h2>
        <h3 class=" who-is roman subtitle">Ayudamos a compañías y startups como la tuya <span class="heavy black">a conectar con los clientes adecuados en el momento perfecto.</span></h3>
      </div>
      <div class="clearfix"></div>



       <ul class="services-carousel">
  			<?php
  			global $post;
  			$args = array('posts_per_page' => 3 , 'post_type' => 'services' );
  			$loop = new WP_Query( $args );
  			while ( $loop->have_posts() ) : $loop->the_post(); ?>
  				<li class="slide col-sm-4">
  					<div class="icon-container"><span class="services-icons-background"></span><span class="services-icons icon-<?php echo $post->post_name;?>"></span></div>
  					<h3 class="slide-title"><?php the_title(); ?></h3>
  					<?php the_excerpt(); ?>
  				</li>
  			<?php
  			endwhile;
  			wp_reset_postdata();
  			?>
  		</ul>
  	</div>

    <!-- <div class="col-sm-12 col-xs-12">
      <br><br>
      <img src="https://www.treebox.co/wp-content/themes/treebox/images/treebox-metodologia.svg" width="100%">
      <img src="https://www.treebox.co/wp-content/themes/treebox/images/treebox-metodologia-pasos.svg" class="metodologia" width="100%">
  </div> -->

  	<div class="clearfix"></div>
  	<!-- /carousel -->
  </div>

	<div class="portfolio-gallery" id="portfolio">
		<?php
		$args = array('posts_per_page' => 6, 'post_type' => 'portfolio', 'order' => 'ASC' );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="portfolio-thumb">
        <a href="<?php the_permalink(); ?>" style="background:url(<?php the_post_thumbnail_url(); ?>) no-repeat; background-size: cover;" class="portfolio-thumb-container"></a>
        <a href="<?php the_permalink(); ?>">
        <div class="portfolio-link">
          <span class="portfolio-thumb-title"><?php the_title(); ?></span>
          <a class="more more-button" href="<?php the_permalink(); ?>">Ver más<span class="icon-next next-more"></span></a>
        </div>
        </a>
      </div>
		<?php
		endwhile;
		wp_reset_postdata();
		?>
    <div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
	<!-- /portfolio -->

  <div class="container">
    <div class="clients" id="clients">
  		<h2 class="section-title super-h2">Más de 30.000</h2>
      <p class="text-center col-sm-6 col-sm-offset-3 super-text">Negocios se han concretado gracias a <span class="heavy super-link">treebox.</span> Estas son algunas de las compañias con las que hemos trabajado.</p>
      <div class="clearfix"></div>
    	  <img src="https://treebox.co/wp-content/themes/treebox/images/confian-en-treebox.png" alt="treebox satellite" class="img-clientes">
  	</div>
  	<div class="clearfix"></div>
  	<!-- /clients -->
  </div>

  <!-- <div class="container">
    <div class="talking-about" id="talking-about">
  		<h2 class="section-title">+ de 30.000</h2>
      <p>negocios se han concretado gracias con <span class="heavy">treebox</span></p>
  		<ul class="clients-gallery">
  			<?php
  			$args = array('posts_per_page' => 10 , 'post_type' => 'talking' );
  			$loop = new WP_Query( $args );
  			while ( $loop->have_posts() ) : $loop->the_post(); ?>
  				<li>
  					<div class="image-container" style="background-image: url(<?php the_post_thumbnail_url(); ?>); background-size:contain;"></div>
  				</li>
  			<?php
  			endwhile;
  			wp_reset_postdata();
  			?>
  		</ul>
  	</div>
  	<div class="clearfix"></div>
  	 /talking-about
  </div> -->

  <div class="container">
    <div class="testimonials">
      <ul class="testimonials-carousel">
        <?php
    		$args = array('posts_per_page' => 5 , 'post_type' => 'testimonials' );
    		$loop = new WP_Query( $args );
    		while ( $loop->have_posts() ) : $loop->the_post(); ?>
    			<li class="testimonials-slide">
    				<div class="testimonial-pic-container">
              <div class="testimonial-icon-container">
                <span class="testimonial-icon-background"></span>
                <span class="testimonial-icons icon-testimonial"></span>
              </div>
              <div class="client-photo">
                <div class="client-image-container"><?php the_post_thumbnail(); ?></div>
              </div>
    				</div>
            <div class="client-photo col-lg-2">
              <div class="client-image-container"><?php the_post_thumbnail(); ?></div>
            </div>
            <div class="testimonial-content col-lg-10">
              <?php the_content(); ?>
      				<h4><?php the_title(); ?></h4>
      				<p class="position"><?php echo get_post_meta($post->ID, 'position', true); ?></p>
            </div>
            <div class="clearfix"></div>
    			</li>
    		<?php
    		endwhile;
    		wp_reset_postdata();
    		?>
      </ul>
  	</div>
  	<!-- /testimonials -->
  </div>

  <div class="container">
    <div class="team" id="team">
  		<?php
  			$post_team = get_post( 7 );
  			$title = $post_team->post_title;
  			$content = $post_team->post_content;
  		?>
  		<h2 class="section-title"><?php echo $title;?></h2>
  		<div class="col col-12">
        <div class="team-photo col-sm-6">
          <?php echo get_the_post_thumbnail( $post_team->ID, 'full' ); ?>
        </div>
        <div class="col-sm-6">
          <div class="division"></div>
          <?php echo $content;?>
          <a class="more more-button" href="#">Ver más<span class="icon-next next-more"></span></a>
        </div>
  			<div class="clearfix"></div>
  		</div>
  		<div class="hidden-content">
  			<div class="carousel">
  				<ul class="team-expanded">
  					<?php
  					$args = array('posts_per_page' => 10 , 'post_type' => 'team' );
  					$loop = new WP_Query( $args );
  					while ( $loop->have_posts() ) : $loop->the_post(); ?>
  						<li class="slide col-sm-3">
  							<div class="img-container"><?php the_post_thumbnail(); ?></div>
  							<h4><?php the_title(); ?></h4>
  							<p><?php echo get_post_meta($post->ID, 'position', true); ?></p>
  							<ul class="social">
                  <?php
                    $facebook = get_post_meta($post->ID, 'facebook', true);
                    if ($facebook != ''){ ?>
                      <li><a class="icon-facebook" href="<?php echo $facebook; ?>" target="_blank" ><span>Facebook</span></a></li>
                    <?php }
                    $twitter = get_post_meta($post->ID, 'twitter', true);
                    if ($twitter != ''){ ?>
                      <li><a class="icon-twitter" href="<?php echo $twitter; ?>" target="_blank" ><span>Facebook</span></a></li>
                    <?php }
                    $linkedin = get_post_meta($post->ID, 'linkedin', true);
                    if ($linkedin != ''){ ?>
                      <li><a class="icon-linkedin" href="<?php echo $linkedin; ?>" target="_blank" ><span>Facebook</span></a></li>
                    <?php }
                  ?>
  							</ul>
  						</li>
  					<?php
  					endwhile;
  					wp_reset_postdata();
  					?>
  				</ul>
          <div class="clearfix"></div>
  			</div>
  			<!--<h2 class="section-title">Colaboradores</h2>
  			<ul class="collaborators">
  				<?php
  				$args = array('posts_per_page' => 10 , 'post_type' => 'collaborators');
  				$loop = new WP_Query( $args );
  				while ( $loop->have_posts() ) : $loop->the_post(); ?>
  					<li class="col-sm-3 col-xs-6">
  						<h4><?php the_title(); ?></h4>
  						<p><?php echo get_post_meta($post->ID, 'position', true); ?></p>
  					</li>
  				<?php
  				endwhile;
  				wp_reset_postdata();
  				?>
  			</ul>
        -->
  		</div>
  	</div>
  	<!-- / team -->
  </div>

  <div class="contact-illustration row"></div>

  <div class="container">
    <div class="contact" id="contact">
  		<?php
  			$post_contact = get_post( 10 );
  			$title = $post_contact->post_title;
  			$content = $post_contact->post_content;
  		?>
  		<h2 class="section-title"><?php echo $title;?></h2>
  		<div class="col-sm-6">
        <div class="division"></div>
  			<?php echo $content; ?>
         <ul class="social">
          <?php
            $facebook = get_post_meta($post_contact->ID, 'facebook', true);
            if ($facebook != ''){ ?>
              <li><a class="icon-facebook" href="<?php echo $facebook; ?>" target="_blank" ><span>treebox en facebook</span></a></li>
            <?php }
            $twitter = get_post_meta($post_contact->ID, 'twitter', true);
            if ($twitter != ''){ ?>
              <li><a class="icon-twitter" href="<?php echo $twitter; ?>" target="_blank" ><span>treebox en twitter</span></a></li>
            <?php }
            $linkedin = get_post_meta($post_contact->ID, 'linkedin', true);
            if ($linkedin != ''){ ?>
              <li><a class="icon-linkedin" href="<?php echo $linkedin; ?>" target="_blank" ><span>treebox en linkedin</span></a></li>
            <?php }
            $instagram = get_post_meta($post_contact->ID, 'instagram', true);
            if ($linkedin != ''){ ?>
              <li><a class="icon-instagram" href="<?php echo $instagram; ?>" target="_blank" ><span>treebox en instagram</span></a></li>
            <?php }
          ?>
        </ul>

  		</div>

  		<div class="col-sm-6">
       <div class="division"></div>
      <?php dynamic_sidebar('form-sidebar'); ?>


  		</div>
      <div class="clearfix"></div>
  	</div>
  	<!-- /contact -->
  </div>

 


<?php get_footer(); ?>
