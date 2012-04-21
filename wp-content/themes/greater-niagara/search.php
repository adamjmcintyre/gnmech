<?php get_header(); ?>

	<div id="content" class="narrowcolumn search">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>

		<nav class="post-links clearfix">
			<?php 
			    next_posts_link('&lt; Previous Entries');
			    $pp = get_previous_posts_link('Next Entries &gt;');
			    if(strlen($pp) > 0){
			        echo '<span class="separator">|</span>' . $pp;    
			    } 			    
			?>
		</nav>

        <ol class="listing">
    		<?php while (have_posts()) : the_post(); ?>
                <li>
                    <article id="post-<?php the_ID(); ?>" class="single-post clearfix">
                        <section class="image">
                            <a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>">
                                <?php isoblog_the_post_thumbnail($post->ID, array( 150,150 )); ?>
                            </a>
                        </section>
                        <section class="right-column">
                            <section class="body" role="main">
                                <header>
                                    <h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
                                </header>
                                                     
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
                </li>    
    		<?php endwhile; ?>
		</ol>

        <nav class="post-links post-links-btm clearfix">
            <?php 
                next_posts_link('&lt; Previous Entries');
                 
                $pp = get_previous_posts_link('Next Entries &gt;');
                if(strlen($pp) > 0){
                    echo '<span class="separator">|</span>' . $pp;    
                }               
            ?>
        </nav>

	<?php else : ?>

		<h2>No posts found. Try a different search?</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

<?php get_footer(); ?>

