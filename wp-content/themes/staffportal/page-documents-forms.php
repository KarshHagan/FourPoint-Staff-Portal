<?php
/**
 * Template for displaying the benefits page
 */
global $theme;
get_header(); ?>
  <!-- section w/bg image, search, quick links box -->
  <section class="hero-main">
    <div class="container">
      <div class="search-left">
        <h1>Employee Benefits</h1>
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
              'tax_query' => array(
                array(
                  'taxonomy' => 'category',
                  'terms' => 'benefit-quicklinks',
                  'field' => 'slug'
                )
              )
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
      <?php $benefit_categories = get_terms(array(
        'taxonomy' => 'benefit_category',
        'hide_empty' => false
      ));
      foreach($benefit_categories as $category) {
      ?>
      <li><a href="#<?php echo $category->slug ?>"><?php echo $category->name ?></a></li>
      <?php } ?>
    </ul>
  </div>

  <!-- boxed sections -->
  <?php
  foreach($benefit_categories as $category) {
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
          foreach($benefits as $benefit) { ?>
              <li>
                <div class="benefit-title">
                  <?php echo $benefit->post_title ?>
                </div>
                <div class="benefit-documents">
                <?php $documents = get_field('benefit_documents',$benefit->ID);
                if($documents) {
                  foreach($documents as $document) { ?>
                      <a href="<?php the_field('document_file',$document->ID) ?>" target="_blank"><?php echo $document->post_title ?></a>
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
