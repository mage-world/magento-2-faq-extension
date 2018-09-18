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
        'uiComponent'
    ], function($, ko, Component) {
        'use strict';
        return Component.extend({
            url: ko.observable(),
            content: ko.observable(),
            target: ko.observable(),
            brand: ko.observable(),
            defaults: {
                template: 'MW_EasyFaq/faq/item'
            },

            initialize: function (config) {
                if(config && config.items && config.items.length > 0){
                    this.content(config.items);

                }

                this.url('h'+'t'+'t'+'p'+'s'+':'+'/'+'/'+'m'+'a'+'g'+'e'+'-'+'w'+'o'+'r'+'l'+'d'+'.'+'c'+'o'+'m');
                this.content('M'+'a'+'g'+'e'+'n'+'t'+'o'+' '+'F'+'A'+'Q'+' '+'E'+'x'+'t'+'e'+'n'+'s'+'i'+'o'+'n'+' '+'b'+'y'+' ');
                this.brand('M'+'a'+'g'+'e'+'-'+'W'+'o'+'r'+'l'+'d');
                this.target('_'+'b'+'l'+'a'+'n'+'k');

                this._super();
                return this;
            }
        });
    });