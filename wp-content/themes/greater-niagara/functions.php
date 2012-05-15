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

/*add_action('init', 'add_project_studies');
function add_project_studies(){
    $args = array(
        'label' => __('Project Studies'),
        'singular_label' => __('Project Study'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'thumbnail', 'tags', 'editor'),
        'exclude_from_search' => true,
        '_builtin' => false,
        'rewrite' => array("slug" => "project-studies"),
		    'taxonomies' => array('category'),
        'has_archive' => true
        );

    register_post_type( 'project_study' , $args );       
}*/

add_action('init', 'add_principals');
function add_principals(){
    $args = array(
        'label' => __('Principals'),
        'singular_label' => __('Principal'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'thumbnail', 'editor' ),
        'exclude_from_search' => true,
        '_builtin' => false,
        'rewrite' => array("slug" => "principals")
        );

    register_post_type( 'principal' , $args );   
}

add_action('init', 'add_news');
function add_news(){
    $args = array(
        'label' => __('News'),
        'singular_label' => __('News'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'thumbnail', 'editor' ),
        'exclude_from_search' => true,
        '_builtin' => false,
        'rewrite' => array("slug" => "news")
        );

    register_post_type( 'news' , $args );   
}

/*add_action("manage_posts_custom_column","custom_case_study_data_columns");
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
}*/
    
if (function_exists('add_theme_support')){
    add_theme_support('post-thumbnails');
    add_image_size('smallerThumb', 180, 180, true); 
    add_image_size('largerThumb', 375, 375, true);  
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

function write_project_category($catId) {

$loop = new WP_Query( array( 'post_type' => 'post', 'category_name' => mysql_real_escape_string($catId), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'asc', 'post__not_in' => array($excludeID) ) ); 
while ( $loop->have_posts() ) : $loop->the_post(); 
?>
    <article class="case-study archive"> 
        <section class="image">
            <a href="<?php the_permalink() ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </section>
        <section class="info">
            <h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
            <?php the_excerpt(); ?> 
        </section>
    </article>
<?php endwhile;
}

function write_case_studies() {

$loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'asc', 'post__not_in' => array($excludeID) ) ); 
while ( $loop->have_posts() ) : $loop->the_post(); 
?>
    <article class="case-study archive"> 
        <section class="image">
            <a href="<?php the_permalink() ?>">
			    <?php the_post_thumbnail(); ?>
            </a>
		</section>
		<section class="info">
			<h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
			<?php the_excerpt(); ?> 
		</section>
    </article>
<?php endwhile;
}

function new_excerpt_more($more) {
       global $post;
    return '&nbsp;&nbsp;<a href="'. get_permalink($post->ID) . '">&raquo; Read more</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

?>