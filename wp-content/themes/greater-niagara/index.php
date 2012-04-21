<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage IsoBlog
 */
?>
<?php get_header(); ?>
<div id="content" class="clearfix">

<?php 
/**
 * TO DO
 *
 * REPLACE THIS WITH A MORE GENERIC INDEX
 */
?>
  <?php get_featured_posts(); ?>
  <?php if (have_posts()) : ?>
  <?php 
		    $max = 3; // Maximum featured posts we'll display
		    $i = 0;
		    $hasBigPost = false; // Do we have "big" featured post?
		    $isBigPost = false;
			while (have_posts() && $i < $max) : the_post(); 
        ?>
  <?php 
                $all_tags = get_the_tags();
                
                if($all_tags && !$hasBigPost){  // Only one big post allowed. If we don't have one yet, carry on...

                	foreach($all_tags as $tag){
                		if($tag->name == 'big-featured-post'){
                	       $isBigPost = true;
                	       $hasBigPost = true;
                	       break;		
                		}
                	}                	
                }
                else{
                	$isBigPost = false;
                }
            ?>
  <div class="homepage-post post <?php if($isBigPost) echo 'big-featured-post' ?>" id="post-<?php the_ID(); ?>">
    <?php 
			        $category = get_the_category();
			        $parent = get_cat_name($category[0]->category_parent);
			        if(!empty($parent)){
			        	echo '<h2>' . $parent . '</h2>';
			        }
			        else{
			        	echo '<h2>' . $category[0]->cat_name . '</h2>';
			        }
			    ?>
    <div class="image">
      <?php the_post_thumbnail(); ?>
    </div>
    <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h1>
    <p class="date">
      <?php the_time('F j') ?>
    </p>
    <div class="inf">
      <p><span>Posted by </span>
        <?php the_author_posts_link(); ?>
      </p>
    </div>
    <div class="entry">
      <?php the_excerpt(); ?>
    </div>
    <div class="inf inf-last">
      <p class="postmetadata"><span>posted to:</span> <span class="categories">
        <?php the_category(', ') ?>
        </span>
        <?php if($user_ID): ?>
        <?php edit_post_link('Edit', ' | ', ' '); ?>
        <? endif; ?>
        |
        <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
      </p>
    </div>
  </div>
  <?php 
			$i++;
			endwhile; 
		?>
  <div class="navigation">
    <div class="alignleft">
      <?php next_posts_link('&laquo; Previous Entries') ?>
    </div>
    <div class="alignright">
      <?php previous_posts_link('Next Entries &raquo;') ?>
    </div>
  </div>
  <?php else : ?>
  <h1 class="center">Not Found</h1>
  <p class="center">Sorry, but you are looking for something that isn't here.</p>
  <?php include (TEMPLATEPATH . "/searchform.php"); ?>
  <?php endif; ?>
  <div id="homepage_social">
    <div id="vimeo"></div>
  </div>
</div>
<?php get_footer(); ?>
