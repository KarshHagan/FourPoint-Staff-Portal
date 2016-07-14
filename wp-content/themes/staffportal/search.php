<?php
/*
Search Page
*/
global $theme;
get_header();
$search = get_search_query();
//  Searching Employees
$args = array(
 'count_total' => false,
 'search' => sprintf( '*%s*', $search ),
 'search_fields' => array(
   'display_name',
   'user_login',
 ),
 // 'fields' => 'ID',
);
$employees = get_users( $args );
?>
<?php if ( have_posts() || count($employees) > 0) :
   $benefits = [];
   $documents = [];
   $brand_documents = [];
   $offices = [];
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
         case 'office':
            array_push($offices,$post);
            break;
     }
   endwhile;
   ?>
  <div class="search_results container">
     <div class="result">
        <h2>Results for:</h2>
        <p><?php the_search_query(); ?></p>
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
     <!-- Benefit Results -->
     <div class="document-results">
        <?php foreach($documents as $document) { ?>
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

     <?php if(count($brand_documents) > 0) { ?>
     <!-- Benefit Results -->
     <div class="brand_documents-results">
        <?php foreach($brand_documents as $document) { ?>
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

     <?php if(count($tickets) > 0) { ?>
       <div class="copy_split it-items">
       <?php foreach($tickets as $ticket) { ?>
         <div class="side-content result">
         <!-- the other type will be data-type="guide"-->
           <aside>
             <p><?php the_title(); ?>
             <p class="ticket-details">
               <?php the_field('ticket_date',$ticket->ID) ?></p>
           </aside>
           <article><p><?php the_excerpt(); ?></p>
             <a href="<?php echo get_permalink($ticket->ID); ?>">Learn More</a>
           </article>
         </div>
       <?php } ?>
     </div>
     <?php }
     if(count($employees) > 0) {
     ?>
    <ul class="employee-results">
      <?php
      foreach($employees as $employee) {
        $user_title = get_field('title','user_'.$employee->ID);
        $outside_dial = get_field('outside_dial','user_'.$employee->ID);
        $extension = get_field('extension','user_'.$employee->ID);
        $mobile_number = get_field('mobile_number','user_'.$employee->ID);
        $conf_call_id = get_field('conf_call_id','user_'.$employee->ID);
        $profile_photo = get_field('profile_photo','user_'.$employee->ID);
        $last_name_category = $theme->get_last_name_filer($employee->last_name);
        // $offices = get_field('employee_office','user_'.$employee->ID);
        $offices = wp_get_object_terms( $employee->ID, 'office' );
        if( count($offices) > 0 ) {
          $office = $offices[0];
          $office_name = $office->name;
          $office_slug = $office->slug;
        } else {
          $office_name = '&nbsp;';
          $office_slug = '';
        }
      ?>
      <li class="employee-bio-container" data-office="<?php echo $office_slug ?>" data-name="<?php echo $last_name_category ?>">
        <div class="employee-bio">
          <div class="front shadow-border">
            <img class="profile-img" src="<?php echo $profile_photo['sizes']['thumbnail'] ?>">
            <h2><?php echo $employee->display_name ?></h2>
            <h3><?php echo $user_title ?></h3>
            <p class="office"><?php echo $office_name ?></p>
            <ul class="contact-info">
              <li class="email-addr">Email: <span><?php echo $employee->user_email ?></span></li>
              <li>Direct Line: <span><?php echo $outside_dial ?></span></li>
              <li>Ext: <span><?php echo $extension ?></span></li>
              <li>Mobile: <span><?php echo $mobile_number ?></span></li>
            </ul>
            <a href="#" class="more-flip">More</a>
          </div>

          <div class="back shadow-border">
            <img class="profile-img" src="<?php echo $profile_photo['sizes']['thumbnail'] ?>">
            <div class="inner">
              <p><?php echo $employee->description ?></p>
            </div>
            <a href="#" class="more-flip">Less</a>
          </div>

        </div>
      </li>
      <?php } ?>
    </ul>
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
