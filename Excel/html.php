<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <input type="file" id="my_file_input" />
    <div id='my_file_output'></div>

</body>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="shim.js"></script>
<script src="jszip.js"></script>
<script src="xlsx.js"></script>

<script>

    $('#my_file_input').change(function(){
        readFile();
    });
    

    function readFile() {
        var files=document.getElementById('my_file_input').files;

        var i,f;
        for (i = 0, f = files[i]; i != files.length; ++i) {
            var reader = new FileReader();
            var name = files[0].name;
            reader.onload = function(e) {
                var data = e.target.result;
               
                //var wb = XLSX.read(data, {type: 'binary'});
                var arr = String.fromCharCode.apply(null, new Uint8Array(data));

                var wb = XLSX.read(btoa(arr), {type: 'base64'});

                process_wb(wb);
            };
            //reader.readAsBinaryString(f);
            reader.readAsArrayBuffer(f);
        }
    }

    function process_wb(wb) {
        var output = "";


        /*output = JSON.stringify(to_json(wb), 2, 2);
        */
        output = to_json(wb);


        $.ajax({
          type:'POST',
          url: '/Swengg/Excel/insertCheckedRooms.php',
          data:{"data":output},
          success:function(data){
            alert(data);
          },
           error : function(jqXHR, textStatus, errorThrown) {

            alert(textStatus);
            alert(errorThrown);
        },
        
        });



    console.log(output);
}

function to_json(workbook) {
    var result = {};
    workbook.SheetNames.forEach(function(sheetName) {
        var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);

        if(roa.length > 0){
            result[sheetName] = roa;

        }
    });
    return result;
}

    /*var tarea = document.getElementById('b64data');
    function b64it() {
        var wb = XLSX.read(tarea.value, {type: 'base64'});
        process_wb(wb);
    }
    */
    



   /* function get_radio_value( radioName ) {
        var radios = document.getElementsByName( radioName );
        for( var i = 0; i < radios.length; i++ ) {
            if( radios[i].checked ) {
                return radios[i].value;
            }
        }
    }*/

    

    /* function to_csv(workbook) {*/
  /*      var result = [];
        workbook.SheetNames.forEach(function(sheetName) {
            var csv = XLSX.utils.sheet_to_csv(workbook.Sheets[sheetName]);
            if(csv.length > 0){
                result.push("SHEET: " + sheetName);
                result.push("");
                result.push(csv);
            }
        });
        return result.join("\n");
    }
     
    function to_formulae(workbook) {
        var result = [];
        workbook.SheetNames.forEach(function(sheetName) {
            var formulae = XLSX.utils.get_formulae(workbook.Sheets[sheetName]);
            if(formulae.length > 0){
                result.push("SHEET: " + sheetName);
                result.push("");
                result.push(formulae.join("\n"));
            }
        });
        return result.join("\n");
    }*/



   /* function handleDragover(e) {
        e.stopPropagation();
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
    }
     
    if(drop.addEventListener) {
        drop.addEventListener('dragenter', handleDragover, false);
        drop.addEventListener('dragover', handleDragover, false);
        drop.addEventListener('drop', handleDrop, false);
    }*/
</script>
</html>
