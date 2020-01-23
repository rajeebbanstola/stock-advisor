<?php
/**
 * Enqueue parent and child theme css
 */
function fool_enqueue_scripts() { 
    $parent_style = 'twentytwenty-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'fool_enqueue_scripts' );

/**
 * Post meta for Stock News Post Type
 */
function fool_get_stock_news_meta(){
    ob_start();
    ?>
    <div class="post-meta-wrapper post-meta-single post-meta-single-top">
        <ul class="post-meta">
            <li class="post-author meta-wrapper">
                <span class="meta-icon">
                    <span class="screen-reader-text"><?php _e( 'Post author', 'fool' ); ?></span>
                    <?php twentytwenty_the_theme_svg( 'user' ); ?>
                </span>
                <span class="meta-text">
                    <?php
                    printf(
                        /* translators: %s: Author name */
                        __( 'By %s', 'fool' ),
                        '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'first_name' ) ) . ' ' . esc_html( get_the_author_meta( 'last_name' ) ) . '</a>'
                    );
                    ?>
                </span>
            </li>
            <li class="post-date meta-wrapper">
                <span class="meta-icon">
                    <span class="screen-reader-text"><?php _e( 'Post date', 'fool' ); ?></span>
                    <?php twentytwenty_the_theme_svg( 'calendar' ); ?>
                </span>
                <span class="meta-text">
                    <a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
                </span>
            </li>
            <?php if(fool_get_stock_symbol_taxonomy()) : ?>
            <li class="post-ticker meta-wrapper">
                <span class="meta-icon">
                    <span class="screen-reader-text"><?php _e( 'Stock Symbol', 'fool' ); ?></span>
                    <?php twentytwenty_the_theme_svg( 'folder' ); ?>
                </span>
                <span class="meta-text">
                    <a href="<?php the_permalink(); ?>"><?php echo fool_get_stock_symbol_taxonomy(); ?></a>
                </span>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php
    $meta_output = ob_get_clean();
    return $meta_output;      
}

/**
 * Print Post meta for Stock News Post Type
 */
function fool_the_stock_news_meta(){
    echo fool_get_stock_news_meta();
}

/**
 * Get the taxonomy for Stock Symbol 
 */
function fool_get_stock_symbol_taxonomy(){
    $terms = get_the_terms(get_the_ID(), 'stockadvisor_ticker');
    if(!is_array( $terms )) return false;
    $term = array_pop($terms);
    return $term->name;
}

/**
 * Get the stock symbol from taxonomy
 */
function fool_get_stock_symbol_from_taxonomy( $stock_ticker ){
    return explode(':', $stock_ticker)[1];
}

/** 
 * Print the company profile
 * Stock Recommendation Post Type
 */
function fool_the_company_profile( $stock_ticker ){
    echo fool_get_company_profile( $stock_ticker );
}

/**
 * Prepare HTML from company profile data
 * Stock Recommendation Post Type
 * 
 * @param company_stock_ticker
 */
function fool_get_company_profile( $stock_ticker ){
    $company_profile = fool_request_company_profile( $stock_ticker );
    ob_start();
    ?>
        <ul>
            <li>
                <span>Company Logo</span>
                <span><img src="<?php echo esc_attr( $company_profile->image ); ?>" /><span>
            </li>
            <li>
                <span>Company Name</span>
                <span><?php echo esc_html( $company_profile->companyName ); ?><span>
            </li>
            <li>
                <span>Exchange</span>
                <span><?php echo esc_html( $company_profile->exchange ); ?><span>
            </li>
            <li>
                <span>Description</span>
                <span><?php echo esc_html( $company_profile->description ); ?><span>
            </li>
            <li>
                <span>Industry</span>
                <span><?php echo esc_html( $company_profile->industry ); ?><span>
            </li>
            <li>
                <span>Sector</span>
                <span><?php echo esc_html( $company_profile->sector ); ?><span>
            </li>
            <li>
                <span>CEO</span>
                <span><?php echo esc_html( $company_profile->ceo ); ?><span>
            </li>
            <li>
                <span>Website</span>
                <span><a href="<?php echo esc_attr( $company_profile->website ); ?>"><?php echo esc_attr( $company_profile->website ); ?></a></span>
            </li>
        </ul>
    <?php
    $html_output = ob_get_clean();
    return $html_output;
}

/** 
 * Call external API for Company Profile
 */
function fool_request_company_profile( $stock_ticker ){
    $company_profile_json = get_transient( 'company_profile_'.$stock_ticker );
    if( !empty( $company_profile_json ) ) {
        return $company_profile_json;
    }

    $response = wp_remote_get( 'https://financialmodelingprep.com/api/v3/company/profile/'.$stock_ticker);

    if ( is_array( $response ) && ! is_wp_error( $response ) ) {
        $headers = $response['headers'];
        $body    = $response['body'];
    }

    $company_profile = json_decode($body);

    set_transient( 'company_profile_'.$stock_ticker, $company_profile->profile, DAY_IN_SECONDS );

    return $company_profile->profile;
}

/** 
 * Print the company profile
 * Company Page
 */
function fool_the_company_page_profile( $stock_ticker ){
    echo fool_get_company_page_profile( $stock_ticker );
}

/**
 * Prepare HTML from company profile data
 * Company Page
 * 
 * @param company_stock_ticker
 */
function fool_get_company_page_profile( $stock_ticker ){
    $company_profile = fool_request_company_profile( $stock_ticker );
    ob_start();
    ?>
        <ul>
            <li>
                <span>Price</span>
                <span><?php echo esc_html( $company_profile->price ); ?><span>
            </li>
            <li>
                <span>Price Change</span>
                <span><?php echo esc_html( $company_profile->changes ); ?><span>
            </li>
            <li>
                <span>Price change in percentage</span>
                <span><?php echo esc_html( $company_profile->changesPercentage ); ?><span>
            </li>
            <li>
                <span>52 week range</span>
                <span><?php echo esc_html( $company_profile->range ); ?><span>
            </li>
            <li>
                <span>Beta</span>
                <span><?php echo esc_html( $company_profile->beta ); ?><span>
            </li>
            <li>
                <span>Volume Average</span>
                <span><?php echo esc_html( $company_profile->volAvg ); ?><span>
            </li>
            <li>
                <span>Market Capitalisation</span>
                <span><?php echo esc_html( $company_profile->mktCap ); ?><span>
            </li>
            <li>
                <span>Last Dividend</span>
                <span><?php echo ($company_profile->lastDiv) ? $company_profile->lastDiv : 'N/A' ?></span>
            </li>
        </ul>
    <?php
    $html_output = ob_get_clean();
    return $html_output;
}

/**
 * Modify query for Stock Recommendation Archive
 */

function fool_stock_recommendation_archive_query($query) {
    if (is_post_type_archive('stock_recommendation')) {
        $query->set( 'posts_per_page', 10 );
        $query->set( 'orderby', 'date' );
        $query->set( 'order', 'DESC' );
        return;
    }     
}
add_action('pre_get_posts', 'fool_stock_recommendation_archive_query');


/** 
 * Print company recommendations if they exist
 */
function fool_the_company_recommendations_html( $ticker_taxonomy ){
    echo fool_get_company_recommendations_html( $ticker_taxonomy );
}

/**
 * Prepare company recommendations HTML
 * 
 * @param ticker_taxonomy
 */
function fool_get_company_recommendations_html( $ticker_taxonomy ){

    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'stockadvisor_ticker',
                'field' => 'name',
                'terms' => $ticker_taxonomy,
            ),
        ),
        'post_type' => 'stock_recommendation'
    );
    $recommendation_query = new WP_Query($args);
    ob_start();
    if( $recommendation_query->have_posts() ) {
    ?>
    <h3>Recommendations</h3>
    <ul>
    <?php
    while ($recommendation_query->have_posts()) : $recommendation_query->the_post(); ?>
        <li>
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
        </li>
    <?php endwhile; ?>
    </ul>
    <?php }
    wp_reset_query();

    $html_output = ob_get_clean();
    return $html_output;
}

