$(document).ready(function () {

    $('form').submit(function (event) {
        event.preventDefault();

        function funcBefore() {
            $('#result').text("Loading...");
        }

        function funcSuccess(result) {
            $('#result').html(result);
            $('hr.line').remove();
        }

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
            contentType: false,
            dataType: "html",
            cache: false,
            processData: false,
            beforeSend: funcBefore,
            success: funcSuccess
        });
    });
});