<?php
/*
Plugin Name: People
Description: Declares a plugin that will create a custom post type displaying people.
Version: 1.0
Author: Jehan Tremback
License: GPLv2
*/
add_action( 'init', 'create_person' );


function create_person() {
  register_post_type( 'people',
    array(
      'labels' => array(
        'name' => 'People',
        'singular_name' => 'Person',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Person',
        'edit' => 'Edit',
        'edit_item' => 'Edit Person',
        'new_item' => 'New Person',
        'view' => 'View',
        'view_item' => 'View Person',
        'search_items' => 'Search People',
        'not_found' => 'No People found',
        'not_found_in_trash' => 'No People found in Trash',
        'parent' => 'Parent Person'
      ),
      'public' => true,
      'menu_position' => 15,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( 'category' ),
      'has_archive' => false
    )
  );
}

add_action( 'admin_init', 'my_admin' );




function my_admin() {
  add_meta_box( 'person_meta_box',
    'Person Details',
    'display_person_meta_box',
    'people', 'normal', 'high'
  );
}

function display_person_meta_box( $person ) {
  // Retrieve current name of the Director and Movie Rating based on review ID
  $tagline = esc_html( get_post_meta( $person->ID, 'tagline', true ) );

  $twitter = esc_html( get_post_meta( $person->ID, 'twitter', true ) );

  $bio = esc_html( get_post_meta( $person->ID, 'bio', true ) );

  ?>
  <table>
    <tr>
      <td style="width: 100%">Tagline</td>
      <td><input type="text" size="80" name="person_tagline" value="<?php echo $tagline; ?>" /></td>
    </tr>

    <tr>
      <td style="width: 100%">Twitter</td>
      <td><input type="text" size="80" name="person_twitter" value="<?php echo $twitter; ?>" /></td>
    </tr>

    <tr>
      <td style="width: 100%">Bio</td>
      <td><textarea rows="20" cols="75" name="person_bio"><?php echo $bio; ?></textarea></td>
    </tr>

  </table>
  <?php } 

add_action( 'save_post', 'add_person_fields', 10, 2 );


function add_person_fields( $person_id, $person ) {
  // Check post type for movie reviews
  if ( $person->post_type == 'people' ) {
    // Store data in post meta table if present in post data

    if ( isset( $_POST['person_tagline'] ) && $_POST['person_tagline'] != '' ) {
      update_post_meta( $person_id, 'tagline', $_POST['person_tagline'] );
    }

    if ( isset( $_POST['person_twitter'] ) && $_POST['person_twitter'] != '' ) {
      update_post_meta( $person_id, 'twitter', $_POST['person_twitter'] );
    }

    if ( isset( $_POST['person_bio'] ) && $_POST['person_bio'] != '' ) {
      update_post_meta( $person_id, 'bio', $_POST['person_bio'] );
    }
  }
}

function peopleLoop($atts, $content = null) {
    extract(shortcode_atts(array(
      "category" => '',
      "type" => 'people',
      'per_row' => '5',
      'width' => ''
    ), $atts));

    //Extract ID from category name
    $theCatId = get_term_by( 'slug', $category, 'category' );
    $theCatId = $theCatId->term_id;



    //Establish global post var
    global $post;

    //Open markup
    $output = '';

    //set args for WP_Query
    $argsQ = array(
      'post_type' => $type,
      'cat' => $theCatId
      );

    //make new WP_Query
    $yo_quiery = new WP_Query($argsQ);
    $total = $yo_quiery->found_posts;

    //Start counter
    $i = 0;

    //While counter is less than
    while($i < $total) :

      //Set up args for get_posts
      $argsG2 = array(
        'numberposts' => $per_row,
        'offset' => $i,
        'category' => $theCatId,
        'post_type' => $type,
        'orderby' => 'menu_order'
      );

      //Get the posts
      $myposts = get_posts($argsG2);


      $output .= '<div class="row">';

      foreach($myposts as $post) : setup_postdata($post);
        $output .='<div class="picunit tipper '.$width.'" data-toggle="modal" data-target="#'.get_the_ID().'">
            <a href="#'.get_the_ID().'">'.get_the_post_thumbnail().'</a>
            <div class="caption" style="display: block;">
              <a href="#'.get_the_ID().'">'.get_the_title().'</a>
            </div>
            <div class="caption" style="display: block;">'.get_post_meta( get_the_ID(), 'tagline', true ).'</div>
            <div class="hovertext" style="display: none;">Click for bio<span class="redtext">.</span></div>
          </div>';
      endforeach;

      //Second row

      $output .= '</div><div class="row">';

      foreach($myposts as $post) : setup_postdata($post);

        $output .='
          <div class="modal fade" id="'.get_the_ID().'"tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" id="myModalLabel"><a href="'.get_post_meta( get_the_ID(), 'website', true ).'">'.get_the_title().'</a></h3>
                </div>
                <div class="modal-body">
                  <div class="hypo-responsive-modal-image">'.get_the_post_thumbnail().'</div>
                  <h5>'.get_post_meta( get_the_ID(), 'tagline', true ).'</h5>
                  <h5>
                    <a href="https://twitter.com/#!/'.substr(get_post_meta( get_the_ID(), 'twitter', true ), 1).'">'.get_post_meta( get_the_ID(), 'twitter', true ).'</a>
                  </h5>
                  <p>'.get_post_meta( get_the_ID(), 'bio', true ).'</p>
                </div>
              </div>
            </div>
          </div>';
      endforeach;

      $output .= '</div>';

      //Increment counter
      $i += $per_row;

    endwhile;

    //Close and return markup
    return $output;
  }
  add_shortcode('people-loop', 'peopleLoop');

?>
