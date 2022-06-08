'use strict';

function createDiv(xoption, parentId) {
	var objContainer = document.getElementById(parentId);
	objContainer.innerHTML +="<div " + xoption + "></div>";
}

function createInput( xoption, parentId) {
	var objContainer = document.getElementById(parentId);
	objContainer.innerHTML +="<input " + xoption + ">";
}

function createLabel(xoption, xcaption, parentId) {
	var objContainer = document.getElementById(parentId);
	objContainer.innerHTML +="<label " + xoption + ">" + xcaption + "</label>";
}

function createButton(xoption, xcaption, parentId) {
	var objContainer = document.getElementById(parentId);
	objContainer.innerHTML +="<button type='button' " + xoption + ">" + xcaption + "</button>";
}

function createLine(parentId, xoption) {
	var objContainer = document.getElementById(parentId);
	objContainer.innerHTML +="<hr "+xoption+">";
}

function createFormGroup(parentId){
	var objContainer = document.getElementById(parentId);
	objContainer.innerHTML +="<div class='form-group'>";
}
function createFormInput(xoption, xTextAttribut, parentId){
	var objContainer = document.getElementById(parentId);
	objContainer.innerHTML +="<div " + xoption + "><input class='form-control' " + xTextAttribut + "></div>";
}