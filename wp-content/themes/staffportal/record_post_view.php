<?php
require_once("../../../wp-load.php");
if( $_POST['document_id'] && $_POST['user_id'] ) {
  // $count++;
  // update_field('views', $count);
  /* track personal post view */
  // get the recently viewed list
  if( get_field('recently_viewed_ids',$_POST['user_id']) ) {
      $recently_viewed_ids = get_field('recently_viewed_ids',$_POST['user_id']);
  } else {
    $recently_viewed_ids = '';
  }
  $recently_viewed = explode(",",$recently_viewed_ids);
  // pop the last recently viewed and add the new document to the beginning of the list
  if( in_array( $_POST['document_id'],$recently_viewed ) ) {
    $found_value_index = array_search( $_POST['document_id'], $recently_viewed );
    $found_value = $recently_viewed[$found_value_index];
    array_splice($recently_viewed,$found_value_index,1);
    array_unshift($recently_viewed, $found_value);
  } else {
    array_unshift( $recently_viewed, $_POST['document_id'] );
    if(count(array_filter($recently_viewed)) > 5) {
        array_pop( $recently_viewed );
    }
  }
  $recently_viewed_ids = implode( ",", array_filter($recently_viewed) );
  // $recently_viewed_ids = '';
  // update the stored field with the recently viewed ids
  update_field('recently_viewed_ids', $recently_viewed_ids, $_POST['user_id']);

  /* track an overall view of the document */
  if(get_field('views',$_POST['document_id'])) {
    $count = (int) get_field('views',$_POST['document_id']);
  } else {
    $count = 0;
  }

  $count++;
  update_field('views', $count, $_POST['document_id']);
}
