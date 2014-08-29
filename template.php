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
        // $vars['classes_array'][] = presidio_id_safe('page-'. $path);
        // $vars['classes_array'][] = presidio_id_safe('section-'. $section);
    }

    if (theme_get_setting('mossback_wireframe_mode')) {
        drupal_add_css(drupal_get_path('theme', 'mossback') . '/css/wireframe.css', array('type' => 'file'));
    }

}

function mossback_preprocess_page(&$vars, $hook) {
    // Determine if the page is rendered using panels.
    $vars['is_panel'] = FALSE;
    if (module_exists('page_manager') && count(page_manager_get_current_page())) {
        $vars['is_panel'] = TRUE;
    }

    // Make sure tabs is empty.
    if (empty($vars['tabs']['#primary']) && empty($vars['tabs']['#secondary'])) {
        $vars['tabs'] = '';
    }
}

function mossback_preprocess_panels_pane(&$vars) {
    if ($vars['pane']->type === 'custom') {
        $vars['classes_array'][] = 'pane-custom-' . $vars['pane']->pid;
        $vars['classes_array'][] = str_replace('_', '-', $vars['pane']->subtype);

        if (!empty($vars['pane']->configuration['name'])) {
            $vars['classes_array'][] = str_replace('_', '-', $vars['pane']->configuration['name']);
        }
    }
}

function mossback_css_alter(&$css) {
    if (theme_get_setting('mossback_wireframe_mode')) {
        unset($css[drupal_get_path('theme', 'mossback') . '/css/main.css']);
    }
}

