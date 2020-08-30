<?php get_header(); ?>

  <div class="wrap">
    <div id="primary" class="content-area">
      <main id="main" class="site-main" role="main">

        <?php
        /* Start the Loop */
        while ( have_posts() ) : the_post();
          $meta = get_post_meta($post->ID);
          echo do_shortcode("[rezfusion-lodging-item itemid=\"{$meta['rezfusion_hub_item_id'][0]}\"]");

        endwhile; // End of the loop.
        ?>

      </main><!-- #main -->
    </div><!-- #primary -->
    <?php get_sidebar(); ?>
  </div><!-- .wrap -->

<?php get_footer();
