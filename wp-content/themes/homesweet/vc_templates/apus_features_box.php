<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$items = (array) vc_param_group_parse_atts( $items );
if ( !empty($items) ):
$count = 0;
?>
	<div class="widget widget-features-box <?php echo esc_attr($el_class); ?> <?php echo esc_attr($style); ?>">
		<?php if ($title!=''): ?>
        <h3 class="widget-title">
            <span><?php echo esc_attr( $title ); ?></span>
	    </h3>
	    <?php endif; ?>
		<div class="content">
			<div class="row">
				<?php foreach ($items as $item): ?>
					<?php if ( isset($item['image']) && $item['image'] ) $image_bg = wp_get_attachment_image_src($item['image'],'full'); ?>
					<?php if ( isset($item['image_hover']) && $item['image_hover'] ) $image_bg_hover = wp_get_attachment_image_src($item['image_hover'],'full'); ?>
					<div class="col-xs-12 col-sm-<?php echo 12/$number; ?>">
						<div class="feature-box">
							<div class="feature-box-inner">
								<div class="fbox-icon">
									<div class="icon-inner <?php if(!empty($image_bg_hover)) echo 'has-hover'; ?>">
										<?php if(isset( $image_bg[0]) && $image_bg[0] ) { ?>
												<img class="img" src="<?php echo esc_url_raw($image_bg[0]); ?>" alt="">
										<?php }elseif (isset($item['icon']) && $item['icon']) { ?>
									        	<div class="inner">
									            	<i class="<?php echo esc_attr($item['icon']); ?>"></i>
									            </div>
									    <?php } ?>
									    <?php if(isset( $image_bg_hover[0]) && $image_bg_hover[0] ) { ?>
									    	<div class="img-hover">
												<img src="<?php echo esc_url_raw($image_bg_hover[0]); ?>" alt="">
											</div>
										<?php } ?>
									</div>
								</div>
							    <div class="fbox-content ">  
							    	<?php if (isset($item['title']) && trim($item['title'])!='') { ?>
							            <h3 class="ourservice-heading"><?php echo trim($item['title']); ?></h3>
							        <?php } ?>
							         <?php if (isset($item['description']) && trim($item['description'])!='') { ?>
							            <div class="description"><?php echo trim( $item['description'] );?></div>  
							        <?php } ?>
							        <?php if(isset($item['button_link']) && $item['button_link'] && isset($item['button_text']) && $item['button_text'] ){ ?>
									    <div class="clearfix">
									    	<a class="readmore" href="<?php echo esc_attr($item['button_link']); ?>" ><?php echo trim($item['button_text']); ?> </a>
									    </div>
								    <?php } ?>
							    </div> 
						    </div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>