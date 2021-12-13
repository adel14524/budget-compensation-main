<script>
    $(document).ready(function(){
    <?php
    if($userlevel === "Chief"){
    ?>
        //For add Objective
        $("#corporate").hide();
        $("#company").hide();
        $("#group").hide();
        $("#personal").hide();

        //For edit Objective
        $("#editcorporate").hide();
        $("#editcompany").hide();
        $("#editgroup").hide();
        $("#editpersonal").hide();

    <?php
    }elseif($userlevel === "Superior"){
    ?>
        //For add Objective
        $("#cp").hide();
        $("#cphide").hide();
        $("#corporate").hide();
        $("#company").hide();
        $("#group").hide();
        $("#personal").hide();

        //For edit Objective
        $("#editcp").hide();
        $("#editcphide").hide();
        $("#editcorporate").hide();
        $("#editcompany").hide();
        $("#editgroup").hide();
        $("#editpersonal").hide();

    <?php
    }elseif ($userlevel === "Manager") {
    ?>
        //For add Objective
        $("#corporate").hide();
        $("#company").hide();
        $("#group").hide();
        $("#personal").hide();
        $("#cp").hide();
        $("#cphide").hide();
        $("#c").hide();
        $("#chide").hide();

        //For edit Objective
        $("#editcorporate").hide();
        $("#editcompany").hide();
        $("#editgroup").hide();
        $("#editpersonal").hide();
        $("#editcp").hide();
        $("#editcphide").hide();
        $("#editc").hide();
        $("#editchide").hide();

    <?php
    }elseif ($userlevel === "Personal") {
    ?>
        //For add Objective
        $("#corporate").hide();
        $("#company").hide();
        $("#group").hide();
        $("#personal").hide();
        $("#cp").hide();
        $("#cphide").hide();
        $("#c").hide();
        $("#chide").hide();
        $("#g").hide();
        $("#ghide").hide();

        //For edit Objective
        $("#editcorporate").hide();
        $("#editcompany").hide();
        $("#editgroup").hide();
        $("#editpersonal").hide();
        $("#editcp").hide();
        $("#editcphide").hide();
        $("#editc").hide();
        $("#editchide").hide();
        $("#editg").hide();
        $("#editghide").hide();

    <?php
    }
    ?>
        //For add Objective
        $("#cp").click(function(){
        $("#corporate").show();
        $("#company").hide();
        $("#group").hide();
        $("#personal").hide();

        $("#corporate .sharedID").prop({"disabled":false});

        $("#company .sharedID").prop({"disabled":true});
        $("#company .alignID").prop({"disabled":true});

        $("#group .sharedID").prop({"disabled":true});
        $("#group .alignID").prop({"disabled":true});

        $("#personal .sharedID").prop({"disabled":true});
        $("#personal .alignID").prop({"disabled":true});
        });

        $("#c").click(function(){
        $("#corporate").hide();
        $("#company").show();
        $("#group").hide();
        $("#personal").hide();

        $("#corporate .sharedID").prop({"disabled":true});

        $("#company .sharedID").prop({"disabled":false});
        $("#company .alignID").prop({"disabled":false});

        $("#group .sharedID").prop({"disabled":true});
        $("#group .alignID").prop({"disabled":true});

        $("#personal .sharedID").prop({"disabled":true});
        $("#personal .alignID").prop({"disabled":true});
        });

        $("#g").click(function(){
        $("#corporate").hide();
        $("#company").hide();
        $("#group").show();
        $("#personal").hide();

        $("#corporate .sharedID").prop({"disabled":true});

        $("#company .sharedID").prop({"disabled":true});
        $("#company .alignID").prop({"disabled":true});

        $("#group .sharedID").prop({"disabled":false});
        $("#group .alignID").prop({"disabled":false});

        $("#personal .sharedID").prop({"disabled":true});
        $("#personal .alignID").prop({"disabled":true});
        });

        $("#p").click(function(){
        $("#corporate").hide();
        $("#company").hide();
        $("#group").hide();
        $("#personal").show();

        $("#corporate .sharedID").prop({"disabled":true});

        $("#company .sharedID").prop({"disabled":true});
        $("#company .alignID").prop({"disabled":true});

        $("#group .sharedID").prop({"disabled":true});
        $("#group .alignID").prop({"disabled":true});

        $("#personal .sharedID").prop({"disabled":false});
        $("#personal .alignID").prop({"disabled":false});
        });

        //For edit Objective
        $("#editcp").click(function(){
        $("#editcorporate").show();
        $("#editcompany").hide();
        $("#editgroup").hide();
        $("#editpersonal").hide();

        $("#editcorporate .sharedID").prop({"disabled":false});

        $("#editcompany .sharedID").prop({"disabled":true});
        $("#editcompany .alignID").prop({"disabled":true});

        $("#editgroup .sharedID").prop({"disabled":true});
        $("#editgroup .alignID").prop({"disabled":true});

        $("#editpersonal .sharedID").prop({"disabled":true});
        $("#editpersonal .alignID").prop({"disabled":true});
        });

        $("#editc").click(function(){
        $("#editcorporate").hide();
        $("#editcompany").show();
        $("#editgroup").hide();
        $("#editpersonal").hide();

        $("#editcorporate .sharedID").prop({"disabled":true});
        $("#editcorporate .alignID").prop({"disabled":true});

        $("#editcompany .sharedID").prop({"disabled":false});
        $("#editcompany .alignID").prop({"disabled":false});

        $("#editgroup .sharedID").prop({"disabled":true});
        $("#editgroup .alignID").prop({"disabled":true});

        $("#editpersonal .sharedID").prop({"disabled":true});
        $("#editpersonal .alignID").prop({"disabled":true});
        });

        $("#editg").click(function(){
        $("#editcorporate").hide();
        $("#editcompany").hide();
        $("#editgroup").show();
        $("#editpersonal").hide();

        $("#editcorporate .sharedID").prop({"disabled":true});

        $("#editcompany .sharedID").prop({"disabled":true});
        $("#editcompany .alignID").prop({"disabled":true});

        $("#editgroup .sharedID").prop({"disabled":false});
        $("#editgroup .alignID").prop({"disabled":false});

        $("#editpersonal .sharedID").prop({"disabled":true});
        $("#editpersonal .alignID").prop({"disabled":true});
        });

        $("#editp").click(function(){
        $("#editcorporate").hide();
        $("#editcompany").hide();
        $("#editgroup").hide();
        $("#editpersonal").show();

        $("#editcorporate .sharedID").prop({"disabled":true});

        $("#editcompany .sharedID").prop({"disabled":true});
        $("#editcompany .alignID").prop({"disabled":true});

        $("#editgroup .sharedID").prop({"disabled":true});
        $("#editgroup .alignID").prop({"disabled":true});

        $("#editpersonal .sharedID").prop({"disabled":false});
        $("#editpersonal .alignID").prop({"disabled":false});
    });

        $("#addgroupundercompany").hide();
        $("#addgroupundergroup").hide();

        $("#grouptypecompany").click(function(){
            $("#addgroupundercompany").show();
            $("#addgroupundergroup").hide();
        });

        $("#grouptypegroup").click(function(){
            $("#addgroupundercompany").hide();
            $("#addgroupundergroup").show();
        });

        $("#editgroupundercompany").hide();
        $("#editgroupundergroup").hide();

        $("#editgrouptypecompany").click(function(){
            $("#editgroupundercompany").show();
            $("#editgroupundergroup").hide();
        });

        $("#editgrouptypegroup").click(function(){
            $("#editgroupundercompany").hide();
            $("#editgroupundergroup").show();
        });
    });
</script>