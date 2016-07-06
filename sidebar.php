<!-- Sidebar -->
<div id="sidebar">
<div class="side-widget">
<div class="widget-content">
<h2>Pages</h2>
<ul >
<li><a href="<?php bloginfo('url') ?>" title="Home">Home</a></li>
<?php wp_list_pages('title_li='); ?>
</ul>
</div>
</div>
<?php 	/* Widgetized sidebar, if you have the plugin installed. */
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Sidebar One (left)") ) : ?>
<div class="side-widget">
<div class="widget-content">
<?php _e('<h2>Categories</h2>'); ?>
<ul >
<?php wp_list_categories('title_li='); ?>
</ul>
</div>
</div>	
<div class="side-widget">
<div class="widget-content">
<?php _e('<h2>Archives</h2>'); ?>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</div>
</div>
<?php endif; ?>
				
<div class="side-widget">
<div class="widget-content">
<h2>Feeds</h2>
<ul >		
<li><a href="./?feed=rss2" title="Syndicate this site using RSS 2.0">Entries <abbr title="Really Simple Syndication">RSS</abbr></a></li>
<li><a href="./?feed=comments-rss2" title="The latest comments to all posts in RSS">Comments <abbr title="Really Simple Syndication">RSS</abbr></a></li>
</ul>
</div>
</div>
</div>
<!-- Sidebar ends -->