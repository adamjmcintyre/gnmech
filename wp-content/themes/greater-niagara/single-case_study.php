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
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" class="content">
	            <header>
	                <h1>
	                    <a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>">
	                        <?php the_title(); ?>
	                    </a>
	                </h1>
	                <h2>
						<?php echo get_post_meta($id, 'case_study_company_name', true);?>
                	</h2>
	            </header>

	            <?php 
	                if(has_post_thumbnail()){
	                    the_post_thumbnail();
	                }
	            ?>

	            <section class="body" role="main">
	                <?php the_content(); ?>
	            </section>
	   
	        </article>

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
				echo '<div class="related-content"><h3>Related Cases:</h3><ul>';
				while( $my_query->have_posts() ) {
				$my_query->the_post();?>

				<li>
					<article>
						<a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
							<?php the_post_thumbnail(); ?>
						</a>
						
						<h1>
							<a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
								<?php the_title(); ?>
							</a>
						</h1>
					</article>
				</li>
				<?
				}
				echo '</ul></div>';
				}
				}
				$post = $orig_post;
				wp_reset_query(); 
			?>       
    <?php endwhile; else: ?>
        <div>
            <p>Sorry, no posts matched your criteria.</p>
        </div>
    <?php endif; ?>
<?php get_footer(); ?>
