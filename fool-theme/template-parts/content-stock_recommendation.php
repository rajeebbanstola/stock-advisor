<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php get_template_part( 'template-parts/entry-header-stock' ); ?>

	<div class="post-inner thin">

		<div class="entry-content">

			<?php the_content(); ?>

		</div><!-- .entry-content -->

		<div class="company-profile">
			<?php
			$ticker_taxonomy = fool_get_stock_symbol_taxonomy();
			$stock_symbol = fool_get_stock_symbol_from_taxonomy( $ticker_taxonomy );
			fool_the_company_profile( $stock_symbol );
			?>
		</div>

	</div><!-- .post-inner -->

	<div class="section-inner">
		<?php edit_post_link(); ?>
	</div><!-- .section-inner -->

</article><!-- .post -->
