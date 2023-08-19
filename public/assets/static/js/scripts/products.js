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

        $.get('/backend/products/' + $(this).attr('data-id'), function(data) {
            
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


    //Init plugins from dynamic data loaded.
    $('#modal-edit').on('show.bs.modal', function (e) {
        // Toggles
        $(this).find('.br-toggle').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('on');
        });

        // Select2
        $(this).find('.select2-multi').select2({
            minimumResultsForSearch: Infinity,
            dropdownParent: $("#modal-edit-body"),
            placeholder: 'Sélectionnez le(s) choix'
        });

        $('.select2-modal-edit').select2({
            minimumResultsForSearch: '',
            dropdownParent: $("#modal-edit-body"),
            placeholder: "Sélectionnez un choix"
        });

        // Tooltip
        $(this).find('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });
        $(this).find('[rel="tooltip"], [data-toggle="tooltip"]').on('click', function () {
            $(this).tooltip('hide')
        })
    })

    // hide modal with effect
    $('#modal-edit, #modal-add').on('hidden.bs.modal', function (e) {
        $(this).removeClass(function (index, className) {
            return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
        });
        //modal edit remove extra rows.

        //
        $('#modal-edit-msg, #modal-add-msg').html('');
        $('.file-e-label').html('Choisir Fichier');
    });

    // submit edit form
    $('#form-edit').submit(function (e) {
        e.preventDefault();
        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            var formData = new FormData($('#form-edit')[0]);
            formData.append('price-dimension', Number($(this).find('#price-dimension-edit').hasClass('on')));
            formData.append('parfum-dimension', Number($(this).find('#parfum-dimension-edit').hasClass('on')));
            formData.append('decors-dimension', Number($(this).find('#decors-dimension-edit').hasClass('on')));
            // for (var pair of formData.entries()) {
            //     console.log(pair[0] + ': ' + pair[1]);
            // }
            // return false;
            $.ajax({
                    url: "/backend/products/" + $(this).find('input[name="id"]').val(),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(function (data) {
                    // console.log(data)
                    try {
                        if (data.status == 'success') {
                            $('#modal-edit-msg').html('');
                            $('#modal-edit').find('.file-e-label').html('Choisir Fichier');
                            $('#modal-edit-msg').html(alerts('success', 'Opération terminé avec succés.', 'success'));
                            // hide modal event
                            $("#form-edit").removeClass('was-validated');
                            //2 secs et la modal fermer auto.
                            setTimeout(function () {
                                $('#modal-edit').modal('hide');
                            }, 2500);


                            $('#modal-edit').on('hide.bs.modal', function (e) {
                                location.reload();
                            });
                        } else {
                            if (data.error != undefined){
                                $('#modal-edit-msg').html(alerts('danger', 'échec de l\'opération, '+data.error+' !', 'error'));
                            }else{
                                $('#modal-edit-msg').html(alerts('danger', 'échec de l\'opération, veuillez réessayer !', 'error'));
                            }
                        }
                    } catch (error) {
                        swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error');
                        $("#form-edit").removeClass('was-validated');
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        var errors = '';
                        $.each(jqXHR.responseJSON, function (key, value) {
                            errors += "<br>" + value;
                        });
                        $('#modal-edit-msg').html(alerts('danger', errors));
                    } else if (jqXHR.status == 401) {
                        swal('Erreur!', "Operation echoué, s'il vous plaît l 'authentification est requise !", 'error');
                    }else {
                        swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error');
                        $("#form-edit").removeClass('was-validated');
                    }
                });
            }
            $(this).addClass('was-validated');
            $(".modal").animate({
                scrollTop: 0
            }, "slow");
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

        // $('input,textarea,select').filter('[required]:visible').each(function() {
        //     console.log($(this).attr('name'))
        // });
        // return false;

        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            var formData = new FormData($('#form-add')[0]);
            formData.append('status', Number($('.br-toggle').hasClass('on')));
            formData.append('price-dimension', Number($('#price-dimension').hasClass('on')));
            formData.append('parfum-dimension', Number($('#parfum-dimension').hasClass('on')));
            formData.append('decors-dimension', Number($('#decors-dimension').hasClass('on')));
            // for (var pair of formData.entries()) {
            //     console.log(pair[0] + ', ' + pair[1]);
            // }
            $.ajax({
                    url: "/backend/products",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,

                })
                .done(function (data) {
                    // console.log(data)
                    try {
                        if (data.status == 'success') {
                            $('#modal-add-msg').html('');
                            $("#form-add").removeClass('was-validated');
                            $('#form-add').each(function () {
                                this.reset();
                            });
                            $('.file-a-label').html('Choisir Fichier');
                            $('.select2-modal-add').each(function () {
                                $(this).val('').trigger('change');
                            });
                            $('#modal-add-msg').html(alerts('success', 'Opération terminé avec succés.', 'success'));
                            // hide modal event

                            //2 secs et la modal fermer auto.
                            setTimeout(function () { $('#modal-add').modal('hide'); }, 2000);


                            $('#modal-add').on('hide.bs.modal', function (e) {
                                location.reload();
                            });
                        } else {
                            if (data.error != undefined) {
                                $('#modal-add-msg').html(alerts('danger', 'échec de l\'opération, ' + data.error + ' !', 'error'));
                            } else {
                                $('#modal-add-msg').html(alerts('danger', 'échec de l\'opération, veuillez réessayer !', 'error'));
                            }
                             
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
                    } else if (jqXHR.status == 401) {
                        swal('Erreur!', "Operation echoué, s'il vous plaît l 'authentification est requise !", 'error');
                    } else {
                        swal('Erreur!', 'Operation echoué, un erreur survenue !', 'error');
                    }
                });
        }
        $(this).addClass('was-validated');
        $(".modal").animate({
            scrollTop: 0
        }, "slow");
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
        $.post('/backend/products/update/status', req)
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

                    $.post('/backend/products/delete/' + item_id)
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


    $("#modal-add, #modal-edit").on('click', '.br-toggle-switcher', function () {
        if ($(this).hasClass('on')) {    
            $(this).closest('.row')
                    .find(".br-toggle-badge")
                    .removeClass()
                    .addClass('br-toggle-badge badge badge-black')
                    .html('prix est en fonction de dimension &nbsp; <i class="fa fa-check-circle"></i>');
            
            if (!$(this).hasClass('no-required')) {
                $(this).closest('.row').next('.group-1').next('.group-2').find('input, select').each(function (index, value) { // Loop thru all the elements
                    $(this).prop('required', true);
                });
                $(this).closest('.row').next('.group-1').find('input, select').each(function (index, value) { // Loop thru all the elements
                    $(this).prop('required', false);
                });
            }
            
            $(this).closest('.row').next('.group-1').addClass('d-none');
            $(this).closest('.row').next('.group-1').next('.group-2').removeClass('d-none');
            
        } else {
            $(this).closest('.row')
                    .find(".br-toggle-badge")
                    .removeClass()
                    .addClass('br-toggle-badge badge badge-black')
                    .html('prix en fonction de la dimension &nbsp;<i class="fa fa-question-circle"></i>');
            
            if (!$(this).hasClass('no-required')) {
                $(this).closest('.row').next('.group-1').next('.group-2').find('input, select').each(function (index, value) { // Loop thru all the elements
                    $(this).prop('required', false);
                });
                $(this).closest('.row').next('.group-1').find('input, select').each(function (index, value) { // Loop thru all the elements
                    $(this).prop('required', true);
                });
            }
            
            $(this).closest('.row').next('.group-1').removeClass('d-none');
            $(this).closest('.row').next('.group-1').next('.group-2').addClass('d-none');
            
            
        }
    });

    //while selecting dimension > change radio val.
    $('.modal').on('change', '[name="p-dimension[]"]', function (e) {
        $(this).parents('.form-inline').find('input[name="default-price"]').val(
            $(this).children("option:selected").val()
        );
    })
    //while selecting radio > change radio val from selected dimension.
    $('.modal').on('click', 'input[name="default-price"]', function (e) {
        $(this).val(
            $(this).parents('.form-inline').find('[name="p-dimension[]"]').children("option:selected").val()
        );
    });


    //while selecting parfum > change radio val (G1).
    $('.modal').on('change', '[name="parfum[]"]', function (e) {
        $(this).parents('.form-inline').find('input[name="default-price-parfum-g1"]').val(
            $(this).children("option:selected").val()
        );
    });
    //while selecting radio > change radio val from selected parfum (G1).
    $('.modal').on('click', 'input[name="default-price-parfum-g1"]', function (e) {
        $(this).val(
            $(this).parents('.form-inline').find('[name="parfum[]"]').children("option:selected").val()
        );
    });

    //while selecting parfum/dimension > change radio val (G2).
    $('.modal').on('change', '[name="p-parfum-dimension[]"]', function (e) {
        $(this).parents('.form-inline').find('input[name="default-price-parfum-g2"]').val(
            $(this).parents('.form-inline').find('[name="p-parfum[]"]').children("option:selected").val() + '-' + $(this).children("option:selected").val()
        );
    })
    $('.modal').on('change', '[name="p-parfum[]"]', function (e) {
        $(this).parents('.form-inline').find('input[name="default-price-parfum-g2"]').val(
            $(this).children("option:selected").val() + '-' + $(this).parents('.form-inline').find('[name="p-parfum-dimension[]"]').children("option:selected").val()
        );
    })
    //while selecting radio > change radio val from selected parfum (G2).
    $('.modal').on('click', 'input[name="default-price-parfum-g2"]', function (e) {
        $(this).val(
            $(this).parents('.form-inline').find('[name="p-parfum[]"]').children("option:selected").val()
            + '-' +
            $(this).parents('.form-inline').find('[name="p-parfum-dimension[]"]').children("option:selected").val()
        );
    });


    //while selecting decors > change radio val (G1).
    $('.modal').on('change', '[name="decors[]"]', function (e) {
        $(this).parents('.form-inline').find('input[name="default-price-decor-g1"]').val(
            $(this).children("option:selected").val()
        );
    })
    //while selecting radio > change radio val from selected decors (G1).
    $('.modal').on('click', 'input[name="default-price-decor-g1"]', function (e) {
        $(this).val(
            $(this).parents('.form-inline').find('[name="decors[]"]').children("option:selected").val()
        );
    });

    //while selecting decors/dimension > change radio val (G2).
    $('.modal').on('change', '[name="p-decors[]"]', function (e) {
        $(this).parents('.form-inline').find('input[name="default-price-decor-g2"]').val(
            $(this).children("option:selected").val()
            + '-' +
            $(this).parents('.form-inline').find('[name="p-decors-dimension[]"]').children("option:selected").val()
        );
    })    
    $('.modal').on('change', '[name="p-decors-dimension[]"]', function (e) {
        $(this).parents('.form-inline').find('input[name="default-price-decor-g2"]').val(
            $(this).parents('.form-inline').find('[name="p-decors[]"]').children("option:selected").val()
            + '-' +
            $(this).children("option:selected").val()
        );
    })
    //while selecting radio > change radio val from selected decors (G2).
    $('.modal').on('click', 'input[name="default-price-decor-g2"]', function (e) {
        $(this).val(
            $(this).parents('.form-inline').find('[name="p-decors[]"]').children("option:selected").val()
            + '-' +
            $(this).parents('.form-inline').find('[name="p-decors-dimension[]"]').children("option:selected").val()
        );
    });

    var d_dimension = $('#default-select-price').html();
    var d_parfum = $('#default-select-parfum').html();
    var d_decors = $('#default-select-decors').html();
    function row(row_name, action) {
        var row = {};
        row['price'] = `
            <div class="form-inline mg-b-0 pd-b-15">
                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="prix par défaut">
                    <input name="default-price" value="" type="radio">
                    <span></span>
                </label>
                <div class="form-group mg-r-10">
                    <select name="p-dimension[]" style="width:380px" class="select2-modal-`+action+` form-control" data-placeholder="Sélectionnez un dimension">
                        <option></option>
                        ` + d_dimension + `
                    </select>
                </div>
                <div class="form-group mg-r-10">
                    <input type="text" class="form-control" name="p-dimension-price[]" onpaste="return false;"
                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                        placeholder="Prix">
                    </div>
                    <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                        data-placement="right" title="" data-original-title="Supprimer ce champ">
                        <i class="fa fa-times-circle"></i>
                    </button>
                </div>`;

        row['parfum-group-1'] = `
            <div class="form-inline mg-b-0 pd-b-15">
                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title="" data-original-title="prix par défaut">
                    <input name="default-price-parfum-g1" value="" type="radio" >
                    <span></span>
                </label>
                <div class="form-group mg-r-10">
                    <select name="parfum[]" style="width:380px" class="default-select-parfum-g1 select2-modal-`+action+` form-control" data-placeholder="Sélectionnez un parfum">
                        ` + d_parfum + `
                    </select>
                </div>
                <div class="form-group mg-r-10">
                    <input type="text" class="form-control" name="parfum-price[]" onpaste="return false;"
                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                        placeholder="Prix">
                </div>
                <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                    data-placement="right" title="" data-original-title="Supprimer ce champ">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div><!-- form-group -->`;

        row['parfum-group-2'] = `
            <div class="form-inline mg-b-0 pd-b-15">
                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title="" data-original-title="prix par défaut">
                    <input name="default-price-parfum-g2" value="" type="radio">
                    <span></span>
                </label>
                <div class="form-group mg-r-10">
                    <select name="p-parfum[]" style="width:200px" class="default-select-parfum-g2 select2-modal-`+action+` form-control" data-placeholder="Sélectionnez un parfum">
                        ` + d_parfum + `
                    </select>
                </div>
                
                <div class="form-group mg-r-10">
                    <select name="p-parfum-dimension[]" style="width:220px" class="default-select-parfum-dimension-g2 select2-modal-`+action+` form-control" data-placeholder="Sélectionnez un dimension">
                        ` + d_dimension + `
                    </select>
                </div>

                <div class="form-group mg-r-10">
                    <input type="text" class="form-control" name="p-parfum-price[]" onpaste="return false;"
                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                        placeholder="Prix" style="width:140px">
                </div>
                <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                    data-placement="right" title="" data-original-title="Supprimer ce champ">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div><!-- form-group -->`;


        row['decor-group-1'] = `
            <div class="form-inline mg-b-0 pd-b-15">
                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title="" data-original-title="prix par défaut">
                    <input name="default-price-decor-g1" value="" type="radio" >
                    <span></span>
                </label>
                <div class="form-group mg-r-10">
                    <select name="decors[]" style="width:380px" class="select2-modal-`+action+` form-control" data-placeholder="Sélectionnez un accessoire">
                        ` + d_decors + `
                    </select>
                </div>
                <div class="form-group mg-r-10">
                    <input type="text" class="form-control" name="decors-price[]" onpaste="return false;"
                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                        placeholder="Prix">
                </div>
                <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                    data-placement="right" title="" data-original-title="Supprimer ce champ">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div><!-- form-group -->`;

        row['decor-group-2'] = `
            <div class="form-inline mg-b-0 pd-b-15">
                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title="" data-original-title="prix par défaut">
                    <input name="default-price-decor-g2" value="" type="radio">
                    <span></span>
                </label>
                <div class="form-group mg-r-10">
                    <select name="p-decors[]" style="width:200px" class="select2-modal-`+action+` form-control" data-placeholder="Sélectionnez un accessoire">
                        ` + d_decors + `
                    </select>
                </div>
                
                <div class="form-group mg-r-10">
                    <select name="p-decors-dimension[]" style="width:220px" class="select2-modal-`+action+` form-control" data-placeholder="Sélectionnez un dimension">
                        ` + d_dimension + `
                    </select>
                </div>

                <div class="form-group mg-r-10">
                    <input type="text" class="form-control" name="p-decors-price[]" onpaste="return false;"
                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                        placeholder="Prix" style="width:140px">
                </div>
                <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                    data-placement="right" title="" data-original-title="Supprimer ce champ">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div><!-- form-group -->`;
            return row[row_name];
    }
    
        
    $('.modal').on('click', '.btn-add-row', function (e) {
        e.preventDefault();
        var index = $(this).attr('data-index');
        $(this).attr('data-index', ++index);

        if($(this).parents('#modal-add').length){
            
            $(this).parents('.' + $(this).attr('data-group')).append(row($(this).attr('data-content'), 'add'));

            $('#modal-add').find('.select2-modal-add').select2({
                minimumResultsForSearch: '',
                dropdownParent: $("#modal-add-body"),
                placeholder: "Sélectionnez un choix"
            });
        }else{

            $(this).parents('.' + $(this).attr('data-group')).append(row($(this).attr('data-content'), 'edit'));
            
            $('#modal-edit').find('.select2-modal-edit').select2({
                minimumResultsForSearch: '',
                dropdownParent: $("#modal-edit-body"),
                placeholder: "Sélectionnez un choix"
            });
        }
        $("[data-toggle='tooltip']").tooltip();
        $('[data-toggle="popover"]').popover();
        $('[rel="tooltip"], [data-toggle="tooltip"]').on('click', function () {
            $(this).tooltip('hide');
        })
    })

    $('.modal').on('click', '.btn-del', function (e) {
        e.preventDefault();

        //check if set as default before delete.
        if ($(this).parents('.form-inline').find('input[type="radio"]').is(':checked')){
            $(this).parents('.form-group').find('input[type="radio"]').eq(0).attr('checked', true).trigger('click');
        }
        $(this).parents('.form-inline').remove();
    })    
    
    $('#reset-form-add').on('click', function (e) {
        e.preventDefault();
        $('#modal-add').find('form')[0].reset();
        $('.file-a-label').html('Choisir Fichier');
        $('.select2-modal-add').each(function () {
            $(this).val('').trigger('change');
        });
    })

    $(".modal").on('change', 'select[name="tags[]"]', function () {
        var subSelector = $(this).parents('.modal').find('select[name="sub_tags[]"]');
        var tags = [];
        $.each($("select[name='tags[]'] option:selected"), function () {
            tags.push($(this).val());
        });
        if (!Array.isArray(tags) && !tags.length) {
            return false;
        }
        // tags = tags.join(", ");
        $.post('/backend/sub-tags/get-items', {tags: tags})
            .done(function (data) {
                if (data.status === 'success') {
                    subSelector.html(data.data).trigger('change');
                } else {
                    console.log('error in sub-tags.');
                }
            })
            .fail(function () {
                console.log('error in sub-tags.');
            });
    });

})