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
    
    var array_carrousel = document.querySelectorAll('.ppgbo_carrousel');
    for (let j = 0; j < array_carrousel.length; j++) {
        if (array_carrousel[j]) {
            const li = array_carrousel[j].querySelectorAll('li');
            const col_number = array_carrousel[j].getElementsByClassName('carrousel')[0].classList[1].replace('col-', '');
            var count = {
                2: 6,
                3: 4,
                4: 3,
                6: 2,
                12: 1
            };
            
            for (let i = 0; i < li.length; i++) {
                li[i].style.width = (((array_carrousel[j].offsetWidth - 100) / count[col_number]) - 20) + 'px';
            }
            
            var arrows = document.querySelectorAll('.carrousel-prev');
            if (arrows.length > 0) {
                array_carrousel[j].getElementsByClassName('carrousel-prev')[0].addEventListener('click', function(){ppgbo_carousel_previous_link(j)}, false);
                array_carrousel[j].getElementsByClassName('carrousel-next')[0].addEventListener('click', function(){ppgbo_carousel_next_link(j)}, false);
            }
            array_carrousel[j].querySelector('ul').style.marginLeft = 0;
            
            var dots = document.querySelectorAll('.dots_navigation');
            if (dots[j]) {
                var dots_links = dots[j].getElementsByTagName('a');
                var class_active = '';
                var class_inactive = '';
                
                for (let i = 0; i < dots_links.length; i++) {
                    dots_links[i].addEventListener('click', function(){ppgbo_carousel_dots_link(i, j)}, false);
                }
            }
            
            if (array_carrousel[j].getElementsByClassName('carrousel')[0].classList.length > 1 && array_carrousel[j].getElementsByClassName('carrousel')[0].classList[2] == 'autoplay') {
                var timer = 5000;
                if (array_carrousel[j].getElementsByClassName('carrousel')[0].classList.length > 2) {
                    timer = Math.floor(array_carrousel[j].getElementsByClassName('carrousel')[0].classList[3].replace('autoplay-', ''));
                }
                setTimeout(function() {
                    ppgbo_carousel_next_link_autoplay(j, timer);
                }, timer);
            }
        }
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

/* CARROUSEL */
function ppgbo_carousel_show_another_link(direction, index) {
    var array_carrousel = document.querySelectorAll('.ppgbo_carrousel');
    var ul = array_carrousel[index].getElementsByTagName('ul');
    var current = -parseInt(ul[0].style.marginLeft) / 100;
    var new_link = current + direction;
    var links_number = ul[0].children.length;
    const col_number = array_carrousel[index].getElementsByClassName('carrousel')[0].classList[1].replace('col-', '');
    var count = {
        2: 6,
        3: 4,
        4: 3,
        6: 2,
        12: 1
    };
    
    var dots = document.querySelectorAll('.dots_navigation');
    if (dots[index]) {
        var dots_links = dots[index].getElementsByTagName('a');
        var class_active = '';
        var class_inactive = '';
        
        for (let i = 0; i < dots_links.length; i++) {
            if (hasClass(dots_links[i], 'dots-active')) {
                class_active = dots_links[i].getElementsByTagName('img')[0].src;
            }
            else if (hasClass(dots_links[i], 'dots')) {
                class_inactive = dots_links[i].getElementsByTagName('img')[0].src;
            }
        }
    }

    if (new_link >= 0 && new_link < (links_number / count[col_number])) {
        if (dots[index]) {
            var dots_links = dots[index].getElementsByTagName('a');
            
            for (let i = 0; i < dots_links.length; i++) {
                dots_links[i].classList.remove('dots-active');
                dots_links[i].getElementsByTagName('img')[0].src = class_inactive;
            }
            
            dots[index].getElementsByTagName('a')[new_link].classList.add('dots-active');
            dots[index].getElementsByTagName('a')[new_link].getElementsByTagName('img')[0].src = class_active;
        }
        
        ul[0].style.transition = 'margin-left 2s';
        ul[0].style.marginLeft = -(new_link * 100) + '%';
    }
    else if (new_link >= (links_number / count[col_number])) {
        if (dots[index]) {
            var dots_links = dots[index].getElementsByTagName('a');
            
            for (let i = 0; i < dots_links.length; i++) {
                dots_links[i].classList.remove('dots-active');
                dots_links[i].getElementsByTagName('img')[0].src = class_inactive;
            }
            
            dots[index].getElementsByTagName('a')[0].classList.add('dots-active');
            dots[index].getElementsByTagName('a')[0].getElementsByTagName('img')[0].src = class_active;
        }
        
        ul[0].style.transition = 'margin-left 2s';
        ul[0].style.marginLeft = 0;
    }
    else if (new_link < 0) {
        if (dots[index]) {
            var dots_links = dots[index].getElementsByTagName('a');
            
            for (let i = 0; i < dots_links.length; i++) {
                dots_links[i].classList.remove('dots-active');
                dots_links[i].getElementsByTagName('img')[0].src = class_inactive;
            }
            
            dots[index].getElementsByTagName('a')[dots_links.length].classList.add('dots-active');
            dots[index].getElementsByTagName('a')[dots_links.length].getElementsByTagName('img')[0].src = class_active;
        }
        
        ul[0].style.transition = 'margin-left 2s';
        ul[0].style.marginLeft = -(Math.floor(links_number / count[col_number]) * 100) + '%';
    }
}

function hasClass( target, className ) {
    return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
}

function ppgbo_carousel_previous_link(index) {
	ppgbo_carousel_show_another_link(-1, index);
	return false;
}

function ppgbo_carousel_next_link(index) {
	ppgbo_carousel_show_another_link(1, index);
	return false;
}

function ppgbo_carousel_dots_link(position, index) {
    var array_carrousel = document.querySelectorAll('.ppgbo_carrousel');
    var ul = array_carrousel[index].getElementsByTagName('ul');
    var current = -parseInt(ul[0].style.marginLeft) / 100;
    
	ppgbo_carousel_show_another_link(position - current, index);
	return false;
}

function ppgbo_carousel_next_link_autoplay(index, timer) {
    ppgbo_carousel_show_another_link(1, index);
    
	timeout = setTimeout(function() {
        ppgbo_carousel_next_link_autoplay(index, timer);
    }, timer);
	//return false;
}