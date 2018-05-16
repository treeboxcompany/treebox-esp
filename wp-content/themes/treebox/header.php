<!doctype html>
	<html class="no-js" lang="es">
	  <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width,initial-scale=1">
	    <title><?php wp_title(); ?></title>



	    <link rel="apple-touch-icon" href="apple-touch-icon.png">
	    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>">
		<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/bootstrap.css">
      	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/jquery.bxslider.css">
      	<link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/style.css?v=1.2.29.1">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	  	<link rel="canonical" href="https://treebox.co/" />
      	<meta name="google-site-verification" content="wl17hv_6HnjdRmFz-MUnGuhSHQGWsgdN0wQ1FrPn8cI" />
			<?php wp_head(); ?>
		</head>
	  

	  <body>
			<!-- Google Tag Manager -->
				<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
				})(window,document,'script','dataLayer','GTM-NNQS2X');</script>
			<!-- End Google Tag Manager -->


      <div id="fb-root"></div>
      <script>(function(d, s, id) {
    	  var js, fjs = d.getElementsByTagName(s)[0];
    	  if (d.getElementById(id)) return;
    	  js = d.createElement(s); js.id = id;
    	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
    	  fjs.parentNode.insertBefore(js, fjs);
    	}(document, 'script', 'facebook-jssdk'));
      </script>
      <header>
        <div class="navbar-fixed-top container">
          <div class="logo-container">
            <a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a>
          </div>
          <nav>
            <!-- <ul class="lang">
              <li class="active">Es</li>
              <li>En</li>
            </ul> -->
            <button class="cmn-toggle-switch cmn-toggle-switch__htx"><span>toggle menu</span></button>
            <?php
            wp_nav_menu( array(
                'menu' => 'Main Menu'
            ) );
            ?>

          </nav>
          <div class="clearfix"></div>
        </div>
      </header>
	      <!-- /header -->
