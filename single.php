<?php get_header(); ?>

<!-- Post -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h1><?php the_title(); ?></h1>
<div class="back">
<div class="top">
<div class="postmetadata1">
Posted : <i><b><?php the_author() ?></b>  On  <b><?php the_date() ?></b></i><br />
Category : <i><b><?php the_category(',') ?></b></i><br />	</div>
<div class="entry post-body">
<?php the_content(); ?>	
<div class="postmetadata">		
<a href="<?php comments_link(); ?>" class="entryComment"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/comment.gif" alt="" />  <?php comments_number('0', '1', '%'); ?> Comments </a>
<?php edit_post_link('Edit This',' | ',''); ?> </div>
<?php the_tags('<div class="tags">Tags: ', ', ','</div>'); ?>
</div>
</div>
</div>

<?php comments_template(); ?>


<?php endwhile; else: ?>
<h1>page Note Found</h1>
<div class="back">
<div class="top">
<div class="entry post-body">
<p>Sorry, no posts matched your criteria.</p>
</div>
</div>
</div>
<?php endif; ?>
<!-- Post ends -->

<?php get_footer(); ?>