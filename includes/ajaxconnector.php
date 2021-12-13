<script>
  $(document).ready(function(){

      $(document).on('click', ".updateKRprogress", function(){
        var keyresultID = $(this).data('id');
        $.ajax({
          url:"ajax-getkeyresult.php",
          method:"POST",
          data:{keyresultID:keyresultID},
          dataType:"json",
          success:function(data){
            $("#keyresultprogress").val(data);
          }
        });
      });

      $(document).on('click', ".editKR", function(){
        var keyresultID = $(this).data('id');
        $.ajax({
          url:"ajax-getkeyresult.php",
          method:"POST",
          data:{keyresultID:keyresultID},
          dataType:"json",
          success:function(data){
            $("#editdependsobjective").val(data);
          }
        });
      });

      $(document).on('click', ".deleteKR", function(){
        var keyresultID = $(this).data('id');
        $.ajax({
          url:"ajax-getkeyresult.php",
          method:"POST",
          data:{keyresultID:keyresultID},
          dataType:"json",
          success:function(data){
            $("#editdependsobjective").val(data);
          }
        });
      });

      $(document).on('click', ".addA", function(){
        var keyresultID = $(this).data('id');
        $.ajax({
          url:"ajax-getkeyresult.php",
          method:"POST",
          data:{keyresultID:keyresultID},
          dataType:"json",
          success:function(data){
            $("#editdependsobjective").val(data);
          }
        });
      });

      $(document).on('click', ".updateAprogress", function(){
        var activitiesID = $(this).data('id');
        $.ajax({
          url:"ajax-getactivities.php",
          method:"POST",
          data:{activitiesID:activitiesID},
          dataType:"json",
          success:function(data){
            $("#activitiesprogress").val(data);
          }
        });
      });

      $(document).on('click', ".editA", function(){
        var activitiesID = $(this).data('id');
        $.ajax({
          url:"ajax-getactivities.php",
          method:"POST",
          data:{activitiesID:activitiesID},
          dataType:"json",
          success:function(data){
            $("#activitiesprogress").val(data);
          }
        });
      });

      $(document).on('click', ".deleteA", function(){
        var activitiesID = $(this).data('id');
        $.ajax({
          url:"ajax-getactivities.php",
          method:"POST",
          data:{activitiesID:activitiesID},
          dataType:"json",
          success:function(data){
            $("#activitiesprogress").val(data);
          }
        });
      });

      $(document).on('click', ".deleteG", function(){
        var groupID = $(this).data('id');
        $.ajax({
          url:"ajax-getgroup.php",
          method:"POST",
          data:{groupID:groupID},
          dataType:"json",
          success:function(data){
            $("#groupdetail").val(data);
          }
        });
      });

      $(document).on('click', ".deleteU", function(){
        var userID = $(this).data('id');
        $.ajax({
          url:"ajax-getuser.php",
          method:"POST",
          data:{userID:userID},
          dataType:"json",
          success:function(data){
            $("#userdetail").val(data);
          }
        });
      });

      $(document).on('click', ".addplan", function(){
        var userID = $(this).data('id');
        $.ajax({
          url:"ajax-getuser.php",
          method:"POST",
          data:{userID:userID},
          dataType:"json",
          success:function(data){
            $("#planname").val(data);
          }
        });
      });

    });
</script>