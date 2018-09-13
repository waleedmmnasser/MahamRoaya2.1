<h1>صفحة المهام</h1>
<div style="width:90%; font-size:20px">
    <input id="currentTasksOpt" type="radio" name="tasksOptions" value="CurrentTasks" checked>
    <label for="currentTasksOpt">مهامي الحالية (قيد التنفيذ)</label>
    <input id="allTasksOpt" type="radio" name="tasksOptions" value="AllTasks">
    <label for="allTasksOpt">    جميع مهامي</label>
    <input id="someTasksOpt" type="radio" name="tasksOptions" value="SomeTasks">
    <label for="someTasksOpt">مهامي خلال فترة:  </label>
    <label style="font-size:17px">من تاريخ </label>
    <input id="fromTaskDate" type="date" name="fromTaskDate" disabled />
    <label style="font-size:17px">إلى تاريخ </label>
    <input id="toTaskDate" type="date" name="toTaskDate" disabled />
    <button class="w3-btn w3-white w3-border w3-round-large" id="showDatedTasks" style="font-size:17px; font-weight:bold" disabled>
        اعرض
    </button>
</div>
<br>
<div id="table-wrapper">
    <div id="table-scroll">
        <table class="w3-table w3-bordered">
            <thead>
                <tr>
                    <th>وصف المهمة</th>
                    <th>تاريخ التكليف</th>
                    <th>موعد التسليم</th>
                    <th style="width:30px">نسبة الإنجاز</th>
                    <th style="width:80px">ملاحظات</th>
                </tr>
            </thead>
            <tbody id="tasksTblBody">
                <?php echo $this->empCrntTasks; ?>
            </tbody>
        </table>
    </div>
</div>
<br>
<div id="updateMessage"></div>
<br><br>
<label style="font-weight:bold; font-size:18px; text-decoration:underline">مهام الموظفين التابعين لك</label>
<br><br>
<?php if ($this->isManager) { ?>
    <label>اختر أحد الموظفين</label>
    <select id="subordinatesList" name="subordinatesList">
        <?php
            foreach($this->subEmps as $emp)
                echo "<option value='" . $emp->getId() . "'>" . $emp->getFullName() . "</option>";
        ?>
    </select>
    <br><br>
    <label>مهام الموظف</label>
    <table class="w3-table w3-bordered">
        <thead>
        <tr>
            <th>وصف المهمة</th>
            <th>تاريخ التكليف</th>
            <th>التاريخ المحدد للتسليم</th>
            <th>نسبة الإنجاز</th>
            <th>ملاحظات</th>
            <th>تأجيل</th>
            <th>إلغاء</th>
        </tr>
        </thead>
        <tbody id="subOrdTasksTblBody"></tbody>
    </table>
    <br><br><br>
    <div id="newSubOrdTaskDiv" style="width:60%" disabled>
        <div class="w3-border">
            <div class="w3-container w3-blue">
                <h3>لإضافة مهمة جديدة</h3>
            </div>
            <form class="w3-container">
                <label>الوصف</label><input class="w3-input" id="taskDesc" type="text" name="taskDesc" /><br>
                <label>ساعة التسليم</label><input class="w3-input" id="taskDueTime" type="time" name="taskDueTime" /><br>
                <label>التاريخ المحدد للتسليم</label><input class="w3-input" id="taskDueDate" type="date" name="taskDueDate" /><br>
                <label>ملاحظات</label><input class="w3-input" id="taskNote" type="text" name="taskNote" /><br>
                <button id="addSubordNewTask" class="w3-btn w3-white w3-border w3-round-large">أضف</button>
            </form>
        </div>
    </div>
    <div id="taskAdditionMsg"></div>
<?php } ?>

