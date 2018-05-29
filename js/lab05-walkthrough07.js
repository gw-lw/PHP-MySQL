var daysOfWeek = new Array("Monday","Tuesday","Wednesday", "Thursday", "Friday");
document.write(daysOfWeek+"<br>");
daysOfWeek.push("Saturday");
document.write(daysOfWeek+"<br/>");
daysOfWeek.unshift("Sunday");
document.write(daysOfWeek+"<br/>");
document.write("<table border=1><tr>");
for (var i = 0; i < daysOfWeek.length; i++){document.write("<th>"+daysOfWeek[i]+"</th>");}
document.write("</tr>");
for (var i = 1; i < 8; i++){document.write("<td>"+i+"</td>");}
document.write("</tr>");
for (var i = 8; i < 15; i++){document.write("<td>"+i+"</td>");}
document.write("</tr>");
for (var i = 15; i < 22; i++){document.write("<td>"+i+"</td>");}
document.write("</tr>");
for (var i = 22; i < 29; i++){document.write("<td>"+i+"</td>");}
document.write("</tr>");
for (var i = 29; i < 31; i++){document.write("<td>"+i+"</td>");}
document.write("</tr>");