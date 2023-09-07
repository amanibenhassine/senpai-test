<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @since      1.0.0
 * @package    Senpai_Wp_Test
 * @author     Amine Safsafi <amine.safsafi@senpai.codes>
 */

get_header();

if ( have_posts() ) {
	// Load posts loop.
	while ( have_posts() ) {
		the_post();
		the_content();
	}
}else {
	echo "<h1 style='text-align:center;margin-top:150px;'>Silence is golden...</h1>";
}

get_footer();

