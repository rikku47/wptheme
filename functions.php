<?php

add_action('init', 'register_my_menu');
add_filter('walker_nav_menu_start_el', 'add_font_awesome', 10 ,4);
add_filter('nav_menu_css_class', 'nav_menu_remove_fa_class');

function register_my_menu() {
  register_nav_menu('header-menu',__( 'Header Menu'));
}

function add_font_awesome(string $item_output, WP_Post $item, int $depth, stdClass $args) {
  if (in_array('fas', $item->classes)) {
    
    $tmp_classes = preg_grep('/fa/i', $item->classes);

    $icon = ' <i class="' . implode(' ', $tmp_classes) . '"></i>';
    
    preg_match('/(<a.+>)(.+)(<\/a>)/i', $item_output, $matches);

    if(4 === count($matches)) {
        
        $item_output = $matches[1];
    
        // if( $before ) {
        //     $item_output .= $icon . ' ' . $matches[2];
        // } else {
            $item_output .= $matches[2] . ' '  . $icon;
        // }

        $item_output .= $matches[3];    
    }    
}

return $item_output;
}

function nav_menu_remove_fa_class($classes){
    if( is_array($classes)) {
        $tmp_classes = preg_grep('/fa/i', $classes);
        if( !empty($tmp_classes)) {
            $classes = array_values(array_diff($classes, $tmp_classes));
        }
    }

    return $classes;
}

function breadcrumbs() {
	$showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$home = 'Startseite'; // text for the 'Home' link
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before = '<li><span class="current active">'; // tag before the current crumb
	$after = '</span></li>'; // tag after the current crumb
 
	global $post;
	$homeLink = get_bloginfo('url');
 
	if (is_home() || is_front_page()) {
		if ($showOnHome == 1) {
			echo '<ol id="crumbs">
					<li>
					<a href="' . $homeLink . '">' . $home . '</a>
					</li>
				</ol>';
		}
	} else {	
		echo '<ol id="crumbs">
				<li>	
					<a href="' . $homeLink . '">' . $home . '</a>
				</li>';
 
    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ');
      echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_day() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
      echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li>';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
        if ($showCurrent == 1) echo ' ' . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, ' ');
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ');
      echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
      if ($showCurrent == 1) echo ' ' . $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo ' ';
      }
      if ($showCurrent == 1) echo ' ' . $before . get_the_title() . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }
	
	if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
	echo	'</ol>';
  }
}

?>