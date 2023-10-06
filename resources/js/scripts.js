$('#tab1-select').change((e) => {
    // Get the selected option value
    let selectedOption = $(e.currentTarget).val();

    $.ajax({
        url: '/super-admin/entities-select',
        method: 'GET',
        complete: function (data) {
            let jsonObject = JSON.parse(data.responseText)

            let $select = $('<select>').addClass('bulk-select entity-select mt-2');

            // Add name attribute to the select element
            $select.attr('name', 'entity-id');

            if (selectedOption === 'change-entity') {
                for (let x = 0; x < jsonObject.length; x++) {
                    let $option = $('<option>').text(jsonObject[x]['name']).val(jsonObject[x]['id']);
                    $select.append($option);
                }

                $(e.currentTarget).after($select);
            } else {
                $('.entity-select').remove();
            }

            if (selectedOption === 'change-status') {
                let $option = $('<option>').text('Activate').val(1);
                let $option2 = $('<option>').text('Deactivate').val(0);

                let $select2 = $('<select>').addClass('bulk-select status-select mt-2');
                $select2.attr({
                    'name': 'user-status'
                })
                $select2.append($option, $option2);

                $(e.currentTarget).after($select2);
            }
        }
    })
})

// Show the success message
$(document).ready(function() {

    setTimeout(function() {
        $('#success-message').fadeOut('slow');
    }, 3000);
});


$('.select-all-items').click((e)=>{
    let formId = $(e.currentTarget).parent().attr('id');
    $("#" + formId + " .custom-row-class").addClass('selected');
    $("#" + formId + " .custom-row-class").find('.select-current-item').prop('checked', true);
});

$('.deselect-all-items').click((e)=>{
    let formId = $(e.currentTarget).parent().attr('id');
    $("#" + formId + " .custom-row-class").removeClass('selected');
    $("#" + formId + " .custom-row-class").find('.select-current-item').prop('checked', false);
});

$(document).on('click', '.custom-row-class:not(".select-current-item")', function(e) {
    if ($(this).hasClass('selected')) {
        $(e.currentTarget).find('.select-current-item').prop('checked', true);
    } else {
        $(e.currentTarget).find('.select-current-item').prop('checked', false);
    }
});

$('.nav-item button').click((e) => {
    let targetId = $(e.currentTarget).data('bs-target');
    let $tagifyCol = $('#tagify-col');
    switch (targetId) {
        case '#navs-pills-top-import-export':
            $tagifyCol.hide();
            break;
        case '#navs-pills-top-add':
            $tagifyCol.hide();
            break;
        case '#navs-pills-top-all':
            $tagifyCol.show();
            break;
        case '#navs-pills-top-archive':
            $tagifyCol.show();
            break;
    }
});