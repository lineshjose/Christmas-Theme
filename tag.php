<?php get_header(); ?>

<!-- Tags -->
<h1>Tag Archive</h1>
<div class="tags">Tags : <?php wp_tag_cloud('smallest=8&largest=16'); ?></div>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div id="page-<?php echo the_ID();?>" class="<?php echo $alternate;?>">
<div class="back">
<div class="top">
<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
<?php if ( get_post_meta($post->ID, 'heading', true) ) { ?> 
<h4><?php echo get_post_meta($post->ID, "heading", $single = true); ?></h4>
<?php } ?>	
<div class="postmetadata1">
Posted : <i><b><?php the_author() ?> </b>on  <b><?php the_date()?></b></i><br />
Category : <i><b><?php the_category(',') ?></b></i><br />
</div>
<div class="post-body">
<?php the_excerpt(); ?>
</div>				
<div class="postmetadata">
<a href="<?php the_permalink() ?>">Read More</a>&nbsp;|&nbsp;
<a href="<?php comments_link(); ?>" class="entryComment"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/comment.gif" alt="" />   Comments </a>
<?php edit_post_link('Edit This',' | ',''); ?> 
</div>
</div>
</div>
</div>
<?php endwhile; ?>

<div class="navigation">
<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
</div>
<div style="clear:both"><br /></div>

<?php else : ?>
<div class="back">
<div class="top">
<div class="post-body">
<h2>Not Found</h2>
<div>
Sorry, but you are looking for something that isn't here.
</div>
</div>
</div>
</div>
<?php endif; ?>
 <!-- Tags  ends-->