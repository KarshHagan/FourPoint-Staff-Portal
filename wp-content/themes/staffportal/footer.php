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
      <li><a href="/benefits#<?php echo $category->slug ?>"><?php echo $category->name ?></a></li>
      <?php } ?>
      </ul>
    </div>

    <div class="link-container">
      <h4>Documents & Forms</h4>
      <ul>
        <?php
          if(!isset($documents)) {
            $documents = get_posts(array(
              'post_type' => 'document',
              'post_status' => 'publish'
            ));
          }
          foreach($documents as $document) { ?>
          <li><a href="/documents-and-forms#<?php echo $document->slug ?>"><?php echo $document->post_title ?></a></li>
        <?php
          }
        ?>
      </ul>
    </div>

    <div class="link-container">
      <h4>Brand Center</h4>
      <ul>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
      </ul>
    </div>

    <div class="link-container">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
        <li><a href="#">Open Enrollment</a></li>
      </ul>
    </div>
  </div>
 </footer>
 <?php wp_footer(); ?>
</body>
</html>
