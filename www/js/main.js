"use strict";

$(function () {
    if (navigator.userAgent.match(/(android|iphone|ipad|blackberry|symbian|symbianos|symbos|netfront|model-orange|javaplatform|iemobile|windows phone|samsung|htc|opera mobile|opera mobi|opera mini|presto|huawei|blazer|bolt|doris|fennec|gobrowser|iris|maemo browser|mib|cldc|minimo|semc-browser|skyfire|teashark|teleca|uzard|uzardweb|meego|nokia|bb10|playbook)/gi)) {
        $('[data-menu]')
            .click(onClickMenu)

    } else {
        $('[data-menu]')
            .mouseenter(onMouseEnterMenu)
            .mouseleave(onMouseLeave);
    }
    // $('.card')
    //     .mouseenter(function () {$(this).addClass('is-flipped')})
    //     .mouseleave(function () {$(this).removeClass('is-flipped')});
    $('.card')
        .click(function () {$(this).toggleClass('is-flipped'); event.preventDefault()});
    $('p.over-card').click(function () {
        console.log("test")
        var link = $(event.target).parent("div").parent("div").parent("a").attr("href");
        if (link.search("http")=== -1){
            document.location.href="index.php"+link;
        } else {
            window.open(link,"_blank")
        }
        //console.log(link.attr("href"))

    })




    $('[data-action]').click(onClickManageItem);

    $('#btn_search').click(function () {
        $('#search_bar').submit();
    });
    $(document).scroll(onScrollPage);
    checkForms();
});

function checkForms() {

    // si le selecteur $('form') à trouvé des formulaires dans la page, on lance la classe
    var $form = $('form');
    if ($form.length) {
        var formFilter = new FormFilter($form);
        formFilter.run();
    }
}
function onClickMenu() {
    var targetMenu;
    var position;
    var width;
    if (event.target.toString().search("a#") !== -1){
         targetMenu = event.target.dataset.menu;
         position = event.target.offsetLeft;
         width = event.target.clientWidth;
    } else {
        var parent = $(event.target).parent()
        targetMenu = parent.data("menu");
        position = parent[0].offsetLeft;
        width = parent[0].clientWidth;
    }
    //recuperation de l'id du sous menu a afficher contenue dans l'attribut data menu de l'element cliqué


    //recuperation de tous les sous menus
    var submenus = $('[data-submenu]');

    //boucle sur tous les sous menus pour tous les cacher sauf celui cliqué
    for (var count = 0 ; count<submenus.length ; count++){

        if(submenus[count].id !== targetMenu) {

            submenus[count].classList.add("hidden")

        }
    }
    //on selection le sous menu demandé
    var $menu = $('#'+targetMenu);

    //on initie son opacité a 0 pour le faire apparaitre progressivement
    var opacity = 0;
    $menu.css("opacity" , opacity);
    $menu.css("left" , position);
    $menu.css("width" , width);
    $menu.css("background-position-x" , -position);

    //on enleve la class hidden du sous menu
    $menu.toggleClass("hidden");


    //on desactive le comportement par default du lien dans la nav
    event.preventDefault();



    $menu.css("opacity" , 1)
}
function onMouseEnterMenu(event) {
    //recuperation de l'id du sous menu a afficher contenue dans l'attribut data menu de l'element cliqué
    var targetMenu = event.target.dataset.menu;
    var position = event.target.offsetLeft;
    var width = event.target.clientWidth;
    //recuperation de tous les sous menus
    var submenus = $('[data-submenu]');

    //boucle sur tous les sous menus pour tous les cacher sauf celui cliqué
    for (var count = 0 ; count<submenus.length ; count++){

        if(submenus[count].id !== targetMenu) {

            submenus[count].classList.add("hidden")

        }
    }


    //on selection le sous menu demandé
    var $menu = $('#'+targetMenu);


    //on initie son opacité a 0 pour le faire apparaitre progressivement
    var opacity = 0;
    $menu.css("opacity" , opacity);
    $menu.css("left" , position);
    $menu.css("width" , width);
    $menu.css("background-position-x" , -position);

    //on enleve la class hidden du sous menu
    $menu.removeClass("hidden");


    //on desactive le comportement par default du lien dans la nav
    event.preventDefault();


    //on crée un timer qui toutes les 50ms va appeller une fonction qui va augmenter l'opacité du sous menu de 0.05 jusqu'a atteindre 1
    // var timer = window.setInterval(function(){
    //     if(opacity<1){
    //         opacity+=0.05;
    //     }
    //     else{
    //         clearInterval(timer);
    //     }
    //     $menu.css("opacity" , opacity)
    // } , 50)
    $menu.css("opacity" , 1)
}

