<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gte IE 8]><!--><html <?php language_attributes(); ?>><!--<![endif]-->

<head profile="http://gmpg.org/xfn/11">
    <meta charset="<?php bloginfo('charset'); ?>">
    <!--[if IE]><![endif]-->

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
    <meta name="author" content="Greater Niagara Mechanical" >

    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_bloginfo('template_directory') . '/style.css'; ?>">
 
    <!--[if lt IE 9]>
    <script type="text/javascript">
    var elem;
    var elems = 'abbr article aside audio canvas datalist details eventsource figure footer header hgroup mark menu meter nav output progress section time video'.split(' ');
    var i = elems.length+1;
    while ( i >= 0 ) {
        elem = document.createElement( elems[i] );
        i = i - 1;
    }
    elem = null;
    </script>
    <![endif]-->    

<?php
 //determine the feed url
 if (is_category()){
   $feed_url=get_category_feed_link(get_query_var('cat'));
 }elseif(is_tag()){
   $feed_url=get_tag_feed_link(get_query_var('tag_id'));
 }elseif(is_author()){
   $feed_url=get_author_feed_link(get_query_var('author'));
 }elseif(is_single()){
   $feed_url=get_post_comments_feed_link(get_query_var('p'));
 }else{
   $feed_url=get_feed_link();
 }
?>

<?php 
    // Facebook Like button integration
    if(is_single()){
        $title = trim(wp_title(false,false));

        $thumb = get_the_post_thumbnail($post->ID);
        $thumb_url = get_bloginfo('stylesheet_directory') . '/css/img/logo_isobar.png';
        if(strlen($thumb) > 0){
            preg_match('/<img.*src=[\'"]([^\'"]*)[\'"].*>/',$thumb,$matches);
            $thumb_url = $matches[1];            
        }
    ?>
        <meta property="og:title" content="<?php echo $title; ?>">
        <meta property="og:site_name" content="<?php echo bloginfo('name'); ?>">
        <meta property="og:image" content="<?php echo $thumb_url; ?>">                  
    <?php 
    }
?>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php echo $feed_url ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> ATOM Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
</head>

<?php write_body_tag(); ?>

<div id="container">
    <header class="clearfix">
        <a href="/" class="logo">
            <img src="<?php echo get_bloginfo('stylesheet_directory') . '/img/logo.png'; ?>" alt="Greater Niagara Mechanical: Western New York HVAC design and installation">
        </a>
        <section class="contact-information logo vcard">
            <h1 class="fn">Greater Niagara Mechanical, Inc.</h1>
            <p>
                <span class="street-address">7311 Ward Rd # A</span>
                <span class="locality">North Tonawanda</span>
                <span class="region">New York</span>
                <span class="postal-code">14120</span>
            </p>                    
            <h2 class="tel">
                (716) 695-3600
            </h2>                   
        </section>
        <nav id="main-navigation">
            <ul>
                <li><a href="/1">Services</a></li>
                <li><a href="/2">Project Studies</a></li>
                <li><a href="/3">Specialties</a></li>
                <li><a href="/4">About Us</a></li>
                <li><a href="/5">Contact</a></li>
            </ul>
        </nav>
    </header>  
      
    <section id="content" role="main">
