document.addEventListener("DOMContentLoaded", function(event) {
	var classname = document.getElementsByClassName("ppgbo_qcd");
	for (var i = 0; i < classname.length; i++) {
		//click gauche
		classname[i].addEventListener('click', ppgboLeftClick, false);
		//click droit
		classname[i].addEventListener('contextmenu', ppgboRightClick, false);
	}
    var images = document.getElementsByClassName("product_link");
    for (var i = 0; i < images.length; i++) {
        images[i].addEventListener('mouseover', ppgboHoverImages, false);
        images[i].addEventListener('mouseout', ppgboOutImages, false);
    }
});
//fonction du click gauche
var ppgboLeftClick = function(event) {
	var attribute = this.getAttribute("data-qcd");     
	var tab = this.getAttribute("data-tab");
	
    var newWindow = window.open(decodeURIComponent(window.atob(attribute)), tab);    
	newWindow.focus();                
};
//fonction du click droit
var ppgboRightClick = function(event) {
    var attribute = this.getAttribute("data-qcd");    
	var tab = this.getAttribute("data-tab");
	
    var newWindow = window.open(decodeURIComponent(window.atob(attribute)), tab);    
	newWindow.focus();   
} 
//fonction de hover de l'image
var ppgboHoverImages = function(event) {
    var image = this.parentNode.getElementsByClassName("product_image");
    var attribute = image[0].getAttribute("data-hover");
    
    if (attribute) {
        image[0].setAttribute('src', attribute);
    }
}
//fonction de out de l'image
var ppgboOutImages = function(event) {
    var image = this.parentNode.getElementsByClassName("product_image");
    var attribute = image[0].getAttribute("data-src");
    
    if (attribute) {
        image[0].setAttribute('src', attribute);
    }
}