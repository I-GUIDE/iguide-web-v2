<?php
/**
 * Plugin Name: I-GUIDE Newsletter Tool
 * Description: Extracts and inserts newsletter content into the WordPress post editor in 'news_events' post type.
 * Version: 1.4
 * Author: Nattapon Jaroenchai
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Add meta box for email URL input
function iguide_add_meta_box() {
    add_meta_box(
        'iguide_newsletter_importer',
        'Import Newsletter',
        'iguide_meta_box_callback',
        'news_events',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'iguide_add_meta_box');

function iguide_meta_box_callback($post) {
    $email_url = get_post_meta($post->ID, '_iguide_email_url', true);
    ?>
    <label for="iguide_email_url">Enter Email URL:</label>
    <input type="url" id="iguide_email_url" name="iguide_email_url" value="<?php echo esc_url($email_url); ?>" style="width:100%;" />
    <button type="button" id="iguide_fetch_newsletter" class="button">Fetch Newsletter</button>
    <p id="iguide_status"></p>
    
    <script>
    jQuery(document).ready(function($) {
        $('#iguide_fetch_newsletter').click(function() {
            var url = $('#iguide_email_url').val();
            if (!url) {
                alert("Please enter a valid email URL.");
                return;
            }
            
            $('#iguide_status').text('Fetching content...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'iguide_fetch_newsletter',
                    email_url: url,
                    post_id: <?php echo $post->ID; ?>
                },
                success: function(response) {
                    if (response) {
                        // Insert into the Text Mode
                        $('#content').val(response);

                        // Insert into the TinyMCE (Visual Editor)
                        if (typeof tinymce !== "undefined" && tinymce.editors.length > 0) {
                            tinymce.editors[0].setContent(response);
                        }

                        $('#iguide_status').html('<strong>Newsletter Imported!</strong> (Check the post content editor)');
                    } else {
                        $('#iguide_status').html('<strong>Error:</strong> Failed to fetch content.');
                    }
                },
                error: function() {
                    $('#iguide_status').html('<strong>Error:</strong> Unable to fetch content.');
                }
            });
        });
    });
    </script>
    <?php
}

// Handle AJAX request
function iguide_fetch_newsletter() {
    if (!current_user_can('edit_posts')) wp_die('Unauthorized access');

    $email_url = esc_url_raw($_POST['email_url']);
    if (!$email_url) wp_die('Invalid request');

    // Fetch and extract email content
    $newsletter_content = iguide_scrape_newsletter($email_url);

    if ($newsletter_content) {
        echo $newsletter_content;
    } else {
        echo "Failed to fetch content";
    }

    wp_die();
}
add_action('wp_ajax_iguide_fetch_newsletter', 'iguide_fetch_newsletter');

// Function to scrape and extract email content
function iguide_scrape_newsletter($url) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    
    global $wp_filesystem;
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) return false;

    $html = wp_remote_retrieve_body($response);
    if (!$html) return false;

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_NOERROR);
    $xpath = new DOMXPath($dom);

    // Extract styles
    $styles = $xpath->query("//style");
    $styles_content = "";
    foreach ($styles as $style) {
        $styles_content .= $dom->saveHTML($style) . "\n";
    }

    // Extract table
    $table = $xpath->query("//table[contains(@class, 'shell_panel-row')]");
    if (!$table || $table->length === 0) return false;

    $table_html = $dom->saveHTML($table->item(0));

    // Modify table background color
    $table_html = preg_replace('/background-color:\s*#[0-9A-Fa-f]{3,6};?/', 'background-color: #FFFFFF;', $table_html);
    $table_html = preg_replace('/bgcolor="#[0-9A-Fa-f]{3,6}"/', 'bgcolor="#FFFFFF"', $table_html);

    // Remove footer rows with "shell_panel-cell shell_panel-cell--footer"
    $table_dom = new DOMDocument();
    $table_dom->loadHTML(mb_convert_encoding($table_html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_NOERROR);
    $table_xpath = new DOMXPath($table_dom);
    
    foreach ($table_xpath->query("//tr[td[contains(@class, 'shell_panel-cell shell_panel-cell--footer')]]") as $footer_row) {
        $footer_row->parentNode->removeChild($footer_row);
    }

    // Remove last two rows
    $all_rows = $table_xpath->query("//tr");
    $row_count = $all_rows->length;
    if ($row_count > 2) {
        for ($i = 1; $i <= 2; $i++) {
            $all_rows->item($row_count - $i)->parentNode->removeChild($all_rows->item($row_count - $i));
        }
    }

    // Final extracted table
    $final_table = $table_dom->saveHTML();

    // Remove weird encoding characters
    $clean_html = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $final_table);
    $clean_html = html_entity_decode($clean_html, ENT_QUOTES, 'UTF-8');

    return "<style>\n" . $styles_content . "\n</style>\n" . $clean_html;
}
