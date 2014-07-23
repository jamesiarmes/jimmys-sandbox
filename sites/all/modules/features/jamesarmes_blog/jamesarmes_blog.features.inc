<?php
/**
 * @file
 * jamesarmes_blog.features.inc
 */

/**
 * Implements hook_views_api().
 */
function jamesarmes_blog_views_api() {
  return array("version" => "3.0");
}

/**
 * Implements hook_node_info().
 */
function jamesarmes_blog_node_info() {
  $items = array(
    'blog' => array(
      'name' => t('Blog entry'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
