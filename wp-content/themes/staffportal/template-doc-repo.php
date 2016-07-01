<?php
/**
 * Template Name: Document Repo
 */
global $theme;
get_header();
if ( have_posts() ) while ( have_posts() ) : the_post();
$post_type = get_field('associated_post_type');
$category_taxonomy = get_field('category_taxonomy');
?>
  <div class="anchor-links">
    <ul>
      <?php $categories = get_terms(array(
        'taxonomy' => $category_taxonomy,
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
    <div class="container shadow-border">
      <div class="box-left">
        <h2><?php echo $category->name ?></h2>
        <?php $links = get_field('links',$category); ?>
        <?php if($links && count($links) > 0) { ?>
        <div class="benefit-category-links">
        <?php foreach($links as $link) { ?>
          <div class="benefit-category-link">
            <a class="link" target="_blank" href="<?php echo $link['url'] ?>">
              <img src="<?php echo $link['logo'] ?>">
              <span class="visit">Visit Site</span>
            </a>
          </div>
        <?php } ?>
        </div>
        <?php
        } ?>
        <?php the_field('description',$category); ?>

      </div>
      <div class="border"></div>
      <div class="box-right">
          <?php $documents = get_posts(
            array(
              'post_type' => $post_type,
              'post_status' => 'publish',
              'orderby' => 'menu_order',
              'order' => 'ASC',
              'tax_query' => array(
                array(
                  'taxonomy' => $category_taxonomy,
                  'terms' => $category->slug,
                  'field' => 'slug'
                )
              )
            )
          );
          foreach($documents as $document) { ?>
            <h4 class="collapse-item-click"><?php echo $document->post_title ?><span class="plus-minus"></span></h4>
                <?php $document_files = get_field('document_files',$document->ID);
                if($document_files) { ?>
                  <ul class="collapsible-content">
                  <?php foreach($document_files as $document_file) { ?>
                      <li><a href="<?php the_field('file_path',$document_file->ID) ?>" class="document-file" data-documentid="<?php echo $document_file->ID ?>" data-userid="<?php echo $current_user->ID ?>" target="_blank"><?php echo $document_file->post_title ?></a></li>
                  <?php }
                }  ?>
                  </ul>
          <?php } ?>
      </div>
    </div>
    <a href="#top" class="to-top text-arrow-link">Back to top</a>
  </section>
  <?php } ?>
<?php endwhile;// end of the loop. ?>
<?php get_footer(); ?>
