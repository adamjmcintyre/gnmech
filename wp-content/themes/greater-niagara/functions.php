<?php
/*register_sidebar(array(
    'name' => 'Default',
    'before_widget' => '',
    'before_title' => '',
    'after_title' => '',
    'after_widget' => ''
));

register_sidebar(array(
    'name' => 'Home',
    'before_widget' => '',
    'before_title' => '',
    'after_title' => '',
    'after_widget' => ''
));

register_sidebar(array(
    'name' => 'Author',
    'before_widget' => '',
    'before_title' => '',
    'after_title' => '',
    'after_widget' => ''    
));*/

add_action('init', 'add_case_studies');
function add_case_studies(){
    $args = array(
        'label' => __('Case Studies'),
        'singular_label' => __('Case Study'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'thumbnail', 'tags', 'excerpt', 'editor' ),
        'exclude_from_search' => true,
        '_builtin' => false,
        'rewrite' => array("slug" => "case-studies"),
		    'taxonomies' => array('post_tag')
        );

    register_post_type( 'case_study' , $args );       
}

add_action("manage_posts_custom_column","custom_case_study_data_columns");
add_action("manage_edit-case_study_columns","custom_case_study_columns");
function custom_case_study_columns($columns){
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Title",
        "case_study_company_name" => "Company",
        "case_study_project_name" => "Project",
        "date" => "Date"
    );
    
    return $columns;
}

function custom_case_study_data_columns($column){
    global $post;

    if("title" == $column) echo $post->post_title;
    elseif("date" == $column) echo mysql2date('d M Y',$post->post_date);
    elseif("case_study_company_name" == $column) echo get_post_meta($post->ID,'case_study_company_name',true);
	elseif("case_study_featured" == $column) echo get_post_meta($post->ID,'case_study_featured',true);
}

add_action("add_meta_boxes","add_case_study_boxes");
function add_case_study_boxes(){
    add_meta_box("case-study-meta","Case Study Information","do_case_study_meta","case_study","normal","high");
    wp_register_style('isobar-admin','/wp-content/themes/IsoBlog/css/admin.css',false,false,'screen');
    wp_enqueue_style('isobar-admin');    
}
function do_case_study_meta(){
    global $post;
    wp_nonce_field('case_study','case_study_nonce');
    ?>
        <div class="postbox isobar-admin">
            <h3>Company Information:</h3>
            <fieldset class="inside">        
                <div class="row">
                    <label for="case_study_company_name">Company Name</label>
                    <input type="text" id="case_study_company_name" name="case_study_company_name" value="<?php echo get_post_meta($post->ID,'case_study_company_name',true) ?>" />
                </div>
                <div class="row">
                    <label for="case_study_company_industry">Industry</label>
                    <input type="text" id="case_study_company_industry" name="case_study_company_industry" value="<?php echo get_post_meta($post->ID,'case_study_company_industry',true) ?>" />        
                </div>
                <div class="row">
                    <label for="case_study_company_description">Company Description</label>
                    <textarea id="case_study_company_description" name="case_study_company_description" rows="10" cols="50"><?php echo get_post_meta($post->ID,'case_study_company_description',true) ?></textarea>        
                </div>
            </fieldset>
        </div>
        
        <div class="postbox isobar-admin">
            <h3>Featured</h3>
            <fieldset class="inside">
                
				<div class="row">
                    <label for="case_study_featured">Featured (To set, enter "featured" here. Don't forget to remove the old one.)</label>
                   <input type="text" id="case_study_featured" name="case_study_featured" maxlength="8" value="<?php echo get_post_meta($post->ID,'case_study_featured',true) ?>" />      
                </div>
            </fieldset>
        </div>        
    <?php 
}

add_action('save_post','save_case_study_data');
function save_case_study_data($post_id){
    if(! wp_verify_nonce($_POST['case_study_nonce'],'case_study')){
        return $post_id;
    }   
    
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
        return $post_id;
    }
    
    // Check permissions
    if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
    } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
    }

    $case_data = array(
        'case_study_company_name' => $_POST['case_study_company_name'],
        'case_study_company_industry' => $_POST['case_study_company_industry'],
        'case_study_company_description' => $_POST['case_study_company_description'],
        'case_study_project_name' => $_POST['case_study_project_name'],
		'case_study_featured' => $_POST['case_study_featured']
    );
    
    foreach($case_data as $key => $value){
        update_post_meta($post_id, $key, $value);
    }    

    return $case_data;
}
    
