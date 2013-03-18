<?php get_header(); ?>

<!-- Archives -->
<?php if (have_posts()) : ?>
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<h1 >Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
<h1 >Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h1 >Archive for <?php the_time('F jS, Y'); ?></h1>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h1 >Archive for <?php the_time('F, Y'); ?></h1>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h1 >Archive for <?php the_time('Y'); ?></h1>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h1 >Author Archive</h1>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h1>Blog Archives</h1>
<?php } ?>
<?php while (have_posts()) : the_post(); ?>
<div id="page-<?php echo the_ID();?>" class="<?php echo $alternate;?>">
<div class="back">
<div class="top">
<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
<?php if ( get_post_meta($post->ID, 'heading', true) ) { ?> 
<h4><?php echo get_post_meta($post->ID, "heading", $single = true); ?></h4>
<?php }?>	
<div class="postmetadata1">
Posted : <i><b><?php the_author() ?> </b>on  <b><?php the_time('M d, Y')?></b></i><br />
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
<?php else :?>

<h1>Page not found</h1>
<div class="back">
<div class="top">
<div class="post-body">
<?php
		if ( is_category() ) { // If this is a category archive
			printf("< class='center'>Sorry, but there aren't any posts in the %s category yet.", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("Sorry, but there aren't any posts with this date.");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf(" class='center'>Sorry, but there aren't any posts by %s yet.", $userdata->display_name);
		} else {
			echo("No posts found.");
		}
?>
</div>
</div>
</div>
<?php	endif;?>
<!-- Archives ends -->

<?php get_footer(); ?>