/*
Template Name: Admin Template
Author: Wrappixel

File: js
*/
// ==============================================================
// Auto select left navbar
// ==============================================================
$(function() {
    "use strict";
    var url = window.location + "";
    var path = url.replace(window.location.protocol + "//" + window.location.host + "/", "");
    var element = $('ul#sidebarnav a').filter(function() {
        return this.href === url || this.href === path;// || url.href.indexOf(this.href) === 0;
    });

    $('#sidebarnav a').on('click', function (e) {

            if (!$(this).hasClass("active")) {
                // hide any open menus and remove all other classes
                $("ul", $(this).parents("ul:first")).removeClass("in");
                $("a", $(this).parents("ul:first")).removeClass("active");

                // open our new menu and add the open class
                $(this).next("ul").addClass("in");
                $(this).addClass("active");

            }
            else if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(this).parents("ul:first").removeClass("active");
                $(this).next("ul").removeClass("in");
            }
    })
    $('#sidebarnav >li >a.has-arrow').on('click', function (e) {
        e.preventDefault();
    });

    // Auto scroll to the active nav
    if ( $(window).width() > 768 || window.Touch) {
         $('.scroll-sidebar').animate({
            scrollTop: $("#sidebarnav .sidebar-item.selected").offset().top -250
        }, 500);
    }

});