if (function_exists('add_theme_support')){
    add_theme_support('post-thumbnails');
    add_image_size('smallerThumb', 180, 180, true); 
    add_image_size('largerThumb', 375, 375, true);  
}

/***
 * Add post thumbnails to RSS feed
 */
function rss_post_thumbnail($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
        $content = '<p class="post-thumbnail">' . get_the_post_thumbnail($post->ID) . '</p>' . get_the_content();
    }
    return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

/***
 * Change the default "more" text on post excerpts for the main page.
 */
function new_excerpt_more($post){
    return '<a href="' . get_permalink($post->ID) . '">&hellip;</a>';
}
add_filter('excerpt_more','new_excerpt_more');

/***
 * Add some extended attributes to user profiles.
 */
add_action('show_user_profile', 'extended_attributes');
add_action('edit_user_profile', 'extended_attributes');

function extended_attributes($user){ ?>
    <h3><?php _e("Bio Info", "blank"); ?></h3>
    <table class="form-table">
       <tr>
           <th><label for="title"><?php _e("Title"); ?></label></th>
           <td>
               <input type="text" name="title" id="title" value="<?php echo esc_attr(get_the_author_meta('title', $user->ID)); ?>" class="regular-text"><br>
               <span class="description"><?php _e("Enter your Isobar Title or Something Witty"); ?></span>
           </td>
       </tr>
       <tr>
           <th><label for="office"><?php _e("Office"); ?></label></th>
           <td>
               <?php 
                   $office = get_the_author_meta('office', $user->ID); 
                   $cities = array('Boston','Toronto','San Francisco');
               ?>
               <select name="office" id="office">
                   <?php 
                       for($i = 0; $i < count($cities); $i++){
                           $selected = "";
                           if($cities[$i] == $office){
                               $selected = 'selected="selected"';
                           }
                           echo '<option value="' . $cities[$i] . '"' . $selected . '>' . $cities[$i] . '</option>';
                       }
                   ?>                  
               </select>
           </td>
       </tr>
       
       <!--
       <tr>
           <th><label for="active"><?php _e("Active"); ?></label></th>
           <td>
               <input name="active" type="checkbox" value="<?php if (get_the_author_meta('active', $user->ID) == "true"){   echo " checked"; }; ?>" />
           </td>
       </tr>   
       -->
       
       <tr>
            <th><label for="agree"><?php _e('Is this employee Active?'); ?></label></th>
            <td>
            <?php $agree = get_the_author_meta( 'agree', $user->ID ); ?>
                <ul>
                    <li><input value="yes" name="agree" <?php if ($agree == 'yes' ) { ?>checked="checked"<?php }?> type="radio" /> <?php _e('Yes'); ?></li>
                    <li><input value="no"  name="agree" <?php if ($agree == 'no'  ) { ?>checked="checked"<?php }?> type="radio" /> <?php _e('No'); ?></li>
                </ul>
            </td>           
        </tr>

       
       
       <tr>
           <th><label for="blurb"><?php _e("Blurb"); ?></label></th>
           <td>
               <input type="text" name="blurb" maxlength="100" id="blurb" value="<?php echo esc_attr(get_the_author_meta('blurb', $user->ID)); ?>" class="regular-text"><br>
               <span class="description"><?php _e("Little blurb about yourself. (Please try to keep it under 100 characters!)"); ?></span>
           </td>
       </tr>               
    </table>   
    
    <h3><?php _e("Profile Photo", "blank"); ?></h3>
    <p>To upload your profile photo, please upload it within a <a href="http://www.gravatar.com" target="_blank">Gravatar</a> account. It's easy, we promise.</p><br /><br />
    
    <h3><?php _e("Follow Feeds", "blank"); ?></h3>
    <strong>Remember! People will see this stuff!!!</strong>
    <table class="form-table">
       <tr>
           <th><label for="twitter"><?php _e("Twitter"); ?></label></th>
           <td>
               @<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" class="regular-text"><br>
               <span class="description"><?php _e("Enter your Twitter username. No need to put an @ in front!"); ?></span>
           </td>
       </tr>
       <tr>
           <th><label for="facebook"><?php _e("Facebook"); ?></label></th>
           <td>
               <input type="text" name="facebook" id="facebook" value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>" class="regular-text"><br>
               <span class="description"><?php _e("Enter your Facebook username"); ?></span>
           </td>
       </tr>
       <tr>
           <th><label for="flickr"><?php _e("Flickr"); ?></label></th>
           <td>
               <input type="text" name="flickr" id="flickr" value="<?php echo esc_attr(get_the_author_meta('flickr', $user->ID)); ?>" class="regular-text"><br>
               <span class="description"><?php _e("Enter your Flickr username"); ?></span>
           </td>
       </tr>   
       <tr>
           <th><label for="linkedin"><?php _e("LinkedIn"); ?></label></th>
           <td>
               http://www.linkedin.com/in/<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>" class="regular-text"><br>
               <span class="description"><?php _e("Enter your LinkedIn public profile username from your public profile URL (http://www.linkedin.com/in/[your_name])"); ?></span>
           </td>
       </tr>               
    </table>
<?php }

