$(document).ready(function() {

    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    })
    .on("change", function(e) {
        $('.filter-form .form-control').each(function() {
            if($(this).val() !== '') {
                $(this).next().addClass('form-label-active');
            }
        });
    });

    //Filter form hover label movement
        $('.filter-form .form-control').hover(
            function () {
                let value = $(this).val();
                $(this).focus();

                if(value == '') {
                    $(this).next().addClass('form-label-active');
                }
            },
            function () {
                let value = $(this).val();

                $(this).blur();

                if(value == '') {
                    $(this).next().removeClass('form-label-active');
                }
            }
        );
    //Filter form hover label movement

    
    //Filter form load label movement
        $('.filter-form .form-control').each(function() {
            if($(this).val() !== '') {
                $(this).next().addClass('form-label-active');
            }
        });
    //Filter form load label movement

    
    // Select2 dropdowns
        $('.filter-single-dropdown').select2({
            minimumResultsForSearch: Infinity
        });
    // Select2 dropdowns

});


// Prevent too many clicks
    function submitForm() {
        var form = $(".table-container .create-modal form");

        if(form[0].checkValidity()) {
            $('.table-container .modal form .form-btn').prop('disabled', true);
            form.submit();
        }
        else {
            form[0].reportValidity();
        }
    }

    function updateForm() {
        var form = $(".table-container .edit-modal form");

        if(form[0].checkValidity()) {
            $('.table-container .modal form .form-btn').prop('disabled', true);
            form.submit();
        }
        else {
            form[0].reportValidity();
        }
    }
// Prevent too many clicks


// Delete data
    function deleteRow(url) {
        $('.delete-modal').modal('show');
        $('.delete-modal .confirm_delete').attr('href', url);
    }
// Delete data