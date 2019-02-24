function validateForm() {
  var validForm = true;
  var fee = document.forms["updateForm"]["fee"].value;
  var time = document.forms["updateForm"]["time"].value;
  var date = new Date(document.forms["updateForm"]["date"].value);
  var dateString = document.forms["updateForm"]["date"].value;

  if (fee == "") {
    document.getElementById("invalidFee").innerHTML =
    "Session Fee is required!";
    if($(window).width() > 575){
      document.getElementById("invalidFeeIcon").style.visibility = "visible";
      document.getElementById("successFeeIcon").style.visibility = "hidden";
      document.getElementById("feeGroup").className = "form-group has-error has-feedback";
    }
    validForm = false;
  }
  else if (fee < 0){
    document.getElementById("invalidFee").innerHTML =
    "Session Fee cannot be negative!";
    if($(window).width() > 575){
      document.getElementById("invalidFeeIcon").style.visibility = "visible";
      document.getElementById("successFeeIcon").style.visibility = "hidden";
      document.getElementById("feeGroup").className = "form-group has-error has-feedback";
    }
    validForm = false;
  }
  else{
    document.getElementById("invalidFee").innerHTML = "";
    if ($(window).width() > 575){
      document.getElementById("invalidFeeIcon").style.visibility = "hidden";
      document.getElementById("successFeeIcon").style.visibility = "visible";
      document.getElementById("feeGroup").className = "form-group has-success has-feedback";
    }
  }

  if (time == "") {
    document.getElementById("invalidTime").innerHTML =
    "Session Time is required!";
    if ($(window).width() > 575){
      document.getElementById("invalidTimeIcon").style.visibility = "visible";
      document.getElementById("successTimeIcon").style.visibility = "hidden";
      document.getElementById("timeGroup").className = "form-group has-error has-feedback";
    }
    validForm = false;
  }
  else{
    document.getElementById("invalidTime").innerHTML = "";
    if ($(window).width() > 575){
      document.getElementById("invalidTimeIcon").style.visibility = "hidden";
      document.getElementById("successTimeIcon").style.visibility = "visible";
      document.getElementById("timeGroup").className = "form-group has-success has-feedback";
    }
  }

  if (dateString == ""){
    document.getElementById("invalidDate").innerHTML =
    "Session Date is required!";
    if ($(window).width() > 575){
      document.getElementById("invalidDateIcon").style.visibility = "visible";
      document.getElementById("successDateIcon").style.visibility = "hidden";
      document.getElementById("dateGroup").className = "form-group has-error has-feedback";
    }
    validForm = false;
  }
  else if (date < new Date()){
    document.getElementById("invalidDate").innerHTML =
    "Invalid session date!";
    if ($(window).width() > 575){
      document.getElementById("invalidDateIcon").style.visibility = "visible";
      document.getElementById("successDateIcon").style.visibility = "hidden";
      document.getElementById("dateGroup").className = "form-group has-error has-feedback";
    }
    validForm = false;
  }
  else{
    document.getElementById("invalidDate").innerHTML = "";
    if ($(window).width() > 575){
      document.getElementById("invalidDateIcon").style.visibility = "hidden";
      document.getElementById("successDateIcon").style.visibility = "visible";
      document.getElementById("dateGroup").className = "form-group has-success has-feedback";
    }
  }

  return validForm;
}
