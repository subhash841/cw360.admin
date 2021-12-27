$(function () {

        $('.js-basic-example').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            bSort: false,
            buttons: [
            {
                extend: 'excel',
                text:'Export to Excel',
                exportOptions: {
                columns: ':not(.notexport)'
            }
            }
            ]
        });


//    $('.js-basic-example').dataTable({
//        "bDestroy": true,
//        "bPaginate": true,
//        "bScrollCollapse": true,
//        "bProcessing": true,
//        "bFilter": true,
//        "bSort": false,
//        aoColumnDefs: [
//            {aTargets: ['_all'], bSortable: true},
//            {aTargets: [0], bSortable: false},
//            {aTargets: [1], bSortable: false}
//        ]
//    });



    //Exportable table
        $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
            {
                extend: 'excel',
                text:'Export to Excel',
                exportOptions: {
                columns: ':not(.notexport)'
            }
            }
            ]
        });



});