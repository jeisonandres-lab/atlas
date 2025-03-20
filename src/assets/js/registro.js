import { clasesInputs, clasesInputsError } from "./ajax/inputs.js";
$(function () {

    // $("#fechaing3").flatpickr(optional_config);
    flatpickr("#fechaing3", {
        "disable": [
            function (date) {
                // return true to disable
                return (date.getDay() === 0 || date.getDay() === 6);

            }
        ],
        "locale": {
            "firstDayOfWeek": 1 // start week on Monday
        },
        locale: "es", // Establece el idioma a español
        maxDate: "today" // Limita la selección a la fecha actual o anterior
    });
    function scroll_to_class(element_class, removed_height) {
        var scroll_to = $(element_class).offset().top - removed_height;
        if ($(window).scrollTop() != scroll_to) {
            $('html, body').stop().animate({ scrollTop: scroll_to }, 0);
        }
    }

    function bar_progress(progress_line_object, direction) {
        var number_of_steps = progress_line_object.data('number-of-steps');
        var now_value = progress_line_object.data('now-value');
        var new_value = 0;
        if (direction == 'right') {
            new_value = now_value + (100 / number_of_steps);
        }
        else if (direction == 'left') {
            new_value = now_value - (100 / number_of_steps);
        }
        progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
    }

    jQuery(document).ready(function () {


        $('#top-navbar-1').on('shown.bs.collapse', function () {
            $.backstretch("resize");
        });
        $('#top-navbar-1').on('hidden.bs.collapse', function () {
            $.backstretch("resize");
        });

        /*
            Form
        */
        $('.f1 fieldset:first').fadeIn('slow');

        $('.f1 input[type="text"], .f1 input[type="password"], .f1 textarea, .f1 select').on('focus', function () {
            $(this).removeClass('input-error');
        });

        // next step
        $('.f1 .btn-next').on('click', function () {
            var parent_fieldset = $(this).parents('fieldset');
            var next_step = true;
            // navigation steps / progress steps
            var current_active_step = $(this).parents('.f1').find('.f1-step.active');
            var progress_line = $(this).parents('.f1').find('.f1-progress-line');

            // fields validation
            parent_fieldset.find('input[type="text"], input[type="password"], textarea, select, .select2').each(function () {
                if (!$(this).hasClass('cumplido') && !$(this).hasClass('cumplidoNormal')) {
                    clasesInputsError($(this));
                    $("#alert").empty();
                    $("#alert").html(`
                        <div class="d-flex alert alert-warning alert-dismissible m-0 contentAlerta" role="alert" >
                            <div class="d-flex align-items-center alert-icon me-3">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-text">
                                <strong>Debes de llenar los campos </strong> con los datos necesarios, <strong class="text-success">cada campo debe de estar de color verde</strong>, si alguno esta de<strong class="text-danger"> color rojo</strong> no podra pasar a la otra página.
                            </div>
                        </div>
                    `);
                    $("#alert").hide(); // Oculta el contenedor principal #alert
                    $("#alert").slideDown("slow");
                    
                    setTimeout(function() {
                      $("#alert").slideUp("slow"); // Oculta la alerta con un efecto de deslizamiento hacia arriba
                    }, 10000); // Ejecuta después de 10 segundos     
                    next_step = false;
                } else {
                    clasesInputs($(this));
                }
            });



            if (next_step) {
                parent_fieldset.fadeOut(400, function () {
                    // change icons
                    current_active_step.removeClass('active').addClass('activated').next().addClass('active');
                    // progress bar
                    bar_progress(progress_line, 'right');
                    // show next step
                    $(this).next().fadeIn();
                    // scroll window to beginning of the form
                    scroll_to_class($('.f1'), 20);
                });
            }

        });

        // previous step
        $('.f1 .btn-previous').on('click', function () {
            // navigation steps / progress steps
            var current_active_step = $(this).parents('.f1').find('.f1-step.active');
            var progress_line = $(this).parents('.f1').find('.f1-progress-line');

            $(this).parents('fieldset').fadeOut(400, function () {
                // change icons
                current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
                // progress bar
                bar_progress(progress_line, 'left');
                // show previous step
                $(this).prev().fadeIn();
                // scroll window to beginning of the form
                scroll_to_class($('.f1'), 20);
            });
        });

        // submit
        $('.f1').on('submit', function (e) {
            var formValidar = true;

            // fields validation
            $(this).find('input[type="text"], input[type="password"], textarea, select').each(function () {
                if (!$(this).hasClass('cumplido') && !$(this).hasClass('cumplidoNormal')) {
                    e.preventDefault();
                    $(this).addClass('input-error');
                    formValidar = false;
                } else {
                    $(this).removeClass('input-error');
                }
            });

            // Select2 validation
            $(this).find('select').each(function () {
                if (!$(this).next('.select2').hasClass('cumplido') && !$(this).next('.select2').hasClass('cumplidoNormal')) {
                    e.preventDefault();
                    $(this).next('.select2').addClass('input-error');
                    formValidar = false;
                } else {
                    $(this).next('.select2').removeClass('input-error');
                }
            });

            if (!formValidar) {
                e.preventDefault();
            }
        });

    });

});