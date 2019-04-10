var Utils = {
    url : $('#url').val(),
    sendPHPURL: "public/assets/sendmail.php",
    sendPHP : 'public/assets/js/sendmail.php',
    sourceApp: 'api',
    sourceSecureApp: $('#approot').attr('content') ,
    sourceAdminAppApi: $('#approot').attr('content') + 'admin-api',
    sourceAdminAppInnerApi: $('#approot').attr('content') + 'inner-api',
    sourceMetaAuth: $('#appauth').attr('content'),
    sourceMetaAccessToken: $('#appauthaccesstken').attr('content'),
    sourceMetaKey: $('#appkey').attr('content'),
    sourceMetaGroupString:  "auth=" + $('#appauth').attr('content') +"&key=" +  $('#appkey').attr('content'),
    sourceAppLogout: $('#approot').attr('content') + 'logout',
    appAutoLogout: $('#auto_logout').attr('content') ,
    appCurrency: $('#appcurrency').attr('content') ,
    
    PasswordCheck: function (pass, confirm) {
        if (pass.val() != confirm.val()) {
            toastr.warning("Passwords Do Not Match!")
            pass.addClass('error');
            confirm.addClass('error');
            return false;
        } else {
            pass.removeClass('error');
            confirm.removeClass('error');
            return true;
        }
    },
    ShowAlert: function (type, text, heading, isclosable, col) {
        heading = typeof heading !== 'undefined' || heading !== "" ? '<h4>' + heading + '</h4>' : '';
        isclosable = typeof isclosable !== 'undefined' ? false : isclosable;
        col = typeof col !== 'undefined' && col !== "" ? col : 'col-md-12';
        isclosable = (isclosable === true ? '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' : '');
        return '<div class="' + col + '"><div class="alert alert-' + type + ' alert-dismissable">' +
                    isclosable +
                    heading +
                    text +
                  '</div></div>';
    },
    toastr: function (type, text, heading) {
        /// <summary>
        /// Remember for this to work you need to call toastr.js first before Utils
        /// Method show toastr.js messages - mainly because from the server level we can send all levels (success/info/warning/error)
        /// </summary>
        heading = typeof heading !== 'undefined' || heading !== "" ? heading : '';
        text = typeof text !== 'undefined' || text !== "" ? text : 'Invalid Text Type';
        type = typeof type !== 'undefined' || type !== "" ? type : 'error';
        if(type == 'success')
        {
            toastr.success(text, heading);
        }
        else if(type == 'info')
        {
            toastr.info(text, heading);
        }
        else if(type == 'warning')
        {
            toastr.warning(text, heading);
        }
        else
        {
            toastr.error(text, heading);
        }
    },
    fa: function (icon, size, custom) {
        /// <summary>
        /// FONT AWESOME
        /// icon - is the type 'user' or 'group'
        /// size - is the icon size 1x or whatever
        /// custom - is an custom class and even font awesome classes like 'fa-spin'
        /// fontawesome.io should be imported first
        /// </summary>
        icon = typeof icon !== 'undefined' || icon !== "" ? icon : '';
        size = typeof size !== 'undefined' || size !== "" ? size : '';
        custom = typeof custom !== 'undefined' || custom !== "" ? custom : '';

        return '<i class="fa fa-' + icon + ' ' + size + ' ' + custom + '"> </i> ';
    },
};
