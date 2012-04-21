<nav id="sidebar">
    <header class="hidden">
        <h4>Blog navigation</h4>
    </header>

    <?php if(function_exists('dynamic_sidebar')): ?>
        <?php 
            if(is_author()){
                dynamic_sidebar('Author');                
            }
            else if(is_home()){
                dynamic_sidebar('Home');
            }
            else{
                dynamic_sidebar('Default');    
            }
        ?>                    
    <?php else: ?>
        <?php
            // Build our author list. Gives us a bit more control over 
            // the markup than we have with the WordPress built-in.
            $authors = wp_list_authors('echo=0');
            $all_authors = explode('<li>',str_replace('</li>','',$authors));
            $author_list = array();
            
            for($i = 0; $i < count($all_authors); $i++){
                preg_match('/<a.*href=[\'"].*\?author=([^\'"]*)[\'"].*>(.*)<\/a>/',$all_authors[$i],$matches);
                // Map author name to author ID
                if(strlen($matches[2]) > 0){
                    $author_list[$matches[2]] = $matches[1];            
                }
            }
            
            // ...and do the same for our archive list.
            $archives = wp_get_archives('echo=0&type=monthly&format=html');
        
            $all_archives = explode('<li>',str_replace('</li>','',$archives));
            $archive_list = array();
            
            for($i = 0; $i < count($all_archives); $i++){
                preg_match('/<a.*href=[\'"].*\?m=([^"\']*)[\'"].*>(.*)<\/a>/',$all_archives[$i],$matches);
        
                // Map arhive name to author ID
                if(strlen($matches[2]) > 0){
                    $archive_list[$matches[2]] = $matches[1];            
                }
            }    
        ?>

            <section class="search">
                <header>
                    <h4>Search</h4>                    
                </header>
                <?php include (TEMPLATEPATH . '/searchform.php'); ?>
            </section>          
                     
            <section>
                <header>
                    <h4>Authors</h4>
                </header>
                <ul class="authors clearfix">
                    <?php
                        // Shuffle up our array elements 
                        $shuffled = array_keys($author_list);
                        
                        // We only display 14 authors + 1 link to more thus $i < 14
                        for($i = 0; $i < 14; $i++){
                            $class = "";
                            if(($i + 1) % 5 == 0){
                                $class = ' class="last"';
                            }
                            
                            echo '<li' . $class . '><a href="' . get_bloginfo('url') . '?author=' . $author_list[$shuffled[$i]] . '"><img src="' . get_bloginfo('stylesheet_directory') . '/img/fpo_author-pic.png" alt="' . $shuffled[$i] . '"><span class="hidden">' . $shuffled[$i] . '</span></a></li>';
                        }
                    ?>
                                                         
                    <li class="more last">
                        <a href="<?php echo get_bloginfo('template_url') . '/authors.php'; ?>" class="view-all">View all authors</a>
                    </li>                        
                </ul>
            </section>  
                    
            <section>
                <header>
                    <h4>Browse</h4>
                </header>
                <form id="category-form" action="" method="GET">
                   <div>
                       <select id="cat" name="cat">
                            <option value="">categories</option>
                           <option value="creative" data-url="/top-categories/creative/">Creative</option>
                           <option value="strategy" data-url="/top-categories/strategy/">Strategy</option>
                           <option value="technology" data-url="/top-categories/technology/">Technology</option>
                           <?php 
                               $cats = get_categories('hierarchical=1&exclude=567,160');
                    
                               foreach($cats as $c){
                                   echo '<option value="' . $c->term_id . '" data-url="' . get_category_link($c->term_id) . '">' . $c->name . '</option>';
                               }
                           ?>
                       </select>
                       <input type="submit" value="Go">
                   </div>
                </form>
                <form id="author-form" action="" method="GET">
                    <div>
                        <select id="author" name="author" data-url="<?php echo (get_bloginfo('url') . '/?author='); ?>">    
                            <option value=''>authors</option>
                            <?php
                                foreach(array_keys($author_list) as $key){
                                    echo '<option value="' . $author_list[$key] . '">' . $key . '</option>';
                                }
                            ?>
                        </select>
                        <input type="submit" value="Go">
                    </div>        
                </form>
                <form id="archive-form" action="" method="GET">
                    <select id="m" name="m" data-url="<?php echo (get_bloginfo('url') . '/?m='); ?>">
                        <option value="">archives by month</option>
                        <?php
                            foreach(array_keys($archive_list) as $key){
                                echo '<option value="' . $archive_list[$key] . '">' . $key . '</option>';
                            }
                        ?>
                    </select>   
                    <input type="submit" value="Go">     
                </form>
            </section>
            
            <section>
                <header>
                    <h4>Latest Posts</h4>
                </header>
                <ol class="post-list">
                    <?php 
                        $lastPosts = get_posts('numberposts=5&exclude=' . get_featured_post_ids());
                        foreach($lastPosts as $p):
                            setup_postdata($p);   
                    ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?> 
                                <span class="author">&mdash; <span class="highlight"><?php the_author(); ?></span></span>
                            </a>
                        </li>            
                    <?php endforeach; ?>                       
                </ol>    
            </section>    
    <?php endif; ?>
</nav>