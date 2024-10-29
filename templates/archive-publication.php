<?php
/**
 * The template for displaying single publication
 */

get_header(); ?>

<div class="wrap">
  <div class="content-area">
    <textarea id='bibtex_input' style="display: none;">
      <?php $bibtex_content = "";
      $query = new WP_Query(array(
        'post_type' => 'publication',
        'posts_per_page' => -1
      ));
      while ( $query->have_posts() ) : $query->the_post();
        echo get_post_meta(get_the_ID(), '_bibtex', true);
      endwhile;
      wp_reset_postdata();
      ?>
    </textarea>
    <div id="bibtex_display"></div>
  </div>
</div>

<?php get_footer(); ?>
