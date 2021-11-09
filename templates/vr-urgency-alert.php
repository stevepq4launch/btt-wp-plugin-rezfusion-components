<div class="rezfusion-urgency-alert">
    <?php if ($visitorsCount >= $visitorDisplayThreshold) : ?>
    <div>
        <?php if (!empty($highlightedText)) : ?>
        <span class="rezfusion-urgency-alert__highlighted"><?php echo $highlightedText; ?></span>
        <?php endif; ?>
        <span class="rezfusion-urgency-alert__recently-viewed"><?php echo $urgencyText; ?></span>
    </div>
    <?php endif; ?>
</div>