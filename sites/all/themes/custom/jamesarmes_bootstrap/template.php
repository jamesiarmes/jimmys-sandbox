<?php
// function THEMENAME_menu_tree__MENU_NAME($variables) {
function jamesarmes_bootstrap_menu_tree__main_menu($variables) {
  return '<ul class="nav pull-right main-menu">' . $variables['tree'] . '</ul>';
}

function jamesarmes_bootstrap_menu_tree__user_menu($variables) {
  return '<ul class="nav secondary-menu">' . $variables['tree'] . '</ul>';
}

function jamesarmes_bootstrap_menu_link__user_menu($variables) {
  $element = &$variables['element'];

  $index = (isset($element['#attributes']['class']) ? array_search('leaf', $variables['element']['#attributes']['class']) : FALSE);
  if ($index !== FALSE) {
    unset($element['#attributes']['class'][$index]);
  }

  return theme_menu_link($variables);
}

function jamesarmes_bootstrap_preprocess_page(&$vars) {
//   open_framework_preprocess_page($vars);
  
  // Get the entire main menu tree
  $secondary_menu_tree = menu_tree_all_data('user-menu');
  
  // Add the rendered output to the $main_menu_expanded variables
  $vars['secondary_menu_expanded'] = menu_tree_output($secondary_menu_tree);
}
