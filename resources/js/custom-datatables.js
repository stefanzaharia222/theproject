$(document).ready(function () {
    'use strict';

    if ($('#card-datatable').length) {
        // // Setup - add a text input to each footer cell
        $('#card-datatable thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#card-datatable thead');

        ajaxTable('#items-list', '#card-datatable', '.filters');

        $('#card-datatable-deleted thead tr')
            .clone(true)
            .addClass('filters-deleted')
            .appendTo('#card-datatable-deleted thead');

        ajaxTable('#items-list-deleted', '#card-datatable-deleted', '.filters-deleted');
    }
})

function ajaxTable(selector1, selector2, selector3) {
    $.ajax({
        url: '/lang/json',
        method: 'GET',
        dataType: 'json',
        success: function (translations) {
            let fieldsDeleted = $(selector1).data('allitems');
            initDatatables(selector2, fieldsDeleted, selector3, translations);
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function initDatatables(selector1, data, selector2, languageData) {
    let columns = $('#columns-list').data('columns');
    let convertedFormat = columns.map(function (item) {
        return {"data": item};
    });

    convertedFormat.unshift({"data": ""});

    let targetKeys = ['created_at', 'updated_at', 'deleted_at', 'email_verified_at'];

    let positions = targetKeys.map(function (key) {
        return columns.indexOf(key) + 1;
    });

    let table = $(selector1).DataTable({
        select: {
            'style': 'multi'
        },
        data: data,
        orderable: true,
        order: [[2, 'desc']],
        orderCellsTop: true,
        language: {
            "emptyTable": languageData.emptyTable,
            "info": languageData.info,
            "infoEmpty": languageData.infoEmpty,
            "infoFiltered": languageData.infoFiltered,
            "infoPostFix": languageData.infoPostFix,
            "thousands": languageData.thousands,
            "lengthMenu": languageData.lengthMenu,
            "loadingRecords": languageData.loadingRecords,
            "processing": languageData.processing,
            "search": languageData.search,
            "zeroRecords": languageData.zeroRecords,
            "paginate": {
                "first": languageData.paginate.first,
                "last": languageData.paginate.last,
                "next": languageData.paginate.next,
                "previous": languageData.paginate.previous
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
        },
        columns: convertedFormat,
        columnDefs: [
            {
                targets: 0,
                render: function () {
                    return '<input type="checkbox" class="select-current-item">';
                }
            },
            {
                targets: positions, // Assuming the first column contains the date
                render: function (data, type, row) {
                    if (typeof data !== "undefined" && data !== null) {
                        return moment(data).format("YYYY-MM-DD HH:mm:ss");
                    } else {
                        return '//';
                    }
                }
            },
            {
                targets: 1,
                render: function (data, type, row) {
                    return "<i class='fa fa-pencil' aria-hidden='true' data-rowdata='" + JSON.stringify(row) + "'></i>"
                }
            },
            {targets: 2, width: '100%'},
            {
                targets: 6,
                render: function (data, type, row) {
                    if (data === 1) {
                        return '<div class="status-field-active"></div>';
                    } else if (data === 0) {
                        return '<div class="status-field-inactive"></div>';
                    } else {
                        return data;
                    }
                }
            },
            {
                targets: "_all",
                render: function (data, type, row) {
                    if (typeof data === 'string' && data.startsWith("{")) {
                        let parsedData = JSON.parse(data);

                        if (typeof parsedData[appLocale] !== "undefined") {
                            return parsedData[appLocale];
                        } else if (typeof parsedData[appLocale.toUpperCase()] !== "undefined") {
                            return parsedData[appLocale.toUpperCase()];
                        } else if (typeof parsedData['en'] !== "undefined") {
                            return parsedData['en'];
                        } else {
                            return parsedData;
                        }
                    } else  {
                        return data;
                    }
                }
            }
        ],
        dom: '<"card-header custom-card-header-design"<"head-label text-center"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 10,
        initComplete: function (data) {
            let api = this.api();

            api.rows().every(function () {
                let rowNode = this.node();
                // Apply CSS styles to the row
                $(rowNode).addClass('custom-row-class');
            });

            api.columns().eq(0).each(function (colIdx) {
                if (colIdx === 0 || colIdx === 1) {
                    return;
                }

                let cell = $(selector2 + ' th').eq(api.column(colIdx).index());

                let title = cell.text();
                cell.html('<input type="text" style="width: calc(100%) " placeholder="filter" />');


                let input = $('input', cell);
                input.css({
                    'border': '1px solid lightgrey'
                })
                input.off('keyup change').on('change', function (e) {
                    input.attr('title', input.val());
                    let regexr = '({search})';
                    api.column(colIdx).search(
                        this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))') : '',
                        this.value != '',
                        this.value == ''
                    ).draw();

                }).on('keyup', function (e) {
                    e.stopPropagation();
                    let cursorPosition = this.selectionStart;
                    input.trigger('change');
                    input.focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                });
            });

            $('.tab-pane .card').removeClass('d-none');
        },
    });
    $('.fa-pencil').unbind('click')
    $('.form-update-modal input').keyup(function () {
        $(this).attr({
            value: $(this).val()
        })
    })
    $('.fa-pencil').click((e) => {
        let rowData = $(e.currentTarget).data('rowdata');

        let $modalBody = $("#myModal .modal-body");

        $modalBody.empty()

        // Get the full URL
        let fullUrl = window.location.href;

        // Split the URL by slashes
        let segments = fullUrl.split('/');

        // Get the last segment
        let item = segments[segments.length - 1];

        // Make an AJAX request to get the Blade view content
        $.ajax({
            url: '/get-modal-content',
            method: 'GET',
            data: {data: rowData, "type-form": item},
            complete: function (response) {
                // Insert the content into the modal's body
                $modalBody.html(response.responseText);

                // Open the modal
                $("#myModal").modal("show");

                $('.form-update-modal .update-button').click(() => {
                    // @TODO it change all data but we have to recreate data as {"en":"asdasd"} because NOW we have translations
                    let inputsSerialize = $('.form-update-modal').serialize()
                    updateRecord(inputsSerialize, item);
                });
            }
        });
    })

    $('.tab-pane .card').removeClass('d-none')

    //Trigger the pencil click
    var currentURL = window.location.href;

    // Check if the URL contains "users"
    if (currentURL.includes("users")) {
        $('tbody tr td:nth-child(5)').attr('style', 'color: cornflowerblue; text-decoration: underline;')

        $('tbody tr td:nth-child(4), tbody tr td:nth-child(5)').click(function () {
            $(this).closest('tr').find('td:nth-child(2) i').trigger('click')
        })
    } else {
        $('tbody tr td:nth-child(4)').click(function () {
            $(this).closest('tr').find('td:nth-child(2) i').trigger('click')
        })
    }

}

$(document).ready(function () {
    $('.submit-button').click(function (event) {
        let formClass = $(this).closest('form').attr('id');

        let form = $('#' + formClass);
        // Find selected rows and extract data
        let rowsData = [];

        $("#" + formClass + ' tr.selected').each(function (index, data) {
            let rowData = {};
            $(this).find('td').each(function (index) {
                // Get the corresponding header column name
                let columnName = $('#all_items_form th:eq(' + index + ')').text();

                if (columnName === 'ID') {
                    // Store the data with the column name
                    rowData = $(this).text();
                }
            });
            rowsData.push(rowData);
        });

        form.append('<input type="hidden" name="selected-rows-json" value= \'' + JSON.stringify(rowsData) + ' \' >')

        //check if option is selected
        let selectedValue = $('#' + formClass + " select").val();

        if (selectedValue && selectedValue !== '') {
            if (rowsData.length > 0) {
                // Option is selected
                form.submit();
            } else {
                $('#' + formClass + "  table ").tooltip({
                    title: 'No row selected for bulk action',
                    animation: true,
                    trigger: 'manual',

                })
                $('#' + formClass + "  table ").tooltip('show');
                setTimeout(function () {
                    $('#' + formClass + "  table").tooltip('hide');
                }, 1000); // 1 second (1000 milliseconds)
            }
        } else {
            $('#' + formClass + "  .bulk-select:first-child").tooltip({
                title: 'Select something first',
                animation: true,
                trigger: 'manual',
            })
            $('#' + formClass + "  .bulk-select:first-child ").tooltip('show');
            setTimeout(function () {
                $('#' + formClass + "  .bulk-select:first-child ").tooltip('hide');
            }, 1000); // 1 second (1000 milliseconds)
        }
    });
    $('tbody tr td:nth-child(4)').css({
        "text-decoration": "underline"
    })
});


function updateRecord(rowData, item) {
    $.ajax({
        url: '/update-modal-content',
        method: 'GET',
        data: {
            input: rowData,
            "type-form": item,
            "form-action-select": "update_single_action",
            "ajax-request": true
        },
        complete: function (response) {
            window.location.reload();
        }
    });
}
