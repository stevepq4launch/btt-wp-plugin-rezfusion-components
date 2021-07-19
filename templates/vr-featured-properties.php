<?php if (count($properties)) : ?>
	<section class="featured-properties">
		<div class="featured-properties__container">
			<div class="featured-properties__wrap slider flex-row">
				<?php foreach ($properties as $property) : ?>
					<article class="featured-properties__card flex-row flex-xs-12 flex-sm-6 flex-md-4 flex-xs-center">
						<a href="<?php echo $property['url']; ?>" class="featured-properties__link flex-row flex-xs-center">
							<figure class="featured-properties__image">
								<img src="<?php echo $property['image_url']; ?>" alt="<?php echo $property['image_title'] || $property['image_description']; ?>">
							</figure>
							<div class="featured-properties__name flex-row flex-xs-center">
								<h4><?php echo $property['name']; ?></h4>
							</div>
							<div class="featured-properties__details">
								<?php echo $propertyDetailsPartial->render([
									'baths' => $property['baths'],
									'beds' => $property['beds'],
									'sleeps' => $property['sleeps'],
									'useIcons' => $useIcons,
									'bathsLabel' => $bathsLabel,
									'bedsLabel' => $bedsLabel,
									'sleepsLabel' => $sleepsLabel,
								]);
								?>
							</div>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>