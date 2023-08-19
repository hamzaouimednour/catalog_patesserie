$(function () {
    
    $('#print-order').on('click', function(){
        location.href = window.location.origin + '/order/print/' + $(this).attr('data-id');
    })
})