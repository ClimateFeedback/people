<?php

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
  // Retrieve current name
  $title = esc_html( get_post_meta( $person->ID, 'title', true ) );

  $website = esc_html( get_post_meta( $person->ID, 'website', true ) );

  $affiliation = esc_html( get_post_meta( $person->ID, 'affiliation', true ) );

  $expertise = esc_html( get_post_meta( $person->ID, 'expertise', true ) );

  $hypothesis = esc_html ( get_post_meta( $person->ID, 'hypothesis', true ) );

  $last_name = esc_html ( get_post_meta( $person->ID, 'last_name', true ) );

  ?>
  <table>
    <tr>
      <td style="width: 100%">Website</td>
      <td><input type="text" size="80" name="person_website" value="<?php echo $website; ?>" /></td>
    </tr>

    <tr>
      <td style="width: 100%">Hypothesis Handle</td>
      <td><input type="text" size="80" name="person_hypothesis" value="<?php echo $hypothesis; ?>" /></td>
    </tr>

    <tr>
      <td style="width: 100%">Title (eg PhD Candidate...)</td>
      <td><input type="text" size="80" name="person_title" value="<?php echo $title; ?>" /></td>
    </tr>

    <tr>
      <td style="width: 100%">Affiliation</td>
      <td><input type="text" size="80" name="person_affiliation" value="<?php echo $affiliation; ?>" /></td>
    </tr>

    <tr>
      <td style="width: 100%">Expertise</td>
      <td><input type="text" size="80" name="person_expertise" value="<?php echo $expertise; ?>" /></td>
    </tr>

    <tr>
      <td style="width: 100%">Last Name</td>
      <td><input type="text" size="80" name="person_last_name" value="<?php echo $last_name; ?>" /></td>
    </tr>

  </table>
  <?php }

add_action( 'save_post', 'add_person_fields', 10, 2 );


function add_person_fields( $person_id, $person ) {
  // Check post type for movie reviews
  if ( $person->post_type == 'people' ) {
    // Store data in post meta table if present in post data

    if ( isset( $_POST['person_title'] ) && $_POST['person_title'] != '' ) {
      update_post_meta( $person_id, 'title', $_POST['person_title'] );
    }

    if ( isset( $_POST['person_website'] ) && $_POST['person_website'] != '' ) {
      update_post_meta( $person_id, 'website', $_POST['person_website'] );
    }

    if ( isset( $_POST['person_hypothesis'] ) && $_POST['person_hypothesis'] != '' ) {
      update_post_meta( $person_id, 'hypothesis', $_POST['person_hypothesis'] );
    }

    if ( isset( $_POST['person_expertise'] ) && $_POST['person_expertise'] != '' ) {
      update_post_meta( $person_id, 'expertise', $_POST['person_expertise'] );
    }

    if ( isset( $_POST['person_affiliation'] ) && $_POST['person_affiliation'] != '' ) {
      update_post_meta( $person_id, 'affiliation', $_POST['person_affiliation'] );
    }

    if ( isset( $_POST['person_last_name'] ) && $_POST['person_last_name'] != '' ) {
      update_post_meta( $person_id, 'last_name', $_POST['person_last_name'] );
    }
  }
}

function peopleLoop($atts, $content = null) {
    extract(shortcode_atts(array(
      "category" => '',
      "type" => 'people',
      'per_row' => '1',
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
        'meta_key' => 'last_name',
        'orderby' => 'meta_value',
        'order' => 'ASC'
      );

      //Get the posts
      $myposts = get_posts($argsG2);
      remove_all_filters('posts_orderby');

      $output .= '<div class="row expert">';

      foreach($myposts as $post) : setup_postdata($post);
        $output .='
                     <div class="med-left">
                        '.get_the_post_thumbnail().'
                     </div>
                     <div class="med-body">
                        <h3 class="noborder"> <a target="_blank" href="'.get_post_meta( get_the_ID(), 'website', true ).'">'.get_the_title().'</a></h3>
                        <p>'.get_post_meta( get_the_ID(), 'title', true ).', '.get_post_meta( get_the_ID(), 'affiliation', true ).'</p>
                        <p>'.get_post_meta( get_the_ID(), 'expertise', true ).'</p>
                        <p> <a target="_blank" href="https://hypothes.is/stream?q=user:'.get_post_meta( get_the_ID(), 'hypothesis', true ).'" class="">'.get_post_meta( get_the_ID(), 'hypothesis', true ).'</a></p>
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
                  <h3 class="modal-title" id="myModalLabel"><a target="_blank" href="'.get_post_meta( get_the_ID(), 'website', true ).'">'.get_the_title().'</a></h3>
                </div>
                <div class="modal-body">
                  <div class="responsive-modal-image">'.get_the_post_thumbnail().'</div>
                  <h5>'.get_post_meta( get_the_ID(), 'title', true ).' <br> '.get_post_meta( get_the_ID(), 'affiliation', true ).'</h5>
                  <h5>
                    '.get_post_meta( get_the_ID(), 'expertise', true ).' <br>
                    <small>hypothesis:</small> '.get_post_meta( get_the_ID(), 'hypothesis', true ).'
                  </h5>
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
