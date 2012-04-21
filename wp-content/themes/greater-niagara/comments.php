    <?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}
?>
<?php if (count($comments) > 0) : ?>

<!-- You can start editing here. -->
<section id="comments" class="post-extras" role="complementary">    
	<?php if ($comments) : ?>
		<header>
		    <hgroup>
		        <h3>Talk amongst yourselves&hellip;</h3>
		        <h6>Comments about <?php echo get_the_author() . "'s"; ?> post, <em><?php the_title(); ?></em></h6>
		    </hgroup>
	    </header>
		<ol class="comment-list">
		<?php 
           $count = 0;
	   	   foreach ($comments as $comment) : 
               $class = ' class="alt"';    
  	   	       if($count %2 == 0){
                   $class = '';
               }
   	   ?>
		
			<li<?php echo $class; ?> id="comment-<?php comment_ID() ?>">
                <article class="clearfix">
                    <details>
                        <p><time datetime="<?php the_time('j F Y') ?>" pubdate="pubdate"><?php the_time('j F Y') ?></time></p>
                    </details>
                    <?php echo get_avatar(get_comment_author_email(), 46); ?>
                    <section>                               
                        <span class="author-link"><?php comment_author_link(); ?></span>
                        <?php 
                             if($comment->comment_approved == '0'):
                        ?>
                            <br><em>Your comment is awaiting moderation.</em><br>
                        <?php endif; ?>                 
                        <?php echo get_comment_text(); ?>
                    </section>                  
                </article>				
			</li>
		<?php 
            $count++;
		    endforeach; /* end for each comment */ 
	    ?>
	
		</ol>
	
	 <?php else : // this is displayed if there are no comments so far ?>
	
		<?php if ('open' == $post->comment_status) : ?>
            <header>
                <hgroup>
                    <h3>Talk amongst yourselves&hellip;</h3>
                    <h6>Be the first to comment on this post.</h6>
                </hgroup>
            </header>
	
		 <?php else : // comments are closed ?>
            <header>
                <hgroup>
                    <h3>Talk amongst yourselves&hellip;</h3>
                    <h6>Comments are closed.</h6>
                </hgroup>
            </header>
		<?php endif; ?>
	<?php endif; ?>
	
</section>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<div class="form">
	
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
    	
    	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    	
    	<?php if ( $user_ID ) : ?>
        	
        	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
        	
        	<?php else : ?>
        	<h5>Add a comment</h5>
        	<div>
        		<input type="text" name="author" class="required" id="author" value="Name" size="22" tabindex="1" onfocus="this.value=''" />
                <br>        		
        		<input type="text" name="email" id="email" class="required email" value="Email Address" size="22" tabindex="2" />
                <br>        
        		<input type="text" name="url" class="openid_link" id="url" value="Web URL (optional)" size="22" tabindex="3" />
        	</div>
	   <?php endif; ?>
    	<div>
    		<textarea name="comment" id="comment" cols="50" rows="5" tabindex="4" class="required"></textarea>
    		
    		<?php do_action('comment_form', $post->ID); ?>
    	</div>
    	<div>
    	
    	<input name="submit" type="submit" class="button" id="submit" tabindex="5" value="Comment" />
    	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
    	</div>
    	
    	</form>
       <?php endif; ?>
</div>	

<?php endif; // if you delete this the sky will fall on your head ?>
