
 $(document).ready(function(){
    //"use strict";

    /*var url = $('#url').val(); 
    var optionRequest = "";

    $.ajaxSetup({
        headers: { 'Appauth': Utils.sourceMetaAuth , 'Appapikey' : Utils.sourceMetaKey }
    });
    */

    $.ajaxSetup({ cache: false });






   


    

    

    

    $('body').find('.dataTable').DataTable({
      "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "iDisplayLength" : 50
    });


    $('body').find('.dataTableLimit').DataTable({
      "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "iDisplayLength" : 10
    });




    function registerEvents()
    {
       
        $(".timeago").timeago();

        $('.expireDate').countdown({ date: $(this).data('date'),
              render: function(data){
                var text = this.leadingZeros(data.days, 2) + ' day(s) ' + this.leadingZeros(data.hours, 2) + ":" + this.leadingZeros(data.min, 2) + ":" + this.leadingZeros(data.sec, 2);
                $(this.el).text((text == "00:00:00" || text == "00 day(s) 00:00:00" ) ? "Expired" : text );
              },
              onEnd: function(){
                $(this.el).removeClass('label-success').addClass('label-important');
                $(this.el).text('Expired');
              } 
          });

        $('.dataTable').DataTable({
              "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "iDisplayLength" : 50
            });

        $('.tip').tooltip();
    }


    

   $('body').find(".timeago").timeago();



    $('body').on('click','.actionBtnValidate',function(event){
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
                     $(form).submit();
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



    $('body').on('submit','.actionBtnValidatePOST',function(event){
        event.preventDefault();

        var obj = $(this);
        var form = "#"+obj.attr('id');
        var thisformId = obj.attr('id');
        var $validator = $(form).validate();
        if($(form).valid())
        {
            //-------------------
              document.getElementById(thisformId).submit()
            //-------------------
        }
        else
        {
            Utils.toastr('danger','Some form field are required');
        }        
    });




    $('body').on('submit','.actionBtnValidateConfirmPOST',function(event){
        event.preventDefault();

        var obj = $(this);
        var form = "#"+obj.attr('id');
        var thisformId = obj.attr('id');
        var $validator = $(form).validate();
        if($(form).valid())
        {
            //-------------------
            $.confirm({
                text: obj.data('modal-text'),
                title: obj.data('modal-title'),
                confirm: function(button) {
                    //-------------------
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
              
            //-------------------
        }
        else
        {
            Utils.toastr('danger','Some form field are required');
        }        
    });




    //enable
    $('body').on('click','.enable-check', function(event){  
        var obj = $(this);          
        if(obj.is(':checked')){
            $('body').find("[name='"+obj.data('btn')+"']").prop('disabled',false);                
        }
        else{
            $('body').find("[name='"+obj.data('btn')+"']").prop('disabled',true);                 
        }
    });

    $('.tip').tooltip();
















$('body').on('submit','.actionBtnValidateAJAX',function(event){
        event.preventDefault();
        var obj = $(this);
        var form = "#"+obj.attr('id');
        var $validator = $(this).validate();
        if($(this).valid())
        {
          
            //-------------------
            $.ajax({
                type: "POST",
                data: $(form).serialize(),
                url: Utils.sourceSecureApp + obj.data('api'),
                dataType: "json",
                success: function(json){
                  Utils.toastr(json.type,json.msg);
                }         
            });
            //-------------------
        }
        else
        {
            Utils.toastr('danger','Some form field are required');
        }        
    });








































});


