$(function() {

    // sorting
    $("#sort-table").tablesorter();

    // pagination
    $('#sort-table').hpaging({
        'limit': 10,
    });

    $('.x-btn i').on('click', function() {

        // const conf = confirm('Are you sure?');
        // if(conf === false) {
        //     return false;
        // }

        swal({
            title: 'Вы уверены?',
            text: "Дорама будет удалена!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#952347',
            cancelButtonColor: '#212529',
            confirmButtonText: 'Да, удалить',
            cancelButtonText: 'Отмена'
        }).then((result) => {
            if (result.value) {
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

                        swal({
                            title: 'Удалено!',
                            text: 'Дорама успешно удалена',
                            type: 'success',
                            confirmButtonColor: '#212529',
                        })
                    },
                 })
            } else {
                return false;
            }
        })
    })

    $('.edit-btn i').on('click', function() {
        const tr = $(this).parent().parent();
        const doramaId = tr.find('.dorama-id').text();
        window.location.href = "/editNewDorama/" + doramaId;
    })
});