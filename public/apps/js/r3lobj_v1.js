function xBox(xcontainer,xid,xstyle,xcaption){
	var objContainer = document.getElementById(xcontainer);
	xcaption=(xcaption != undefined) ? xcaption : '';
	objContainer.innerHTML +="<div id=" + xid +" style='position:absolute;"+xstyle+"'>"+xcaption+"</div>";
}

function xPnlAnim(xid){	
	var objNewContainer = document.getElementById(xid);	
	var xWidth=objNewContainer.clientWidth;
	var xHeight=objNewContainer.clientHeight;
	var xStop = Math.round(xWidth/10);
	var xDivHeight= (xHeight/xStop);
	var xCtr=0;
	showAnim(xid,xCtr,xStop,xDivHeight);
	objNewContainer.style.width=xWidth+"px";	
}

function xIFrame(xcontainer,xid,xsrc,xstyle){
	var objContainer = document.getElementById(xcontainer);
	iFrame="<iframe src='"+xsrc+"' id="+xid+" name="+xid+" width='100%' height='100%' style='"+xstyle+"'> <p>Your browser does not support iframes.</p> </iframe>"			
	objContainer.innerHTML +=iFrame;
}

function xPanel(xcontainer,xid,xstyle){
	var objContainer = document.getElementById(xcontainer);
	objContainer.innerHTML +="<div id=" + xid +" style='position:absolute;"+xstyle+"'></div>";
}

function xMenuBar(xcontainer,xid,xstyle,xitemmenu){
	var objContainer = document.getElementById(xcontainer);
	var sitemmenu=xitemmenu.split(",");
	var sstr="";
	var nctr=0;
	var larray=sitemmenu.length;	
	for (nctr=0;nctr<larray;nctr++){
		sstr =sstr+" <td style='background-color:inherit;'><div id=" + xid + nctr + " style='cursor: pointer;');'>|<a href='javascript: execMenuBar("+nctr+")'>" + sitemmenu[nctr] +"</a> &nbsp; &nbsp;</div></td>";
	}	
	objContainer.innerHTML +="<div id=" + xid + " style='position:absolute;"+xstyle+"'> <table><tr style='font-weight:bold'>" + sstr + "</tr></table></div>";	
}

function xLabel(xcontainer,xid,xcaption,xstyle){
	var objContainer = document.getElementById(xcontainer);	
	objContainer.innerHTML += "<div id="+xid+" style='position:absolute;"+xstyle+"'>" + xcaption + "</div>";
}

function xInput(xcontainer,xid,xstyle,xsize,xmaxlength){
	var objContainer = document.getElementById(xcontainer);		
	objContainer.innerHTML += "<input id="+xid+" style='position:absolute;"+xstyle+"' type='text' size="+xsize+" maxlength="+xmaxlength+"> </input>";	
}

function xInputWithKeyboard(xcontainer,xid,xstyle,xsize,xmaxlength){
	var objContainer = document.getElementById(xcontainer);		
	objContainer.innerHTML += "<input id="+xid+" class='keyboardInput' style='position:absolute;"+xstyle+"' type='text' size="+xsize+" maxlength="+xmaxlength+"> </input>";	
}

function xInputPassword(xcontainer,xid,xstyle,xsize,xmaxlength){
	var objContainer = document.getElementById(xcontainer);		
	objContainer.innerHTML += "<input id="+xid+" style='position:absolute;"+xstyle+"' type='password' size="+xsize+" maxlength="+xmaxlength+"> </input>";	
}

function xTextArea(xcontainer,xid,xstyle,xcols,xrows){
	var objContainer = document.getElementById(xcontainer);	
	objContainer.innerHTML += "<textarea style='position:absolute;font-family:Arial;"+ xstyle +"' id=" + xid + " cols=" + xcols + " rows=" + xrows + "></textarea>";	
}

