<?php

/// Add custom Font Types
function springy_preprocess_html(&$variables) {
    drupal_add_css("http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic|Open+Sans:300italic,400italic,600italic,400,300,600|Roboto+Condensed:400,700", array('type' => 'external'));
}

// Add Viewport
function springy_preprocess_page(&$vars) {

    // Meta Viewport
    $viewport = '<meta name="viewport" content="initial-scale=1, maximum-scale=1">';
    $addtohead = array(
        '#type' => 'markup',
        '#markup' => $viewport
    );

    drupal_add_html_head($addtohead,'viewport');
}

function springy_theme() {
  $items = array();
  // create custom user-login.tpl.php
  $items['user_login'] = array(
  'render element' => 'form',
  'path' => drupal_get_path('theme', 'springy') . '/theme',
  'template' => 'user-login',
  'preprocess functions' => array(
  'your_themename_preprocess_user_login'
  ),
 );
return $items;
}

/// Make Drupal messages pretty
function springy_theme_registry_alter(&$theme_registry) {
  $theme_registry['status_messages']['function'] = '_custom_theme_status_messages';
}
/**
 * Custom theme function that overrides
 * theme('status_messages').
 */
function _custom_theme_status_messages($variables) {
   $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
    'info' => t('Informative message'),
  );

  // Map Drupal message types to their corresponding gumby classes.
  $status_class = array(
    'status' => 'success',
    'error' => 'danger',
    'warning' => 'warning',
    // Not supported, but in theory a module could send any type of message.
    // @see drupal_set_message()
    // @see theme_status_messages()
    'info' => 'info',
  );

  foreach (drupal_get_messages($display) as $type => $messages) {
    $class = (isset($status_class[$type])) ? $status_class[$type] : '';


    if (!empty($status_heading[$type])) {
      $output .= '<h4 class="element-invisible">' . $status_heading[$type] . "</h4>\n";
    }


      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li class="alert '.$status_class[$type].'">' . $message . "</li>\n";
      }
      $output .= " </ul>\n";

  }
  return $output;
}

