<?php
/**
 * The home page.
 *
 * @package WordPress
 * @subpackage IsoBlog
 */
/*
 * Template Name: Home
 */
?>
<?php get_header(); ?>
<div class="toggle-opts clearfix">
	<h5>Latest posts:</h5>
	<ul>
		<li class="on"><a href="#hero" class="hero-view">Grid</a></li>
		<li><a href="#list" class="list-view">List</a></li>
	</ul>
</div>

<section id="featured-posts" class="hero toggle-posts clearfix">
	<header class="hidden">
		<h1>Latest Posts</h1>
	</header>
<?php

if (have_posts()) {
	$i = 0;
	$myposts = get_posts('numberposts=21&orderby=date&order=DESC');
	foreach($myposts as $post) {
		setup_postdata($post);
?>
	<!-- FEATURED POSTS MOSAIC -->
	<article class="<?php echo "entry hero main-category category-". $i; ?>" id="hv<?php echo $i; ?>">
		<header>
			<h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>">	<?php the_title(); ?></a></h1>
		</header>
		<div class="rollover">
			<!-- LARGE THUMBNAIL -->		
			<div id="hvl<?php echo $i; ?>" style="display:none;">
				<a class="thumb" href="<?php the_permalink() ?>"><?php the_post_thumbnail("largerThumb"); ?></a>
				<blockquote class="larger">
					<p>
					<span class="date"><?php the_time('j F Y'); ?></span>
					<span class="title"><?php echo isoblog_truncate(get_the_title(), 60); ?></span>									
					<span class="excerpt"><?php echo isoblog_truncate(get_the_excerpt(), 120); ?></span>
					<span class="author">&mdash; <?php the_author(); ?> </span>
					</p>
				</blockquote>
			</div>
			<!-- SMALL THUMBNAIL -->
			<div id="hvs<?php echo $i; ?>" style="display:none;">
				<a class="thumb" href="<?php the_permalink() ?>"><?php the_post_thumbnail("smallerThumb"); ?></a>
				<blockquote class="smaller">
					<p>
					<span class="date"><?php the_time('j F Y'); ?></span>
					<span class="title"><?php echo isoblog_truncate(get_the_title(), 40); ?></span>														
					<span class="excerpt"><?php echo isoblog_truncate(get_the_excerpt(), 70); ?></span>
					<span class="author">&mdash; <?php the_author(); ?> </span>
					</p>
				</blockquote>
			</div>
		</div>
		
		<!-- FEATURED AREA: TOP -->
		<section class="highlight-info hidden">
			<section class="thumbnail">
				<a href="<?php the_permalink() ?>"  style="display:inline; margin-right:30px; margin-bottom:20px; float:left;"><?php
					if (has_post_thumbnail()) {
						the_post_thumbnail(array(150,150));
					} else {
						echo '<img src="'. get_bloginfo('stylesheet_directory') .'/img/defaultThumbnail.jpg" width="150" height="150" border="0" />';
					}
				?></a>
			</section>
			<article class="description">
				<header>
					<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></h1>
				</header>
				<a href="<?php the_permalink() ?>"><?php the_excerpt(); ?></a>
				<footer>
					<time datetime="<?php the_time('j F Y') ?>" pubdate="pubdate"><?php the_time('j F Y') ?></time> |
					<span class="categories">Category: <?php the_category(', '); ?></span> |
					<span role="author" class="author">by <?php the_author_posts_link(); ?></span>
				</footer>
			</article>
		</section>
	</article>
<?php
		$i++;
	} // foreach
?>

	<div id="featuredList" class="list">
	<?php

	$i = 0;
	$myposts = get_posts('numberposts=21&orderby=date&order=DESC');
	foreach($myposts as $post) {
		setup_postdata($post);
?>
		<article id="lv<?php echo $i++; ?>" class="single-post clearfix">
            <section class="image">
                <a href="<?php the_permalink() ?>" rel="permalink" title="Link to <?php the_title(); ?>"><?php isoblog_the_post_thumbnail($post->ID, array( 150,150 )); ?></a>
            </section>
		    <section class="right-column">
    		    <section class="body" role="main">
    		        <header>
                        <h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
                    </header>
                    <section class="author">
                        <header>
                            <h4 class="hidden">Author</h4>
                        </header>
                        <div class="author vcard">
                            <cite class="fn">
                                <h6>
                                    <a href="<?php echo get_bloginfo('url') . '/author/' . get_the_author_meta('user_login',get_the_author_id()); ?>"
                                        class="url" rel="author"><?php the_author(); ?></a>
                                </h6>
                                <p class="title">
                                    <?php echo the_author_meta('title'); ?>
                                </p>
                            </cite>
                        </div>
                    </section>
                    <details>
                        <p>Posted in <?php the_category(', ') ?></p>                 
                        <p><time datetime="<?php the_time('j F Y') ?>" pubdate="pubdate"><?php the_time('j F Y') ?></time></p>
                    </details>
        			<?php the_excerpt(); ?>
                    <footer>
                    	<p><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
                    </footer>        			
                </section>
            </section>
        </article>
<?php
	}
?>
        
        <nav class="post-links clearfix">
            <a href="<?php echo get_bloginfo('url') . '/archives/'; ?>" >View all posts</a>
        </nav>
	</div>
<?php
}
?>
<!--[if IE]>
	<div class="clearfix"></div>
<![endif]-->
</section>

<section id="social-media">
	<header class="clearfix">
		<h3>What we&#39;re talking about</h3>
		<ul class="social-icons">
			<li><a href="http://twitter.com/isobarna/lists/isobartweeters" class="twitter external">Tweets</a> </li>
		</ul>
	</header>
	<div class="social-container">
		<div id="tweet-list"></div>
	</div>
</section>

<?php get_footer(); ?>