const iterview = (function () {
    return {
        handleButtonLoading: function (isLoading, buttonId) {
            if (isLoading) {
                // turn button into loading state
                $(buttonId).prop('disabled', true);
                $(buttonId).html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                );
            } else {
                // turn button into default state
                $(buttonId).prop('disabled', false);
                $(buttonId).html(
                    `Update`
                );
            }
        },

        handleSuccessResponse: function (table, result, modalId) {
            // hide the modal
            $(modalId).modal('hide');

            // show success message
            $('.alert-text').html(result.alert)
            $('#alert-message').fadeIn();

            // refresh the table
            table.ajax.reload();

            // hide success message after 4 seconds
            setTimeout(function () {
                $('#alert-message').fadeOut();
                $('.alert-text').html('');
            }, 4000);
        }
    }
})();