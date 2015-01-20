<?php

/**
 * Here we override the default HTML output of drupal.
 * refer to https://drupal.org/node/457740
 */

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('mossback_rebuild_registry')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}

function mossback_preprocess_html(&$vars) {
    global $user, $language;

    // HTML Attributes
    // Use a proper attributes array for the html attributes.
    $vars['html_attributes'] = array();
    $vars['html_attributes']['lang'][] = $language->language;
    $vars['html_attributes']['dir'][] = $language->dir;

    // Convert RDF Namespaces into structured data using drupal_attributes.
    $vars['rdf_namespaces'] = array();
    if (function_exists('rdf_get_namespaces')) {
        foreach (rdf_get_namespaces() as $prefix => $uri) {
            $prefixes[] = $prefix . ': ' . $uri;
        }
        $vars['rdf_namespaces']['prefix'] = implode(' ', $prefixes);
    }

    // Flatten the HTML attributes and RDF namespaces arrays.
    $vars['html_attributes'] = drupal_attributes($vars['html_attributes']);
    $vars['rdf_namespaces'] = drupal_attributes($vars['rdf_namespaces']);

    if (!$vars['is_front']) {
        // Add unique classes for each page and website section
        $path = drupal_get_path_alias($_GET['q']);
        list($section, ) = explode('/', $path, 2);
        $vars['classes_array'][] = 'with-subnav';
    }

    if (theme_get_setting('mossback_wireframe_mode')) {
        drupal_add_css(drupal_get_path('theme', 'mossback') . '/css/wireframe.css', array('type' => 'file'));
    }

}

function mossback_preprocess_page(&$vars, $hook) {
    // Make sure tabs is empty.
    if (empty($vars['tabs']['#primary']) && empty($vars['tabs']['#secondary'])) {
        $vars['tabs'] = '';
    }
}

function mossback_css_alter(&$css) {
    // Remove the main css file when in wireframe mode.
    if (theme_get_setting('mossback_wireframe_mode')) {
        unset($css[drupal_get_path('theme', 'mossback') . '/css/mossback.css']);
    }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function mossback_breadcrumb($variables) {
    $breadcrumb = $variables['breadcrumb'];  // Determine if we are to display the breadcrumb.
    $show_breadcrumb = theme_get_setting('mossback_breadcrumb');

    if ($show_breadcrumb == 'yes' || ($show_breadcrumb == 'admin' && arg(0) == 'admin')) {

        // Optionally get rid of the homepage link.
        $show_breadcrumb_home = theme_get_setting('mossback_breadcrumb_home');
        if (!$show_breadcrumb_home) {
            array_shift($breadcrumb);
        }
        // Return the breadcrumb with separators.
        if (!empty($breadcrumb)) {
            $breadcrumb_separator = theme_get_setting('mossback_breadcrumb_separator');
            $trailing_separator = $title = '';
            if (theme_get_setting('mossback_breadcrumb_title')) {
                $item = menu_get_item();
                if (!empty($item['tab_parent'])) {
                    // If we are on a non-default tab, use the tab's title.
                    $title = check_plain($item['title']);
                }
                else {
                    $title = drupal_get_title();
                }
                if ($title) {
                    $trailing_separator = $breadcrumb_separator;
                }
            }
            elseif (theme_get_setting('mossback_breadcrumb_trailing')) {
                $trailing_separator = $breadcrumb_separator;
            }
            // Provide a navigational heading to give context for breadcrumb links to
            // screen-reader users. Make the heading invisible with .element-invisible.
            $heading = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

            return $heading . '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . $trailing_separator . $title . '</div>';
        }
    }
    // Otherwise, return an empty string.
    return '';
}

