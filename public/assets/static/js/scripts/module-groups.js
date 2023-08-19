$(function () {

    // Toggles
    $('.modal').on('click', '.br-toggle', function (e) {
        e.preventDefault();
        $(this).toggleClass('on');
    });
    $('.modal').on('click', '.item-actions', function (e) {
        e.preventDefault();
        var id = $(this).prop('id');
        if ($(this).hasClass('on')){
            $(this).parents('.list-group').find('#actions-' + id).removeClass('d-none');
        }else{
            $(this).parents('.list-group').find('#actions-' + id).addClass('d-none');
        }
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
    $('.modal-effect').on('click', function (e) {
        e.preventDefault();

        var effect = $(this).attr('data-effect');
        $('#modal-edit').addClass(effect);

        $.get('/backend/module-groups/' + $(this).attr('data-id'), function (data) {

            if (data == undefined) {
                swal("Erreur!", "Element sélectionné n'est pas existe!", "error");
            } else {

                //before launch modal, Init all for plugins.

                //Load data then launch modal.
                $('#modal-edit').find('#modal-edit-body').html(data);
                $('#modal-edit').modal('show');

            }
        })

    });
    
    // showing modal with effect
    $('#btn-modal-add').on('click', function (e) {
        e.preventDefault();

        $.get('/backend/module-groups/add/group', function (data) {

            if (data == undefined) {
                swal("Erreur!", "Element sélectionné n'est pas existe!", "error");
            } else {

                //before launch modal, Init all for plugins.

                //Load data then launch modal.
                $('#modal-add').find('.modal-body').html(data);
                $('#modal-add').modal('show');
                

            }
        })

    });

    // hide modal with effect
    $('#modal-edit, #modal-add').on('hidden.bs.modal', function (e) {
        $(this).removeClass(function (index, className) {
            return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
        });
        $('#modal-edit, #modal-add').find('.modal-body').html('');
        $('#modal-edit-msg, #modal-add-msg').html('');
    });

    // submit edit form
    $('#form-edit').submit(function (e) {
        e.preventDefault();
        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            var item_actions = {};
            var actions = [];
            $(".item-actions").each(function (index) {

                var item_id = $(this).prop('id');
                actions = [];

                if ($(this).hasClass('on')) {
                    $(this).parents('.list-group').find('#actions-' + item_id).find('.action-item').each(function (index) {
                        if ($(this).prop('checked')) {
                            actions.push($(this).val());
                        }
                    })
                    item_actions[item_id] = actions;
                }
            });
            $.post('/backend/module-groups/' + $(this).find('input[name="id"]').val(), $(this).serialize() + "&modules=" + JSON.stringify(item_actions))
                .done(function (data) {
                    try {
                        if (data.status == 'success') {
                            $('#modal-edit-msg').html('');
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
         $(".modal").animate({
             scrollTop: 0
         }, "slow");
    })

    // submit add form
    $('#form-add').submit(function (e) {
        e.preventDefault();
        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            var item_actions = {};
            var actions = [];
            $(".item-actions").each(function (index) {

                var item_id = $(this).prop('id');
                actions = [];

                if($(this).hasClass('on')){
                    $(this).parents('.list-group').find('#actions-' + item_id).find('.action-item').each(function (index) {
                        if($(this).prop('checked')){
                            actions.push($(this).val());
                        }
                    })
                    item_actions[item_id] = actions;
                }
                
            });
            // console.log(item_actions);return false;
            $.post('/backend/module-groups', $(this).serialize() + "&modules=" + JSON.stringify(item_actions) + '&status=' + Number($('.br-toggle').hasClass('on')))
                .done(function (data) {
                    // console.log(data);
                    // return false;
                    try {
                        if (data.status == 'success') {
                            $('#modal-add-msg').html('');
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
        $(".modal").animate({
            scrollTop: 0
        }, "slow");
    })

    // click on status btn
    $('.btn-status').on('click', function (e) {
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
        $.post('/backend/module-groups/update/status', req)
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
    $('.btn-delete').on('click', function (e) {
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

                    $.post('/backend/module-groups/delete/' + item_id)
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