<?php /*
Three-wide related posts view
Author: Adam McIntyre
*/  
?>
<?php if ($related_query->have_posts()): ?>
    <section id="related-posts" class="related-posts post-extras clearfix" role="complementary">
        <header>
            <h3>If you enjoyed that, may we recommend:</h3>
        </header>
        
    <?php 
        $postsArray = array();
        $i = 1;
        while ($related_query->have_posts()) : $related_query->the_post();
    ?>      
        <article class="related-post <?php if($i == 3){ echo 'last'; } ?>">
            <div class="rollover">
                <a href="<?php echo get_permalink(); ?>">        
                   <?php 
                        // No default images here...
                        if(the_post_thumbnail()): 
                    ?> 
                        <?php the_post_thumbnail(array( 180,180 )); ?>     
                    <?php endif; ?>            
                </a>
               
                <blockquote>       
                    <p>           
                        <?php 
                            // Need to truncate excerpts to fit within boundaries
                            // of 150x150 images.
                            echo isoblog_truncate(get_the_excerpt(),75);                    
                        ?>
                    </p>
                </blockquote>
            </div>
            <footer>
                <details open="open">
                    <a href="<?php echo get_permalink(); ?>">                       
                        <?php echo get_the_title(); ?> 
                    
                    
                    <span class="author"> 
                        &mdash; <span class="highlight"><?php the_author(); ?></span></a>
                    </span>                                               
                </details>
            </footer>
        </article>
    <?php $i++; endwhile; ?>               
    </section>
<?php endif; ?>