<?php
/**
 * Functions which return fragments used throughout the site widgets
 */

function get_the_primary_tag_link() {
  $primary_tag_id = get_post_meta( get_the_id(), 'primary_tag', true );
  $primary_tag_array = get_term_by( 'id', $primary_tag_id, 'post_tag', ARRAY_A);
  $primary_tag = ucwords($primary_tag_array['name']);
  $primary_tag_url = '/tag/' . $primary_tag_array['slug'];

  if ( ! empty($primary_tag) ) {
    $html = '<a href="' . esc_url( $primary_tag_url ) . '">' . esc_html( $primary_tag ) . '</a>';
    return $html;
  } else {
    $the_category = get_the_category();
    $category_name = $the_category[0]->name;
    $html = '<a>' . esc_html( $category_name ) . '</a>';
    return $html;
  }
}

function get_the_byline_link() {
  if ( function_exists( 'coauthors_posts_links' ) ) {
    coauthors_posts_links();
  } else {
    the_author_posts_link();
  }
}