add_action('personal_options_update', 'save_extended_attributes');
add_action('edit_user_profile_update', 'save_extended_attributes');

function save_extended_attributes($user_id){
    if(! current_user_can('edit_user', $user_id)){ return false; }
    
    update_usermeta($user_id, 'title', $_POST['title']);
    update_usermeta($user_id, 'office', $_POST['office']);
    update_usermeta($user_id, 'active', $_POST['active']);  
    update_usermeta($user_id, 'agree', $_POST['agree']);  
    update_usermeta($user_id, 'blurb', $_POST['blurb']);
    update_usermeta($user_id, 'twitter', $_POST['twitter']);
    update_usermeta($user_id, 'facebook', $_POST['facebook']);
    update_usermeta($user_id, 'flickr', $_POST['flickr']);
    update_usermeta($user_id, 'linkedin', $_POST['linkedin']);      
}

function write_body_tag(){
    $className = "post";
    if (is_home()) :
        $className = "homepage";
    endif;
    if (is_archive()) :
        $className = "listing";
    endif;
    ?>
    <!--[if lt IE 8 ]>    <body class="<?php echo $className ?> oldIE"> <![endif]--> 
    <!--[if !IE]><!--> <body class="<?php echo $className ?>"> <!--<![endif]-->
    <?php

}

add_action( 'init', 'create_taxonomies', 0 );

function create_taxonomies() {
    register_taxonomy( 'top-categories', 'post', array( 'hierarchical' => false, 'label' => 'Topics', 'query_var' => true, 'rewrite' => true ) );
}

function isoblog_write_capability() {
  $loop = new WP_Query( array( 'post_type' => 'about_us_capability', 'posts_per_page' => 4 ) ); 
  $capabilityCount = 1;
  while ( $loop->have_posts() ) : $loop->the_post(); 
  ?>
  	<?php if ($capabilityCount <= 4) { ?>
  		<li>
  		<h2><?php single_post_title(' '); ?></h2>
  		<aside><?php echo($capabilityCount); ?></aside>
  		<article><?php the_content('Read more...'); ?></article>
  		</li>
  	<?php $capabilityCount++; }  ?>
  <?php endwhile;
}