function onClickManageItem() {
    event.preventDefault();
    var action = $(this).data("action");
    var id=$(this).data("id");
    switch(action){
        case "editCourse" :
            showEditCourse(id);
            break;
        case "removeCourse" :

            $.post("" , "ajaxDeleteCourse&id="+id , onDeleteCourseSuccess);
            break;
        case "editLink" :
            showEditLink(id);

            break;
        case "removeLink" :
            $.post("" , "ajaxDeleteLink&id="+id);
            break;
        default : return false;
    }

}
function onDeleteCourseSuccess() {
    window.location.reload();
}
function showEditCourse(courseId) {
    var $editCourse = $('#editCourse'+courseId);
    var categoryId = $editCourse.find("[name=category]").data("selected");
    $editCourse.find("[name=category]").prop("selectedIndex",categoryId-1 );
    $editCourse.slideToggle()
}
function showEditLink(linkId) {
    var $editLink = $('#editLink'+linkId);
    var categoryId = $editLink.find("[name=category]").data("selected");
    $editLink.find("[name=category]").prop("selectedIndex",categoryId-1 );
    $editLink.slideToggle()
}
jQuery.fn.mouseIsOver = function () {

    if($(this[0]).is(":hover"))
       {
           return true;
       }

    return false;

};
function onScrollPage() {
    var header = $('header');
    if (scrollY>=1){
        header.css("height" , "50px");
        header.css("position" , "fixed");
        header.css("top" , "0");
        $('[data-submenu]').css("top" , "50px");
        $('div.stage').addClass("hidden");
        $('#user-nav').css("display" , "none");
        $('#search_bar').css("top" , "40%");
        $('main').css("margin-top","100px");
    } else {
        header.css("height" , "100px");
        $('[data-submenu]').css("top" , "100px");
        $('div.stage').removeClass("hidden");
        $('#user-nav').css("display" , "block");
        $('#search_bar').css("top" , "70%");
        header.css("position" , "relative");
        $('main').css("margin-top","0");


    }
}
function onMouseLeave() {
    var submenus = $('[data-submenu]');
    var submenu;

    $(submenus)
        .mouseenter(function () {
            $(this).data("over", true);
        })
        .mouseleave(  function () {
            $(this).data("over", false );
            $(this).addClass("hidden")
        } );
    if (!is_old_internet_explorer()){


        $(document)
            .bind("mousemove", function () {
                for (var index = 0; index < submenus.length; index++) {
                    submenu = $(submenus[index]);

                    // if (!$(submenu).mouseIsOver()) {
                    //
                    //     $(submenu).addClass("hidden")
                    // } else {
                    //     submenu.mouseleave(function () {
                    //         $(this).addClass("hidden")
                    //
                    //     })

                    if (!$(submenu).data("over")) {
                        $(submenu).addClass("hidden")
                        $(this).unbind("mousemove")
                    }
                }
            });
    }




    //}
}
function is_old_internet_explorer(){
    var matches = navigator.userAgent.search("Edge");
    if( matches !== -1){
        return true;
    }
    return false;
}