function xCombo(xcontainer,xid,xoptvalue,xcaption,xstyle,x){
	var soptval=xoptvalue.split(",");
	var scaption=xcaption.split(",");
	var sstr="";
	var nctr=0;
	var larray=soptval.length;

	for (nctr=0;nctr<larray;nctr++){
		sstr =sstr+" <option value='" + soptval[nctr] + "'> " + scaption[nctr] + "</option>";
	}

	var objContainer = document.getElementById(xcontainer);
	objContainer.innerHTML +="<select id=" + xid + " style='position:absolute;"+xstyle+"'>" + sstr + " </select>";
}

function xCheckBox(xcontainer,xid,xvalue,xstyle){		
	var objContainer = document.getElementById(xcontainer);		
	objContainer.innerHTML +="<input id='" + xid + "' style='position:absolute;" + xstyle + "' type='checkbox' value='"+xvalue+"'>";	
} 

function xAddItemCombo(xcombo,xvalue,xtext){	
	var opt = document.createElement("option");
	opt.value = xvalue;
	opt.text = xtext;
	document.getElementById(xcombo).options.add(opt);
}

function xButton(xcontainer,xid,xcaption,xonclick,xstyle){ //STANDART BUTTON
	var objContainer = document.getElementById(xcontainer);
	xBtn = "<button id=" + xid + " onclick='"+xonclick+"' style='position:absolute;"+xstyle+"'>" + xcaption + "</button>";
	objContainer.innerHTML +=xBtn;
}

function xBButton(xcontainer,xid,xcaption,xonclick,xstyle){ //BOX BUTTON
	var objContainer = document.getElementById(xcontainer);	
	xBtn = "<div id="+xid+" onclick='"+xonclick+"' style='height:15px;position:absolute;cursor:pointer;padding:1px;font-family:arial;font-size:12px;text-align:center;background-color: #FFFFFF;border: solid 1px #D8D8D8;box-shadow: 2px 2px 2px #888888;"+xstyle+"'>" + xcaption + "</div>"		
	objContainer.innerHTML += xBtn;	
}

function xFButton(xcontainer,xid,xcaption,xonclick,xstyle){ //FLAT BUTTON
	var objContainer = document.getElementById(xcontainer);
	xBtn = "<div id="+xid+" onclick='"+xonclick+"' style='height:15px;width:50px;text-align:center;position:absolute; cursor:pointer;"+xstyle+"'>" + xcaption + "</div>"	
	objContainer.innerHTML += xBtn;	
}

function xLines(xcontainer,xid,xstyle,xlength,xcolor){
	var objContainer = document.getElementById(xcontainer);
	objContainer.innerHTML +="<div id=" + xid +" style='position:absolute;margin:0;"+xstyle+"'><table><tr><td width='" + xlength +"' style='background-color:"+ xcolor +"'></td></tr></table></div>";	
}

function xDLine(xcontainer,xid,xstyle){//Draw Lines
	var objContainer = document.getElementById(xcontainer);
	objContainer.innerHTML +="<div id=" + xid +" style='position:absolute;"+xstyle+"'></div>";	
}

function xTableBlank(xcontainer,xid,xheader,xstyle){	
	var objContainer = document.getElementById(xcontainer);	
	var xheader;
	var sstr1="";
	var sstr2="";
	var nctr=0;
	
	var larray=xheader.length;	
	
	for (nctr=0;nctr<larray;nctr++){
		sstr1 =sstr1+" <th style='background-color:#999999;'>"+ xheader[nctr] +"</th>";
		sstr2 =sstr2+" <td>&nbsp</td>";
	}
	objContainer.innerHTML +="<div id=" + xid + " style='position:absolute;border: solid 1px #D8D8D8; overflow:auto;"+xstyle+"'> <table   border=0  style='width:100%;'>"+sstr1+" <tr style='background-color:#dddddd;'>" + sstr2 + "</tr></table></div>";	
}

