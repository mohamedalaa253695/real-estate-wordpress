<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$args = array(
	'post_type' => 'apus_testimonial',
	'posts_per_page' => $number,
	'post_status' => 'publish',
);
$loop = new WP_Query($args);

?>
<div class="widget-testimonials <?php echo esc_attr($el_class.' '.$style); ?>">
	<?php if ($title!=''): ?>
        <h3 class="widget-title">
            <span><?php echo esc_attr( $title ); ?></span>
        </h3>
    <?php endif; ?>
	<?php if ( $loop->have_posts() ): ?>
        <div class="testimonial-wrapper" data-testimonial="content">
            <div class="owl-carousel-wrapper">
        		<div class="owl-carousel" data-items="<?php echo esc_attr($columns); ?>" data-carousel="owl" data-smallmedium="1" data-extrasmall="1" <?php if($style == 'bg-white') {echo 'data-pagination="false" data-nav="true"';}else{ echo 'data-pagination="true" data-nav="false"';}  ?> <?php echo trim($loop->post_count > 1 ? 'data-loop="true"' : ''); ?>>
                    <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                        <?php get_template_part( 'vc_templates/testimonial/testimonial-v1' ); ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
	<?php endif; ?>
</div>
<?php wp_reset_postdata(); ?>