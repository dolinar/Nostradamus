$(document).ready(function() {
    $('.dropdown').on('show.bs.dropdown', function(e){
      $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
    });

    $('.dropdown').on('hide.bs.dropdown', function(e){
      $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
    });



    $('.form-check-overall-prediction').click(function() {
      $('.form-check-overall-prediction').not(this).prop('checked', false);
    });

    //TODO!!!! only for overallprediction checkbox family.
    $('input[type="checkbox"]').change(function () {
        if ($(this).is(':checked')) {
            $('#team-id').val($(this).attr('name'));
        } 
    });
});

$(document).ready(function() {
    $('.btn-click').click(function() {
        var id = this.id;
        $('#div-' + id).toggle(500);
        $(this).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
});

$(document).ready(function() {
    $('#show-group-form').click(function() {     
        $('#group-store').toggle(500);
    }); 

    $('#group-add-member').click(function() {
        $('#add-member-form').toggle(500);
    }); 

});


$(document).ready(function(){
    $('#user-search').on('keyup', function() {
        var text = $('#user-search').val();
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            method: "GET",
            url: "/table/search",
            data: {text: $('#user-search').val()},
            success: function(response) {
                if (response['search'] == null) {
                    $('body').html(response['html']);
                    $('#user-search').focus();
                    $('#pagination').show();
                } else {
                    $('#tbody-participants').hide();
                    $('#tbody-participants').html(response['html']);
                    $('#tbody-participants').show(300);
                    $('#pagination').hide();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                //alert(errorThrown);
            }       
        });
    });
});

$(document).ready(function(){
    $('#user-id-select').select2({
        placeholder: 'Izberi uporabnika',
        width: '100%'
    });
});

$(document).ready(function() {
    $('#store-accept').click(function() {
        var id = $(this).attr('name');
        var confirmed = $(this).attr('value');

        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            method: "GET",
            url: "store_user_to_group",
            data: {id: id, confirmed: confirmed},
            success: function(response) {
                $('body').html(response);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                //alert(errorThrown);
            }       
        });
    });

    $('#store-reject').click(function() {
        var id = $(this).attr('name');
        var confirmed = $(this).attr('value');

        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            method: "GET",
            url: "store_user_to_group",
            data: {id: id, confirmed: confirmed},
            success: function(response) {
                $('body').html(response);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                //alert(errorThrown);
            }       
        });
    });
});
