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
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
          <li><a href="#">Fidelity Time</a></li>
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
  <section class="box">
    <div class="container">
      <div class="box-left">

        <li><a href="#<?php echo $category->slug ?>"><?php echo $category->name ?></a></li>

        <h2><?php echo $category->name ?></h2>
        <?php the_field('description',$category->term_id) ?>
        <p>Seitan everyday carry stumptown, schlitz beard selvage biodiesel. YOLO gochujang distillery four dollar toast pinterest. XOXO kitsch post-ironic, franzen craft beer pug iPhone four dollar toast paleo try-hard godard typewriter fingerstache. Banh mi distillery locavore, neutra thundercats asymmetrical ennui lumbersexual cronut. Tilde typewriter trust fund vinyl, hammock pinterest tousled flannel hashtag church-key messenger bag cred vegan readymade bespoke. Kogi hella waistcoat chicharrones</p>
      </div>
      <div class="box-right">
        <ul>
          <?php $benefits = get_posts(
            array(
              'tax_query' => array(
                array(
                  'taxonomy' => 'benefit_category',
                  'terms' => $category->slug,
                  'field' => 'slug'
                )
              )
            )
          );
          var_dump($benefits);
          foreach($benefits as $benefit) { ?>
              <!-- <li><span><?php echo $benefit->name ?></span>
                <?php $documents = get_field('documents',$benefit->ID);
                if($documents) {
                  foreach($documents as $document) { ?>
                      <a href="#"><?php echo $document->post_name ?></a>
                  <?php }
                }  ?>
                <a href="#">Open Enrollment</a>
              </li> -->
          <?php } ?>
          <!-- <li><span>Employee Benefits Employee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee BenefitsEmployee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li> -->
        </ul>
      </div>
    </div>
    <a href="#top" class="to-top">Back to top</a>
  </section>
  <?php
  } ?>
  <section class="box box-blue">
    <div class="container">
      <div class="box-left">
        <h2>Open Enrollment</h2>
        <p>Seitan everyday carry stumptown, schlitz beard selvage biodiesel. YOLO gochujang distillery four dollar toast pinterest. XOXO kitsch post-ironic, franzen craft beer pug iPhone four dollar toast paleo try-hard godard typewriter fingerstache. Banh mi distillery locavore, neutra thundercats asymmetrical ennui lumbersexual cronut. Tilde typewriter trust fund vinyl, hammock pinterest tousled flannel hashtag church-key messenger bag cred vegan readymade bespoke. Kogi hella waistcoat chicharrones</p>
      </div>
      <div class="box-right">
        <ul>
          <li><span>Employee Benefits Employee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee BenefitsEmployee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li>
        </ul>
      </div>
    </div>
    <a href="#top" class="to-top">Back to top</a>
  </section>


  <section class="box">
    <div class="container">
      <div class="box-left">
        <h2>Open Enrollment</h2>
        <p>Seitan everyday carry stumptown, schlitz beard selvage biodiesel. YOLO gochujang distillery four dollar toast pinterest. XOXO kitsch post-ironic, franzen craft beer pug iPhone four dollar toast paleo try-hard godard typewriter fingerstache. Banh mi distillery locavore, neutra thundercats asymmetrical ennui lumbersexual cronut. Tilde typewriter trust fund vinyl, hammock pinterest tousled flannel hashtag church-key messenger bag cred vegan readymade bespoke. Kogi hella waistcoat chicharrones</p>
      </div>
      <div class="box-right">
        <ul>
          <li><span>Employee Benefits Employee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li>
          <li><span>Employee BenefitsEmployee Benefits Employee Benefits Employee Benefits</span><a href="#">Open Enrollment Open Enrollment</a></li>
          <li><span>Employee Benefits</span><a href="#">Open Enrollment</a></li>
        </ul>
      </div>
    </div>
    <a href="#top" class="to-top">Back to top</a>
  </section>
<?php get_footer(); ?>
