<?php
/**
 * The template for displaying single publication
 */

get_header(); ?>

<div class="wrap">
  <div class="content-area">
    <!-- style="display: none;" -->
    <textarea id='bibtex_input' style="display: none;" ><?php echo get_post_meta(get_the_ID(), '_bibtex', true);?></textarea>
    <div id="bibtex_display"></div>
  </div>
</div>

<?php get_footer(); ?>
