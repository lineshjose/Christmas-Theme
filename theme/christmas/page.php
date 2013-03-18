<?php get_header(); ?>

<!-- Page -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h1 ><?php the_title(); ?></h1>
<div class="back">
<div class="entry post-body">
<?php the_content(); ?>
</div>
</div>
<?php endwhile; endif; ?>
<!-- Pge ends -->

<?php get_footer(); ?>