class Webcam {
  constructor(webcamElement, canvasElement = null, snapSoundElement = null, activeCamera = 0) {
    this._webcamElement = webcamElement;
    this._webcamElement.width = this._webcamElement.width || 640;
    this._webcamElement.height = this._webcamElement.height || video.width * (3 / 4);    
    this._webcamList = [];
    this._streamList = [];    
    this._selectedDeviceId = '';
    this._activeCamIdx = activeCamera;
    this._canvasElement = canvasElement;
    this._snapSoundElement = snapSoundElement;    
  }

  get webcamList(){
    return this._webcamList;
  }

  get webcamCount(){
    return this._webcamList.length;
  }

  get selectedDeviceId(){
    return this._selectedDeviceId;
  }   

  get getActiveCam(){
      return this._activeCamIdx;
  }

  set setActiveCam(value){
  this._activeCamIdx = value;
  }

  /* Get all video input devices info */
  getVideoInputs(mediaDevices){
    this._webcamList = [];
    mediaDevices.forEach(mediaDevice => {
      if (mediaDevice.kind === 'videoinput') {
        this._webcamList.push(mediaDevice);
      }
    });

    if(this._webcamList.length == 1){
      this._activeCamIdx = 0;     
    }
  
    this._selectedDeviceId = this._webcamList[this._activeCamIdx].deviceId;
    
    return this._webcamList;
  }

  /* Get media constraints */
  getMediaConstraints() {      
      var videoConstraints = {};
      videoConstraints.deviceId = { exact: this._selectedDeviceId};      
      var constraints = {
          video: videoConstraints,
          audio: false
      };
      return constraints;
  }

  /* Select camera based on facingMode */ 
  selectCamera(){          
    if (this._webcamList.length > 1){
      if (this._selectedDeviceId == ""){
        this._selectedDeviceId = this._webcamList[0].deviceId;
        this._activeCamIdx = 0;
      }else{          
        this._activeCamIdx = this._activeCamIdx + 1;        
        if (this._activeCamIdx > (this.webcamList.length - 1)){
          this._activeCamIdx = 0;
        }          
        this._selectedDeviceId = this._webcamList[this._activeCamIdx].deviceId;
      }                   
    }
  }

  /* Change Facing mode and selected camera */ 
  flip(){    
    this._webcamElement.style.transform = "";
    this.selectCamera();    
  }

  /*
    1. Get permission from user
    2. Get all video input devices info
    3. Select camera based on facingMode 
    4. Start stream
  */
  async start(startStream = true) {
    return new Promise((resolve, reject) => {  
      this.stop();      
      navigator.mediaDevices.getUserMedia(this.getMediaConstraints()) //get permisson from user
        .then(stream => {
          this._streamList.push(stream);
          this.info() //get all video input devices info
            .then(webcams =>{  
              this.stream();                      
              resolve(this._selectedDeviceId);              
            }) 
            .catch(error => {                
              reject(error);
            });
        })
        .catch(error => {          
            reject(error);
        });
    });
  }

  /* Get all video input devices info */ 
  async info(){        
    return new Promise((resolve, reject) => {            
      navigator.mediaDevices.enumerateDevices()
        .then(devices =>{
          this.getVideoInputs(devices);
          resolve(this._webcamList);
        }) 
        .catch(error => {            
          reject(error);
        });
    });
  }

  /* Start streaming webcam to video element */ 
  async stream() {
    return new Promise((resolve, reject) => {         
      navigator.mediaDevices.getUserMedia(this.getMediaConstraints())
        .then(stream => {
            this._streamList.push(stream);
            this._webcamElement.srcObject = stream;            
            this._webcamElement.play();
            resolve(this._selectedDeviceId);
        })
        .catch(error => {            
            reject(error);
        });
    });
  }

  /* Stop streaming webcam */ 
  stop() {
    this._streamList.forEach(stream => {
      stream.getTracks().forEach(track => {
        track.stop();
      });
    });   
  }

  snap() {
    if(this._canvasElement!=null){
      if(this._snapSoundElement!= null){
        this._snapSoundElement.play();
      }
      this._canvasElement.height = this._webcamElement.scrollHeight;
      this._canvasElement.width = this._webcamElement.scrollWidth;
      let context = this._canvasElement.getContext('2d');        
      context.clearRect(0, 0, this._canvasElement.width, this._canvasElement.height);
      context.drawImage(this._webcamElement, 0, 0, this._canvasElement.width, this._canvasElement.height);
      let data = this._canvasElement.toDataURL('image/png');
      return data;
    }
    else{
      throw "canvas element is missing";
    }
  } 
}