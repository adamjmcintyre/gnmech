<?php
/**
 * Case study template.
 *
 * @package WordPress
 * @subpackage IsoBlog
 */
/*
 * Template Name: Case Study
 */
?>

<?php get_header(); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); 
        $id = get_the_id();
    ?>

	    <?php /*    
		Case study title: <?php echo the_title(); ?><br/>
        Company name: <?php echo get_post_meta($id, 'case_study_company_name', true);?>
        Industry: <?php echo get_post_meta($id, 'case_study_company_industry', true);?>
        Logo: <?php the_post_thumbnail(array(115,115)); ?>
        Description: <?php echo get_post_meta($id, 'case_study_company_description', true);?>
        Project Name: <?php echo get_post_meta($id, 'case_study_project_name', true);?>        
        Project Description: <?php the_content(); ?>
		*/?>
        <span class="backToListing"><a href="http://na.isobar.com/case-study-listing/">&laquo; Back to Case Studies</a></span>
		<article id="post-<?php the_ID(); ?>" class="single-post clearfix">
		
            <section id="case-study">
                <header>
                    <h1><a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
                </header>
                 <section class="author">
				 
				 <div class="company-info">
					<div class="company-name">
						<?php echo get_post_meta($id, 'case_study_company_name', true);?>
					</div>
					<div class="company-industry">
						<?php echo get_post_meta($id, 'case_study_company_industry', true);?>
					</div>
					<div class="post_thumbnail">
						<?php the_post_thumbnail(); ?>
					</div>
					<div class="company-description">
						<?php echo get_post_meta($id, 'case_study_company_description', true);?>
					</div>
				 </div>
                    <?php if (function_exists('sociable_html')) {
                        echo sociable_html();
                    } ?>
                </section>   
        
                <section class="right-column">
                    <section class="body" role="main">
                                        
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
        
                    <?php $orig_post = $post;
					global $post;
					
					$tags = wp_get_post_tags($post->ID);
					if ($tags) {
						$tag_ids = array();
						foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

						$args=array(
							'post_type' => 'case_study',
							'tag__in' => $tag_ids,
							'post__not_in' => array($post->ID),
							'showposts'=>3, // Number of related posts that will be shown.
							'caller_get_posts'=>1
						);


					$my_query = new wp_query( $args );
					if( $my_query->have_posts() ) {
					echo '<div id="related_posts_case"><h3>If you enjoyed that, may we recommend:</h3><ul>';
					while( $my_query->have_posts() ) {
					$my_query->the_post();?>

					<li>
						<div class="relatedthumb"><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a></div>
						<div class="relatedcontent">
							<p><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
						</div>
					</li>
					<?
					}
					echo '</ul></div>';
					}
					}
					$post = $orig_post;
					wp_reset_query(); ?>                              
               
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
