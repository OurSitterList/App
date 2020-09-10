
var $loginErrorPane,
    $loginWindowContent;

function toggleLoginPane(type)
{
    if (!$loginErrorPane)
    {
        $loginErrorPane = $('#loginErrorPane');
    }
    if (!$loginWindowContent)
    {
        $loginWindowContent = $('#loginWindowContent');
    }
    $loginErrorPane.hide();
    $loginWindowContent.show();

    if (type)
    {
        $('#' + type + '_login_username').select();
    }
}

function loginError(type, errorMsg)
{
    var closeBtn = '<div align="center"><input type="button" value="Go Back" class="login_sub_btn" onclick="toggleLoginPane(\'' + type + '\');" /></div>';
    $('#loginWindowContent').hide();
    $('#loginErrorPane').html(errorMsg + '<br /><br />' + closeBtn).show();
}

function getLoginBtnHandler(type)
{
    return function()
    {
        var uname = $('#' + type + '_login_username').val();
        var pass = $('#' + type + '_login_password').val();

        if (!uname || !pass)
        {
            loginError(type, 'Please enter your username and password.');
            return;
        }

        // show loader
        showLoginLoader(type);

        // make request
        $.ajax({
            url: '/login-ajax.php',
            method: 'post',
            dataType: 'json',
            data: {type: type, username: uname, password: pass, redirect: getUrlVars()['redirect']},
            success: function(data)
            {
                var err;
                if (!data || typeof data.error == 'undefined')
                {
                    err = 'Unexpected error has occurred.';
                }
                else if (data.error === true)
                {
                    err = data.msg || 'Unexpected error has occurred.';
                }

                if (err)
                {
                    hideLoginLoader(type);
                    loginError(type, err);
                }
                else if (data && typeof data.red != 'undefined' && data.red)
                {
                    document.location = data.red;
                }
                else
                {
                    console.log(data);
                    hideLoginLoader(type);
                    loginError(type, 'An unexpected error has occurred. Please try again.');
                }
            },
            error: function(data)
            {
                console.log(data);
                hideLoginLoader(type);
                loginError(type, 'An unexpected error has occurred. Please try again.');
            }
        });

    };
}

function showLoginLoader(type)
{
    $('#' + type + '_login_buttons').hide();
    $('#' + type + '_login_loader').show();
}

function hideLoginLoader(type)
{
    $('#' + type + '_login_loader').hide();
    $('#' + type + '_login_buttons').show();
}

$(function(){
    // login button handlers
    $('#sitter_login_button').click(getLoginBtnHandler('sitter'));
    $('#family_login_button').click(getLoginBtnHandler('family'));
});

function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
  });
  return vars;
}
