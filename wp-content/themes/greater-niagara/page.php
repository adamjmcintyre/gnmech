<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" class="single-post clearfix static-page">
            <section>
                <header>
                    <h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
                </header>
                
                <section class="right-column">
                    <section class="body" role="main">
                        <details open="open" class="clearfix">
                            <p><time datetime="<?php the_time('j F Y') ?>" pubdate="pubdate"><?php the_time('j F Y') ?></time></p>
                        </details>
                                        
                        <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

                        <?php if (function_exists('sociable_html')): 
                            $sh = sociable_html();
                            if(strlen($sh) > 0):    
                        ?>                                                    
                            <div class="fb-like">
                                <iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
                            </div>

                            <div class="meta clearfix">   
                                <?php echo sociable_html(); ?> 
                            </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="fb-like">
                                <iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
                            </div>                        
                        <?php endif; ?>
                        
                        <?php if($user_ID): ?>
                            <div class="meta clearfix">                                 
                                <?php edit_post_link('Edit'); ?>                                                                                                        
                            </div>
                        <? endif; ?>                                    
                        
                    </section>                                                        
                </section>
            </section>                               
        </article>

    <?php endwhile; else: ?>
        <div>
            <p>Sorry, no posts matched your criteria.</p>
        </div>
    <?php endif; ?>
<?php get_footer(); ?>
