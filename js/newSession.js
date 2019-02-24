function addSession(){
  var table = document.getElementById('addedSessionTable');
  var row = table.insertRow(1);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(5);
  var cell7 = row.insertCell(6);
  var cell8 = row.insertCell(7);
  var cell9 = row.insertCell(8);
  var cell10 = row.insertCell(9);


  cell1.outerHTML = document.getElementById('id1').innerHTML;
  cell2.outerHTML = document.getElementById('title1').innerHTML;
  cell3.outerHTML = document.getElementById('date1').innerHTML;
  cell4.outerHTML = document.getElementById('time1').innerHTML;
  cell5.outerHTML = document.getElementById('fee1').innerHTML;
  cell6.outerHTML = document.getElementById('type1').innerHTML;
  cell7.outerHTML = document.getElementById('trainer1').innerHTML;
  cell8.outerHTML = document.getElementById('specialty1').innerHTML;
  cell9.outerHTML = document.getElementById('rating1').innerHTML;
  cell10.outerHTML = document.getElementById('status1').innerHTML;
}
