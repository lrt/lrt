$(document).ready(function(){
    
    $('.popin').click(function(event) {
        event.preventDefault();
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


