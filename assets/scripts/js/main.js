$(document).ready(function () {
    var elements = document.getElementsByTagName("INPUT");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function (e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("Por favor preencha este campo!");
            }
        };
        elements[i].oninput = function (e) {
            e.target.setCustomValidity("");
        };
    }

    const $username_field = $('#username');

    $username_field.focus();
    $username_field.keypress(login);

    $('#password').keypress(login);

    $('#login').bind('click', function () {
        const form = $('#login_form');

        ajaxPost({
            id:form[0].id,
            data:{
                action:this.id,
                data:form.serializeJSON()
            },
            form:form[0]
        });

        return false;
    });

    $('#logout').bind('click', function () {
        const form = $('#logout_form');

        ajaxPost({
            id:form[0].id,
            data:{
                action:this.id
            }
        });

        return false;
    });
});

function login(event) {
    if (event.keyCode == 13) {
        $('#login').click();
        return false;
    }
}

function ajaxPost(options) {
    if (options.hide == null)
        options.hide = true;

    if (options.feedback == null)
        options.feedback = true;

    if (options.permanent == null)
        options.permanent = false;

    if (options.feedback) {
        $('#waiting').show(500);
        $('#result').hide(0);
    }

    if (options.id != null && options.hide)
        $('#' + options.id).hide(0);

    $.ajax({
            type:'POST',
            url:'assets/scripts/php/post.php',
            dataType:'json',
            data:options.data,
            success:function (output) {
                if (options.feedback) {
                    $('#waiting').hide(500);

                    const $results_div = $('#result');

                    $results_div.removeClass().addClass((output.error === true) ? 'text-error' : 'text-success')
                        .html(output.msg).show(500);

                    if (!options.permanent)
                        $results_div.delay(2000).hide(500);
                }

                if (output.error === true)
                    if (options.id != null && options.hide)
                        $('#' + options.id).show(500);

                if (output.error && options.form != null) {
                    options.form.reset();
                }

                if (output.page != null) {
                    window.location = output.page;
                }
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                if (options.feedback) {
                    $('#waiting').hide(500);

                    const $results_div = $('#result');

                    $results_div.removeClass().addClass('text-error')
                        .html(XMLHttpRequest.responseText).show(500);

                    if (!options.permanent)
                        $results_div.delay(2000).hide(500);
                }

                if (options.id != null && options.hide)
                    $('#' + options.id).show(500);

                if (options.form != null) {
                    options.form.reset();
                }
            }
        }
    )
}