/** 
 * Print news on company profile page
 */
function fool_the_company_news_html( $ticker_taxonomy ){
    echo fool_get_company_news_html( $ticker_taxonomy );
}

/**
 * Prepare company news HTML
 * 
 * @param ticker_taxonomy
 */
function fool_get_company_news_html( $ticker_taxonomy ){
    $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'stockadvisor_ticker',
                'field' => 'name',
                'terms' => $ticker_taxonomy,
            ),
        ),
        'post_type' => 'stock_news',
        'posts_per_page' => 10,
        'paged' => $paged,
    );
    $recommendation_query = new WP_Query($args);
    ob_start();
    if( $recommendation_query->have_posts() ) {
        ?>
        <h3>Other Coverage</h3>
        <ul>
        <?php
        while ($recommendation_query->have_posts()) : $recommendation_query->the_post(); ?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </li>
        <?php endwhile; ?>
        </ul>
        <?php 
        $big = 999999999;
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $recommendation_query->max_num_pages
        ) );
    }
    wp_reset_postdata();

    $html_output = ob_get_clean();
    return $html_output;
}

/**
 * Disable redirect in company single page
 * https://developer.wordpress.org/reference/functions/redirect_canonical/
 */
function fool_disable_canonical_redirect($redirect_url) {
    if (is_singular('company')) $redirect_url = false;
    return $redirect_url;
}
add_filter('redirect_canonical','fool_disable_canonical_redirect');


/**
 * Get company logo URL
 */
function fool_get_company_logo_url( $stock_ticker ){
    $company_profile = fool_request_company_profile( $stock_ticker );
    return $company_profile->image;
}

/**
 * Get company description
 */
function fool_get_company_description( $stock_ticker ){
    $company_profile = fool_request_company_profile( $stock_ticker );
    return $company_profile->description;
}