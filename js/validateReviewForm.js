/**
  This function will validate the form when input is invalid.
*/
function validateForm2() {
  var radios = document.getElementsByName("rating");
  var formValid = false;

  var i = 0;
  while (!formValid && i < radios.length) {
    if (radios[i].checked)
    formValid = true;
    i++;
  }

  if (!formValid)
  document.getElementById("text").innerHTML= "Please choose your rating!";
  return formValid;
}
