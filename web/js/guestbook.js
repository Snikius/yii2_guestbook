var guestbook=(function() {
    var modelName="guestbookform";
  
    var updateCaptcha = function() {
         var src=$("#guestbookform-verifycode-image").attr("src");
         var link=src.indexOf("&") !== -1 ? src.substr(0, src.indexOf("&")) : src;
         var rand=Math.floor(Math.random() * (99999 + 1)) + 1000;
         $("#guestbookform-verifycode-image").attr("src",link+"&"+rand);
    };
    
    var refresh = function(form) {
        var formId=$(form).attr("id");
        var fieldClass="#"+formId+" .form-group";
        $(fieldClass).removeClass("has-success");
        $(fieldClass).removeClass("has-error");
        $(fieldClass+" .help-block").text("");
        $(fieldClass+" input").val("");
        $(fieldClass+" textarea").val("");
        $.pjax.reload({container:'#pjaxwidget'});
    };
    
    var setError=function(message,attribute) {
        var fieldClassName=".field-"+modelName+"-"+attribute.toLowerCase();
        $(fieldClassName).removeClass("has-success");
        $(fieldClassName).addClass("has-error");
        $(fieldClassName+" .help-block").text(message);
    };
    
    var lockView=function(form) {
        var formId=$(form).attr("id");
        var value=$("#"+formId+" button").text();
        $("#"+formId+" button").attr('data-value',value);
        $("#"+formId+" button").text("Отправка...");
        $("#"+formId+" button").prop('disabled',true);
    };
    
    var unlockView=function(form) {
        var formId=$(form).attr("id");
        var value=$("#"+formId+" button").attr('data-value');
        $("#"+formId+" button").text(value);
        $("#"+formId+" button").prop('disabled',false);
    };
    
    var showSendedMessage=function() {
        $(".jsGuestbookMessage").removeClass("hidden");
        $(".jsForm").hide(500);
    };
    
    var hideSendedMessage=function() {
        $(".jsGuestbookMessage").addClass("hidden");
    };
    var procError=function(xhr) {
        if(typeof xhr.message == "undefined") {
            alert("Ошибка");
        } else {
            var data = $.parseJSON(xhr.message);
            for(var i in data) {
                setError(data[i],i);
            }
        }
    };
    var public_func={
        submit: function(form) {
            var data=$(form).serializeArray();
            hideSendedMessage();
            lockView(form);
            $.ajax({
               url: form.attr('action'),
               type: 'POST',
               dataType: "json", 
               data: data              
           }) .done(function(data,status,xhr) {
               showSendedMessage();
               refresh(form);
               unlockView(form);
               updateCaptcha();
           }).fail(function(xhr,status,error) { 
               procError(xhr.responseJSON);
               unlockView(form);
               updateCaptcha();
           }); 
        },
        captchaInit: function() { 
            $("#guestbookform-verifycode-image").on("click", function() {
                updateCaptcha();
                return false;
            });
        }
    };
    return public_func;
})();
