<?php
/*
Template Name: Search Page
*/
global $theme;
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

if( strlen($query_string) > 0 ) {
	foreach($query_args as $key => $string) {
		$query_split = explode("=", $string);
		$search_query[$query_split[0]] = urldecode($query_split[1]);
	} // foreach
} //if
$search = new WP_Query($search_query);
get_header();
?>
<h2>SEARCH RESULTS PAGE:</h2>
<?php if ( have_posts() ) :
   $benefits = [];
   $documents = [];
   $brand_documents = [];
   $employees = [];
   $tickets = [];
   while ( have_posts() ) : the_post();
     switch($post->post_type) {
         case 'benefit':
            array_push($benefits,$post);
            break;
         case 'document':
            array_push($documents,$post);
            break;
         case 'brand_document':
            array_push($brand_documents,$post);
            break;
         case 'ticket':
               array_push($tickets,$post);
               break;
         case 'employee':
            array_push($employees,$post);
            break;
     }
   endwhile;
   ?>
  <div class="search_results container">
     <div class="result">
        <h2>Results for:</h2>
        <?php the_search_query(); ?>
     </div>
     <?php if(count($benefits) > 0) { ?>
     <!-- Benefit Results -->
     <div class="benefit-results">
        <?php foreach($benefits as $document) { ?>
        <div class="result">
           <h6><?php echo $document->post_title ?></h6>
           <?php
               $document_files = get_field('document_files',$document->ID);
               if($document_files) { ?>
                 <ul class="search-result-files">
                 <?php foreach($document_files as $document_file) { ?>
                     <li><a href="<?php the_field('file_path',$document_file->ID) ?>" class="document-file" data-documentid="<?php echo $document_file->ID ?>" data-userid="<?php echo $current_user->ID ?>" target="_blank"><?php echo $document_file->post_title ?></a></li>
                 <?php }
               }  ?>
                 </ul>
        </div>
        <?php } ?>
     </div>
     <?php } ?>

     <?php if(count($documents) > 0) { ?>
     <!-- Document Results -->
     <div class="document-results">
        <?php foreach($documents as $document) { ?>
        <div class="result">
           <h6><?php echo $document->title ?></h6>

        </div>
        <?php } ?>
     </div>
     <?php } ?>
  </div>
<?php else : ?>
<div class="search_results container">
  <div class="result">
     <h6>Sorry, no search results were found for:</h6>
     <?php the_search_query(); ?>
  </div>
</div>
<?php endif; ?>
<?php get_footer(); ?>
