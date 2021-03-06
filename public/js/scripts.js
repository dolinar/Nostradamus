$(document).ready(function() {
    $('.navbar .dropdown').hover(function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
      }, function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
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
        $('#group-inv-status-table').hide(500);
        $('#add-member-form').toggle(500);
    }); 

    $('#group-show-inv-status').click(function() {
        $('#add-member-form').hide(500);
        $('#group-inv-status-table').toggle(500);
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
                    $('.dropdown-toggle').dropdown();
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
        width: '100%',
    });
});

$(document).ready(function() {
    $('#store-accept').click(function() {
        var id = $(this).attr('name');
        var confirmed = $(this).attr('value');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "POST",
            url: "/store_user_to_group",
            data: {id: id, confirmed: confirmed},
            success: function(response) {
                $('body').html(response);
                $('.dropdown-toggle').dropdown();
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
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "POST",
            url: "/store_user_to_group",
            data: {id: id, confirmed: confirmed},
            success: function(response) {
                $('body').html(response);
                $('.dropdown-toggle').dropdown();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                //alert(errorThrown);
            }       
        });
    });
});

$(document).ready(function(){
    $('.group-delete-fa').click(function() {
        if (confirm('Res želite uporabnika odstraniti iz skupine?')) {
            var id = $(this).attr('id');
            var idGroup = $(this).attr('value');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "/remove_user",
                data: {id: id, idGroup: idGroup },
                success: function(response) {
                    $('body').html(response);
                    $('.dropdown-toggle').dropdown();

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    //alert(errorThrown);
                }       
            });
        }
    })

    $('#group-leave').click(function() {
        if (confirm('Res želite zapustiti skupino?')) {
            var idGroup = $(this).attr('value');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "/leave_group",
                data: {idGroup: idGroup },
                success: function(response) {
                    $('body').html(response);
                    $('.dropdown-toggle').dropdown();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    //alert(textStatus);
                }       
            });
        }
    }) 
});

$(document).ready(function() {
    $('.rate-stars').each($(this).mdbRate);
    $('#rate-1').click(function(){
    });
});


// dropdowns
$(document).ready(function() {
    $('.li-results').click(function() {    
        var id = $(this).attr('id');
        $('#tb-' + id).toggle(500);
        $(this).find('.fa-chevron-results').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    }); 

    $('.active-predictions-dropdown').click(function() {
        $('.active-predictions').toggle(500);
        $(this).find('.fa-chevron-active-predictions').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });

    $('.previous-predictions-dropdown').click(function() {
        $(this).siblings().find('.previous-prediction').toggle(500);
        $(this).find('.fa-chevron-previous-predictions').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });

    $('.previous-predictions-profile-dropdown').click(function() {
        
        $('.previous-prediction-item').hide(500);
        $('.previous-prediction').toggle(500);
        $(this).find('.fa-chevron-previous-predictions-profile').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });

    $('.previous-prediction').click(function() {
        $(this).siblings('#' + $(this).attr('id')).toggle(500);
        $(this).find('.fa-chevron-results').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });


    $('.active-predictions-profile-dropdown').click(function() {
        $('.active-prediction').toggle(500);
        $(this).find('.fa-chevron-active-predictions').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });

    $('.active-prediction').click(function() {
        $(this).siblings('#' + $(this).attr('id')).toggle(500);
        $(this).find('.fa-chevron-predictions').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
});


// timeago
jQuery(document).ready(function() { 
    jQuery("time.timeago").timeago();
});


// registration images
jQuery(document).ready(function() { 
    $('.image-selector').click(function() {
        $('.image-selector').removeClass('green');
        this.classList.add('green');
        $('#profile_image').val(this.id);
    });
});


// quick prediction form
$(document).ready(function() {
    $('.quick-prediction-form').on('submit', function(event) {
        event.preventDefault();
        var id = $(this).attr('id').split('-')[1];
        $('#' + id).modal('hide');
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "POST",
            url: "/predictions",
            data: $( this ).serialize(),
            success: function(response) {
                toastr['info']('Napoved uspešno oddana!');
                document.getElementById('btn-' + id).removeAttribute("onclick");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                toastr['error']('Prišlo je do napake. Prosimo, poskusite kasneje.');
            }       
        });
    });
});