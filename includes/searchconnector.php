<script type="text/javascript">
$(document).ready(function(){
  function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }
    

    var chinese = 
    {
      "sProcessing":"处理中...",
      "sLengthMenu": "显示 _MENU_ 项结果",
      "sZeroRecords":"没有匹配结果",
      "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
      "sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
      "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
      "sInfoPostFix":  "",
      "sSearch":       "搜索:",
      "sUrl":          "",
      "sEmptyTable":     "表中数据为空",
      "sLoadingRecords": "载入中...",
      "sInfoThousands":  ",",
      "oPaginate": {
          "sFirst":    "首页",
          "sPrevious": "上页",
          "sNext":     "下页",
          "sLast":     "末页"
      },
      "oAria": {
          "sSortAscending":  ": 以升序排列此列",
          "sSortDescending": ": 以降序排列此列"
      }
    };
    var malay = 
    {
       "sProcessing":   "Sedang proses...",
       "sLengthMenu":   "Tampilan _MENU_ entri",
       "sZeroRecords":  "Tidak ditemukan data yang sesuai",
       "sInfo":         "Tampilan _START_ sampai _END_ dari _TOTAL_ entri",
       "sInfoEmpty":    "Tampilan 0 hingga 0 dari 0 entri",
       "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
       "sInfoPostFix":  "",
       "sSearch":       "Cari:",
       "sUrl":          "",
       "oPaginate": {
           "sFirst":    "Awal",
           "sPrevious": "Balik",
           "sNext":     "Lanjut",
           "sLast":     "Akhir"
       }
    };
    var english = 
    {
      "sEmptyTable":     "No data available in table",
      "sInfo":           "Showing _START_ to _END_ of _TOTAL_ entries",
      "sInfoEmpty":      "Showing 0 to 0 of 0 entries",
      "sInfoFiltered":   "(filtered from _MAX_ total entries)",
      "sInfoPostFix":    "",
      "sInfoThousands":  ",",
      "sLengthMenu":     "Show _MENU_ entries",
      "sLoadingRecords": "Loading...",
      "sProcessing":     "Processing...",
      "sSearch":         "Search:",
      "sZeroRecords":    "No matching records found",
      "oPaginate": {
          "sFirst":    "First",
          "sLast":     "Last",
          "sNext":     "Next",
          "sPrevious": "Previous"
      },
      "oAria": {
          "sSortAscending":  ": activate to sort column ascending",
          "sSortDescending": ": activate to sort column descending"
      }
    }

    var lang = getUrlVars()["lang"];
    if(lang === "en"){
      var langset1 = english;
    }else if(lang === "zh"){
      var langset1 = chinese;
    }else if(lang === "bm"){
      var langset1 = malay;
    }else{
      var langset1 = english;
    }

	//Search and view
  $('#okrloglist').DataTable( {
        "language" : langset1,
        "ordering": false,
        initComplete: function () {
            this.api().columns([]).every( function () {
                var column = this;
                var select = $('<select class="custom-select custom-select-sm"><option value="">All</option></select>')
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }

        
    } );

  $('#krhistory').DataTable( {
        "language" : langset1,
        "ordering": false,
        initComplete: function () {
            this.api().columns([0]).every( function () {
                var column = this;
                var select = $('<select class="custom-select custom-select-sm"><option value="">All</option></select>')
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }

        
    } );

  $('#dahistory').DataTable( {
        "language" : langset1,
        "ordering": false,
        initComplete: function () {
            this.api().columns([0]).every( function () {
                var column = this;
                var select = $('<select class="custom-select custom-select-sm"><option value="">All</option></select>')
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }

        
    } );

    $('#objectivelog').DataTable({
      "language" : langset1,
        "searching": false,
        "ordering": false,
        "info": false,
        "scrollCollapse": true

    });

    $('#keyresultlog').DataTable({
      "language" : langset1,
        "searching": false,
        "ordering": false,
        "info": false,
        "scrollCollapse": true

    });

    $('#activitieslog').DataTable({
      "language" : langset1,
        "searching": false,
        "ordering": false,
        "info": false,
        "scrollCollapse": true

    });

    $('#usersatcompanymembership').DataTable( {
      "language" : langset1,
      "ordering": false,
      initComplete: function () {
          this.api().columns([1,2]).every( function () {
              var column = this;
              var select = $('<select class="custom-select custom-select-sm"><option value="">All</option></select>')
                  .appendTo( $(column.header()) )
                  .on( 'change', function () {
                      var val = $.fn.dataTable.util.escapeRegex(
                          $(this).val()
                      );

                      column
                          .search( val ? '^'+val+'$' : '', true, false )
                          .draw();
                  } );

              column.data().unique().sort().each( function ( d, j ) {
                  select.append( '<option value="'+d+'">'+d+'</option>' )
              } );
          } );
      }

      
  } );

    $('#usersgroupmembership').DataTable( {
      "language" : langset1,
      "ordering": false,
      initComplete: function () {
          this.api().columns([1,2]).every( function () {
              var column = this;
              var select = $('<select class="custom-select custom-select-sm"><option value="">All</option></select>')
                  .appendTo( $(column.header()) )
                  .on( 'change', function () {
                      var val = $.fn.dataTable.util.escapeRegex(
                          $(this).val()
                      );

                      column
                          .search( val ? '^'+val+'$' : '', true, false )
                          .draw();
                  } );

              column.data().unique().sort().each( function ( d, j ) {
                  select.append( '<option value="'+d+'">'+d+'</option>' )
              } );
          } );
      }

      
  } );

    $('#submitreporttable').DataTable( {
      "language" : langset1,
      "ordering": false,
      initComplete: function () {
          this.api().columns([2,3]).every( function () {
              var column = this;
              var select = $('<select class="custom-select custom-select-sm"><option value="">All</option></select>')
                  .appendTo( $(column.header()) )
                  .on( 'change', function () {
                      var val = $.fn.dataTable.util.escapeRegex(
                          $(this).val()
                      );

                      column
                          .search( val ? '^'+val+'$' : '', true, false )
                          .draw();
                  } );

              column.data().unique().sort().each( function ( d, j ) {
                  select.append( '<option value="'+d+'">'+d+'</option>' )
              } );
          } );
      }

      
  } );

});

</script>