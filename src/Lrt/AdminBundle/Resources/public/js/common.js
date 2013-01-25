$(document).ready(function(){

    // MASKED INPUTS
    $(".mask_phone").mask('99 (999) 999-99-99');
    $(".mask_credit").mask('9999-9999-9999-9999');
    $(".mask_date").mask('99/99/9999');
    $(".mask_tin").mask('99-9999999');
    $(".mask_ssn").mask('999-99-9999');

    //CUSTOM SCROLLING
    $(".scroll").mCustomScrollbar();

    //DATEPICKER
    $('.datepicker').datepicker()

    //POPOVER
    $('#btn-more').popover();

    //POPIN
    $('.popin').click(function(e) {
        e.preventDefault();
        var title = $(this).attr('rel');

        $.ajax({
            url: $(this).attr('href'),
            type: 'get',
            beforeSend: function() {
                $('#box').modal('toggle');
            },
            success: function(data) {
                $('#myModalLabel').text(title);
                $('#box .modal-body').html(data);
            }
        });
    });

});
