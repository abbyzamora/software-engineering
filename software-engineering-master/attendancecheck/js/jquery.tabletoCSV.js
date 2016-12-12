jQuery.fn.tableToCSV = function(time,building,xlsxWriter,xlsxSheet,cell) {
    
    var clean_text = function(text){
        text = text.replace(/"/g, '""');
        return '"'+text+'"';
    };
    
	$(this).each(function(){
			var table = $(this);
			var caption = $(this).find('caption').text();
			var title = [];
			var rows = [];

			$(this).find('tr').each(function(){
				var data = [];
				$(this).find('th').each(function(){
                    var text = clean_text($(this).text());
					title.push(text);
					});
				$(this).find('td').each(function(){
                    var text = clean_text($(this).text());
					data.push(text);
					});
				data = data.join(",");
				rows.push(data);
				});
			title = title.join(",");
			rows = rows.join("\n");

			var csv = title + rows;
			// Date
			
		    // date = date + "-" + d.getMonth();
		    // date = date + "-"+d.getDay();


			var uri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
			var download_link = document.createElement('a');
			download_link.href = uri;
			var ts = new Date().getTime();

			if(caption==""){
				download_link.download =  date+".csv";
			} else {
				download_link.download = date+".csv";
			}
			var file = document.body.appendChild(download_link);
			download_link.click();
			console.log(rows);

			
           
            
             

			document.body.removeChild(download_link);
	});
    
};
