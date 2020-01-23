<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */


$ticker_taxonomy = fool_get_stock_symbol_taxonomy();
$stock_symbol = fool_get_stock_symbol_from_taxonomy( $ticker_taxonomy );
?>

<header class="entry-header has-text-align-center post-meta-single post-meta-single-bottom">

	<div class="entry-header-inner section-inner medium">

		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
		}
		?>
		<div class="company-logo">
			<img src="<?php echo esc_attr( fool_get_company_logo_url( $stock_symbol ) ); ?>" />
		</div>

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->
