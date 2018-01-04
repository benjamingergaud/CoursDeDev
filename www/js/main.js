"use strict";

$(function () {
    $('[data-menu]').click(onClickMenu);
    $('[data-action]').click(onClickManageItem);
    $('#btn_search').click(function () {
        $('#search_bar').submit();
    })
    checkForms();
});

function checkForms() {

    // si le selecteur $('form') à trouvé des formulaires dans la page, on lance la classe
    var $form = $('form');
    console.log("test"+$form.length);
    if ($form.length) {
        var formFilter = new FormFilter($form);
        formFilter.run();
    }
}
function onClickMenu() {

    //recuperation de l'id du sous menu a afficher contenue dans l'attribut data menu de l'element cliqué
    var targetMenu = event.target.dataset.menu;

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


    //on enleve la class hidden du sous menu
    $menu.toggleClass("hidden");


    //on desactive le comportement par default du lien dans la nav
    event.preventDefault();


    //on crée un timer qui toutes les 50ms va appeller une fonction qui va augmenter l'opacité du sous menu de 0.05 jusqu'a atteindre 1
    var timer = window.setInterval(function(){
        if(opacity<1){
            opacity+=0.05;
        }
        else{
            clearInterval(timer);
        }
        $menu.css("opacity" , opacity)
    } , 50)
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
    console.log('test');
    var $editLink = $('#editLink'+linkId);
    var categoryId = $editLink.find("[name=category]").data("selected");
    $editLink.find("[name=category]").prop("selectedIndex",categoryId-1 );
    $editLink.slideToggle()
}