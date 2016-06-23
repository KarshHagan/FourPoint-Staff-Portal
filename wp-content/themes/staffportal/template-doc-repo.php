<?php
/**
 * Template Name: Document Repo
 */
global $theme;
get_header();
if ( have_posts() ) while ( have_posts() ) : the_post();
$quicklink_term = get_field('quicklink_term');
$post_type = get_field('associated_post_type');
$category_taxonomy = get_field('category_taxonomy');
?>
  <!-- section w/bg image, search, quick links box -->
  <section class="hero-main">
    <div class="container">
      <div class="search-left">
        <h1><?php the_title(); ?></h1>
        <h3>Search for a document or resource</h3>
        <form>SEARCH BOX GOES HERE</form>
      </div>
      <div class="quick-links shadow-border">
        <h3 class="blue-caps-headline">Quick Links</h3>
        <ul>
          <?php
          $quicklinks = get_posts(
            array(
              'post_type' => 'quick-link',
              'post_status' => 'publish',
            )
          );
          foreach($quicklinks as $quicklink) { ?>
              <li><a href="<?php the_field('url',$quicklink->ID) ?>"><?php echo $quicklink->post_title ?></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </section>

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
    <div class="container">
      <div class="box-left">
        <?php $links = get_field('links',$category); ?>
        <?php if($links && count($links) > 0) { ?>
        <div class="benefit-category-links">
        <?php foreach($links as $link) { ?>
          <div class="benefit-category-link">
            <div class="logo"><img src="<?php echo $link['logo'] ?>"></div>
            <a class="link" href="<?php echo $link['url'] ?>">Visit Site</a>
          </div>
        <?php } ?>
        </div>
        <?php
        } ?>
        <h2><?php echo $category->name ?></h2>
        <?php the_field('description',$category); ?>
      </div>
      <div class="border"></div>
      <div class="box-right">
          <?php $documents = get_posts(
            array(
              'post_type' => $post_type,
              'post_status' => 'publish',
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
            <h4 class="collapse-item-click"><?php echo $document->post_title ?><span>+</span></h4>
                <?php $document_files = get_field('document_files',$document->ID);
                if($document_files) { ?>
                  <ul class="collapsible-content">
                  <?php foreach($document_files as $document_file) { ?>
                      <li><a href="<?php the_field('file_path',$document_file->ID) ?>" target="_blank"><?php echo $document_file->post_title ?></a></li>
                  <?php }
                }  ?>
                  </ul>
          <?php } ?>
      </div>
    </div>
    <a href="#top" class="to-top">Back to top</a>
  </section>
  <?php } ?>
<?php endwhile;// end of the loop. ?>
<?php get_footer(); ?>
