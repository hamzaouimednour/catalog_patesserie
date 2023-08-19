$(function () {
    var preloader = $('.preloader');
    $(window).on('load', function () {
        function hidePreloader() { preloader.fadeOut(500); }
        hidePreloader();
    });
    
    // Select2 without the search for modal
    $('.select2-modal-add').select2({
      minimumResultsForSearch: '',
      dropdownParent: $("#modal-add-body"),
      placeholder: "Sélectionnez un choix"
    });
    
    $('.select2-multi').select2({
        minimumResultsForSearch: Infinity,
        dropdownParent: $("#modal-add-body"),
        placeholder: 'Sélectionnez le(s) choix'
    });

    // Select2 without the search for modal
    $('.select2-modal-edit').select2({
      minimumResultsForSearch: '',
      dropdownParent: $("#modal-edit-body"),
      placeholder: "Sélectionnez un choix"
    });

    $('[data-toggle="tooltip"]').tooltip({ trigger: 'hover'});
    $('[rel="tooltip"], [data-toggle="tooltip"]').on('click', function () {
        $(this).tooltip('hide')
    })


})

function fill_fields(form, params) {

    Object.keys(params).forEach(key => {
        var field = '[name="' + key + '"]';
        // field as array
        if(!$(field).length){
            field = '[name="' + key + '[]"]';
        }
        if ($(field).length) {
            if ($(field).prop('type') != 'file' && $(field).prop('type') != 'checkbox') {
                $('#' + form).find(field).val(params[key]);
            }

            // Select2
            if ($(field).attr('class') != undefined && $(field).attr('class').indexOf('select2') > -1) {
                $(field).trigger('change');
            }

            // CheckBox
            if ($(field).prop('type') == 'checkbox') {
                var obj = JSON.parse(params[key]);

                $(field).each(function () {
                    if ( obj.includes($(this).val()) ) {
                        $(this).attr('checked', true);
                    }
                });
                
            }
            
            // //status toggle.
            // if ($('#' + form).find(".br-toggle").length){
            //     if (params['status']) {
            //         $('#' + form).find(".br-toggle").removeClass('on off').addClass('on');
            //     }else{
            //         $('#' + form).find(".br-toggle").removeClass('on off').addClass('off');
            //     }
            // }
        }
    });
        //img preview.
        if ($('#' + form).find("#img").length) {
            $('#' + form).find("#img").prop('src', '/thumbs/' + params["img"]);
        }
}
function alerts(params, errors) {

    var status = {};
    status['success'] = `
        <div class="alert alert-success pd-y-20" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="d-sm-flex align-items-center justify-content-start">
                <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0 mg-r-20"></i>
                <span><strong>Succés!</strong> ` + errors + `</span>
            </div><!-- d-flex -->
        </div>`;

    status['danger'] = `
        <div class="alert alert-danger pd-y-20" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="d-flex align-items-center justify-content-start">
                <i class="icon ion-ios-close alert-icon tx-32 mg-t-5 mg-xs-t-0 mg-r-20"></i>
                <span><strong>Echec!</strong> ` + errors + `</span>
            </div><!-- d-flex -->
        </div><!-- alert -->`;

    return status[params];
}