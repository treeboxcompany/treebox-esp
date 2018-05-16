<?php
/**
 * Business Pro Theme
 *
 * This template overrides the default Portfolio archive template.
 *
 * @package   BusinessProTheme
 * @link      https://seothemes.com/themes/business-pro
 * @author    SEO Themes
 * @copyright Copyright © 2017 SEO Themes
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {

	die;

}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove standard loop (optional).
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add our custom loop.
add_action( 'genesis_loop', 'business_filterable_portfolio' );

// Enqueue scripts.
wp_enqueue_script( 'isotope', get_stylesheet_directory_uri() . '/assets/scripts/min/isotope.pkgd.min.js', array( 'jquery' ), CHILD_THEME_VERSION, false );
wp_enqueue_script( 'isotope-init', get_stylesheet_directory_uri() . '/assets/scripts/min/isotope-init.min.js', array( 'isotope' ), CHILD_THEME_VERSION, false );

/**
 * Output filterable portfolio items.
 *
 * @since 1.0.0
 *
 * @return void
 */
function business_filterable_portfolio() {

	global $post;
	$terms = get_terms( 'portfolio-type' );
	?>

	<div class="portfolio">
		<?php if ( $terms ) { ?>
		<div id="portfolio-cats" class="filter clearfix">
			<div class="wrap">
				<a href="#" class="active" data-filter="*"><?php esc_html_e( 'All', 'business-pro-theme' ); ?></a>
				<?php foreach ( $terms as $term ) : ?>
					<a href='#' data-filter='.<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_html( $term->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php } ?>

		<?php if ( have_posts() ) { ?>
		<div class="portfolio-sizer"></div>
		<div class="portfolio-content">
		<?php

		while ( have_posts() ) :

			the_post();

			$terms = get_the_terms( get_the_ID(), 'portfolio-type' );

			// Display portfolio items.
			if ( has_post_thumbnail( $post->ID ) ) {
				?>
				<article class="portfolio-item <?php if ( $terms ) { foreach ( $terms as $term ) { echo ' ' . esc_attr( $term->slug ); } } ?>">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php
						echo genesis_get_image( array(
							'size'     => 'portfolio',
							'itemprop' => 'image',
						) );
						printf( '<p class="entry-title" itemprop="name"><span>%s</span></p>', get_the_title() );
					?>
					</a>
				</article>
				<?php

			}
		endwhile;
		?>
		</div>
		<?php } ?>
	</div>

<?php

}

// Run genesis.
genesis();
