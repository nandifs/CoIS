'use strict';

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 5000
});

function sweetAlert(stitle) {  
  Toast.fire({
      icon: "success",
      title: stitle,
  });
}

function sweetDangerAlert(stitle) {
  Toast.fire({
      icon: "error",
      title: stitle,
  });
}

function sweetAlertInfo(tMessage, tTitle, tFooter) {
  if (arguments.length == 1) {    
    Swal.fire({
      icon: 'info',
      title: 'Oops',
      text: tMessage
    })
  }else if (arguments.length == 2) {    
    Swal.fire({
      icon: 'info',
      title: tTitle,
      text: tMessage
    })
  }else{
    Swal.fire({
      icon: 'info',
      title: tTitle,
      text: tMessage,
      footer: tFooter
    })
  }  
}

function sweetAlertError(tMessage, tTitle, tFooter) {
  if (arguments.length == 1) {    
    Swal.fire({
      icon: 'error',
      title: 'Oops',
      text: tMessage
    })
  }else if (arguments.length == 2) {    
    Swal.fire({
      icon: 'error',
      title: tTitle,
      text: tMessage
    })
  }else{
    Swal.fire({
      icon: 'error',
      title: tTitle,
      text: tMessage,
      footer: tFooter
    })
  }  
}