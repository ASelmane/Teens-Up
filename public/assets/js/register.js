function maPosition(position) {
    var infopos = position.coords.latitude +";"+position.coords.longitude;
    document.getElementById("registration_form_last_location").value = infopos;
  }
  if(navigator.geolocation)
    navigator.geolocation.getCurrentPosition(maPosition);
  
  var form1 = document.getElementById("form1")
  var form2 = document.getElementById("form2")
  var form3 = document.getElementById("form3")

  var prenom = document.getElementById("form1").value
  var email = document.getElementById("form1").value
  var mdp = document.getElementById("form1").value
  var ddn_year = document.getElementById('registration_form_ddn_year').value
  var ddn_month = document.getElementById('registration_form_ddn_month').value
  var ddn_day = document.getElementById('registration_form_ddn_day').value


  var tab = []
  
  var agreeTerms = document.getElementById("registration_form_agreeTerms");
  
  var submit1 = document.getElementById("submit1")
  var submit2 = document.getElementById("submit2")
  var submit3 = document.getElementById("submit3")
  
  agreeTerms.addEventListener("change", function(){
      if((agreeTerms.checked) && (prenom != '' ) && (email != '') && (mdp != '') && (ddn_year != '') && (ddn_month != '') && (ddn_day!= '')){
          submit1.classList.remove("disabled")
      }
      else submit1.classList.add("disabled")
  })
  
  submit1.addEventListener("click", function(){
    if(submit1.className == "boutton btn active"){
      form1.classList.toggle("active")
      submit1.classList.toggle("active")
  
      form2.classList.toggle("active")
      submit2.classList.toggle("active")
    }
  })
  
  submit2.addEventListener("click", function(){
    form2.classList.toggle("active")
    submit2.classList.toggle("active")

    form3.classList.toggle("active")
    submit3.classList.toggle("active")
  })

  function rangeSlide(value) {
    document.getElementById('rangeValue').innerHTML = value;
  }

  var ddn = document.getElementById('registration_form_ddn');

  ddn.addEventListener('input', function(){
      var ddn_array = ddn.value.split("-");
      ddn_year = document.getElementById('registration_form_ddn_year').value = ddn_array[0];
      ddn_month = document.getElementById('registration_form_ddn_month').value = ddn_array[1];
      ddn_day = document.getElementById('registration_form_ddn_day').value = ddn_array[2];

  })