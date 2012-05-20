<?php
/**
 * Commercial Category Archive
 *
 * @package WordPress
 * @subpackage Greater Niagara Mechanical
 *
 * Template Name: Commercial Projects Listing
 */
?>

<?php get_header(); ?>

<h1>
	Blurb about commercial projects (types of projects they generally are, assorted facts like 
	average duration or other things that are important, etc.). We'll also make sure to call out that these are Buffalo / Western New York-area 
	projects to add a little SEO juice.
</h1>

<?php write_project_category("commercial"); ?>
    
<?php get_footer(); ?>
