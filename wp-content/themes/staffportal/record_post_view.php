<?php
require_once("../../../wp-load.php");
if( $_POST['document_id'] && $_POST['user_id'] ) {
  // get the recently viewed list
  if( get_field('recently_viewed_ids',$_POST['user_id']) ) {
      $recently_viewed_ids = get_field('recently_viewed_ids',$_POST['user_id']);
  } else {
    $recently_viewed_ids = '';
  }
  echo('ids:'.$recently_viewed_ids);
  echo("\n");
  $recently_viewed = explode(",",$recently_viewed_ids);
  // pop the last recently viewed and add the new document to the beginning of the list
  if( in_array( $_POST['document_id'],$recently_viewed ) ) {
    echo("\n found in array \n");
    $found_value_index = array_search( $_POST['document_id'], $recently_viewed );
    $found_value = $recently_viewed[$found_value_index];
    // unset($recently_viewed[$found_value_index]);
    array_splice($recently_viewed,$found_value_index,1);
    array_unshift($recently_viewed, $found_value);
  } else {
    echo("\n not found in array \n");
    print_r( array_filter($recently_viewed) );
    array_unshift( $recently_viewed, $_POST['document_id'] );
    print_r( array_filter($recently_viewed) );
    if(count(array_filter($recently_viewed)) > 5) {
        array_pop( $recently_viewed );
    }
  }
  $recently_viewed_ids = implode( ",", array_filter($recently_viewed) );
  echo("\n ids:".$recently_viewed_ids." \n");
  // $recently_viewed_ids = '';
  // update the stored field with the recently viewed ids
  update_field('recently_viewed_ids', $recently_viewed_ids, $_POST['user_id']);
}
