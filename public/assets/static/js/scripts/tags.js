$(function () {

    $('.table').on('click', '.img-show', function () {
        $('.imagepreview').attr('src', $(this).attr('src'));
        $('#imagemodal').modal('show');
    });
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

    // Toggles
    $('.br-toggle').on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('on');
        // $(this).hasClass('on');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // showing modal with effect
    $('.table').on('click', '.modal-effect', function (e) {
        e.preventDefault();

        var effect = $(this).attr('data-effect');
        $('#modal-edit').addClass(effect);

        $.getJSON('/backend/tags/' + $(this).attr('data-id'))
            .done(function (request) {
                if (request.status == 'success') {

                    // launch & fill fields in edit modal
                    fill_fields('form-edit', request.data);
                    $('#modal-edit').modal('show');

                } else {
                    swal("Erreur!", "Element sélectionné n'est pas existe!", "error");
                }
            })

    });

    // hide modal with effect
    $('#modal-edit, #modal-add').on('hidden.bs.modal', function (e) {
        $(this).removeClass(function (index, className) {
            return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
        });
        $('#modal-edit, #modal-add').find('form')[0].reset();
        $('#modal-edit-msg, #modal-add-msg').html('');
        $('.custom-file-label').html('Choisir Fichier');
    });

    // submit edit form
    $('#form-edit').submit(function (e) {
        e.preventDefault();
        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            var formData = new FormData($('#form-edit')[0]);
            $.ajax({
                    url: "/backend/tags/" + $(this).find('input[name="id"]').val(),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(function (data) {
                    try {
                        if (data.status == 'success') {
                            $('#modal-edit-msg').html('');
                            $('#modal-edit').find('.custom-file-label').html('Choisir Fichier');

                            setTimeout(function () {
                                $('#modal-edit-msg').html(alerts('success', 'Opération terminé avec succés.', 'success'));
                            }, 2000);

                            // hide modal event
                            $('#modal-edit').on('hide.bs.modal', function (e) {
                                location.reload();
                            });
                        } else {
                            $('#modal-edit-msg').html('');
                            setTimeout(function () {
                                $('#modal-edit-msg').html(alerts('danger', 'échec de l\'opération, veuillez réessayer !', 'error'));
                            }, 2000);

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
                        $('#modal-edit-msg').html(alerts('danger', errors));
                    } else {
                        swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error');
                    }
                })
        }
        $(this).addClass('was-validated');
    })

    $('.modal').on('change', '.field-a-upload, .field-e-upload', function (e) {
        // alert(jQuery(this).val())
        if ($(this)[0].files.length) {
            $(this).next().html($(this)[0].files[0].name);
        }
    })

    // submit add form
    $('#form-add').submit(function (e) {
        e.preventDefault();
        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            var formData = new FormData($('#form-add')[0]);
            formData.append('status', Number($('.br-toggle').hasClass('on')));
            $.ajax({
                    url: "/backend/tags",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,

                })
                .done(function (data) {
                    try {
                        if (data.status == 'success') {
                            $('#modal-add-msg').html('');
                            $('#modal-add').find('.custom-file-label').html('Choisir Fichier');
                            setTimeout(function () {
                                $('#modal-add-msg').html(alerts('success', 'Opération terminé avec succés.', 'success'));
                            }, 2000);

                            // hide modal event
                            $('#modal-add').on('hide.bs.modal', function (e) {
                                location.reload();
                            });
                        } else {
                            $('#modal-add-msg').html('');
                            setTimeout(function () {
                                $('#modal-add-msg').html(alerts('danger', 'échec de l\'opération, veuillez réessayer !', 'error'));
                            }, 2000);

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
                        $('#modal-add-msg').html(alerts('danger', errors));
                    } else {
                        swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error');
                    }
                })
        }
        $(this).addClass('was-validated');
    })

    // click on status btn
    $('.table').on('click', '.btn-status', function (e) {
        e.preventDefault();

        // Init elemnts to be changed.
        var self = $(this);
        var icon = $(this).find('i');
        var old_icon = icon.attr('class');
        var badge = $(this).parents('tr').find('td.status-badge');

        // change the load icon.
        icon.removeClass().addClass("fa fa-circle-o-notch fa-spin");

        var old_status = $(this).attr('data-status');
        var new_status = [1, 0];
        var new_status_icon = ["fa fa-eye-slash", "fa fa-eye"];
        var new_status_badge = ['<span class="wd-50 badge badge-success">Active</span>', '<span class="badge badge-secondary">Inactive</span>'];
        var new_status_title = ['Désactiver', 'Activer'];

        var req = {
            status: new_status[old_status],
            id: $(this).attr('data-id')
        };
        $.post('/backend/tags/update/status', req)
            .done(function (data) {
                try {
                    if (data.status == 'success') {

                        // change the new icon.
                        icon.removeClass().addClass(new_status_icon[old_status]);

                        //change the new tooltip title
                        self.attr('data-original-title', new_status_title[old_status]).tooltip('show');

                        //change status badge
                        badge.html(new_status_badge[old_status]);

                        //change the old status
                        self.attr('data-status', new_status[old_status]);

                        swal('Succés', 'Opération terminé avec succés.', 'success')
                        return false;

                    } else {
                        swal('Échec!', 'échec de l\'opération, veuillez réessayer !', 'error');
                        icon.removeClass().addClass(old_icon);
                    }
                } catch (error) {
                    swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error');
                    icon.removeClass().addClass(old_icon);
                }

            })

    })

    // click on delete btn
    $('.table').on('click', '.btn-delete', function (e) {
        e.preventDefault();

        var item_id = $(this).attr('data-id');
        var icon = $(this).find('i');
        var old_icon = icon.attr('class');

        swal({
                title: "Êtes-vous sûr?",
                text: "êtes-vous sûr de supprimer l'element ?",
                icon: "info",
                buttons: {
                    cancel: {
                        text: "Annuler",
                        value: null,
                        visible: !0,
                        className: "btn btn-default",
                        closeModal: !0
                    },
                    confirm: {
                        text: "OUI, CONFIRMER LA SUPPRESSION",
                        value: !0,
                        visible: !0,
                        className: "btn btn-danger",
                        closeModal: 0
                    }
                }
            })
            .then((willAccept) => {
                if (willAccept) {

                    // change the load icon.
                    icon.removeClass().addClass("fa fa-circle-o-notch fa-spin");

                    $.post('/backend/tags/delete/' + item_id)
                        .done(function (data) {
                            try {
                                if (data.status === 'success') {

                                    // alert success msg.
                                    swal("Succès!", 'Element supprimé avec succés.', 'success');

                                    // remove the selected item.
                                    // $('#item-' + item_id).remove();
                                    datatble1.row($('#item-' + item_id)).remove().draw();

                                } else {
                                    icon.removeClass().addClass(old_icon);
                                    // alert failed msg.
                                    swal("Échoué!", "Operation echoué, veuillez réessayer!", "error");
                                }
                            } catch (err) {
                                icon.removeClass().addClass(old_icon);
                                // error occured.
                                swal("Échoué!", "Operation echoué, erreur survenue!", "error");
                            }

                        })
                        .fail(function () {
                            icon.removeClass().addClass(old_icon);
                            swal("Erreur!", "Operation echoué, réessayer une autre fois!", "error");
                        });
                }
            });
    });
})