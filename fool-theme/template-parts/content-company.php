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

$ticker_taxonomy = fool_get_stock_symbol_taxonomy();
$stock_symbol = fool_get_stock_symbol_from_taxonomy( $ticker_taxonomy );
?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php get_template_part( 'template-parts/entry-header-company' ); ?>

	<div class="post-inner thin">

		<div class="entry-content">
			<?php echo fool_get_company_description( $stock_symbol ); ?>
		</div><!-- .entry-content -->

		<div class="company-profile">
			<?php fool_the_company_page_profile( $stock_symbol ); ?>
		</div>
		<?php if( get_query_var( 'paged' ) <= 1): ?>
		<div class="company-recommendations">
			<?php fool_the_company_recommendations_html( $ticker_taxonomy ); ?>
		</div>
		<?php endif; ?>

		<div class="company-news">
			<?php fool_the_company_news_html( $ticker_taxonomy ); ?>
		</div>

	</div><!-- .post-inner -->

	<div class="section-inner">
		<?php edit_post_link(); ?>
	</div><!-- .section-inner -->

</article><!-- .post -->
