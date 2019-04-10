 jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value);
    }, "type the correct answer");

  jQuery.validator.addMethod('isname', function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9 ]+$/.test(value);
    }, "type the correct name");
  jQuery.validator.addMethod('isaddress', function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9,. ]+$/.test(value);
    }, "type the correct name");
  jQuery.validator.addMethod('iscontact', function (value, element) {
        return this.optional(element) || /^[0-9]+$/.test(value);
    }, "type the correct contact  number");
  jQuery.validator.addMethod('isnumber', function (value, element) {
        return this.optional(element) || /^[0-9]+$/.test(value);
    }, "type the correct numeric");
  jQuery.validator.addMethod('iscurreny', function (value, element) {
        return this.optional(element) || /^\d+(?:\.\d{0,2})?$/.test(value);
    }, "type the correct currency -_-");

  jQuery.validator.addMethod('isbitcoin', function (value, element) {
        return this.optional(element) || /^[0-9.]+$/.test(value);
    }, "Oops entered value does look like a valid Bitcoin amount");

  jQuery.validator.addClassRules("required",{
                required:true
           });
  jQuery.validator.addClassRules("iscurreny",{
                iscurreny:true
           });
  jQuery.validator.addClassRules("isemail",{
                email:true
           });
  jQuery.validator.addClassRules("isname",{
                isname: true
           });
  jQuery.validator.addClassRules("iscontact",{
                iscontact: true
           });
  jQuery.validator.addClassRules("isnumber",{
                isnumber: true
           });
  jQuery.validator.addClassRules("isdate",{
                date: true
           });


