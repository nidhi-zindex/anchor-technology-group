// JavaScript Document
$(document).ready(function () {

    $("#contact-form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Validate before AJAX
        if ($("#contact-form").valid()) {
            $("#zi-submit").prop('disabled', true).html('Submitting...');

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "form.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#contact-form')[0].reset();
                    var result = JSON.parse(response);
                    $("#zi-submit").html('Schedule a Call');

                    if (result.success === true) {
                        $('#successSend').removeClass('d-none');
                        setTimeout(() => {
                            $('#successSend').addClass('d-none');
                        }, 10000);
                    } else {
                        $('#errorSend').removeClass('d-none');
                        setTimeout(() => {
                            $('#errorSend').addClass('d-none');
                        }, 5000);
                    }

                    $("#zi-submit").prop('disabled', false);
                },
                error: function () {
                    $("#zi-submit").html('Schedule a Call');
                    $('#errorSend').removeClass('d-none');
                    setTimeout(() => {
                        $('#errorSend').addClass('d-none');
                    }, 5000);
                    $("#zi-submit").prop('disabled', false);
                }
            });
        }
    });

    // ✅ Validation rules
    $("#contact-form").validate({
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            company: {
                required: true
            },
            role: {
                required: true
            },
            email: {
                required: true,
                email: true
            },

        },
        messages: {
            name: {
                required: "Please enter your name.",
                minlength: "Your name must be at least 2 characters."
            },
            company: {
                required: "Please enter your company name."
            },
            role: {
                required: "Please enter your role."
            },
            email: {
                required: "Please enter your email.",
                email: "Please enter a valid email address."
            },

        }
    });

});
