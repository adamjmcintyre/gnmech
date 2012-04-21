<?php
/**
 * Template Name: Contact Us
 *
 * @package WordPress
 * @subpackage IsoBlog
 */

?>

<?php get_header(); ?>
		<article id="post-<?php the_ID(); ?>" class="clearfix contact-us">
            <section id="addresses">
                <header>
                    <h1>Thanks for your interest.</h1>    
                </header>

                <p>
                	For inquires about how we can help you, please give us a call at <strong>(716) 695-3600</strong>. Lorem ipsum amit sit dolor. Varis et vectum.
            	</p>

                <address class="contact-information logo vcard">
                    <h1 class="fn">Greater Niagara Mechanical, Inc.</h1>
                    <p>
                        <span class="street-address">7311 Ward Rd # A</span>
                        <span class="locality">North Tonawanda</span>
                        <span class="region">New York</span>
                        <span class="postal-code">14120</span>
                    </p>                    
                    <h2 class="tel">
                        (716) 695-3600
                    </h2>                   
                </address>
            </section>
        </article>

<?php get_footer(); ?>
