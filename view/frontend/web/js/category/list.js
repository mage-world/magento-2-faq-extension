/*
 * Mage-World
 *
 *  @category    Mage-World
 *  @package     MW
 *  @author      Mage-world Developer
 *
 *  @copyright   Copyright (c) 2018 Mage-World (https://www.mage-world.com/)
 */

define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'MW_EasyFaq/js/faq/grid'
    ], function($, ko, Component, Faq) {
        'use strict';
        return Component.extend({
            items: ko.observableArray(),
            getFaqUrl: ko.observable(),
            isAjaxPageType: ko.observable(),
            defaults: {
                template: 'MW_EasyFaq/category/list'
            },

            initialize: function (config) {
                if(config && config.categories && config.categories.length > 0){
                    this.items(config.categories);
                }

                if(config && config.get_faq_url){
                    this.getFaqUrl(config.get_faq_url);
                }

                if(config && config.is_ajax_type){
                    this.isAjaxPageType(config.is_ajax_type);
                }

                if(!this.isAjaxPageType()){
                    
                }

                this._super();

                return this;
            },

            firstItemSelected: function(){
                $('.faq-category-list .faq-category-item').first().click();
            },

            categorySelected: function (category, event) {
                if($(event.target).hasClass('selected')){
                    return false;
                }
                $('.faq-category-item').removeClass('selected');
                $(event.target).addClass('selected');
                var categoryId = category.category_id;

                if(!this.isAjaxPageType()){
                    let target = '#category-container-'+categoryId;
                    $('html,body').stop().animate({
                        scrollTop: $(target).offset().top - 15
                    }, 1000);
                    event.preventDefault();
                    return false;
                }

                $('.loading-mask').show();
                $.get(this.getFaqUrl()+'category_id/'+categoryId, function(res){
                    var res = JSON.parse(res);
                    Faq().setItems(res);
                    $('.loading-mask').hide();
                });
            }
        });

        function repositionProductInfoDiv(){
            var mainContainer = jQuery('.columns');
            
            var productInfoContainer = jQuery('.faq-category-container');
            var productShotsContainer = jQuery('.column.main');
            var scrollPosition = jQuery(window).scrollTop();
            var topPosition = (mainContainer.height() - productInfoContainer.height());
          
            if (productShotsContainer.height() > productInfoContainer.height()) {
                if (scrollPosition >= (mainContainer.offset().top + (mainContainer.height() - productInfoContainer.height()))) { //  || ((productInfoContainer.offset().top + productInfoContainer.height())>(productShotsContainer.offset().top + productShotsContainer.height()))
                    productInfoContainer.css('position', 'relative').css('top', topPosition).css('left', '0px').css('width', '');
                } else if (scrollPosition > (mainContainer.offset().top)){
                    var leftOffset = productShotsContainer.offset().left + productShotsContainer.width() + 20;
                    var calculatedWidth = (mainContainer.width() * (5/12))
                    productInfoContainer.css('position', 'fixed').css('top', '10px').css('left', leftOffset).css('width', calculatedWidth).css('background-color', 'white'); //
                } else {
                    productInfoContainer.css('position', 'relative').css('top', '0px').css('left', '0px').css('width', '');
                }
            } else {
                if (scrollPosition > (productShotsContainer.offset().top)) {
                    productInfoContainer.css('position', 'relative').css('top', topPosition).css('left', '0px').css('width', '');
                } else {
                    productInfoContainer.css('position', 'relative').css('top', '0px').css('left', '0px').css('width', '');
                }
            }
        }

        jQuery(window).scroll(function(){
            if (jQuery(window).innerWidth() >= 768) {
                repositionProductInfoDiv();
            } else {
                jQuery('.faq-category-container').css('position', 'relative').css('top', '0px').css('left', '0px');
            }
        });

        jQuery('.faq-list').resize(function(){
            if (jQuery(window).innerWidth() >= 768) {
                repositionProductInfoDiv();
            } else {
                jQuery('.faq-category-container').css('position', 'relative').css('top', '0px').css('left', '0px');
            }
        });

        jQuery('.faq-item-question').on('click', function (){
            if (jQuery(window).innerWidth() >= 768) {
                setTimeout(function(){
                    repositionProductInfoDiv();
                }, 300);
            } else {
                jQuery('.faq-category-container').css('position', 'relative').css('top', '0px').css('left', '0px');
            }
        })
    });