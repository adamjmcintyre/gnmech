<?php
register_sidebar(array(
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
));

add_action('init', 'isoblog_add_taglines');
function isoblog_add_taglines(){
    $args = array(
        'label' => __('Isobar Is ...'),
        'singular_label' => __('Isobar Is ...'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => false,
        'supports' => array( 'title' ),
        'exclude_from_search' => true
        );

    register_post_type( 'isobar_tagline' , $args );    
}

add_action('init', 'isoblog_add_about_us_types');
function isoblog_add_about_us_types(){
    $args = array(
        'label' => __('About Us -- Blurbs'),
        'singular_label' => __('About Us -- Blurbs'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => false,
        // Allow users to specify classes to style blurbs via custom fields.
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'exclude_from_search' => true
        );

    register_post_type( 'about_us_blurbs' , $args );   

    $args = array(
        'label' => __('About Us -- Capabilities'),
        'singular_label' => __('About Us -- Capabilities'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => false,
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'exclude_from_search' => true
        );

    register_post_type( 'about_us_capability' , $args );    
}

add_action('init', 'isoblog_add_case_studies');
function isoblog_add_case_studies(){
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

add_action('init', 'isoblog_add_buzzworthy');
function isoblog_add_buzzworthy() {
    $args = array(
        'label' => __('Buzzworthy'),
        'singular_label' => __('Buzzworthy'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail' ),
        );

    register_post_type( 'buzzworthy' , $args );
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

function isoblog_write_body_tag(){
    $className = "post";
    if (is_home()) :
        $className = "homepage";
    endif;
    if (is_archive()) :
        $className = "listing";
    endif;
    ?>
    <!--[if lt IE 7 ]> <body class="<?php echo $className ?> ie ie6"> <![endif]--> 
<!--[if IE 7 ]>    <body class="<?php echo $className ?> ie ie7"> <![endif]--> 
<!--[if IE 8 ]>    <body class="<?php echo $className ?> ie ie8"> <![endif]--> 
<!--[if !IE]><!--> <body class="<?php echo $className ?>"> <!--<![endif]-->
    <?php

}
function isoblog_write_tagline(){
    if (is_home()) : ?>
        <h2> <span class="hidden">is</span> <span id="tagline-swap">this is our blog</span>.</h2>
    <?php elseif (is_author()) : 
        global $wp_query;
        $curauth = $wp_query->get_queried_object();
    ?> 
        <h2>This is <?php echo $curauth->first_name; ?>'s bio</h2>
    <?php elseif (is_category()) : ?>
        <h2>These are the <?php single_cat_title() ?> <em>posts </em> </h2>
    <?php elseif (is_tag()) : ?>
        <h2>This is the <?php single_tag_title()  ?> page.</h2>
    <?php elseif (is_day()) : ?>
        <h2>This what we said on <?php the_time('F jS, Y') ?>  </h2>
    <?php elseif (is_month()) : ?>
        <h2>This what we said in <?php the_time('F, Y') ?>  </h2>
    <?php elseif (is_year()) : ?>
        <h2>This what we said in <?php  the_time('Y') ?>  </h2>
    <?php elseif (is_archive()) : ?>
        <h2>This is the  <?php echo isoblog_get_term(); ?>  <em>blog</em></h2>
    <?php elseif (is_page()) : ?>
        <h2><?php the_title(); ?></h2>
    <?php 
    //this will need to be a taxonomic term at some point
    elseif (is_single()) :?>
        <?php if ( isoblog_in_term("creative","top-categories") ) : ?>
            <h2>This is the Creative <em>blog.</em></h2>
        <?php elseif (isoblog_in_term("technology","top-categories")) : ?>
            <h2>This is the Technology <em>blog.</em></h2>
        <?php elseif ( isoblog_in_term("innovation","top-categories")) : ?>
            <h2>This is the Innovation <em>blog.</em></h2>
        <?php endif; ?>
    <?php else : ?>
        <h2> This is our blog.</h2>
    <?php endif;
}

add_action( 'init', 'isoblog_create_taxonomies', 0 );

function isoblog_create_taxonomies() {
    register_taxonomy( 'top-categories', 'post', array( 'hierarchical' => false, 'label' => 'Topics', 'query_var' => true, 'rewrite' => true ) );
}

function isoblog_write_cat_and_comments($cat) {
?>
<section class="other-category">
    <header><h1><a href="<?php echo get_bloginfo('url') . '/top-categories/' . $cat . '/'; ?>"><?php echo $cat; ?></a></h1></header>
        <ul class="post-list">
        <?php
            global $post;
            $myposts = get_posts( array(
                'top-categories' => $cat,
                'numberofposts' => '5'
            ));
            foreach($myposts as $post) :
                setup_postdata($post);
            ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endforeach; ?>
    </ul> 
</section>
<?php
}
function isoblog_write_blog_listings($tax) {
?><div id="blog-listings" class="clearfix"><?php
if ($tax == "Creative" ) :
        isoblog_write_cat_and_comments("technology");
        isoblog_write_cat_and_comments("innovation");
    elseif ($tax == "Technology"):
        isoblog_write_cat_and_comments("creative");
        isoblog_write_cat_and_comments("innovation");
    else :
        isoblog_write_cat_and_comments("creative");
        isoblog_write_cat_and_comments("technology");
    endif;
?></div><?php
}
function isoblog_write_buzz() {
$loop = new WP_Query( array( 'post_type' => 'buzzworthy', 'posts_per_page' => 2 ) ); 
while ( $loop->have_posts() ) : $loop->the_post(); 
?>
    <div> 
        <?php the_content(); ?>
      <details>
        <p><?php 
        the_excerpt(); 
        the_author_posts_link(); 
        ?></p>
        
      </details>
    </div>
<?php endwhile;
}

function isoblog_write_blurbs() {
$loop = new WP_Query( array( 'post_type' => 'about_us_blurbs', 'posts_per_page' => 10, 'order' => 'ASC' ) );
$carouselCount = 1;
while ( $loop->have_posts() ) : $loop->the_post(); 
?>
	<li class="<?php echo('container jcarousel-item jcarousel-item-horizontal jcarousel-item-' . $carouselCount . ' jcarousel-item-' . $carouselCount . '-horizontal'); ?> <?php $currentID = get_the_ID(); $cssClass = get_post_meta($currentID, cssClass, true); echo($cssClass); ?>" style="float: left; list-style: none outside none; width: 770px important!;" jcarouselindex="<?php echo($carouselCount); ?>">
	<h1><?php single_post_title(' '); ?></h1>

	<article><?php the_content('Read more...'); ?></article>
	</li>
	<?php $carouselCount++; ?>
<?php endwhile;
	echo"<li class='ourTeam'><div class='authorsList'><h1 id='ourTeam'>Our Team</h1><ul class='authorRow'>";
		
		$authors = wp_list_authors('echo=0');
        $all_authors = explode('<li>',str_replace('</li>','',$authors));
        $author_list = array();
	        
        for($i = 0; $i < count($all_authors); $i++){
            preg_match('/<a.*href=[\'"].*\/author\/([^\'"\/]*).*>(.*)<\/a>/',$all_authors[$i],$matches);
            // Map author name to author ID
            if(strlen($matches[1]) > 0){
                $author_list[$matches[1]] = $matches[2];            
            }
        }        
		
			// Shuffle up our array elements 
                    $shuffled = array_keys($author_list);
                    shuffle($shuffled);
                    $default_profile_img = get_bloginfo('stylesheet_directory') . '/img/fpo_author-pic.png';
                    
                    // We only display 40 authors
                    $count = 0;
                    $totalAuthors = 1;
                    while($totalAuthors <= 51 && $count < count($shuffled)){
                        $user = get_userdatabylogin($shuffled[$count]);
                        if($user->agree != 'no' && validate_gravatar($user->user_email)){
                            $class = ' class="authorLI"';
							if(($totalAuthors) % 10 == 0){
								$class = ' class="authorLI last"';
							}
    
                            echo '<li' . $class . '><a href="' . get_bloginfo('url') . '/author/' . $shuffled[$count] . '">';
                            echo get_avatar($user->ID, 72, $default_profile_img) . '<span class="hidden">' . $author_list[$shuffled[$count]] . '</span></a></li>';  
							
							if(($totalAuthors) % 10 == 0){
								
								echo('</ul><ul class="authorRow">');
                            }
							
                            $totalAuthors++;
														
							if($totalAuthors == 3){
								echo("<li class='authorLI big'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/two_00.jpg'></li>");
								$totalAuthors+=2;
							}
							if($totalAuthors == 6){
								echo("<li class='authorLI'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_00.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 7){
								echo("<li class='authorLI big'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/two_01.jpg'></li>");
								$totalAuthors+=2;
							}
							if($totalAuthors == 11){
								echo("<li class='authorLI xl'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/four_00.jpg'></li>");
								$totalAuthors+=2;
							}
							if($totalAuthors == 14){
								echo("<li class='authorLI'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_01.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 21){
								echo("<li class='authorLI xl'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/four_01.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 22){
								echo("<li class='authorLI xl'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/four_02.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 25){
								echo("<li class='authorLI big'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/two_02.jpg'></li>");
								$totalAuthors+=2;
							}
							if($totalAuthors == 28){
								echo("<li class='authorLI'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_02.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 32){
								echo("<li class='authorLI'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_03.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 34){
								echo("<li class='authorLI big'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/two_03.jpg'></li>");
								$totalAuthors+=2;
							}
							if($totalAuthors == 38){
								echo("<li class='authorLI'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_04.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 41){
								echo("<li class='authorLI'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_05.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 43){
								echo("<li class='authorLI big'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/two_04.jpg'></li>");
								$totalAuthors+=2;
							}
							if($totalAuthors == 45){
								echo("<li class='authorLI'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_06.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 48){
								echo("<li class='authorLI'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_07.jpg'></li>");
								$totalAuthors++;
							}
							if($totalAuthors == 50){
								echo("<li class='authorLI last'><img src='http://na.isobar.com/wp-content/themes/IsoBlog/css/img/one_08.jpg'></li>");
								$totalAuthors++;
							}	
                        }                        
                        $count++;

                    }	
	echo"</ul></div></li>";
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


function isoblog_truncate($text, $max = 25, $append = '&hellip;'){
    if(strlen($text) <= $max){
        return $text;
    }
    $truncated = substr($text,0,$max);
    return substr($truncated, 0, strrpos($truncated, " ")) . $append;           
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

function validate_gravatar($email) {
    // Cache the results of pinging Gravatar's service to determine if 
    // this user has an avatar or not.
    $email = strtolower($email);
    $hash = md5($email);    
    
    $cachefile = WP_CONTENT_DIR . '/gravatar-cache/gravatar-' . $hash . '.txt';
    $cachetime = 24 * 60 * 60;  // One day (24 hours x 60 minutes/hour * 60 seconds/minute)
   
    $has_valid_avatar = 0;

    if(is_file($cachefile) && time() - $cachetime < filemtime($cachefile)){
        $has_valid_avatar = file_get_contents($cachefile);
    }
    else{
        // Craft a potential url and test its headers
        $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
        $headers = get_headers($uri);
    
        if (!preg_match("|200|", $headers[0])) {
            $has_valid_avatar = 0;
        } else {
            $has_valid_avatar = 1;
        }
        $fp = fopen($cachefile,'w');
        fwrite($fp,$has_valid_avatar);
        fclose($fp);
    }
    return $has_valid_avatar;
}

function isoblog_get_author_posts_link($auth){
    return get_bloginfo('url') . '/author/' . $auth->user_nicename;
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
// Add Slideshare oEmbed
function add_oembed_slideshare(){
    wp_oembed_add_provider( 'http://www.slideshare.net/*', 'http://api.embed.ly/v1/api/oembed',true);
}
add_action('init','add_oembed_slideshare');

// Customize TinyMCE "styles" dropdown
function tiny_mce_before_init_styles( $init_array ) {
$init_array['theme_advanced_styles'] = "Center Align=aligncenter;Left Align=alignleft;Right Align=alignright;Caption=wp-caption;oembed=wp-oembed";
return $init_array;
}
add_filter( 'tiny_mce_before_init', 'tiny_mce_before_init_styles' );
?>