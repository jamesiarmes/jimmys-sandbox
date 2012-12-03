<?php
/**
 * @file
 * Theme overrides and processing functions for the JamesArmes.com Bootstrap
 * theme.
 */

/**
 * Implements theme_menu_tree__MENU_NAME().
 *
 * Add the nav, pull-right and main-menu classes to the main menu.
 */
function jamesarmes_bootstrap_menu_tree__main_menu($variables) {
  return '<ul class="nav pull-right main-menu">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_tree__MENU_NAME().
 *
 * Add the nav and sexondary-menu classes to the user menu.
 */
function jamesarmes_bootstrap_menu_tree__user_menu($variables) {
  return '<ul class="nav secondary-menu">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_link__MENU_NAME().
 *
 * Remove the leaf class from user menu links.
 */
function jamesarmes_bootstrap_menu_link__user_menu($variables) {
  $element = &$variables['element'];

  // If the link has the "leaf" class then remove that class.
  $index = (isset($element['#attributes']['class']) ? array_search('leaf', $variables['element']['#attributes']['class']) : FALSE);
  if ($index !== FALSE) {
    unset($element['#attributes']['class'][$index]);
  }

  return theme_menu_link($variables);
}

/**
 * Implements template_preprocess_page().
 *
 * Add the user menu as the secondary menu for the theme.
 */
function jamesarmes_bootstrap_preprocess_page(&$vars) {
  // Get the entire main menu tree.
  $secondary_menu_tree = menu_tree_all_data('user-menu');

  // Add the rendered output to the $main_menu_expanded variable.
  $vars['secondary_menu_expanded'] = menu_tree_output($secondary_menu_tree);
}

/**
 * Implements template_preprocess_comment().
 *
 * Modify how the submitted variable is rendered to use "@" to seperate the
 * author and time.
 */
function jamesarmes_bootstrap_preprocess_comment(&$variables) {
  $variables['submitted'] = $variables['author'] . ' @ ' . $variables['created'];
}

/**
 * Implements theme_username().
 *
 * Make sure the username does not include the "(not verified" suffix.
 */
function jamesarmes_bootstrap_username($variables) {
  if ($variables['extra'] == ' (' . t('not verified') . ')') {
    $variables['extra'] = '';
  }

  return theme_username($variables);
}

/**
 * Implements hook_username_alter().
 *
 * Render the user's name as their full name if they have an account with the
 * appropriate fields.
 */
function jamesarmes_bootstrap_username_alter(&$name, $account) {
  // If the account is not a real account (i.e. a comment) then it won't have
  // the full name fields.
  if (!$account->uid) {
    return;
  }

  // If the user does not have the first name field or it is empty, rely on the
  // default behavior.
  $wrapper = entity_metadata_wrapper('user', user_load($account->uid));
  if (empty($wrapper->field_first_name) || !$wrapper->field_first_name->value()) {
    return;
  }

  $name = $wrapper->field_first_name->value();

  // If the user has a middle name or initial then add it to the name.
  $middle_name = (!empty($wrapper->field_middle_name) ? $wrapper->field_middle_name->value() : NULL);
  if ($middle_name) {
    $name .= " $middle_name";
  }

  // If the user has a last name then add it to the name.
  $last_name = (!empty($wrapper->field_last_name) ? $wrapper->field_last_name->value() : NULL);
  if ($last_name) {
    $name .= " $last_name";
  }
}

/**
 * Implements hook_FORM_ID_alter().
 *
 * Change the comment notification type to a select only displayed when
 * notifications have been enabled.
 */
function jamesarmes_bootstrap_form_comment_form_alter(&$form, &$form_state, $form_id) {
  if (isset($form['notify_settings'])) {
    $form['notify_settings']['notify_type']['#states']['visible'][] = array(':input[name="notify"]' => array('checked' => TRUE));
    $form['notify_settings']['notify_type']['#type'] = 'select';
  }
}

