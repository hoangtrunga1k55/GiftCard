define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils'
    ],
    function ($,Component,quote, totals, priceUtils) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Mageplaza_GiftCard/checkout/summary/customdiscount'
            },
            isDisplayedCustomdiscount : function(){
                var price = totals.getSegment('custom_discount').value;
                if(price < 0){
                    return true;
                }
                return false;
            },
            getCustomDiscount : function(){
                var price = totals.getSegment('custom_discount').value;
                return this.getFormattedPrice(price);
            }
        });
    }
);
