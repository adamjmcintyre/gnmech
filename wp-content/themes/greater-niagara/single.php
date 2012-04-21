<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" class="single-post clearfix">
            <section>
                <header>
                    <h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
                </header>
                <section class="author">
                    <header class="hidden">
                        <h4>Author</h4>
                    </header>                
                    <div class="author vcard">
                        <div class="fn">
                            <h6>
                                <a href="<?php echo get_bloginfo('url') . '/author/' . get_the_author_meta('user_login'); ?>"
                                    class="url" rel="author">
                                    <?php the_author(); ?>
                                </a>
                            </h6>
                            <p class="title">
                                <?php echo the_author_meta('title'); ?>
                            </p>
                            <?php echo get_avatar(get_the_author_id(), 115); ?>  
                            <p class="bio">
                                <?php echo the_author_meta('blurb'); ?>
                            </p>                          
                        </div>
                    </div>  
                    
                    <?php if (function_exists('sociable_html')) {
                        echo sociable_html();
                    } ?>
                </section>   
        
        	    <section class="right-column">
        		    <section class="body" role="main">
                        <details open="open" class="clearfix">
                            <p><time datetime="<?php the_time('j F Y') ?>" pubdate="pubdate"><?php the_time('j F Y') ?></time></p>
                        </details>
                                		
            			<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
                        
                        <div class="fb-like">
                            <iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
                        </div>
                        
                        <div class="meta clearfix">     
                            <?php if($user_ID): ?>
                                <?php edit_post_link('Edit'); ?>                  
                            <? endif; ?>                                             

                            <nav id="post-links" class="clearfix">
                                <?php 
                                    previous_post_link_plus('post_date', 'loop', 'no thumb', '%link', '&lt; Previous', 0, TRUE);
                                    echo '<span class="separator">|</span>';
                                    next_post_link_plus('post_date', 'loop', 'no thumb', '%link', 'Next Post &gt;', 0, TRUE);                                
                                ?> 
                            </nav>                                    
                        </div>                
                        
                    </section>
        
                    <?php related_posts(); ?>                                
               
                    <?php comments_template(); ?>                                
                </section>
            </section>                               
        </article>

	<?php endwhile; else: ?>
        <div>
		    <p>Sorry, no posts matched your criteria.</p>
        </div>
	<?php endif; ?>
<?php get_footer(); ?>