<script>
    $(function(){
        $("#subordinatesList").change(function(){
            //alert($("#subordinatesList option:selected").val());

            $("#newSubOrdTaskDiv").prop("disabled", false);

            $.ajax({
                    type: "POST",
                    url: "tasks/getSubordinateCurrentTasks",
                    //contentType: "application/json; charset=utf-8",
                    data: "subEmpId=" + $("#subordinatesList option:selected").val(),
                    //dataType: "json",
                })
                .done(function(data) {
                    //alert("Ajax done");
                    //alert(data);
                    if (!data.includes("<script>"))
                        $("#subOrdTasksTblBody").html(data);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    alert("Ajax failed");
                    //var err = eval("(" + jqXHR.responseText + ")");
                    //alert(err.Message);
                    //jQuery.parseJSON(jqXHR.responseText);
                    alert(errorThrown);
                });
        });

        $("#updateTasks").click(function(){
            try {
                $("#updateMessage").html('');
                //alert("User name: " + $("#login").val());
                //alert($("#loginForm").serialize());
                var tasksUpdates = [];
                $("#tasksTblBody tr").each(function() {
                    var taskVals = { progress: "", notes: "" };

                    $(this).find("input").each(function() {
                        if ($(this).attr("id").startsWith("prgr"))
                            taskVals.progress = $(this).val();
                        else if ($(this).attr("id").startsWith("note"))
                            taskVals.notes = $(this).val();
                    });

                    tasksUpdates.push(taskVals);
                });
                $.ajax({
                    type: "POST",
                    url: "tasks/update",
                    //contentType: "application/json; charset=utf-8",
                    data: tasksUpdates,
                    //dataType: "json",
                })
                .done(function(data) {
                    //alert("Ajax done");
                    //alert(data);
                    if (!data.includes("<script>"))
                        $("#updateMessage").html(data);
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
            }
        });

        $("#addSubordNewTask").click(function(){
            try {
                $("#taskAdditionMsg").html('');
                alert("Saving subord task...");
                //alert($("#subordinatesList option:selected").attr("value"));

                var newTaskInfo = "subOrdId=" + $("#subordinatesList option:selected").val()
                                + "&desc=" + $("#taskDesc").val()
                                + "&dueDate=" + $("#taskDueDate").val() 
                                + "&dueTime=" + $("#taskDueTime").val() 
                                + "&notes=" + $("#taskNote").val();
                
                alert("Task: " + newTaskInfo);
                
                $.ajax({
                    type: "POST",
                    url: "tasks/addNewTaskForSubordinate",
                    //contentType: "application/json; charset=utf-8",
                    data: newTaskInfo,
                    //dataType: "json",
                })
                .done(function(data) {
                    alert("Back from server");
                    alert(data);
                    if (!data.includes("<script>"))
                        $("#taskAdditionMsg").html(data);
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
            }
        });

        $("#currentTasksOpt").change(function() {
            //alert("Some tasks");
            $("#fromTaskDate").prop("disabled", true); $("#toTaskDate").prop("disabled", true);
            $("#showDatedTasks").prop("disabled", true);

            try {
                $("#tasksTblBody").html('');
                
                $.ajax({
                    type: "POST",
                    url: "tasks/getEmployeeCurrentTasks",
                })
                .done(function(data) {
                    //alert("Got all tasks");
                    //alert(data);
                    if (!data.includes("<script>"))
                        $("#tasksTblBody").html(data);
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

        $("#allTasksOpt").change(function() {
            //alert("Some tasks");
            $("#fromTaskDate").prop("disabled", true); $("#toTaskDate").prop("disabled", true);
            $("#showDatedTasks").prop("disabled", true);

            try {
                $("#tasksTblBody").html('');
                
                $.ajax({
                    type: "POST",
                    url: "tasks/getEmployeeAllTasks",
                })
                .done(function(data) {
                    //alert("Got all tasks");
                    //alert(data);
                    if (!data.includes("<script>"))
                        $("#tasksTblBody").html(data);
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

        $("#someTasksOpt").change(function() {
            //alert("Some tasks");
            $("#fromTaskDate").prop("disabled", false); $("#toTaskDate").prop("disabled", false);
            $("#showDatedTasks").prop("disabled", false);
        });

        $("#showDatedTasks").click(function() {
            //alert("Some tasks");
            try {
                $("#tasksTblBody").html('');
                
                var dateRange = "fromDate=" + $("#fromTaskDate").val() + "&toDate=" + $("#toTaskDate").val();

                $.ajax({
                    type: "POST",
                    url: "tasks/getEmployeeDatedTasks",
                    data: dateRange,
                })
                .done(function(data) {
                    //alert("Got all tasks");
                    //alert(data);
                    if (!data.includes("<script>"))
                        $("#tasksTblBody").html(data);
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