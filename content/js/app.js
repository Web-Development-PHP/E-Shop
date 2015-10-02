$(document).ready(function() {
    $('.ajaxForm > input[type="submit"]').click(function(ev){
        ev.preventDefault();
        var clickedForm = ev.target.parentNode;
        var form = $(this).parent();
        var formAction = form.attr('action');
        var formMethod = form.attr('method');
        var postData = $(this).parent().serializeArray();
        makeRequest(formAction, formMethod, postData);
    });

    function makeRequest(url, method, data) {
        $.ajax({
            type: method,
            url: url,
            data: data,
            success: function(response) {
                $('#ajaxContent').html(response);
            }
        });
    }
});