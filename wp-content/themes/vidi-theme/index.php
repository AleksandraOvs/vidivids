<?php get_header() ?>
    
        <?php 
        if( is_404() ){
           ?>
            <section>
                <div class="container">
                <div class="e404-container">
                    <p class="e404">404</p>
                    <p class="e404-text">Sorry, this page does not exist :-(</p>
                    <a href="<?php echo get_home_url(); ?>" class="e404-text"> Go to Main page</a>
                </div>
                </div>
            </section>
           <?php
        }
        ?>
        <?php if(have_posts()) : 
        ?>
          <section class="blogs">
          <div class="container">
            <div class="blogs__title title">Blog</div>
            <div class="blogs__inner">
            <?php
              while(have_posts() ) : the_post(); ?>
              

            <?php get_template_part('entry');

            endwhile;
            ?>
            </div>
            <div class="pagination blogs__pagination">
   <?php echo custom_pagination(); ?>
</div>
    </div>
  </section>
  <?php
        endif;
            ?>
        
<?php get_footer() ?>