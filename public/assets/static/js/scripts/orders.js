$(function () {

    $.ajaxSetup({
        headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
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

        $('.select2-status').select2({
            minimumResultsForSearch: '',
            dropdownParent: $("#modal-status-body"),
            placeholder: "Sélectionnez un choix"
        });

        // showing modal with effect
        $('.table').on('click', '.modal-effect', function (e) {
            e.preventDefault();

            var effect = $(this).attr('data-effect');
            $('#modal-edit').addClass(effect);

            $.get('/backend/orders/' + $(this).attr('data-id'), function (data) {

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
        $('.table').on('click', '.btn-edit', function (e) {
            e.preventDefault();

            $.get('/backend/orders/update/' + $(this).attr('data-id'), function (data) {

                if (data == undefined) {
                    swal("Erreur!", "Element sélectionné n'est pas existe!", "error");
                } else {

                    //before launch modal, Init all for plugins.

                    //Load data then launch modal.
                    $('#modal-edit-order').find('#modal-edit-order-body').html(data);
                    $('#modal-edit-order').modal('show');
                    $('.select2-edit').select2({
                        minimumResultsForSearch: '',
                        dropdownParent: $("#modal-edit-order-body"),
                        placeholder: "Sélectionnez un choix"
                    });
                    $('.modal').find('[data-toggle="tooltip"]').tooltip({ trigger: 'hover' });
                    $('.modal').find('[rel="tooltip"], [data-toggle="tooltip"]').on('click', function () {
                        $(this).tooltip('hide')
                    })

                }
            })
        });
        
        $('.table').on('click', '.btn-status', function (e) {
            e.preventDefault();

            $.getJSON('/backend/orders/status/get/' + $(this).attr('data-id'))
                .done(function (request) {
                    if (request.status == 'success') {

                        // launch & fill fields in edit modal
                        fill_fields('form-status', request.data);
                        $('#modal-status').modal('show');

                    } else {
                        swal("Erreur!", "Element sélectionné n'est pas existe!", "error");
                    }
                })

        });
        

        $('#form-status').submit(function (e) {
            e.preventDefault();
            
            if ($(this)[0].checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
            } else {
                $.post('/backend/orders/status/update' , $(this).serialize())
                    .done(function (data) {
                        try {
                            if (data.status == 'success') {
                                $('#status-info-section').html('');
                                setTimeout(function () {
                                    $('#status-info-section').html(alerts('success', 'Opération terminé avec succés.', 'success'));
                                }, 2000);

                                // hide modal event
                                $('#modal-status').on('hide.bs.modal', function (e) {
                                    location.reload();
                                });
                            } else {
                                $('#status-info-section').html('');
                                setTimeout(function () {
                                    $('#status-info-section').html(alerts('danger', 'échec de l\'opération, veuillez réessayer !', 'error'));
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
                            $('#status-info-section').html(alerts('danger', errors));
                        } else {
                            swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error');
                        }
                    })
            }
            $(this).addClass('was-validated');
        })

    $('#modal-edit-order').on('keyup', '[name="acompte"]', function (e) {
        e.preventDefault();
        $.post('/backend/orders/calc-reste', $('#form-edit-order').serialize())
            .done(function (data) {
                console.log(data);
                if (data == undefined) {
                    swal("Erreur!", "", "error");
                } else {
                    $('.modal').find('[name="reste"]').val(data.reste)
                }
            })
    })

    $('.modal').on('click', '#order-update', function (e) {
        e.preventDefault();
        // console.log($('#form-edit-order').serialize())
        $.post('/backend/orders/edit-order', $('#form-edit-order').serialize())
            .done(function (data) {
                // console.log(data);
                if (data == undefined) {
                    swal("Erreur!", "Element sélectionné n'est pas existe!", "error");
                } else {

                    if (data.status == 'failed') {
                        $('#modal-edit-order').find('#edit-info-section').html(alerts('danger', 'échec de l\'opération, veuillez réessayer !', 'error'));
                    } else {
                       $('#modal-edit-order').find('#edit-info-section').html(alerts('success', 'Opération terminé avec succés.', 'success'));
                    }
                    //before launch modal, Init all for plugins.
                    $('#modal-edit-order').animate({
                        scrollTop: 0
                    }, 'slow');
                    $('#modal-edit-order').on('hide.bs.modal', function (e) {
                        location.reload();
                    });
                }
            })
    })


    /**
     * Edit Order section :
     */

    $('.modal').on('click', '.btn-remove-item', function (e) {
        e.preventDefault();

        $.post('/orders/remove/item/' + $(this).attr('data-id'), {'item': $(this).parents('tr').attr('id')})
            .done(function (data) {
                // console.log(data);
                if (data == undefined) {
                    swal("Erreur!", "Element sélectionné n'est pas existe!", "error");
                } else {

                    if (data.status == 'failed') {
                        console.log('0');
                    }
                }
            })
    })

    $('#modal-edit-order').on('click', '.btn-save-item', function (e) {
        e.preventDefault();
        var req = $(this).parents('tr').find(".form :input").serialize() + '&item=' + $(this).parents('tr').attr('id') + '&qty=' + $(this).parents('tr').find(".qty").val();
        // console.log(req);
        $.post('/backend/orders/item/save/' + $(this).attr('data-id'), req)
            .done(function (data) {
                // console.log(data);return false;
                if (data == undefined) {
                    swal("Erreur!", "Element sélectionné n'est pas existe!", "error");
                } else {

                    if (data.status == 'failed') {
                         swal("Erreur!", "Echec essayé a nouveau!", "error");
                    } else {
                        $('#modal-edit-order').find('#'+data.data.item_id_pu).text(data.data.pu);
                        $('#modal-edit-order').find('#'+data.data.item_id_total).text(data.data.total);
                        $('#modal-edit-order').find('#cart_total').text(data.data.cart_total);
                        $('#modal-edit-order').find('[name="reste"]').val(data.data.reste);
                    }
                    
                }
            })
            .fail(function (jqXHR, textStatus, error) {

                if(jqXHR.status == 500){
                    swal("Attention!", "Parfums et/ou Accessoires Décoratifs n'est pas existe dans ce Dimension!", "error");
                }

            });
    })



    

    /**
     * Qty section.
     */
    var quantitiy = 0;
    
    $('.modal').on('click', '.qty-plus', function (e) {
        e.preventDefault();
        var quantity = parseFloat($(this).prev().val());
        // If is not undefined
        $(this).prev().val(quantity + 1);

    });

    $('.modal').on('click', '.qty-minus', function (e) {
        e.preventDefault();
        var quantity = parseFloat($(this).next().val());
        // Increment
        if (quantity > 1) {
            $(this).next().val(quantity - 1);
        }
    });

    $('.modal').on('keypress', '.float-num', function (eve) {
        if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0)) {
            eve.preventDefault();
        }

        // this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
        $('.modal').on('keyup', '.float-num', function (eve) {
            if ($(this).val().indexOf('.') == 0) {
                $(this).val($(this).val().substring(1));
            }
        });
        $('.modal').on("cut copy paste", '.float-num', function (e) {
            e.preventDefault();
        });
        $('.modal').on("change", '.float-num', function (e) {
            e.preventDefault();
            if ($(this).val() == undefined || parseFloat($(this).val()) <= 0 || $(this).val() == "") {
                $(this).val(1);
            }
        });
    });

})