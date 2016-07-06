<?php

$themename = "Christmas";
$shortname = "fms";

$options = array (	

			


	array(  "name" => "Header Logo",
			"desc" => "Would you like a logo in your header?",
            "id" => $shortname."_logo_header",
			"default" => "no",
            "type" => "logo"),	
		
		array(  "name" => "User Login",
			"desc" => "Would you like to display a User Login bar at the top of your site?",
            "id" => $shortname."_user_login",
			"default" => "yes",
            "type" => "login"),
			

	
	array(  "name" => "Featured Post Widget",
			"desc" => "Would you like to activate the Featured Post widget?",
            "id" => $shortname."_feature_widget",
			"default" => "yes",
            "type" => "feature"),


	array(  "name" => "Number of Posts",
			"desc" => "How many posts would you like to appear on the main page?",
            "id" => $shortname."_number_posts",
			"default" => "6",
            "type" => "posts")
					
);
add_action('admin_head', 'wp_admin_js');

function wp_admin_js() {
	if(stristr($_SERVER['REQUEST_URI'],'FMS-Header')) { 
		echo '<script type="text/javascript" src="'; echo bloginfo('template_url'); echo '/admin/js/header.js"></script>'."\n"; 
	}
	if(stristr($_SERVER['REQUEST_URI'],'FMS-Layout')) { 
		echo '<script type="text/javascript" src="'; echo bloginfo('template_url'); echo '/admin/js/basic.js"></script>'."\n";
	}
	if(stristr($_REQUEST['page'], 'FMS-Header') || stristr($_REQUEST['page'], 'FMS-Layout') || stristr($_REQUEST['page'], 'FMS-Info')) { 
		wp_enqueue_script("jquery");
		echo '<script type="text/javascript" src="'.get_bloginfo('template_url').'/admin/js/jquery.jqtransform.js" ></script>'."\n";
		echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/admin/style.css" />';
		echo "
<script type=\"text/javascript\">
jQuery(function() {
    //find all form with class jqtransform and apply the plugin
    jQuery(\"form.jqtransform\").jqTransform();
});
</script>
";
	}
}

function fms_head() {
	if (get_option('fms_logo_header') == "yes") {
		list($w, $h) = @getimagesize(get_option('fms_logo'));
		$height = $h/2+15;
	} else {
		$height= 35;
	}
	
}
add_action('wp_head', 'fms_head');

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == 'FMS-Layout' || $_GET['page'] == 'FMS-Header' || $_GET['page'] == 'FMS-Info' ) {

        if ( 'save' == $_REQUEST['action'] ) {
				
                foreach ($options as $value) {
                    if( !isset( $_REQUEST[ $value['id'] ] ) ) {  } else { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
				if(stristr($_SERVER['REQUEST_URI'],'&saved=true')) {
					$location = $_SERVER['REQUEST_URI'];
					} else {
					$location = $_SERVER['REQUEST_URI'] . "&saved=true";		
					}
					
				if ($_FILES["file"]["type"]){
					  	$directory = dirname(__FILE__) . "/uploads/";				
						move_uploaded_file($_FILES["file"]["tmp_name"],
						$directory . $_FILES["file"]["name"]);
						update_option('fms_logo', get_settings('siteurl'). "/wp-content/themes/". get_settings('template')."/uploads/". $_FILES["file"]["name"]);
						}
						
                header("Location: $location");
				die;
        } 
    }
	// Set all default options
	foreach ($options as $default) {
		if(get_option($default['id'])=="") {
			update_option($default['id'],$default['default']);
		}
	}
	/*
	// Delete all default options
	foreach ($options as $default) {
		delete_option($default['id'],$default['default']);
	}
	*/	
	
	add_menu_page('Page title', 'Christmas', 10, 'christmas', 'fms_header');
	
}

// HTML for top of admin pages
function admin_pages_top() {
?>
<form method="post" class="jqtransform" id="myForm" enctype="multipart/form-data" action="">
<div id="poststuff" class="metabox-holder has-right-sidebar">

<div id="side-info-column" class="inner-sidebar">
<div id='side-sortables' class='meta-box-sortables'>
<div id="linksubmitdiv" class="postbox " >
<h3>Current Saved Settings</h3>
<div class="inside">
<div class="submitbox" id="submitlink">

<div id="minor-publishing">
	<ul style="padding:10px 0 0 5px;">
<?php
}

// HTML for middle of admin pages
function admin_pages_middle() {
?>
	</ul>
<div id="major-publishing-actions">

<div id="publishing-action">
	<input name="save" type="submit" value="Save changes" />    
	<input type="hidden" name="action" value="save" />
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>

</div>
</div>
</div></div></div>

<div id="post-body" class="has-sidebar">
<div id="post-body-content" class="has-sidebar-content">
<?php
}



######################################
##     Display the layout page     ###
######################################

function fms_header() {
    global $themename, $shortname, $options;
	?>
    	<div class="wrap">
<h2><?php echo $themename; ?></h2>
<p>Thanks for downloading <strong><a href="http://linesh.com/projects/christmas/"><?php echo $themename; ?></a></strong> by Linesh Jose. Hope you enjoy using it!</p>
<p>There are tons of layout possibilities available with this theme, as well as a bunch of cool features that will surely help you get your site looking and working it's best.</p>
<p>A lot of hard work went in to programming and designing <strong><?php echo $themename; ?></strong>, and if you would like to support Linesh Jose (the guy who designed it) please <a href="http://linesh.com/make-a-donation/">make a  donation</a>.  If you have any questions, comments, or if you encounter a bug, please <a href="http://linesh.com/">contact me</a>.</p>
	
	<?php
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	?>
	<?php admin_pages_top(); // Display the HTML for the top of admin pages ?>
	<li>Header Logo: <strong><?php echo ucwords(get_option('fms_logo_header')); ?></strong></li>
		<li>User Login: <strong><?php echo ucwords(get_option('fms_user_login')); ?></strong></li>
		<li>Number of Posts: <strong><?php echo get_option('fms_number_posts'); ?></strong></li>
	<?php admin_pages_middle(); // Display the HTML for the middle of admin pages ?>
	<?php
	foreach ($options as $value) { 
	switch ( $value['type'] ) {
	case "logo":
			?>
			<div class="stuffbox">
				<h3><?php echo $value['name']; ?></h3>
				<div class="inside">
					<input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="yes"<?php if ( get_settings( $value['id'] ) == "yes") { echo " checked"; } ?> onclick="showMe()" /><label>Yes</label><input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="no"<?php if ( get_settings( $value['id'] ) == "no") { echo " checked"; } ?> onclick="showMe()" /><label>No</label>
		   			<p style="clear:left;"><small><?php echo $value['desc']; ?></small></p>
                    <div id="headerLogo">
                        Choose a file to upload: <input type="file" name="file" id="file" />
                        <?php if(get_option('fms_logo')) { echo '<div><img src="'; echo get_option('fms_logo'); echo '"  style="margin-top:10px;border:1px solid #aaa;padding:10px;" /></div>'; } ?> 
	        		</div>
            	</div>
            </div>
   			<?php
			break;	
			case "posts":
			?>
			<div class="stuffbox">
				<h3><?php echo $value['name']; ?></h3>
				<div class="inside"><input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" size="3" type="text" value="<?php echo get_option( $value['id'] ); ?>" />
				<p style="clear:left;"><small><?php echo $value['desc']; ?></small></p>
				</div>
			</div>
			<?php
			break;			
			case "login":
			?>
			<div class="stuffbox">
				<h3><?php echo $value['name']; ?></h3>
				<div class="inside">
             	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="yes"<?php if ( get_settings( $value['id'] ) == "yes") { echo " checked"; } ?> /><label>Yes</label><input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="no"<?php if ( get_settings( $value['id'] ) == "no") { echo " checked"; } ?> /><label>No</label>  
                <p style="clear:left;"><small><?php echo $value['desc']; ?></small></p>
            	</div>
            </div>
			<?php break;
				
			
		} 
	}
	?>
	</div></div>
	</div>
	</form>
	</div>
<?php
}




add_action('admin_menu', 'mytheme_add_admin'); 

include(TEMPLATEPATH.'/widgets/widget_login.php');
include(TEMPLATEPATH.'/widgets/widget_feature.php'); 

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name' => 'Sidebar One (left)',
	'before_widget' => '<div class="side-widget"><div class="widget-content">',
	'after_widget' => '</div></div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

if (get_option('fms_site_sidebars') == "2") {
	register_sidebar(array(
	'name' => 'Sidebar Two (right)',
	'before_widget' => '<div class="side-widget"><div class="widget-content">',
	'after_widget' => '</div></div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
	));
	}
}