function xTable(xcontainer,xid,xstyle,xheader){	
	var objContainer = document.getElementById(xcontainer);	
	var xheadertable=xheader.split(",");	
	var sstr1="";
	var sstr2="";
	var nctr=0;
	
	var larray=xheadertable.length;	
	
	for (nctr=0;nctr<larray;nctr++){
		sstr1 =sstr1+" <th style='background-color:#77ABF9'>"+ xheadertable[nctr] +"</th>";
		sstr2 =sstr2+" <td style='background-color:#DAF2FE'>&nbsp</td>";
	}
	objContainer.innerHTML +="<div id=" + xid + " style='position:absolute;border: solid 1px #D8D8D8;"+xstyle+"'> <table style='color:white;width:100%'>"+sstr1+" <tr style='font-weight:bold;'>" + sstr2 + "</tr></table></div>";		
}

function addSpace(JmlSpace){
	var nCtr;
	var sSpace="";
	for (nCtr=0;nCtr<JmlSpace;nCtr++){
		sSpace=sSpace+"&nbsp;"
	}
	return sSpace;
}

/* Support Events */
(function($) {
    $.fn.drags = function(opt) {

        opt = $.extend({
            handle: "",
            cursor: "move",
            draggableClass: "draggable",
            activeHandleClass: "active-handle"
        }, opt);

        var $selected = null;
        var $elements = (opt.handle === "") ? this : this.find(opt.handle);

        return $elements.css('cursor', opt.cursor).on("mousedown", function(e) {
            if(opt.handle === "") {
                $selected = $(this);
                $selected.addClass(opt.draggableClass);
            } else {
                $selected = $(this).parent();
                $selected.addClass(opt.draggableClass).find(opt.handle).addClass(opt.activeHandleClass);
            }
            var drg_h = $selected.outerHeight(),
                drg_w = $selected.outerWidth(),
                pos_y = $selected.offset().top + drg_h - e.pageY,
                pos_x = $selected.offset().left + drg_w - e.pageX;
            $(document).on("mousemove", function(e) {
                $selected.offset({
                    top: e.pageY + pos_y - drg_h,
                    left: e.pageX + pos_x - drg_w
                });
            }).on("mouseup", function() {
                $(this).off("mousemove"); // Unbind events from document
                $selected.removeClass(opt.draggableClass);
                $selected = null;
            });
            e.preventDefault(); // disable selection
        }).on("mouseup", function() {
            if(opt.handle === "") {
                $selected.removeClass(opt.draggableClass);
            } else {
                $selected.removeClass(opt.draggableClass)
                    .find(opt.handle).removeClass(opt.activeHandleClass);
            }
            $selected = null;
        }); 
    }
})(jQuery);

/* Support Aplication */
function showAnim(sid,nCtr,nStop,nDivHeight){
	var objNewContainer = document.getElementById(sid);		
	nCtr++;		
	objNewContainer.style.width=(nCtr*10)+"px";
	objNewContainer.style.height=(nCtr*nDivHeight)+"px";		
	if (nCtr!=nStop){
		setTimeout(function(){showAnim(sid,nCtr,nStop,nDivHeight)},2);
	}		
}

