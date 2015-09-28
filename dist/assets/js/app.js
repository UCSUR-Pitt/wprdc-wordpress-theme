Foundation.global.namespace = '';
jQuery(document).foundation();
jQuery('form.newsletter').on('valid.fndtn.abide', function() {
    var form = jQuery(this);
    jQuery.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize() + '&action=newsletter_register',
        dataType: 'json',
        cache: false,
        success: function(res) {
            jQuery('#ModalTitle').html(res.title);
            jQuery('#ModalLead').html(res.lead);
            jQuery('#ModalText').html(res.text);
            jQuery('#alertModal').addClass('small').foundation('reveal', 'open');
        }
    });
});