function csv_tags() {
    $posttags = get_the_tags();
    foreach((array)$posttags as $tag) {
        $csv_tags .= $tag->name . ',';
    }
    echo '<meta name="keywords" content="'.$csv_tags.'" />';
}

function theme_excerpt($num) {
	global $more;
	$more = 1;
	$link = get_permalink();
	$limit = $num+1;
	$excerpt = explode(' ', strip_tags(get_the_content()), $limit);
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt).'...';
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	echo '<p>'.$excerpt.'</p>';
	$more = 0;
}

function metaDesc() {
	$content = strip_tags(get_the_content());
	if (strlen($content) < 155) {
		echo $content;
	} else {
		$desc = substr($content,0,155);
		echo $desc."...";
	}
}

function getImage($num) {
	global $more;
	$more = 1;
	$link = get_permalink();
	$content = get_the_content();
	$count = substr_count($content, '<img');
	$start = 0;
	for($i=1;$i<=$count;$i++) {
		$imgBeg = strpos($content, '<img', $start);
		$post = substr($content, $imgBeg);
		$imgEnd = strpos($post, '>');
		$postOutput = substr($post, 0, $imgEnd+1);
		$result = preg_match('/width="([0-9]*)" height="([0-9]*)"/', $postOutput, $matches);
		if ($result) {
			$pagestring = $matches[0];
			$image[$i] = str_replace($pagestring, "", $postOutput);
		} else {
			$image[$i] = $postOutput;
		}
		$start=$imgEnd+1;
	}
	if(stristr($image[$num],'<img')) { echo '<a href="'.$link.'">'.$image[$num]."</a>"; }
	$more = 0;
}

## Comment function
if ( ! function_exists( 'twentyten_comment' ) ) :
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li>
	<?php echo get_avatar( $comment, 32 ); ?>
		<div class="comment-info">
		<?php printf( __( '%s', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?> 
		 <?php if ( $comment->comment_approved == '0' ) : ?>
			(<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>)
		<?php endif; ?> 
		<?php edit_comment_link( __( '(Edit this)', 'twentyten' ), ' ' );?>
		<br />
		<small><?php printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></small>
	</div>
	<div class="comment-text"><?php comment_text(); ?></div>
	<!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

?>