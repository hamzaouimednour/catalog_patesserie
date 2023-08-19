$(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#productModal').on('keypress change', '.float-num', function (eve) {
        if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0)) {
            eve.preventDefault();
        }

        // this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
        $('#productModal').on('keyup', '.float-num', function (eve) {
            if ($(this).val().indexOf('.') == 0) {
                $(this).val($(this).val().substring(1));
            }
        });

        var regex = /[+-]?([0-9]*[.])?[0-9]+/;
    });

    function RemoveLastDirectoryPartOf(the_url) {
        var the_arr = the_url.split('/');
        the_arr.pop();
        return (the_arr.join('/'));
    }

    $('.cat-search').on('click', function(e){
        e.preventDefault();
        document.location.href = window.location.origin + '/products/' + $(this).attr('data-id') + '/' + $('select[name="sort-items"]').children("option:selected").val();
    })
    $('select[name="sort-items"]').on('change', function (e) {
        e.preventDefault();
        url = RemoveLastDirectoryPartOf(location.href);
        urlSplit = location.href.split('/');
        if(urlSplit.length > 5){
            location.href = url + '/' + $(this).children("option:selected").val();
        }else{
            location.href = window.location.origin + '/products/all/' + $(this).children("option:selected").val();
        }
    })

    /**
     * Qty minus / plus
     */
    // $('#productModal').on("cut copy paste", '#items-qty',function (e) {
    //     e.preventDefault();
    // });
    // $('#productModal').on("change", '#items-qty',function (e) {
    //     e.preventDefault();
    //     if ($(this).val() == undefined || parseFloat($(this).val()) <= 0 || $(this).val() == "" ) {
    //         $(this).val(1);
    //     }
    // });

    // $('#productModal').on('click', '#qty-minus', function (e) {
    //     e.preventDefault();
    //     var qty = parseInt($('#productModal').find('#items-qty').val());

    //     if (qty <= 1 && $(this).prop('disabled') == false) {
    //         $(this).prop('disabled', true);
    //     } else {
    //         $(this).prop('disabled', false);
    //         $('#productModal').find('#items-qty').val(qty - 1).keyup();
    //         if (parseInt($('#productModal').find('#items-qty').val()) <= 1) {
    //             $(this).prop('disabled', true);
    //         }
    //     }
    // })

    // $('#productModal').on('click', '#qty-plus', function (e) {
    //     e.preventDefault();
    //     var qty = parseInt($(this).parent().find('#items-qty').val());
    //     if ((qty + 1).toString().length <= parseInt($(this).parent().find('#items-qty').prop('maxlength'))) {
    //         $('#productModal').find('#items-qty').val(qty + 1).keyup();
    //     }
    //     $('#productModal').find('#qty-minus').prop('disabled', false);
    // })
    
    $('#productModal').on('click', '.minus-btn', function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('#productModal').on('click', '.plus-btn', function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    $('.product-cart').on('click', function(e){
        e.preventDefault();
        $('#productModal').find('#productModal-body').html('');
        // console.log($(this).attr('data-id')); return false;
        $.get('/products/fetch/' + $(this).attr('data-id'))
        .done(function (data) {
            if (data == undefined) {
                console.log("Element sélectionné n'est pas existe!");
            } else {

                //Load data then launch modal.
                $('#productModal').find('#productModal-body').html(data);

                //Start Keyboard plugin.
                $('.modal').find('#default').keyboard();
                $('.modal').find('#addInputBtn').click(function () {
                    $(this).parent().append($('<input>').attr('type', 'text').addClass('form-control').addClass(
                        'keyboard'));
                    $(this).siblings('.keyboard').keyboard();
                });
                $('.modal').find('#removeInputBtn').click(function () {
                    $(this).siblings('.keyboard').last().remove();
                });
                $('.modal').find('#placement').keyboard({
                    placement: 'top'
                });

                // $('#items-qty').keyboard();
                $('.modal').find('#items-qty').keyboard({
                    type: 'numpad'
                });
                $('.modal').find('#addInputBtn').click(function () {
                    $(this).parent().append($('<input>').attr('type', 'text').addClass('form-control').addClass('keyboard'));
                    $(this).siblings('.keyboard').keyboard();
                });
                $('.modal').find('#removeInputBtn').click(function () {
                    $(this).siblings('.keyboard').last().remove();
                });
                $('.modal').find('#placement').keyboard({
                    placement: 'top'
                });


                $('#productModal').modal('show');
            }
        })
    })


    // Add product to cart.
    $('#productModal').on('click', '#cart-add', function(e){
        e.preventDefault();
        $('#productModal').find('#modal-msg-failed').addClass("d-none");
        $('#productModal').find('#modal-msg-success').addClass("d-none");
        // console.log($('#cart-form').serialize())
        $.post('/cart/add/1', $('#cart-form').serialize() + '&qty=' + $('#items-qty').val())
            .done(function (data) {
                if (data == undefined) {
                    console.log("Element sélectionné n'est pas existe!");
                } else {
                console.log(data);

                    if(data.status == 'failed'){
                        $('#productModal').find('#modal-msg-failed').removeClass("d-none");
                        $('#productModal').find('#modal-msg-success').addClass("d-none");
                    }else{
                        $('#productModal').find('#modal-msg-failed').addClass("d-none");
                        $('#productModal').find('#modal-msg-success').removeClass("d-none");
                        $('#cart-quantity').text(data.nbr);
                    }
                    //before launch modal, Init all for plugins.
                    $('#productModal').animate({ scrollTop: 0 }, 'slow');
                }
            })
    })
    
    // Update price.
    $('#productModal').on('change', ".select:not('[name=dimension]'):not('[name=dimension2]')", function (e) {
        e.preventDefault();
        // console.log($('#cart-form').serialize())
        $.post('/cart/add/0', $('#cart-form').serialize() + '&qty=' + $('#items-qty').val())
            .done(function (data) {
                console.log(data);
                if (data == undefined) {
                    console.log("Element sélectionné n'est pas existe!");
                } else {
                    //before launch modal, Init all for plugins.
                    $('#productModal').find('#product-price').html(data.total);
                }
            })
    })


     // Update price.
    $('#productModal').on('click', '.plus-btn, .minus-btn', function (e) {
        e.preventDefault();
        // console.log($('#cart-form').serialize())
        $.post('/cart/add/0', $('#cart-form').serialize() + '&qty=' + $('#items-qty').val())
            .done(function (data) {
                // console.log(data);
                if (data == undefined) {
                    console.log("Element sélectionné n'est pas existe!");
                } else {
                    //before launch modal, Init all for plugins.
                    $('#productModal').find('#product-price').html(data.total);
                }
            })
    })

     // Update price.
    $('#productModal').on('click keyup focus', '#items-qty', function (e) {
        e.preventDefault();
        
        // console.log($('#cart-form').serialize())
        $.post('/cart/add/0', $('#cart-form').serialize() + '&qty=' + $('#items-qty').val())
            .done(function (data) {
                // console.log(data);
                if (data == undefined) {
                    console.log("Element sélectionné n'est pas existe!");
                } else {
                    //before launch modal, Init all for plugins.
                    $('#productModal').find('#product-price').html(data.total);
                }
            })
    })
    
    // get specified items for a dimension.
    $('#productModal').on('change', '[name="dimension"], [name="dimension2"]', function (e) {
        e.preventDefault();
        // console.log($('#cart-form').serialize())
        $.post('/products/items', $('#cart-form').serialize() + '&qty=' + $('#items-qty').val())
            .done(function (data) {
                // console.log(data);
                if (data == undefined) {
                    console.log("Element sélectionné n'est pas existe!");
                } else {

                    //before launch modal, Init all for plugins.
                    if(data.parfums.length != 0 ){
                        $('#productModal').find('[name="parfums"]').html(data.parfums_str);
                    }
                    
                    if(data.decors.length != 0 ){
                        $('#productModal').find('[name="decors"]').html(data.decors_str);
                    }

                    $.post('/cart/add/0', $('#cart-form').serialize() + '&qty=' + $('#items-qty').val())
                        .done(function (data) {
                            console.log(data);
                            if (data == undefined) {
                                console.log("Element sélectionné n'est pas existe!");
                            } else {
                                //before launch modal, Init all for plugins.
                                $('#productModal').find('#product-price').html(data.total);
                            }
                        })

                }
            })
    })
})