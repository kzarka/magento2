/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    "jquery",
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'mage/translate',
    "jquery/ui"
], function ($, Component, customerData) {
    'use strict';

    $(document).on('click', '.authentication-wrapper',function(){
        var object = customerData.get('notifications');
        var unread = parseInt(object().count);
        console.log(unread);
        customerData.reload('notifications');
        if(unread && $(".authentication-dropdown").hasClass("_show"))
        {
            seen();
            setTimeout(customerData.reload('notifications'), 5000);
        }
        
    });

    function seen()
    {
        $.ajax({
            url: '/magento2/blog/notification/seen',
            type: 'POST'
        }).done(function(data){
            console.log(data);            
        });
    }

    return Component.extend({
        initialize: function () {
            this._super();
            this.loadNotifications = customerData.get('notifications');
        }
    });
});