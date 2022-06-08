'use strict';

/** 
 * Fungsi konversi full date to mysql date.
 * @return dd-mm-yyyy hh:dd:ss
 */
 var ubah_tanggal_to_mysql = function (mydate) {
  
  var gdate = [
    mydate.getFullYear(),
      ('0' + (mydate.getMonth() + 1)).slice(-2),
      ('0' + mydate.getDate()).slice(-2)
  ].join('-');

  var gtime = [
    ('0' + mydate.getHours()).slice(-2),
      ('0' + mydate.getMinutes()).slice(-2),
      ('0' + mydate.getSeconds()).slice(-2)
  ].join(':');
  
  var rdate = gdate + " " + gtime;

  return rdate;
};

/** 
 * Fungsi mengambil tanggal hari ini.
 * @return dd-mm-yyyy 
 */
var CurrentDate = function (fdate) {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, "0");
    var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
    var yyyy = today.getFullYear();
  
    if (fdate=="indo"){
      today = dd + "/" + mm + "/" + yyyy;
    }else if (fdate=="eng"){
      today = mm + "/" + dd + "/" + yyyy;
    }else if (fdate=="mysql"){
      today = yyyy + "-" + mm + "-" + dd;
    }
    
  
    return today;
};

/** 
 * Fungsi mengambil jam saat ini.
 * 
 * @return hh:mm:ss
 */
var CurrentTime = function () {
    var today = new Date();
    var hh = today.getHours();
    var mm = String(today.getMinutes()).padStart(2, "0");
    var ss = String(today.getSeconds()).padStart(2, "0");

    today = hh + ":" + mm + ":" + ss;

    return today;
};

/** 
 * Fungsi untuk mengubah susunan format tanggal 
 * Dari English to MySQL 
 * -> mm/dd/yyyy ke yyyy-mm-dd 
 */
function ubah_tgl_etm(tanggal)
{
  let pisah, larik, satukan;

  pisah = tanggal.split('/');
  larik = new Array(pisah[2], pisah[0], pisah[1]);
  satukan = larik.join('-');

  return satukan;
}

/** 
 * Dari MySQL to English 
 * -> yyyy-mm-dd ke mm/dd/yyyy 
 **/
function ubah_tgl_mte(tanggal)
{
  let pisah, larik, satukan;

  pisah = tanggal.split('-');
  larik = new Array(pisah[1], pisah[2], pisah[0]);
  satukan = larik.join('/');

  return satukan;
}

/** 
 * Dari Indonesia to MySQL 
 * -> dd/mm/yyyy ke yyyy-mm-dd */
function ubah_tgl_itm(tanggal)
{
    let pisah, larik, satukan;

    pisah = tanggal.split('/');
    larik = new Array(pisah[2], pisah[1], pisah[0]);
    satukan = larik.join('-');

    return satukan;
}

/** 
 * Dari MySQL to Indonesia 
 * -> yyyy-mm-dd ke dd/mm/yyyy 
 **/
function ubah_tgl_mti(tanggal)
{
    let pisah, larik, satukan;

    pisah = tanggal.split('-');    
    larik = new Array(pisah[2], pisah[1], pisah[0]);
    satukan = larik.join('/');

    return satukan;
}

/** 
 * Ambil bln dan Tahun Dari Tgl MySQL
 * -> yyyy-mm-dd ke mmyyyy 
 **/
 function ubah_tgl_mtmy(tanggal)
 {
     let pisah, larik, satukan;
 
     pisah = tanggal.split('-');    
     larik = new Array(pisah[1],pisah[0]);
     satukan = larik.join('');
 
     return satukan;
 }

/** 
 * Fungsi post ke http
 * @param arg1 Ignore result 
 * @param arg2 Post without additional Data
 * @param arg3 Post with additional Data
 */
$.postJSON = function(arg1, arg2, arg3) {
    var pnlDebug;

    //Check methode overloading
    if (arguments.length == 1) {
        $.post(arg1, arg2, 'json').fail(function(xhr, textStatus, errorThrown) {            
            pnlDebug = $('#debug_content'); 
            if (typeof pnlDebug != "undefined") {
                pnlDebug.html(xhr.responseText);
                pnlDebug.show();
            }else{
                alert(xhr.responseText);
                console.log("Error 1 : " + xhr.responseText)
            }            
        });
    }else if (arguments.length == 2) {
        $.post(arg1, arg2, 'json').fail(function(xhr, textStatus, errorThrown) {            
            pnlDebug = $('#debug_content'); 
            if (typeof pnlDebug != "undefined") {
                pnlDebug.html(xhr.responseText);
                pnlDebug.show();
            }else{
                alert(xhr.responseText);
                console.log("Error 2 : " + xhr.responseText)
            }            
        });
    } else if (arguments.length == 3) {        
        $.post(arg1, arg2, arg3, 'json').fail(function(xhr, textStatus, errorThrown) {            
            pnlDebug = $('#debug_content'); 
            if (typeof objDebug != "undefined") {
                pnlDebug.html(xhr.responseText);
                pnlDebug.show();
            }else{
                alert("Error 3 : " + xhr.responseText);
            }            
        });
    }
}

/** 
 * Fungsi SweetAlert Confirm For Delete Record
 * @param stitle title alert 
 * @param postaddr Post Address 
 */
