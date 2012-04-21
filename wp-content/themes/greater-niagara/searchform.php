<?php 
    if(! isset($default)){
        $default = "keyword, author, or date";
    }
?>

<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
	<div>		
		<input id="s" name="s" value="<?php echo $default ?>" data-default="<?php echo $default ?>" class="text" type="text">
		<input id="searchsubmit" type="submit" value="submit">
	</div>
</form>
