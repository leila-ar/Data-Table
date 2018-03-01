function data-hover($dataset,$cols, $fixedHeader = FALSE) {
  // This turns fixedHeader on or off
  if($fixedHeader == FALSE) {
    $tbl_fixed_header_option = "";
  }
  else {
    $tbl_fixed_header_option = "fixedHeader: true,";
  }
  echo "<script>";
  // To convert php array into javascript array
  echo "var cols = ". json_encode($cols) . ";\n";
  // End of converting php array into javascript array
  echo "
  function number-Commas(x,includeDollarSign) {
      inputValue = x;
      x = x.toString();
      x = x.split(\".\");
      decimalPart = x[1];
      // Concatinate zero to have 2 decimal value in the total amount
      if (inputValue.toString().includes(\".\"))
         decimalPart = (decimalPart.length==1) ?  decimalPart+\"0\" : decimalPart;
      intPart = x[0];
      var pattern = /(-?\d+)(\d{3})/;
      while (pattern.test(intPart))
          intPart = intPart.replace(pattern, \"$1,$2\");
      res = intPart;
      // Detect $ sign
      if (includeDollarSign)
         res = res
      // Detect whether total number is integer or float
      if (Number.isInteger(inputValue))
         return res
      else
         return res+\".\"+decimalPart;
  }
  $(document).ready(function() {
    $('#export_table').DataTable( {".
          $tbl_fixed_header_option.
          "select: true,
          dom:  \"<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>\" +
                \"<'row'<'col-sm-12'tr>>\" +
                \"<'row'<'col-sm-5'i><'col-sm-7'p>>\",
          buttons: [
            { extend: 'csv', footer: true, text: 'Export to Spreadsheet' }
        ],
          \"pageLength\": -1,
          \"lengthMenu\": [[10, 25, 50, 100, -1], [10, 25, 50, 100, \"All\"]],
          \"footerCallback\": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get actual numeral data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            /*
                // Iterate over numeric indexes for expected columns.
                // Calculate each row value times 100
                // Calculate total by deviding to 100
            */
            includeDollarSign = false;
            for (var i = 0; i < cols.length; i++) {
                colArray = api.column( cols[i] ).data().toArray();
                for (var j = 0; j < colArray.length; j++) {
                    if (colArray[j].includes(\"$\"))
                       includeDollarSign = true;
                    colArray[j] = parseFloat(intVal(colArray[j]))*100 ;
                }
                total = colArray.reduce( function (a, b) {
                    return (intVal(a) + intVal(b));
                }, 0 );
                total = total/100;
                // Update footer
                $( api.column( cols[i] ).footer() ).html(
                    number-Commas(total,includeDollarSign)
                );
            }
        }
    } );
  } );
  </script>
  <table class=\"table table-bordered table-hover\" id=\"export_table\" cellspacing=\"0\" width=\"100%\">
        <thead>
          <tr>";
              foreach ($dataset[0] as $column => $colvalue) {
                echo "<th style=\"text-align:left\">".$column."</th>";
              }
          echo "
          </tr>
        </thead>
        <tfoot>
            <tr><th>TOTAL</th>";
            // The firt footer column shows "Total"
            // ## Iterate footer columns from second colomn
                for ($i = 1; $i < count($dataset[0]); $i++) {
                   echo "<th style=\"text-align:left\"></th>";
                };
            echo "
            </tr>
        </tfoot>
        <tbody>";
           foreach($dataset as $column => $row_content) {
             echo "<tr>";
             foreach ($row_content as $key => $value) {
               echo "<td style=\"text-align:left\">".$value."</td>";
             }
             echo "</tr>";
           }
        echo "
        </tbody>
    </table>
";
}