//extension: "jpg|jpeg|png|gif"
 $(document).ready(function(){
    "use strict";

    $.ajaxSetup({
        headers: { 'Auth': Utils.sourceMetaAuth , 'Access-Key' : Utils.sourceMetaKey , 'Access-Token' : Utils.sourceMetaAccessToken }
    });



  
    //Load New Duration
    $("[name='form_duration']").on('change',function(e){
        if($(this).val() == ''){
            Utils.toastr('warning','Select valid Investment Duration');
            $("[name='form_duration']").prop('selectedIndex', 0);
            $("[name='form_expected']").val('').prop('disabled', true);
        }
        else{
            var duration  = $(this).val();
            var amount  = $("[name='form_amount']").val();
            if($("[name='form_amount']").val() != ''){
                if(amount < 500){
                    $(this).removeClass('valid').addClass('error');
                    Utils.toastr('warning','Initial amount can not be less than 500.00');
                }else{
                    var profits = ((amount * 0.02) * duration);
                    var expected = (parseFloat(profits, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                    $("[name='form_expected']").val('R' + expected.replace(',', '') + ' - R' + (expected.replace(',', '')/4) + ' P/M' );
                }
                
            }
            else{
                Utils.toastr('warning','Enter Initial amount first');
                $("[name='form_duration']").prop('selectedIndex', 0);
                $("[name='form_expected']").val('').prop('disabled', true);
            }
        }
    });
    //end load options
    //
    ////Load New Duration
   


    $('#main-register-form').validate({
        rules: {
            form_amount: {
                required: true,
                minlength: 3,
                maxlength: 20,
                iscurreny: true,
                min: 500
            },
            form_duration: {
                required: true
            },
            form_title: {
                required: true
            },
            form_firstname: {
                required: true,
                minlength: 2,
                maxlength: 60,
                isname: true
            },
            form_surname: {
                required: true,
                minlength: 2,
                maxlength: 60,
                isname: true
            },
            form_comms: {
                required: true
            },
            form_contact: {
                required: {
                    depends: function () {
                        return $("[name='form_comms']").val() == "sms";
                    }
                },
                minlength: 10,
                maxlength: 15,
                iscontact: true
            },
            form_email: {
                required: {
                    depends: function () {
                        return $("[name='form_comms']").val() == "email";
                    }
                },
                maxlength: 60,
                email  : true
            },
            form_sponsor_code: {
                minlength: 6,
                maxlength: 60
            },
        },
        messages: {
            form_amount: {
                required: "Initial Amount is required",
                minlength: "Initial Amount must have at least 3 characters",
                maxlength: "Initial Amount is way too long - must be 6 chars or less",
                iscurreny: "Amount is not a valid currency e.g 500.00",
                min: "Investment amount can not be less than 500.00"
            },
            form_duration: {
                required: "Duration is required",
            },
            form_title: {
                required: "Title is required",
            },
            form_firstname: {
                required: "First name is required",
                minlength: "First name is must have at least 2 characters",
                maxlength: "First name is way too long - must be 60 chars or less",
                isname: "First name provided has some invalid characters",
            },
            form_surname: {
                required: "Surname is required",
                minlength: "Surname is must have at least 2 characters",
                maxlength: "Surname is way too long - must be 60 chars or less",
                isname: "Surname provided has some invalid characters",
            },
            form_comms: {
                required: "Communication is required",
            },
            form_contact: {
                required: "Contact number is required",
                minlength: "Contact number is must have at least 10 characters",
                maxlength: "Contact number is way too long - must be 13 chars or less",
                iscontact: "Contact number provided must be numbers only",
            },
            form_email: {
                required: "Email address is required",
                minlength: "Email address is must have at least 7 characters",
                maxlength: "Email address is way too long - must be 60 chars or less",
                email  : "Email provided is not valid - e.g, james@gmail.com"
            },
            form_sponsor_code: {
                minlength: "Sponsor code must have at least 6 characters",
                maxlength: "Sponsor code is way too long - must be 60 chars or less",
            },
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            $(form).find("[name='action_btn']").prop('disabled',true).html(Utils.fa('spinner','','fa-spin') + 'Please wait processing ...');
            
            $.ajax({
                    type: "POST",
                    url: AppURI + Utils.sourceApp,
                    data: $(form).serialize() + '&function=c2ltcGxlUmVnaXN0cmF0aW9u' ,
                    dataType: "json",
                    success: function(json) 
                    {
                       console.log(json);
                        if(json.group == 'validation'){
                            $('#' + json.control).focus();
                            Utils.toastr(json.type,json.msg);
                        }
                        else{
                            if(json.type == 'success'){
                                $(form)[0].reset();
                            }
                            Utils.toastr(json.type,json.msg);
                        }
                        $(form).find("[name='action_btn']").prop('disabled',false).html(Utils.fa('user') + 'Create Account Now !!');
                    }         
                });
        }
    });
    //forgot password modal form #

    $('body').on('click','.btn-quick-action-validate',function(event){
        event.preventDefault();
        var obj = $(this);
        var form = "#"+obj.data('form');
        var $validator = $(form).validate();
        if($(form).valid())
        {
           if(obj.data('api-action') === "followup")
            {
                $(form).find("[name='"+obj.data('btn')+"']").prop('disabled',true).html(Utils.fa('spinner','','fa-pulse') + obj.data('action-text'));
                $.ajax({
                        type: obj.data('method'),
                        url: Utils.sourceSecureApp + obj.data('api'),
                        data: $(form).serialize(),
                        dataType: "json",
                        success: function(json) 
                        {
                            if(json.group == 'validation'){
                                $(form).find("[name='"+json.control+"']").focus();
                                Utils.toastr(json.type,json.msg);
                            }
                            else{
                                if(json.type == 'success'){
                                    if(obj.data('clear-form') == "yes"){
                                        $(form)[0].reset();
                                    }
                                    if(obj.data('refresh-section') == "yes"){
                                        $("."+obj.data('section')).load(location.href+" ."+obj.data('section') +">*","");
                                    }
                                    
                                }
                                Utils.toastr(json.type,json.msg);
                            }
                            $(form).find("[name='"+obj.data('btn')+"']").prop('disabled',false).html(obj.data('text'));
                        }         
                    });
            }
        }
        else
        {
            Utils.toastr('danger','Some form field are required');
        }
        
    });


    $('body').on('click','.btn-quick-action-validate-upload',function(event){
        event.preventDefault();
        var obj = $(this);
        var form = "#"+obj.data('form');
        var $validator = $(form).validate();
        if($(form).valid())
        {
          $(form).submit();
        }
        else
        {
            Utils.toastr('danger','Some form field are required');
        }
        
    });

    $('body').on('click','.validate-form',function(event){
        event.preventDefault();
        


        var obj = $(this);
        var form = "#"+obj.data('form');
        var $validator = $(form).validate();
        if($(form).valid())
        {
          //$(form).submit();
           $.confirm({
                text: obj.data('modal-text'),
                title: obj.data('modal-title'),
                confirm: function(button) {
                    //-------------------
                    //$(form).submit();
                    //-------------------
                },
                cancel: function(button) {
                    // nothing to do
                },
                confirmButton: "Confirm",
                cancelButton: "Cancel",
                post: true,
                confirmButtonClass: "btn-primary btn-fill",
                cancelButtonClass: "btn-danger btn-fill",
                dialogClass: "modal-dialog"
            });
        }
        else
        {
            Utils.toastr('danger','Some form field are required');
        }
        
        
    });


    $("#register-form").validate({
    
        // Specify the validation rules
        rules: {
            firstname: "required",
            lastname: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
            agree: "required"
        },
        
        // Specify the validation error messages
        messages: {
            firstname: "Please enter your first name",
            lastname: "Please enter your last name",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy"
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('body').on('submit','.form-to-validate',function(event){
        event.preventDefault();
        var obj = $(this);

        var thisform = "#"+obj.attr('id');
        var thisformId = obj.attr('id');
        var $validator = $(thisform).validate();
        if($(thisform).valid())
        {
            $.confirm({
                text: obj.data('modal-text'),
                title: obj.data('modal-title'),
                confirm: function(button) {
                    //-------------------
                    //Utils.toastr('info',obj.data('modal-info'));
                    //$(thisform).submit();
                    document.getElementById(thisformId).submit()
                    //-------------------
                },
                cancel: function(button) {
                    // nothing to do
                },
                confirmButton: "Confirm",
                cancelButton: "Cancel",
                post: true,
                confirmButtonClass: "btn-primary btn-fill",
                cancelButtonClass: "btn-danger btn-fill",
                dialogClass: "modal-dialog"
            });
        }
        else
        {
            Utils.toastr('danger','Some form field are required');
        }
        
        
    });
    //$('body .validate-form').validate();



    $('body').on('click','.postQuick',function(event) {
        event.preventDefault();
        var obj = $(this);
        $.ajax({
            type: "POST",
            url: Utils.sourceSecureApp + obj.data('call'),
            data: obj.data('call-data') ,
            dataType: "json",
            success: function(json) 
            {
                if(json.group == 'validation'){
                    Utils.toastr(json.type,json.msg);
                }
                else{
                    if(json.type == 'success' || json.type == 'info'){
                        if(obj.data('act-on') == "timeline"){
                          $('#'+ obj.data('element')).delay(400).fadeOut(1000);  
                        }
                        
                    }

                    Utils.toastr(json.type,json.msg); 
                }
            }         
        });
    });























});