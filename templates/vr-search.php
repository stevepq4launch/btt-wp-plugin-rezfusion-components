<?php
/**
 * @file Mount point for SearchPage (`[rezfusion-search]` shortcode)
 */
?>
<div id="app"></div>
<script>
(function(){
    window.addEventListener('load', function(){
        let promoCodePropertiesIds = <?php echo json_encode($promoCodePropertiesIds); ?>;
        let promoCodeText = '<?php echo $promoCodeFlagText; ?>';
        (promoCodePropertiesIds.length && typeof propertyCardFlag !== 'undefined') && propertyCardFlag(document.getElementById('app'), promoCodePropertiesIds, promoCodeText);
    });
})();
</script>