function sweetAlertDelete(stitle, postaddr, dataTable) {
  Swal.fire({
    title: 'HAPUS DATA\n' + stitle + ' ?',
    text: "Data yang terhapus, tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus saja!'
  }).then((result) => {    
    if (result.isConfirmed) {  
      $.LoadingOverlay("show");
      $.postJSON(postaddr,function(data, status){
        if (status=="success"){
          if (data.status=="success"){
            let cekTable = dataTable.split(":");            
            if (cekTable[0]=='reload'){
              $('#' + cekTable[1]).DataTable().ajax.reload();
            }else{              
                deleteTableRow(dataTable.split("|"));
            }            
            Swal.fire(
              'Hapus Data!',
              'Data telah terhapus.',
              'success'
            )
          }else{
            Swal.fire(
              'GAGAL HAPUS DATA!',
              'Data tidak berhasil di hapus.',
              'warning'
            )
          }          
        }else{
          Swal.fire(
            'GAGAL HAPUS DATA!',
            'Data tidak berhasil di hapus.',
            'warning'
          )
        }
        $.LoadingOverlay("hide");
      });
    }
  })
}

function insertTableRow(dataTable){  
  let xTable, xRow, xCell, lRows, newData, nCtr, xCheckRow;

  //get table
  xTable = document.getElementById(dataTable.name);
  
  //get count rows
  lRows = xTable.rows.length;
  
  //check first row
  xCheckRow = xTable.rows[1].cells[0].innerHTML;
  if (xCheckRow=="No data available in table"){
    dataTable.irow = "first";
  }

  //insert row

  if (dataTable.irow=="first"){
    xTable.deleteRow(1);
    xRow = xTable.insertRow(1);
  }else{
    xRow = xTable.insertRow(lRows);
  }

  //insert cell
  xCell = xRow.insertCell(0);
  xCell.innerHTML =  lRows + ".";
  newData = dataTable.data;  
  
  nCtr = 1;
  newData.forEach(element => {
    xCell = xRow.insertCell(nCtr);
    xCell.innerHTML = element.value;
    nCtr++;
  }); 

  if(dataTable.irow=="first"){
    lRows = xTable.rows.length;
    //set number rows
    for (nCtr=1; nCtr<lRows; nCtr++){
      xCell = xTable.rows[nCtr].cells;
      xCell[0].innerHTML = nCtr + ".";
    } 
  }
}

function updateTableRow(dataTable){  
  let xTable, xRow, xCell, newData, nCtr;

  //get table
  xTable = document.getElementById(dataTable.name);
    
  //update row    
  newData = dataTable.data;  
  
  nCtr = 1;
  xRow = xTable.rows[dataTable.irow];

  newData.forEach(element => {
    xCell = xRow.cells[nCtr];
    xCell.innerHTML = element.value;
    nCtr++;
  }); 
}

function deleteTableRow(dataTable){
  let xTable, xCell, lRows, nCtr;
  
  //get table
  xTable = document.getElementById(dataTable[0]);
  
  //deleted row
  xTable.deleteRow(dataTable[1]);
  
  //get count rows
  lRows = xTable.rows.length;

  //set number rows
  for (nCtr=1; nCtr<lRows; nCtr++){
    xCell = xTable.rows[nCtr].cells;
    xCell[0].innerHTML = nCtr + ".";
  }    
}

/** 
 * Create default action for coloum action in data table
 * @param dataId data/record id/ 
 * @returns button for action coloumn
 */
function createDefaultAction(dataId){
  let btnAksi ='<div class="btn-group"> <button type="button" class="btn btn-success btn-sm" title="Edit" data-id="' + dataId + '" onclick="updateData(this);"><i class="fa fa-edit"></i> Edit</button> <button type="button" class="btn btn-danger btn-sm" title="Hapus" data-id="' + dataId + '" onclick="deleteData(this);"><i class=" fa fa-trash-alt"></i> Hapus</button></div>';

  return btnAksi;
}

/** 
 * Reset Form Data
 * @param form Form Id/Name 
 */
function resetForm($form) {  
  $form.find('input:text, input:hidden, input:password, input:file, textarea').val('');
  $form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
  $form.find('select').prop("selectedIndex", 0);
}

/**
 * Check if object exist
 * @param name Object name
 */
function isObjExist(objName) {
  var elem = document.getElementById(objName);  
  if (elem !== null){
    return true;
  }
  return false;
}

/**
 * Check if object exist by class name
 * @param name Object name
 */
 function isObjExistByClassName(className) {
  var elem = document.getElementsByClassName(className);  
  if (elem.length !== 0){
    return true;
  }
  return false;
}

/**
 * Add zero to text
 *  
 * @param string $text text after add zero
 * @param string|null $title text for first text
 * @param int $length of all text
 * 
 * @return mixed
 */
 function addZeroSpaces(vtext, vtitle, vlength)
 {
     if (vlength == 0) {
         return vtitle + vtext;
     } else {
         let lenoftext = vtext.length;
         let lenofchar = vlength - lenoftext;
         let azero = "";
         for (let i = 0; i < lenofchar; i++) {
          azero = azero + "0";
         }
         return vtitle + azero + vtext;
     }
 }