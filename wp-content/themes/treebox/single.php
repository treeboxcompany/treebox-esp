<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <div class="blog blog-full-entry">
    <div class="blog-entry">
      <div class="blog-entry-thumbnail"><?php the_post_thumbnail(); ?></div>
      <div class="padded-content container">
        <h1 class="blog-entry-title"><?php the_title(); ?></h1>
        <div class="blog-entry-meta col-centered"><span class="blog-entry-date"><?php the_date(); ?></span> | <span class="blog-entry-author"><?php the_author(); ?></span></div>
        <div class="share-blog-entry top-share col-sm-6">
          <ul class="social">
            <li><span class="share-text">Compartir</span></li>
            <li><a class="icon-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><span>Facebook</span></a></li>
            <li><a class="icon-twitter" href="http://twitter.com/share?text=<?php the_excerpt(); ?>&url=<?php the_permalink(); ?>" target="_blank"><span>Twitter</span></a></li>
          </ul>
        </div>
        <div class="clearfix"></div>
        <div class="blog-entry-content">
    			<?php the_content(); ?>
    		</div>
        <div class="author-detail col-sm-8">
          <?php
          $author             = get_the_author();
          $author_description = get_the_author_meta( 'description' );
          $author_url         = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
          $author_avatar      = get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'wpex_author_bio_avatar_size', 75 ) );

          if ( $author_description ) : ?>
            <div class="author-info">
                <div class="author-info-inner">
                  <?php if ( $author_avatar ) { ?>
                    <div class="author-avatar col-sm-2 col-xs-4">
                      <div class="image-container">
                        <?php echo $author_avatar; ?>
                      </div>
                    </div><!-- /author-avatar -->
                  <?php } ?>
                  <div class="author-description col-sm-10 col-xs-8">
                    <p class="author-name"><?php echo $author ?></h4>
                    <p><?php echo $author_description; ?></p>
                  </div><!-- /author-description -->
                </div><!-- /author-info-inner -->
            </div><!-- /author-info -->
          <?php endif; ?>
          <div class="clearfix"></div>
        </div>
        <div class="share-blog-entry col-sm-4">
          <ul class="social">
            <li><span class="share-text">Compartir</span></li>
            <li><a class="icon-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><span>Facebook</span></a></li>
            <li><a class="icon-twitter" href="http://twitter.com/share?text=<?php the_excerpt(); ?>&url=<?php the_permalink(); ?>" target="_blank"><span>Twitter</span></a></li>
          </ul>
        </div>
        <div class="clearfix"></div>
        <?php comments_template(); ?>
        <div class="clearfix"></div>
        <div class="navigation">
          <div class="previous-post-link col-xs-6">
            <?php previous_post_link( '%link', 'Entrada anterior: %title' ); ?>
          </div>
          <div class="next-post-link col-xs-6">
            <?php next_post_link( '%link', 'Siguiente entrada: %title' ); ?>
          </div>
        </div>
      </div>
    </div>
    <!-- /blog-entry -->
  </div>

<?php endwhile; else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>


<?php get_footer(); ?>
