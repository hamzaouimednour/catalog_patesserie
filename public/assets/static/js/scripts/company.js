$(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $('#form-update').on('submit', function(e){
        e.preventDefault();
        $('#info-section').html('');
        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            $.post('/backend/company/update' , $(this).serialize())
                .done(function (data) {
                    try {
                        if (data.status == 'success') {
                            $('#info-section').html(alerts('success', 'Opération terminé avec succés.', 'success'));
                        } else {
                            $('#info-section').html(alerts('danger', 'échec de l\'opération, veuillez réessayer !', 'error'));
                        }
                    } catch (error) {
                        swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error')
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        var errors = '';
                        $.each(jqXHR.responseJSON, function (key, value) {
                            errors += "<br>" + value;
                        });
                        $('#info-section').html(alerts('danger', errors));
                    } else {
                        swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error');
                    }
                })
        }
        $(this).addClass('was-validated');
    })
})