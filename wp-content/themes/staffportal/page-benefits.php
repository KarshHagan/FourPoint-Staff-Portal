<?php
/**
 * Template for displaying the benefits page
 */
global $theme;
get_header(); ?>
  <div class="anchor-links">
    <ul>
      <?php $categories = get_terms(array(
        'taxonomy' => 'benefit_category',
        'hide_empty' => false
      ));
      foreach($categories as $category) {
      ?>
      <li><a href="#<?php echo $category->slug ?>"><?php echo $category->name ?></a></li>
      <?php } ?>
    </ul>
  </div>

  <!-- boxed sections -->
  <?php
  foreach($categories as $category) {
  ?>
  <a name="<?php echo $category->slug ?>"></a>
  <section class="box <?php the_field('background_color',$category) ?>">
    <div class="container">
      <div class="box-left">
        <?php $links = get_field('benefit_links',$category); ?>
        <?php if(count($links) > 0) { ?>
        <div class="benefit_category_link">
        <?php foreach($links as $link) { ?>
          <div class="logo"><img src="<?php the_field('logo',$link->ID) ?>"></div>
          <a class="link" href="<?php the_field('url',$link->ID) ?>">Visit Site &rdquo;</a>
        <?php } ?>
        </div>
        <?php
        } ?>
        <h2><?php echo $category->name ?></h2>
        <?php the_field('description',$category); ?>
      </div>
      <div class="border"></div>
      <div class="box-right">
        <ul>
          <?php $benefits = get_posts(
            array(
              'post_type' => 'benefit',
              'post_status' => 'publish',
              'tax_query' => array(
                array(
                  'taxonomy' => 'benefit_category',
                  'terms' => $category->slug,
                  'field' => 'slug'
                )
              )
            )
          );
          foreach($documents as $document) { ?>
              <li>
                <div class="benefit-title">
                  <?php echo $document->post_title ?>
                </div>
                <div class="benefit-documents">
                <?php $document_files = get_field('benefit_documents',$document->ID);
                if($document_files) {
                  foreach($document_files as $document_file) { ?>
                      <a href="<?php the_field('document_file',$document_file->ID) ?>" target="_blank"><?php echo $document_file->post_title ?></a>
                  <?php }
                }  ?>
                </div>
              </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <a href="#top" class="to-top">Back to top</a>
  </section>
  <?php } ?>
<?php get_footer(); ?>
