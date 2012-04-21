        <?php get_sidebar(); ?>
		
		<?php wp_footer(); ?>
	</section><!-- END section#content -->
    
    <footer id="site-footer">
        <div class="vcard">
            <p class="adr">
                <span class="fn">Greater Niagara Mechanical, Inc.</span>
                <span class="street-address">7311 Ward Rd # A</span>
                <span class="locality">North Tonawanda</span>
                <span class="region">New York</span>
                <span class="postal-code">14120</span>
                <span class="tel">(716) 695-3600</span>
            </p>
        </div>   

        <span class="copyright">&copy; <?php echo date('Y'); ?></span>                 
    </footer>

</div><!-- END div#container -->
  
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<!--don't serve analytics to logged-in users -->
<?php if ( $user_ID ) : ?>
<?php else : ?>
<script type="text/javascript">
  // var _gaq = _gaq || [];
  // _gaq.push(['_setAccount', 'UA-1745698-2']);
  // _gaq.push(['_trackPageview']);

  // (function() {
  //   var ga = document.createElement('script');
  //   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 
  //       'http://www') + '.google-analytics.com/ga.js';
  //   ga.setAttribute('async', 'true');
  //   document.documentElement.firstChild.appendChild(ga);
  })();

</script>
<?php endif; ?>

</body>
</html>
