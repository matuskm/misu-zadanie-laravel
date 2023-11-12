(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_scripts_popupmodal_js"],{

/***/ "./resources/js/scripts/popupmodal.js":
/*!********************************************!*\
  !*** ./resources/js/scripts/popupmodal.js ***!
  \********************************************/
/***/ (() => {

function popUpModal() {
  var myModal = document.getElementById('myModal');
  var myInput = document.getElementById('myInput');
  myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus();
  });
}
$(document).ready(function () {
  popUpModal();
});

/***/ })

}]);