function isoblog_write_clients() {
	$case_count = 0;
	echo "<div id='column_01'>";
		$loop = new WP_Query( array( 'post_type' => 'case_study', 'orderby' => 'title', 'order' => 'asc', 'posts_per_page' => '4', 'numberposts' => '4', 'offset' => '0', 'post_status' => 'publish' ) ); 
		while ( $loop->have_posts() ) : $loop->the_post(); 
			?>
			<li><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><span class="rightRight">&rsaquo;</span><h3><?php the_title(); ?></a></h3></li>
		<?php endwhile;
	echo("</div>");
	echo "<div id='column_02'>";
		$loop = new WP_Query( array( 'post_type' => 'case_study', 'orderby' => 'title', 'order' => 'asc', 'posts_per_page' => '4', 'numberposts' => '4', 'offset' => '4', 'post_status' => 'publish' ) ); 
		while ( $loop->have_posts() ) : $loop->the_post(); 
			?>
			<li><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><span class="rightRight">&rsaquo;</span><h3><?php the_title(); ?></a></h3></li>
		<?php endwhile;
	echo("</div>");
}

function isoblog_write_case_studies() {

$loop = new WP_Query( array( 'post_type' => 'case_study', 'posts_per_page' => 10, 'meta_key' => 'case_study_featured', 'meta_value' => 'featured' ) ); 
while ( $loop->have_posts() ) : $loop->the_post(); 
?>
    <article class="case-study featured-case"> 
        <section class="image">
			<?php the_post_thumbnail(); ?>
		</section>
		<section class="info">
			<h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
			<?php the_excerpt(); ?> 
			<?php global $post; $excludeID = $post->ID;?>
		</section>
    </article>
	
	
<?php endwhile;

$loop = new WP_Query( array( 'post_type' => 'case_study', 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'asc', 'post__not_in' => array($excludeID) ) ); 
while ( $loop->have_posts() ) : $loop->the_post(); 
?>
    <article class="case-study"> 
        <section class="image">
			<?php the_post_thumbnail(); ?>
		</section>
		<section class="info">
			<h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
			<?php the_excerpt(); ?> 
			
		</section>
    </article>
<?php endwhile;
}


function isoblog_in_term( $tax, $category, $_post = null ) {
    if ( empty( $category ) )
        return false;

    if ( $_post ) {
        $_post = get_post( $_post );
    } else {
        $_post =& $GLOBALS['post'];
    }

    if ( !$_post )
        return false;
    
    $r = is_object_in_term( $_post->ID, $category, $tax );

    if ( is_wp_error( $r ) ){
        return false;
    }
    
    return $r;
}
function isoblog_get_term(){
        global $wp_query;
        $curtax = $wp_query->get_queried_object();
        return  $curtax->name;
}

function isoblog_get_the_post_thumbnail($postID, $size = 'thumbnail'){
    $thumb = get_the_post_thumbnail($postID, $size);
    if($thumb){
        return $thumb;
    }  
    else{
        $dimensions = '';
        $class = "attachment-thumbnail wp-post-image";
        if(is_array($size)){
            $dimensions = 'width="' . $size[0] . '" height="' . $size[1] . '"';    
        }
        else{
            switch($size){
                case 'largerThumb':
                    $class = "attachment-largerThumb wp-post-image";
                    $dimensions = 'width="375" height="375"';
                    break;
                case 'large':
                    $class = "attachment-large wp-post-image";
                    $dimensions = 'width="375" height="375"';
                    break;
                case 'medium':
                    $class = "attachment-medium wp-post-image";
                    $dimensions = 'width="236" height="236"';
                    break;                
                case 'smallerThumb':
                    $class = "attachment-smallerThumb wp-post-image";
                case 'thumbnail': 
                default:
                    $dimensions = 'width="180" height="180"';      
            }
        }
        return '<img src="' . get_bloginfo('template_directory') . '/img/defaultThumbnail.jpg' . '" class="' . $class . '" alt="" ' . $dimensions . '>';
    }  
}

function isoblog_the_post_thumbnail($postID, $size = 'thumbnail'){
    echo isoblog_get_the_post_thumbnail($postID, $size);
}

// Customize TinyMCE "styles" dropdown
function tiny_mce_before_init_styles( $init_array ) {
  $init_array['theme_advanced_styles'] = "Center Align=aligncenter;Left Align=alignleft;Right Align=alignright;Caption=wp-caption;oembed=wp-oembed";
  return $init_array;
}
add_filter( 'tiny_mce_before_init', 'tiny_mce_before_init_styles' );
?>