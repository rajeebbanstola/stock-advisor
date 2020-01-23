<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */
?>

<header class="entry-header has-text-align-center post-meta-single post-meta-single-bottom">

	<div class="entry-header-inner section-inner medium">

		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
		}

		// Display stock news post meta 
		fool_the_stock_news_meta();
		?>

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->
