$(document).ready(function () {
    var currentPath = window.location.pathname.replace(/^\/atlas/, ''); // Ajustar si hay prefijo
    $(".menu > ul > li").removeClass("active");
    $(".menu a").each(function () {
        var href = $(this).attr("href");
        if (href && href !== "#" && currentPath.includes(href)) {
            $(this).closest("li").addClass("active");
            if ($(this).closest("ul").hasClass("sub-menu")) {
                $(this).closest("ul").slideDown();
                $(this).closest("ul").closest("li").addClass("active");
            }
        }
    });
});


$(".menu > ul > li").click(function (e) {
    // remove active grom already active
    $(this).siblings().removeClass("active");
    // // add active to clicked
    // $(this).toggleClass("active");

    //if  has sub menu open it
    $(this).find("ul").slideToggle();
    //close other sub menus if any open
    $(this).siblings().find("ul").slideUp();
    // remove active class from other sub menu items
    $(this).siblings().find("ul").find("li").removeClass("active");

});

$(".menu-btn").click(function () {
    $(".sidebar").toggleClass("active");
});


