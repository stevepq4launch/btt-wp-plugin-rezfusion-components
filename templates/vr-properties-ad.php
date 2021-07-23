<?php

if ($lodgingItems) : ?>

<div class="properties-ad">
  <?php foreach ($lodgingItems as $item) : ?>

  <div class="properties-ad__card">
    <a href="<?php echo '/' . $item['slug'] . '/' . $item['url'] . '/'; ?>" class="properties-ad__link">
      <img src="<?php echo $item['image'] ?>" alt="<?php echo $item['alt'] ?>" class="properties-ad__image" />
      <?php if($includeDetails === true) : ?>
      <div class="properties-ad__details">
        <span class="properties-ad__beds"><i class="fas fa-bed"></i> <?php echo $item['beds']; ?><em class="bar">|</em></span>
        <span class="properties-ad__baths"><i class="fas fa-bath"></i> <?php echo $item['baths']; ?><em class="bar">|</em></span>
        <span class="properties-ad__sleeps"><i class="fas fa-users"></i> <?php echo $item['sleeps']; ?></span>
      </div>
      <?php endif; ?>
      <div class="properties-ad__body">
        <h4 class="properties-ad__name"><?php echo $item['name']; ?></h4>
      </div>
    </a>
  </div>

  <?php endforeach; ?>
</div>

<?php endif;