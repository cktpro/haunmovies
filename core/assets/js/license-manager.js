var $ = jQuery.noConflict();
$(document).ready( function()
{
    $('.expand-act-box').click( function() {

        var collapse_content_selector = $(this).attr('id');
        var toggle_switch = $(this);
        $(collapse_content_selector).toggle( function() {
            if($(this).css('display')=='none') {
                toggle_switch.html('<i class="dashicons dashicons-unlock"></i> '+toggle_switch.text());
            } else {
                toggle_switch.html('<i class="dashicons dashicons-dismiss"></i> '+toggle_switch.text());
            }
            $('html, body').animate({
                scrollTop: $(collapse_content_selector).offset().top - 100
            }, 500);
        });
    });


    $('#update-license').click( () => {
        $('#update-license').text('Updating...')
        var action = $('#update-license').data('action')
        $.ajax({
            type: 'POST',
            url: halim_license.ajax_url,
            dataType: 'json',
            data: {
                action: action
            },
            success: (res) => {
                console.log(res);
                $('#update-license').text('Update License')
                $('.license-msg').show().text(res).css('color', 'red')
            }
        });
    });

    $('#activate-license').click( () => {
        var license_key = $('input[name="license_key"]').val(),
            action = $('#activate-license').data('action')

        if(!license_key) {
            alert('Please enter license code')
            return
        }
        $('#activate-license').text('Activating...')
        $.ajax({
            type: 'POST',
            url: halim_license.ajax_url,
            dataType: 'json',
            data: {
                action: action,
                license_key: license_key
            },
            success: (res) => {
                $('#activate-status').show().text(res.message)
                if(res.status) {
                    $('#activate-license').text('Activated')
                    $('.license_status').removeClass('license_invalid')
                    $('.license_invalid i').addClass('dashicons-yes-alt').removeClass('dashicons-dismiss')
                    $('.license_status .txt').text('Your license is valid')
                    setTimeout( () => {
                        window.location.reload();
                    }, 1200)
                }
                 else {
                    $('#activate-license').text('Activate License')
                }
            }
        });
    });

    $('#deactivate-license').click( () => {
        $('#deactivate-license').text('Deactivating...')
        var action = $('#deactivate-license').data('action')
        $.ajax({
            type: 'POST',
            url: halim_license.ajax_url,
            dataType: 'json',
            data: {
                action: action
            },
            success: (res) => {
                if(res.status) {
                    $('#deactivate-license').text('Deactivated')
                    $('#deactivate-status').show().text(res.message)
                    $('.license_status').addClass('license_invalid')
                    $('.license_invalid i').removeClass('dashicons-yes-alt').addClass('dashicons-dismiss')
                    $('.license_status .txt').text('Your license is invalid')
                    setTimeout( () => {
                        window.location.reload();
                    }, 1200)
                } else {

                }
            }
        });
    });

});

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}
