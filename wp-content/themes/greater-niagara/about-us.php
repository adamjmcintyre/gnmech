<?php
/**
 * Template Name: About Us
 *
 * @package WordPress
 * @subpackage IsoBlog
 */
?>
<?php get_header(); ?>
        <div id="about-us"> 
            <section id="principals">
                <?php write_about_us(); ?>
            </section>
            
            <section id="address">
                <header>
                    <h1>Where to find us</h1>    
                </header>

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
        </div>
<?php get_footer(); ?>