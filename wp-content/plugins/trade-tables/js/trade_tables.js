jQuery(document).ready( function ($){
    $('.tradeTable').DataTable({
        ordering: false,
        pagingType: 'simple',
        language: {
            searchPlaceholder: "Search",
            "search": "",
            "lengthMenu": "Show _MENU_ entries",
            paginate: {
                "next":       "Next",
                "previous":   "Previous"
            },
        },

    });
});