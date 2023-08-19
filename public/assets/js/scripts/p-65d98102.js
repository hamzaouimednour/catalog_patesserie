$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.clockpicker').clockpicker({
        placement: 'top',
        autoclose: true,
        'default': 'now'
    });

    // $('.datepicker').datepicker({
    //     format: 'dd/mm/yyyy',
    //     language: 'fr',
    //     startDate: '-3d'
    // });

    $('.float-num').on('keypress', function (eve) {
        if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0)) {
            eve.preventDefault();
        }

        // this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
        $('.float-num').on('keyup', function (eve) {
            if ($(this).val().indexOf('.') == 0) {
                $(this).val($(this).val().substring(1));
            }
        });
    });


        $('.plus-btn, .minus-btn').on('click', function () {
            var qty = $(this).parents('.product-quantity').find('[name="qty"]');
            if (qty.val() == 0 || qty.val() == "" || qty.val() == undefined) {
                qty.val('1');
            }
            // alert($(this).parents('tr').find('.product-subtotal').length)
            var req = {
                id: qty.attr('data-id'),
                key: qty.attr('data-key'),
                qty: qty.val()
            };
            var subtotal = $(this).parents('tr').find('.product-subtotal');
            $.post('/cart/qty', req)
                .done(function (data) {
                    // console.log(data);
                    if (data == undefined) {
                        console.log("Element sélectionné n'est pas existe!");
                    } else {

                        if (data.status == 'success') {
                            subtotal.html(data.total + " <small>DT</small>");
                            $('#order-total').html(data.order_total + " <span>DT</span>");
                        }
                    }
                })
        })

        $('[name="qty"]').on('focusout', function () {
            var qty = $(this).parents('.product-quantity').find('[name="qty"]');
            // alert($(this).parents('tr').find('.product-subtotal').length)
            var req = {
                id: qty.attr('data-id'),
                key: qty.attr('data-key'),
                qty: qty.val()
            };
            var subtotal = $(this).parents('tr').find('.product-subtotal');
            $.post('/cart/qty', req)
                .done(function (data) {
                    console.log(data);
                    if (data == undefined) {
                        console.log("Element sélectionné n'est pas existe!");
                    } else {

                        if (data.status == 'success') {
                            subtotal.html(data.total + " <small>DT</small>");
                            $('#order-total').html(data.order_total + " <span>DT</span>");
                        }
                    }
                })
        })

    $('.product-delete').on('click', function (e) {
        e.preventDefault();
        var req = {
            id: $(this).attr('data-id'),
            key: $(this).attr('data-key')
        };
        var tr = $(this).parents('tr');
        $.post('/cart/remove', req)
            .done(function (data) {
                // console.log(data);
                if (data == undefined) {
                    console.log("Element sélectionné n'est pas existe!");
                } else {
                    
                    if(data.status == 'success'){
                        tr.remove();
                        $('#order-total').html(data.order_total + " <small>DT</small>");
                        $('#cart-quantity').text(data.nbr);
                    }
                }
            })
    })

    $('#cart-form').on('submit', function (e) {
        e.preventDefault();
        
        $('#submit-cart-form').attr('disabled', true);

        if ($(this)[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            $.post('/order/submit', $('#cart-form').serialize())
                .done(function (data) {
                    // console.log(data);
                    if (data == undefined) {
                        console.log("Element sélectionné n'est pas existe!");
                    } else {

                        if (data.status == 'success') {
                            // window.location.href = window.location.origin  + "/cart/order/" + data.id;
                            $('#order_num').html(data.num);
                            $('#order_num').attr('data-order-id', data.id);
                            $('#modal-cart').modal('show');
                        }
                    }
                })
        }
        $('#submit-cart-form').attr('disabled', false);
    })

    $('#print-order').on('click', function(e){
        e.preventDefault();
        window.location.href = window.location.origin + "/order/print/" + $('#order_num').attr('data-order-id');
    })

    $('[name="acompte"]').on('focusout blur', function(){
        $.post('/calc-acompte', {acompte: $('input[name="acompte"]').val()})
            .done(function (data) {
                if (data == undefined) {
                    console.log("Element sélectionné n'est pas existe!");
                } else {
                    if (data.total != undefined) {
                        $('[name="reste"]').val(data.total + ' DT');
                    }
                }
            })
    })

    $('#clear-cart').on('click', function () {
        $.get('/cart/destroy')
            .done(function (data) {
                console.log("new cart.");
                location.reload();
            })
    })


});