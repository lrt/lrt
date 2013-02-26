$(function(){
    $.fn.extend({
        ajaxForm: function(){
            $(this).submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    cache: false,
                    success: function(){
                        $('#result').html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Votre email a été envoyé.</div>").show('slow');
                        /*setTimeout(function() {
                            $('#result').hide("slow");
                        }, 5000);*/
                    },
                    error: function(error){
                        $('#result').html("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Une erreur est survenue.</div>");
                        setTimeout(function() {
                            $('#result').hide("slow");
                        }, 5000);
                    }
                });
                return false;
            });
        }
    });

    $('#formContact').ajaxForm();
    $('#formNewsletter').ajaxForm();
    $('#formAdhesion').ajaxForm();
});

//POPIN
$('.popin').click(function(e) {
    e.preventDefault();
    var title = $(this).attr('title');

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

$('.clients-carousel').flexslider({
    animation: "slide",
    easing: "swing",
    animationLoop: true,
    itemWidth: 1,
    itemMargin: 1,
    minItems: 1,
    maxItems: 8,
    controlNav: false,
    directionNav: false,
    move: 2
});


