<?php
/**
 * Outputs tagline posts, allowing us to hook in via jQuery to dynamically display them.
 * 
 * @package WordPress
 * @subpackage IsoBlog
 * 
 * Template Name: taglines
*/
?>
<?php 
    header('Content-type: text/plain');
    $posts = get_posts('post_type=isobar_tagline&nopaging=true');

    if(isset($_GET['callback'])){
        echo $_GET['callback'] . '(';
    }

    echo '{ ';
    echo 'values : [';
    
    $last = count($posts) - 1;
    $i = 0;
    foreach($posts as $post):
        setup_postdata($post);
        $endPost = '"';
        if($i < $last){
            $endPost = '",';
        }
        
        echo '"' . get_the_title() . $endPost;
        $i++;
    endforeach;
    echo ']}';
    
    if(isset($_GET['callback'])){
        echo ')';
    }
?>
