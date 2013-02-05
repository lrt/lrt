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
                        setTimeout(function() {
                            $('#result').hide("slow");
                        }, 5000);
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


