<?php get_header(); ?>

<?php	
	$options = get_option("widget_sideFeature");
	$posts = get_option('fms_number_posts');
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	if (is_active_widget('widget_myFeature')) {
		$category = "showposts=".$posts."&cat=-".$options['category']."&paged=".$paged;
	} else {
		$category = "showposts=".$posts."&paged=".$paged;	
	}
	$i = 1;
	?>
<?php query_posts($category); ?>
	


<!-- postings-->
<h1>Home</h1>
<?php
	if (have_posts())
	{
	$i=1;
			 while (have_posts()) 
			 {
			 the_post();
			 $alternate=$i%2==0?"postentry1":"postentry2";
?>		
<div id="page-<?php echo the_ID();?>" class="<?php echo $alternate;?>">
<div class="back">
<div class="top">
<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
<?php if ( get_post_meta($post->ID, 'heading', true) ) { ?> 
<h4><?php echo get_post_meta($post->ID, "heading", $single = true); ?></h4>
<?php }?>	
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
<?php
			$i++;		 
			 }
			 
?>
<br />
	<?php if($wp_query->max_num_pages > 1)
	{ 
	//Pagination
	?>
<div class="navigation ">
<div class="leftnav"><?php next_posts_link('&laquo; Older Entries') ?></div>
<div class="rightnav"><?php previous_posts_link('Newer Entries &raquo;') ?></div>				
<div style="clear:both"><br /></div>
</div>
	<?php 
	} 
	?>
	
<?php		 
	} else{	?>

<div class="back">
<div class="top">
<div class="entry post-body">
	<div id="errobox" style="padding-left:10px">
		<h2 class="center">404 Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
	</div>	</div></div></div><br />
	
	<?php
	}
?>
<!-- /postings-->

<?php get_footer(); ?>