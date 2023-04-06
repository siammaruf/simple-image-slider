<?php
	$attributes = $args['attributes'] ?? [];
	if (isset($attributes['id'])):
	$slider_id = (int)$attributes['id'];
	$slides = get_post_meta($slider_id,"_kcs_slides", true);
	if ($slides):
?>
		<!-- hero-wrap-->
		<div class="hero-wrap fl-wrap full-height">
			<!--fs-slider-wrap -->
			<div class="fs-slider-wrap fs-slider-det full-height fl-wrap hero_fsw dark-bg">
				<div class="fs-slider full-height fl-wrap">
					<div class="swiper-container">
						<div class="swiper-wrapper" >
							<?php foreach ($slides as $key => $slide): ?>
								<!-- swiper-slide-->
								<div class="swiper-slide">
									<div class="fs-slider-item fl-wrap">
										<div class="bg"  data-bg="<?=esc_url($slide['imgLink'])?>" data-swiper-parallax="40%"></div>
										<div class="overlay"></div>
										<div class="grid-carousel-title">
											<h3><?=__($slide['title'],'kcs')?></h3>
											<div class="clearfix"></div>
											<h4><?=__($slide['subTitle'],'kcs')?></h4>
											<div class="bold-separator"><span></span></div>
											<?php if (isset($slide['btnText']) && isset($slide['btnLink'])): ?>
											<a href="#sec2" class="hero_btn custom-scroll-link">Scroll down to Discover<i class="fal fa-long-arrow-down"></i></a>
											<?php endif;?>
										</div>
									</div>
								</div>
								<!-- swiper-slide-->
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="hero-slider_btn hero-slider_btn_next fs-slider-button-next"><i class="fas fa-caret-right"></i></div>
				<div class="hero-slider_btn hero-slider_btn_prev fs-slider-button-prev"><i class="fas fa-caret-left"></i></div>
				<div class="hero-slider-wrap_pagination"></div>
			</div>
			<!--fs-slider-wrap end -->
			<div class="hero-dec_top"></div>
			<div class="hero-dec_bottom"></div>
			<div class="hero-dec_top_right"></div>
			<div class="hero-dec_bottom_right"></div>
			<div class="brush-dec"></div>
		</div>
		<!-- hero-wrap  end -->
	<?php else:?>
	<div class="slider-not-found">Looks like slides not found!</div>
<?php endif;?>
<?php else:?>
	<div class="slider-not-found">Invalid shortcode!</div>
<?php endif;?>

