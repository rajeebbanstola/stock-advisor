<?php
/**
 * Displays stock recommendation archive template
 *
 * @since 1.0.0
 */
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <header class="entry-header has-text-align-center post-meta-single post-meta-single-bottom">
        <div class="entry-header-inner section-inner medium">
            <?php the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
            <span class="color-accent"><?php echo fool_get_stock_symbol_taxonomy(); ?></span>
        </div>
    </header>
</article>