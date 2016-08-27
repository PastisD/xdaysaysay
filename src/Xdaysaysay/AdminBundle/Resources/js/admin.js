admin = {};

$(document).ready( function() {
    admin.dataTables.init();
    $('select').not('.not-select2').select2();
});

// dataTables
admin.dataTables = admin.dataTables || {};
admin.dataTables.columns = [];
admin.dataTables.searchColumns = [];
admin.dataTables.init = function () {
    // $.fn.dataTable.moment('DD/MM/YYYY');
    $('.dataTable').each(function () {

        var options = {
            processing: true,
            order: [[0, 'asc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
            },
            columnDefs: [{orderable: false, targets: ['disable-sort']}],
            stateSave: true
        };

        var columns = admin.dataTables.columns[$(this).data('name')];

        // Define default ordering and disable sort if data-disable-sort = true
        var th = $('thead th', this);
        var order = [];
        $.each(th, function (i, el) {
            var sort = $(el).data('sort');
            if (sort) {
                order.push([i, sort]);
            }
        });

        if (order.length > 0) {
            options.order = order;
        }

        if (admin.dataTables.columns && admin.dataTables.columns[$(this).data('name')]) {
            options.columns = columns;
        }

        if ($(this).data('ajax-url')) {
            options.ajax = $(this).data('ajax-url');
            options.serverSide = true;
        }

        /* Callback addLink around rows */
        if($(this).data('callback') == 'wrapLink'){
            options.drawCallback = function (settings) {
                var api = this.api();
                $(this).find('tr').each(function (index, value) {
                    if(index>0){
                        var tr = $(value);
                        tr.css('cursor', 'pointer');
                        var data = api.rows( {page:'current'} ).data();
                        tr.click(function () {
                            window.open(data[index-1]['url_redirect'], '_blank');
                        });
                    }
                });
            }
        }

        if($(this).data('search') == false){
            options.searching = false;
        }

        $(this).DataTable(options);
    });
};