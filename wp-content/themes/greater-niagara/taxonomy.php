<?php
/**
 * Taxonomy page. Does double duty. For top level categories 
 * it displays cool grid. For lower level categories it goes back to list view.
 * 
 * @package WordPress
 * @subpackage IsoBlog
*/
?>
<?php get_header(); ?>
<section id="category-archive" class="toggle-posts clearfix">
    <?php
    	$i = 0;
    	while (have_posts()) : the_post();
    		if ($i == 6 || $i == 7 ) :
    			$dimensions = "largerThumb";
    			$truncate = 150;
    		else :
    			$dimensions = "smallerThumb";
    			$truncate = 75;
    		endif; 
    	?>
    
          <article class="<?php echo "entry hero main-category category-".$i;?>" id="post-<?php the_ID(); ?>">
            <header>
              <h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>">
                <?php the_title(); ?>
                </a></h1>
            </header>
            <div class="rollover"> 
                <a href="<?php the_permalink() ?>">
                    <?php 
                        // No default post thumbs here...
                        the_post_thumbnail($dimensions); 
                    ?>
                </a>
                <blockquote>
                    <p>
                        <?php echo isoblog_truncate(get_the_excerpt(),$truncate); ?>
                    </p>
                </blockquote>
            </div>
          </article>
    <?php $i++ ?>
    <?php endwhile; ?>
    
    <div class="list">
        <ol>   
            <?php
                global $post;
                $myposts = get_posts('numberposts=20&top-categories='. strip_tags(isoblog_get_term()) .'');
                $i = 0;
                foreach($myposts as $post) :
                    setup_postdata($post);
                    $class = 'class="full odd"';
                    if($i % 2 == 0){
                        $class = 'class="full even"';
                    }
                ?>
                <li <?php echo $class; ?>>
                    <article class="clearfix">
                        <section class="thumb">
                            <a href="<?php the_permalink(); ?>"><?php isoblog_the_post_thumbnail($post->ID, array( 150,150 )); ?></a>
                        </section>
                        <section class="body">                            
                            <h2>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <?php the_excerpt(); ?>
                            <details open="true">
                                <p>&mdash;  <?php the_author_posts_link(); ?></p>
                                <p><time datetime="<?php the_time('c') ?>" pubdate="pubdate"><?php the_time('F jS, Y') ?></time></p>
                            </details>                            
                        </section>
                    </article>
                    
                </li>
            <?php $i++; endforeach; ?>
        </ol> 
    </div>               
</section>  

<div class="clearfix"> <!-- .toggle-opts floats right... -->
    <div class="toggle-opts">
      <h5>View as</h5>
      <ul>
        <li class="on"> <a href="#hero" class="hero-view">Hero view</a> </li>
        <li> <a href="#list" class="list-view">List view</a> </li>
      </ul>
    </div> 
</div>

<?php 
	
	isoblog_write_blog_listings(isoblog_get_term());
 ?>
  <nav class="navigation">
    <ul>
      <li class="alignleft">
        <?php next_posts_link('&lt; Previous Entries') ?>
      </li>
      <li class="alignright">
        <?php previous_posts_link('Next Entries &gt;') ?>
      </li>
    </ul>
  </nav>

<?php get_footer(); ?>
