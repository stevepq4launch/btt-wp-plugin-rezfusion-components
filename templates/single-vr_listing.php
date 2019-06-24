<?php get_header(); ?>

  <div class="wrap">
    <div id="primary" class="content-area">
      <main id="main" class="site-main" role="main">

        <?php
        /* Start the Loop */
        while ( have_posts() ) : the_post();

          echo do_shortcode('[rezfusion-component id="details-page" element="details-page"]');

        endwhile; // End of the loop.
        ?>

      </main><!-- #main -->
    </div><!-- #primary -->
    <?php get_sidebar(); ?>
  </div><!-- .wrap -->

<?php get_footer();