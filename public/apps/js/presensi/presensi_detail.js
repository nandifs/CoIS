function onClickPreviousButton(mitrakerja_id, periode, actionkey){
    var myForm = document.createElement("FORM");
    myForm.setAttribute("id","FromData");
    document.body.appendChild(myForm);
  
    var myInput1 = document.createElement("INPUT");    
    var myInput2 = document.createElement("INPUT");    
    var myInput3 = document.createElement("INPUT");
  
    myInput1.setAttribute("name","dtakses");
    myInput1.setAttribute("type","text");
    myInput1.setAttribute("value",mitrakerja_id);
  
    myInput2.setAttribute("name","periode");
    myInput2.setAttribute("type","text");
    myInput2.setAttribute("value",periode);

    myInput3.setAttribute("name","cmdaksi");
    myInput3.setAttribute("type","text");
    myInput3.setAttribute("value",actionkey);
  
    document.getElementById("FromData").appendChild(myInput1);
    document.getElementById("FromData").appendChild(myInput2);
    document.getElementById("FromData").appendChild(myInput3);
   
    // To submit the form: 
    myForm.method = "POST";
    myForm.action = "/presensi";
    myForm.submit();    
  }