'use strict';

var tblKontrakPKS;

function initObjPageKontrak() {
    $('.btn-aksi').click(function () {
        let url_aksi = "";
        const aksi = $(this).data('id');
        const cmdAksi = aksi.split("|");
        
        console.log(cmdAksi);
        if (cmdAksi[1] != ""){
            if (cmdAksi[0] == "detail"){                
                url_aksi ="/kontrak_pks_detail/" + cmdAksi[1];
            }else if(cmdAksi[0] == "edit"){                                    
                url_aksi ="/kontrak_pks_edit/" + cmdAksi[1];
            }else if(cmdAksi[0] == "delete"){                                    
                url_aksi ="/kontrak_pks_delete/" + cmdAksi[1];            
            }

            window.location = url_aksi;
        }else{            
            sweetAlertInfo("Data Kontrak belum dipilih.");
        }        
    });
}


$(function () {
    initObjPageKontrak();
});