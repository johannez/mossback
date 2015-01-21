<?php

function mossback_form_system_theme_settings_alter(&$form, $form_state) {
    $form['options_settings']['mossback_breadcrumb'] = array(
        '#type'          => 'fieldset',
        '#title'         => t('Breadcrumb settings'),
        '#attributes'    => array('id' => 'mossback-breadcrumb'),
    );
    $form['options_settings']['mossback_breadcrumb']['mossback_breadcrumb'] = array(
        '#type'          => 'select',
        '#title'         => t('Display breadcrumb'),
        '#default_value' => theme_get_setting('mossback_breadcrumb'),
        '#options'       => array(
                      'yes'   => t('Yes'),
                      'admin' => t('Only in admin section'),
                      'no'    => t('No'),
                    ),
    );
    $form['options_settings']['mossback_breadcrumb']['mossback_breadcrumb_separator'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Breadcrumb separator'),
        '#description'   => t('Text only. Don’t forget to include spaces.'),
        '#default_value' => theme_get_setting('mossback_breadcrumb_separator'),
        '#size'          => 5,
        '#maxlength'     => 10,
        '#prefix'        => '<div id="div-mossback-breadcrumb-collapse">', // jquery hook to show/hide optional widgets
    );
    $form['options_settings']['mossback_breadcrumb']['mossback_breadcrumb_home'] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Show home page link in breadcrumb'),
        '#default_value' => theme_get_setting('mossback_breadcrumb_home'),
    );
    $form['options_settings']['mossback_breadcrumb']['mossback_breadcrumb_trailing'] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Append a separator to the end of the breadcrumb'),
        '#default_value' => theme_get_setting('mossback_breadcrumb_trailing'),
        '#description'   => t('Useful when the breadcrumb is placed just before the title.'),
    );
    $form['options_settings']['mossback_breadcrumb']['mossback_breadcrumb_title'] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Append the content title to the end of the breadcrumb'),
        '#default_value' => theme_get_setting('mossback_breadcrumb_title'),
        '#description'   => t('Useful when the breadcrumb is not placed just before the title.'),
        '#suffix'        => '</div>', // #div-mossback-breadcrumb
    );
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
}


