<?php get_header(); ?>

    <div class="archive-list">
        <?php if (have_posts()) : ?>
        <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="single-post clearfix">
                <section class="image">
                    <?php isoblog_the_post_thumbnail($post->ID, array( 150,150 )); ?>
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
                                            class="url" rel="author">
                                            <?php the_author(); ?>
                                        </a>                        
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
                                   
        <?php endwhile; ?>
        <nav class="post-links clearfix">
            <?php 
                posts_nav_link('&nbsp;|&nbsp;','&lt; Previous','Next &gt;');                               
            ?> 
        </nav>            
        <?php else : ?>
    
            <h2 class="center">Not Found</h2>
            <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    
        <?php endif; ?>
    </div>
<?php get_footer(); ?>
