<?php

  function expertLoop() {
    $args = array(
      'blog_id'      => $GLOBALS['blog_id'],
      'role'         => 'Scientist',
      'meta_key'     => '',
      'meta_value'   => '',
      'meta_compare' => '',
      'meta_query'   => array(),
      'include'      => array(),
      'exclude'      => array(),
      'orderby'      => 'last_name',
      'order'        => 'ASC',
      'offset'       => '',
      'search'       => '',
      'number'       => '',
      'count_total'  => false,
      'fields'       => 'all_with_meta',
      'who'          => ''
    );

    $blogusers = get_users( $args );

    //Open markup
    $output = '';
    
    foreach ( $blogusers as $user ) {

      $userdata = get_userdata( $user->get('ID') );
      $all_meta_for_user = get_user_meta( $user->get('ID') );
      
      if ( !empty($all_meta_for_user['expertise'][0]) ) {
        $expertise = $all_meta_for_user['expertise'][0];
      }
      if ( !empty($userdata->user_url) ) {
        $website = $userdata->user_url;
      }    
      if ( !empty($all_meta_for_user['orchid'][0]) ) {
        $orchid = $all_meta_for_user['orchid'][0];
      }
      if ( !empty($all_meta_for_user['hypothesis'][0]) ) {
        $hypothesis = $all_meta_for_user['hypothesis'][0];
      }
      if ( !empty($all_meta_for_user['title'][0]) ) {
        $title = $all_meta_for_user['title'][0];
      }
      if ( !empty($all_meta_for_user['affiliation'][0]) ) {
        $affiliation = $all_meta_for_user['affiliation'][0];
      }
      if ( !empty($all_meta_for_user['publicationone'][0]) ) {
        $publicationone = $all_meta_for_user['publicationone'][0];
      }
      if ( !empty($all_meta_for_user['first_name'][0]) ) {
        $first_name = $all_meta_for_user['first_name'][0];
      }
      if ( !empty($all_meta_for_user['last_name'][0]) ) {
        $last_name = $all_meta_for_user['last_name'][0];
      }

      
      $output .='<div class="row expert">
          <div class="med-left">
            '.get_avatar( $user->get('ID'), $size = '256', $default = '<path_to_url>' ).'
          </div>
          <div class="med-body">
            <h3 class="noborder"> <a target="_blank" href="'.$website.'">'.$first_name.' '.$last_name.'</a></h3>
            <p>'.$title.', '.$affiliation.'</p>
            <p><small>Expertise:</small> '.$expertise.'</p>
            <p><small>Hypothesis:</small> <a target="_blank" href="https://hypothes.is/stream?q=user:'.$hypothesis.'" class="">'.$hypothesis.'</a></p>
          </div>
        </div>';
    }

    //Close and return markup
    return $output;
  }

  add_shortcode('expert-loop', 'expertLoop');



  function GuestLoop() {
    $args = array(
      'blog_id'      => $GLOBALS['blog_id'],
      'role'         => 'Guest',
      'meta_key'     => '',
      'meta_value'   => '',
      'meta_compare' => '',
      'meta_query'   => array(),
      'include'      => array(),
      'exclude'      => array(),
      'orderby'      => 'last_name',
      'order'        => 'ASC',
      'offset'       => '',
      'search'       => '',
      'number'       => '',
      'count_total'  => false,
      'fields'       => 'all_with_meta',
      'who'          => ''
    );

    $blogusers = get_users( $args );

    //Open markup
    $output = '';
    
    foreach ( $blogusers as $user ) {

      $userdata = get_userdata( $user->get('ID') );
      $all_meta_for_user = get_user_meta( $user->get('ID') );
      
      if ( !empty($all_meta_for_user['expertise'][0]) ) {
        $expertise = $all_meta_for_user['expertise'][0];
      }
      if ( !empty($userdata->user_url) ) {
        $website = $userdata->user_url;
      }    
      if ( !empty($all_meta_for_user['orchid'][0]) ) {
        $orchid = $all_meta_for_user['orchid'][0];
      }
      if ( !empty($all_meta_for_user['hypothesis'][0]) ) {
        $hypothesis = $all_meta_for_user['hypothesis'][0];
      }
      if ( !empty($all_meta_for_user['title'][0]) ) {
        $title = $all_meta_for_user['title'][0];
      }
      if ( !empty($all_meta_for_user['affiliation'][0]) ) {
        $affiliation = $all_meta_for_user['affiliation'][0];
      }
      if ( !empty($all_meta_for_user['publicationone'][0]) ) {
        $publicationone = $all_meta_for_user['publicationone'][0];
      }
      if ( !empty($all_meta_for_user['first_name'][0]) ) {
        $first_name = $all_meta_for_user['first_name'][0];
      }
      if ( !empty($all_meta_for_user['last_name'][0]) ) {
        $last_name = $all_meta_for_user['last_name'][0];
      }

      
      $output .='<div class="row expert">
          <div class="med-left">
            '.get_avatar( $user->get('ID'), $size = '256', $default = '<path_to_url>' ).'
          </div>
          <div class="med-body">
            <h3 class="noborder"> <a target="_blank" href="'.$website.'">'.$first_name.' '.$last_name.'</a></h3>
            <p>'.$title.', '.$affiliation.'</p>
            <p><small>Expertise:</small> '.$expertise.'</p>
            <p><small>Hypothesis:</small> <a target="_blank" href="https://hypothes.is/stream?q=user:'.$hypothesis.'" class="">'.$hypothesis.'</a></p>
          </div>
        </div>';
    }

    //Close and return markup
    return $output;
  }

  add_shortcode('guest-loop', 'GuestLoop');



  function TeamLoop() {
    $args = array(
      'blog_id'      => $GLOBALS['blog_id'],
      'role'         => 'Editor',
      'meta_key'     => '',
      'meta_value'   => '',
      'meta_compare' => '',
      'meta_query'   => array(),
      'include'      => array(),
      'exclude'      => array(),
      'orderby'      => 'last_name',
      'order'        => 'ASC',
      'offset'       => '',
      'search'       => '',
      'number'       => '',
      'count_total'  => false,
      'fields'       => 'all_with_meta',
      'who'          => ''
    );

    $blogusers = get_users( $args );

    //Open markup
    $output = '';
    
    foreach ( $blogusers as $user ) {

      $userdata = get_userdata( $user->get('ID') );
      $all_meta_for_user = get_user_meta( $user->get('ID') );
      
      if ( !empty($userdata->user_url) ) {
        $website = $userdata->user_url;
      }    
      if ( !empty($all_meta_for_user['description'][0]) ) {
        $bio = $all_meta_for_user['description'][0];
      }
      if ( !empty($all_meta_for_user['title'][0]) ) {
        $title = $all_meta_for_user['title'][0];
      }
      if ( !empty($all_meta_for_user['first_name'][0]) ) {
        $first_name = $all_meta_for_user['first_name'][0];
      }
      if ( !empty($all_meta_for_user['last_name'][0]) ) {
        $last_name = $all_meta_for_user['last_name'][0];
      }

      
      $output .='<div class="row expert">
          <div class="med-left">
            '.get_avatar( $user->get('ID'), $size = '256', $default = '<path_to_url>' ).'
          </div>
          <div class="med-body">
            <h3 class="noborder"> <a target="_blank" href="'.$website.'">'.$first_name.' '.$last_name.'</a></h3>
            <strong>'.$title.'</strong>
            <p> '.$bio.'</p>
          </div>
        </div>';
    }

    //Close and return markup
    return $output;
  }

  add_shortcode('team-loop', 'TeamLoop');

