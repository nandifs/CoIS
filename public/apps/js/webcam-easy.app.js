'use strict';

var uriElement;
var imgElement;
var actCamera;

const webcamElement = document.getElementById("webcam");
const canvasElement = document.getElementById("canvas");
const snapSoundElement = document.getElementById("snapSound");

const webcam = new Webcam(
  webcamElement,
  canvasElement,
  snapSoundElement,
  0
);

function startCamera(imgElem, uriElem, actCam) {  
  imgElement = imgElem;
  uriElement = uriElem;
  actCamera = actCam;    
  $(".md-modal").addClass("md-show");    
  webcam.setActiveCam = actCamera;
  webcam.info() //get all video input devices info
  .then((result) =>{      
      webcam
      .start()
      .then((result) => {        
        cameraStarted();
        console.log("webcam started");
      })
      .catch((err) => {
        console.log("Error StartCamera : " + err);
        displayError(err);
      });
  });  
}

$("#cameraFlip").click(function () {
  webcam.flip();
  webcam.start();
});

function displayError(err = "") {
  if (err != "") {
    $("#errorMsg").html(err);
  }
  $("#errorMsg").removeClass("d-none");
}

function cameraStarted() {
  $("#errorMsg").addClass("d-none");
  $(".flash").hide();
  $(".webcam-container").removeClass("d-none");  
  if (webcam.webcamList.length > 1) {
    $("#cameraFlip").removeClass("d-none");        
  //  webcam.start();    
  }
  $("#wpfront-scroll-top-container").addClass("d-none");
  //window.scrollTo(0, 0);
  $("body").css("overflow-y", "hidden");
}

function cameraStopped() {
  $("#errorMsg").addClass("d-none");
  $("#wpfront-scroll-top-container").removeClass("d-none");
  $("#cameraFlip").addClass("d-none");
  $(".webcam-container").addClass("d-none");
  $("#webcam-caption").html("Click to Start Camera");
  $(".md-modal").removeClass("md-show");
}

$("#take-photo").click(function () {
  beforeTakePhoto();
  let picture = webcam.snap();

  var img_data = picture.replace(/^data:image\/(png|jpg);base64,/, "");

  imgElement.html('<img  src="' + picture + '" class="img-foto" />');
  uriElement.val(img_data);

  //document.querySelector("#download-photo").href = picture;

  afterTakePhoto();
});

function beforeTakePhoto() {
  $(".flash")
    .show()
    .animate({ opacity: 0.3 }, 500)
    .fadeOut(500)
    .css({ opacity: 0.7 });
  //window.scrollTo(0, 0);
  $("#cameraControls").addClass("d-none");
}

function afterTakePhoto() {
  webcam.stop();
  $("#canvas").removeClass("d-none");
  $("#take-photo").addClass("d-none");
  $("#cameraControls").removeClass("d-none");
  removeCapture();
  cameraStopped();
  $("body").css("overflow-y", "auto");
  console.log("webcam stopped");
}

function removeCapture() {
  $("#canvas").addClass("d-none");
  $("#cameraControls").removeClass("d-none");
  $("#take-photo").removeClass("d-none");
}

$("#resume-camera").click(function () {
  webcam.stream().then((facingMode) => {
    removeCapture();
  });
});

$("#exit-app").click(function () {
  removeCapture();
  cameraStopped();
  $("body").css("overflow-y", "auto");
  console.log("webcam stopped");
});
