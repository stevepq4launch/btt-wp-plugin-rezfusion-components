<div class="property-details flex-row flex-xs-center">
    <span class="property-details__beds"><?php if($useIcons === true) : ?><i class="fas fa-bed"></i><?php else : echo $bedsLabel; endif; ?> <?php echo $beds; ?><em class="bar">|</em></span>
    <span class="property-details__baths"><?php if($useIcons === true) : ?><i class="fas fa-bath"></i><?php else : echo $bathsLabel; endif; ?> <?php echo $baths; ?><em class="bar">|</em></span>
    <span class="property-details__sleeps"><?php if($useIcons === true) : ?><i class="fas fa-users"></i><?php else : echo $sleepsLabel; endif; ?> <?php echo $sleeps; ?></span>
</div>