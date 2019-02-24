function validatePersonalForm() {
  var validSession = true;
  var date = new Date(document.forms["personalForm"]["date"].value);
  var fee = (document.forms['personalForm']['fee'].value);

    if (date < new Date()){
      document.getElementById('invalidPDate').innerHTML = "Date cannot be before today.";
      validSession = false;
    }
    else {
      document.getElementById('invalidPDate').innerHTML = "";
    }

    if (fee < 0){
      document.getElementById('invalidPFee').innerHTML = "Fee cannot be less than 0.";
      validSession = false;
    }
    else {
      document.getElementById('invalidPFee').innerHTML = "";
    }

    return validSession;
}

function validateGroupForm() {
    var validSession = true;
    var date = new Date(document.forms["groupForm"]["date"].value);
    var fee = document.forms["groupForm"]["fee"].value;
    var pax = document.forms["groupForm"]["pax"].value;

    if (date < new Date()) {
        document.getElementById('invalidGrpDate').innerHTML = "Date cannot be before today.";
        validSession = false;
    }
    else{
      document.getElementById('invalidGrpDate').innerHTML = "";
    }

    if (fee < 0){
      document.getElementById('invalidGrpFee').innerHTML = "Fee cannot be less than 0.";
      validSession = false;
    }
    else {
      document.getElementById('invalidGrpFee').innerHTML = "";
    }

    if (pax <= 1){
      document.getElementById('invalidGrpParticipants').innerHTML = "Participants cannot be 1 or less.";
      validSession = false;
    }
    else {
      document.getElementById('invalidGrpParticipants').innerHTML = "";
    }

    return validSession;
}