function xTableLegend(xcontainer,xstyle){	
	var objContainer = document.getElementById(xcontainer);		
	iPnlLgdMaps="pnlLgndMaps";
	xPanel(xcontainer,iPnlLgdMaps,"top:27px;width:300px;height:305px;background:#F4F4F4;border: solid 1px #D8D8D8;"+xstyle);			
	
	xImgGgn1 ="../images/maps/red-dot.png";
	xImgGgn2 ="../images/maps/pink-dot.png";
	xImgGgn3 ="../images/maps/blue-dot.png";
	xImgGgn4 ="../images/maps/yellow-dot.png";	
	xImgGgn5 ="../images/maps/ssm.png";
	xImgGgn6 ="../images/maps/green-dot.png";		
	
	xImgPtgs1 ="../images/maps/cars1.png";
	xImgPtgs2 ="../images/maps/cars4.png";
	xImgPtgs3 ="../images/maps/cars2.png";
	xImgPtgs4 ="../images/maps/cars3.png";
	xImgPtgs5 ="../images/maps/cars5.png";
	
	
	var tblLgnd="";
		tblLgnd+="<table><tr><td><img src='"+ xImgGgn1 +"' width='20px' height='20px'></img></td><td>:</td><td>Gangguan Baru/PK Belum Dikirim ke Petugas</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgGgn2 +"' width='20px' height='20px'></img></td><td>:</td><td>PK Sudah Dikirim Belum Diterima</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgGgn3 +"' width='20px' height='20px'></img></td><td>:</td><td>PK Sudah diterima & Team Menuju Lokasi PK</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgGgn4 +"' width='20px' height='20px'></img></td><td>:</td><td>Proses Recovery</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgGgn5 +"' width='20px' height='20px'></img></td><td>:</td><td>PK Selesai Sementara</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgGgn6 +"' width='20px' height='20px'></img></td><td>:</td><td>PK Sudah Selesai Dilaksanakan</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgPtgs1 +"' width='20px' height='20px'></img></td><td>:</td><td>Pelaksana 'FREE'</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgPtgs2 +"' width='20px' height='20px'></img></td><td>:</td><td>Pelaksana dalam perjalanan menuju tempat gangguan.</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgPtgs3 +"' width='20px' height='20px'></img></td><td>:</td><td>Proses Recovery</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgPtgs4 +"' width='20px' height='20px'></img></td><td>:</td><td>Proses Recovery Selesai</td></tr>"
		tblLgnd+="<tr><td><img src='"+ xImgPtgs5 +"' width='20px' height='20px'></img></td><td>:</td><td>Pelaksana 'Di Daerah Blind Spot'</td></tr>"
		tblLgnd+="</table>"
	var objLgnContainer = document.getElementById(iPnlLgdMaps);
	objLgnContainer.innerHTML +=tblLgnd;
}

function xRuller(xcontainer,xlength){
	var objContainer = document.getElementById(xcontainer);
	var lblruller="";
	var i=0;
	while (i < xlength){
		if ((i%50)==0){
			lblruller+="<div style='position:absolute;height:2px;left:"+i+"px;border-left:2px solid black;'></div>";
			lblruller+="<div style='position:absolute;top:2px;left:"+(i-25)+"px;width:50px;color:red;text-align:center;'>"+i+"</div>";
		}
		i++;
	}
	lblruller+="<div style='position:absolute;height:2px;left:"+i+"px;border-left:2px solid black;'></div>";
	lblruller+="<div style='position:absolute;top:2px;left:"+(i-25)+"px;width:50px;color:red;text-align:center;'>"+i+"</div>";
	cRuller="<div style='top:1px;position:absolute;width:"+xlength+"px;border-top:2px solid red;'>" + lblruller + "</div>";
	objContainer.innerHTML += cRuller;
}

function getMousePos(canvas, evt) {
	var rect = canvas.getBoundingClientRect();
	return {
		x: evt.clientX - rect.left,
		y: evt.clientY - rect.top
	};
}

function openForm(vForm){
	document.getElementById(vForm).style.display="block";
}

function closeForm(vForm){
	document.getElementById(vForm).style.display="none";
}

function openToFrameContent(xurl){		
	window.frames["iFrmContent"].location = xurl;
}

function openToFrame(xIdIFrame,xSrc){
	window.frames[xIdIFrame].location = xSrc;
}

function SignOut(){
	window.location = "../controller/logout.php";
}

var myNamespace = function(){
  var o = {};
  var globals = {};

  var setGlobVar = function(name, value) {
    globals[name] = value;
  };

  var getGlobVar = function(name) {
    if (globals.hasOwnProperty(name)) {
      return globals[name];
    } else {
      // return null by default if the property does not exist 
      return null;
    }
  };

  o.setGlobVar = setGlobVar;
  o.getGlobVar = getGlobVar;
  return o;
}();

/*==================================================
  Cookie functions
  ==================================================*/
function setCookie(name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

function deleteCookie(name, path, domain) {
    if (getCookie(name)) {
        document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}
