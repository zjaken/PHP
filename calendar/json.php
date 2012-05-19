

<!doctype html public "-//w3c//dtd html 4.01 transitional//en">
<html>
<head>
<title>show.html</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">

    
    <script src="../jquery-1.7.2.js"></script>
        
        <!-- include touch.js on desktop browsers only -->
        <script>
			$(document).ready(function(){
			$.getJSON("http://www.google.com/calendar/feeds/zj.aken@googlemail.com/public/full?alt=json-in-script&callback=?"
				,function(data){
					//得到事件数量总和
					var html = '';

					
					var event_time="";
					var event_where="";

					var event_startTime="";
					var event_endTime="";

					//循环出所有的事件
					$.each(data.feed.entry, function(i,entry) {

						
						//得到事件标题、时间、地点、内容
						//if(i==3) return false;


						//alert("alert");
						if(entry.gd$when != undefined){
							event_startTime = entry.gd$when[0].startTime;
							//alert(event_startTime);
							event_endTime = entry.gd$when[0].endTime;
							//event_time = event_startTime.split("-")[0] + ' ' + event_startTime.split("-")[1].split(".")[0] +' - '+ event_endTime.split("-")[0]+' '+ event_endTime.split("-")[1].split(".")[0];


							event_time = event_startTime + "  " + event_endTime;
						}

						event_where = (entry.gd$where[0].valueString == undefined)?"":entry.gd$where[0].valueString;
						
						html += '<ul>';
						html += '<li><strong>事件:</strong> ' + entry.title.$t + '</li>';
						html += '<li><strong>时间:</strong>'+ event_time +'</li>';
						html += '<li><strong>地点:</strong> ' + event_where + '</li>';
						html += '<li><strong>内容:</strong> ' + entry.content.$t + '</li>';
						html += '</ul>';

						
					});

					


					//将数据输入到相关的DIV中
					$('#gcalendar').html(html);
				});
			});
        </script>
<?php
echo "我的日历";
?>
</head>
<body>

<hr></hr>
<div id="gcalendar">

</body>
</html>
