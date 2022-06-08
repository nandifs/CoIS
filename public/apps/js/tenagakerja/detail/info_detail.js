'use strict';

var tblTenagakerja;

function initObjPageTenagakerjaInfoDetail() {
    $('.btn-update').click(function () {
        const upd_id = $(this).data('id');
        let nip = $('#nip').val();
        
        if (nip != ""){            
            if (upd_id == "add"){
                //window.location.href = "/tenagakerja_add_detail";
                let url_get ="/tenagakerja_add_detail";                            
                sendGetData(url_get, nip, "nip");
            }else if(upd_id == "edit"){                                    
                let url_post ="/tenagakerja_edit_detail";
                sendPostData(url_post, nip, "nip");
            }else if(upd_id == "cari"){                                    
                let url_get ="/tenagakerja_info_detail";
                sendGetData(url_get, nip,"nip");
            }
        }else{            
            sweetAlertInfo("NIP tenaga kerja belum terisi.");
        }        
    });
}

function sendPostData(postURL, sendData, nameData = "postdata"){    
    var myForm = document.createElement("FORM");
    myForm.setAttribute("id","FromData");
    document.body.appendChild(myForm);

    var myInput = document.createElement("INPUT");
    myInput.setAttribute("name",nameData);
    myInput.setAttribute("type","text");
    myInput.setAttribute("value",sendData);
    document.getElementById("FromData").appendChild(myInput);
   
    // To submit the form: 
    myForm.method = "POST";
    myForm.action = postURL;
    myForm.submit();
}

function sendGetData(getURL, sendData, nameData = "getdata"){    
    var myForm = document.createElement("FORM");
    myForm.setAttribute("id","FromData");
    document.body.appendChild(myForm);

    var myInput = document.createElement("INPUT");
    myInput.setAttribute("name",nameData);
    myInput.setAttribute("type","text");
    myInput.setAttribute("value",sendData);
    document.getElementById("FromData").appendChild(myInput);
   
    // To submit the form: 
    myForm.method = "GET";
    myForm.action = getURL;
    myForm.submit();
}

$(function () {
    initObjPageTenagakerjaInfoDetail();
});
  