function alertLoginBox(icon, type, title, msg) {

    return `
            <div class="alert alert-`+type+`" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <div class="align-items-center justify-content-start">
                <div class="d-flex">
                    <i class="icon `+ icon + ` alert-icon tx-32"></i>
                    <h5 class="mg-b-2 pd-t-2">`+ title +` !</h5>
                </div>

                    <p class="mg-b-0 tx-xs op-8">`+ msg +` .</p>
                </div><!-- d-flex -->
            </div>
    `;
    
}
$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#login-form').submit(function (e) {
        e.preventDefault();
        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            $.post('/login' , $(this).serialize())
                .done(function (data) {
                    try {
                        if (data.status == 'success') {
                            $('#login_msg').html('');
                            $('#login_msg').html(alertLoginBox('ion-ios-checkmark', 'success', 'Connexion réussie', 'redirection en cours'));
                            $('#login_msg').removeClass('d-none');
                            location.href = data.url;
                        } else {
                            $('#login_msg').html('');
                            $('#login_msg').removeClass('d-none');
                            $('#login_msg').html(alertLoginBox('ion-ios-close ', 'danger', 'Connexion echoué','Login et/ou Mot de passe incorrect.'));

                        }
                    } catch (error) {
                        $('#login_msg').html(alertLoginBox('ion-ios-close ', 'danger', 'Connexion echoué', 'Login et/ou Mot de passe incorrect.'));
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        var errors = '';
                        $.each(jqXHR.responseJSON, function (key, value) {
                            errors += "<br>" + value;
                        });
                        // $('#modal-edit-msg').html(alerts('danger', errors));
                    } else {
                        $('#login_msg').html(alertLoginBox('ion-ios-close ', 'danger', 'Connexion echoué', 'Login et/ou Mot de passe incorrect.'));
                    }
                })
        }
        $(this).addClass('was-validated');
    })
})