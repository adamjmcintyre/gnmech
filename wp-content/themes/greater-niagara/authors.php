<?php
/**
 * Template Name: Author Listing
 *
 * @package WordPress
 * @subpackage IsoBlog
 */
?>
<?php get_header(); ?>

<?php

// custom sorting
function cmp($a, $b) {
	return strcasecmp($a->display_name, $b->display_name);
}

// get users & sort in alphabetical order
$blogusers = get_users_of_blog();
usort($blogusers, "cmp");

if ($blogusers) {
	$open = false;  // keep track of rows
	$i = 0;
	$valid_users = array();  // valid users = users with posts
	foreach ($blogusers as $bloguser) {
		if (get_usernumposts($bloguser->user_id) > 0) {
			array_push($valid_users, $bloguser->user_id);
		}
	}

	foreach ($valid_users as $bloguser) {
		$curauth = get_userdata($bloguser);
		if (!$open && ($i == 0 || $i % 5 == 0)) {
			$open = true;
			echo '<div class="author-row clearfix">', "\n";
		}
		// only active users
		if (strcasecmp($curauth->agree, "no") == 0) {
			continue;
		}
?>
		<div class="author" id="author-<?php echo $curauth->ID ?>">
	    <a href="<?php echo isoblog_get_author_posts_link($curauth); ?>"><?php echo get_avatar($curauth->user_email, $size = '140'); ?></a>
	    <h2><a href="<?php echo isoblog_get_author_posts_link($curauth); ?>"><?php echo $curauth->display_name; ?></a></h2>
	
	    <?php if ($curauth->title): ?>
	        <p class="job-title"><?php echo $curauth->title; ?></p>
	    <?php else: ?>
	        <p class="job-title">&nbsp;</p>
	    <?php endif; ?>
	    <?php
		$args = array(
			'author' => $curauth->ID,
			'posts_per_page' => 1
		);

		$userposts = new WP_Query($args);
		if ($userposts->posts && count($userposts->posts) > 0):
?>
			<ol class="post-list">
<?php
			foreach ($userposts->posts as $post):
				setup_postdata($post);
?>
				<li class="author-recent">
                    <a href="<?php echo get_permalink($post->ID); ?>">
                        <?php echo get_the_title($post->ID); ?>
                    </a>
                </li>
			<?php endforeach; ?>
            </ol>
		<?php endif; ?>
        </div>
        <?php
		if (($i + 1) % 5 == 0) {
			$open = false;
			echo '</div><!--  end author row -->', "\n";
		}
		$i++;
	}
}
// tie up loose ends
if ($open) {
	echo '</div><!--  end author row -->', "\n";
}

?>
<?php get_footer(); ?>