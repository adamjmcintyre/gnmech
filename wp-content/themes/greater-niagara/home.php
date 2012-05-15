<?php
/**
 * The home page.
 *
 * @package WordPress
 * @subpackage IsoBlog
 */
/*
 * Template Name: Home
 */
?>
<?php get_header(); ?>

<section class="hero-callouts">
    <header class="company-description">
        <h1>
            <strong>Greater Niagara Mechanical, Inc.</strong> Lorem ipsum dolor sit amet, consectetur adipiscing. 
        </h1>
        <p>
            Vivamus enim nulla, tempor sed fermentum id, venenatis ac metus. In eu tortor et ligula placerat semper ut sed orci. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        </p>
    </header>
    
    <section class="company-highlights">
        <h1>
            Greater Niagara Mechanical, Inc., is a Western New York-based mechanical solutions company that specializes in installing and maintaining heating, ventaliation, and 
            air conditioning systems, HVAC control systems [anything else that you feel like belongs here; maybe a sentence or two more.]
        </h1>
        <ul class="callouts clearfix">
        	<li>                
                <article>
                    <a href="/commercial">
                        <img src="<?php bloginfo('template_directory'); ?>/img/commercial.jpg" alt="Commercial HVAC projects in Western New York">
                    </a>
                    <header>
                        <h1>                                        
                           <a href="/commercial-projects">
                               Commercial
                           </a>
                        </h1>
                    </header>
                    <summary>
                        Description of the types of commercial projects that you work on. Etc. etc.
                    </summary>
                    <footer>
                        <a href="/commercial-projects">Read more &gt;</a>
                    </footer>
                </article>
        	</li>
        	<li>
                <article>
                    <a href="/construction">
                        <img src="<?php bloginfo('template_directory'); ?>/img/construction.jpg" alt="Construction HVAC projects in Buffalo, NY">
                    </a>
                    <header>
                        <h1>                                        
                           <a href="/construction-projects">Construction</a>
                        </h1>
                    </header>
                    <summary>
                        Description of the types of Construction projects that you work on.
                    </summary>
                    <footer>
                        <a href="/construction-projects">Read more &gt;</a>
                    </footer>                                    
                </article>
        	</li>
        	<li>
                <article>
                    <a href="/past-projects">
                        <img src="<?php bloginfo('template_directory'); ?>/img/past-projects.jpg" alt="Past Buffalo, NY HVAC projects completed by Greater Niagara Mechanical">
                    </a>
                    <header>
                        <h1>                                        
                           <a href="/project-studies">Past Projects</a>
                        </h1>
                    </header>
                    <summary>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus enim nulla, tempor sed fermentum id, venenatis ac metus. In eu tortor et ligula placerat semper ut sed orci. 
                    </summary>
                    <footer>
                        <a href="/project-studies">View all &gt;</a>
                    </footer>                                    
                </article>
        	</li>
        </ul>
    </section>
</section>

<section class="news clearfix">
    <?php write_hp_news(); ?>                        
        
    <nav class="post-links clearfix">
        <a href="<?php echo get_bloginfo('url') . '/news/'; ?>" >View all news</a>
    </nav>    
</section>


<?php get_footer(); ?>