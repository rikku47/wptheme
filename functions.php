<?php

add_action( 'init', 'register_my_menu' );
add_filter( 'walker_nav_menu_start_el', 'add_font_awesome', 10 ,4 );
add_filter( 'nav_menu_css_class', 'nav_menu_remove_fa_class' );

function register_my_menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}

function add_font_awesome( string $item_output, WP_Post $item, int $depth, stdClass $args ) {
  if (in_array( 'fas', $item->classes )) {
    
    $tmp_classes = preg_grep( '/fa/i', $item->classes );

    $icon = ' <i class="' . implode( ' ', $tmp_classes ) . '"></i>';
    
    preg_match( '/(<a.+>)(.+)(<\/a>)/i', $item_output, $matches );

    if( 4 === count( $matches ) ) {
        
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

function nav_menu_remove_fa_class( $classes ){
    if( is_array( $classes ) ) {
        $tmp_classes = preg_grep( '/fa/i', $classes );
        if( !empty( $tmp_classes ) ) {
            $classes = array_values( array_diff( $classes, $tmp_classes ) );
        }
    }

    return $classes;
}

?>