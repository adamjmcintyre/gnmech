<?php get_header(); ?>

<?php 
    global $wp_query;
    $curauth = $wp_query->get_queried_object();  
?>

    <?php 
        // If a user is missing their bio gravatar image or biography, we show a list of posts instead.
        if((! isset($_GET['view']) || (isset($_GET['view']) && $_GET['view'] != 'list'))
            && (validate_gravatar($curauth->user_email) && $curauth->user_description)):
    ?>
        <div id="author" class="clearfix">
            <section class="info">
                <?php echo get_avatar($curauth->ID, 395); ?>
                <header class="clearfix">
                    <h3>Follow <?php echo $curauth->first_name; ?></h3>
                    <ul class="social-icons">
                        <li><a href="<?php echo get_author_feed_link($curauth->ID); ?>" class="comments">Blog posts</a> </li>
                        <?php 
                            $facebook = $curauth->facebook;
                            if(isset($facebook) && strlen($facebook) > 0):         
                        ?>                
                            <li><a href="<?php echo 'http://www.facebook.com/' . $facebook; ?>" class="facebook external">Facebook</a> </li>
                        <?php endif; ?>
                        <?php 
                            $flickr = $curauth->flickr;
                            if(isset($flickr) && strlen($flickr) > 0):         
                        ?>                
                            <li><a href="<?php echo 'http://www.flickr.com/photos/' . $flickr . '/'; ?>" class="flickr external">Flickr streams</a> </li>
                        <?php endif; ?>
                        <?php 
                            $linkedin = $curauth->linkedin;
                            if(isset($linkedin) && strlen($linkedin) > 0):         
                        ?>                
                            <li><a href="<?php echo 'http://www.linkedin.com/in/' . $linkedin . '/'; ?>" class="linked-in external">LinkedIn profile</a> </li>
                        <?php endif; ?>
                        <?php 
                            $twitter = $curauth->twitter;
                            if(isset($twitter) && strlen($twitter) > 0): 
                        ?>                
                            <li><a href="<?php echo 'http://twitter.com/' . $twitter; ?>" class="twitter">Tweets</a> </li>
                        <?php endif; ?>                
                    </ul>
                </header>
                <div id="twitter"></div>        
            </section>
            <section class="bio">
                <?php 
                    $args = array(
                        'author' => $curauth->ID
                    );
                    $query = new WP_query($args); 
                    $post_thumbs = array();
    
                    if($query->posts){
                        $posts = $query->posts;
                        for($i = 0; $i < count($posts); $i++){
                           $post = $posts[$i];
                            if(has_post_thumbnail($post->ID)){
                                // We do not want a default thumbnail here, so we rely on WP's built-in thumb function.
                                array_push($post_thumbs,get_the_post_thumbnail($post->ID, array(115,115)));
                            } 
                            if(count($post_thumbs) == 3){
                                break;
                            }   
                        }
                    }
                ?>
                
                <article>
                
                <?php   
                    if(count($post_thumbs) > 0):
                ?>
                    <section class="blurb has-thumbs">   
                <?php else: ?>                        
                    <section class="blurb">
                <?php endif; ?>
                        <div>
                            <hgroup>
                                <h1><?php echo $curauth->nickname; ?></h1>
                                <h2><?php echo $curauth->title; ?></h2>
                                <h6><?php echo $curauth->office; ?></h6>                 
                            </hgroup>
                            <div class="post-thumbs">
                                <?php 
                                    $end = min(count($post_thumbs), 2); 
                                    for($i = 0; $i < $end; $i++){
                                        echo $post_thumbs[$i];
                                    } 
                                ?>
                            </div> 
                            <?php if($curauth->blurb): ?>           
                                <aside>
                                    <h3><?php echo $curauth->blurb; ?></h3>
                                </aside>
                            <?php endif; ?>
                        </div>                
                    </section>
                    <section>
                        <details open="open">
                            <?php 
                                if(count($post_thumbs) == 3){
                                    echo $post_thumbs[2];
                                }
                            ?>
                            <p>
                                <?php echo $curauth->user_description; ?>
                            </p>                              
                        </details>                                  
                    </section>                    
                </article>
            </section>
        </div>
    <?php else: ?>
        <div id="author" class="no-bio clearfix">
            <h1>All posts by <?php echo $curauth->nickname; ?></h1>               
                <?php 
                    $lastPosts = get_posts('author=' . $curauth->ID);
                    foreach($lastPosts as $post):
                        setup_postdata($post);
                ?>
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
                <?php endforeach; ?>                       
            </ol> 
        </div>       
    <?php endif; ?>   
<?php get_footer(); ?>
