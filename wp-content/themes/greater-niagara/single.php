<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" class="content">
            <header>
                <h1>
                    <a href="<?php the_permalink() ?>" rel="permalink" title="Permanent Link to <?php the_title(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h1>
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

	<?php endwhile; else: ?>
        <article>
		    <p>Sorry, no posts matched your criteria.</p>
        </article>
	<?php endif; ?>
<?php get_footer(); ?>
