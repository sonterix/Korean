$(function() {

    // sorting
    $("#sort-table").tablesorter();

    // pagination
    $('#sort-table').hpaging({
        'limit': 10,
    });

    $('.x-btn i').on('click', function() {

        const conf = confirm('Are you sure?');
        if(conf === false) {
            return false;
        }

        const tr = $(this).parent().parent();
        const doramaId = tr.find('.dorama-id').text();

        $.ajax({
            url: '/deleteDorama',
            type: 'post',
            dataType: 'json',
            data: {
               element: doramaId
            },
            complete: function() {
                tr.remove();
            },
         });
    })

    $('.edit-btn i').on('click', function() {
        const tr = $(this).parent().parent();
        const doramaId = tr.find('.dorama-id').text();
        window.location.href = "/editNewDorama/" + doramaId;
    })
});