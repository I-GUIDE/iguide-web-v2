<?php
/**
 * Search Results Template for i-guide-search-plugin.
 *
 * This template is loaded when a search query is made.
 *
 * @package i-guide-search-plugin
 */

get_header();

/**
 * Extract a contextual snippet from the HTML content based on the search query.
 *
 * This function strips out HTML tags, finds the first occurrence of any query word,
 * and returns a snippet of a given number of words surrounding that match.
 *
 * @param string $html      The HTML content to process.
 * @param string $query     The search query.
 * @param int    $num_words The total number of words for the snippet.
 * @return string The contextual snippet.
 */
function igsp_get_contextual_snippet( $html, $query, $num_words = 30 ) {
    // Get plain text from HTML.
    $plain_text = strip_tags( $html );
    // Normalize whitespace.
    $plain_text = preg_replace( '/\s+/', ' ', $plain_text );
    $words = explode( ' ', $plain_text );
    
    // Prepare query words (lowercase).
    $query_words = array_filter( preg_split( '/\s+/', $query ) );
    $query_words = array_map( 'mb_strtolower', $query_words );
    
    // Find the index of the first word that contains one of the query words.
    $found_index = -1;
    foreach ( $words as $i => $word ) {
        $lower_word = mb_strtolower( $word );
        foreach ( $query_words as $q_word ) {
            if ( mb_strpos( $lower_word, $q_word ) !== false ) {
                $found_index = $i;
                break 2;
            }
        }
    }
    
    // If no match is found, just return the first $num_words words.
    if ( $found_index === -1 ) {
        $snippet_words = array_slice( $words, 0, $num_words );
    } else {
        // Center the snippet around the matched word.
        $half = floor( $num_words / 2 );
        $start = max( 0, $found_index - $half );
        $snippet_words = array_slice( $words, $start, $num_words );
    }
    
    $snippet = implode( ' ', $snippet_words );
    
    // Add ellipsis if the snippet doesn't include the beginning or end.
    if ( $found_index > floor( $num_words / 2 ) ) {
        $snippet = '... ' . $snippet;
    }
    if ( count( $words ) > ( $found_index + floor( $num_words / 2 ) + 1 ) ) {
        $snippet .= ' ...';
    }
    
    return $snippet;
}

/**
 * Highlight keywords in a plain text string.
 *
 * Wraps each occurrence of a query word in a <span class="highlight"> tag.
 *
 * @param string $text  The text to process.
 * @param string $query The search query.
 * @return string Text with highlighted keywords.
 */
function igsp_highlight_keyword_plain( $text, $query ) {
    if ( empty( $query ) ) {
        return $text;
    }
    
    $words = array_filter( preg_split( '/\s+/', $query ) );
    if ( empty( $words ) ) {
        return $text;
    }
    
    // Build a regex pattern for all query words (case-insensitive, Unicode).
    $pattern = '/' . implode( '|', array_map( function( $word ) {
        return preg_quote( $word, '/' );
    }, $words ) ) . '/iu';
    
    return preg_replace( $pattern, '<span class="highlight">$0</span>', $text );
}
?>

<!-- Optional inline CSS for highlighting and search form styling.
     You can also move these styles to your plugin's CSS file. -->
<style>
    .highlight {
        background-color: yellow;
    }
    .search-box-container {
        background-color: #f7fafc;
        padding: 1rem 0;
        margin-bottom: 1.5rem;
    }
    .search-form {
        display: flex;
        align-items: center;
    }
    .search-field {
        flex-grow: 1;
        padding: 0.5rem;
        border: 1px solid #cbd5e0;
        border-radius: 0.375rem;
    }
    .search-submit {
        margin-left: 0.5rem;
        padding: 0.5rem 1rem;
        background-color: #3182ce;
        color: #fff;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
    }
</style>

<!-- Page Title -->
<div class="page-title tw-w-full tw-block tw-relative tw--mt-[200px] tw-pt-[200px]">
    <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
        <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
            <h1><?php printf( __( 'Search Results for: %s', 'text-domain' ), get_search_query() ); ?></h1>
        </div>
    </div>
    <div class="custom-shape-divider-bottom-1675786129">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
        </svg>
    </div>
</div>

<!-- Search Form for New Searches -->
<div class="search-box-container tw-w-full tw-bg-white">
    <div class="tw-container tw-mx-auto tw-px-4">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <label for="search-box" class="screen-reader-text"><?php _e( 'Search for:', 'text-domain' ); ?></label>
            <input type="search" id="search-box" class="search-field" placeholder="<?php esc_attr_e( 'Search …', 'text-domain' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
            <button type="submit" class="search-submit"><?php _e( 'Search', 'text-domain' ); ?></button>
        </form>
    </div>
</div>

<!-- Search Results Content -->
<div class="page-content tw-w-full tw-flex tw-relative tw-bg-white tw-mt-5 tw-mb-16">
    <div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
        <?php if ( have_posts() ) : ?>
            <?php 
            /* Start the Loop */
            while ( have_posts() ) : the_post();
                // Use the excerpt if available; otherwise, trim the full content.
                $content = get_the_excerpt();
                if ( empty( $content ) ) {
                    $content = wp_trim_words( get_the_content(), 55, '...' );
                }
                
                // Remove any shortcodes from the content.
                $content = strip_shortcodes( $content );
                
                // Strip all HTML tags to ensure that page builder markup does not appear.
                $content = wp_strip_all_tags( $content );
                
                // Extract a contextual snippet of 30 words that contains the search keyword.
                $snippet = igsp_get_contextual_snippet( $content, get_search_query(), 30 );
                
                // Highlight the query keywords in the snippet.
                $highlighted_snippet = igsp_highlight_keyword_plain( $snippet, get_search_query() );
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php 
                        // Display the title with a link to the full post.
                        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
                        ?>
                    </header><!-- .entry-header -->
                    
                    <div class="entry-summary">
                        <?php 
                        // Output the contextual snippet with highlighted keywords.
                        echo $highlighted_snippet; 
                        ?>
                    </div><!-- .entry-summary -->
                </article><!-- #post-<?php the_ID(); ?> -->
            <?php endwhile; ?>

            <!-- Pagination -->
            <?php 
            the_posts_pagination( array(
                'prev_text' => __( 'Previous', 'text-domain' ),
                'next_text' => __( 'Next', 'text-domain' ),
            ) ); 
            ?>
        <?php else : ?>
            <p><?php _e( 'No results found. Please try again with a different search term.', 'text-domain' ); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
