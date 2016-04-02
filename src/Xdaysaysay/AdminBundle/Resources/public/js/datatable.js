$(document).ready(function() {
    $('.dataTable').dataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
        },
        "order": [],
        "columnDefs": [
            { targets: 'no-sort', orderable: false }
        ]
    } );
} );