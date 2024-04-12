window.addEventListener('load', function() {
    if ($('#country').val() !== null) {
        var selectedValue = $('#country').val();
    
        // Make an Ajax request to the controller
        $.ajax({
          type: 'GET',
          url: '/register/create',
          data: { selectedValue: selectedValue },
          success: function(response) {

             // Update the selected option in the phone code select box
             $('#phone_code').val(response.data);
             $('#alternate_phone_code').val(response.data);
             $('#emergency_phone_code').val(response.data);
    
          }
        });
    }
});

$(document).ready(function(){
    
    // var current_fs, next_fs, previous_fs; //fieldsets
    // var opacity;
    
    // $(".next").click(function(){
        
    //     current_fs = $(this).parent();
    //     next_fs = $(this).parent().next();
        
    //     //Add Class Active
    //     $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
    //     //show the next fieldset
    //     next_fs.show(); 
    //     //hide the current fieldset with style
    //     current_fs.animate({opacity: 0}, {
    //         step: function(now) {
    //             // for making fielset appear animation
    //             opacity = 1 - now;
    
    //             current_fs.css({
    //                 'display': 'none',
    //                 'position': 'relative'
    //             });
    //             next_fs.css({'opacity': opacity});
    //         }, 
    //         duration: 600
    //     });
    //     window.scrollTo({ top: 350, behavior: 'smooth' });
    // });
    
    // $(".previous").click(function(){
        
    //     current_fs = $(this).parent();
    //     previous_fs = $(this).parent().prev();
        
    //     //Remove class active
    //     $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
    //     //show the previous fieldset
    //     previous_fs.show();
    
    //     //hide the current fieldset with style
    //     current_fs.animate({opacity: 0}, {
    //         step: function(now) {
    //             // for making fielset appear animation
    //             opacity = 1 - now;
    
    //             current_fs.css({
    //                 'display': 'none',
    //                 'position': 'relative'
    //             });
    //             previous_fs.css({'opacity': opacity});
    //         }, 
    //         duration: 600
    //     });
    // });

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function(){
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        // Validate the current fieldset before moving to the next one
        if (validateFieldset(current_fs)) {
            // Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            // Show the next fieldset
            next_fs.show(); 
            // Hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // For making fieldset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                }, 
                duration: 600
            });
            window.scrollTo({ top: 350, behavior: 'smooth' });
        } else {
            // Show an alert or handle the validation error as needed
            $('#unfilledNotice').modal('toggle');
        }
    });

    $(".previous").click(function(){
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        // Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        // Show the previous fieldset
        previous_fs.show();

        // Hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // For making fieldset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            }, 
            duration: 600
        });
    });

    // Function to validate the current fieldset
    function validateFieldset(current_fs) {
        // Find all required fields within the given fieldset
        var requiredFields = current_fs.find('.required-field');

        for (var i = 0; i < requiredFields.length; i++) {
            var field = $(requiredFields[i]);
            var fieldValue = field.val();

            // Check if the input field is empty or not selected
            if (!fieldValue || (field.is(':checkbox') && !field.prop('checked'))) {
                return false; // Return false if any field is empty
            }
        }

        return true; // All required fields in the current fieldset are filled
    }

    
    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });
    
    $(".submit").click(function(){
        return false;
    })

    // if ($('#country').val() !== null) {
    //     $(window).load(function() {
    //         var selectedValue = $('#country').val();
    
    //     // Make an Ajax request to the controller
    //     $.ajax({
    //       type: 'GET',
    //       url: '/register/create',
    //       data: { selectedValue: selectedValue },
    //       success: function(response) {

    //          // Update the selected option in the phone code select box
    //          $('#phone_code').val(response.data);
    //          $('#alternate_phone_code').val(response.data);
    //          $('#emergency_phone_code').val(response.data);
    
    //       }
    //     });
    //     })
    // }
    $('#country').change(function() {
        var selectedValue = $(this).val();
    
        // Make an Ajax request to the controller
        $.ajax({
          type: 'GET',
          url: '/register/create',
          data: { selectedValue: selectedValue },
          success: function(response) {

             // Update the selected option in the phone code select box
             $('#phone_code').val(response.data);
             $('#alternate_phone_code').val(response.data);
             $('#emergency_phone_code').val(response.data);
    
          }
        });
    });

    $('#country').change(function() {
        var selectedValue = $(this).val();
    
        // Make an Ajax request to the controller
        $.ajax({
          type: 'GET',
          url: '/register/create',
          data: { selectedValue: selectedValue },
          success: function(response) {

             // Update the selected option in the phone code select box
             $('#phone_code').val(response.data);
             $('#alternate_phone_code').val(response.data);
             $('#emergency_phone_code').val(response.data);
    
          }
        });
    });
});