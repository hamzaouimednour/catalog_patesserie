$(function () {


    //init datatable plugin.
    try {
        if ($('#datatable1').length) {
            'use strict';

            var datatble1 = $('#datatable1').DataTable({
                responsive: true,
                "order": [],
                language: {
                    searchPlaceholder: 'Chercher...',
                    sSearch: '',
                    lengthMenu: '_MENU_ articles/page',
                }
            });

            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });
        }
    } catch (error) {
        $.noop();
    }

})