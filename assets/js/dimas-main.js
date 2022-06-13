(function (t) {
    ("use strict");
    /*js get device and event*/
    var DIMASJS = {
        window: jQuery(window),
        document: jQuery(document),
        html: jQuery("html"),
        body: jQuery("body"),
    };
    DIMASJS.isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return (
                DIMASJS.isMobile.Android() ||
                DIMASJS.isMobile.BlackBerry() ||
                DIMASJS.isMobile.iOS() ||
                DIMASJS.isMobile.Opera() ||
                DIMASJS.isMobile.Windows()
            );
        },
    };
    var resizeArr = [];
    var resizeTimeout;
    DIMASJS.window.on("load resize orientationchange", function (e) {
        if (resizeArr.length) {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function () {
                for (var i = 0; i < resizeArr.length; i++) {
                    resizeArr[i](e);
                }
            }, 250);
        }
    });
    DIMASJS.debounceResize = function (callback) {
        if (typeof callback === "function") {
            resizeArr.push(callback);
        } else {
            window.dispatchEvent(new Event("resize"));
        }
    };
    DIMASJS.addLedingZero = function (number) {
        return ("0" + number).slice(-2);
    };
    var throttleArr = [];
    var didScroll;
    var delta = 5;
    var lastScrollTop = 0;
    DIMASJS.window.on("load resize scroll orientationchange", function () {
        if (throttleArr.length) {
            didScroll = true;
        }
    });

    function hasScrolled() {
        var scrollTop = DIMASJS.window.scrollTop(),
            windowHeight = DIMASJS.window.height(),
            documentHeight = DIMASJS.document.height(),
            scrollState = "";
        if (Math.abs(lastScrollTop - scrollTop) <= delta) {
            return;
        }
        if (scrollTop > lastScrollTop) {
            scrollState = "down";
        } else if (scrollTop < lastScrollTop) {
            scrollState = "up";
        } else {
            scrollState = "none";
        }
        if (scrollTop === 0) {
            scrollState = "start";
        } else if (scrollTop >= documentHeight - windowHeight) {
            scrollState = "end";
        }
        for (var i in throttleArr) {
            if (typeof throttleArr[i] === "function") {
                throttleArr[i](scrollState, scrollTop, lastScrollTop, DIMASJS.window);
            }
        }
        lastScrollTop = scrollTop;
    }
    setInterval(function () {
        if (didScroll) {
            didScroll = false;
            window.requestAnimationFrame(hasScrolled);
        }
    }, 250);
    DIMASJS.throttleScroll = function (callback) {
        if (typeof callback === "function") {
            throttleArr.push(callback);
        }
    };
    if (typeof cssVars !== "undefined") {
        cssVars({
            onlyVars: true,
        });
    }

    /*js replay animation page*/
    (DIMASJS.animatedBlock = {
        init: function () {
            var n = t(".dimas-animate-element"),
                e = "animate__";
            t(".dimas-fullpage-slider").length ?
                DIMASJS.window.on("dimas.change-slide", function () {
                    n.each(function () {
                        var n = t(this),
                            a = n.data("animation-name");
                        n.removeClass(e + "animated").removeClass(e + a),
                            n.parents(".dimas-section").hasClass("active") &&
                            n.addClass(e + "animated").addClass(e + a);
                    });
                }) :
                n.each(function () {
                    var n = t(this);
                    n.one("inview", function () {
                        var t = n.data("animation-name");
                        n.addClass(e + "animated").addClass(e + t);
                    });
                });
        },
    }),
        DIMASJS.animatedBlock.init();

    /*js get pointer*/
    t("[data-cursor]").length &&
        ((DIMASJS.customCursor = {
            init: function () {
                DIMASJS.body.append(
                    '<div class="dimas-custom-cursor"><span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 24"><path fill="currentColor" d="M5 0v2.4h15.737L0 22.308 1.762 24 22.5 4.092V19.2H25V0H5Z"/></svg></span></div>'
                );
                var n = t(".dimas-custom-cursor");
                DIMASJS.document.on("mousemove pointermove", function (t) {
                    n
                        .get(0)
                        .style.setProperty("--dimas-custom-cursor__x", `${t.clientX}px`),
                        n
                            .get(0)
                            .style.setProperty("--dimas-custom-cursor__y", `${t.clientY}px`);
                }),
                    DIMASJS.document
                        .on("mouseenter", "[data-cursor]", function () {
                            n.addClass(t(this).data("cursor")), n.addClass("is-visible");
                        })
                        .on("mouseleave", "[data-cursor]", function () {
                            n.removeClass(t(this).data("cursor")),
                                n.removeClass("is-visible");
                        });
            },
        }),
            DIMASJS.isMobile.any() || DIMASJS.customCursor.init());

    /*js  pagepiling*/
    void 0 !== t.fn.pagepiling &&
        t(".dimas-fullpage-slider").length &&
        ((DIMASJS.fullpageSlider = {
            init: function () {
                var n = t(".dimas-fullpage-slider"),
                    e = n.find(".dimas-fullpage-slider-nav"),
                    a = !!n.data("loop-top"),
                    i = !!n.data("loop-bottom"),
                    o = n.data("speed") || 800,
                    s = [];

                function r() {
                    n.find(".pp-section.active").scrollTop() > 0 ?
                        t(".dimas-navbar").addClass("dimas-navbar--solid") :
                        t(".dimas-navbar").removeClass("dimas-navbar--solid");
                }
                DIMASJS.body.css("overflow", "hidden"),
                    DIMASJS.html.css("overflow", "hidden"),
                    n.find("[data-anchor]").each(function () {
                        s.push(t(this).data("anchor"));
                    }),
                    r(),
                    e.on("click", ".prev", function (n) {
                        n.preventDefault(), t.fn.pagepiling.moveSectionUp();
                    }),
                    e.on("click", ".next", function (n) {
                        n.preventDefault(), t.fn.pagepiling.moveSectionDown();
                    }),
                    n.pagepiling({
                        menu: ".dimas-offcanvas-menu ul.dimas-menu, .dimas-default-menu__navigation ul.dimas-menu, .dimas-fullpage-slider-nav",
                        scrollingSpeed: o,
                        loopTop: a,
                        loopBottom: i,
                        anchors: s,
                        touchSensitivity: 1,
                        normalScrollElementTouchThreshold: 1,
                        sectionSelector: ".dimas-section",
                        navigation: !1,
                        afterRender: function () {
                            e.find("li:nth-child(2) > a").addClass("active"),
                                t(
                                    ".dimas-offcanvas-menu ul.dimas-menu > li:first-child, .dimas-default-menu__navigation ul.dimas-menu > li:first-child"
                                ).addClass("active"),
                                DIMASJS.window.trigger("dimas.change-slide");
                        },
                        onLeave: function (t, n, e) {
                            DIMASJS.window.trigger("dimas.change-slide");
                        },
                        afterLoad: function (t, n) {
                            r();
                        },
                    }),
                    n.find(".pp-scrollable").on("scroll", function () {
                        t(this).scrollTop() > 0 ?
                            t(".dimas-navbar").addClass("dimas-navbar--solid") :
                            t(".dimas-navbar").removeClass("dimas-navbar--solid");
                    });
            },
        }),
            DIMASJS.fullpageSlider.init());
    /*add data-menuanchor for menu*/
    jQuery('.dimas-menu li').each(function () {
        jQuery(this).attr('data-menuanchor', jQuery(this).text().charAt(0).toUpperCase() + jQuery(this).text().slice(1));
        if (!jQuery('body.home').length) {
            jQuery(this).find('a').attr('href', '/' + jQuery(this).find('a').attr('href'));
            if (jQuery('body.single-project').length) {
                jQuery(".dimas-menu li[data-menuanchor='Projects']").addClass('active');
            }
            else {
                jQuery(".dimas-menu li[data-menuanchor='Blog']").addClass('active');
            }
        }
    });
    /*js offcanvas*/
    var of = !1;
    (DIMASJS.menuOffcanvas = {
        config: {
            easing: "power2.out",
        },
        init: function () {
            var e = t(".dimas-offcanvas-menu"),
                a = e.find("ul.dimas-menu"),
                i = a.find("> li"),
                o = t(".dimas-offcanvas-menu__header"),
                s = t(".dimas-offcanvas-menu__footer > div"),
                r = t(".js-offcanvas-menu-open"),
                f = t(".js-offcanvas-menu-close"),
                l = t(".dimas-site-overlay");
            void 0 !== t.fn.superclick &&
                a.superclick({
                    delay: 300,
                    cssArrows: !1,
                    animation: {
                        opacity: "show",
                        height: "show",
                    },
                    animationOut: {
                        opacity: "hide",
                        height: "hide",
                    },
                }),
                r.on("click", function (t) {
                    t.preventDefault(),
                        of || DIMASJS.menuOffcanvas.open_menu(e, l, i, o, s);
                }),
                f.on("click", function (t) {
                    t.preventDefault(),
                        of && DIMASJS.menuOffcanvas.close_menu(e, l, i, o, s);
                }),
                l.on("click", function (t) {
                    t.preventDefault(),
                        of && DIMASJS.menuOffcanvas.close_menu(e, l, i, o, s);
                }),
                DIMASJS.document.keyup(function (t) {
                    27 === t.keyCode &&
                        of &&
                        (t.preventDefault(),
                            DIMASJS.menuOffcanvas.close_menu(e, l, i, o, s));
                }),
                i.filter("[data-menuanchor]").on("click", "a", function () {
                    of && DIMASJS.menuOffcanvas.close_menu(e, l, i, o, s);
                });
        },
        open_menu: function (t, e, a, i, o) {
            (of = !0),
                "undefined" != typeof gsap &&
                gsap
                    .timeline({
                        defaults: {
                            ease: this.config.easing,
                        },
                    })
                    .set(DIMASJS.html, {
                        overflow: "hidden",
                    })
                    .to(e, 0.3, {
                        autoAlpha: 1,
                    })
                    .fromTo(
                        t,
                        0.6, {
                        x: "100%",
                    }, {
                        x: 0,
                        visibility: "visible",
                    },
                        "-=.3"
                    )
                    .fromTo(
                        i,
                        0.3, {
                        x: 50,
                        autoAlpha: 0,
                    }, {
                        x: 0,
                        autoAlpha: 1,
                    },
                        "-=.3"
                    )
                    .fromTo(
                        a,
                        0.3, {
                        x: 50,
                        autoAlpha: 0,
                    }, {
                        x: 0,
                        autoAlpha: 1,
                        stagger: {
                            each: 0.1,
                            from: "start",
                        },
                    },
                        "-=.15"
                    )
                    .fromTo(
                        o,
                        0.3, {
                        x: 50,
                        autoAlpha: 0,
                    }, {
                        x: 0,
                        autoAlpha: 1,
                        stagger: {
                            each: 0.1,
                            from: "start",
                        },
                    },
                        "-=.15"
                    );
        },
        close_menu: function (t, e, a, i, o) {
            (of = !1),
                "undefined" != typeof gsap &&
                gsap
                    .timeline({
                        defaults: {
                            ease: this.config.easing,
                        },
                    })
                    .set(DIMASJS.html, {
                        overflow: "inherit",
                    })
                    .to(o, 0.3, {
                        x: 50,
                        autoAlpha: 0,
                        stagger: {
                            each: 0.1,
                            from: "end",
                        },
                    })
                    .to(
                        a,
                        0.3, {
                        x: 50,
                        autoAlpha: 0,
                        stagger: {
                            each: 0.1,
                            from: "end",
                        },
                    },
                        "-=.15"
                    )
                    .to(
                        i,
                        0.3, {
                        x: 50,
                        autoAlpha: 0,
                    },
                        "-=.15"
                    )
                    .to(
                        t,
                        0.6, {
                        x: "100%",
                    },
                        "-=.15"
                    )
                    .set(t, {
                        visibility: "hidden",
                    })
                    .to(
                        e,
                        0.3, {
                        autoAlpha: 0,
                    },
                        "-=.6"
                    );
        },
    }),
        DIMASJS.menuOffcanvas.init();

    /*js animsition */
    if (void 0 !== t.fn.animsition) {
        /*preload page*/
        var n = t(".animsition");
        n.animsition({
            inDuration: 500,
            outDuration: 500,
            loadingClass: "preloader",
            loadingInner: '<div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>',
        }),
            n.on("animsition.inEnd", function () {
                DIMASJS.window.trigger("dimas.preloader_done"),
                    DIMASJS.html.addClass("dimas-is-page-loaded");
            });
    }

    /*js counter*/
    "undefined" != typeof gsap &&
        ((DIMASJS.progressBar = {
            init: function () {
                t(".dimas-progress-bar").each(function () {
                    var n = t(this),
                        e = n.data("final-value") || 0,
                        a = n.data("animation-speed") || 0,
                        i = {
                            count: 0,
                        };
                    DIMASJS.window.on("dimas.change-slide", function () {
                        n.parents(".dimas-section").hasClass("active") &&
                            ((i.count = 0),
                                n
                                    .find(".dimas-progress-bar__title > .counter")
                                    .text(Math.round(i.count) + "%"),
                                gsap.set(n.find(".dimas-progress-bar__bar > span"), {
                                    width: 0,
                                }),
                                gsap.to(i, a / 1e3 / 2, {
                                    count: e,
                                    delay: 0.5,
                                    onUpdate: function () {
                                        n.find(".dimas-progress-bar__title > .counter").text(
                                            Math.round(i.count) + "%"
                                        );
                                    },
                                }),
                                gsap.to(n.find(".dimas-progress-bar__bar > span"), a / 1e3, {
                                    width: e + "%",
                                    delay: 0.5,
                                }));
                    });
                });
            },
        }),
            DIMASJS.progressBar.init());
    jQuery(function ($) {
        $(document).ready(function () {
            /*swiper slider*/
            if ($(".dimas-testimonial-slider").length > 0) {
                const slider_testimonial = new Swiper(".dimas-testimonial-slider", {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: true,
                    direction: "horizontal",
                    initialSlide: 0,
                    PreventInteractionOnTransition: true,
                    pagination: {
                        el: ".swiper-pagination",
                        type: "bullets",
                        clickable: true,
                        bulletElement: "div",
                    },
                    keyboard: {
                        enabled: true,
                        onlyInViewport: false,
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                });
                var slider_active = $(".dimas-testimonial-slider .swiper-slide-active");

                function box_check() {
                    i = 0;
                    $(".dimas-testimonial-slider div.swiper-pagination-bullet").each(
                        function () {
                            if (
                                $(
                                    ".dimas-testimonial-slider .swiper-slide[data-swiper-slide-index=" +
                                    i +
                                    "]"
                                )
                            ) {
                                var data_customer_img_src = $(
                                    ".dimas-testimonial-slider .swiper-slide[data-swiper-slide-index=" +
                                    i +
                                    "]"
                                ).attr("data-customer-img-src");
                                $(this).append(
                                    '<img class="testimonial__thumbnail" src="' +
                                    data_customer_img_src +
                                    '" alt="Testimonial thumbnail">'
                                );
                                i++;
                            }
                        }
                    );
                }
                if (!slider_active) {
                    setTimeout(box_check, 100);
                } else {
                    setTimeout(box_check, 0);
                }
            }
            /*slider project single*/
            if ($("#left-slider .swiper").length > 0) {
                if ($(window).width() > 1199) {
                    const slider_projects_left = new Swiper("#left-slider .swiper", {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        direction: "horizontal",
                        initialSlide: 0,
                        PreventInteractionOnTransition: true,
                        pagination: {
                            el: ".swiper-pagination",
                            type: "bullets",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        keyboard: {
                            enabled: true,
                            onlyInViewport: false,
                        },
                    });
                    const slider_projects_right = new Swiper("#right-slider .swiper", {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        direction: "horizontal",
                        initialSlide: 0,
                        PreventInteractionOnTransition: true,
                        keyboard: {
                            enabled: true,
                            onlyInViewport: false,
                        },
                    });
                    slider_projects_right.on("slideChangeTransitionStart", function () {
                        var active_index_right = slider_projects_right.activeIndex;
                        var active_index_left = slider_projects_left.activeIndex;
                        if (active_index_right != active_index_left) {
                            slider_projects_left.slideTo(active_index_right, 300, true);
                        }
                    });
                    slider_projects_left.on("slideChangeTransitionStart", function () {
                        var active_index_left = slider_projects_left.activeIndex;
                        var active_index_right = slider_projects_right.activeIndex;
                        if (active_index_left != active_index_right) {
                            slider_projects_right.slideTo(active_index_left, 300, true);
                        }
                    });
                } else {
                    var count_slide = 0;
                    $("#right-slider .swiper-slide").each(function () {
                        count_slide++;
                        $(this).addClass("pp-wrap");
                        $(this).removeClass("swiper-slide");
                        $(this).appendTo(
                            "#left-slider .swiper-slide:nth-child(" + count_slide + ")"
                        );
                    });
                    $("#right-slider").remove();
                    $("#left-slider .swiper-wrapper").attr("id", "right-slider");
                    $("#left-slider .swiper-wrapper").removeClass("swiper-wrapper");
                    $("#left-slider .swiper-slide").each(function () {
                        $(this).addClass("dimas-section pp-scrollable");
                    });
                    void 0 !== t.fn.pagepiling &&
                        t("#left-slider").length &&
                        ((DIMASJS.fullprojectSlider = {
                            init: function () {
                                var n = t("#left-slider"),
                                    o = 800;
                                DIMASJS.body.css("overflow", "hidden"),
                                    DIMASJS.html.css("overflow", "hidden"),
                                    n.pagepiling({
                                        menu: null,
                                        scrollingSpeed: o,
                                        loopTop: false,
                                        loopBottom: false,
                                        anchors: false,
                                        sectionSelector: ".dimas-section",
                                        navigation: false,
                                        afterRender: function () {
                                            DIMASJS.window.trigger("dimas.change-slide");
                                        },
                                        onLeave: function (t, n, e) {
                                            DIMASJS.window.trigger("dimas.change-slide");
                                        },
                                    });
                            },
                        }),
                            DIMASJS.fullprojectSlider.init());
                }
            }
            /*play video*/
            function pl(t) {
                if (t.hasClass("played")) {
                    t.trigger("pause");
                    t.removeClass("played");
                    $(".dimas-btn.play-video").show();
                } else {
                    t.trigger("play");
                    t.addClass("played");
                    $(".dimas-btn.play-video").hide();
                }
            }
            $(".dimas-btn.play-video").click(function () {
                const vid = $(this).closest(".swiper-slide").find(".slider-video");
                pl(vid);
            });
            $(".slider-video").click(function () {
                pl($(this));
            });
            /* show pointer project */
            if ($(".dimas-project-pointer").length > 0) {
                $(".dimas-project-pointer").each(function () {
                    if ($(this).attr("data-left")) {
                        var data_left = $(this).attr("data-left");
                        $(this).css("left", data_left);
                    }
                    if ($(this).attr("data-top")) {
                        var data_top = $(this).attr("data-top");
                        $(this).css("top", data_top);
                    }
                    if ($(this).attr("data-title")) {
                        var data_title = $(this).attr("data-title");
                        $(this)
                            .find(".dimas-project-pointer__description--title")
                            .text(data_title);
                    }
                    if ($(this).attr("data-text")) {
                        var data_text = $(this).attr("data-text");
                        $(this)
                            .find(".dimas-project-pointer__description--text")
                            .text(data_text);
                    }
                });
                $(".dimas-project-pointer").click(function () {
                    $(".dimas-project-pointer").removeClass("active");
                    $(this).addClass("active");
                });
            }
            /* manosory */
            if ($(".grid").length > 0) {
                setTimeout(() => {
                    $(".grid").masonry({
                        gutter: 32,
                        columnWidth: ".grid-sizer",
                        itemSelector: ".grid-item",
                        percentPosition: true,
                        horizontalOrder: true,
                    });
                }, 100);
            }
            /* lockfixed social share sinlge post*/
            if ($(".dimas-sticky-share").length > 0) {
                function check_sticky() {
                    var window_top_position = $(window).scrollTop();
                    var window_height = $(window).height();
                    var $element = $('.dimas-post__vertical-align > .container');
                    var element_height = $element.outerHeight();
                    var element_top_position = $element.offset().top;
                    var end_sticky = $(".dimas-sticky-share").outerHeight();
                    var ticky_position = (element_top_position + element_height - 80 - end_sticky);
                    var stop_sticky_position = ticky_position - (window_height * 0.3);
                    if ((stop_sticky_position <= window_top_position)) {
                        $(".dimas-sticky-share").css('position', 'absolute');
                        $(".dimas-sticky-share").css('top', ticky_position + 'px');
                    } else {
                        $(".dimas-sticky-share").css('position', 'fixed');
                        $(".dimas-sticky-share").css('top', '30%');
                    }
                }
                $(window).scroll(function () {
                    check_sticky();
                });
            }
            /* fancybox */
            if ($(".fancybox__link").length > 0) {
                const gallery_post = Fancybox.bind('[data-fancybox="gallery"]', {
                    zoom: false,
                    on: {
                        load: (fancybox, slide) => {

                        },
                    },
                });
            }
            /* add class scroll header */
            function add_remove_class_header(header_size) {
                if ($(window).scrollTop() > header_size) {
                    if (!$('.dimas-navbar.dimas-navbar--main').hasClass('dimas-navbar--solid')) {
                        $('.dimas-navbar.dimas-navbar--main').addClass('dimas-navbar--solid');
                    }
                } else {
                    if ($('.dimas-navbar.dimas-navbar--main').hasClass('dimas-navbar--solid')) {
                        $('.dimas-navbar.dimas-navbar--main').removeClass('dimas-navbar--solid');
                    }
                }
            }
            $(window).scroll(function () {
                if ($(window) > 575) {
                    add_remove_class_header(92);
                } else {
                    add_remove_class_header(64);
                }
            });
        });
    });
})(jQuery);
