<?php

function mossback_form_system_theme_settings_alter(&$form, $form_state) {
    $form['themedev'] = array(
        '#type'          => 'fieldset',
        '#title'         => t('Theme development settings'),
    );
    $form['themedev']['mossback_rebuild_registry'] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Rebuild theme registry on every page.'),
        '#default_value' => theme_get_setting('mossback_rebuild_registry'),
        '#description'   => t('During theme development, it can be very useful to continuously <a href="!link">rebuild the theme registry</a>. WARNING: this is a huge performance penalty and must be turned off on production websites.', array('!link' => 'https://drupal.org/node/173880#theme-registry')),
    );
    $form['themedev']['mossback_wireframe_mode'] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Enable wireframe mode'),
        '#default_value' => theme_get_setting('mossback_wireframe_mode'),
        '#description'   => t('<a href="!link">Wireframes</a> are useful when prototyping a website.', array('!link' => 'http://www.boxesandarrows.com/view/html_wireframes_and_prototypes_all_gain_and_no_pain')),
    );
}


