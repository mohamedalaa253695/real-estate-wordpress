<?php
global $post;
$property = $post;
?>
<div class="header-info clearfix">
    <div class="container">
        <div class="header-right pull-right">
            <div class="clearfix top-social">
                <div class="pull-right favorite">
                    <?php if ( class_exists('Homesweet_Realia_Favorite') ) {
                        Homesweet_Realia_Favorite::btn_display();
                    }
                    ?>
                </div>
                <!-- share -->
                <div class="property-box-share pull-right">
                    <a href="#share-box" class="share-box" title="<?php echo esc_html__( 'Share', 'homesweet' ); ?>">
                        <i class="icon-ap_share"></i>
                        <span class="title"><?php echo esc_html__('Share','homesweet') ?></span>
                    </a>
                    <div class="property-box-share-content">
                        <?php get_template_part( 'page-templates/parts/sharebox-property' ); ?>
                    </div>
                </div>
                <div class="pull-right">
                <?php
                if ( class_exists('Homesweet_Realia_Compare') ) {
                    Homesweet_Realia_Compare::display_compare_btn( $property->ID );
                }
                ?>
                </div>
            </div>
            <div class="text-right price">
                <?php homesweet_realia_display_price($property); ?>
            </div>
        </div>
    	<div class="header-left pull-left">
    		<!-- breadscrumb -->
            <?php homesweet_property_breadcrumbs(); ?>
            <div class="header-line">
    		  <?php the_title( '<h1 class="entry-title property-title">', '</h1>' ); ?>
              <?php homesweet_realia_display_labels($property); ?>
            </div>
    		<?php homesweet_realia_display_address($property); ?>

    	</div>
    </div>
</div>