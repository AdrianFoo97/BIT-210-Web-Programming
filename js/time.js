/**
  THis function will check the local time
  whether it is morning and afternoon
  and will change the greeting according
  to the time.
*/
function checkTime(){
var today = new Date();
var curHr = today.getHours();
var greetingString ="";

if (curHr < 12) {
  greetingString = "Good morning!";
} else if (curHr < 18) {
  greetingString = "Good afternoon!";
} else {
  greetingString = "Good evening!";
}
document.write(greetingString);
}
