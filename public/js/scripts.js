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
        $('#div-'+id).toggle(500);
        $(this).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
});

$(document).ready(function() {
    $('#show-group-form').click(function() {
        $('#group-store').toggle(500);
    });
});

