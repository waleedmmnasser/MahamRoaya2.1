<center><h1>شاشة الدخول</h1></center>

<form id="loginForm">
    <div dir="rtl">
        <label>اسم الدخول</label><input id="loginNm" type="text" name="loginName" /><br>
        <label>كلمة المرور</label><input id="userPassword" type="password" name="password" /><br>
    <div>
    <input id="loginBtn" type="button" value="ادخل"/>
    <div id="loginMessage"></div>
</form>

<script>
    $(function(){
        $("#loginBtn").click(function(){
            try {
                $("#loginMessage").html('');
                //alert("User name: " + $("#loginNm").val());
                //alert($("#loginForm").serialize());
                
                var loginInfo = "loginName=" + $("#loginNm").val() + "&password=" + $("#userPassword").val();
                //alert(loginInfo);
                
                $.ajax({
                    type: "POST",
                    url: "login/run",
                    //contentType: "application/json; charset=utf-8",
                    //data: $("#loginForm").serialize(),
                    data: loginInfo,
                    //dataType: "json",
                })
                .done(function(data) {
                    //alert("Ajax done");
                    //alert(data);
                    if (!data.includes("<script>"))
                        $("#loginMessage").html(data);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    alert("Ajax failed");
                    //var err = eval("(" + jqXHR.responseText + ")");
                    //alert(err.Message);
                    //jQuery.parseJSON(jqXHR.responseText);
                    alert(errorThrown);
                });
            }
            catch(err) {
                alert("Error");
                alert(err.message);
            }
        });
    });
</script>