<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++Site Starts+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' - '; } ?><?php bloginfo('name'); if(is_home()) { echo ' - '; bloginfo('description'); } ?></title>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if(is_home() || is_single() || is_page()) { echo '<meta name="robots" content="index,follow" />'; } else { echo '<meta name="robots" content="noindex,follow" />'; } ?>
<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><meta name="description" content="<?php metaDesc(); ?>" />
<?php csv_tags(); ?>
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php endif; ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/iestyles.css" />
<![endif]-->
</head>

<body>

<!--  Container -->
<div id="container">

<!-- User links -->
<div id="toplink">
<div class="links">
<?php if (get_option('fms_user_login') == "yes") { ?>
<?php
global $user_identity, $user_level;
if (is_user_logged_in()) { ?>
<span style="float:left;">Logged in as: <strong><?php echo $user_identity ?></strong></span>&nbsp;|&nbsp;
<a href="<?php bloginfo('url'); ?>/wp-admin">Control Panel </a>&nbsp;|&nbsp;
<?php if ( $user_level >= 1 ) { ?>
<a href="<?php bloginfo('url') ?>/wp-admin/post-new.php">Write</a>&nbsp;|&nbsp;	<?php } ?>
<a href="<?php bloginfo('url') ?>/wp-admin/profile.php">Profile</a>&nbsp;|&nbsp;
<a href="<?php echo wp_logout_url() ?>&amp;redirect_to=<?php echo urlencode($_SERVER['REQUEST_URI']) ?>" title="<?php _e('Log Out') ?>"><?php _e('Log Out'); ?></a>
<?php 
} else {
echo '<a href="'; echo bloginfo("url"); echo '/wp-login.php">Log In</a>&nbsp;|&nbsp</li>';
if (get_option('users_can_register')) { ?>
<a href="<?php echo site_url('wp-login.php?action=register', 'login') ?>"><?php _e('Register') ?></a> 
<?php 
}
} 
}
?> 
</div>
<div class="serach"	>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<label>Search</label><input type="hidden" id="searchsubmit" value="Search" />
<input type="text" class="input" value="" name="s" id="s"  />
<input type="submit" id="searchsubmit" value="Go" class="login_button" />
</form>
</div>
</div>
<div class="clear"></div>
<!-- User links ends-->
		
<!-- begin header -->
<div id="header">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="left" valign="bottom" > 
<?php if (get_option('fms_logo_header') == "yes" && get_option('fms_logo')) { ?>
<div id="title">
<a href="<?php bloginfo('url'); ?>/"><img src="<?php echo get_option('fms_logo'); ?>" title="<?php bloginfo('name'); ?>" alt="<?php bloginfo('name'); ?>" /></a>
</div>    	
<?php } else { ?>
<div id="title"><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></div>
<?php } ?>
<div id="description">
<?php bloginfo('description'); ?>
</div>
</td>
<td align="right" valign="bottom" width="350">
<embed src="<?php bloginfo('template_url'); ?>/flash/animation.swf" width="390" height="123" quality="High" wmode="Transparent" loop="false" play="true" menu="false" scale="ExactFit" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/go/getflashplayer">
</embed>
</td>
</tr>
</table>
</div>
<!-- end header -->
			
<!-- Main wrapper  starts-->
<div id="mainwrapper">

<!-- Content  starts-->
<div id="leftcontent">