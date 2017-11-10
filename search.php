<?php

/*
 * Search only a specific forum
 */
function my_bbp_filter_search_by_current_and_children( $r ){

    if (isset($_GET['bbp_search_forum_id'])) {
        $forum_id = $_GET['bbp_search_forum_id'] ;

        $ar = explode(",", $forum_id);
        //If the forum ID exits, filter the query
        if( $forum_id && is_array( $ar ) ){
     
            $r['meta_query'] = array(
                  array(
                      'key' => '_bbp_forum_id',
                      'value' => $ar,
                      'compare' => 'IN',
                  )
            );
             
        }
  };
    return $r;
}

add_filter( 'bbp_after_has_search_results_parse_args' , 'my_bbp_filter_search_by_current_and_children' );


function bbp_search_current_forum($x = 0){
    $t = bbp_get_forum_id();
    $ids = array( $t );
    $rows = array(bbp_forum_get_subforums());
    $rows = $rows[0];
    $x='';
    foreach($rows as $row):
      array_push ($ids,$row->ID);
    endforeach;

    foreach($ids as $id):
      $x .= $id.',';
    endforeach;
    $x = rtrim($x,',');

    return $x;

}