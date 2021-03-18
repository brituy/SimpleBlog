define(['underscore', 'jquery', 'Magento_Ui/js/modal/modal-component', 'mage/url'], function (_, $, Modal, url) 
{
    'use strict';

    return Modal.extend(
    {
        saveData: function () 
        {
		debugger;

            var ajaxUrl = url.build('adminhtml/category/save');

            var data = {
                'form_key': window.FORM_KEY,
                'data' : this.applied
            };

            $.ajax(
            {
                type: 'POST',
                url: ajaxUrl,
                data: data,
                showLoader: true
            }).done(function (xhr) 
            {
                if (xhr.error) 
                {
                    self.onError(xhr);
                }
            }).fail(this.onError);

            this.closeModal();
        }
    });
});
