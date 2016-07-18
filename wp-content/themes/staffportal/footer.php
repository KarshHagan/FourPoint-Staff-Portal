<?php
/**
 * Template for displaying the footer
 */?>
 <footer class="sp-footer">
  <div class="container">
    <div class="link-container">
      <h4>Benefits</h4>
      <ul>
      <?php
        if(!isset($benefit_categories)) {
          $benefit_categories = get_terms(array(
            'taxonomy' => 'benefit_category',
            'hide_empty' => false
          ));
        }
      foreach($benefit_categories as $category) {
      ?>
      <li><a href="/employee-benefits#<?php echo $category->slug ?>"><?php echo $category->name ?></a></li>
      <?php } ?>
      </ul>
    </div>

    <div class="link-container">
      <h4>Documents &amp; Forms</h4>
      <ul>
        <?php
          if(!isset($document_categories)) {
            $document_categories = get_terms(array(
              'taxonomy' => 'document_category',
              'hide_empty' => false
            ));
          }
          foreach($document_categories as $document_category) { ?>
          <li><a href="/documents-forms#<?php echo $document_category->slug ?>"><?php echo $document_category->name ?></a></li>
        <?php
          }
        ?>
      </ul>
    </div>

    <div class="link-container">
      <h4>Brand Center</h4>
      <ul>
        <?php
        if(!isset($brand_categories)) {
          $brand_categories = get_terms(array(
            'taxonomy' => 'brand_category',
            'hide_empty' => false
          ));
        }
        foreach($brand_categories as $brand_category) {
        ?>
        <li><a href="/brand-center/#<?php echo $brand_category->slug ?>"><?php echo $brand_category->name ?></a></li>
        <?php } ?>
      </ul>
    </div>

    <div class="link-container">
      <h4>Quick Links</h4>
      <ul>
<?php
        if(!isset($quicklinks)) {
          $quicklinks = get_posts(
            array(
              'post_type' => 'quick-link',
              'post_status' => 'publish',
            )
          );
        }
        foreach($quicklinks as $quicklink) { ?>
            <li><a href="<?php the_field('url',$quicklink->ID) ?>"><?php echo $quicklink->post_title ?></a></li>
        <?php
        }
?>
      </ul>
    </div>
  </div>
 </footer>
 <?php wp_footer(); ?>
</body>
</html>
