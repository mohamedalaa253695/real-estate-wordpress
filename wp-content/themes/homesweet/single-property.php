<?php

get_header();

?>

<section id="main-container" class="main-content-property inner">
    <div id="main-content">
        <div id="primary" class="content-area">
            <div id="content" class="site-content single-property" role="main">
                <?php
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        echo Realia_Template_Loader::load('content-property');
                    // End the loop.
                    endwhile;
                ?>
            </div><!-- #content -->
        </div><!-- #primary -->
    </div>
</section>
<?php get_footer(); ?>