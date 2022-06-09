/*!
 * pagepiling.js 1.5.6
 *
 * https://github.com/alvarotrigo/pagePiling.js
 * @license MIT licensed
 *
 * Copyright (C) 2016 alvarotrigo.com - A project by Alvaro Trigo
 */
(function(t, e, i, n) {
    "use strict";
    t.fn.pagepiling = function(s) {
        var a,
            r = t.fn.pagepiling,
            o = t(this),
            l = 0,
            c =
            "ontouchstart" in i ||
            navigator.msMaxTouchPoints > 0 ||
            navigator.maxTouchPoints,
            d = 0,
            u = 0,
            h = 0,
            p = 0,
            f = [],
            m = t.extend(!0, {
                    direction: "vertical",
                    menu: null,
                    verticalCentered: !0,
                    sectionsColor: [],
                    anchors: [],
                    scrollingSpeed: 700,
                    easing: "easeInQuart",
                    loopBottom: !1,
                    loopTop: !1,
                    css3: !0,
                    navigation: {
                        textColor: "#000",
                        bulletsColor: "#000",
                        position: "right",
                        tooltips: [],
                    },
                    normalScrollElements: null,
                    normalScrollElementTouchThreshold: 5,
                    touchSensitivity: 5,
                    keyboardScrolling: !0,
                    sectionSelector: ".section",
                    animateAnchor: !1,
                    afterLoad: null,
                    onLeave: null,
                    afterRender: null,
                },
                s
            );
        t.extend(t.easing, {
                easeInQuart: function(t, e, i, n, s) {
                    return n * (e /= s) * e * e * e + i;
                },
            }),
            (r.setScrollingSpeed = function(t) {
                m.scrollingSpeed = t;
            }),
            (r.setMouseWheelScrolling = function(t) {
                t
                    ?
                    o.get(0).addEventListener ?
                    (o.get(0).addEventListener("mousewheel", E, !1),
                        o.get(0).addEventListener("wheel", E, !1)) :
                    o.get(0).attachEvent("onmousewheel", E) :
                    o.get(0).addEventListener ?
                    (o.get(0).removeEventListener("mousewheel", E, !1),
                        o.get(0).removeEventListener("wheel", E, !1)) :
                    o.get(0).detachEvent("onmousewheel", E);
            }),
            (r.setAllowScrolling = function(t) {
                t
                    ?
                    (r.setMouseWheelScrolling(!0),
                        (function() {
                            if (c) {
                                var t = P();
                                o.off("touchstart " + t.down).on("touchstart " + t.down, L),
                                    o.off("touchmove " + t.move).on("touchmove " + t.move, I);
                            }
                        })()) :
                    (r.setMouseWheelScrolling(!1),
                        (function() {
                            if (c) {
                                var t = P();
                                o.off("touchstart " + t.down), o.off("touchmove " + t.move);
                            }
                        })());
            }),
            (r.setKeyboardScrolling = function(t) {
                m.keyboardScrolling = t;
            }),
            (r.moveSectionUp = function() {
                var e = t(".pp-section.active").prev(".pp-section");
                !e.length && m.loopTop && (e = t(".pp-section").last()),
                    e.length && g(e);
            }),
            (r.moveSectionDown = function() {
                var e = t(".pp-section.active").next(".pp-section");
                !e.length && m.loopBottom && (e = t(".pp-section").first()),
                    e.length && g(e);
            }),
            (r.moveTo = function(i) {
                var n = "";
                (n = isNaN(i) ?
                    t(e).find('[data-anchor="' + i + '"]') :
                    t(".pp-section").eq(i - 1)).length > 0 && g(n);
            }),
            t(m.sectionSelector).each(function() {
                t(this).addClass("pp-section");
            }),
            m.css3 &&
            (m.css3 = (function() {
                var t = e.createElement("p"),
                    s = {
                        webkitTransform: "-webkit-transform",
                        OTransform: "-o-transform",
                        msTransform: "-ms-transform",
                        MozTransform: "-moz-transform",
                        transform: "transform",
                    };
                for (var a in (e.body.insertBefore(t, null), s))
                    t.style[a] !== n &&
                    ((t.style[a] = "translate3d(1px,1px,1px)"),
                        i.getComputedStyle(t).getPropertyValue(s[a]));
                return e.body.removeChild(t), !0;
            })()),
            t(o).css({
                overflow: "hidden",
                "-ms-touch-action": "none",
                "touch-action": "none",
            }),
            r.setAllowScrolling(!0),
            t.isEmptyObject(m.navigation) ||
            (function() {
                t("body").append('<div id="pp-nav"><ul></ul></div>');
                var e = t("#pp-nav");
                e.css("color", m.navigation.textColor),
                    e.addClass(m.navigation.position);
                for (var i = 0; i < t(".pp-section").length; i++) {
                    var n = "";
                    if (
                        (m.anchors.length && (n = m.anchors[i]),
                            "undefined" !== m.navigation.tooltips)
                    ) {
                        var s = m.navigation.tooltips[i];
                        void 0 === s && (s = "");
                    }
                    e.find("ul").append(
                        '<li data-tooltip="' +
                        s +
                        '"><a href="#' +
                        n +
                        '"><span></span></a></li>'
                    );
                }
                e.find("span").css("border-color", m.navigation.bulletsColor);
            })();
        var v = t(".pp-section").length;

        function g(e, i) {
            var n,
                s = {
                    destination: e,
                    animated: i,
                    activeSection: t(".pp-section.active"),
                    anchorLink: e.data("anchor"),
                    sectionIndex: e.index(".pp-section"),
                    toMove: e,
                    yMovement:
                        ((n = e),
                            t(".pp-section.active").index(".pp-section") >
                            n.index(".pp-section") ?
                            "up" :
                            "down"),
                    leavingSection: t(".pp-section.active").index(".pp-section") + 1,
                };
            if (!s.activeSection.is(e)) {
                var r, o, c;
                void 0 === s.animated && (s.animated = !0),
                    void 0 !== s.anchorLink &&
                    ((r = s.anchorLink),
                        (o = s.sectionIndex),
                        m.anchors.length ?
                        ((location.hash = r), x(location.hash)) :
                        x(String(o))),
                    s.destination.addClass("active").siblings().removeClass("active"),
                    (s.sectionsToMove = (function(e) {
                        var i;
                        i =
                            "down" === e.yMovement ?
                            t(".pp-section").map(function(i) {
                                if (i < e.destination.index(".pp-section"))
                                    return t(this);
                            }) :
                            t(".pp-section").map(function(i) {
                                if (i > e.destination.index(".pp-section"))
                                    return t(this);
                            });
                        return i;
                    })(s)),
                    "down" === s.yMovement ?
                    ((s.translate3d = O()),
                        (s.scrolling = "-100%"),
                        m.css3 ||
                        s.sectionsToMove.each(function(e) {
                            e != s.activeSection.index(".pp-section") &&
                                t(this).css(w(s.scrolling));
                        }),
                        (s.animateSection = s.activeSection)) :
                    ((s.translate3d = "translate3d(0px, 0px, 0px)"),
                        (s.scrolling = "0"),
                        (s.animateSection = e)),
                    t.isFunction(m.onLeave) &&
                    m.onLeave.call(
                        this,
                        s.leavingSection,
                        s.sectionIndex + 1,
                        s.yMovement
                    ),
                    (function(e) {
                        m.css3 ?
                            (S(e.animateSection, e.translate3d, e.animated),
                                e.sectionsToMove.each(function() {
                                    S(t(this), e.translate3d, e.animated);
                                }),
                                setTimeout(function() {
                                    y(e);
                                }, m.scrollingSpeed)) :
                            ((e.scrollOptions = w(e.scrolling)),
                                e.animated ?
                                e.animateSection.animate(
                                    e.scrollOptions,
                                    m.scrollingSpeed,
                                    m.easing,
                                    function() {
                                        b(e), y(e);
                                    }
                                ) :
                                (e.animateSection.css(w(e.scrolling)),
                                    setTimeout(function() {
                                        b(e), y(e);
                                    }, 400)));
                    })(s),
                    (c = s.anchorLink),
                    m.menu &&
                    (t(m.menu).find(".active").removeClass("active"),
                        t(m.menu)
                        .find('[data-menuanchor="' + c + '"]')
                        .addClass("active")),
                    (function(e, i) {
                        m.navigation &&
                            (t("#pp-nav").find(".active").removeClass("active"),
                                e ?
                                t("#pp-nav")
                                .find('a[href="#' + e + '"]')
                                .addClass("active") :
                                t("#pp-nav").find("li").eq(i).find("a").addClass("active"));
                    })(s.anchorLink, s.sectionIndex),
                    (a = s.anchorLink);
                var d = new Date().getTime();
                l = d;
            }
        }

        function y(e) {
            t.isFunction(m.afterLoad) &&
                m.afterLoad.call(this, e.anchorLink, e.sectionIndex + 1);
        }

        function b(e) {
            "up" === e.yMovement &&
                e.sectionsToMove.each(function(i) {
                    t(this).css(w(e.scrolling));
                });
        }

        function w(t) {
            return "vertical" === m.direction ? {
                top: t,
            } : {
                left: t,
            };
        }

        function x(e) {
            (e = e.replace("#", "")),
            (t("body")[0].className = t("body")[0].className.replace(
                /\b\s?pp-viewing-[^\s]+\b/g,
                ""
            )),
            t("body").addClass("pp-viewing-" + e);
        }

        function T() {
            return new Date().getTime() - l < 600 + m.scrollingSpeed;
        }

        function S(t, e, i) {
            t.toggleClass("pp-easing", i),
                t.css(
                    (function(t) {
                        return {
                            "-webkit-transform": t,
                            "-moz-transform": t,
                            "-ms-transform": t,
                            transform: t,
                        };
                    })(e)
                );
        }
        t(".pp-section")
            .each(function(e) {
                t(this).data("data-index", e),
                    t(this).css("z-index", v),
                    e ||
                    0 !== t(".pp-section.active").length ||
                    t(this).addClass("active"),
                    void 0 !== m.anchors[e] &&
                    t(this).attr("data-anchor", m.anchors[e]),
                    void 0 !== m.sectionsColor[e] &&
                    t(this).css("background-color", m.sectionsColor[e]),
                    m.verticalCentered &&
                    !t(this).hasClass("pp-scrollable") &&
                    t(this)
                    .addClass("pp-table")
                    .wrapInner('<div class="pp-tableCell" style="height:100%" />'),
                    (v -= 1);
            })
            .promise()
            .done(function() {
                m.navigation &&
                    (t("#pp-nav").css(
                            "margin-top",
                            "-" + t("#pp-nav").height() / 2 + "px"
                        ),
                        t("#pp-nav")
                        .find("li")
                        .eq(t(".pp-section.active").index(".pp-section"))
                        .find("a")
                        .addClass("active")),
                    t(i).on("load", function() {
                        var n, s;
                        (n = i.location.hash.replace("#", "")),
                        (s = t(e).find('.pp-section[data-anchor="' + n + '"]')).length >
                            0 && g(s, m.animateAnchor);
                    }),
                    t.isFunction(m.afterRender) && m.afterRender.call(this);
            }),
            t(i).on("hashchange", function() {
                var n = i.location.hash.replace("#", "").split("/")[0];
                if (n.length) {
                    if (n && n !== a)
                        g(
                            isNaN(n) ?
                            t(e).find('[data-anchor="' + n + '"]') :
                            t(".pp-section").eq(n - 1)
                        );
                }
            }),
            t(e).keydown(function(e) {
                if (m.keyboardScrolling && !T())
                    switch (e.which) {
                        case 38:
                        case 33:
                        case 37:
                            r.moveSectionUp();
                            break;
                        case 40:
                        case 34:
                        case 39:
                            r.moveSectionDown();
                            break;
                        case 36:
                            r.moveTo(1);
                            break;
                        case 35:
                            r.moveTo(t(".pp-section").length);
                            break;
                        default:
                            return;
                    }
            }),
            m.normalScrollElements &&
            (t(e).on("mouseenter", m.normalScrollElements, function() {
                    r.setMouseWheelScrolling(!1);
                }),
                t(e).on("mouseleave", m.normalScrollElements, function() {
                    r.setMouseWheelScrolling(!0);
                }));
        var C = new Date().getTime();

        function E(e) {
            var n = new Date().getTime(),
                s = (e = e || i.event).wheelDelta || -e.deltaY || -e.detail,
                a = Math.max(-1, Math.min(1, s)),
                r = void 0 !== e.wheelDeltaX || void 0 !== e.deltaX,
                o =
                Math.abs(e.wheelDeltaX) < Math.abs(e.wheelDelta) ||
                Math.abs(e.deltaX) < Math.abs(e.deltaY) ||
                !r;
            f.length > 149 && f.shift(), f.push(Math.abs(s));
            var l = n - C;
            if (((C = n), l > 200 && (f = []), !T())) {
                var c = _(t(".pp-section.active"));
                return (
                    k(f, 10) >= k(f, 70) &&
                    o &&
                    (a < 0 ? M("down", c) : a > 0 && M("up", c)), !1
                );
            }
        }

        function k(t, e) {
            for (
                var i = 0, n = t.slice(Math.max(t.length - e, 1)), s = 0; s < n.length; s++
            )
                i += n[s];
            return Math.ceil(i / e);
        }

        function M(t, e) {
            var i, n;
            if (
                ("down" == t ?
                    ((i = "bottom"), (n = r.moveSectionDown)) :
                    ((i = "top"), (n = r.moveSectionUp)),
                    e.length > 0)
            ) {
                if (!(function(t, e) {
                        if ("top" === t) return !e.scrollTop();
                        if ("bottom" === t)
                            return e.scrollTop() + 1 + e.innerHeight() >= e[0].scrollHeight;
                    })(i, e))
                    return !0;
                n();
            } else n();
        }

        function _(t) {
            return t.filter(".pp-scrollable");
        }

        function P() {
            return i.PointerEvent ? {
                down: "pointerdown",
                move: "pointermove",
                up: "pointerup",
            } : {
                down: "MSPointerDown",
                move: "MSPointerMove",
                up: "MSPointerUp",
            };
        }

        function $(t) {
            var e = new Array();
            return (
                (e.y =
                    void 0 !== t.pageY && (t.pageY || t.pageX) ?
                    t.pageY :
                    t.touches[0].pageY),
                (e.x =
                    void 0 !== t.pageX && (t.pageY || t.pageX) ?
                    t.pageX :
                    t.touches[0].pageX),
                e
            );
        }

        function A(t) {
            return void 0 === t.pointerType || "mouse" != t.pointerType;
        }

        function L(t) {
            var e = t.originalEvent;
            if (A(e)) {
                var i = $(e);
                (d = i.y), (u = i.x);
            }
        }

        function I(e) {
            var i = e.originalEvent;
            if (!z(e.target) && A(i)) {
                var n = _(t(".pp-section.active"));
                if ((n.length || e.preventDefault(), !T())) {
                    var s = $(i);
                    (h = s.y),
                    (p = s.x),
                    "horizontal" === m.direction && Math.abs(u - p) > Math.abs(d - h) ?
                        Math.abs(u - p) > (o.width() / 100) * m.touchSensitivity &&
                        (u > p ? M("down", n) : p > u && M("up", n)) :
                        Math.abs(d - h) > (o.height() / 100) * m.touchSensitivity &&
                        (d > h ? M("down", n) : h > d && M("up", n));
                }
            }
        }

        function z(e, i) {
            i = i || 0;
            var n = t(e).parent();
            return (!!(
                    i < m.normalScrollElementTouchThreshold &&
                    n.is(m.normalScrollElements)
                ) ||
                (i != m.normalScrollElementTouchThreshold && z(n, ++i))
            );
        }

        function O() {
            return "vertical" !== m.direction ?
                "translate3d(-100%, 0px, 0px)" :
                "translate3d(0px, -100%, 0px)";
        }
        t(e).on("click touchstart", "#pp-nav a", function(e) {
                e.preventDefault();
                var i = t(this).parent().index();
                g(t(".pp-section").eq(i));
            }),
            t(e).on({
                    mouseenter: function() {
                        var e = t(this).data("tooltip");
                        t(
                                '<div class="pp-tooltip ' +
                                m.navigation.position +
                                '">' +
                                e +
                                "</div>"
                            )
                            .hide()
                            .appendTo(t(this))
                            .fadeIn(200);
                    },
                    mouseleave: function() {
                        t(this)
                            .find(".pp-tooltip")
                            .fadeOut(200, function() {
                                t(this).remove();
                            });
                    },
                },
                "#pp-nav li"
            );
    };
})(jQuery, document, window),
(function(t) {
    "function" == typeof define && define.amd ?
        define(["jquery"], t) :
        "object" == typeof module && module.exports ?
        (module.exports = t(require("jquery"))) :
        t(jQuery);
})(function(t) {
    t.extend(t.fn, {
        validate: function(e) {
            if (this.length) {
                var i = t.data(this[0], "validator");
                return (
                    i ||
                    (this.attr("novalidate", "novalidate"),
                        (i = new t.validator(e, this[0])),
                        t.data(this[0], "validator", i),
                        i.settings.onsubmit &&
                        (this.on("click.validate", ":submit", function(e) {
                                (i.submitButton = e.currentTarget),
                                t(this).hasClass("cancel") && (i.cancelSubmit = !0),
                                    void 0 !== t(this).attr("formnovalidate") &&
                                    (i.cancelSubmit = !0);
                            }),
                            this.on("submit.validate", function(e) {
                                function n() {
                                    var n, s;
                                    return (
                                        i.submitButton &&
                                        (i.settings.submitHandler || i.formSubmitted) &&
                                        (n = t("<input type='hidden'/>")
                                            .attr("name", i.submitButton.name)
                                            .val(t(i.submitButton).val())
                                            .appendTo(i.currentForm)), !(i.settings.submitHandler && !i.settings.debug) ||
                                        ((s = i.settings.submitHandler.call(i, i.currentForm, e)),
                                            n && n.remove(),
                                            void 0 !== s && s)
                                    );
                                }
                                return (
                                    i.settings.debug && e.preventDefault(),
                                    i.cancelSubmit ?
                                    ((i.cancelSubmit = !1), n()) :
                                    i.form() ?
                                    i.pendingRequest ?
                                    ((i.formSubmitted = !0), !1) :
                                    n() :
                                    (i.focusInvalid(), !1)
                                );
                            })),
                        i)
                );
            }
            e &&
                e.debug &&
                window.console &&
                console.warn("Nothing selected, can't validate, returning nothing.");
        },
        valid: function() {
            var e, i, n;
            return (
                t(this[0]).is("form") ?
                (e = this.validate().form()) :
                ((n = []),
                    (e = !0),
                    (i = t(this[0].form).validate()),
                    this.each(function() {
                        (e = i.element(this) && e) || (n = n.concat(i.errorList));
                    }),
                    (i.errorList = n)),
                e
            );
        },
        rules: function(e, i) {
            var n,
                s,
                a,
                r,
                o,
                l,
                c = this[0],
                d =
                void 0 !== this.attr("contenteditable") &&
                "false" !== this.attr("contenteditable");
            if (
                null != c &&
                (!c.form &&
                    d &&
                    ((c.form = this.closest("form")[0]), (c.name = this.attr("name"))),
                    null != c.form)
            ) {
                if (e)
                    switch (
                        ((n = t.data(c.form, "validator").settings),
                            (s = n.rules),
                            (a = t.validator.staticRules(c)),
                            e)
                    ) {
                        case "add":
                            t.extend(a, t.validator.normalizeRule(i)),
                                delete a.messages,
                                (s[c.name] = a),
                                i.messages &&
                                (n.messages[c.name] = t.extend(
                                    n.messages[c.name],
                                    i.messages
                                ));
                            break;
                        case "remove":
                            return i ?
                                ((l = {}),
                                    t.each(i.split(/\s/), function(t, e) {
                                        (l[e] = a[e]), delete a[e];
                                    }),
                                    l) :
                                (delete s[c.name], a);
                    }
                return (
                    (r = t.validator.normalizeRules(
                        t.extend({},
                            t.validator.classRules(c),
                            t.validator.attributeRules(c),
                            t.validator.dataRules(c),
                            t.validator.staticRules(c)
                        ),
                        c
                    )).required &&
                    ((o = r.required),
                        delete r.required,
                        (r = t.extend({
                                required: o,
                            },
                            r
                        ))),
                    r.remote &&
                    ((o = r.remote),
                        delete r.remote,
                        (r = t.extend(r, {
                            remote: o,
                        }))),
                    r
                );
            }
        },
    });
    var e = function(t) {
        return t.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");
    };
    t.extend(t.expr.pseudos || t.expr[":"], {
            blank: function(i) {
                return !e("" + t(i).val());
            },
            filled: function(i) {
                var n = t(i).val();
                return null !== n && !!e("" + n);
            },
            unchecked: function(e) {
                return !t(e).prop("checked");
            },
        }),
        (t.validator = function(e, i) {
            (this.settings = t.extend(!0, {}, t.validator.defaults, e)),
            (this.currentForm = i),
            this.init();
        }),
        (t.validator.format = function(e, i) {
            return 1 === arguments.length ?

                function() {
                    var i = t.makeArray(arguments);
                    return i.unshift(e), t.validator.format.apply(this, i);
                } :
                (void 0 === i ||
                    (arguments.length > 2 &&
                        i.constructor !== Array &&
                        (i = t.makeArray(arguments).slice(1)),
                        i.constructor !== Array && (i = [i]),
                        t.each(i, function(t, i) {
                            e = e.replace(new RegExp("\\{" + t + "\\}", "g"), function() {
                                return i;
                            });
                        })),
                    e);
        }),
        t.extend(t.validator, {
            defaults: {
                messages: {},
                groups: {},
                rules: {},
                errorClass: "error",
                pendingClass: "pending",
                validClass: "valid",
                errorElement: "label",
                focusCleanup: !1,
                focusInvalid: !0,
                errorContainer: t([]),
                errorLabelContainer: t([]),
                onsubmit: !0,
                ignore: ":hidden",
                ignoreTitle: !1,
                onfocusin: function(t) {
                    (this.lastActive = t),
                    this.settings.focusCleanup &&
                        (this.settings.unhighlight &&
                            this.settings.unhighlight.call(
                                this,
                                t,
                                this.settings.errorClass,
                                this.settings.validClass
                            ),
                            this.hideThese(this.errorsFor(t)));
                },
                onfocusout: function(t) {
                    this.checkable(t) ||
                        (!(t.name in this.submitted) && this.optional(t)) ||
                        this.element(t);
                },
                onkeyup: function(e, i) {
                    (9 === i.which && "" === this.elementValue(e)) ||
                    -1 !==
                        t.inArray(
                            i.keyCode, [16, 17, 18, 20, 35, 36, 37, 38, 39, 40, 45, 144, 225]
                        ) ||
                        ((e.name in this.submitted || e.name in this.invalid) &&
                            this.element(e));
                },
                onclick: function(t) {
                    t.name in this.submitted ?
                        this.element(t) :
                        t.parentNode.name in this.submitted &&
                        this.element(t.parentNode);
                },
                highlight: function(e, i, n) {
                    "radio" === e.type ?
                        this.findByName(e.name).addClass(i).removeClass(n) :
                        t(e).addClass(i).removeClass(n);
                },
                unhighlight: function(e, i, n) {
                    "radio" === e.type ?
                        this.findByName(e.name).removeClass(i).addClass(n) :
                        t(e).removeClass(i).addClass(n);
                },
            },
            setDefaults: function(e) {
                t.extend(t.validator.defaults, e);
            },
            messages: {
                required: "This field is required.",
                remote: "Please fix this field.",
                email: "Please enter a valid email address.",
                url: "Please enter a valid URL.",
                date: "Please enter a valid date.",
                dateISO: "Please enter a valid date (ISO).",
                number: "Please enter a valid number.",
                digits: "Please enter only digits.",
                equalTo: "Please enter the same value again.",
                maxlength: t.validator.format(
                    "Please enter no more than {0} characters."
                ),
                minlength: t.validator.format(
                    "Please enter at least {0} characters."
                ),
                rangelength: t.validator.format(
                    "Please enter a value between {0} and {1} characters long."
                ),
                range: t.validator.format(
                    "Please enter a value between {0} and {1}."
                ),
                max: t.validator.format(
                    "Please enter a value less than or equal to {0}."
                ),
                min: t.validator.format(
                    "Please enter a value greater than or equal to {0}."
                ),
                step: t.validator.format("Please enter a multiple of {0}."),
            },
            autoCreateRanges: !1,
            prototype: {
                init: function() {
                    function e(e) {
                        var i =
                            void 0 !== t(this).attr("contenteditable") &&
                            "false" !== t(this).attr("contenteditable");
                        if (
                            (!this.form &&
                                i &&
                                ((this.form = t(this).closest("form")[0]),
                                    (this.name = t(this).attr("name"))),
                                n === this.form)
                        ) {
                            var s = t.data(this.form, "validator"),
                                a = "on" + e.type.replace(/^validate/, ""),
                                r = s.settings;
                            r[a] && !t(this).is(r.ignore) && r[a].call(s, this, e);
                        }
                    }
                    (this.labelContainer = t(this.settings.errorLabelContainer)),
                    (this.errorContext =
                        (this.labelContainer.length && this.labelContainer) ||
                        t(this.currentForm)),
                    (this.containers = t(this.settings.errorContainer).add(
                        this.settings.errorLabelContainer
                    )),
                    (this.submitted = {}),
                    (this.valueCache = {}),
                    (this.pendingRequest = 0),
                    (this.pending = {}),
                    (this.invalid = {}),
                    this.reset();
                    var i,
                        n = this.currentForm,
                        s = (this.groups = {});
                    t.each(this.settings.groups, function(e, i) {
                            "string" == typeof i && (i = i.split(/\s/)),
                                t.each(i, function(t, i) {
                                    s[i] = e;
                                });
                        }),
                        (i = this.settings.rules),
                        t.each(i, function(e, n) {
                            i[e] = t.validator.normalizeRule(n);
                        }),
                        t(this.currentForm)
                        .on(
                            "focusin.validate focusout.validate keyup.validate",
                            ":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'], [type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], [type='radio'], [type='checkbox'], [contenteditable], [type='button']",
                            e
                        )
                        .on(
                            "click.validate",
                            "select, option, [type='radio'], [type='checkbox']",
                            e
                        ),
                        this.settings.invalidHandler &&
                        t(this.currentForm).on(
                            "invalid-form.validate",
                            this.settings.invalidHandler
                        );
                },
                form: function() {
                    return (
                        this.checkForm(),
                        t.extend(this.submitted, this.errorMap),
                        (this.invalid = t.extend({}, this.errorMap)),
                        this.valid() ||
                        t(this.currentForm).triggerHandler("invalid-form", [this]),
                        this.showErrors(),
                        this.valid()
                    );
                },
                checkForm: function() {
                    this.prepareForm();
                    for (
                        var t = 0, e = (this.currentElements = this.elements()); e[t]; t++
                    )
                        this.check(e[t]);
                    return this.valid();
                },
                element: function(e) {
                    var i,
                        n,
                        s = this.clean(e),
                        a = this.validationTargetFor(s),
                        r = this,
                        o = !0;
                    return (
                        void 0 === a ?
                        delete this.invalid[s.name] :
                        (this.prepareElement(a),
                            (this.currentElements = t(a)),
                            (n = this.groups[a.name]) &&
                            t.each(this.groups, function(t, e) {
                                e === n &&
                                    t !== a.name &&
                                    (s = r.validationTargetFor(r.clean(r.findByName(t)))) &&
                                    s.name in r.invalid &&
                                    (r.currentElements.push(s), (o = r.check(s) && o));
                            }),
                            (i = !1 !== this.check(a)),
                            (o = o && i),
                            (this.invalid[a.name] = !i),
                            this.numberOfInvalids() ||
                            (this.toHide = this.toHide.add(this.containers)),
                            this.showErrors(),
                            t(e).attr("aria-invalid", !i)),
                        o
                    );
                },
                showErrors: function(e) {
                    if (e) {
                        var i = this;
                        t.extend(this.errorMap, e),
                            (this.errorList = t.map(this.errorMap, function(t, e) {
                                return {
                                    message: t,
                                    element: i.findByName(e)[0],
                                };
                            })),
                            (this.successList = t.grep(this.successList, function(t) {
                                return !(t.name in e);
                            }));
                    }
                    this.settings.showErrors ?
                        this.settings.showErrors.call(
                            this,
                            this.errorMap,
                            this.errorList
                        ) :
                        this.defaultShowErrors();
                },
                resetForm: function() {
                    t.fn.resetForm && t(this.currentForm).resetForm(),
                        (this.invalid = {}),
                        (this.submitted = {}),
                        this.prepareForm(),
                        this.hideErrors();
                    var e = this.elements()
                        .removeData("previousValue")
                        .removeAttr("aria-invalid");
                    this.resetElements(e);
                },
                resetElements: function(t) {
                    var e;
                    if (this.settings.unhighlight)
                        for (e = 0; t[e]; e++)
                            this.settings.unhighlight.call(
                                this,
                                t[e],
                                this.settings.errorClass,
                                ""
                            ),
                            this.findByName(t[e].name).removeClass(
                                this.settings.validClass
                            );
                    else
                        t.removeClass(this.settings.errorClass).removeClass(
                            this.settings.validClass
                        );
                },
                numberOfInvalids: function() {
                    return this.objectLength(this.invalid);
                },
                objectLength: function(t) {
                    var e,
                        i = 0;
                    for (e in t) void 0 !== t[e] && null !== t[e] && !1 !== t[e] && i++;
                    return i;
                },
                hideErrors: function() {
                    this.hideThese(this.toHide);
                },
                hideThese: function(t) {
                    t.not(this.containers).text(""), this.addWrapper(t).hide();
                },
                valid: function() {
                    return 0 === this.size();
                },
                size: function() {
                    return this.errorList.length;
                },
                focusInvalid: function() {
                    if (this.settings.focusInvalid)
                        try {
                            t(
                                    this.findLastActive() ||
                                    (this.errorList.length && this.errorList[0].element) || []
                                )
                                .filter(":visible")
                                .trigger("focus")
                                .trigger("focusin");
                        } catch (t) {}
                },
                findLastActive: function() {
                    var e = this.lastActive;
                    return (
                        e &&
                        1 ===
                        t.grep(this.errorList, function(t) {
                            return t.element.name === e.name;
                        }).length &&
                        e
                    );
                },
                elements: function() {
                    var e = this,
                        i = {};
                    return t(this.currentForm)
                        .find("input, select, textarea, [contenteditable]")
                        .not(":submit, :reset, :image, :disabled")
                        .not(this.settings.ignore)
                        .filter(function() {
                            var n = this.name || t(this).attr("name"),
                                s =
                                void 0 !== t(this).attr("contenteditable") &&
                                "false" !== t(this).attr("contenteditable");
                            return (!n &&
                                e.settings.debug &&
                                window.console &&
                                console.error("%o has no name assigned", this),
                                s &&
                                ((this.form = t(this).closest("form")[0]), (this.name = n)), !(
                                    this.form !== e.currentForm ||
                                    n in i ||
                                    !e.objectLength(t(this).rules()) ||
                                    ((i[n] = !0), 0)
                                )
                            );
                        });
                },
                clean: function(e) {
                    return t(e)[0];
                },
                errors: function() {
                    var e = this.settings.errorClass.split(" ").join(".");
                    return t(this.settings.errorElement + "." + e, this.errorContext);
                },
                resetInternals: function() {
                    (this.successList = []),
                    (this.errorList = []),
                    (this.errorMap = {}),
                    (this.toShow = t([])),
                    (this.toHide = t([]));
                },
                reset: function() {
                    this.resetInternals(), (this.currentElements = t([]));
                },
                prepareForm: function() {
                    this.reset(), (this.toHide = this.errors().add(this.containers));
                },
                prepareElement: function(t) {
                    this.reset(), (this.toHide = this.errorsFor(t));
                },
                elementValue: function(e) {
                    var i,
                        n,
                        s = t(e),
                        a = e.type,
                        r =
                        void 0 !== s.attr("contenteditable") &&
                        "false" !== s.attr("contenteditable");
                    return "radio" === a || "checkbox" === a ?
                        this.findByName(e.name).filter(":checked").val() :
                        "number" === a && void 0 !== e.validity ?
                        e.validity.badInput ?
                        "NaN" :
                        s.val() :
                        ((i = r ? s.text() : s.val()),
                            "file" === a ?
                            "C:\\fakepath\\" === i.substr(0, 12) ?
                            i.substr(12) :
                            (n = i.lastIndexOf("/")) >= 0 ?
                            i.substr(n + 1) :
                            (n = i.lastIndexOf("\\")) >= 0 ?
                            i.substr(n + 1) :
                            i :
                            "string" == typeof i ?
                            i.replace(/\r/g, "") :
                            i);
                },
                check: function(e) {
                    e = this.validationTargetFor(this.clean(e));
                    var i,
                        n,
                        s,
                        a,
                        r = t(e).rules(),
                        o = t.map(r, function(t, e) {
                            return e;
                        }).length,
                        l = !1,
                        c = this.elementValue(e);
                    for (n in ("function" == typeof r.normalizer ?
                            (a = r.normalizer) :
                            "function" == typeof this.settings.normalizer &&
                            (a = this.settings.normalizer),
                            a && ((c = a.call(e, c)), delete r.normalizer),
                            r)) {
                        s = {
                            method: n,
                            parameters: r[n],
                        };
                        try {
                            if (
                                "dependency-mismatch" ===
                                (i = t.validator.methods[n].call(
                                    this,
                                    c,
                                    e,
                                    s.parameters
                                )) &&
                                1 === o
                            ) {
                                l = !0;
                                continue;
                            }
                            if (((l = !1), "pending" === i))
                                return void(this.toHide = this.toHide.not(
                                    this.errorsFor(e)
                                ));
                            if (!i) return this.formatAndAdd(e, s), !1;
                        } catch (t) {
                            throw (
                                (this.settings.debug &&
                                    window.console &&
                                    console.log(
                                        "Exception occurred when checking element " +
                                        e.id +
                                        ", check the '" +
                                        s.method +
                                        "' method.",
                                        t
                                    ),
                                    t instanceof TypeError &&
                                    (t.message +=
                                        ".  Exception occurred when checking element " +
                                        e.id +
                                        ", check the '" +
                                        s.method +
                                        "' method."),
                                    t)
                            );
                        }
                    }
                    if (!l) return this.objectLength(r) && this.successList.push(e), !0;
                },
                customDataMessage: function(e, i) {
                    return (
                        t(e).data(
                            "msg" + i.charAt(0).toUpperCase() + i.substring(1).toLowerCase()
                        ) || t(e).data("msg")
                    );
                },
                customMessage: function(t, e) {
                    var i = this.settings.messages[t];
                    return i && (i.constructor === String ? i : i[e]);
                },
                findDefined: function() {
                    for (var t = 0; t < arguments.length; t++)
                        if (void 0 !== arguments[t]) return arguments[t];
                },
                defaultMessage: function(e, i) {
                    "string" == typeof i &&
                        (i = {
                            method: i,
                        });
                    var n = this.findDefined(
                            this.customMessage(e.name, i.method),
                            this.customDataMessage(e, i.method),
                            (!this.settings.ignoreTitle && e.title) || void 0,
                            t.validator.messages[i.method],
                            "<strong>Warning: No message defined for " +
                            e.name +
                            "</strong>"
                        ),
                        s = /\$?\{(\d+)\}/g;
                    return (
                        "function" == typeof n ?
                        (n = n.call(this, i.parameters, e)) :
                        s.test(n) &&
                        (n = t.validator.format(n.replace(s, "{$1}"), i.parameters)),
                        n
                    );
                },
                formatAndAdd: function(t, e) {
                    var i = this.defaultMessage(t, e);
                    this.errorList.push({
                            message: i,
                            element: t,
                            method: e.method,
                        }),
                        (this.errorMap[t.name] = i),
                        (this.submitted[t.name] = i);
                },
                addWrapper: function(t) {
                    return (
                        this.settings.wrapper &&
                        (t = t.add(t.parent(this.settings.wrapper))),
                        t
                    );
                },
                defaultShowErrors: function() {
                    var t, e, i;
                    for (t = 0; this.errorList[t]; t++)
                        (i = this.errorList[t]),
                        this.settings.highlight &&
                        this.settings.highlight.call(
                            this,
                            i.element,
                            this.settings.errorClass,
                            this.settings.validClass
                        ),
                        this.showLabel(i.element, i.message);
                    if (
                        (this.errorList.length &&
                            (this.toShow = this.toShow.add(this.containers)),
                            this.settings.success)
                    )
                        for (t = 0; this.successList[t]; t++)
                            this.showLabel(this.successList[t]);
                    if (this.settings.unhighlight)
                        for (t = 0, e = this.validElements(); e[t]; t++)
                            this.settings.unhighlight.call(
                                this,
                                e[t],
                                this.settings.errorClass,
                                this.settings.validClass
                            );
                    (this.toHide = this.toHide.not(this.toShow)),
                    this.hideErrors(),
                        this.addWrapper(this.toShow).show();
                },
                validElements: function() {
                    return this.currentElements.not(this.invalidElements());
                },
                invalidElements: function() {
                    return t(this.errorList).map(function() {
                        return this.element;
                    });
                },
                showLabel: function(e, i) {
                    var n,
                        s,
                        a,
                        r,
                        o = this.errorsFor(e),
                        l = this.idOrName(e),
                        c = t(e).attr("aria-describedby");
                    o.length ?
                        (o
                            .removeClass(this.settings.validClass)
                            .addClass(this.settings.errorClass),
                            o.html(i)) :
                        ((n = o =
                                t("<" + this.settings.errorElement + ">")
                                .attr("id", l + "-error")
                                .addClass(this.settings.errorClass)
                                .html(i || "")),
                            this.settings.wrapper &&
                            (n = o
                                .hide()
                                .show()
                                .wrap("<" + this.settings.wrapper + "/>")
                                .parent()),
                            this.labelContainer.length ?
                            this.labelContainer.append(n) :
                            this.settings.errorPlacement ?
                            this.settings.errorPlacement.call(this, n, t(e)) :
                            n.insertAfter(e),
                            o.is("label") ?
                            o.attr("for", l) :
                            0 ===
                            o.parents("label[for='" + this.escapeCssMeta(l) + "']")
                            .length &&
                            ((a = o.attr("id")),
                                c ?
                                c.match(
                                    new RegExp("\\b" + this.escapeCssMeta(a) + "\\b")
                                ) || (c += " " + a) :
                                (c = a),
                                t(e).attr("aria-describedby", c),
                                (s = this.groups[e.name]) &&
                                ((r = this),
                                    t.each(r.groups, function(e, i) {
                                        i === s &&
                                            t(
                                                "[name='" + r.escapeCssMeta(e) + "']",
                                                r.currentForm
                                            ).attr("aria-describedby", o.attr("id"));
                                    })))), !i &&
                        this.settings.success &&
                        (o.text(""),
                            "string" == typeof this.settings.success ?
                            o.addClass(this.settings.success) :
                            this.settings.success(o, e)),
                        (this.toShow = this.toShow.add(o));
                },
                errorsFor: function(e) {
                    var i = this.escapeCssMeta(this.idOrName(e)),
                        n = t(e).attr("aria-describedby"),
                        s = "label[for='" + i + "'], label[for='" + i + "'] *";
                    return (
                        n &&
                        (s = s + ", #" + this.escapeCssMeta(n).replace(/\s+/g, ", #")),
                        this.errors().filter(s)
                    );
                },
                escapeCssMeta: function(t) {
                    return t.replace(/([\\!"#$%&'()*+,.\/:;<=>?@\[\]^`{|}~])/g, "\\$1");
                },
                idOrName: function(t) {
                    return (
                        this.groups[t.name] ||
                        (this.checkable(t) ? t.name : t.id || t.name)
                    );
                },
                validationTargetFor: function(e) {
                    return (
                        this.checkable(e) && (e = this.findByName(e.name)),
                        t(e).not(this.settings.ignore)[0]
                    );
                },
                checkable: function(t) {
                    return /radio|checkbox/i.test(t.type);
                },
                findByName: function(e) {
                    return t(this.currentForm).find(
                        "[name='" + this.escapeCssMeta(e) + "']"
                    );
                },
                getLength: function(e, i) {
                    switch (i.nodeName.toLowerCase()) {
                        case "select":
                            return t("option:selected", i).length;
                        case "input":
                            if (this.checkable(i))
                                return this.findByName(i.name).filter(":checked").length;
                    }
                    return e.length;
                },
                depend: function(t, e) {
                    return (!this.dependTypes[typeof t] || this.dependTypes[typeof t](t, e));
                },
                dependTypes: {
                    boolean: function(t) {
                        return t;
                    },
                    string: function(e, i) {
                        return !!t(e, i.form).length;
                    },
                    function: function(t, e) {
                        return t(e);
                    },
                },
                optional: function(e) {
                    var i = this.elementValue(e);
                    return (!t.validator.methods.required.call(this, i, e) &&
                        "dependency-mismatch"
                    );
                },
                startRequest: function(e) {
                    this.pending[e.name] ||
                        (this.pendingRequest++,
                            t(e).addClass(this.settings.pendingClass),
                            (this.pending[e.name] = !0));
                },
                stopRequest: function(e, i) {
                    this.pendingRequest--,
                        this.pendingRequest < 0 && (this.pendingRequest = 0),
                        delete this.pending[e.name],
                        t(e).removeClass(this.settings.pendingClass),
                        i &&
                        0 === this.pendingRequest &&
                        this.formSubmitted &&
                        this.form() ?
                        (t(this.currentForm).submit(),
                            this.submitButton &&
                            t(
                                "input:hidden[name='" + this.submitButton.name + "']",
                                this.currentForm
                            ).remove(),
                            (this.formSubmitted = !1)) :
                        !i &&
                        0 === this.pendingRequest &&
                        this.formSubmitted &&
                        (t(this.currentForm).triggerHandler("invalid-form", [this]),
                            (this.formSubmitted = !1));
                },
                previousValue: function(e, i) {
                    return (
                        (i = ("string" == typeof i && i) || "remote"),
                        t.data(e, "previousValue") ||
                        t.data(e, "previousValue", {
                            old: null,
                            valid: !0,
                            message: this.defaultMessage(e, {
                                method: i,
                            }),
                        })
                    );
                },
                destroy: function() {
                    this.resetForm(),
                        t(this.currentForm)
                        .off(".validate")
                        .removeData("validator")
                        .find(".validate-equalTo-blur")
                        .off(".validate-equalTo")
                        .removeClass("validate-equalTo-blur")
                        .find(".validate-lessThan-blur")
                        .off(".validate-lessThan")
                        .removeClass("validate-lessThan-blur")
                        .find(".validate-lessThanEqual-blur")
                        .off(".validate-lessThanEqual")
                        .removeClass("validate-lessThanEqual-blur")
                        .find(".validate-greaterThanEqual-blur")
                        .off(".validate-greaterThanEqual")
                        .removeClass("validate-greaterThanEqual-blur")
                        .find(".validate-greaterThan-blur")
                        .off(".validate-greaterThan")
                        .removeClass("validate-greaterThan-blur");
                },
            },
            classRuleSettings: {
                required: {
                    required: !0,
                },
                email: {
                    email: !0,
                },
                url: {
                    url: !0,
                },
                date: {
                    date: !0,
                },
                dateISO: {
                    dateISO: !0,
                },
                number: {
                    number: !0,
                },
                digits: {
                    digits: !0,
                },
                creditcard: {
                    creditcard: !0,
                },
            },
            addClassRules: function(e, i) {
                e.constructor === String ?
                    (this.classRuleSettings[e] = i) :
                    t.extend(this.classRuleSettings, e);
            },
            classRules: function(e) {
                var i = {},
                    n = t(e).attr("class");
                return (
                    n &&
                    t.each(n.split(" "), function() {
                        this in t.validator.classRuleSettings &&
                            t.extend(i, t.validator.classRuleSettings[this]);
                    }),
                    i
                );
            },
            normalizeAttributeRule: function(t, e, i, n) {
                /min|max|step/.test(i) &&
                    (null === e || /number|range|text/.test(e)) &&
                    ((n = Number(n)), isNaN(n) && (n = void 0)),
                    n || 0 === n ? (t[i] = n) : e === i && "range" !== e && (t[i] = !0);
            },
            attributeRules: function(e) {
                var i,
                    n,
                    s = {},
                    a = t(e),
                    r = e.getAttribute("type");
                for (i in t.validator.methods)
                    "required" === i ?
                    ("" === (n = e.getAttribute(i)) && (n = !0), (n = !!n)) :
                    (n = a.attr(i)),
                    this.normalizeAttributeRule(s, r, i, n);
                return (
                    s.maxlength &&
                    /-1|2147483647|524288/.test(s.maxlength) &&
                    delete s.maxlength,
                    s
                );
            },
            dataRules: function(e) {
                var i,
                    n,
                    s = {},
                    a = t(e),
                    r = e.getAttribute("type");
                for (i in t.validator.methods)
                    "" ===
                    (n = a.data(
                        "rule" +
                        i.charAt(0).toUpperCase() +
                        i.substring(1).toLowerCase()
                    )) && (n = !0),
                    this.normalizeAttributeRule(s, r, i, n);
                return s;
            },
            staticRules: function(e) {
                var i = {},
                    n = t.data(e.form, "validator");
                return (
                    n.settings.rules &&
                    (i = t.validator.normalizeRule(n.settings.rules[e.name]) || {}),
                    i
                );
            },
            normalizeRules: function(e, i) {
                return (
                    t.each(e, function(n, s) {
                        if (!1 !== s) {
                            if (s.param || s.depends) {
                                var a = !0;
                                switch (typeof s.depends) {
                                    case "string":
                                        a = !!t(s.depends, i.form).length;
                                        break;
                                    case "function":
                                        a = s.depends.call(i, i);
                                }
                                a
                                    ?
                                    (e[n] = void 0 === s.param || s.param) :
                                    (t.data(i.form, "validator").resetElements(t(i)),
                                        delete e[n]);
                            }
                        } else delete e[n];
                    }),
                    t.each(e, function(n, s) {
                        e[n] = t.isFunction(s) && "normalizer" !== n ? s(i) : s;
                    }),
                    t.each(["minlength", "maxlength"], function() {
                        e[this] && (e[this] = Number(e[this]));
                    }),
                    t.each(["rangelength", "range"], function() {
                        var i;
                        e[this] &&
                            (t.isArray(e[this]) ?
                                (e[this] = [Number(e[this][0]), Number(e[this][1])]) :
                                "string" == typeof e[this] &&
                                ((i = e[this].replace(/[\[\]]/g, "").split(/[\s,]+/)),
                                    (e[this] = [Number(i[0]), Number(i[1])])));
                    }),
                    t.validator.autoCreateRanges &&
                    (null != e.min &&
                        null != e.max &&
                        ((e.range = [e.min, e.max]), delete e.min, delete e.max),
                        null != e.minlength &&
                        null != e.maxlength &&
                        ((e.rangelength = [e.minlength, e.maxlength]),
                            delete e.minlength,
                            delete e.maxlength)),
                    e
                );
            },
            normalizeRule: function(e) {
                if ("string" == typeof e) {
                    var i = {};
                    t.each(e.split(/\s/), function() {
                            i[this] = !0;
                        }),
                        (e = i);
                }
                return e;
            },
            addMethod: function(e, i, n) {
                (t.validator.methods[e] = i),
                (t.validator.messages[e] =
                    void 0 !== n ? n : t.validator.messages[e]),
                i.length < 3 &&
                    t.validator.addClassRules(e, t.validator.normalizeRule(e));
            },
            methods: {
                required: function(e, i, n) {
                    if (!this.depend(n, i)) return "dependency-mismatch";
                    if ("select" === i.nodeName.toLowerCase()) {
                        var s = t(i).val();
                        return s && s.length > 0;
                    }
                    return this.checkable(i) ?
                        this.getLength(e, i) > 0 :
                        null != e && e.length > 0;
                },
                email: function(t, e) {
                    return (
                        this.optional(e) ||
                        /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(
                            t
                        )
                    );
                },
                url: function(t, e) {
                    return (
                        this.optional(e) ||
                        /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[\/?#]\S*)?$/i.test(
                            t
                        )
                    );
                },
                date: (function() {
                    var t = !1;
                    return function(e, i) {
                        return (
                            t ||
                            ((t = !0),
                                this.settings.debug &&
                                window.console &&
                                console.warn(
                                    "The `date` method is deprecated and will be removed in version '2.0.0'.\nPlease don't use it, since it relies on the Date constructor, which\nbehaves very differently across browsers and locales. Use `dateISO`\ninstead or one of the locale specific methods in `localizations/`\nand `additional-methods.js`."
                                )),
                            this.optional(i) || !/Invalid|NaN/.test(new Date(e).toString())
                        );
                    };
                })(),
                dateISO: function(t, e) {
                    return (
                        this.optional(e) ||
                        /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(
                            t
                        )
                    );
                },
                number: function(t, e) {
                    return (
                        this.optional(e) ||
                        /^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(t)
                    );
                },
                digits: function(t, e) {
                    return this.optional(e) || /^\d+$/.test(t);
                },
                minlength: function(e, i, n) {
                    var s = t.isArray(e) ? e.length : this.getLength(e, i);
                    return this.optional(i) || s >= n;
                },
                maxlength: function(e, i, n) {
                    var s = t.isArray(e) ? e.length : this.getLength(e, i);
                    return this.optional(i) || s <= n;
                },
                rangelength: function(e, i, n) {
                    var s = t.isArray(e) ? e.length : this.getLength(e, i);
                    return this.optional(i) || (s >= n[0] && s <= n[1]);
                },
                min: function(t, e, i) {
                    return this.optional(e) || t >= i;
                },
                max: function(t, e, i) {
                    return this.optional(e) || t <= i;
                },
                range: function(t, e, i) {
                    return this.optional(e) || (t >= i[0] && t <= i[1]);
                },
                step: function(e, i, n) {
                    var s,
                        a = t(i).attr("type"),
                        r = "Step attribute on input type " + a + " is not supported.",
                        o = new RegExp("\\b" + a + "\\b"),
                        l = function(t) {
                            var e = ("" + t).match(/(?:\.(\d+))?$/);
                            return e && e[1] ? e[1].length : 0;
                        },
                        c = function(t) {
                            return Math.round(t * Math.pow(10, s));
                        },
                        d = !0;
                    if (a && !o.test(["text", "number", "range"].join()))
                        throw new Error(r);
                    return (
                        (s = l(n)),
                        (l(e) > s || c(e) % c(n) != 0) && (d = !1),
                        this.optional(i) || d
                    );
                },
                equalTo: function(e, i, n) {
                    var s = t(n);
                    return (
                        this.settings.onfocusout &&
                        s.not(".validate-equalTo-blur").length &&
                        s
                        .addClass("validate-equalTo-blur")
                        .on("blur.validate-equalTo", function() {
                            t(i).valid();
                        }),
                        e === s.val()
                    );
                },
                remote: function(e, i, n, s) {
                    if (this.optional(i)) return "dependency-mismatch";
                    s = ("string" == typeof s && s) || "remote";
                    var a,
                        r,
                        o,
                        l = this.previousValue(i, s);
                    return (
                        this.settings.messages[i.name] ||
                        (this.settings.messages[i.name] = {}),
                        (l.originalMessage =
                            l.originalMessage || this.settings.messages[i.name][s]),
                        (this.settings.messages[i.name][s] = l.message),
                        (n =
                            ("string" == typeof n && {
                                url: n,
                            }) ||
                            n),
                        (o = t.param(
                            t.extend({
                                    data: e,
                                },
                                n.data
                            )
                        )),
                        l.old === o ?
                        l.valid :
                        ((l.old = o),
                            (a = this),
                            this.startRequest(i),
                            ((r = {})[i.name] = e),
                            t.ajax(
                                t.extend(!0, {
                                        mode: "abort",
                                        port: "validate" + i.name,
                                        dataType: "json",
                                        data: r,
                                        context: a.currentForm,
                                        success: function(t) {
                                            var n,
                                                r,
                                                o,
                                                c = !0 === t || "true" === t;
                                            (a.settings.messages[i.name][s] = l.originalMessage),
                                            c
                                                ?
                                                ((o = a.formSubmitted),
                                                    a.resetInternals(),
                                                    (a.toHide = a.errorsFor(i)),
                                                    (a.formSubmitted = o),
                                                    a.successList.push(i),
                                                    (a.invalid[i.name] = !1),
                                                    a.showErrors()) :
                                                ((n = {}),
                                                    (r =
                                                        t ||
                                                        a.defaultMessage(i, {
                                                            method: s,
                                                            parameters: e,
                                                        })),
                                                    (n[i.name] = l.message = r),
                                                    (a.invalid[i.name] = !0),
                                                    a.showErrors(n)),
                                                (l.valid = c),
                                                a.stopRequest(i, c);
                                        },
                                    },
                                    n
                                )
                            ),
                            "pending")
                    );
                },
            },
        });
    var i,
        n = {};
    return (
        t.ajaxPrefilter ?
        t.ajaxPrefilter(function(t, e, i) {
            var s = t.port;
            "abort" === t.mode && (n[s] && n[s].abort(), (n[s] = i));
        }) :
        ((i = t.ajax),
            (t.ajax = function(e) {
                var s = ("mode" in e ? e : t.ajaxSettings).mode,
                    a = ("port" in e ? e : t.ajaxSettings).port;
                return "abort" === s ?
                    (n[a] && n[a].abort(), (n[a] = i.apply(this, arguments)), n[a]) :
                    i.apply(this, arguments);
            })),
        t
    );
}),
(function(t, e) {
    "object" == typeof exports && "undefined" != typeof module ?
        (module.exports = e()) :
        "function" == typeof define && define.amd ?
        define(e) :
        ((t = t || self).Swiper = e());
})(this, function() {
    "use strict";

    function t(t) {
        return (
            null !== t &&
            "object" == typeof t &&
            "constructor" in t &&
            t.constructor === Object
        );
    }

    function e(i, n) {
        void 0 === i && (i = {}),
            void 0 === n && (n = {}),
            Object.keys(n).forEach(function(s) {
                void 0 === i[s] ?
                    (i[s] = n[s]) :
                    t(n[s]) &&
                    t(i[s]) &&
                    Object.keys(n[s]).length > 0 &&
                    e(i[s], n[s]);
            });
    }
    var i = "undefined" != typeof document ? document : {},
        n = {
            body: {},
            addEventListener: function() {},
            removeEventListener: function() {},
            activeElement: {
                blur: function() {},
                nodeName: "",
            },
            querySelector: function() {
                return null;
            },
            querySelectorAll: function() {
                return [];
            },
            getElementById: function() {
                return null;
            },
            createEvent: function() {
                return {
                    initEvent: function() {},
                };
            },
            createElement: function() {
                return {
                    children: [],
                    childNodes: [],
                    style: {},
                    setAttribute: function() {},
                    getElementsByTagName: function() {
                        return [];
                    },
                };
            },
            createElementNS: function() {
                return {};
            },
            importNode: function() {
                return null;
            },
            location: {
                hash: "",
                host: "",
                hostname: "",
                href: "",
                origin: "",
                pathname: "",
                protocol: "",
                search: "",
            },
        };
    e(i, n);
    var s = "undefined" != typeof window ? window : {};
    e(s, {
        document: n,
        navigator: {
            userAgent: "",
        },
        location: {
            hash: "",
            host: "",
            hostname: "",
            href: "",
            origin: "",
            pathname: "",
            protocol: "",
            search: "",
        },
        history: {
            replaceState: function() {},
            pushState: function() {},
            go: function() {},
            back: function() {},
        },
        CustomEvent: function() {
            return this;
        },
        addEventListener: function() {},
        removeEventListener: function() {},
        getComputedStyle: function() {
            return {
                getPropertyValue: function() {
                    return "";
                },
            };
        },
        Image: function() {},
        Date: function() {},
        screen: {},
        setTimeout: function() {},
        clearTimeout: function() {},
        matchMedia: function() {
            return {};
        },
    });
    var a = function(t) {
        for (var e = 0; e < t.length; e += 1) this[e] = t[e];
        return (this.length = t.length), this;
    };

    function r(t, e) {
        var n = [],
            r = 0;
        if (t && !e && t instanceof a) return t;
        if (t)
            if ("string" == typeof t) {
                var o,
                    l,
                    c = t.trim();
                if (c.indexOf("<") >= 0 && c.indexOf(">") >= 0) {
                    var d = "div";
                    for (
                        0 === c.indexOf("<li") && (d = "ul"),
                        0 === c.indexOf("<tr") && (d = "tbody"),
                        (0 !== c.indexOf("<td") && 0 !== c.indexOf("<th")) ||
                        (d = "tr"),
                        0 === c.indexOf("<tbody") && (d = "table"),
                        0 === c.indexOf("<option") && (d = "select"),
                        (l = i.createElement(d)).innerHTML = c,
                        r = 0; r < l.childNodes.length; r += 1
                    )
                        n.push(l.childNodes[r]);
                } else
                    for (
                        o =
                        e || "#" !== t[0] || t.match(/[ .<>:~]/) ?
                        (e || i).querySelectorAll(t.trim()) : [i.getElementById(t.trim().split("#")[1])],
                        r = 0; r < o.length; r += 1
                    )
                        o[r] && n.push(o[r]);
            } else if (t.nodeType || t === s || t === i) n.push(t);
        else if (t.length > 0 && t[0].nodeType)
            for (r = 0; r < t.length; r += 1) n.push(t[r]);
        return new a(n);
    }

    function o(t) {
        for (var e = [], i = 0; i < t.length; i += 1)
            -
            1 === e.indexOf(t[i]) && e.push(t[i]);
        return e;
    }
    (r.fn = a.prototype), (r.Class = a), (r.Dom7 = a);
    var l = {
        addClass: function(t) {
            if (void 0 === t) return this;
            for (var e = t.split(" "), i = 0; i < e.length; i += 1)
                for (var n = 0; n < this.length; n += 1)
                    void 0 !== this[n] &&
                    void 0 !== this[n].classList &&
                    this[n].classList.add(e[i]);
            return this;
        },
        removeClass: function(t) {
            for (var e = t.split(" "), i = 0; i < e.length; i += 1)
                for (var n = 0; n < this.length; n += 1)
                    void 0 !== this[n] &&
                    void 0 !== this[n].classList &&
                    this[n].classList.remove(e[i]);
            return this;
        },
        hasClass: function(t) {
            return !!this[0] && this[0].classList.contains(t);
        },
        toggleClass: function(t) {
            for (var e = t.split(" "), i = 0; i < e.length; i += 1)
                for (var n = 0; n < this.length; n += 1)
                    void 0 !== this[n] &&
                    void 0 !== this[n].classList &&
                    this[n].classList.toggle(e[i]);
            return this;
        },
        attr: function(t, e) {
            var i = arguments;
            if (1 === arguments.length && "string" == typeof t)
                return this[0] ? this[0].getAttribute(t) : void 0;
            for (var n = 0; n < this.length; n += 1)
                if (2 === i.length) this[n].setAttribute(t, e);
                else
                    for (var s in t)(this[n][s] = t[s]), this[n].setAttribute(s, t[s]);
            return this;
        },
        removeAttr: function(t) {
            for (var e = 0; e < this.length; e += 1) this[e].removeAttribute(t);
            return this;
        },
        data: function(t, e) {
            var i;
            if (void 0 !== e) {
                for (var n = 0; n < this.length; n += 1)
                    (i = this[n]).dom7ElementDataStorage ||
                    (i.dom7ElementDataStorage = {}),
                    (i.dom7ElementDataStorage[t] = e);
                return this;
            }
            if ((i = this[0]))
                return i.dom7ElementDataStorage && t in i.dom7ElementDataStorage ?
                    i.dom7ElementDataStorage[t] :
                    i.getAttribute("data-" + t) || void 0;
        },
        transform: function(t) {
            for (var e = 0; e < this.length; e += 1) {
                var i = this[e].style;
                (i.webkitTransform = t), (i.transform = t);
            }
            return this;
        },
        transition: function(t) {
            "string" != typeof t && (t += "ms");
            for (var e = 0; e < this.length; e += 1) {
                var i = this[e].style;
                (i.webkitTransitionDuration = t), (i.transitionDuration = t);
            }
            return this;
        },
        on: function() {
            for (var t, e = [], i = arguments.length; i--;) e[i] = arguments[i];
            var n = e[0],
                s = e[1],
                a = e[2],
                o = e[3];

            function l(t) {
                var e = t.target;
                if (e) {
                    var i = t.target.dom7EventData || [];
                    if ((i.indexOf(t) < 0 && i.unshift(t), r(e).is(s))) a.apply(e, i);
                    else
                        for (var n = r(e).parents(), o = 0; o < n.length; o += 1)
                            r(n[o]).is(s) && a.apply(n[o], i);
                }
            }

            function c(t) {
                var e = (t && t.target && t.target.dom7EventData) || [];
                e.indexOf(t) < 0 && e.unshift(t), a.apply(this, e);
            }
            "function" == typeof e[1] &&
                ((n = (t = e)[0]), (a = t[1]), (o = t[2]), (s = void 0)),
                o || (o = !1);
            for (var d, u = n.split(" "), h = 0; h < this.length; h += 1) {
                var p = this[h];
                if (s)
                    for (d = 0; d < u.length; d += 1) {
                        var f = u[d];
                        p.dom7LiveListeners || (p.dom7LiveListeners = {}),
                            p.dom7LiveListeners[f] || (p.dom7LiveListeners[f] = []),
                            p.dom7LiveListeners[f].push({
                                listener: a,
                                proxyListener: l,
                            }),
                            p.addEventListener(f, l, o);
                    }
                else
                    for (d = 0; d < u.length; d += 1) {
                        var m = u[d];
                        p.dom7Listeners || (p.dom7Listeners = {}),
                            p.dom7Listeners[m] || (p.dom7Listeners[m] = []),
                            p.dom7Listeners[m].push({
                                listener: a,
                                proxyListener: c,
                            }),
                            p.addEventListener(m, c, o);
                    }
            }
            return this;
        },
        off: function() {
            for (var t, e = [], i = arguments.length; i--;) e[i] = arguments[i];
            var n = e[0],
                s = e[1],
                a = e[2],
                r = e[3];
            "function" == typeof e[1] &&
                ((n = (t = e)[0]), (a = t[1]), (r = t[2]), (s = void 0)),
                r || (r = !1);
            for (var o = n.split(" "), l = 0; l < o.length; l += 1)
                for (var c = o[l], d = 0; d < this.length; d += 1) {
                    var u = this[d],
                        h = void 0;
                    if (
                        (!s && u.dom7Listeners ?
                            (h = u.dom7Listeners[c]) :
                            s && u.dom7LiveListeners && (h = u.dom7LiveListeners[c]),
                            h && h.length)
                    )
                        for (var p = h.length - 1; p >= 0; p -= 1) {
                            var f = h[p];
                            (a && f.listener === a) ||
                            (a &&
                                f.listener &&
                                f.listener.dom7proxy &&
                                f.listener.dom7proxy === a) ?
                            (u.removeEventListener(c, f.proxyListener, r),
                                h.splice(p, 1)) :
                            a ||
                                (u.removeEventListener(c, f.proxyListener, r),
                                    h.splice(p, 1));
                        }
                }
            return this;
        },
        trigger: function() {
            for (var t = [], e = arguments.length; e--;) t[e] = arguments[e];
            for (var n = t[0].split(" "), a = t[1], r = 0; r < n.length; r += 1)
                for (var o = n[r], l = 0; l < this.length; l += 1) {
                    var c = this[l],
                        d = void 0;
                    try {
                        d = new s.CustomEvent(o, {
                            detail: a,
                            bubbles: !0,
                            cancelable: !0,
                        });
                    } catch (t) {
                        (d = i.createEvent("Event")).initEvent(o, !0, !0), (d.detail = a);
                    }
                    (c.dom7EventData = t.filter(function(t, e) {
                        return e > 0;
                    })),
                    c.dispatchEvent(d),
                        (c.dom7EventData = []),
                        delete c.dom7EventData;
                }
            return this;
        },
        transitionEnd: function(t) {
            var e,
                i = ["webkitTransitionEnd", "transitionend"],
                n = this;

            function s(a) {
                if (a.target === this)
                    for (t.call(this, a), e = 0; e < i.length; e += 1) n.off(i[e], s);
            }
            if (t)
                for (e = 0; e < i.length; e += 1) n.on(i[e], s);
            return this;
        },
        outerWidth: function(t) {
            if (this.length > 0) {
                if (t) {
                    var e = this.styles();
                    return (
                        this[0].offsetWidth +
                        parseFloat(e.getPropertyValue("margin-right")) +
                        parseFloat(e.getPropertyValue("margin-left"))
                    );
                }
                return this[0].offsetWidth;
            }
            return null;
        },
        outerHeight: function(t) {
            if (this.length > 0) {
                if (t) {
                    var e = this.styles();
                    return (
                        this[0].offsetHeight +
                        parseFloat(e.getPropertyValue("margin-top")) +
                        parseFloat(e.getPropertyValue("margin-bottom"))
                    );
                }
                return this[0].offsetHeight;
            }
            return null;
        },
        offset: function() {
            if (this.length > 0) {
                var t = this[0],
                    e = t.getBoundingClientRect(),
                    n = i.body,
                    a = t.clientTop || n.clientTop || 0,
                    r = t.clientLeft || n.clientLeft || 0,
                    o = t === s ? s.scrollY : t.scrollTop,
                    l = t === s ? s.scrollX : t.scrollLeft;
                return {
                    top: e.top + o - a,
                    left: e.left + l - r,
                };
            }
            return null;
        },
        css: function(t, e) {
            var i;
            if (1 === arguments.length) {
                if ("string" != typeof t) {
                    for (i = 0; i < this.length; i += 1)
                        for (var n in t) this[i].style[n] = t[n];
                    return this;
                }
                if (this[0])
                    return s.getComputedStyle(this[0], null).getPropertyValue(t);
            }
            if (2 === arguments.length && "string" == typeof t) {
                for (i = 0; i < this.length; i += 1) this[i].style[t] = e;
                return this;
            }
            return this;
        },
        each: function(t) {
            if (!t) return this;
            for (var e = 0; e < this.length; e += 1)
                if (!1 === t.call(this[e], e, this[e])) return this;
            return this;
        },
        html: function(t) {
            if (void 0 === t) return this[0] ? this[0].innerHTML : void 0;
            for (var e = 0; e < this.length; e += 1) this[e].innerHTML = t;
            return this;
        },
        text: function(t) {
            if (void 0 === t) return this[0] ? this[0].textContent.trim() : null;
            for (var e = 0; e < this.length; e += 1) this[e].textContent = t;
            return this;
        },
        is: function(t) {
            var e,
                n,
                o = this[0];
            if (!o || void 0 === t) return !1;
            if ("string" == typeof t) {
                if (o.matches) return o.matches(t);
                if (o.webkitMatchesSelector) return o.webkitMatchesSelector(t);
                if (o.msMatchesSelector) return o.msMatchesSelector(t);
                for (e = r(t), n = 0; n < e.length; n += 1)
                    if (e[n] === o) return !0;
                return !1;
            }
            if (t === i) return o === i;
            if (t === s) return o === s;
            if (t.nodeType || t instanceof a) {
                for (e = t.nodeType ? [t] : t, n = 0; n < e.length; n += 1)
                    if (e[n] === o) return !0;
                return !1;
            }
            return !1;
        },
        index: function() {
            var t,
                e = this[0];
            if (e) {
                for (t = 0; null !== (e = e.previousSibling);)
                    1 === e.nodeType && (t += 1);
                return t;
            }
        },
        eq: function(t) {
            if (void 0 === t) return this;
            var e,
                i = this.length;
            return new a(
                t > i - 1 ? [] :
                t < 0 ?
                (e = i + t) < 0 ? [] : [this[e]] : [this[t]]
            );
        },
        append: function() {
            for (var t, e = [], n = arguments.length; n--;) e[n] = arguments[n];
            for (var s = 0; s < e.length; s += 1) {
                t = e[s];
                for (var r = 0; r < this.length; r += 1)
                    if ("string" == typeof t) {
                        var o = i.createElement("div");
                        for (o.innerHTML = t; o.firstChild;)
                            this[r].appendChild(o.firstChild);
                    } else if (t instanceof a)
                    for (var l = 0; l < t.length; l += 1) this[r].appendChild(t[l]);
                else this[r].appendChild(t);
            }
            return this;
        },
        prepend: function(t) {
            var e, n;
            for (e = 0; e < this.length; e += 1)
                if ("string" == typeof t) {
                    var s = i.createElement("div");
                    for (s.innerHTML = t, n = s.childNodes.length - 1; n >= 0; n -= 1)
                        this[e].insertBefore(s.childNodes[n], this[e].childNodes[0]);
                } else if (t instanceof a)
                for (n = 0; n < t.length; n += 1)
                    this[e].insertBefore(t[n], this[e].childNodes[0]);
            else this[e].insertBefore(t, this[e].childNodes[0]);
            return this;
        },
        next: function(t) {
            return this.length > 0 ?
                t ?
                this[0].nextElementSibling && r(this[0].nextElementSibling).is(t) ?
                new a([this[0].nextElementSibling]) :
                new a([]) :
                this[0].nextElementSibling ?
                new a([this[0].nextElementSibling]) :
                new a([]) :
                new a([]);
        },
        nextAll: function(t) {
            var e = [],
                i = this[0];
            if (!i) return new a([]);
            for (; i.nextElementSibling;) {
                var n = i.nextElementSibling;
                t ? r(n).is(t) && e.push(n) : e.push(n), (i = n);
            }
            return new a(e);
        },
        prev: function(t) {
            if (this.length > 0) {
                var e = this[0];
                return t ?
                    e.previousElementSibling && r(e.previousElementSibling).is(t) ?
                    new a([e.previousElementSibling]) :
                    new a([]) :
                    e.previousElementSibling ?
                    new a([e.previousElementSibling]) :
                    new a([]);
            }
            return new a([]);
        },
        prevAll: function(t) {
            var e = [],
                i = this[0];
            if (!i) return new a([]);
            for (; i.previousElementSibling;) {
                var n = i.previousElementSibling;
                t ? r(n).is(t) && e.push(n) : e.push(n), (i = n);
            }
            return new a(e);
        },
        parent: function(t) {
            for (var e = [], i = 0; i < this.length; i += 1)
                null !== this[i].parentNode &&
                (t ?
                    r(this[i].parentNode).is(t) && e.push(this[i].parentNode) :
                    e.push(this[i].parentNode));
            return r(o(e));
        },
        parents: function(t) {
            for (var e = [], i = 0; i < this.length; i += 1)
                for (var n = this[i].parentNode; n;)
                    t ? r(n).is(t) && e.push(n) : e.push(n), (n = n.parentNode);
            return r(o(e));
        },
        closest: function(t) {
            var e = this;
            return void 0 === t ?
                new a([]) :
                (e.is(t) || (e = e.parents(t).eq(0)), e);
        },
        find: function(t) {
            for (var e = [], i = 0; i < this.length; i += 1)
                for (var n = this[i].querySelectorAll(t), s = 0; s < n.length; s += 1)
                    e.push(n[s]);
            return new a(e);
        },
        children: function(t) {
            for (var e = [], i = 0; i < this.length; i += 1)
                for (var n = this[i].childNodes, s = 0; s < n.length; s += 1)
                    t ?
                    1 === n[s].nodeType && r(n[s]).is(t) && e.push(n[s]) :
                    1 === n[s].nodeType && e.push(n[s]);
            return new a(o(e));
        },
        filter: function(t) {
            for (var e = [], i = 0; i < this.length; i += 1)
                t.call(this[i], i, this[i]) && e.push(this[i]);
            return new a(e);
        },
        remove: function() {
            for (var t = 0; t < this.length; t += 1)
                this[t].parentNode && this[t].parentNode.removeChild(this[t]);
            return this;
        },
        add: function() {
            for (var t = [], e = arguments.length; e--;) t[e] = arguments[e];
            var i,
                n,
                s = this;
            for (i = 0; i < t.length; i += 1) {
                var a = r(t[i]);
                for (n = 0; n < a.length; n += 1)
                    (s[s.length] = a[n]), (s.length += 1);
            }
            return s;
        },
        styles: function() {
            return this[0] ? s.getComputedStyle(this[0], null) : {};
        },
    };
    Object.keys(l).forEach(function(t) {
        r.fn[t] = r.fn[t] || l[t];
    });
    var c = {
            deleteProps: function(t) {
                var e = t;
                Object.keys(e).forEach(function(t) {
                    try {
                        e[t] = null;
                    } catch (t) {}
                    try {
                        delete e[t];
                    } catch (t) {}
                });
            },
            nextTick: function(t, e) {
                return void 0 === e && (e = 0), setTimeout(t, e);
            },
            now: function() {
                return Date.now();
            },
            getTranslate: function(t, e) {
                var i, n, a;
                void 0 === e && (e = "x");
                var r = s.getComputedStyle(t, null);
                return (
                    s.WebKitCSSMatrix ?
                    ((n = r.transform || r.webkitTransform).split(",").length > 6 &&
                        (n = n
                            .split(", ")
                            .map(function(t) {
                                return t.replace(",", ".");
                            })
                            .join(", ")),
                        (a = new s.WebKitCSSMatrix("none" === n ? "" : n))) :
                    (i = (a =
                            r.MozTransform ||
                            r.OTransform ||
                            r.MsTransform ||
                            r.msTransform ||
                            r.transform ||
                            r
                            .getPropertyValue("transform")
                            .replace("translate(", "matrix(1, 0, 0, 1,"))
                        .toString()
                        .split(",")),
                    "x" === e &&
                    (n = s.WebKitCSSMatrix ?
                        a.m41 :
                        16 === i.length ?
                        parseFloat(i[12]) :
                        parseFloat(i[4])),
                    "y" === e &&
                    (n = s.WebKitCSSMatrix ?
                        a.m42 :
                        16 === i.length ?
                        parseFloat(i[13]) :
                        parseFloat(i[5])),
                    n || 0
                );
            },
            parseUrlQuery: function(t) {
                var e,
                    i,
                    n,
                    a,
                    r = {},
                    o = t || s.location.href;
                if ("string" == typeof o && o.length)
                    for (
                        a = (i = (o = o.indexOf("?") > -1 ? o.replace(/\S*\?/, "") : "")
                            .split("&")
                            .filter(function(t) {
                                return "" !== t;
                            })).length,
                        e = 0; e < a; e += 1
                    )
                        (n = i[e].replace(/#\S+/g, "").split("=")),
                        (r[decodeURIComponent(n[0])] =
                            void 0 === n[1] ? void 0 : decodeURIComponent(n[1]) || "");
                return r;
            },
            isObject: function(t) {
                return (
                    "object" == typeof t &&
                    null !== t &&
                    t.constructor &&
                    t.constructor === Object
                );
            },
            extend: function() {
                for (var t = [], e = arguments.length; e--;) t[e] = arguments[e];
                for (var i = Object(t[0]), n = 1; n < t.length; n += 1) {
                    var s = t[n];
                    if (null != s)
                        for (
                            var a = Object.keys(Object(s)), r = 0, o = a.length; r < o; r += 1
                        ) {
                            var l = a[r],
                                d = Object.getOwnPropertyDescriptor(s, l);
                            void 0 !== d &&
                                d.enumerable &&
                                (c.isObject(i[l]) && c.isObject(s[l]) ?
                                    c.extend(i[l], s[l]) :
                                    !c.isObject(i[l]) && c.isObject(s[l]) ?
                                    ((i[l] = {}), c.extend(i[l], s[l])) :
                                    (i[l] = s[l]));
                        }
                }
                return i;
            },
        },
        d = {
            touch: !!(
                "ontouchstart" in s ||
                (s.DocumentTouch && i instanceof s.DocumentTouch)
            ),
            pointerEvents:
                !!s.PointerEvent &&
                "maxTouchPoints" in s.navigator &&
                s.navigator.maxTouchPoints >= 0,
            observer: "MutationObserver" in s || "WebkitMutationObserver" in s,
            passiveListener: (function() {
                var t = !1;
                try {
                    var e = Object.defineProperty({}, "passive", {
                        get: function() {
                            t = !0;
                        },
                    });
                    s.addEventListener("testPassiveListener", null, e);
                } catch (t) {}
                return t;
            })(),
            gestures: "ongesturestart" in s,
        },
        u = function(t) {
            void 0 === t && (t = {});
            var e = this;
            (e.params = t),
            (e.eventsListeners = {}),
            e.params &&
                e.params.on &&
                Object.keys(e.params.on).forEach(function(t) {
                    e.on(t, e.params.on[t]);
                });
        },
        h = {
            components: {
                configurable: !0,
            },
        };
    (u.prototype.on = function(t, e, i) {
        var n = this;
        if ("function" != typeof e) return n;
        var s = i ? "unshift" : "push";
        return (
            t.split(" ").forEach(function(t) {
                n.eventsListeners[t] || (n.eventsListeners[t] = []),
                    n.eventsListeners[t][s](e);
            }),
            n
        );
    }),
    (u.prototype.once = function(t, e, i) {
        var n = this;
        if ("function" != typeof e) return n;

        function s() {
            for (var i = [], a = arguments.length; a--;) i[a] = arguments[a];
            n.off(t, s), s.f7proxy && delete s.f7proxy, e.apply(n, i);
        }
        return (s.f7proxy = e), n.on(t, s, i);
    }),
    (u.prototype.off = function(t, e) {
        var i = this;
        return i.eventsListeners ?
            (t.split(" ").forEach(function(t) {
                    void 0 === e ?
                        (i.eventsListeners[t] = []) :
                        i.eventsListeners[t] &&
                        i.eventsListeners[t].length &&
                        i.eventsListeners[t].forEach(function(n, s) {
                            (n === e || (n.f7proxy && n.f7proxy === e)) &&
                            i.eventsListeners[t].splice(s, 1);
                        });
                }),
                i) :
            i;
    }),
    (u.prototype.emit = function() {
        for (var t = [], e = arguments.length; e--;) t[e] = arguments[e];
        var i,
            n,
            s,
            a = this;
        if (!a.eventsListeners) return a;
        "string" == typeof t[0] || Array.isArray(t[0]) ?
            ((i = t[0]), (n = t.slice(1, t.length)), (s = a)) :
            ((i = t[0].events), (n = t[0].data), (s = t[0].context || a));
        var r = Array.isArray(i) ? i : i.split(" ");
        return (
            r.forEach(function(t) {
                if (a.eventsListeners && a.eventsListeners[t]) {
                    var e = [];
                    a.eventsListeners[t].forEach(function(t) {
                            e.push(t);
                        }),
                        e.forEach(function(t) {
                            t.apply(s, n);
                        });
                }
            }),
            a
        );
    }),
    (u.prototype.useModulesParams = function(t) {
        var e = this;
        e.modules &&
            Object.keys(e.modules).forEach(function(i) {
                var n = e.modules[i];
                n.params && c.extend(t, n.params);
            });
    }),
    (u.prototype.useModules = function(t) {
        void 0 === t && (t = {});
        var e = this;
        e.modules &&
            Object.keys(e.modules).forEach(function(i) {
                var n = e.modules[i],
                    s = t[i] || {};
                n.instance &&
                    Object.keys(n.instance).forEach(function(t) {
                        var i = n.instance[t];
                        e[t] = "function" == typeof i ? i.bind(e) : i;
                    }),
                    n.on &&
                    e.on &&
                    Object.keys(n.on).forEach(function(t) {
                        e.on(t, n.on[t]);
                    }),
                    n.create && n.create.bind(e)(s);
            });
    }),
    (h.components.set = function(t) {
        this.use && this.use(t);
    }),
    (u.installModule = function(t) {
        for (var e = [], i = arguments.length - 1; i-- > 0;)
            e[i] = arguments[i + 1];
        var n = this;
        n.prototype.modules || (n.prototype.modules = {});
        var s =
            t.name || Object.keys(n.prototype.modules).length + "_" + c.now();
        return (
            (n.prototype.modules[s] = t),
            t.proto &&
            Object.keys(t.proto).forEach(function(e) {
                n.prototype[e] = t.proto[e];
            }),
            t.static &&
            Object.keys(t.static).forEach(function(e) {
                n[e] = t.static[e];
            }),
            t.install && t.install.apply(n, e),
            n
        );
    }),
    (u.use = function(t) {
        for (var e = [], i = arguments.length - 1; i-- > 0;)
            e[i] = arguments[i + 1];
        var n = this;
        return Array.isArray(t) ?
            (t.forEach(function(t) {
                    return n.installModule(t);
                }),
                n) :
            n.installModule.apply(n, [t].concat(e));
    }),
    Object.defineProperties(u, h);
    var p,
        f,
        m,
        v,
        g,
        y,
        b,
        w,
        x,
        T,
        S,
        C,
        E,
        k,
        M,
        _ = {
            updateSize: function() {
                var t,
                    e,
                    i = this.$el;
                (t =
                    void 0 !== this.params.width ?
                    this.params.width :
                    i[0].clientWidth),
                (e =
                    void 0 !== this.params.height ?
                    this.params.height :
                    i[0].clientHeight),
                (0 === t && this.isHorizontal()) ||
                (0 === e && this.isVertical()) ||
                ((t =
                        t -
                        parseInt(i.css("padding-left"), 10) -
                        parseInt(i.css("padding-right"), 10)),
                    (e =
                        e -
                        parseInt(i.css("padding-top"), 10) -
                        parseInt(i.css("padding-bottom"), 10)),
                    c.extend(this, {
                        width: t,
                        height: e,
                        size: this.isHorizontal() ? t : e,
                    }));
            },
            updateSlides: function() {
                var t = this.params,
                    e = this.$wrapperEl,
                    i = this.size,
                    n = this.rtlTranslate,
                    a = this.wrongRTL,
                    r = this.virtual && t.virtual.enabled,
                    o = r ? this.virtual.slides.length : this.slides.length,
                    l = e.children("." + this.params.slideClass),
                    d = r ? this.virtual.slides.length : l.length,
                    u = [],
                    h = [],
                    p = [];

                function f(e) {
                    return !t.cssMode || e !== l.length - 1;
                }
                var m = t.slidesOffsetBefore;
                "function" == typeof m && (m = t.slidesOffsetBefore.call(this));
                var v = t.slidesOffsetAfter;
                "function" == typeof v && (v = t.slidesOffsetAfter.call(this));
                var g = this.snapGrid.length,
                    y = this.snapGrid.length,
                    b = t.spaceBetween,
                    w = -m,
                    x = 0,
                    T = 0;
                if (void 0 !== i) {
                    var S, C;
                    "string" == typeof b &&
                        b.indexOf("%") >= 0 &&
                        (b = (parseFloat(b.replace("%", "")) / 100) * i),
                        (this.virtualSize = -b),
                        n ?
                        l.css({
                            marginLeft: "",
                            marginTop: "",
                        }) :
                        l.css({
                            marginRight: "",
                            marginBottom: "",
                        }),
                        t.slidesPerColumn > 1 &&
                        ((S =
                                Math.floor(d / t.slidesPerColumn) ===
                                d / this.params.slidesPerColumn ?
                                d :
                                Math.ceil(d / t.slidesPerColumn) * t.slidesPerColumn),
                            "auto" !== t.slidesPerView &&
                            "row" === t.slidesPerColumnFill &&
                            (S = Math.max(S, t.slidesPerView * t.slidesPerColumn)));
                    for (
                        var E,
                            k = t.slidesPerColumn,
                            M = S / k,
                            _ = Math.floor(d / t.slidesPerColumn),
                            P = 0; P < d; P += 1
                    ) {
                        C = 0;
                        var $ = l.eq(P);
                        if (t.slidesPerColumn > 1) {
                            var A = void 0,
                                L = void 0,
                                I = void 0;
                            if ("row" === t.slidesPerColumnFill && t.slidesPerGroup > 1) {
                                var z = Math.floor(
                                        P / (t.slidesPerGroup * t.slidesPerColumn)
                                    ),
                                    O = P - t.slidesPerColumn * t.slidesPerGroup * z,
                                    D =
                                    0 === z ?
                                    t.slidesPerGroup :
                                    Math.min(
                                        Math.ceil((d - z * k * t.slidesPerGroup) / k),
                                        t.slidesPerGroup
                                    );
                                (A =
                                    (L =
                                        O - (I = Math.floor(O / D)) * D + z * t.slidesPerGroup) +
                                    (I * S) / k),
                                $.css({
                                    "-webkit-box-ordinal-group": A,
                                    "-moz-box-ordinal-group": A,
                                    "-ms-flex-order": A,
                                    "-webkit-order": A,
                                    order: A,
                                });
                            } else
                                "column" === t.slidesPerColumnFill ?
                                ((I = P - (L = Math.floor(P / k)) * k),
                                    (L > _ || (L === _ && I === k - 1)) &&
                                    (I += 1) >= k &&
                                    ((I = 0), (L += 1))) :
                                (L = P - (I = Math.floor(P / M)) * M);
                            $.css(
                                "margin-" + (this.isHorizontal() ? "top" : "left"),
                                0 !== I && t.spaceBetween && t.spaceBetween + "px"
                            );
                        }
                        if ("none" !== $.css("display")) {
                            if ("auto" === t.slidesPerView) {
                                var F = s.getComputedStyle($[0], null),
                                    R = $[0].style.transform,
                                    B = $[0].style.webkitTransform;
                                if (
                                    (R && ($[0].style.transform = "none"),
                                        B && ($[0].style.webkitTransform = "none"),
                                        t.roundLengths)
                                )
                                    C = this.isHorizontal() ?
                                    $.outerWidth(!0) :
                                    $.outerHeight(!0);
                                else if (this.isHorizontal()) {
                                    var j = parseFloat(F.getPropertyValue("width")),
                                        N = parseFloat(F.getPropertyValue("padding-left")),
                                        V = parseFloat(F.getPropertyValue("padding-right")),
                                        H = parseFloat(F.getPropertyValue("margin-left")),
                                        Y = parseFloat(F.getPropertyValue("margin-right")),
                                        q = F.getPropertyValue("box-sizing");
                                    C = q && "border-box" === q ? j + H + Y : j + N + V + H + Y;
                                } else {
                                    var X = parseFloat(F.getPropertyValue("height")),
                                        W = parseFloat(F.getPropertyValue("padding-top")),
                                        G = parseFloat(F.getPropertyValue("padding-bottom")),
                                        U = parseFloat(F.getPropertyValue("margin-top")),
                                        K = parseFloat(F.getPropertyValue("margin-bottom")),
                                        Q = F.getPropertyValue("box-sizing");
                                    C = Q && "border-box" === Q ? X + U + K : X + W + G + U + K;
                                }
                                R && ($[0].style.transform = R),
                                    B && ($[0].style.webkitTransform = B),
                                    t.roundLengths && (C = Math.floor(C));
                            } else
                                (C = (i - (t.slidesPerView - 1) * b) / t.slidesPerView),
                                t.roundLengths && (C = Math.floor(C)),
                                l[P] &&
                                (this.isHorizontal() ?
                                    (l[P].style.width = C + "px") :
                                    (l[P].style.height = C + "px"));
                            l[P] && (l[P].swiperSlideSize = C),
                                p.push(C),
                                t.centeredSlides ?
                                ((w = w + C / 2 + x / 2 + b),
                                    0 === x && 0 !== P && (w = w - i / 2 - b),
                                    0 === P && (w = w - i / 2 - b),
                                    Math.abs(w) < 0.001 && (w = 0),
                                    t.roundLengths && (w = Math.floor(w)),
                                    T % t.slidesPerGroup == 0 && u.push(w),
                                    h.push(w)) :
                                (t.roundLengths && (w = Math.floor(w)),
                                    (T - Math.min(this.params.slidesPerGroupSkip, T)) %
                                    this.params.slidesPerGroup ==
                                    0 && u.push(w),
                                    h.push(w),
                                    (w = w + C + b)),
                                (this.virtualSize += C + b),
                                (x = C),
                                (T += 1);
                        }
                    }
                    if (
                        ((this.virtualSize = Math.max(this.virtualSize, i) + v),
                            n &&
                            a &&
                            ("slide" === t.effect || "coverflow" === t.effect) &&
                            e.css({
                                width: this.virtualSize + t.spaceBetween + "px",
                            }),
                            t.setWrapperSize &&
                            (this.isHorizontal() ?
                                e.css({
                                    width: this.virtualSize + t.spaceBetween + "px",
                                }) :
                                e.css({
                                    height: this.virtualSize + t.spaceBetween + "px",
                                })),
                            t.slidesPerColumn > 1 &&
                            ((this.virtualSize = (C + t.spaceBetween) * S),
                                (this.virtualSize =
                                    Math.ceil(this.virtualSize / t.slidesPerColumn) -
                                    t.spaceBetween),
                                this.isHorizontal() ?
                                e.css({
                                    width: this.virtualSize + t.spaceBetween + "px",
                                }) :
                                e.css({
                                    height: this.virtualSize + t.spaceBetween + "px",
                                }),
                                t.centeredSlides))
                    ) {
                        E = [];
                        for (var Z = 0; Z < u.length; Z += 1) {
                            var J = u[Z];
                            t.roundLengths && (J = Math.floor(J)),
                                u[Z] < this.virtualSize + u[0] && E.push(J);
                        }
                        u = E;
                    }
                    if (!t.centeredSlides) {
                        E = [];
                        for (var tt = 0; tt < u.length; tt += 1) {
                            var et = u[tt];
                            t.roundLengths && (et = Math.floor(et)),
                                u[tt] <= this.virtualSize - i && E.push(et);
                        }
                        (u = E),
                        Math.floor(this.virtualSize - i) - Math.floor(u[u.length - 1]) >
                            1 && u.push(this.virtualSize - i);
                    }
                    if (
                        (0 === u.length && (u = [0]),
                            0 !== t.spaceBetween &&
                            (this.isHorizontal() ?
                                n ?
                                l.filter(f).css({
                                    marginLeft: b + "px",
                                }) :
                                l.filter(f).css({
                                    marginRight: b + "px",
                                }) :
                                l.filter(f).css({
                                    marginBottom: b + "px",
                                })),
                            t.centeredSlides && t.centeredSlidesBounds)
                    ) {
                        var it = 0;
                        p.forEach(function(e) {
                            it += e + (t.spaceBetween ? t.spaceBetween : 0);
                        });
                        var nt = (it -= t.spaceBetween) - i;
                        u = u.map(function(t) {
                            return t < 0 ? -m : t > nt ? nt + v : t;
                        });
                    }
                    if (t.centerInsufficientSlides) {
                        var st = 0;
                        if (
                            (p.forEach(function(e) {
                                    st += e + (t.spaceBetween ? t.spaceBetween : 0);
                                }),
                                (st -= t.spaceBetween) < i)
                        ) {
                            var at = (i - st) / 2;
                            u.forEach(function(t, e) {
                                    u[e] = t - at;
                                }),
                                h.forEach(function(t, e) {
                                    h[e] = t + at;
                                });
                        }
                    }
                    c.extend(this, {
                            slides: l,
                            snapGrid: u,
                            slidesGrid: h,
                            slidesSizesGrid: p,
                        }),
                        d !== o && this.emit("slidesLengthChange"),
                        u.length !== g &&
                        (this.params.watchOverflow && this.checkOverflow(),
                            this.emit("snapGridLengthChange")),
                        h.length !== y && this.emit("slidesGridLengthChange"),
                        (t.watchSlidesProgress || t.watchSlidesVisibility) &&
                        this.updateSlidesOffset();
                }
            },
            updateAutoHeight: function(t) {
                var e,
                    i = [],
                    n = 0;
                if (
                    ("number" == typeof t ?
                        this.setTransition(t) :
                        !0 === t && this.setTransition(this.params.speed),
                        "auto" !== this.params.slidesPerView &&
                        this.params.slidesPerView > 1)
                )
                    if (this.params.centeredSlides)
                        this.visibleSlides.each(function(t, e) {
                            i.push(e);
                        });
                    else
                        for (e = 0; e < Math.ceil(this.params.slidesPerView); e += 1) {
                            var s = this.activeIndex + e;
                            if (s > this.slides.length) break;
                            i.push(this.slides.eq(s)[0]);
                        }
                else i.push(this.slides.eq(this.activeIndex)[0]);
                for (e = 0; e < i.length; e += 1)
                    if (void 0 !== i[e]) {
                        var a = i[e].offsetHeight;
                        n = a > n ? a : n;
                    }
                n && this.$wrapperEl.css("height", n + "px");
            },
            updateSlidesOffset: function() {
                for (var t = this.slides, e = 0; e < t.length; e += 1)
                    t[e].swiperSlideOffset = this.isHorizontal() ?
                    t[e].offsetLeft :
                    t[e].offsetTop;
            },
            updateSlidesProgress: function(t) {
                void 0 === t && (t = (this && this.translate) || 0);
                var e = this.params,
                    i = this.slides,
                    n = this.rtlTranslate;
                if (0 !== i.length) {
                    void 0 === i[0].swiperSlideOffset && this.updateSlidesOffset();
                    var s = -t;
                    n && (s = t),
                        i.removeClass(e.slideVisibleClass),
                        (this.visibleSlidesIndexes = []),
                        (this.visibleSlides = []);
                    for (var a = 0; a < i.length; a += 1) {
                        var o = i[a],
                            l =
                            (s +
                                (e.centeredSlides ? this.minTranslate() : 0) -
                                o.swiperSlideOffset) /
                            (o.swiperSlideSize + e.spaceBetween);
                        if (
                            e.watchSlidesVisibility ||
                            (e.centeredSlides && e.autoHeight)
                        ) {
                            var c = -(s - o.swiperSlideOffset),
                                d = c + this.slidesSizesGrid[a];
                            ((c >= 0 && c < this.size - 1) ||
                                (d > 1 && d <= this.size) ||
                                (c <= 0 && d >= this.size)) &&
                            (this.visibleSlides.push(o),
                                this.visibleSlidesIndexes.push(a),
                                i.eq(a).addClass(e.slideVisibleClass));
                        }
                        o.progress = n ? -l : l;
                    }
                    this.visibleSlides = r(this.visibleSlides);
                }
            },
            updateProgress: function(t) {
                if (void 0 === t) {
                    var e = this.rtlTranslate ? -1 : 1;
                    t = (this && this.translate && this.translate * e) || 0;
                }
                var i = this.params,
                    n = this.maxTranslate() - this.minTranslate(),
                    s = this.progress,
                    a = this.isBeginning,
                    r = this.isEnd,
                    o = a,
                    l = r;
                0 === n ?
                    ((s = 0), (a = !0), (r = !0)) :
                    ((a = (s = (t - this.minTranslate()) / n) <= 0), (r = s >= 1)),
                    c.extend(this, {
                        progress: s,
                        isBeginning: a,
                        isEnd: r,
                    }),
                    (i.watchSlidesProgress ||
                        i.watchSlidesVisibility ||
                        (i.centeredSlides && i.autoHeight)) &&
                    this.updateSlidesProgress(t),
                    a && !o && this.emit("reachBeginning toEdge"),
                    r && !l && this.emit("reachEnd toEdge"),
                    ((o && !a) || (l && !r)) && this.emit("fromEdge"),
                    this.emit("progress", s);
            },
            updateSlidesClasses: function() {
                var t,
                    e = this.slides,
                    i = this.params,
                    n = this.$wrapperEl,
                    s = this.activeIndex,
                    a = this.realIndex,
                    r = this.virtual && i.virtual.enabled;
                e.removeClass(
                        i.slideActiveClass +
                        " " +
                        i.slideNextClass +
                        " " +
                        i.slidePrevClass +
                        " " +
                        i.slideDuplicateActiveClass +
                        " " +
                        i.slideDuplicateNextClass +
                        " " +
                        i.slideDuplicatePrevClass
                    ),
                    (t = r ?
                        this.$wrapperEl.find(
                            "." + i.slideClass + '[data-swiper-slide-index="' + s + '"]'
                        ) :
                        e.eq(s)).addClass(i.slideActiveClass),
                    i.loop &&
                    (t.hasClass(i.slideDuplicateClass) ?
                        n
                        .children(
                            "." +
                            i.slideClass +
                            ":not(." +
                            i.slideDuplicateClass +
                            ')[data-swiper-slide-index="' +
                            a +
                            '"]'
                        )
                        .addClass(i.slideDuplicateActiveClass) :
                        n
                        .children(
                            "." +
                            i.slideClass +
                            "." +
                            i.slideDuplicateClass +
                            '[data-swiper-slide-index="' +
                            a +
                            '"]'
                        )
                        .addClass(i.slideDuplicateActiveClass));
                var o = t
                    .nextAll("." + i.slideClass)
                    .eq(0)
                    .addClass(i.slideNextClass);
                i.loop && 0 === o.length && (o = e.eq(0)).addClass(i.slideNextClass);
                var l = t
                    .prevAll("." + i.slideClass)
                    .eq(0)
                    .addClass(i.slidePrevClass);
                i.loop && 0 === l.length && (l = e.eq(-1)).addClass(i.slidePrevClass),
                    i.loop &&
                    (o.hasClass(i.slideDuplicateClass) ?
                        n
                        .children(
                            "." +
                            i.slideClass +
                            ":not(." +
                            i.slideDuplicateClass +
                            ')[data-swiper-slide-index="' +
                            o.attr("data-swiper-slide-index") +
                            '"]'
                        )
                        .addClass(i.slideDuplicateNextClass) :
                        n
                        .children(
                            "." +
                            i.slideClass +
                            "." +
                            i.slideDuplicateClass +
                            '[data-swiper-slide-index="' +
                            o.attr("data-swiper-slide-index") +
                            '"]'
                        )
                        .addClass(i.slideDuplicateNextClass),
                        l.hasClass(i.slideDuplicateClass) ?
                        n
                        .children(
                            "." +
                            i.slideClass +
                            ":not(." +
                            i.slideDuplicateClass +
                            ')[data-swiper-slide-index="' +
                            l.attr("data-swiper-slide-index") +
                            '"]'
                        )
                        .addClass(i.slideDuplicatePrevClass) :
                        n
                        .children(
                            "." +
                            i.slideClass +
                            "." +
                            i.slideDuplicateClass +
                            '[data-swiper-slide-index="' +
                            l.attr("data-swiper-slide-index") +
                            '"]'
                        )
                        .addClass(i.slideDuplicatePrevClass));
            },
            updateActiveIndex: function(t) {
                var e,
                    i = this.rtlTranslate ? this.translate : -this.translate,
                    n = this.slidesGrid,
                    s = this.snapGrid,
                    a = this.params,
                    r = this.activeIndex,
                    o = this.realIndex,
                    l = this.snapIndex,
                    d = t;
                if (void 0 === d) {
                    for (var u = 0; u < n.length; u += 1)
                        void 0 !== n[u + 1] ?
                        i >= n[u] && i < n[u + 1] - (n[u + 1] - n[u]) / 2 ?
                        (d = u) :
                        i >= n[u] && i < n[u + 1] && (d = u + 1) :
                        i >= n[u] && (d = u);
                    a.normalizeSlideIndex && (d < 0 || void 0 === d) && (d = 0);
                }
                if (s.indexOf(i) >= 0) e = s.indexOf(i);
                else {
                    var h = Math.min(a.slidesPerGroupSkip, d);
                    e = h + Math.floor((d - h) / a.slidesPerGroup);
                }
                if ((e >= s.length && (e = s.length - 1), d !== r)) {
                    var p = parseInt(
                        this.slides.eq(d).attr("data-swiper-slide-index") || d,
                        10
                    );
                    c.extend(this, {
                            snapIndex: e,
                            realIndex: p,
                            previousIndex: r,
                            activeIndex: d,
                        }),
                        this.emit("activeIndexChange"),
                        this.emit("snapIndexChange"),
                        o !== p && this.emit("realIndexChange"),
                        (this.initialized || this.params.runCallbacksOnInit) &&
                        this.emit("slideChange");
                } else
                    e !== l && ((this.snapIndex = e), this.emit("snapIndexChange"));
            },
            updateClickedSlide: function(t) {
                var e = this.params,
                    i = r(t.target).closest("." + e.slideClass)[0],
                    n = !1;
                if (i)
                    for (var s = 0; s < this.slides.length; s += 1)
                        this.slides[s] === i && (n = !0);
                if (!i || !n)
                    return (
                        (this.clickedSlide = void 0), void(this.clickedIndex = void 0)
                    );
                (this.clickedSlide = i),
                this.virtual && this.params.virtual.enabled ?
                    (this.clickedIndex = parseInt(
                        r(i).attr("data-swiper-slide-index"),
                        10
                    )) :
                    (this.clickedIndex = r(i).index()),
                    e.slideToClickedSlide &&
                    void 0 !== this.clickedIndex &&
                    this.clickedIndex !== this.activeIndex &&
                    this.slideToClickedSlide();
            },
        },
        P = {
            getTranslate: function(t) {
                void 0 === t && (t = this.isHorizontal() ? "x" : "y");
                var e = this.params,
                    i = this.rtlTranslate,
                    n = this.translate,
                    s = this.$wrapperEl;
                if (e.virtualTranslate) return i ? -n : n;
                if (e.cssMode) return n;
                var a = c.getTranslate(s[0], t);
                return i && (a = -a), a || 0;
            },
            setTranslate: function(t, e) {
                var i = this.rtlTranslate,
                    n = this.params,
                    s = this.$wrapperEl,
                    a = this.wrapperEl,
                    r = this.progress,
                    o = 0,
                    l = 0;
                this.isHorizontal() ? (o = i ? -t : t) : (l = t),
                    n.roundLengths && ((o = Math.floor(o)), (l = Math.floor(l))),
                    n.cssMode ?
                    (a[this.isHorizontal() ? "scrollLeft" : "scrollTop"] =
                        this.isHorizontal() ? -o : -l) :
                    n.virtualTranslate ||
                    s.transform("translate3d(" + o + "px, " + l + "px, 0px)"),
                    (this.previousTranslate = this.translate),
                    (this.translate = this.isHorizontal() ? o : l);
                var c = this.maxTranslate() - this.minTranslate();
                (0 === c ? 0 : (t - this.minTranslate()) / c) !== r &&
                    this.updateProgress(t),
                    this.emit("setTranslate", this.translate, e);
            },
            minTranslate: function() {
                return -this.snapGrid[0];
            },
            maxTranslate: function() {
                return -this.snapGrid[this.snapGrid.length - 1];
            },
            translateTo: function(t, e, i, n, s) {
                var a;
                void 0 === t && (t = 0),
                    void 0 === e && (e = this.params.speed),
                    void 0 === i && (i = !0),
                    void 0 === n && (n = !0);
                var r = this,
                    o = r.params,
                    l = r.wrapperEl;
                if (r.animating && o.preventInteractionOnTransition) return !1;
                var c,
                    d = r.minTranslate(),
                    u = r.maxTranslate();
                if (
                    ((c = n && t > d ? d : n && t < u ? u : t),
                        r.updateProgress(c),
                        o.cssMode)
                ) {
                    var h = r.isHorizontal();
                    return (
                        0 === e ?
                        (l[h ? "scrollLeft" : "scrollTop"] = -c) :
                        l.scrollTo ?
                        l.scrollTo(
                            (((a = {})[h ? "left" : "top"] = -c),
                                (a.behavior = "smooth"),
                                a)
                        ) :
                        (l[h ? "scrollLeft" : "scrollTop"] = -c), !0
                    );
                }
                return (
                    0 === e ?
                    (r.setTransition(0),
                        r.setTranslate(c),
                        i &&
                        (r.emit("beforeTransitionStart", e, s),
                            r.emit("transitionEnd"))) :
                    (r.setTransition(e),
                        r.setTranslate(c),
                        i &&
                        (r.emit("beforeTransitionStart", e, s),
                            r.emit("transitionStart")),
                        r.animating ||
                        ((r.animating = !0),
                            r.onTranslateToWrapperTransitionEnd ||
                            (r.onTranslateToWrapperTransitionEnd = function(t) {
                                r &&
                                    !r.destroyed &&
                                    t.target === this &&
                                    (r.$wrapperEl[0].removeEventListener(
                                            "transitionend",
                                            r.onTranslateToWrapperTransitionEnd
                                        ),
                                        r.$wrapperEl[0].removeEventListener(
                                            "webkitTransitionEnd",
                                            r.onTranslateToWrapperTransitionEnd
                                        ),
                                        (r.onTranslateToWrapperTransitionEnd = null),
                                        delete r.onTranslateToWrapperTransitionEnd,
                                        i && r.emit("transitionEnd"));
                            }),
                            r.$wrapperEl[0].addEventListener(
                                "transitionend",
                                r.onTranslateToWrapperTransitionEnd
                            ),
                            r.$wrapperEl[0].addEventListener(
                                "webkitTransitionEnd",
                                r.onTranslateToWrapperTransitionEnd
                            ))), !0
                );
            },
        },
        $ = {
            slideTo: function(t, e, i, n) {
                var s;
                void 0 === t && (t = 0),
                    void 0 === e && (e = this.params.speed),
                    void 0 === i && (i = !0);
                var a = this,
                    r = t;
                r < 0 && (r = 0);
                var o = a.params,
                    l = a.snapGrid,
                    c = a.slidesGrid,
                    d = a.previousIndex,
                    u = a.activeIndex,
                    h = a.rtlTranslate,
                    p = a.wrapperEl;
                if (a.animating && o.preventInteractionOnTransition) return !1;
                var f = Math.min(a.params.slidesPerGroupSkip, r),
                    m = f + Math.floor((r - f) / a.params.slidesPerGroup);
                m >= l.length && (m = l.length - 1),
                    (u || o.initialSlide || 0) === (d || 0) &&
                    i &&
                    a.emit("beforeSlideChangeStart");
                var v,
                    g = -l[m];
                if ((a.updateProgress(g), o.normalizeSlideIndex))
                    for (var y = 0; y < c.length; y += 1)
                        -
                        Math.floor(100 * g) >= Math.floor(100 * c[y]) && (r = y);
                if (a.initialized && r !== u) {
                    if (!a.allowSlideNext && g < a.translate && g < a.minTranslate())
                        return !1;
                    if (!a.allowSlidePrev &&
                        g > a.translate &&
                        g > a.maxTranslate() &&
                        (u || 0) !== r
                    )
                        return !1;
                }
                if (
                    ((v = r > u ? "next" : r < u ? "prev" : "reset"),
                        (h && -g === a.translate) || (!h && g === a.translate))
                )
                    return (
                        a.updateActiveIndex(r),
                        o.autoHeight && a.updateAutoHeight(),
                        a.updateSlidesClasses(),
                        "slide" !== o.effect && a.setTranslate(g),
                        "reset" !== v && (a.transitionStart(i, v), a.transitionEnd(i, v)), !1
                    );
                if (o.cssMode) {
                    var b = a.isHorizontal(),
                        w = -g;
                    return (
                        h && (w = p.scrollWidth - p.offsetWidth - w),
                        0 === e ?
                        (p[b ? "scrollLeft" : "scrollTop"] = w) :
                        p.scrollTo ?
                        p.scrollTo(
                            (((s = {})[b ? "left" : "top"] = w),
                                (s.behavior = "smooth"),
                                s)
                        ) :
                        (p[b ? "scrollLeft" : "scrollTop"] = w), !0
                    );
                }
                return (
                    0 === e ?
                    (a.setTransition(0),
                        a.setTranslate(g),
                        a.updateActiveIndex(r),
                        a.updateSlidesClasses(),
                        a.emit("beforeTransitionStart", e, n),
                        a.transitionStart(i, v),
                        a.transitionEnd(i, v)) :
                    (a.setTransition(e),
                        a.setTranslate(g),
                        a.updateActiveIndex(r),
                        a.updateSlidesClasses(),
                        a.emit("beforeTransitionStart", e, n),
                        a.transitionStart(i, v),
                        a.animating ||
                        ((a.animating = !0),
                            a.onSlideToWrapperTransitionEnd ||
                            (a.onSlideToWrapperTransitionEnd = function(t) {
                                a &&
                                    !a.destroyed &&
                                    t.target === this &&
                                    (a.$wrapperEl[0].removeEventListener(
                                            "transitionend",
                                            a.onSlideToWrapperTransitionEnd
                                        ),
                                        a.$wrapperEl[0].removeEventListener(
                                            "webkitTransitionEnd",
                                            a.onSlideToWrapperTransitionEnd
                                        ),
                                        (a.onSlideToWrapperTransitionEnd = null),
                                        delete a.onSlideToWrapperTransitionEnd,
                                        a.transitionEnd(i, v));
                            }),
                            a.$wrapperEl[0].addEventListener(
                                "transitionend",
                                a.onSlideToWrapperTransitionEnd
                            ),
                            a.$wrapperEl[0].addEventListener(
                                "webkitTransitionEnd",
                                a.onSlideToWrapperTransitionEnd
                            ))), !0
                );
            },
            slideToLoop: function(t, e, i, n) {
                void 0 === t && (t = 0),
                    void 0 === e && (e = this.params.speed),
                    void 0 === i && (i = !0);
                var s = t;
                return (
                    this.params.loop && (s += this.loopedSlides),
                    this.slideTo(s, e, i, n)
                );
            },
            slideNext: function(t, e, i) {
                void 0 === t && (t = this.params.speed), void 0 === e && (e = !0);
                var n = this.params,
                    s = this.animating,
                    a = this.activeIndex < n.slidesPerGroupSkip ? 1 : n.slidesPerGroup;
                if (n.loop) {
                    if (s) return !1;
                    this.loopFix(), (this._clientLeft = this.$wrapperEl[0].clientLeft);
                }
                return this.slideTo(this.activeIndex + a, t, e, i);
            },
            slidePrev: function(t, e, i) {
                void 0 === t && (t = this.params.speed), void 0 === e && (e = !0);
                var n = this.params,
                    s = this.animating,
                    a = this.snapGrid,
                    r = this.slidesGrid,
                    o = this.rtlTranslate;
                if (n.loop) {
                    if (s) return !1;
                    this.loopFix(), (this._clientLeft = this.$wrapperEl[0].clientLeft);
                }

                function l(t) {
                    return t < 0 ? -Math.floor(Math.abs(t)) : Math.floor(t);
                }
                var c,
                    d = l(o ? this.translate : -this.translate),
                    u = a.map(function(t) {
                        return l(t);
                    }),
                    h =
                    (r.map(function(t) {
                            return l(t);
                        }),
                        a[u.indexOf(d)],
                        a[u.indexOf(d) - 1]);
                return (
                    void 0 === h &&
                    n.cssMode &&
                    a.forEach(function(t) {
                        !h && d >= t && (h = t);
                    }),
                    void 0 !== h &&
                    (c = r.indexOf(h)) < 0 &&
                    (c = this.activeIndex - 1),
                    this.slideTo(c, t, e, i)
                );
            },
            slideReset: function(t, e, i) {
                return (
                    void 0 === t && (t = this.params.speed),
                    void 0 === e && (e = !0),
                    this.slideTo(this.activeIndex, t, e, i)
                );
            },
            slideToClosest: function(t, e, i, n) {
                void 0 === t && (t = this.params.speed),
                    void 0 === e && (e = !0),
                    void 0 === n && (n = 0.5);
                var s = this.activeIndex,
                    a = Math.min(this.params.slidesPerGroupSkip, s),
                    r = a + Math.floor((s - a) / this.params.slidesPerGroup),
                    o = this.rtlTranslate ? this.translate : -this.translate;
                if (o >= this.snapGrid[r]) {
                    var l = this.snapGrid[r];
                    o - l > (this.snapGrid[r + 1] - l) * n &&
                        (s += this.params.slidesPerGroup);
                } else {
                    var c = this.snapGrid[r - 1];
                    o - c <= (this.snapGrid[r] - c) * n &&
                        (s -= this.params.slidesPerGroup);
                }
                return (
                    (s = Math.max(s, 0)),
                    (s = Math.min(s, this.slidesGrid.length - 1)),
                    this.slideTo(s, t, e, i)
                );
            },
            slideToClickedSlide: function() {
                var t,
                    e = this,
                    i = e.params,
                    n = e.$wrapperEl,
                    s =
                    "auto" === i.slidesPerView ?
                    e.slidesPerViewDynamic() :
                    i.slidesPerView,
                    a = e.clickedIndex;
                if (i.loop) {
                    if (e.animating) return;
                    (t = parseInt(
                        r(e.clickedSlide).attr("data-swiper-slide-index"),
                        10
                    )),
                    i.centeredSlides ?
                        a < e.loopedSlides - s / 2 ||
                        a > e.slides.length - e.loopedSlides + s / 2 ?
                        (e.loopFix(),
                            (a = n
                                .children(
                                    "." +
                                    i.slideClass +
                                    '[data-swiper-slide-index="' +
                                    t +
                                    '"]:not(.' +
                                    i.slideDuplicateClass +
                                    ")"
                                )
                                .eq(0)
                                .index()),
                            c.nextTick(function() {
                                e.slideTo(a);
                            })) :
                        e.slideTo(a) :
                        a > e.slides.length - s ?
                        (e.loopFix(),
                            (a = n
                                .children(
                                    "." +
                                    i.slideClass +
                                    '[data-swiper-slide-index="' +
                                    t +
                                    '"]:not(.' +
                                    i.slideDuplicateClass +
                                    ")"
                                )
                                .eq(0)
                                .index()),
                            c.nextTick(function() {
                                e.slideTo(a);
                            })) :
                        e.slideTo(a);
                } else e.slideTo(a);
            },
        },
        A = {
            loopCreate: function() {
                var t = this,
                    e = t.params,
                    n = t.$wrapperEl;
                n.children("." + e.slideClass + "." + e.slideDuplicateClass).remove();
                var s = n.children("." + e.slideClass);
                if (e.loopFillGroupWithBlank) {
                    var a = e.slidesPerGroup - (s.length % e.slidesPerGroup);
                    if (a !== e.slidesPerGroup) {
                        for (var o = 0; o < a; o += 1) {
                            var l = r(i.createElement("div")).addClass(
                                e.slideClass + " " + e.slideBlankClass
                            );
                            n.append(l);
                        }
                        s = n.children("." + e.slideClass);
                    }
                }
                "auto" !== e.slidesPerView ||
                    e.loopedSlides ||
                    (e.loopedSlides = s.length),
                    (t.loopedSlides = Math.ceil(
                        parseFloat(e.loopedSlides || e.slidesPerView, 10)
                    )),
                    (t.loopedSlides += e.loopAdditionalSlides),
                    t.loopedSlides > s.length && (t.loopedSlides = s.length);
                var c = [],
                    d = [];
                s.each(function(e, i) {
                    var n = r(i);
                    e < t.loopedSlides && d.push(i),
                        e < s.length && e >= s.length - t.loopedSlides && c.push(i),
                        n.attr("data-swiper-slide-index", e);
                });
                for (var u = 0; u < d.length; u += 1)
                    n.append(r(d[u].cloneNode(!0)).addClass(e.slideDuplicateClass));
                for (var h = c.length - 1; h >= 0; h -= 1)
                    n.prepend(r(c[h].cloneNode(!0)).addClass(e.slideDuplicateClass));
            },
            loopFix: function() {
                this.emit("beforeLoopFix");
                var t,
                    e = this.activeIndex,
                    i = this.slides,
                    n = this.loopedSlides,
                    s = this.allowSlidePrev,
                    a = this.allowSlideNext,
                    r = this.snapGrid,
                    o = this.rtlTranslate;
                (this.allowSlidePrev = !0), (this.allowSlideNext = !0);
                var l = -r[e] - this.getTranslate();
                e < n ?
                    ((t = i.length - 3 * n + e),
                        (t += n),
                        this.slideTo(t, 0, !1, !0) &&
                        0 !== l &&
                        this.setTranslate((o ? -this.translate : this.translate) - l)) :
                    e >= i.length - n &&
                    ((t = -i.length + e + n),
                        (t += n),
                        this.slideTo(t, 0, !1, !0) &&
                        0 !== l &&
                        this.setTranslate((o ? -this.translate : this.translate) - l)),
                    (this.allowSlidePrev = s),
                    (this.allowSlideNext = a),
                    this.emit("loopFix");
            },
            loopDestroy: function() {
                var t = this.$wrapperEl,
                    e = this.params,
                    i = this.slides;
                t
                    .children(
                        "." +
                        e.slideClass +
                        "." +
                        e.slideDuplicateClass +
                        ",." +
                        e.slideClass +
                        "." +
                        e.slideBlankClass
                    )
                    .remove(),
                    i.removeAttr("data-swiper-slide-index");
            },
        },
        L = {
            setGrabCursor: function(t) {
                if (!(
                        d.touch ||
                        !this.params.simulateTouch ||
                        (this.params.watchOverflow && this.isLocked) ||
                        this.params.cssMode
                    )) {
                    var e = this.el;
                    (e.style.cursor = "move"),
                    (e.style.cursor = t ? "-webkit-grabbing" : "-webkit-grab"),
                    (e.style.cursor = t ? "-moz-grabbin" : "-moz-grab"),
                    (e.style.cursor = t ? "grabbing" : "grab");
                }
            },
            unsetGrabCursor: function() {
                d.touch ||
                    (this.params.watchOverflow && this.isLocked) ||
                    this.params.cssMode ||
                    (this.el.style.cursor = "");
            },
        },
        I = {
            appendSlide: function(t) {
                var e = this.$wrapperEl,
                    i = this.params;
                if (
                    (i.loop && this.loopDestroy(),
                        "object" == typeof t && "length" in t)
                )
                    for (var n = 0; n < t.length; n += 1) t[n] && e.append(t[n]);
                else e.append(t);
                i.loop && this.loopCreate(),
                    (i.observer && d.observer) || this.update();
            },
            prependSlide: function(t) {
                var e = this.params,
                    i = this.$wrapperEl,
                    n = this.activeIndex;
                e.loop && this.loopDestroy();
                var s = n + 1;
                if ("object" == typeof t && "length" in t) {
                    for (var a = 0; a < t.length; a += 1) t[a] && i.prepend(t[a]);
                    s = n + t.length;
                } else i.prepend(t);
                e.loop && this.loopCreate(),
                    (e.observer && d.observer) || this.update(),
                    this.slideTo(s, 0, !1);
            },
            addSlide: function(t, e) {
                var i = this.$wrapperEl,
                    n = this.params,
                    s = this.activeIndex;
                n.loop &&
                    ((s -= this.loopedSlides),
                        this.loopDestroy(),
                        (this.slides = i.children("." + n.slideClass)));
                var a = this.slides.length;
                if (t <= 0) this.prependSlide(e);
                else if (t >= a) this.appendSlide(e);
                else {
                    for (var r = s > t ? s + 1 : s, o = [], l = a - 1; l >= t; l -= 1) {
                        var c = this.slides.eq(l);
                        c.remove(), o.unshift(c);
                    }
                    if ("object" == typeof e && "length" in e) {
                        for (var u = 0; u < e.length; u += 1) e[u] && i.append(e[u]);
                        r = s > t ? s + e.length : s;
                    } else i.append(e);
                    for (var h = 0; h < o.length; h += 1) i.append(o[h]);
                    n.loop && this.loopCreate(),
                        (n.observer && d.observer) || this.update(),
                        n.loop ?
                        this.slideTo(r + this.loopedSlides, 0, !1) :
                        this.slideTo(r, 0, !1);
                }
            },
            removeSlide: function(t) {
                var e = this.params,
                    i = this.$wrapperEl,
                    n = this.activeIndex;
                e.loop &&
                    ((n -= this.loopedSlides),
                        this.loopDestroy(),
                        (this.slides = i.children("." + e.slideClass)));
                var s,
                    a = n;
                if ("object" == typeof t && "length" in t) {
                    for (var r = 0; r < t.length; r += 1)
                        (s = t[r]),
                        this.slides[s] && this.slides.eq(s).remove(),
                        s < a && (a -= 1);
                    a = Math.max(a, 0);
                } else
                    (s = t),
                    this.slides[s] && this.slides.eq(s).remove(),
                    s < a && (a -= 1),
                    (a = Math.max(a, 0));
                e.loop && this.loopCreate(),
                    (e.observer && d.observer) || this.update(),
                    e.loop ?
                    this.slideTo(a + this.loopedSlides, 0, !1) :
                    this.slideTo(a, 0, !1);
            },
            removeAllSlides: function() {
                for (var t = [], e = 0; e < this.slides.length; e += 1) t.push(e);
                this.removeSlide(t);
            },
        },
        z =
        ((p = s.navigator.platform),
            (f = s.navigator.userAgent),
            (m = {
                ios: !1,
                android: !1,
                androidChrome: !1,
                desktop: !1,
                iphone: !1,
                ipod: !1,
                ipad: !1,
                edge: !1,
                ie: !1,
                firefox: !1,
                macos: !1,
                windows: !1,
                cordova: !(!s.cordova && !s.phonegap),
                phonegap: !(!s.cordova && !s.phonegap),
                electron: !1,
            }),
            (v = s.screen.width),
            (g = s.screen.height),
            (y = f.match(/(Android);?[\s\/]+([\d.]+)?/)),
            (b = f.match(/(iPad).*OS\s([\d_]+)/)),
            (w = f.match(/(iPod)(.*OS\s([\d_]+))?/)),
            (x = !b && f.match(/(iPhone\sOS|iOS)\s([\d_]+)/)),
            (T = f.indexOf("MSIE ") >= 0 || f.indexOf("Trident/") >= 0),
            (S = f.indexOf("Edge/") >= 0),
            (C = f.indexOf("Gecko/") >= 0 && f.indexOf("Firefox/") >= 0),
            (E = "Win32" === p),
            (k = f.toLowerCase().indexOf("electron") >= 0),
            (M = "MacIntel" === p), !b &&
            M &&
            d.touch &&
            ((1024 === v && 1366 === g) ||
                (834 === v && 1194 === g) ||
                (834 === v && 1112 === g) ||
                (768 === v && 1024 === g)) &&
            ((b = f.match(/(Version)\/([\d.]+)/)), (M = !1)),
            (m.ie = T),
            (m.edge = S),
            (m.firefox = C),
            y &&
            !E &&
            ((m.os = "android"),
                (m.osVersion = y[2]),
                (m.android = !0),
                (m.androidChrome = f.toLowerCase().indexOf("chrome") >= 0)),
            (b || x || w) && ((m.os = "ios"), (m.ios = !0)),
            x && !w && ((m.osVersion = x[2].replace(/_/g, ".")), (m.iphone = !0)),
            b && ((m.osVersion = b[2].replace(/_/g, ".")), (m.ipad = !0)),
            w &&
            ((m.osVersion = w[3] ? w[3].replace(/_/g, ".") : null),
                (m.ipod = !0)),
            m.ios &&
            m.osVersion &&
            f.indexOf("Version/") >= 0 &&
            "10" === m.osVersion.split(".")[0] &&
            (m.osVersion = f.toLowerCase().split("version/")[1].split(" ")[0]),
            (m.webView = !(!(x || b || w) ||
                    (!f.match(/.*AppleWebKit(?!.*Safari)/i) && !s.navigator.standalone)
                ) ||
                (s.matchMedia && s.matchMedia("(display-mode: standalone)").matches)),
            (m.webview = m.webView),
            (m.standalone = m.webView),
            (m.desktop = !(m.ios || m.android) || k),
            m.desktop &&
            ((m.electron = k),
                (m.macos = M),
                (m.windows = E),
                m.macos && (m.os = "macos"),
                m.windows && (m.os = "windows")),
            (m.pixelRatio = s.devicePixelRatio || 1),
            m);

    function O(t) {
        var e = this.touchEventsData,
            n = this.params,
            a = this.touches;
        if (!this.animating || !n.preventInteractionOnTransition) {
            var o = t;
            o.originalEvent && (o = o.originalEvent);
            var l = r(o.target);
            if (
                ("wrapper" !== n.touchEventsTarget ||
                    l.closest(this.wrapperEl).length) &&
                ((e.isTouchEvent = "touchstart" === o.type),
                    (e.isTouchEvent || !("which" in o) || 3 !== o.which) &&
                    !(
                        (!e.isTouchEvent && "button" in o && o.button > 0) ||
                        (e.isTouched && e.isMoved)
                    ))
            )
                if (
                    n.noSwiping &&
                    l.closest(
                        n.noSwipingSelector ? n.noSwipingSelector : "." + n.noSwipingClass
                    )[0]
                )
                    this.allowClick = !0;
                else if (!n.swipeHandler || l.closest(n.swipeHandler)[0]) {
                (a.currentX =
                    "touchstart" === o.type ? o.targetTouches[0].pageX : o.pageX),
                (a.currentY =
                    "touchstart" === o.type ? o.targetTouches[0].pageY : o.pageY);
                var d = a.currentX,
                    u = a.currentY,
                    h = n.edgeSwipeDetection || n.iOSEdgeSwipeDetection,
                    p = n.edgeSwipeThreshold || n.iOSEdgeSwipeThreshold;
                if (!h || !(d <= p || d >= s.screen.width - p)) {
                    if (
                        (c.extend(e, {
                                isTouched: !0,
                                isMoved: !1,
                                allowTouchCallbacks: !0,
                                isScrolling: void 0,
                                startMoving: void 0,
                            }),
                            (a.startX = d),
                            (a.startY = u),
                            (e.touchStartTime = c.now()),
                            (this.allowClick = !0),
                            this.updateSize(),
                            (this.swipeDirection = void 0),
                            n.threshold > 0 && (e.allowThresholdMove = !1),
                            "touchstart" !== o.type)
                    ) {
                        var f = !0;
                        l.is(e.formElements) && (f = !1),
                            i.activeElement &&
                            r(i.activeElement).is(e.formElements) &&
                            i.activeElement !== l[0] &&
                            i.activeElement.blur();
                        var m = f && this.allowTouchMove && n.touchStartPreventDefault;
                        (n.touchStartForcePreventDefault || m) && o.preventDefault();
                    }
                    this.emit("touchStart", o);
                }
            }
        }
    }

    function D(t) {
        var e = this.touchEventsData,
            n = this.params,
            s = this.touches,
            a = this.rtlTranslate,
            o = t;
        if ((o.originalEvent && (o = o.originalEvent), e.isTouched)) {
            if (!e.isTouchEvent || "touchmove" === o.type) {
                var l =
                    "touchmove" === o.type &&
                    o.targetTouches &&
                    (o.targetTouches[0] || o.changedTouches[0]),
                    d = "touchmove" === o.type ? l.pageX : o.pageX,
                    u = "touchmove" === o.type ? l.pageY : o.pageY;
                if (o.preventedByNestedSwiper)
                    return (s.startX = d), void(s.startY = u);
                if (!this.allowTouchMove)
                    return (
                        (this.allowClick = !1),
                        void(
                            e.isTouched &&
                            (c.extend(s, {
                                    startX: d,
                                    startY: u,
                                    currentX: d,
                                    currentY: u,
                                }),
                                (e.touchStartTime = c.now()))
                        )
                    );
                if (e.isTouchEvent && n.touchReleaseOnEdges && !n.loop)
                    if (this.isVertical()) {
                        if (
                            (u < s.startY && this.translate <= this.maxTranslate()) ||
                            (u > s.startY && this.translate >= this.minTranslate())
                        )
                            return (e.isTouched = !1), void(e.isMoved = !1);
                    } else if (
                    (d < s.startX && this.translate <= this.maxTranslate()) ||
                    (d > s.startX && this.translate >= this.minTranslate())
                )
                    return;
                if (
                    e.isTouchEvent &&
                    i.activeElement &&
                    o.target === i.activeElement &&
                    r(o.target).is(e.formElements)
                )
                    return (e.isMoved = !0), void(this.allowClick = !1);
                if (
                    (e.allowTouchCallbacks && this.emit("touchMove", o), !(o.targetTouches && o.targetTouches.length > 1))
                ) {
                    (s.currentX = d), (s.currentY = u);
                    var h,
                        p = s.currentX - s.startX,
                        f = s.currentY - s.startY;
                    if (!(
                            this.params.threshold &&
                            Math.sqrt(Math.pow(p, 2) + Math.pow(f, 2)) <
                            this.params.threshold
                        ))
                        if (
                            (void 0 === e.isScrolling &&
                                ((this.isHorizontal() && s.currentY === s.startY) ||
                                    (this.isVertical() && s.currentX === s.startX) ?
                                    (e.isScrolling = !1) :
                                    p * p + f * f >= 25 &&
                                    ((h =
                                            (180 * Math.atan2(Math.abs(f), Math.abs(p))) / Math.PI),
                                        (e.isScrolling = this.isHorizontal() ?
                                            h > n.touchAngle :
                                            90 - h > n.touchAngle))),
                                e.isScrolling && this.emit("touchMoveOpposite", o),
                                void 0 === e.startMoving &&
                                ((s.currentX === s.startX && s.currentY === s.startY) ||
                                    (e.startMoving = !0)),
                                e.isScrolling)
                        )
                            e.isTouched = !1;
                        else if (e.startMoving) {
                        (this.allowClick = !1), !n.cssMode && o.cancelable && o.preventDefault(),
                            n.touchMoveStopPropagation &&
                            !n.nested &&
                            o.stopPropagation(),
                            e.isMoved ||
                            (n.loop && this.loopFix(),
                                (e.startTranslate = this.getTranslate()),
                                this.setTransition(0),
                                this.animating &&
                                this.$wrapperEl.trigger(
                                    "webkitTransitionEnd transitionend"
                                ),
                                (e.allowMomentumBounce = !1), !n.grabCursor ||
                                (!0 !== this.allowSlideNext &&
                                    !0 !== this.allowSlidePrev) ||
                                this.setGrabCursor(!0),
                                this.emit("sliderFirstMove", o)),
                            this.emit("sliderMove", o),
                            (e.isMoved = !0);
                        var m = this.isHorizontal() ? p : f;
                        (s.diff = m),
                        (m *= n.touchRatio),
                        a && (m = -m),
                            (this.swipeDirection = m > 0 ? "prev" : "next"),
                            (e.currentTranslate = m + e.startTranslate);
                        var v = !0,
                            g = n.resistanceRatio;
                        if (
                            (n.touchReleaseOnEdges && (g = 0),
                                m > 0 && e.currentTranslate > this.minTranslate() ?
                                ((v = !1),
                                    n.resistance &&
                                    (e.currentTranslate =
                                        this.minTranslate() -
                                        1 +
                                        Math.pow(-this.minTranslate() + e.startTranslate + m,
                                            g
                                        ))) :
                                m < 0 &&
                                e.currentTranslate < this.maxTranslate() &&
                                ((v = !1),
                                    n.resistance &&
                                    (e.currentTranslate =
                                        this.maxTranslate() +
                                        1 -
                                        Math.pow(
                                            this.maxTranslate() - e.startTranslate - m,
                                            g
                                        ))),
                                v && (o.preventedByNestedSwiper = !0), !this.allowSlideNext &&
                                "next" === this.swipeDirection &&
                                e.currentTranslate < e.startTranslate &&
                                (e.currentTranslate = e.startTranslate), !this.allowSlidePrev &&
                                "prev" === this.swipeDirection &&
                                e.currentTranslate > e.startTranslate &&
                                (e.currentTranslate = e.startTranslate),
                                n.threshold > 0)
                        ) {
                            if (!(Math.abs(m) > n.threshold || e.allowThresholdMove))
                                return void(e.currentTranslate = e.startTranslate);
                            if (!e.allowThresholdMove)
                                return (
                                    (e.allowThresholdMove = !0),
                                    (s.startX = s.currentX),
                                    (s.startY = s.currentY),
                                    (e.currentTranslate = e.startTranslate),
                                    void(s.diff = this.isHorizontal() ?
                                        s.currentX - s.startX :
                                        s.currentY - s.startY)
                                );
                        }
                        n.followFinger &&
                            !n.cssMode &&
                            ((n.freeMode ||
                                    n.watchSlidesProgress ||
                                    n.watchSlidesVisibility) &&
                                (this.updateActiveIndex(), this.updateSlidesClasses()),
                                n.freeMode &&
                                (0 === e.velocities.length &&
                                    e.velocities.push({
                                        position: s[this.isHorizontal() ? "startX" : "startY"],
                                        time: e.touchStartTime,
                                    }),
                                    e.velocities.push({
                                        position: s[this.isHorizontal() ? "currentX" : "currentY"],
                                        time: c.now(),
                                    })),
                                this.updateProgress(e.currentTranslate),
                                this.setTranslate(e.currentTranslate));
                    }
                }
            }
        } else e.startMoving && e.isScrolling && this.emit("touchMoveOpposite", o);
    }

    function F(t) {
        var e = this,
            i = e.touchEventsData,
            n = e.params,
            s = e.touches,
            a = e.rtlTranslate,
            r = e.$wrapperEl,
            o = e.slidesGrid,
            l = e.snapGrid,
            d = t;
        if (
            (d.originalEvent && (d = d.originalEvent),
                i.allowTouchCallbacks && e.emit("touchEnd", d),
                (i.allowTouchCallbacks = !1), !i.isTouched)
        )
            return (
                i.isMoved && n.grabCursor && e.setGrabCursor(!1),
                (i.isMoved = !1),
                void(i.startMoving = !1)
            );
        n.grabCursor &&
            i.isMoved &&
            i.isTouched &&
            (!0 === e.allowSlideNext || !0 === e.allowSlidePrev) &&
            e.setGrabCursor(!1);
        var u,
            h = c.now(),
            p = h - i.touchStartTime;
        if (
            (e.allowClick &&
                (e.updateClickedSlide(d),
                    e.emit("tap click", d),
                    p < 300 &&
                    h - i.lastClickTime < 300 &&
                    e.emit("doubleTap doubleClick", d)),
                (i.lastClickTime = c.now()),
                c.nextTick(function() {
                    e.destroyed || (e.allowClick = !0);
                }), !i.isTouched ||
                !i.isMoved ||
                !e.swipeDirection ||
                0 === s.diff ||
                i.currentTranslate === i.startTranslate)
        )
            return (i.isTouched = !1), (i.isMoved = !1), void(i.startMoving = !1);
        if (
            ((i.isTouched = !1),
                (i.isMoved = !1),
                (i.startMoving = !1),
                (u = n.followFinger ?
                    a ?
                    e.translate :
                    -e.translate :
                    -i.currentTranslate), !n.cssMode)
        )
            if (n.freeMode) {
                if (u < -e.minTranslate()) return void e.slideTo(e.activeIndex);
                if (u > -e.maxTranslate())
                    return void(e.slides.length < l.length ?
                        e.slideTo(l.length - 1) :
                        e.slideTo(e.slides.length - 1));
                if (n.freeModeMomentum) {
                    if (i.velocities.length > 1) {
                        var f = i.velocities.pop(),
                            m = i.velocities.pop(),
                            v = f.position - m.position,
                            g = f.time - m.time;
                        (e.velocity = v / g),
                        (e.velocity /= 2),
                        Math.abs(e.velocity) < n.freeModeMinimumVelocity &&
                            (e.velocity = 0),
                            (g > 150 || c.now() - f.time > 300) && (e.velocity = 0);
                    } else e.velocity = 0;
                    (e.velocity *= n.freeModeMomentumVelocityRatio),
                    (i.velocities.length = 0);
                    var y = 1e3 * n.freeModeMomentumRatio,
                        b = e.velocity * y,
                        w = e.translate + b;
                    a && (w = -w);
                    var x,
                        T,
                        S = !1,
                        C = 20 * Math.abs(e.velocity) * n.freeModeMomentumBounceRatio;
                    if (w < e.maxTranslate())
                        n.freeModeMomentumBounce ?
                        (w + e.maxTranslate() < -C && (w = e.maxTranslate() - C),
                            (x = e.maxTranslate()),
                            (S = !0),
                            (i.allowMomentumBounce = !0)) :
                        (w = e.maxTranslate()),
                        n.loop && n.centeredSlides && (T = !0);
                    else if (w > e.minTranslate())
                        n.freeModeMomentumBounce ?
                        (w - e.minTranslate() > C && (w = e.minTranslate() + C),
                            (x = e.minTranslate()),
                            (S = !0),
                            (i.allowMomentumBounce = !0)) :
                        (w = e.minTranslate()),
                        n.loop && n.centeredSlides && (T = !0);
                    else if (n.freeModeSticky) {
                        for (var E, k = 0; k < l.length; k += 1)
                            if (l[k] > -w) {
                                E = k;
                                break;
                            }
                        w = -(w =
                            Math.abs(l[E] - w) < Math.abs(l[E - 1] - w) ||
                            "next" === e.swipeDirection ?
                            l[E] :
                            l[E - 1]);
                    }
                    if (
                        (T &&
                            e.once("transitionEnd", function() {
                                e.loopFix();
                            }),
                            0 !== e.velocity)
                    ) {
                        if (
                            ((y = a ?
                                    Math.abs((-w - e.translate) / e.velocity) :
                                    Math.abs((w - e.translate) / e.velocity)),
                                n.freeModeSticky)
                        ) {
                            var M = Math.abs((a ? -w : w) - e.translate),
                                _ = e.slidesSizesGrid[e.activeIndex];
                            y = M < _ ? n.speed : M < 2 * _ ? 1.5 * n.speed : 2.5 * n.speed;
                        }
                    } else if (n.freeModeSticky) return void e.slideToClosest();
                    n.freeModeMomentumBounce && S ?
                        (e.updateProgress(x),
                            e.setTransition(y),
                            e.setTranslate(w),
                            e.transitionStart(!0, e.swipeDirection),
                            (e.animating = !0),
                            r.transitionEnd(function() {
                                e &&
                                    !e.destroyed &&
                                    i.allowMomentumBounce &&
                                    (e.emit("momentumBounce"),
                                        e.setTransition(n.speed),
                                        setTimeout(function() {
                                            e.setTranslate(x),
                                                r.transitionEnd(function() {
                                                    e && !e.destroyed && e.transitionEnd();
                                                });
                                        }, 0));
                            })) :
                        e.velocity ?
                        (e.updateProgress(w),
                            e.setTransition(y),
                            e.setTranslate(w),
                            e.transitionStart(!0, e.swipeDirection),
                            e.animating ||
                            ((e.animating = !0),
                                r.transitionEnd(function() {
                                    e && !e.destroyed && e.transitionEnd();
                                }))) :
                        e.updateProgress(w),
                        e.updateActiveIndex(),
                        e.updateSlidesClasses();
                } else if (n.freeModeSticky) return void e.slideToClosest();
                (!n.freeModeMomentum || p >= n.longSwipesMs) &&
                (e.updateProgress(),
                    e.updateActiveIndex(),
                    e.updateSlidesClasses());
            } else {
                for (
                    var P = 0, $ = e.slidesSizesGrid[0], A = 0; A < o.length; A += A < n.slidesPerGroupSkip ? 1 : n.slidesPerGroup
                ) {
                    var L = A < n.slidesPerGroupSkip - 1 ? 1 : n.slidesPerGroup;
                    void 0 !== o[A + L] ?
                        u >= o[A] && u < o[A + L] && ((P = A), ($ = o[A + L] - o[A])) :
                        u >= o[A] && ((P = A), ($ = o[o.length - 1] - o[o.length - 2]));
                }
                var I = (u - o[P]) / $,
                    z = P < n.slidesPerGroupSkip - 1 ? 1 : n.slidesPerGroup;
                if (p > n.longSwipesMs) {
                    if (!n.longSwipes) return void e.slideTo(e.activeIndex);
                    "next" === e.swipeDirection &&
                        (I >= n.longSwipesRatio ? e.slideTo(P + z) : e.slideTo(P)),
                        "prev" === e.swipeDirection &&
                        (I > 1 - n.longSwipesRatio ? e.slideTo(P + z) : e.slideTo(P));
                } else {
                    if (!n.shortSwipes) return void e.slideTo(e.activeIndex);
                    !e.navigation ||
                        (d.target !== e.navigation.nextEl &&
                            d.target !== e.navigation.prevEl) ?
                        ("next" === e.swipeDirection && e.slideTo(P + z),
                            "prev" === e.swipeDirection && e.slideTo(P)) :
                        d.target === e.navigation.nextEl ?
                        e.slideTo(P + z) :
                        e.slideTo(P);
                }
            }
    }

    function R() {
        var t = this.params,
            e = this.el;
        if (!e || 0 !== e.offsetWidth) {
            t.breakpoints && this.setBreakpoint();
            var i = this.allowSlideNext,
                n = this.allowSlidePrev,
                s = this.snapGrid;
            (this.allowSlideNext = !0),
            (this.allowSlidePrev = !0),
            this.updateSize(),
                this.updateSlides(),
                this.updateSlidesClasses(),
                ("auto" === t.slidesPerView || t.slidesPerView > 1) &&
                this.isEnd &&
                !this.params.centeredSlides ?
                this.slideTo(this.slides.length - 1, 0, !1, !0) :
                this.slideTo(this.activeIndex, 0, !1, !0),
                this.autoplay &&
                this.autoplay.running &&
                this.autoplay.paused &&
                this.autoplay.run(),
                (this.allowSlidePrev = n),
                (this.allowSlideNext = i),
                this.params.watchOverflow &&
                s !== this.snapGrid &&
                this.checkOverflow();
        }
    }

    function B(t) {
        this.allowClick ||
            (this.params.preventClicks && t.preventDefault(),
                this.params.preventClicksPropagation &&
                this.animating &&
                (t.stopPropagation(), t.stopImmediatePropagation()));
    }

    function j() {
        var t = this.wrapperEl,
            e = this.rtlTranslate;
        (this.previousTranslate = this.translate),
        this.isHorizontal() ?
            (this.translate = e ?
                t.scrollWidth - t.offsetWidth - t.scrollLeft :
                -t.scrollLeft) :
            (this.translate = -t.scrollTop), -0 === this.translate && (this.translate = 0),
            this.updateActiveIndex(),
            this.updateSlidesClasses();
        var i = this.maxTranslate() - this.minTranslate();
        (0 === i ? 0 : (this.translate - this.minTranslate()) / i) !==
        this.progress &&
            this.updateProgress(e ? -this.translate : this.translate),
            this.emit("setTranslate", this.translate, !1);
    }
    var N = !1;

    function V() {}
    var H = {
            init: !0,
            direction: "horizontal",
            touchEventsTarget: "container",
            initialSlide: 0,
            speed: 300,
            cssMode: !1,
            updateOnWindowResize: !0,
            preventInteractionOnTransition: !1,
            edgeSwipeDetection: !1,
            edgeSwipeThreshold: 20,
            freeMode: !1,
            freeModeMomentum: !0,
            freeModeMomentumRatio: 1,
            freeModeMomentumBounce: !0,
            freeModeMomentumBounceRatio: 1,
            freeModeMomentumVelocityRatio: 1,
            freeModeSticky: !1,
            freeModeMinimumVelocity: 0.02,
            autoHeight: !1,
            setWrapperSize: !1,
            virtualTranslate: !1,
            effect: "slide",
            breakpoints: void 0,
            spaceBetween: 0,
            slidesPerView: 1,
            slidesPerColumn: 1,
            slidesPerColumnFill: "column",
            slidesPerGroup: 1,
            slidesPerGroupSkip: 0,
            centeredSlides: !1,
            centeredSlidesBounds: !1,
            slidesOffsetBefore: 0,
            slidesOffsetAfter: 0,
            normalizeSlideIndex: !0,
            centerInsufficientSlides: !1,
            watchOverflow: !1,
            roundLengths: !1,
            touchRatio: 1,
            touchAngle: 45,
            simulateTouch: !0,
            shortSwipes: !0,
            longSwipes: !0,
            longSwipesRatio: 0.5,
            longSwipesMs: 300,
            followFinger: !0,
            allowTouchMove: !0,
            threshold: 0,
            touchMoveStopPropagation: !1,
            touchStartPreventDefault: !0,
            touchStartForcePreventDefault: !1,
            touchReleaseOnEdges: !1,
            uniqueNavElements: !0,
            resistance: !0,
            resistanceRatio: 0.85,
            watchSlidesProgress: !1,
            watchSlidesVisibility: !1,
            grabCursor: !1,
            preventClicks: !0,
            preventClicksPropagation: !0,
            slideToClickedSlide: !1,
            preloadImages: !0,
            updateOnImagesReady: !0,
            loop: !1,
            loopAdditionalSlides: 0,
            loopedSlides: null,
            loopFillGroupWithBlank: !1,
            allowSlidePrev: !0,
            allowSlideNext: !0,
            swipeHandler: null,
            noSwiping: !0,
            noSwipingClass: "swiper-no-swiping",
            noSwipingSelector: null,
            passiveListeners: !0,
            containerModifierClass: "swiper-container-",
            slideClass: "swiper-slide",
            slideBlankClass: "swiper-slide-invisible-blank",
            slideActiveClass: "swiper-slide-active",
            slideDuplicateActiveClass: "swiper-slide-duplicate-active",
            slideVisibleClass: "swiper-slide-visible",
            slideDuplicateClass: "swiper-slide-duplicate",
            slideNextClass: "swiper-slide-next",
            slideDuplicateNextClass: "swiper-slide-duplicate-next",
            slidePrevClass: "swiper-slide-prev",
            slideDuplicatePrevClass: "swiper-slide-duplicate-prev",
            wrapperClass: "swiper-wrapper",
            runCallbacksOnInit: !0,
        },
        Y = {
            update: _,
            translate: P,
            transition: {
                setTransition: function(t, e) {
                    this.params.cssMode || this.$wrapperEl.transition(t),
                        this.emit("setTransition", t, e);
                },
                transitionStart: function(t, e) {
                    void 0 === t && (t = !0);
                    var i = this.activeIndex,
                        n = this.params,
                        s = this.previousIndex;
                    if (!n.cssMode) {
                        n.autoHeight && this.updateAutoHeight();
                        var a = e;
                        if (
                            (a || (a = i > s ? "next" : i < s ? "prev" : "reset"),
                                this.emit("transitionStart"),
                                t && i !== s)
                        ) {
                            if ("reset" === a)
                                return void this.emit("slideResetTransitionStart");
                            this.emit("slideChangeTransitionStart"),
                                "next" === a ?
                                this.emit("slideNextTransitionStart") :
                                this.emit("slidePrevTransitionStart");
                        }
                    }
                },
                transitionEnd: function(t, e) {
                    void 0 === t && (t = !0);
                    var i = this.activeIndex,
                        n = this.previousIndex,
                        s = this.params;
                    if (((this.animating = !1), !s.cssMode)) {
                        this.setTransition(0);
                        var a = e;
                        if (
                            (a || (a = i > n ? "next" : i < n ? "prev" : "reset"),
                                this.emit("transitionEnd"),
                                t && i !== n)
                        ) {
                            if ("reset" === a)
                                return void this.emit("slideResetTransitionEnd");
                            this.emit("slideChangeTransitionEnd"),
                                "next" === a ?
                                this.emit("slideNextTransitionEnd") :
                                this.emit("slidePrevTransitionEnd");
                        }
                    }
                },
            },
            slide: $,
            loop: A,
            grabCursor: L,
            manipulation: I,
            events: {
                attachEvents: function() {
                    var t = this.params,
                        e = this.touchEvents,
                        n = this.el,
                        s = this.wrapperEl;
                    (this.onTouchStart = O.bind(this)),
                    (this.onTouchMove = D.bind(this)),
                    (this.onTouchEnd = F.bind(this)),
                    t.cssMode && (this.onScroll = j.bind(this)),
                        (this.onClick = B.bind(this));
                    var a = !!t.nested;
                    if (!d.touch && d.pointerEvents)
                        n.addEventListener(e.start, this.onTouchStart, !1),
                        i.addEventListener(e.move, this.onTouchMove, a),
                        i.addEventListener(e.end, this.onTouchEnd, !1);
                    else {
                        if (d.touch) {
                            var r = !(
                                "touchstart" !== e.start ||
                                !d.passiveListener ||
                                !t.passiveListeners
                            ) && {
                                passive: !0,
                                capture: !1,
                            };
                            n.addEventListener(e.start, this.onTouchStart, r),
                                n.addEventListener(
                                    e.move,
                                    this.onTouchMove,
                                    d.passiveListener ? {
                                        passive: !1,
                                        capture: a,
                                    } :
                                    a
                                ),
                                n.addEventListener(e.end, this.onTouchEnd, r),
                                e.cancel && n.addEventListener(e.cancel, this.onTouchEnd, r),
                                N || (i.addEventListener("touchstart", V), (N = !0));
                        }
                        ((t.simulateTouch && !z.ios && !z.android) ||
                            (t.simulateTouch && !d.touch && z.ios)) &&
                        (n.addEventListener("mousedown", this.onTouchStart, !1),
                            i.addEventListener("mousemove", this.onTouchMove, a),
                            i.addEventListener("mouseup", this.onTouchEnd, !1));
                    }
                    (t.preventClicks || t.preventClicksPropagation) &&
                    n.addEventListener("click", this.onClick, !0),
                        t.cssMode && s.addEventListener("scroll", this.onScroll),
                        t.updateOnWindowResize ?
                        this.on(
                            z.ios || z.android ?
                            "resize orientationchange observerUpdate" :
                            "resize observerUpdate",
                            R, !0
                        ) :
                        this.on("observerUpdate", R, !0);
                },
                detachEvents: function() {
                    var t = this.params,
                        e = this.touchEvents,
                        n = this.el,
                        s = this.wrapperEl,
                        a = !!t.nested;
                    if (!d.touch && d.pointerEvents)
                        n.removeEventListener(e.start, this.onTouchStart, !1),
                        i.removeEventListener(e.move, this.onTouchMove, a),
                        i.removeEventListener(e.end, this.onTouchEnd, !1);
                    else {
                        if (d.touch) {
                            var r = !(
                                "onTouchStart" !== e.start ||
                                !d.passiveListener ||
                                !t.passiveListeners
                            ) && {
                                passive: !0,
                                capture: !1,
                            };
                            n.removeEventListener(e.start, this.onTouchStart, r),
                                n.removeEventListener(e.move, this.onTouchMove, a),
                                n.removeEventListener(e.end, this.onTouchEnd, r),
                                e.cancel &&
                                n.removeEventListener(e.cancel, this.onTouchEnd, r);
                        }
                        ((t.simulateTouch && !z.ios && !z.android) ||
                            (t.simulateTouch && !d.touch && z.ios)) &&
                        (n.removeEventListener("mousedown", this.onTouchStart, !1),
                            i.removeEventListener("mousemove", this.onTouchMove, a),
                            i.removeEventListener("mouseup", this.onTouchEnd, !1));
                    }
                    (t.preventClicks || t.preventClicksPropagation) &&
                    n.removeEventListener("click", this.onClick, !0),
                        t.cssMode && s.removeEventListener("scroll", this.onScroll),
                        this.off(
                            z.ios || z.android ?
                            "resize orientationchange observerUpdate" :
                            "resize observerUpdate",
                            R
                        );
                },
            },
            breakpoints: {
                setBreakpoint: function() {
                    var t = this.activeIndex,
                        e = this.initialized,
                        i = this.loopedSlides;
                    void 0 === i && (i = 0);
                    var n = this.params,
                        s = this.$el,
                        a = n.breakpoints;
                    if (a && (!a || 0 !== Object.keys(a).length)) {
                        var r = this.getBreakpoint(a);
                        if (r && this.currentBreakpoint !== r) {
                            var o = r in a ? a[r] : void 0;
                            o && [
                                "slidesPerView",
                                "spaceBetween",
                                "slidesPerGroup",
                                "slidesPerGroupSkip",
                                "slidesPerColumn",
                            ].forEach(function(t) {
                                var e = o[t];
                                void 0 !== e &&
                                    (o[t] =
                                        "slidesPerView" !== t || ("AUTO" !== e && "auto" !== e) ?
                                        "slidesPerView" === t ?
                                        parseFloat(e) :
                                        parseInt(e, 10) :
                                        "auto");
                            });
                            var l = o || this.originalParams,
                                d = n.slidesPerColumn > 1,
                                u = l.slidesPerColumn > 1;
                            d && !u ?
                                s.removeClass(
                                    n.containerModifierClass +
                                    "multirow " +
                                    n.containerModifierClass +
                                    "multirow-column"
                                ) :
                                !d &&
                                u &&
                                (s.addClass(n.containerModifierClass + "multirow"),
                                    "column" === l.slidesPerColumnFill &&
                                    s.addClass(n.containerModifierClass + "multirow-column"));
                            var h = l.direction && l.direction !== n.direction,
                                p = n.loop && (l.slidesPerView !== n.slidesPerView || h);
                            h && e && this.changeDirection(),
                                c.extend(this.params, l),
                                c.extend(this, {
                                    allowTouchMove: this.params.allowTouchMove,
                                    allowSlideNext: this.params.allowSlideNext,
                                    allowSlidePrev: this.params.allowSlidePrev,
                                }),
                                (this.currentBreakpoint = r),
                                p &&
                                e &&
                                (this.loopDestroy(),
                                    this.loopCreate(),
                                    this.updateSlides(),
                                    this.slideTo(t - i + this.loopedSlides, 0, !1)),
                                this.emit("breakpoint", l);
                        }
                    }
                },
                getBreakpoint: function(t) {
                    if (t) {
                        var e = !1,
                            i = Object.keys(t).map(function(t) {
                                if ("string" == typeof t && 0 === t.indexOf("@")) {
                                    var e = parseFloat(t.substr(1));
                                    return {
                                        value: s.innerHeight * e,
                                        point: t,
                                    };
                                }
                                return {
                                    value: t,
                                    point: t,
                                };
                            });
                        i.sort(function(t, e) {
                            return parseInt(t.value, 10) - parseInt(e.value, 10);
                        });
                        for (var n = 0; n < i.length; n += 1) {
                            var a = i[n],
                                r = a.point;
                            a.value <= s.innerWidth && (e = r);
                        }
                        return e || "max";
                    }
                },
            },
            checkOverflow: {
                checkOverflow: function() {
                    var t = this.params,
                        e = this.isLocked,
                        i =
                        this.slides.length > 0 &&
                        t.slidesOffsetBefore +
                        t.spaceBetween * (this.slides.length - 1) +
                        this.slides[0].offsetWidth * this.slides.length;
                    t.slidesOffsetBefore && t.slidesOffsetAfter && i ?
                        (this.isLocked = i <= this.size) :
                        (this.isLocked = 1 === this.snapGrid.length),
                        (this.allowSlideNext = !this.isLocked),
                        (this.allowSlidePrev = !this.isLocked),
                        e !== this.isLocked &&
                        this.emit(this.isLocked ? "lock" : "unlock"),
                        e &&
                        e !== this.isLocked &&
                        ((this.isEnd = !1), this.navigation.update());
                },
            },
            classes: {
                addClasses: function() {
                    var t = this.classNames,
                        e = this.params,
                        i = this.rtl,
                        n = this.$el,
                        s = [];
                    s.push("initialized"),
                        s.push(e.direction),
                        e.freeMode && s.push("free-mode"),
                        e.autoHeight && s.push("autoheight"),
                        i && s.push("rtl"),
                        e.slidesPerColumn > 1 &&
                        (s.push("multirow"),
                            "column" === e.slidesPerColumnFill &&
                            s.push("multirow-column")),
                        z.android && s.push("android"),
                        z.ios && s.push("ios"),
                        e.cssMode && s.push("css-mode"),
                        s.forEach(function(i) {
                            t.push(e.containerModifierClass + i);
                        }),
                        n.addClass(t.join(" "));
                },
                removeClasses: function() {
                    var t = this.$el,
                        e = this.classNames;
                    t.removeClass(e.join(" "));
                },
            },
            images: {
                loadImage: function(t, e, i, n, a, o) {
                    var l;

                    function c() {
                        o && o();
                    }
                    r(t).parent("picture")[0] || (t.complete && a) ?
                        c() :
                        e ?
                        (((l = new s.Image()).onload = c),
                            (l.onerror = c),
                            n && (l.sizes = n),
                            i && (l.srcset = i),
                            e && (l.src = e)) :
                        c();
                },
                preloadImages: function() {
                    var t = this;

                    function e() {
                        null != t &&
                            t &&
                            !t.destroyed &&
                            (void 0 !== t.imagesLoaded && (t.imagesLoaded += 1),
                                t.imagesLoaded === t.imagesToLoad.length &&
                                (t.params.updateOnImagesReady && t.update(),
                                    t.emit("imagesReady")));
                    }
                    t.imagesToLoad = t.$el.find("img");
                    for (var i = 0; i < t.imagesToLoad.length; i += 1) {
                        var n = t.imagesToLoad[i];
                        t.loadImage(
                            n,
                            n.currentSrc || n.getAttribute("src"),
                            n.srcset || n.getAttribute("srcset"),
                            n.sizes || n.getAttribute("sizes"), !0,
                            e
                        );
                    }
                },
            },
        },
        q = {},
        X = (function(t) {
            function e() {
                for (var i, n, s, a = [], o = arguments.length; o--;)
                    a[o] = arguments[o];
                1 === a.length && a[0].constructor && a[0].constructor === Object ?
                    (s = a[0]) :
                    ((n = (i = a)[0]), (s = i[1])),
                    s || (s = {}),
                    (s = c.extend({}, s)),
                    n && !s.el && (s.el = n),
                    t.call(this, s),
                    Object.keys(Y).forEach(function(t) {
                        Object.keys(Y[t]).forEach(function(i) {
                            e.prototype[i] || (e.prototype[i] = Y[t][i]);
                        });
                    });
                var l = this;
                void 0 === l.modules && (l.modules = {}),
                    Object.keys(l.modules).forEach(function(t) {
                        var e = l.modules[t];
                        if (e.params) {
                            var i = Object.keys(e.params)[0],
                                n = e.params[i];
                            if ("object" != typeof n || null === n) return;
                            if (!(i in s) || !("enabled" in n)) return;
                            !0 === s[i] &&
                                (s[i] = {
                                    enabled: !0,
                                }),
                                "object" != typeof s[i] ||
                                "enabled" in s[i] ||
                                (s[i].enabled = !0),
                                s[i] ||
                                (s[i] = {
                                    enabled: !1,
                                });
                        }
                    });
                var u = c.extend({}, H);
                l.useModulesParams(u),
                    (l.params = c.extend({}, u, q, s)),
                    (l.originalParams = c.extend({}, l.params)),
                    (l.passedParams = c.extend({}, s)),
                    (l.$ = r);
                var h = r(l.params.el);
                if ((n = h[0])) {
                    if (h.length > 1) {
                        var p = [];
                        return (
                            h.each(function(t, i) {
                                var n = c.extend({}, s, {
                                    el: i,
                                });
                                p.push(new e(n));
                            }),
                            p
                        );
                    }
                    var f, m, v;
                    return (
                        (n.swiper = l),
                        h.data("swiper", l),
                        n && n.shadowRoot && n.shadowRoot.querySelector ?
                        ((f = r(
                            n.shadowRoot.querySelector("." + l.params.wrapperClass)
                        )).children = function(t) {
                            return h.children(t);
                        }) :
                        (f = h.children("." + l.params.wrapperClass)),
                        c.extend(l, {
                            $el: h,
                            el: n,
                            $wrapperEl: f,
                            wrapperEl: f[0],
                            classNames: [],
                            slides: r(),
                            slidesGrid: [],
                            snapGrid: [],
                            slidesSizesGrid: [],
                            isHorizontal: function() {
                                return "horizontal" === l.params.direction;
                            },
                            isVertical: function() {
                                return "vertical" === l.params.direction;
                            },
                            rtl: "rtl" === n.dir.toLowerCase() || "rtl" === h.css("direction"),
                            rtlTranslate: "horizontal" === l.params.direction &&
                                ("rtl" === n.dir.toLowerCase() ||
                                    "rtl" === h.css("direction")),
                            wrongRTL: "-webkit-box" === f.css("display"),
                            activeIndex: 0,
                            realIndex: 0,
                            isBeginning: !0,
                            isEnd: !1,
                            translate: 0,
                            previousTranslate: 0,
                            progress: 0,
                            velocity: 0,
                            animating: !1,
                            allowSlideNext: l.params.allowSlideNext,
                            allowSlidePrev: l.params.allowSlidePrev,
                            touchEvents:
                                ((m = ["touchstart", "touchmove", "touchend", "touchcancel"]),
                                    (v = ["mousedown", "mousemove", "mouseup"]),
                                    d.pointerEvents &&
                                    (v = ["pointerdown", "pointermove", "pointerup"]),
                                    (l.touchEventsTouch = {
                                        start: m[0],
                                        move: m[1],
                                        end: m[2],
                                        cancel: m[3],
                                    }),
                                    (l.touchEventsDesktop = {
                                        start: v[0],
                                        move: v[1],
                                        end: v[2],
                                    }),
                                    d.touch || !l.params.simulateTouch ?
                                    l.touchEventsTouch :
                                    l.touchEventsDesktop),
                            touchEventsData: {
                                isTouched: void 0,
                                isMoved: void 0,
                                allowTouchCallbacks: void 0,
                                touchStartTime: void 0,
                                isScrolling: void 0,
                                currentTranslate: void 0,
                                startTranslate: void 0,
                                allowThresholdMove: void 0,
                                formElements: "input, select, option, textarea, button, video, label",
                                lastClickTime: c.now(),
                                clickTimeout: void 0,
                                velocities: [],
                                allowMomentumBounce: void 0,
                                isTouchEvent: void 0,
                                startMoving: void 0,
                            },
                            allowClick: !0,
                            allowTouchMove: l.params.allowTouchMove,
                            touches: {
                                startX: 0,
                                startY: 0,
                                currentX: 0,
                                currentY: 0,
                                diff: 0,
                            },
                            imagesToLoad: [],
                            imagesLoaded: 0,
                        }),
                        l.useModules(),
                        l.params.init && l.init(),
                        l
                    );
                }
            }
            t && (e.__proto__ = t),
                (e.prototype = Object.create(t && t.prototype)),
                (e.prototype.constructor = e);
            var i = {
                extendedDefaults: {
                    configurable: !0,
                },
                defaults: {
                    configurable: !0,
                },
                Class: {
                    configurable: !0,
                },
                $: {
                    configurable: !0,
                },
            };
            return (
                (e.prototype.slidesPerViewDynamic = function() {
                    var t = this.params,
                        e = this.slides,
                        i = this.slidesGrid,
                        n = this.size,
                        s = this.activeIndex,
                        a = 1;
                    if (t.centeredSlides) {
                        for (
                            var r, o = e[s].swiperSlideSize, l = s + 1; l < e.length; l += 1
                        )
                            e[l] &&
                            !r &&
                            ((a += 1), (o += e[l].swiperSlideSize) > n && (r = !0));
                        for (var c = s - 1; c >= 0; c -= 1)
                            e[c] &&
                            !r &&
                            ((a += 1), (o += e[c].swiperSlideSize) > n && (r = !0));
                    } else
                        for (var d = s + 1; d < e.length; d += 1)
                            i[d] - i[s] < n && (a += 1);
                    return a;
                }),
                (e.prototype.update = function() {
                    var t = this;
                    if (t && !t.destroyed) {
                        var e = t.snapGrid,
                            i = t.params;
                        i.breakpoints && t.setBreakpoint(),
                            t.updateSize(),
                            t.updateSlides(),
                            t.updateProgress(),
                            t.updateSlidesClasses(),
                            t.params.freeMode ?
                            (n(), t.params.autoHeight && t.updateAutoHeight()) :
                            (("auto" === t.params.slidesPerView ||
                                    t.params.slidesPerView > 1) &&
                                t.isEnd &&
                                !t.params.centeredSlides ?
                                t.slideTo(t.slides.length - 1, 0, !1, !0) :
                                t.slideTo(t.activeIndex, 0, !1, !0)) || n(),
                            i.watchOverflow && e !== t.snapGrid && t.checkOverflow(),
                            t.emit("update");
                    }

                    function n() {
                        var e = t.rtlTranslate ? -1 * t.translate : t.translate,
                            i = Math.min(Math.max(e, t.maxTranslate()), t.minTranslate());
                        t.setTranslate(i), t.updateActiveIndex(), t.updateSlidesClasses();
                    }
                }),
                (e.prototype.changeDirection = function(t, e) {
                    void 0 === e && (e = !0);
                    var i = this.params.direction;
                    return (
                        t || (t = "horizontal" === i ? "vertical" : "horizontal"),
                        t === i ||
                        ("horizontal" !== t && "vertical" !== t) ||
                        (this.$el
                            .removeClass("" + this.params.containerModifierClass + i)
                            .addClass("" + this.params.containerModifierClass + t),
                            (this.params.direction = t),
                            this.slides.each(function(e, i) {
                                "vertical" === t
                                    ?
                                    (i.style.width = "") :
                                    (i.style.height = "");
                            }),
                            this.emit("changeDirection"),
                            e && this.update()),
                        this
                    );
                }),
                (e.prototype.init = function() {
                    this.initialized ||
                        (this.emit("beforeInit"),
                            this.params.breakpoints && this.setBreakpoint(),
                            this.addClasses(),
                            this.params.loop && this.loopCreate(),
                            this.updateSize(),
                            this.updateSlides(),
                            this.params.watchOverflow && this.checkOverflow(),
                            this.params.grabCursor && this.setGrabCursor(),
                            this.params.preloadImages && this.preloadImages(),
                            this.params.loop ?
                            this.slideTo(
                                this.params.initialSlide + this.loopedSlides,
                                0,
                                this.params.runCallbacksOnInit
                            ) :
                            this.slideTo(
                                this.params.initialSlide,
                                0,
                                this.params.runCallbacksOnInit
                            ),
                            this.attachEvents(),
                            (this.initialized = !0),
                            this.emit("init"));
                }),
                (e.prototype.destroy = function(t, e) {
                    void 0 === t && (t = !0), void 0 === e && (e = !0);
                    var i = this,
                        n = i.params,
                        s = i.$el,
                        a = i.$wrapperEl,
                        r = i.slides;
                    return (
                        void 0 === i.params ||
                        i.destroyed ||
                        (i.emit("beforeDestroy"),
                            (i.initialized = !1),
                            i.detachEvents(),
                            n.loop && i.loopDestroy(),
                            e &&
                            (i.removeClasses(),
                                s.removeAttr("style"),
                                a.removeAttr("style"),
                                r &&
                                r.length &&
                                r
                                .removeClass(
                                    [
                                        n.slideVisibleClass,
                                        n.slideActiveClass,
                                        n.slideNextClass,
                                        n.slidePrevClass,
                                    ].join(" ")
                                )
                                .removeAttr("style")
                                .removeAttr("data-swiper-slide-index")),
                            i.emit("destroy"),
                            Object.keys(i.eventsListeners).forEach(function(t) {
                                i.off(t);
                            }), !1 !== t &&
                            ((i.$el[0].swiper = null),
                                i.$el.data("swiper", null),
                                c.deleteProps(i)),
                            (i.destroyed = !0)),
                        null
                    );
                }),
                (e.extendDefaults = function(t) {
                    c.extend(q, t);
                }),
                (i.extendedDefaults.get = function() {
                    return q;
                }),
                (i.defaults.get = function() {
                    return H;
                }),
                (i.Class.get = function() {
                    return t;
                }),
                (i.$.get = function() {
                    return r;
                }),
                Object.defineProperties(e, i),
                e
            );
        })(u),
        W = {
            name: "device",
            proto: {
                device: z,
            },
            static: {
                device: z,
            },
        },
        G = {
            name: "support",
            proto: {
                support: d,
            },
            static: {
                support: d,
            },
        },
        U = {
            isEdge: !!s.navigator.userAgent.match(/Edge/g),
            isSafari: (function() {
                var t = s.navigator.userAgent.toLowerCase();
                return (
                    t.indexOf("safari") >= 0 &&
                    t.indexOf("chrome") < 0 &&
                    t.indexOf("android") < 0
                );
            })(),
            isUiWebView: /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(
                s.navigator.userAgent
            ),
        },
        K = {
            name: "browser",
            proto: {
                browser: U,
            },
            static: {
                browser: U,
            },
        },
        Q = {
            name: "resize",
            create: function() {
                var t = this;
                c.extend(t, {
                    resize: {
                        resizeHandler: function() {
                            t &&
                                !t.destroyed &&
                                t.initialized &&
                                (t.emit("beforeResize"), t.emit("resize"));
                        },
                        orientationChangeHandler: function() {
                            t &&
                                !t.destroyed &&
                                t.initialized &&
                                t.emit("orientationchange");
                        },
                    },
                });
            },
            on: {
                init: function() {
                    s.addEventListener("resize", this.resize.resizeHandler),
                        s.addEventListener(
                            "orientationchange",
                            this.resize.orientationChangeHandler
                        );
                },
                destroy: function() {
                    s.removeEventListener("resize", this.resize.resizeHandler),
                        s.removeEventListener(
                            "orientationchange",
                            this.resize.orientationChangeHandler
                        );
                },
            },
        },
        Z = {
            func: s.MutationObserver || s.WebkitMutationObserver,
            attach: function(t, e) {
                void 0 === e && (e = {});
                var i = this,
                    n = new(0, Z.func)(function(t) {
                        if (1 !== t.length) {
                            var e = function() {
                                i.emit("observerUpdate", t[0]);
                            };
                            s.requestAnimationFrame ?
                                s.requestAnimationFrame(e) :
                                s.setTimeout(e, 0);
                        } else i.emit("observerUpdate", t[0]);
                    });
                n.observe(t, {
                        attributes: void 0 === e.attributes || e.attributes,
                        childList: void 0 === e.childList || e.childList,
                        characterData: void 0 === e.characterData || e.characterData,
                    }),
                    i.observer.observers.push(n);
            },
            init: function() {
                if (d.observer && this.params.observer) {
                    if (this.params.observeParents)
                        for (var t = this.$el.parents(), e = 0; e < t.length; e += 1)
                            this.observer.attach(t[e]);
                    this.observer.attach(this.$el[0], {
                            childList: this.params.observeSlideChildren,
                        }),
                        this.observer.attach(this.$wrapperEl[0], {
                            attributes: !1,
                        });
                }
            },
            destroy: function() {
                this.observer.observers.forEach(function(t) {
                        t.disconnect();
                    }),
                    (this.observer.observers = []);
            },
        },
        J = {
            name: "observer",
            params: {
                observer: !1,
                observeParents: !1,
                observeSlideChildren: !1,
            },
            create: function() {
                c.extend(this, {
                    observer: {
                        init: Z.init.bind(this),
                        attach: Z.attach.bind(this),
                        destroy: Z.destroy.bind(this),
                        observers: [],
                    },
                });
            },
            on: {
                init: function() {
                    this.observer.init();
                },
                destroy: function() {
                    this.observer.destroy();
                },
            },
        },
        tt = {
            update: function(t) {
                var e = this,
                    i = e.params,
                    n = i.slidesPerView,
                    s = i.slidesPerGroup,
                    a = i.centeredSlides,
                    r = e.params.virtual,
                    o = r.addSlidesBefore,
                    l = r.addSlidesAfter,
                    d = e.virtual,
                    u = d.from,
                    h = d.to,
                    p = d.slides,
                    f = d.slidesGrid,
                    m = d.renderSlide,
                    v = d.offset;
                e.updateActiveIndex();
                var g,
                    y,
                    b,
                    w = e.activeIndex || 0;
                (g = e.rtlTranslate ? "right" : e.isHorizontal() ? "left" : "top"),
                a
                    ?
                    ((y = Math.floor(n / 2) + s + o),
                        (b = Math.floor(n / 2) + s + l)) :
                    ((y = n + (s - 1) + o), (b = s + l));
                var x = Math.max((w || 0) - b, 0),
                    T = Math.min((w || 0) + y, p.length - 1),
                    S = (e.slidesGrid[x] || 0) - (e.slidesGrid[0] || 0);

                function C() {
                    e.updateSlides(),
                        e.updateProgress(),
                        e.updateSlidesClasses(),
                        e.lazy && e.params.lazy.enabled && e.lazy.load();
                }
                if (
                    (c.extend(e.virtual, {
                            from: x,
                            to: T,
                            offset: S,
                            slidesGrid: e.slidesGrid,
                        }),
                        u === x && h === T && !t)
                )
                    return (
                        e.slidesGrid !== f && S !== v && e.slides.css(g, S + "px"),
                        void e.updateProgress()
                    );
                if (e.params.virtual.renderExternal)
                    return (
                        e.params.virtual.renderExternal.call(e, {
                            offset: S,
                            from: x,
                            to: T,
                            slides: (function() {
                                for (var t = [], e = x; e <= T; e += 1) t.push(p[e]);
                                return t;
                            })(),
                        }),
                        void C()
                    );
                var E = [],
                    k = [];
                if (t) e.$wrapperEl.find("." + e.params.slideClass).remove();
                else
                    for (var M = u; M <= h; M += 1)
                        (M < x || M > T) &&
                        e.$wrapperEl
                        .find(
                            "." +
                            e.params.slideClass +
                            '[data-swiper-slide-index="' +
                            M +
                            '"]'
                        )
                        .remove();
                for (var _ = 0; _ < p.length; _ += 1)
                    _ >= x &&
                    _ <= T &&
                    (void 0 === h || t ?
                        k.push(_) :
                        (_ > h && k.push(_), _ < u && E.push(_)));
                k.forEach(function(t) {
                        e.$wrapperEl.append(m(p[t], t));
                    }),
                    E.sort(function(t, e) {
                        return e - t;
                    }).forEach(function(t) {
                        e.$wrapperEl.prepend(m(p[t], t));
                    }),
                    e.$wrapperEl.children(".swiper-slide").css(g, S + "px"),
                    C();
            },
            renderSlide: function(t, e) {
                var i = this.params.virtual;
                if (i.cache && this.virtual.cache[e]) return this.virtual.cache[e];
                var n = i.renderSlide ?
                    r(i.renderSlide.call(this, t, e)) :
                    r(
                        '<div class="' +
                        this.params.slideClass +
                        '" data-swiper-slide-index="' +
                        e +
                        '">' +
                        t +
                        "</div>"
                    );
                return (
                    n.attr("data-swiper-slide-index") ||
                    n.attr("data-swiper-slide-index", e),
                    i.cache && (this.virtual.cache[e] = n),
                    n
                );
            },
            appendSlide: function(t) {
                if ("object" == typeof t && "length" in t)
                    for (var e = 0; e < t.length; e += 1)
                        t[e] && this.virtual.slides.push(t[e]);
                else this.virtual.slides.push(t);
                this.virtual.update(!0);
            },
            prependSlide: function(t) {
                var e = this.activeIndex,
                    i = e + 1,
                    n = 1;
                if (Array.isArray(t)) {
                    for (var s = 0; s < t.length; s += 1)
                        t[s] && this.virtual.slides.unshift(t[s]);
                    (i = e + t.length), (n = t.length);
                } else this.virtual.slides.unshift(t);
                if (this.params.virtual.cache) {
                    var a = this.virtual.cache,
                        r = {};
                    Object.keys(a).forEach(function(t) {
                            var e = a[t],
                                i = e.attr("data-swiper-slide-index");
                            i && e.attr("data-swiper-slide-index", parseInt(i, 10) + 1),
                                (r[parseInt(t, 10) + n] = e);
                        }),
                        (this.virtual.cache = r);
                }
                this.virtual.update(!0), this.slideTo(i, 0);
            },
            removeSlide: function(t) {
                if (null != t) {
                    var e = this.activeIndex;
                    if (Array.isArray(t))
                        for (var i = t.length - 1; i >= 0; i -= 1)
                            this.virtual.slides.splice(t[i], 1),
                            this.params.virtual.cache && delete this.virtual.cache[t[i]],
                            t[i] < e && (e -= 1),
                            (e = Math.max(e, 0));
                    else
                        this.virtual.slides.splice(t, 1),
                        this.params.virtual.cache && delete this.virtual.cache[t],
                        t < e && (e -= 1),
                        (e = Math.max(e, 0));
                    this.virtual.update(!0), this.slideTo(e, 0);
                }
            },
            removeAllSlides: function() {
                (this.virtual.slides = []),
                this.params.virtual.cache && (this.virtual.cache = {}),
                    this.virtual.update(!0),
                    this.slideTo(0, 0);
            },
        },
        et = {
            name: "virtual",
            params: {
                virtual: {
                    enabled: !1,
                    slides: [],
                    cache: !0,
                    renderSlide: null,
                    renderExternal: null,
                    addSlidesBefore: 0,
                    addSlidesAfter: 0,
                },
            },
            create: function() {
                c.extend(this, {
                    virtual: {
                        update: tt.update.bind(this),
                        appendSlide: tt.appendSlide.bind(this),
                        prependSlide: tt.prependSlide.bind(this),
                        removeSlide: tt.removeSlide.bind(this),
                        removeAllSlides: tt.removeAllSlides.bind(this),
                        renderSlide: tt.renderSlide.bind(this),
                        slides: this.params.virtual.slides,
                        cache: {},
                    },
                });
            },
            on: {
                beforeInit: function() {
                    if (this.params.virtual.enabled) {
                        this.classNames.push(
                            this.params.containerModifierClass + "virtual"
                        );
                        var t = {
                            watchSlidesProgress: !0,
                        };
                        c.extend(this.params, t),
                            c.extend(this.originalParams, t),
                            this.params.initialSlide || this.virtual.update();
                    }
                },
                setTranslate: function() {
                    this.params.virtual.enabled && this.virtual.update();
                },
            },
        },
        it = {
            handle: function(t) {
                var e = this.rtlTranslate,
                    n = t;
                n.originalEvent && (n = n.originalEvent);
                var a = n.keyCode || n.charCode;
                if (!this.allowSlideNext &&
                    ((this.isHorizontal() && 39 === a) ||
                        (this.isVertical() && 40 === a) ||
                        34 === a)
                )
                    return !1;
                if (!this.allowSlidePrev &&
                    ((this.isHorizontal() && 37 === a) ||
                        (this.isVertical() && 38 === a) ||
                        33 === a)
                )
                    return !1;
                if (!(
                        n.shiftKey ||
                        n.altKey ||
                        n.ctrlKey ||
                        n.metaKey ||
                        (i.activeElement &&
                            i.activeElement.nodeName &&
                            ("input" === i.activeElement.nodeName.toLowerCase() ||
                                "textarea" === i.activeElement.nodeName.toLowerCase()))
                    )) {
                    if (
                        this.params.keyboard.onlyInViewport &&
                        (33 === a ||
                            34 === a ||
                            37 === a ||
                            39 === a ||
                            38 === a ||
                            40 === a)
                    ) {
                        var r = !1;
                        if (
                            this.$el.parents("." + this.params.slideClass).length > 0 &&
                            0 ===
                            this.$el.parents("." + this.params.slideActiveClass).length
                        )
                            return;
                        var o = s.innerWidth,
                            l = s.innerHeight,
                            c = this.$el.offset();
                        e && (c.left -= this.$el[0].scrollLeft);
                        for (
                            var d = [
                                    [c.left, c.top],
                                    [c.left + this.width, c.top],
                                    [c.left, c.top + this.height],
                                    [c.left + this.width, c.top + this.height],
                                ],
                                u = 0; u < d.length; u += 1
                        ) {
                            var h = d[u];
                            h[0] >= 0 && h[0] <= o && h[1] >= 0 && h[1] <= l && (r = !0);
                        }
                        if (!r) return;
                    }
                    this.isHorizontal() ?
                        ((33 !== a && 34 !== a && 37 !== a && 39 !== a) ||
                            (n.preventDefault ?
                                n.preventDefault() :
                                (n.returnValue = !1)),
                            (((34 !== a && 39 !== a) || e) &&
                                ((33 !== a && 37 !== a) || !e)) ||
                            this.slideNext(),
                            (((33 !== a && 37 !== a) || e) &&
                                ((34 !== a && 39 !== a) || !e)) ||
                            this.slidePrev()) :
                        ((33 !== a && 34 !== a && 38 !== a && 40 !== a) ||
                            (n.preventDefault ?
                                n.preventDefault() :
                                (n.returnValue = !1)),
                            (34 !== a && 40 !== a) || this.slideNext(),
                            (33 !== a && 38 !== a) || this.slidePrev()),
                        this.emit("keyPress", a);
                }
            },
            enable: function() {
                this.keyboard.enabled ||
                    (r(i).on("keydown", this.keyboard.handle),
                        (this.keyboard.enabled = !0));
            },
            disable: function() {
                this.keyboard.enabled &&
                    (r(i).off("keydown", this.keyboard.handle),
                        (this.keyboard.enabled = !1));
            },
        },
        nt = {
            name: "keyboard",
            params: {
                keyboard: {
                    enabled: !1,
                    onlyInViewport: !0,
                },
            },
            create: function() {
                c.extend(this, {
                    keyboard: {
                        enabled: !1,
                        enable: it.enable.bind(this),
                        disable: it.disable.bind(this),
                        handle: it.handle.bind(this),
                    },
                });
            },
            on: {
                init: function() {
                    this.params.keyboard.enabled && this.keyboard.enable();
                },
                destroy: function() {
                    this.keyboard.enabled && this.keyboard.disable();
                },
            },
        },
        st = {
            lastScrollTime: c.now(),
            lastEventBeforeSnap: void 0,
            recentWheelEvents: [],
            event: function() {
                return s.navigator.userAgent.indexOf("firefox") > -1 ?
                    "DOMMouseScroll" :
                    (function() {
                        var t = "onwheel" in i;
                        if (!t) {
                            var e = i.createElement("div");
                            e.setAttribute("onwheel", "return;"),
                                (t = "function" == typeof e.onwheel);
                        }
                        return (!t &&
                            i.implementation &&
                            i.implementation.hasFeature &&
                            !0 !== i.implementation.hasFeature("", "") &&
                            (t = i.implementation.hasFeature("Events.wheel", "3.0")),
                            t
                        );
                    })() ?
                    "wheel" :
                    "mousewheel";
            },
            normalize: function(t) {
                var e = 0,
                    i = 0,
                    n = 0,
                    s = 0;
                return (
                    "detail" in t && (i = t.detail),
                    "wheelDelta" in t && (i = -t.wheelDelta / 120),
                    "wheelDeltaY" in t && (i = -t.wheelDeltaY / 120),
                    "wheelDeltaX" in t && (e = -t.wheelDeltaX / 120),
                    "axis" in t && t.axis === t.HORIZONTAL_AXIS && ((e = i), (i = 0)),
                    (n = 10 * e),
                    (s = 10 * i),
                    "deltaY" in t && (s = t.deltaY),
                    "deltaX" in t && (n = t.deltaX),
                    t.shiftKey && !n && ((n = s), (s = 0)),
                    (n || s) &&
                    t.deltaMode &&
                    (1 === t.deltaMode ?
                        ((n *= 40), (s *= 40)) :
                        ((n *= 800), (s *= 800))),
                    n && !e && (e = n < 1 ? -1 : 1),
                    s && !i && (i = s < 1 ? -1 : 1), {
                        spinX: e,
                        spinY: i,
                        pixelX: n,
                        pixelY: s,
                    }
                );
            },
            handleMouseEnter: function() {
                this.mouseEntered = !0;
            },
            handleMouseLeave: function() {
                this.mouseEntered = !1;
            },
            handle: function(t) {
                var e = t,
                    i = this,
                    n = i.params.mousewheel;
                i.params.cssMode && e.preventDefault();
                var s = i.$el;
                if (
                    ("container" !== i.params.mousewheel.eventsTarged &&
                        (s = r(i.params.mousewheel.eventsTarged)), !i.mouseEntered && !s[0].contains(e.target) && !n.releaseOnEdges)
                )
                    return !0;
                e.originalEvent && (e = e.originalEvent);
                var a = 0,
                    o = i.rtlTranslate ? -1 : 1,
                    l = st.normalize(e);
                if (n.forceToAxis)
                    if (i.isHorizontal()) {
                        if (!(Math.abs(l.pixelX) > Math.abs(l.pixelY))) return !0;
                        a = l.pixelX * o;
                    } else {
                        if (!(Math.abs(l.pixelY) > Math.abs(l.pixelX))) return !0;
                        a = l.pixelY;
                    }
                else
                    a =
                    Math.abs(l.pixelX) > Math.abs(l.pixelY) ?
                    -l.pixelX * o :
                    -l.pixelY;
                if (0 === a) return !0;
                if ((n.invert && (a = -a), i.params.freeMode)) {
                    var d = {
                            time: c.now(),
                            delta: Math.abs(a),
                            direction: Math.sign(a),
                        },
                        u = i.mousewheel.lastEventBeforeSnap,
                        h =
                        u &&
                        d.time < u.time + 500 &&
                        d.delta <= u.delta &&
                        d.direction === u.direction;
                    if (!h) {
                        (i.mousewheel.lastEventBeforeSnap = void 0),
                        i.params.loop && i.loopFix();
                        var p = i.getTranslate() + a * n.sensitivity,
                            f = i.isBeginning,
                            m = i.isEnd;
                        if (
                            (p >= i.minTranslate() && (p = i.minTranslate()),
                                p <= i.maxTranslate() && (p = i.maxTranslate()),
                                i.setTransition(0),
                                i.setTranslate(p),
                                i.updateProgress(),
                                i.updateActiveIndex(),
                                i.updateSlidesClasses(),
                                ((!f && i.isBeginning) || (!m && i.isEnd)) &&
                                i.updateSlidesClasses(),
                                i.params.freeModeSticky)
                        ) {
                            clearTimeout(i.mousewheel.timeout),
                                (i.mousewheel.timeout = void 0);
                            var v = i.mousewheel.recentWheelEvents;
                            v.length >= 15 && v.shift();
                            var g = v.length ? v[v.length - 1] : void 0,
                                y = v[0];
                            if (
                                (v.push(d),
                                    g && (d.delta > g.delta || d.direction !== g.direction))
                            )
                                v.splice(0);
                            else if (
                                v.length >= 15 &&
                                d.time - y.time < 500 &&
                                y.delta - d.delta >= 1 &&
                                d.delta <= 6
                            ) {
                                var b = a > 0 ? 0.8 : 0.2;
                                (i.mousewheel.lastEventBeforeSnap = d),
                                v.splice(0),
                                    (i.mousewheel.timeout = c.nextTick(function() {
                                        i.slideToClosest(i.params.speed, !0, void 0, b);
                                    }, 0));
                            }
                            i.mousewheel.timeout ||
                                (i.mousewheel.timeout = c.nextTick(function() {
                                    (i.mousewheel.lastEventBeforeSnap = d),
                                    v.splice(0),
                                        i.slideToClosest(i.params.speed, !0, void 0, 0.5);
                                }, 500));
                        }
                        if (
                            (h || i.emit("scroll", e),
                                i.params.autoplay &&
                                i.params.autoplayDisableOnInteraction &&
                                i.autoplay.stop(),
                                p === i.minTranslate() || p === i.maxTranslate())
                        )
                            return !0;
                    }
                } else {
                    var w = {
                            time: c.now(),
                            delta: Math.abs(a),
                            direction: Math.sign(a),
                            raw: t,
                        },
                        x = i.mousewheel.recentWheelEvents;
                    x.length >= 2 && x.shift();
                    var T = x.length ? x[x.length - 1] : void 0;
                    if (
                        (x.push(w),
                            T ?
                            (w.direction !== T.direction ||
                                w.delta > T.delta ||
                                w.time > T.time + 150) &&
                            i.mousewheel.animateSlider(w) :
                            i.mousewheel.animateSlider(w),
                            i.mousewheel.releaseScroll(w))
                    )
                        return !0;
                }
                return (
                    e.preventDefault ? e.preventDefault() : (e.returnValue = !1), !1
                );
            },
            animateSlider: function(t) {
                return (
                    (t.delta >= 6 && c.now() - this.mousewheel.lastScrollTime < 60) ||
                    (t.direction < 0 ?
                        (this.isEnd && !this.params.loop) ||
                        this.animating ||
                        (this.slideNext(), this.emit("scroll", t.raw)) :
                        (this.isBeginning && !this.params.loop) ||
                        this.animating ||
                        (this.slidePrev(), this.emit("scroll", t.raw)),
                        (this.mousewheel.lastScrollTime = new s.Date().getTime()), !1)
                );
            },
            releaseScroll: function(t) {
                var e = this.params.mousewheel;
                if (t.direction < 0) {
                    if (this.isEnd && !this.params.loop && e.releaseOnEdges) return !0;
                } else if (this.isBeginning && !this.params.loop && e.releaseOnEdges)
                    return !0;
                return !1;
            },
            enable: function() {
                var t = st.event();
                if (this.params.cssMode)
                    return (
                        this.wrapperEl.removeEventListener(t, this.mousewheel.handle), !0
                    );
                if (!t) return !1;
                if (this.mousewheel.enabled) return !1;
                var e = this.$el;
                return (
                    "container" !== this.params.mousewheel.eventsTarged &&
                    (e = r(this.params.mousewheel.eventsTarged)),
                    e.on("mouseenter", this.mousewheel.handleMouseEnter),
                    e.on("mouseleave", this.mousewheel.handleMouseLeave),
                    e.on(t, this.mousewheel.handle),
                    (this.mousewheel.enabled = !0), !0
                );
            },
            disable: function() {
                var t = st.event();
                if (this.params.cssMode)
                    return (
                        this.wrapperEl.addEventListener(t, this.mousewheel.handle), !0
                    );
                if (!t) return !1;
                if (!this.mousewheel.enabled) return !1;
                var e = this.$el;
                return (
                    "container" !== this.params.mousewheel.eventsTarged &&
                    (e = r(this.params.mousewheel.eventsTarged)),
                    e.off(t, this.mousewheel.handle),
                    (this.mousewheel.enabled = !1), !0
                );
            },
        },
        at = {
            update: function() {
                var t = this.params.navigation;
                if (!this.params.loop) {
                    var e = this.navigation,
                        i = e.$nextEl,
                        n = e.$prevEl;
                    n &&
                        n.length > 0 &&
                        (this.isBeginning ?
                            n.addClass(t.disabledClass) :
                            n.removeClass(t.disabledClass),
                            n[
                                this.params.watchOverflow && this.isLocked ?
                                "addClass" :
                                "removeClass"
                            ](t.lockClass)),
                        i &&
                        i.length > 0 &&
                        (this.isEnd ?
                            i.addClass(t.disabledClass) :
                            i.removeClass(t.disabledClass),
                            i[
                                this.params.watchOverflow && this.isLocked ?
                                "addClass" :
                                "removeClass"
                            ](t.lockClass));
                }
            },
            onPrevClick: function(t) {
                t.preventDefault(),
                    (this.isBeginning && !this.params.loop) || this.slidePrev();
            },
            onNextClick: function(t) {
                t.preventDefault(),
                    (this.isEnd && !this.params.loop) || this.slideNext();
            },
            init: function() {
                var t,
                    e,
                    i = this.params.navigation;
                (i.nextEl || i.prevEl) &&
                (i.nextEl &&
                    ((t = r(i.nextEl)),
                        this.params.uniqueNavElements &&
                        "string" == typeof i.nextEl &&
                        t.length > 1 &&
                        1 === this.$el.find(i.nextEl).length &&
                        (t = this.$el.find(i.nextEl))),
                    i.prevEl &&
                    ((e = r(i.prevEl)),
                        this.params.uniqueNavElements &&
                        "string" == typeof i.prevEl &&
                        e.length > 1 &&
                        1 === this.$el.find(i.prevEl).length &&
                        (e = this.$el.find(i.prevEl))),
                    t && t.length > 0 && t.on("click", this.navigation.onNextClick),
                    e && e.length > 0 && e.on("click", this.navigation.onPrevClick),
                    c.extend(this.navigation, {
                        $nextEl: t,
                        nextEl: t && t[0],
                        $prevEl: e,
                        prevEl: e && e[0],
                    }));
            },
            destroy: function() {
                var t = this.navigation,
                    e = t.$nextEl,
                    i = t.$prevEl;
                e &&
                    e.length &&
                    (e.off("click", this.navigation.onNextClick),
                        e.removeClass(this.params.navigation.disabledClass)),
                    i &&
                    i.length &&
                    (i.off("click", this.navigation.onPrevClick),
                        i.removeClass(this.params.navigation.disabledClass));
            },
        },
        rt = {
            update: function() {
                var t = this.rtl,
                    e = this.params.pagination;
                if (
                    e.el &&
                    this.pagination.el &&
                    this.pagination.$el &&
                    0 !== this.pagination.$el.length
                ) {
                    var i,
                        n =
                        this.virtual && this.params.virtual.enabled ?
                        this.virtual.slides.length :
                        this.slides.length,
                        s = this.pagination.$el,
                        a = this.params.loop ?
                        Math.ceil(
                            (n - 2 * this.loopedSlides) / this.params.slidesPerGroup
                        ) :
                        this.snapGrid.length;
                    if (
                        (this.params.loop ?
                            ((i = Math.ceil(
                                    (this.activeIndex - this.loopedSlides) /
                                    this.params.slidesPerGroup
                                )) >
                                n - 1 - 2 * this.loopedSlides &&
                                (i -= n - 2 * this.loopedSlides),
                                i > a - 1 && (i -= a),
                                i < 0 &&
                                "bullets" !== this.params.paginationType &&
                                (i = a + i)) :
                            (i =
                                void 0 !== this.snapIndex ?
                                this.snapIndex :
                                this.activeIndex || 0),
                            "bullets" === e.type &&
                            this.pagination.bullets &&
                            this.pagination.bullets.length > 0)
                    ) {
                        var o,
                            l,
                            c,
                            d = this.pagination.bullets;
                        if (
                            (e.dynamicBullets &&
                                ((this.pagination.bulletSize = d
                                        .eq(0)[this.isHorizontal() ? "outerWidth" : "outerHeight"](!0)),
                                    s.css(
                                        this.isHorizontal() ? "width" : "height",
                                        this.pagination.bulletSize * (e.dynamicMainBullets + 4) +
                                        "px"
                                    ),
                                    e.dynamicMainBullets > 1 &&
                                    void 0 !== this.previousIndex &&
                                    ((this.pagination.dynamicBulletIndex +=
                                            i - this.previousIndex),
                                        this.pagination.dynamicBulletIndex >
                                        e.dynamicMainBullets - 1 ?
                                        (this.pagination.dynamicBulletIndex =
                                            e.dynamicMainBullets - 1) :
                                        this.pagination.dynamicBulletIndex < 0 &&
                                        (this.pagination.dynamicBulletIndex = 0)),
                                    (o = i - this.pagination.dynamicBulletIndex),
                                    (c =
                                        ((l = o + (Math.min(d.length, e.dynamicMainBullets) - 1)) +
                                            o) /
                                        2)),
                                d.removeClass(
                                    e.bulletActiveClass +
                                    " " +
                                    e.bulletActiveClass +
                                    "-next " +
                                    e.bulletActiveClass +
                                    "-next-next " +
                                    e.bulletActiveClass +
                                    "-prev " +
                                    e.bulletActiveClass +
                                    "-prev-prev " +
                                    e.bulletActiveClass +
                                    "-main"
                                ),
                                s.length > 1)
                        )
                            d.each(function(t, n) {
                                var s = r(n),
                                    a = s.index();
                                a === i && s.addClass(e.bulletActiveClass),
                                    e.dynamicBullets &&
                                    (a >= o &&
                                        a <= l &&
                                        s.addClass(e.bulletActiveClass + "-main"),
                                        a === o &&
                                        s
                                        .prev()
                                        .addClass(e.bulletActiveClass + "-prev")
                                        .prev()
                                        .addClass(e.bulletActiveClass + "-prev-prev"),
                                        a === l &&
                                        s
                                        .next()
                                        .addClass(e.bulletActiveClass + "-next")
                                        .next()
                                        .addClass(e.bulletActiveClass + "-next-next"));
                            });
                        else {
                            var u = d.eq(i),
                                h = u.index();
                            if ((u.addClass(e.bulletActiveClass), e.dynamicBullets)) {
                                for (var p = d.eq(o), f = d.eq(l), m = o; m <= l; m += 1)
                                    d.eq(m).addClass(e.bulletActiveClass + "-main");
                                if (this.params.loop)
                                    if (h >= d.length - e.dynamicMainBullets) {
                                        for (var v = e.dynamicMainBullets; v >= 0; v -= 1)
                                            d.eq(d.length - v).addClass(
                                                e.bulletActiveClass + "-main"
                                            );
                                        d.eq(d.length - e.dynamicMainBullets - 1).addClass(
                                            e.bulletActiveClass + "-prev"
                                        );
                                    } else
                                        p
                                        .prev()
                                        .addClass(e.bulletActiveClass + "-prev")
                                        .prev()
                                        .addClass(e.bulletActiveClass + "-prev-prev"),
                                        f
                                        .next()
                                        .addClass(e.bulletActiveClass + "-next")
                                        .next()
                                        .addClass(e.bulletActiveClass + "-next-next");
                                else
                                    p
                                    .prev()
                                    .addClass(e.bulletActiveClass + "-prev")
                                    .prev()
                                    .addClass(e.bulletActiveClass + "-prev-prev"),
                                    f
                                    .next()
                                    .addClass(e.bulletActiveClass + "-next")
                                    .next()
                                    .addClass(e.bulletActiveClass + "-next-next");
                            }
                        }
                        if (e.dynamicBullets) {
                            var g = Math.min(d.length, e.dynamicMainBullets + 4),
                                y =
                                (this.pagination.bulletSize * g -
                                    this.pagination.bulletSize) /
                                2 -
                                c * this.pagination.bulletSize,
                                b = t ? "right" : "left";
                            d.css(this.isHorizontal() ? b : "top", y + "px");
                        }
                    }
                    if (
                        ("fraction" === e.type &&
                            (s
                                .find("." + e.currentClass)
                                .text(e.formatFractionCurrent(i + 1)),
                                s.find("." + e.totalClass).text(e.formatFractionTotal(a))),
                            "progressbar" === e.type)
                    ) {
                        var w;
                        w = e.progressbarOpposite ?
                            this.isHorizontal() ?
                            "vertical" :
                            "horizontal" :
                            this.isHorizontal() ?
                            "horizontal" :
                            "vertical";
                        var x = (i + 1) / a,
                            T = 1,
                            S = 1;
                        "horizontal" === w ? (T = x) : (S = x),
                            s
                            .find("." + e.progressbarFillClass)
                            .transform(
                                "translate3d(0,0,0) scaleX(" + T + ") scaleY(" + S + ")"
                            )
                            .transition(this.params.speed);
                    }
                    "custom" === e.type && e.renderCustom ?
                        (s.html(e.renderCustom(this, i + 1, a)),
                            this.emit("paginationRender", this, s[0])) :
                        this.emit("paginationUpdate", this, s[0]),
                        s[
                            this.params.watchOverflow && this.isLocked ?
                            "addClass" :
                            "removeClass"
                        ](e.lockClass);
                }
            },
            render: function() {
                var t = this.params.pagination;
                if (
                    t.el &&
                    this.pagination.el &&
                    this.pagination.$el &&
                    0 !== this.pagination.$el.length
                ) {
                    var e =
                        this.virtual && this.params.virtual.enabled ?
                        this.virtual.slides.length :
                        this.slides.length,
                        i = this.pagination.$el,
                        n = "";
                    if ("bullets" === t.type) {
                        for (
                            var s = this.params.loop ?
                                Math.ceil(
                                    (e - 2 * this.loopedSlides) / this.params.slidesPerGroup
                                ) :
                                this.snapGrid.length,
                                a = 0; a < s; a += 1
                        )
                            t.renderBullet ?
                            (n += t.renderBullet.call(this, a, t.bulletClass)) :
                            (n +=
                                "<" +
                                t.bulletElement +
                                ' class="' +
                                t.bulletClass +
                                '"></' +
                                t.bulletElement +
                                ">");
                        i.html(n),
                            (this.pagination.bullets = i.find("." + t.bulletClass));
                    }
                    "fraction" === t.type &&
                        ((n = t.renderFraction ?
                                t.renderFraction.call(this, t.currentClass, t.totalClass) :
                                '<span class="' +
                                t.currentClass +
                                '"></span> / <span class="' +
                                t.totalClass +
                                '"></span>'),
                            i.html(n)),
                        "progressbar" === t.type &&
                        ((n = t.renderProgressbar ?
                                t.renderProgressbar.call(this, t.progressbarFillClass) :
                                '<span class="' + t.progressbarFillClass + '"></span>'),
                            i.html(n)),
                        "custom" !== t.type &&
                        this.emit("paginationRender", this.pagination.$el[0]);
                }
            },
            init: function() {
                var t = this,
                    e = t.params.pagination;
                if (e.el) {
                    var i = r(e.el);
                    0 !== i.length &&
                        (t.params.uniqueNavElements &&
                            "string" == typeof e.el &&
                            i.length > 1 &&
                            1 === t.$el.find(e.el).length &&
                            (i = t.$el.find(e.el)),
                            "bullets" === e.type &&
                            e.clickable &&
                            i.addClass(e.clickableClass),
                            i.addClass(e.modifierClass + e.type),
                            "bullets" === e.type &&
                            e.dynamicBullets &&
                            (i.addClass("" + e.modifierClass + e.type + "-dynamic"),
                                (t.pagination.dynamicBulletIndex = 0),
                                e.dynamicMainBullets < 1 && (e.dynamicMainBullets = 1)),
                            "progressbar" === e.type &&
                            e.progressbarOpposite &&
                            i.addClass(e.progressbarOppositeClass),
                            e.clickable &&
                            i.on("click", "." + e.bulletClass, function(e) {
                                e.preventDefault();
                                var i = r(this).index() * t.params.slidesPerGroup;
                                t.params.loop && (i += t.loopedSlides), t.slideTo(i);
                            }),
                            c.extend(t.pagination, {
                                $el: i,
                                el: i[0],
                            }));
                }
            },
            destroy: function() {
                var t = this.params.pagination;
                if (
                    t.el &&
                    this.pagination.el &&
                    this.pagination.$el &&
                    0 !== this.pagination.$el.length
                ) {
                    var e = this.pagination.$el;
                    e.removeClass(t.hiddenClass),
                        e.removeClass(t.modifierClass + t.type),
                        this.pagination.bullets &&
                        this.pagination.bullets.removeClass(t.bulletActiveClass),
                        t.clickable && e.off("click", "." + t.bulletClass);
                }
            },
        },
        ot = {
            setTranslate: function() {
                if (this.params.scrollbar.el && this.scrollbar.el) {
                    var t = this.scrollbar,
                        e = this.rtlTranslate,
                        i = this.progress,
                        n = t.dragSize,
                        s = t.trackSize,
                        a = t.$dragEl,
                        r = t.$el,
                        o = this.params.scrollbar,
                        l = n,
                        c = (s - n) * i;
                    e
                        ?
                        (c = -c) > 0 ?
                        ((l = n - c), (c = 0)) :
                        -c + n > s && (l = s + c) :
                        c < 0 ?
                        ((l = n + c), (c = 0)) :
                        c + n > s && (l = s - c),
                        this.isHorizontal() ?
                        (a.transform("translate3d(" + c + "px, 0, 0)"),
                            (a[0].style.width = l + "px")) :
                        (a.transform("translate3d(0px, " + c + "px, 0)"),
                            (a[0].style.height = l + "px")),
                        o.hide &&
                        (clearTimeout(this.scrollbar.timeout),
                            (r[0].style.opacity = 1),
                            (this.scrollbar.timeout = setTimeout(function() {
                                (r[0].style.opacity = 0), r.transition(400);
                            }, 1e3)));
                }
            },
            setTransition: function(t) {
                this.params.scrollbar.el &&
                    this.scrollbar.el &&
                    this.scrollbar.$dragEl.transition(t);
            },
            updateSize: function() {
                if (this.params.scrollbar.el && this.scrollbar.el) {
                    var t = this.scrollbar,
                        e = t.$dragEl,
                        i = t.$el;
                    (e[0].style.width = ""), (e[0].style.height = "");
                    var n,
                        s = this.isHorizontal() ? i[0].offsetWidth : i[0].offsetHeight,
                        a = this.size / this.virtualSize,
                        r = a * (s / this.size);
                    (n =
                        "auto" === this.params.scrollbar.dragSize ?
                        s * a :
                        parseInt(this.params.scrollbar.dragSize, 10)),
                    this.isHorizontal() ?
                        (e[0].style.width = n + "px") :
                        (e[0].style.height = n + "px"),
                        (i[0].style.display = a >= 1 ? "none" : ""),
                        this.params.scrollbar.hide && (i[0].style.opacity = 0),
                        c.extend(t, {
                            trackSize: s,
                            divider: a,
                            moveDivider: r,
                            dragSize: n,
                        }),
                        t.$el[
                            this.params.watchOverflow && this.isLocked ?
                            "addClass" :
                            "removeClass"
                        ](this.params.scrollbar.lockClass);
                }
            },
            getPointerPosition: function(t) {
                return this.isHorizontal() ?
                    "touchstart" === t.type || "touchmove" === t.type ?
                    t.targetTouches[0].clientX :
                    t.clientX :
                    "touchstart" === t.type || "touchmove" === t.type ?
                    t.targetTouches[0].clientY :
                    t.clientY;
            },
            setDragPosition: function(t) {
                var e,
                    i = this.scrollbar,
                    n = this.rtlTranslate,
                    s = i.$el,
                    a = i.dragSize,
                    r = i.trackSize,
                    o = i.dragStartPos;
                (e =
                    (i.getPointerPosition(t) -
                        s.offset()[this.isHorizontal() ? "left" : "top"] -
                        (null !== o ? o : a / 2)) /
                    (r - a)),
                (e = Math.max(Math.min(e, 1), 0)),
                n && (e = 1 - e);
                var l =
                    this.minTranslate() +
                    (this.maxTranslate() - this.minTranslate()) * e;
                this.updateProgress(l),
                    this.setTranslate(l),
                    this.updateActiveIndex(),
                    this.updateSlidesClasses();
            },
            onDragStart: function(t) {
                var e = this.params.scrollbar,
                    i = this.scrollbar,
                    n = this.$wrapperEl,
                    s = i.$el,
                    a = i.$dragEl;
                (this.scrollbar.isTouched = !0),
                (this.scrollbar.dragStartPos =
                    t.target === a[0] || t.target === a ?
                    i.getPointerPosition(t) -
                    t.target.getBoundingClientRect()[
                        this.isHorizontal() ? "left" : "top"
                    ] :
                    null),
                t.preventDefault(),
                    t.stopPropagation(),
                    n.transition(100),
                    a.transition(100),
                    i.setDragPosition(t),
                    clearTimeout(this.scrollbar.dragTimeout),
                    s.transition(0),
                    e.hide && s.css("opacity", 1),
                    this.params.cssMode &&
                    this.$wrapperEl.css("scroll-snap-type", "none"),
                    this.emit("scrollbarDragStart", t);
            },
            onDragMove: function(t) {
                var e = this.scrollbar,
                    i = this.$wrapperEl,
                    n = e.$el,
                    s = e.$dragEl;
                this.scrollbar.isTouched &&
                    (t.preventDefault ? t.preventDefault() : (t.returnValue = !1),
                        e.setDragPosition(t),
                        i.transition(0),
                        n.transition(0),
                        s.transition(0),
                        this.emit("scrollbarDragMove", t));
            },
            onDragEnd: function(t) {
                var e = this.params.scrollbar,
                    i = this.scrollbar,
                    n = this.$wrapperEl,
                    s = i.$el;
                this.scrollbar.isTouched &&
                    ((this.scrollbar.isTouched = !1),
                        this.params.cssMode &&
                        (this.$wrapperEl.css("scroll-snap-type", ""), n.transition("")),
                        e.hide &&
                        (clearTimeout(this.scrollbar.dragTimeout),
                            (this.scrollbar.dragTimeout = c.nextTick(function() {
                                s.css("opacity", 0), s.transition(400);
                            }, 1e3))),
                        this.emit("scrollbarDragEnd", t),
                        e.snapOnRelease && this.slideToClosest());
            },
            enableDraggable: function() {
                if (this.params.scrollbar.el) {
                    var t = this.scrollbar,
                        e = this.touchEventsTouch,
                        n = this.touchEventsDesktop,
                        s = this.params,
                        a = t.$el[0],
                        r = !(!d.passiveListener || !s.passiveListeners) && {
                            passive: !1,
                            capture: !1,
                        },
                        o = !(!d.passiveListener || !s.passiveListeners) && {
                            passive: !0,
                            capture: !1,
                        };
                    d.touch ?
                        (a.addEventListener(e.start, this.scrollbar.onDragStart, r),
                            a.addEventListener(e.move, this.scrollbar.onDragMove, r),
                            a.addEventListener(e.end, this.scrollbar.onDragEnd, o)) :
                        (a.addEventListener(n.start, this.scrollbar.onDragStart, r),
                            i.addEventListener(n.move, this.scrollbar.onDragMove, r),
                            i.addEventListener(n.end, this.scrollbar.onDragEnd, o));
                }
            },
            disableDraggable: function() {
                if (this.params.scrollbar.el) {
                    var t = this.scrollbar,
                        e = this.touchEventsTouch,
                        n = this.touchEventsDesktop,
                        s = this.params,
                        a = t.$el[0],
                        r = !(!d.passiveListener || !s.passiveListeners) && {
                            passive: !1,
                            capture: !1,
                        },
                        o = !(!d.passiveListener || !s.passiveListeners) && {
                            passive: !0,
                            capture: !1,
                        };
                    d.touch ?
                        (a.removeEventListener(e.start, this.scrollbar.onDragStart, r),
                            a.removeEventListener(e.move, this.scrollbar.onDragMove, r),
                            a.removeEventListener(e.end, this.scrollbar.onDragEnd, o)) :
                        (a.removeEventListener(n.start, this.scrollbar.onDragStart, r),
                            i.removeEventListener(n.move, this.scrollbar.onDragMove, r),
                            i.removeEventListener(n.end, this.scrollbar.onDragEnd, o));
                }
            },
            init: function() {
                if (this.params.scrollbar.el) {
                    var t = this.scrollbar,
                        e = this.$el,
                        i = this.params.scrollbar,
                        n = r(i.el);
                    this.params.uniqueNavElements &&
                        "string" == typeof i.el &&
                        n.length > 1 &&
                        1 === e.find(i.el).length &&
                        (n = e.find(i.el));
                    var s = n.find("." + this.params.scrollbar.dragClass);
                    0 === s.length &&
                        ((s = r(
                                '<div class="' + this.params.scrollbar.dragClass + '"></div>'
                            )),
                            n.append(s)),
                        c.extend(t, {
                            $el: n,
                            el: n[0],
                            $dragEl: s,
                            dragEl: s[0],
                        }),
                        i.draggable && t.enableDraggable();
                }
            },
            destroy: function() {
                this.scrollbar.disableDraggable();
            },
        },
        lt = {
            setTransform: function(t, e) {
                var i = this.rtl,
                    n = r(t),
                    s = i ? -1 : 1,
                    a = n.attr("data-swiper-parallax") || "0",
                    o = n.attr("data-swiper-parallax-x"),
                    l = n.attr("data-swiper-parallax-y"),
                    c = n.attr("data-swiper-parallax-scale"),
                    d = n.attr("data-swiper-parallax-opacity");
                if (
                    (o || l ?
                        ((o = o || "0"), (l = l || "0")) :
                        this.isHorizontal() ?
                        ((o = a), (l = "0")) :
                        ((l = a), (o = "0")),
                        (o =
                            o.indexOf("%") >= 0 ?
                            parseInt(o, 10) * e * s + "%" :
                            o * e * s + "px"),
                        (l =
                            l.indexOf("%") >= 0 ? parseInt(l, 10) * e + "%" : l * e + "px"),
                        null != d)
                ) {
                    var u = d - (d - 1) * (1 - Math.abs(e));
                    n[0].style.opacity = u;
                }
                if (null == c) n.transform("translate3d(" + o + ", " + l + ", 0px)");
                else {
                    var h = c - (c - 1) * (1 - Math.abs(e));
                    n.transform(
                        "translate3d(" + o + ", " + l + ", 0px) scale(" + h + ")"
                    );
                }
            },
            setTranslate: function() {
                var t = this,
                    e = t.$el,
                    i = t.slides,
                    n = t.progress,
                    s = t.snapGrid;
                e
                    .children(
                        "[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]"
                    )
                    .each(function(e, i) {
                        t.parallax.setTransform(i, n);
                    }),
                    i.each(function(e, i) {
                        var a = i.progress;
                        t.params.slidesPerGroup > 1 &&
                            "auto" !== t.params.slidesPerView &&
                            (a += Math.ceil(e / 2) - n * (s.length - 1)),
                            (a = Math.min(Math.max(a, -1), 1)),
                            r(i)
                            .find(
                                "[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]"
                            )
                            .each(function(e, i) {
                                t.parallax.setTransform(i, a);
                            });
                    });
            },
            setTransition: function(t) {
                void 0 === t && (t = this.params.speed),
                    this.$el
                    .find(
                        "[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]"
                    )
                    .each(function(e, i) {
                        var n = r(i),
                            s =
                            parseInt(n.attr("data-swiper-parallax-duration"), 10) || t;
                        0 === t && (s = 0), n.transition(s);
                    });
            },
        },
        ct = {
            getDistanceBetweenTouches: function(t) {
                if (t.targetTouches.length < 2) return 1;
                var e = t.targetTouches[0].pageX,
                    i = t.targetTouches[0].pageY,
                    n = t.targetTouches[1].pageX,
                    s = t.targetTouches[1].pageY;
                return Math.sqrt(Math.pow(n - e, 2) + Math.pow(s - i, 2));
            },
            onGestureStart: function(t) {
                var e = this.params.zoom,
                    i = this.zoom,
                    n = i.gesture;
                if (
                    ((i.fakeGestureTouched = !1),
                        (i.fakeGestureMoved = !1), !d.gestures)
                ) {
                    if (
                        "touchstart" !== t.type ||
                        ("touchstart" === t.type && t.targetTouches.length < 2)
                    )
                        return;
                    (i.fakeGestureTouched = !0),
                    (n.scaleStart = ct.getDistanceBetweenTouches(t));
                }
                (n.$slideEl && n.$slideEl.length) ||
                ((n.$slideEl = r(t.target).closest("." + this.params.slideClass)),
                    0 === n.$slideEl.length &&
                    (n.$slideEl = this.slides.eq(this.activeIndex)),
                    (n.$imageEl = n.$slideEl.find(
                        "img, svg, canvas, picture, .swiper-zoom-target"
                    )),
                    (n.$imageWrapEl = n.$imageEl.parent("." + e.containerClass)),
                    (n.maxRatio = n.$imageWrapEl.attr("data-swiper-zoom") || e.maxRatio),
                    0 !== n.$imageWrapEl.length) ?
                (n.$imageEl && n.$imageEl.transition(0),
                    (this.zoom.isScaling = !0)) :
                (n.$imageEl = void 0);
            },
            onGestureChange: function(t) {
                var e = this.params.zoom,
                    i = this.zoom,
                    n = i.gesture;
                if (!d.gestures) {
                    if (
                        "touchmove" !== t.type ||
                        ("touchmove" === t.type && t.targetTouches.length < 2)
                    )
                        return;
                    (i.fakeGestureMoved = !0),
                    (n.scaleMove = ct.getDistanceBetweenTouches(t));
                }
                n.$imageEl &&
                    0 !== n.$imageEl.length &&
                    ((i.scale = d.gestures ?
                            t.scale * i.currentScale :
                            (n.scaleMove / n.scaleStart) * i.currentScale),
                        i.scale > n.maxRatio &&
                        (i.scale =
                            n.maxRatio - 1 + Math.pow(i.scale - n.maxRatio + 1, 0.5)),
                        i.scale < e.minRatio &&
                        (i.scale =
                            e.minRatio + 1 - Math.pow(e.minRatio - i.scale + 1, 0.5)),
                        n.$imageEl.transform("translate3d(0,0,0) scale(" + i.scale + ")"));
            },
            onGestureEnd: function(t) {
                var e = this.params.zoom,
                    i = this.zoom,
                    n = i.gesture;
                if (!d.gestures) {
                    if (!i.fakeGestureTouched || !i.fakeGestureMoved) return;
                    if (
                        "touchend" !== t.type ||
                        ("touchend" === t.type &&
                            t.changedTouches.length < 2 &&
                            !z.android)
                    )
                        return;
                    (i.fakeGestureTouched = !1), (i.fakeGestureMoved = !1);
                }
                n.$imageEl &&
                    0 !== n.$imageEl.length &&
                    ((i.scale = Math.max(Math.min(i.scale, n.maxRatio), e.minRatio)),
                        n.$imageEl
                        .transition(this.params.speed)
                        .transform("translate3d(0,0,0) scale(" + i.scale + ")"),
                        (i.currentScale = i.scale),
                        (i.isScaling = !1),
                        1 === i.scale && (n.$slideEl = void 0));
            },
            onTouchStart: function(t) {
                var e = this.zoom,
                    i = e.gesture,
                    n = e.image;
                i.$imageEl &&
                    0 !== i.$imageEl.length &&
                    (n.isTouched ||
                        (z.android && t.cancelable && t.preventDefault(),
                            (n.isTouched = !0),
                            (n.touchesStart.x =
                                "touchstart" === t.type ? t.targetTouches[0].pageX : t.pageX),
                            (n.touchesStart.y =
                                "touchstart" === t.type ? t.targetTouches[0].pageY : t.pageY)));
            },
            onTouchMove: function(t) {
                var e = this.zoom,
                    i = e.gesture,
                    n = e.image,
                    s = e.velocity;
                if (
                    i.$imageEl &&
                    0 !== i.$imageEl.length &&
                    ((this.allowClick = !1), n.isTouched && i.$slideEl)
                ) {
                    n.isMoved ||
                        ((n.width = i.$imageEl[0].offsetWidth),
                            (n.height = i.$imageEl[0].offsetHeight),
                            (n.startX = c.getTranslate(i.$imageWrapEl[0], "x") || 0),
                            (n.startY = c.getTranslate(i.$imageWrapEl[0], "y") || 0),
                            (i.slideWidth = i.$slideEl[0].offsetWidth),
                            (i.slideHeight = i.$slideEl[0].offsetHeight),
                            i.$imageWrapEl.transition(0),
                            this.rtl && ((n.startX = -n.startX), (n.startY = -n.startY)));
                    var a = n.width * e.scale,
                        r = n.height * e.scale;
                    if (!(a < i.slideWidth && r < i.slideHeight)) {
                        if (
                            ((n.minX = Math.min(i.slideWidth / 2 - a / 2, 0)),
                                (n.maxX = -n.minX),
                                (n.minY = Math.min(i.slideHeight / 2 - r / 2, 0)),
                                (n.maxY = -n.minY),
                                (n.touchesCurrent.x =
                                    "touchmove" === t.type ? t.targetTouches[0].pageX : t.pageX),
                                (n.touchesCurrent.y =
                                    "touchmove" === t.type ? t.targetTouches[0].pageY : t.pageY), !n.isMoved && !e.isScaling)
                        ) {
                            if (
                                this.isHorizontal() &&
                                ((Math.floor(n.minX) === Math.floor(n.startX) &&
                                        n.touchesCurrent.x < n.touchesStart.x) ||
                                    (Math.floor(n.maxX) === Math.floor(n.startX) &&
                                        n.touchesCurrent.x > n.touchesStart.x))
                            )
                                return void(n.isTouched = !1);
                            if (!this.isHorizontal() &&
                                ((Math.floor(n.minY) === Math.floor(n.startY) &&
                                        n.touchesCurrent.y < n.touchesStart.y) ||
                                    (Math.floor(n.maxY) === Math.floor(n.startY) &&
                                        n.touchesCurrent.y > n.touchesStart.y))
                            )
                                return void(n.isTouched = !1);
                        }
                        t.cancelable && t.preventDefault(),
                            t.stopPropagation(),
                            (n.isMoved = !0),
                            (n.currentX = n.touchesCurrent.x - n.touchesStart.x + n.startX),
                            (n.currentY = n.touchesCurrent.y - n.touchesStart.y + n.startY),
                            n.currentX < n.minX &&
                            (n.currentX =
                                n.minX + 1 - Math.pow(n.minX - n.currentX + 1, 0.8)),
                            n.currentX > n.maxX &&
                            (n.currentX =
                                n.maxX - 1 + Math.pow(n.currentX - n.maxX + 1, 0.8)),
                            n.currentY < n.minY &&
                            (n.currentY =
                                n.minY + 1 - Math.pow(n.minY - n.currentY + 1, 0.8)),
                            n.currentY > n.maxY &&
                            (n.currentY =
                                n.maxY - 1 + Math.pow(n.currentY - n.maxY + 1, 0.8)),
                            s.prevPositionX || (s.prevPositionX = n.touchesCurrent.x),
                            s.prevPositionY || (s.prevPositionY = n.touchesCurrent.y),
                            s.prevTime || (s.prevTime = Date.now()),
                            (s.x =
                                (n.touchesCurrent.x - s.prevPositionX) /
                                (Date.now() - s.prevTime) /
                                2),
                            (s.y =
                                (n.touchesCurrent.y - s.prevPositionY) /
                                (Date.now() - s.prevTime) /
                                2),
                            Math.abs(n.touchesCurrent.x - s.prevPositionX) < 2 && (s.x = 0),
                            Math.abs(n.touchesCurrent.y - s.prevPositionY) < 2 && (s.y = 0),
                            (s.prevPositionX = n.touchesCurrent.x),
                            (s.prevPositionY = n.touchesCurrent.y),
                            (s.prevTime = Date.now()),
                            i.$imageWrapEl.transform(
                                "translate3d(" + n.currentX + "px, " + n.currentY + "px,0)"
                            );
                    }
                }
            },
            onTouchEnd: function() {
                var t = this.zoom,
                    e = t.gesture,
                    i = t.image,
                    n = t.velocity;
                if (e.$imageEl && 0 !== e.$imageEl.length) {
                    if (!i.isTouched || !i.isMoved)
                        return (i.isTouched = !1), void(i.isMoved = !1);
                    (i.isTouched = !1), (i.isMoved = !1);
                    var s = 300,
                        a = 300,
                        r = n.x * s,
                        o = i.currentX + r,
                        l = n.y * a,
                        c = i.currentY + l;
                    0 !== n.x && (s = Math.abs((o - i.currentX) / n.x)),
                        0 !== n.y && (a = Math.abs((c - i.currentY) / n.y));
                    var d = Math.max(s, a);
                    (i.currentX = o), (i.currentY = c);
                    var u = i.width * t.scale,
                        h = i.height * t.scale;
                    (i.minX = Math.min(e.slideWidth / 2 - u / 2, 0)),
                    (i.maxX = -i.minX),
                    (i.minY = Math.min(e.slideHeight / 2 - h / 2, 0)),
                    (i.maxY = -i.minY),
                    (i.currentX = Math.max(Math.min(i.currentX, i.maxX), i.minX)),
                    (i.currentY = Math.max(Math.min(i.currentY, i.maxY), i.minY)),
                    e.$imageWrapEl
                        .transition(d)
                        .transform(
                            "translate3d(" + i.currentX + "px, " + i.currentY + "px,0)"
                        );
                }
            },
            onTransitionEnd: function() {
                var t = this.zoom,
                    e = t.gesture;
                e.$slideEl &&
                    this.previousIndex !== this.activeIndex &&
                    (e.$imageEl && e.$imageEl.transform("translate3d(0,0,0) scale(1)"),
                        e.$imageWrapEl && e.$imageWrapEl.transform("translate3d(0,0,0)"),
                        (t.scale = 1),
                        (t.currentScale = 1),
                        (e.$slideEl = void 0),
                        (e.$imageEl = void 0),
                        (e.$imageWrapEl = void 0));
            },
            toggle: function(t) {
                var e = this.zoom;
                e.scale && 1 !== e.scale ? e.out() : e.in(t);
            },
            in: function(t) {
                var e,
                    i,
                    n,
                    s,
                    a,
                    r,
                    o,
                    l,
                    c,
                    d,
                    u,
                    h,
                    p,
                    f,
                    m,
                    v,
                    g = this.zoom,
                    y = this.params.zoom,
                    b = g.gesture,
                    w = g.image;
                b.$slideEl ||
                    (this.params.virtual && this.params.virtual.enabled && this.virtual ?
                        (b.$slideEl = this.$wrapperEl.children(
                            "." + this.params.slideActiveClass
                        )) :
                        (b.$slideEl = this.slides.eq(this.activeIndex)),
                        (b.$imageEl = b.$slideEl.find(
                            "img, svg, canvas, picture, .swiper-zoom-target"
                        )),
                        (b.$imageWrapEl = b.$imageEl.parent("." + y.containerClass))),
                    b.$imageEl &&
                    0 !== b.$imageEl.length &&
                    (b.$slideEl.addClass("" + y.zoomedSlideClass),
                        void 0 === w.touchesStart.x && t ?
                        ((e =
                                "touchend" === t.type ?
                                t.changedTouches[0].pageX :
                                t.pageX),
                            (i =
                                "touchend" === t.type ?
                                t.changedTouches[0].pageY :
                                t.pageY)) :
                        ((e = w.touchesStart.x), (i = w.touchesStart.y)),
                        (g.scale = b.$imageWrapEl.attr("data-swiper-zoom") || y.maxRatio),
                        (g.currentScale =
                            b.$imageWrapEl.attr("data-swiper-zoom") || y.maxRatio),
                        t ?
                        ((m = b.$slideEl[0].offsetWidth),
                            (v = b.$slideEl[0].offsetHeight),
                            (n = b.$slideEl.offset().left + m / 2 - e),
                            (s = b.$slideEl.offset().top + v / 2 - i),
                            (o = b.$imageEl[0].offsetWidth),
                            (l = b.$imageEl[0].offsetHeight),
                            (c = o * g.scale),
                            (d = l * g.scale),
                            (p = -(u = Math.min(m / 2 - c / 2, 0))),
                            (f = -(h = Math.min(v / 2 - d / 2, 0))),
                            (a = n * g.scale) < u && (a = u),
                            a > p && (a = p),
                            (r = s * g.scale) < h && (r = h),
                            r > f && (r = f)) :
                        ((a = 0), (r = 0)),
                        b.$imageWrapEl
                        .transition(300)
                        .transform("translate3d(" + a + "px, " + r + "px,0)"),
                        b.$imageEl
                        .transition(300)
                        .transform("translate3d(0,0,0) scale(" + g.scale + ")"));
            },
            out: function() {
                var t = this.zoom,
                    e = this.params.zoom,
                    i = t.gesture;
                i.$slideEl ||
                    (this.params.virtual && this.params.virtual.enabled && this.virtual ?
                        (i.$slideEl = this.$wrapperEl.children(
                            "." + this.params.slideActiveClass
                        )) :
                        (i.$slideEl = this.slides.eq(this.activeIndex)),
                        (i.$imageEl = i.$slideEl.find(
                            "img, svg, canvas, picture, .swiper-zoom-target"
                        )),
                        (i.$imageWrapEl = i.$imageEl.parent("." + e.containerClass))),
                    i.$imageEl &&
                    0 !== i.$imageEl.length &&
                    ((t.scale = 1),
                        (t.currentScale = 1),
                        i.$imageWrapEl.transition(300).transform("translate3d(0,0,0)"),
                        i.$imageEl
                        .transition(300)
                        .transform("translate3d(0,0,0) scale(1)"),
                        i.$slideEl.removeClass("" + e.zoomedSlideClass),
                        (i.$slideEl = void 0));
            },
            enable: function() {
                var t = this.zoom;
                if (!t.enabled) {
                    t.enabled = !0;
                    var e = !(
                            "touchstart" !== this.touchEvents.start ||
                            !d.passiveListener ||
                            !this.params.passiveListeners
                        ) && {
                            passive: !0,
                            capture: !1,
                        },
                        i = !d.passiveListener || {
                            passive: !1,
                            capture: !0,
                        },
                        n = "." + this.params.slideClass;
                    d.gestures ?
                        (this.$wrapperEl.on("gesturestart", n, t.onGestureStart, e),
                            this.$wrapperEl.on("gesturechange", n, t.onGestureChange, e),
                            this.$wrapperEl.on("gestureend", n, t.onGestureEnd, e)) :
                        "touchstart" === this.touchEvents.start &&
                        (this.$wrapperEl.on(
                                this.touchEvents.start,
                                n,
                                t.onGestureStart,
                                e
                            ),
                            this.$wrapperEl.on(
                                this.touchEvents.move,
                                n,
                                t.onGestureChange,
                                i
                            ),
                            this.$wrapperEl.on(this.touchEvents.end, n, t.onGestureEnd, e),
                            this.touchEvents.cancel &&
                            this.$wrapperEl.on(
                                this.touchEvents.cancel,
                                n,
                                t.onGestureEnd,
                                e
                            )),
                        this.$wrapperEl.on(
                            this.touchEvents.move,
                            "." + this.params.zoom.containerClass,
                            t.onTouchMove,
                            i
                        );
                }
            },
            disable: function() {
                var t = this.zoom;
                if (t.enabled) {
                    this.zoom.enabled = !1;
                    var e = !(
                            "touchstart" !== this.touchEvents.start ||
                            !d.passiveListener ||
                            !this.params.passiveListeners
                        ) && {
                            passive: !0,
                            capture: !1,
                        },
                        i = !d.passiveListener || {
                            passive: !1,
                            capture: !0,
                        },
                        n = "." + this.params.slideClass;
                    d.gestures ?
                        (this.$wrapperEl.off("gesturestart", n, t.onGestureStart, e),
                            this.$wrapperEl.off("gesturechange", n, t.onGestureChange, e),
                            this.$wrapperEl.off("gestureend", n, t.onGestureEnd, e)) :
                        "touchstart" === this.touchEvents.start &&
                        (this.$wrapperEl.off(
                                this.touchEvents.start,
                                n,
                                t.onGestureStart,
                                e
                            ),
                            this.$wrapperEl.off(
                                this.touchEvents.move,
                                n,
                                t.onGestureChange,
                                i
                            ),
                            this.$wrapperEl.off(this.touchEvents.end, n, t.onGestureEnd, e),
                            this.touchEvents.cancel &&
                            this.$wrapperEl.off(
                                this.touchEvents.cancel,
                                n,
                                t.onGestureEnd,
                                e
                            )),
                        this.$wrapperEl.off(
                            this.touchEvents.move,
                            "." + this.params.zoom.containerClass,
                            t.onTouchMove,
                            i
                        );
                }
            },
        },
        dt = {
            loadInSlide: function(t, e) {
                void 0 === e && (e = !0);
                var i = this,
                    n = i.params.lazy;
                if (void 0 !== t && 0 !== i.slides.length) {
                    var s =
                        i.virtual && i.params.virtual.enabled ?
                        i.$wrapperEl.children(
                            "." +
                            i.params.slideClass +
                            '[data-swiper-slide-index="' +
                            t +
                            '"]'
                        ) :
                        i.slides.eq(t),
                        a = s.find(
                            "." +
                            n.elementClass +
                            ":not(." +
                            n.loadedClass +
                            "):not(." +
                            n.loadingClass +
                            ")"
                        );
                    !s.hasClass(n.elementClass) ||
                        s.hasClass(n.loadedClass) ||
                        s.hasClass(n.loadingClass) ||
                        (a = a.add(s[0])),
                        0 !== a.length &&
                        a.each(function(t, a) {
                            var o = r(a);
                            o.addClass(n.loadingClass);
                            var l = o.attr("data-background"),
                                c = o.attr("data-src"),
                                d = o.attr("data-srcset"),
                                u = o.attr("data-sizes"),
                                h = o.parent("picture");
                            i.loadImage(o[0], c || l, d, u, !1, function() {
                                    if (null != i && i && (!i || i.params) && !i.destroyed) {
                                        if (
                                            (l ?
                                                (o.css("background-image", 'url("' + l + '")'),
                                                    o.removeAttr("data-background")) :
                                                (d &&
                                                    (o.attr("srcset", d),
                                                        o.removeAttr("data-srcset")),
                                                    u &&
                                                    (o.attr("sizes", u), o.removeAttr("data-sizes")),
                                                    h.length &&
                                                    h.children("source").each(function(t, e) {
                                                        var i = r(e);
                                                        i.attr("data-srcset") &&
                                                            (i.attr("srcset", i.attr("data-srcset")),
                                                                i.removeAttr("data-srcset"));
                                                    }),
                                                    c && (o.attr("src", c), o.removeAttr("data-src"))),
                                                o.addClass(n.loadedClass).removeClass(n.loadingClass),
                                                s.find("." + n.preloaderClass).remove(),
                                                i.params.loop && e)
                                        ) {
                                            var t = s.attr("data-swiper-slide-index");
                                            if (s.hasClass(i.params.slideDuplicateClass)) {
                                                var a = i.$wrapperEl.children(
                                                    '[data-swiper-slide-index="' +
                                                    t +
                                                    '"]:not(.' +
                                                    i.params.slideDuplicateClass +
                                                    ")"
                                                );
                                                i.lazy.loadInSlide(a.index(), !1);
                                            } else {
                                                var p = i.$wrapperEl.children(
                                                    "." +
                                                    i.params.slideDuplicateClass +
                                                    '[data-swiper-slide-index="' +
                                                    t +
                                                    '"]'
                                                );
                                                i.lazy.loadInSlide(p.index(), !1);
                                            }
                                        }
                                        i.emit("lazyImageReady", s[0], o[0]),
                                            i.params.autoHeight && i.updateAutoHeight();
                                    }
                                }),
                                i.emit("lazyImageLoad", s[0], o[0]);
                        });
                }
            },
            load: function() {
                var t = this,
                    e = t.$wrapperEl,
                    i = t.params,
                    n = t.slides,
                    s = t.activeIndex,
                    a = t.virtual && i.virtual.enabled,
                    o = i.lazy,
                    l = i.slidesPerView;

                function c(t) {
                    if (a) {
                        if (
                            e.children(
                                "." + i.slideClass + '[data-swiper-slide-index="' + t + '"]'
                            ).length
                        )
                            return !0;
                    } else if (n[t]) return !0;
                    return !1;
                }

                function d(t) {
                    return a ? r(t).attr("data-swiper-slide-index") : r(t).index();
                }
                if (
                    ("auto" === l && (l = 0),
                        t.lazy.initialImageLoaded || (t.lazy.initialImageLoaded = !0),
                        t.params.watchSlidesVisibility)
                )
                    e.children("." + i.slideVisibleClass).each(function(e, i) {
                        var n = a ? r(i).attr("data-swiper-slide-index") : r(i).index();
                        t.lazy.loadInSlide(n);
                    });
                else if (l > 1)
                    for (var u = s; u < s + l; u += 1) c(u) && t.lazy.loadInSlide(u);
                else t.lazy.loadInSlide(s);
                if (o.loadPrevNext)
                    if (l > 1 || (o.loadPrevNextAmount && o.loadPrevNextAmount > 1)) {
                        for (
                            var h = o.loadPrevNextAmount,
                                p = l,
                                f = Math.min(s + p + Math.max(h, p), n.length),
                                m = Math.max(s - Math.max(p, h), 0),
                                v = s + l; v < f; v += 1
                        )
                            c(v) && t.lazy.loadInSlide(v);
                        for (var g = m; g < s; g += 1) c(g) && t.lazy.loadInSlide(g);
                    } else {
                        var y = e.children("." + i.slideNextClass);
                        y.length > 0 && t.lazy.loadInSlide(d(y));
                        var b = e.children("." + i.slidePrevClass);
                        b.length > 0 && t.lazy.loadInSlide(d(b));
                    }
            },
        },
        ut = {
            LinearSpline: function(t, e) {
                var i, n, s, a, r;
                return (
                    (this.x = t),
                    (this.y = e),
                    (this.lastIndex = t.length - 1),
                    (this.interpolate = function(t) {
                        return t ?
                            ((r = (function(t, e) {
                                    for (n = -1, i = t.length; i - n > 1;)
                                        t[(s = (i + n) >> 1)] <= e ? (n = s) : (i = s);
                                    return i;
                                })(this.x, t)),
                                (a = r - 1),
                                ((t - this.x[a]) * (this.y[r] - this.y[a])) /
                                (this.x[r] - this.x[a]) +
                                this.y[a]) :
                            0;
                    }),
                    this
                );
            },
            getInterpolateFunction: function(t) {
                this.controller.spline ||
                    (this.controller.spline = this.params.loop ?
                        new ut.LinearSpline(this.slidesGrid, t.slidesGrid) :
                        new ut.LinearSpline(this.snapGrid, t.snapGrid));
            },
            setTranslate: function(t, e) {
                var i,
                    n,
                    s = this,
                    a = s.controller.control;

                function r(t) {
                    var e = s.rtlTranslate ? -s.translate : s.translate;
                    "slide" === s.params.controller.by &&
                        (s.controller.getInterpolateFunction(t),
                            (n = -s.controller.spline.interpolate(-e))),
                        (n && "container" !== s.params.controller.by) ||
                        ((i =
                                (t.maxTranslate() - t.minTranslate()) /
                                (s.maxTranslate() - s.minTranslate())),
                            (n = (e - s.minTranslate()) * i + t.minTranslate())),
                        s.params.controller.inverse && (n = t.maxTranslate() - n),
                        t.updateProgress(n),
                        t.setTranslate(n, s),
                        t.updateActiveIndex(),
                        t.updateSlidesClasses();
                }
                if (Array.isArray(a))
                    for (var o = 0; o < a.length; o += 1)
                        a[o] !== e && a[o] instanceof X && r(a[o]);
                else a instanceof X && e !== a && r(a);
            },
            setTransition: function(t, e) {
                var i,
                    n = this,
                    s = n.controller.control;

                function a(e) {
                    e.setTransition(t, n),
                        0 !== t &&
                        (e.transitionStart(),
                            e.params.autoHeight &&
                            c.nextTick(function() {
                                e.updateAutoHeight();
                            }),
                            e.$wrapperEl.transitionEnd(function() {
                                s &&
                                    (e.params.loop &&
                                        "slide" === n.params.controller.by &&
                                        e.loopFix(),
                                        e.transitionEnd());
                            }));
                }
                if (Array.isArray(s))
                    for (i = 0; i < s.length; i += 1)
                        s[i] !== e && s[i] instanceof X && a(s[i]);
                else s instanceof X && e !== s && a(s);
            },
        },
        ht = {
            makeElFocusable: function(t) {
                return t.attr("tabIndex", "0"), t;
            },
            makeElNotFocusable: function(t) {
                return t.attr("tabIndex", "-1"), t;
            },
            addElRole: function(t, e) {
                return t.attr("role", e), t;
            },
            addElLabel: function(t, e) {
                return t.attr("aria-label", e), t;
            },
            disableEl: function(t) {
                return t.attr("aria-disabled", !0), t;
            },
            enableEl: function(t) {
                return t.attr("aria-disabled", !1), t;
            },
            onEnterKey: function(t) {
                var e = this.params.a11y;
                if (13 === t.keyCode) {
                    var i = r(t.target);
                    this.navigation &&
                        this.navigation.$nextEl &&
                        i.is(this.navigation.$nextEl) &&
                        ((this.isEnd && !this.params.loop) || this.slideNext(),
                            this.isEnd ?
                            this.a11y.notify(e.lastSlideMessage) :
                            this.a11y.notify(e.nextSlideMessage)),
                        this.navigation &&
                        this.navigation.$prevEl &&
                        i.is(this.navigation.$prevEl) &&
                        ((this.isBeginning && !this.params.loop) || this.slidePrev(),
                            this.isBeginning ?
                            this.a11y.notify(e.firstSlideMessage) :
                            this.a11y.notify(e.prevSlideMessage)),
                        this.pagination &&
                        i.is("." + this.params.pagination.bulletClass) &&
                        i[0].click();
                }
            },
            notify: function(t) {
                var e = this.a11y.liveRegion;
                0 !== e.length && (e.html(""), e.html(t));
            },
            updateNavigation: function() {
                if (!this.params.loop && this.navigation) {
                    var t = this.navigation,
                        e = t.$nextEl,
                        i = t.$prevEl;
                    i &&
                        i.length > 0 &&
                        (this.isBeginning ?
                            (this.a11y.disableEl(i), this.a11y.makeElNotFocusable(i)) :
                            (this.a11y.enableEl(i), this.a11y.makeElFocusable(i))),
                        e &&
                        e.length > 0 &&
                        (this.isEnd ?
                            (this.a11y.disableEl(e), this.a11y.makeElNotFocusable(e)) :
                            (this.a11y.enableEl(e), this.a11y.makeElFocusable(e)));
                }
            },
            updatePagination: function() {
                var t = this,
                    e = t.params.a11y;
                t.pagination &&
                    t.params.pagination.clickable &&
                    t.pagination.bullets &&
                    t.pagination.bullets.length &&
                    t.pagination.bullets.each(function(i, n) {
                        var s = r(n);
                        t.a11y.makeElFocusable(s),
                            t.a11y.addElRole(s, "button"),
                            t.a11y.addElLabel(
                                s,
                                e.paginationBulletMessage.replace(
                                    /\{\{index\}\}/,
                                    s.index() + 1
                                )
                            );
                    });
            },
            init: function() {
                this.$el.append(this.a11y.liveRegion);
                var t,
                    e,
                    i = this.params.a11y;
                this.navigation &&
                    this.navigation.$nextEl &&
                    (t = this.navigation.$nextEl),
                    this.navigation &&
                    this.navigation.$prevEl &&
                    (e = this.navigation.$prevEl),
                    t &&
                    (this.a11y.makeElFocusable(t),
                        this.a11y.addElRole(t, "button"),
                        this.a11y.addElLabel(t, i.nextSlideMessage),
                        t.on("keydown", this.a11y.onEnterKey)),
                    e &&
                    (this.a11y.makeElFocusable(e),
                        this.a11y.addElRole(e, "button"),
                        this.a11y.addElLabel(e, i.prevSlideMessage),
                        e.on("keydown", this.a11y.onEnterKey)),
                    this.pagination &&
                    this.params.pagination.clickable &&
                    this.pagination.bullets &&
                    this.pagination.bullets.length &&
                    this.pagination.$el.on(
                        "keydown",
                        "." + this.params.pagination.bulletClass,
                        this.a11y.onEnterKey
                    );
            },
            destroy: function() {
                var t, e;
                this.a11y.liveRegion &&
                    this.a11y.liveRegion.length > 0 &&
                    this.a11y.liveRegion.remove(),
                    this.navigation &&
                    this.navigation.$nextEl &&
                    (t = this.navigation.$nextEl),
                    this.navigation &&
                    this.navigation.$prevEl &&
                    (e = this.navigation.$prevEl),
                    t && t.off("keydown", this.a11y.onEnterKey),
                    e && e.off("keydown", this.a11y.onEnterKey),
                    this.pagination &&
                    this.params.pagination.clickable &&
                    this.pagination.bullets &&
                    this.pagination.bullets.length &&
                    this.pagination.$el.off(
                        "keydown",
                        "." + this.params.pagination.bulletClass,
                        this.a11y.onEnterKey
                    );
            },
        },
        pt = {
            init: function() {
                if (this.params.history) {
                    if (!s.history || !s.history.pushState)
                        return (
                            (this.params.history.enabled = !1),
                            void(this.params.hashNavigation.enabled = !0)
                        );
                    var t = this.history;
                    (t.initialized = !0),
                    (t.paths = pt.getPathValues()),
                    (t.paths.key || t.paths.value) &&
                    (t.scrollToSlide(
                            0,
                            t.paths.value,
                            this.params.runCallbacksOnInit
                        ),
                        this.params.history.replaceState ||
                        s.addEventListener(
                            "popstate",
                            this.history.setHistoryPopState
                        ));
                }
            },
            destroy: function() {
                this.params.history.replaceState ||
                    s.removeEventListener("popstate", this.history.setHistoryPopState);
            },
            setHistoryPopState: function() {
                (this.history.paths = pt.getPathValues()),
                this.history.scrollToSlide(
                    this.params.speed,
                    this.history.paths.value, !1
                );
            },
            getPathValues: function() {
                var t = s.location.pathname
                    .slice(1)
                    .split("/")
                    .filter(function(t) {
                        return "" !== t;
                    }),
                    e = t.length;
                return {
                    key: t[e - 2],
                    value: t[e - 1],
                };
            },
            setHistory: function(t, e) {
                if (this.history.initialized && this.params.history.enabled) {
                    var i = this.slides.eq(e),
                        n = pt.slugify(i.attr("data-history"));
                    s.location.pathname.includes(t) || (n = t + "/" + n);
                    var a = s.history.state;
                    (a && a.value === n) ||
                    (this.params.history.replaceState ?
                        s.history.replaceState({
                                value: n,
                            },
                            null,
                            n
                        ) :
                        s.history.pushState({
                                value: n,
                            },
                            null,
                            n
                        ));
                }
            },
            slugify: function(t) {
                return t
                    .toString()
                    .replace(/\s+/g, "-")
                    .replace(/[^\w-]+/g, "")
                    .replace(/--+/g, "-")
                    .replace(/^-+/, "")
                    .replace(/-+$/, "");
            },
            scrollToSlide: function(t, e, i) {
                if (e)
                    for (var n = 0, s = this.slides.length; n < s; n += 1) {
                        var a = this.slides.eq(n);
                        if (
                            pt.slugify(a.attr("data-history")) === e &&
                            !a.hasClass(this.params.slideDuplicateClass)
                        ) {
                            var r = a.index();
                            this.slideTo(r, t, i);
                        }
                    }
                else this.slideTo(0, t, i);
            },
        },
        ft = {
            onHashCange: function() {
                this.emit("hashChange");
                var t = i.location.hash.replace("#", "");
                if (t !== this.slides.eq(this.activeIndex).attr("data-hash")) {
                    var e = this.$wrapperEl
                        .children(
                            "." + this.params.slideClass + '[data-hash="' + t + '"]'
                        )
                        .index();
                    if (void 0 === e) return;
                    this.slideTo(e);
                }
            },
            setHash: function() {
                if (
                    this.hashNavigation.initialized &&
                    this.params.hashNavigation.enabled
                )
                    if (
                        this.params.hashNavigation.replaceState &&
                        s.history &&
                        s.history.replaceState
                    )
                        s.history.replaceState(
                            null,
                            null,
                            "#" + this.slides.eq(this.activeIndex).attr("data-hash") || ""
                        ),
                        this.emit("hashSet");
                    else {
                        var t = this.slides.eq(this.activeIndex),
                            e = t.attr("data-hash") || t.attr("data-history");
                        (i.location.hash = e || ""), this.emit("hashSet");
                    }
            },
            init: function() {
                if (!(!this.params.hashNavigation.enabled ||
                        (this.params.history && this.params.history.enabled)
                    )) {
                    this.hashNavigation.initialized = !0;
                    var t = i.location.hash.replace("#", "");
                    if (t)
                        for (var e = 0, n = this.slides.length; e < n; e += 1) {
                            var a = this.slides.eq(e);
                            if (
                                (a.attr("data-hash") || a.attr("data-history")) === t &&
                                !a.hasClass(this.params.slideDuplicateClass)
                            ) {
                                var o = a.index();
                                this.slideTo(o, 0, this.params.runCallbacksOnInit, !0);
                            }
                        }
                    this.params.hashNavigation.watchState &&
                        r(s).on("hashchange", this.hashNavigation.onHashCange);
                }
            },
            destroy: function() {
                this.params.hashNavigation.watchState &&
                    r(s).off("hashchange", this.hashNavigation.onHashCange);
            },
        },
        mt = {
            run: function() {
                var t = this,
                    e = t.slides.eq(t.activeIndex),
                    i = t.params.autoplay.delay;
                e.attr("data-swiper-autoplay") &&
                    (i = e.attr("data-swiper-autoplay") || t.params.autoplay.delay),
                    clearTimeout(t.autoplay.timeout),
                    (t.autoplay.timeout = c.nextTick(function() {
                        t.params.autoplay.reverseDirection ?
                            t.params.loop ?
                            (t.loopFix(),
                                t.slidePrev(t.params.speed, !0, !0),
                                t.emit("autoplay")) :
                            t.isBeginning ?
                            t.params.autoplay.stopOnLastSlide ?
                            t.autoplay.stop() :
                            (t.slideTo(t.slides.length - 1, t.params.speed, !0, !0),
                                t.emit("autoplay")) :
                            (t.slidePrev(t.params.speed, !0, !0), t.emit("autoplay")) :
                            t.params.loop ?
                            (t.loopFix(),
                                t.slideNext(t.params.speed, !0, !0),
                                t.emit("autoplay")) :
                            t.isEnd ?
                            t.params.autoplay.stopOnLastSlide ?
                            t.autoplay.stop() :
                            (t.slideTo(0, t.params.speed, !0, !0), t.emit("autoplay")) :
                            (t.slideNext(t.params.speed, !0, !0), t.emit("autoplay")),
                            t.params.cssMode && t.autoplay.running && t.autoplay.run();
                    }, i));
            },
            start: function() {
                return (
                    void 0 === this.autoplay.timeout &&
                    !this.autoplay.running &&
                    ((this.autoplay.running = !0),
                        this.emit("autoplayStart"),
                        this.autoplay.run(), !0)
                );
            },
            stop: function() {
                return (!!this.autoplay.running &&
                    void 0 !== this.autoplay.timeout &&
                    (this.autoplay.timeout &&
                        (clearTimeout(this.autoplay.timeout),
                            (this.autoplay.timeout = void 0)),
                        (this.autoplay.running = !1),
                        this.emit("autoplayStop"), !0)
                );
            },
            pause: function(t) {
                this.autoplay.running &&
                    (this.autoplay.paused ||
                        (this.autoplay.timeout && clearTimeout(this.autoplay.timeout),
                            (this.autoplay.paused = !0),
                            0 !== t && this.params.autoplay.waitForTransition ?
                            (this.$wrapperEl[0].addEventListener(
                                    "transitionend",
                                    this.autoplay.onTransitionEnd
                                ),
                                this.$wrapperEl[0].addEventListener(
                                    "webkitTransitionEnd",
                                    this.autoplay.onTransitionEnd
                                )) :
                            ((this.autoplay.paused = !1), this.autoplay.run())));
            },
        },
        vt = {
            setTranslate: function() {
                for (var t = this.slides, e = 0; e < t.length; e += 1) {
                    var i = this.slides.eq(e),
                        n = -i[0].swiperSlideOffset;
                    this.params.virtualTranslate || (n -= this.translate);
                    var s = 0;
                    this.isHorizontal() || ((s = n), (n = 0));
                    var a = this.params.fadeEffect.crossFade ?
                        Math.max(1 - Math.abs(i[0].progress), 0) :
                        1 + Math.min(Math.max(i[0].progress, -1), 0);
                    i.css({
                        opacity: a,
                    }).transform("translate3d(" + n + "px, " + s + "px, 0px)");
                }
            },
            setTransition: function(t) {
                var e = this,
                    i = e.slides,
                    n = e.$wrapperEl;
                if ((i.transition(t), e.params.virtualTranslate && 0 !== t)) {
                    var s = !1;
                    i.transitionEnd(function() {
                        if (!s && e && !e.destroyed) {
                            (s = !0), (e.animating = !1);
                            for (
                                var t = ["webkitTransitionEnd", "transitionend"], i = 0; i < t.length; i += 1
                            )
                                n.trigger(t[i]);
                        }
                    });
                }
            },
        },
        gt = {
            setTranslate: function() {
                var t,
                    e = this.$el,
                    i = this.$wrapperEl,
                    n = this.slides,
                    s = this.width,
                    a = this.height,
                    o = this.rtlTranslate,
                    l = this.size,
                    c = this.params.cubeEffect,
                    d = this.isHorizontal(),
                    u = this.virtual && this.params.virtual.enabled,
                    h = 0;
                c.shadow &&
                    (d ?
                        (0 === (t = i.find(".swiper-cube-shadow")).length &&
                            ((t = r('<div class="swiper-cube-shadow"></div>')),
                                i.append(t)),
                            t.css({
                                height: s + "px",
                            })) :
                        0 === (t = e.find(".swiper-cube-shadow")).length &&
                        ((t = r('<div class="swiper-cube-shadow"></div>')),
                            e.append(t)));
                for (var p = 0; p < n.length; p += 1) {
                    var f = n.eq(p),
                        m = p;
                    u && (m = parseInt(f.attr("data-swiper-slide-index"), 10));
                    var v = 90 * m,
                        g = Math.floor(v / 360);
                    o && ((v = -v), (g = Math.floor(-v / 360)));
                    var y = Math.max(Math.min(f[0].progress, 1), -1),
                        b = 0,
                        w = 0,
                        x = 0;
                    m % 4 == 0 ?
                        ((b = 4 * -g * l), (x = 0)) :
                        (m - 1) % 4 == 0 ?
                        ((b = 0), (x = 4 * -g * l)) :
                        (m - 2) % 4 == 0 ?
                        ((b = l + 4 * g * l), (x = l)) :
                        (m - 3) % 4 == 0 && ((b = -l), (x = 3 * l + 4 * l * g)),
                        o && (b = -b),
                        d || ((w = b), (b = 0));
                    var T =
                        "rotateX(" +
                        (d ? 0 : -v) +
                        "deg) rotateY(" +
                        (d ? v : 0) +
                        "deg) translate3d(" +
                        b +
                        "px, " +
                        w +
                        "px, " +
                        x +
                        "px)";
                    if (
                        (y <= 1 &&
                            y > -1 &&
                            ((h = 90 * m + 90 * y), o && (h = 90 * -m - 90 * y)),
                            f.transform(T),
                            c.slideShadows)
                    ) {
                        var S = d ?
                            f.find(".swiper-slide-shadow-left") :
                            f.find(".swiper-slide-shadow-top"),
                            C = d ?
                            f.find(".swiper-slide-shadow-right") :
                            f.find(".swiper-slide-shadow-bottom");
                        0 === S.length &&
                            ((S = r(
                                    '<div class="swiper-slide-shadow-' +
                                    (d ? "left" : "top") +
                                    '"></div>'
                                )),
                                f.append(S)),
                            0 === C.length &&
                            ((C = r(
                                    '<div class="swiper-slide-shadow-' +
                                    (d ? "right" : "bottom") +
                                    '"></div>'
                                )),
                                f.append(C)),
                            S.length && (S[0].style.opacity = Math.max(-y, 0)),
                            C.length && (C[0].style.opacity = Math.max(y, 0));
                    }
                }
                if (
                    (i.css({
                            "-webkit-transform-origin": "50% 50% -" + l / 2 + "px",
                            "-moz-transform-origin": "50% 50% -" + l / 2 + "px",
                            "-ms-transform-origin": "50% 50% -" + l / 2 + "px",
                            "transform-origin": "50% 50% -" + l / 2 + "px",
                        }),
                        c.shadow)
                )
                    if (d)
                        t.transform(
                            "translate3d(0px, " +
                            (s / 2 + c.shadowOffset) +
                            "px, " +
                            -s / 2 +
                            "px) rotateX(90deg) rotateZ(0deg) scale(" +
                            c.shadowScale +
                            ")"
                        );
                    else {
                        var E = Math.abs(h) - 90 * Math.floor(Math.abs(h) / 90),
                            k =
                            1.5 -
                            (Math.sin((2 * E * Math.PI) / 360) / 2 +
                                Math.cos((2 * E * Math.PI) / 360) / 2),
                            M = c.shadowScale,
                            _ = c.shadowScale / k,
                            P = c.shadowOffset;
                        t.transform(
                            "scale3d(" +
                            M +
                            ", 1, " +
                            _ +
                            ") translate3d(0px, " +
                            (a / 2 + P) +
                            "px, " +
                            -a / 2 / _ +
                            "px) rotateX(-90deg)"
                        );
                    }
                var $ = U.isSafari || U.isUiWebView ? -l / 2 : 0;
                i.transform(
                    "translate3d(0px,0," +
                    $ +
                    "px) rotateX(" +
                    (this.isHorizontal() ? 0 : h) +
                    "deg) rotateY(" +
                    (this.isHorizontal() ? -h : 0) +
                    "deg)"
                );
            },
            setTransition: function(t) {
                var e = this.$el;
                this.slides
                    .transition(t)
                    .find(
                        ".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left"
                    )
                    .transition(t),
                    this.params.cubeEffect.shadow &&
                    !this.isHorizontal() &&
                    e.find(".swiper-cube-shadow").transition(t);
            },
        },
        yt = {
            setTranslate: function() {
                for (
                    var t = this.slides, e = this.rtlTranslate, i = 0; i < t.length; i += 1
                ) {
                    var n = t.eq(i),
                        s = n[0].progress;
                    this.params.flipEffect.limitRotation &&
                        (s = Math.max(Math.min(n[0].progress, 1), -1));
                    var a = -180 * s,
                        o = 0,
                        l = -n[0].swiperSlideOffset,
                        c = 0;
                    if (
                        (this.isHorizontal() ?
                            e && (a = -a) :
                            ((c = l), (l = 0), (o = -a), (a = 0)),
                            (n[0].style.zIndex = -Math.abs(Math.round(s)) + t.length),
                            this.params.flipEffect.slideShadows)
                    ) {
                        var d = this.isHorizontal() ?
                            n.find(".swiper-slide-shadow-left") :
                            n.find(".swiper-slide-shadow-top"),
                            u = this.isHorizontal() ?
                            n.find(".swiper-slide-shadow-right") :
                            n.find(".swiper-slide-shadow-bottom");
                        0 === d.length &&
                            ((d = r(
                                    '<div class="swiper-slide-shadow-' +
                                    (this.isHorizontal() ? "left" : "top") +
                                    '"></div>'
                                )),
                                n.append(d)),
                            0 === u.length &&
                            ((u = r(
                                    '<div class="swiper-slide-shadow-' +
                                    (this.isHorizontal() ? "right" : "bottom") +
                                    '"></div>'
                                )),
                                n.append(u)),
                            d.length && (d[0].style.opacity = Math.max(-s, 0)),
                            u.length && (u[0].style.opacity = Math.max(s, 0));
                    }
                    n.transform(
                        "translate3d(" +
                        l +
                        "px, " +
                        c +
                        "px, 0px) rotateX(" +
                        o +
                        "deg) rotateY(" +
                        a +
                        "deg)"
                    );
                }
            },
            setTransition: function(t) {
                var e = this,
                    i = e.slides,
                    n = e.activeIndex,
                    s = e.$wrapperEl;
                if (
                    (i
                        .transition(t)
                        .find(
                            ".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left"
                        )
                        .transition(t),
                        e.params.virtualTranslate && 0 !== t)
                ) {
                    var a = !1;
                    i.eq(n).transitionEnd(function() {
                        if (!a && e && !e.destroyed) {
                            (a = !0), (e.animating = !1);
                            for (
                                var t = ["webkitTransitionEnd", "transitionend"], i = 0; i < t.length; i += 1
                            )
                                s.trigger(t[i]);
                        }
                    });
                }
            },
        },
        bt = {
            setTranslate: function() {
                for (
                    var t = this.width,
                        e = this.height,
                        i = this.slides,
                        n = this.$wrapperEl,
                        s = this.slidesSizesGrid,
                        a = this.params.coverflowEffect,
                        o = this.isHorizontal(),
                        l = this.translate,
                        c = o ? t / 2 - l : e / 2 - l,
                        u = o ? a.rotate : -a.rotate,
                        h = a.depth,
                        p = 0,
                        f = i.length; p < f; p += 1
                ) {
                    var m = i.eq(p),
                        v = s[p],
                        g = ((c - m[0].swiperSlideOffset - v / 2) / v) * a.modifier,
                        y = o ? u * g : 0,
                        b = o ? 0 : u * g,
                        w = -h * Math.abs(g),
                        x = a.stretch;
                    "string" == typeof x &&
                        -1 !== x.indexOf("%") &&
                        (x = (parseFloat(a.stretch) / 100) * v);
                    var T = o ? 0 : x * g,
                        S = o ? x * g : 0;
                    Math.abs(S) < 0.001 && (S = 0),
                        Math.abs(T) < 0.001 && (T = 0),
                        Math.abs(w) < 0.001 && (w = 0),
                        Math.abs(y) < 0.001 && (y = 0),
                        Math.abs(b) < 0.001 && (b = 0);
                    var C =
                        "translate3d(" +
                        S +
                        "px," +
                        T +
                        "px," +
                        w +
                        "px)  rotateX(" +
                        b +
                        "deg) rotateY(" +
                        y +
                        "deg)";
                    if (
                        (m.transform(C),
                            (m[0].style.zIndex = 1 - Math.abs(Math.round(g))),
                            a.slideShadows)
                    ) {
                        var E = o ?
                            m.find(".swiper-slide-shadow-left") :
                            m.find(".swiper-slide-shadow-top"),
                            k = o ?
                            m.find(".swiper-slide-shadow-right") :
                            m.find(".swiper-slide-shadow-bottom");
                        0 === E.length &&
                            ((E = r(
                                    '<div class="swiper-slide-shadow-' +
                                    (o ? "left" : "top") +
                                    '"></div>'
                                )),
                                m.append(E)),
                            0 === k.length &&
                            ((k = r(
                                    '<div class="swiper-slide-shadow-' +
                                    (o ? "right" : "bottom") +
                                    '"></div>'
                                )),
                                m.append(k)),
                            E.length && (E[0].style.opacity = g > 0 ? g : 0),
                            k.length && (k[0].style.opacity = -g > 0 ? -g : 0);
                    }
                }
                (d.pointerEvents || d.prefixedPointerEvents) &&
                (n[0].style.perspectiveOrigin = c + "px 50%");
            },
            setTransition: function(t) {
                this.slides
                    .transition(t)
                    .find(
                        ".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left"
                    )
                    .transition(t);
            },
        },
        wt = {
            init: function() {
                var t = this.params.thumbs,
                    e = this.constructor;
                t.swiper instanceof e ?
                    ((this.thumbs.swiper = t.swiper),
                        c.extend(this.thumbs.swiper.originalParams, {
                            watchSlidesProgress: !0,
                            slideToClickedSlide: !1,
                        }),
                        c.extend(this.thumbs.swiper.params, {
                            watchSlidesProgress: !0,
                            slideToClickedSlide: !1,
                        })) :
                    c.isObject(t.swiper) &&
                    ((this.thumbs.swiper = new e(
                            c.extend({}, t.swiper, {
                                watchSlidesVisibility: !0,
                                watchSlidesProgress: !0,
                                slideToClickedSlide: !1,
                            })
                        )),
                        (this.thumbs.swiperCreated = !0)),
                    this.thumbs.swiper.$el.addClass(
                        this.params.thumbs.thumbsContainerClass
                    ),
                    this.thumbs.swiper.on("tap", this.thumbs.onThumbClick);
            },
            onThumbClick: function() {
                var t = this.thumbs.swiper;
                if (t) {
                    var e = t.clickedIndex,
                        i = t.clickedSlide;
                    if (!(
                            (i &&
                                r(i).hasClass(this.params.thumbs.slideThumbActiveClass)) ||
                            null == e
                        )) {
                        var n;
                        if (
                            ((n = t.params.loop ?
                                    parseInt(
                                        r(t.clickedSlide).attr("data-swiper-slide-index"),
                                        10
                                    ) :
                                    e),
                                this.params.loop)
                        ) {
                            var s = this.activeIndex;
                            this.slides.eq(s).hasClass(this.params.slideDuplicateClass) &&
                                (this.loopFix(),
                                    (this._clientLeft = this.$wrapperEl[0].clientLeft),
                                    (s = this.activeIndex));
                            var a = this.slides
                                .eq(s)
                                .prevAll('[data-swiper-slide-index="' + n + '"]')
                                .eq(0)
                                .index(),
                                o = this.slides
                                .eq(s)
                                .nextAll('[data-swiper-slide-index="' + n + '"]')
                                .eq(0)
                                .index();
                            n = void 0 === a ? o : void 0 === o ? a : o - s < s - a ? o : a;
                        }
                        this.slideTo(n);
                    }
                }
            },
            update: function(t) {
                var e = this.thumbs.swiper;
                if (e) {
                    var i =
                        "auto" === e.params.slidesPerView ?
                        e.slidesPerViewDynamic() :
                        e.params.slidesPerView,
                        n = this.params.thumbs.autoScrollOffset,
                        s = n && !e.params.loop;
                    if (this.realIndex !== e.realIndex || s) {
                        var a,
                            r,
                            o = e.activeIndex;
                        if (e.params.loop) {
                            e.slides.eq(o).hasClass(e.params.slideDuplicateClass) &&
                                (e.loopFix(),
                                    (e._clientLeft = e.$wrapperEl[0].clientLeft),
                                    (o = e.activeIndex));
                            var l = e.slides
                                .eq(o)
                                .prevAll(
                                    '[data-swiper-slide-index="' + this.realIndex + '"]'
                                )
                                .eq(0)
                                .index(),
                                c = e.slides
                                .eq(o)
                                .nextAll(
                                    '[data-swiper-slide-index="' + this.realIndex + '"]'
                                )
                                .eq(0)
                                .index();
                            (a =
                                void 0 === l ?
                                c :
                                void 0 === c ?
                                l :
                                c - o == o - l ?
                                o :
                                c - o < o - l ?
                                c :
                                l),
                            (r = this.activeIndex > this.previousIndex ? "next" : "prev");
                        } else
                            r = (a = this.realIndex) > this.previousIndex ? "next" : "prev";
                        s && (a += "next" === r ? n : -1 * n),
                            e.visibleSlidesIndexes &&
                            e.visibleSlidesIndexes.indexOf(a) < 0 &&
                            (e.params.centeredSlides ?
                                (a =
                                    a > o ?
                                    a - Math.floor(i / 2) + 1 :
                                    a + Math.floor(i / 2) - 1) :
                                a > o && (a = a - i + 1),
                                e.slideTo(a, t ? 0 : void 0));
                    }
                    var d = 1,
                        u = this.params.thumbs.slideThumbActiveClass;
                    if (
                        (this.params.slidesPerView > 1 &&
                            !this.params.centeredSlides &&
                            (d = this.params.slidesPerView),
                            this.params.thumbs.multipleActiveThumbs || (d = 1),
                            (d = Math.floor(d)),
                            e.slides.removeClass(u),
                            e.params.loop || (e.params.virtual && e.params.virtual.enabled))
                    )
                        for (var h = 0; h < d; h += 1)
                            e.$wrapperEl
                            .children(
                                '[data-swiper-slide-index="' + (this.realIndex + h) + '"]'
                            )
                            .addClass(u);
                    else
                        for (var p = 0; p < d; p += 1)
                            e.slides.eq(this.realIndex + p).addClass(u);
                }
            },
        },
        xt = [
            W,
            G,
            K,
            Q,
            J,
            et,
            nt,
            {
                name: "mousewheel",
                params: {
                    mousewheel: {
                        enabled: !1,
                        releaseOnEdges: !1,
                        invert: !1,
                        forceToAxis: !1,
                        sensitivity: 1,
                        eventsTarged: "container",
                    },
                },
                create: function() {
                    c.extend(this, {
                        mousewheel: {
                            enabled: !1,
                            enable: st.enable.bind(this),
                            disable: st.disable.bind(this),
                            handle: st.handle.bind(this),
                            handleMouseEnter: st.handleMouseEnter.bind(this),
                            handleMouseLeave: st.handleMouseLeave.bind(this),
                            animateSlider: st.animateSlider.bind(this),
                            releaseScroll: st.releaseScroll.bind(this),
                            lastScrollTime: c.now(),
                            lastEventBeforeSnap: void 0,
                            recentWheelEvents: [],
                        },
                    });
                },
                on: {
                    init: function() {
                        !this.params.mousewheel.enabled &&
                            this.params.cssMode &&
                            this.mousewheel.disable(),
                            this.params.mousewheel.enabled && this.mousewheel.enable();
                    },
                    destroy: function() {
                        this.params.cssMode && this.mousewheel.enable(),
                            this.mousewheel.enabled && this.mousewheel.disable();
                    },
                },
            },
            {
                name: "navigation",
                params: {
                    navigation: {
                        nextEl: null,
                        prevEl: null,
                        hideOnClick: !1,
                        disabledClass: "swiper-button-disabled",
                        hiddenClass: "swiper-button-hidden",
                        lockClass: "swiper-button-lock",
                    },
                },
                create: function() {
                    c.extend(this, {
                        navigation: {
                            init: at.init.bind(this),
                            update: at.update.bind(this),
                            destroy: at.destroy.bind(this),
                            onNextClick: at.onNextClick.bind(this),
                            onPrevClick: at.onPrevClick.bind(this),
                        },
                    });
                },
                on: {
                    init: function() {
                        this.navigation.init(), this.navigation.update();
                    },
                    toEdge: function() {
                        this.navigation.update();
                    },
                    fromEdge: function() {
                        this.navigation.update();
                    },
                    destroy: function() {
                        this.navigation.destroy();
                    },
                    click: function(t) {
                        var e,
                            i = this.navigation,
                            n = i.$nextEl,
                            s = i.$prevEl;
                        !this.params.navigation.hideOnClick ||
                            r(t.target).is(s) ||
                            r(t.target).is(n) ||
                            (n ?
                                (e = n.hasClass(this.params.navigation.hiddenClass)) :
                                s && (e = s.hasClass(this.params.navigation.hiddenClass)), !0 === e ?
                                this.emit("navigationShow", this) :
                                this.emit("navigationHide", this),
                                n && n.toggleClass(this.params.navigation.hiddenClass),
                                s && s.toggleClass(this.params.navigation.hiddenClass));
                    },
                },
            },
            {
                name: "pagination",
                params: {
                    pagination: {
                        el: null,
                        bulletElement: "span",
                        clickable: !1,
                        hideOnClick: !1,
                        renderBullet: null,
                        renderProgressbar: null,
                        renderFraction: null,
                        renderCustom: null,
                        progressbarOpposite: !1,
                        type: "bullets",
                        dynamicBullets: !1,
                        dynamicMainBullets: 1,
                        formatFractionCurrent: function(t) {
                            return t;
                        },
                        formatFractionTotal: function(t) {
                            return t;
                        },
                        bulletClass: "swiper-pagination-bullet",
                        bulletActiveClass: "swiper-pagination-bullet-active",
                        modifierClass: "swiper-pagination-",
                        currentClass: "swiper-pagination-current",
                        totalClass: "swiper-pagination-total",
                        hiddenClass: "swiper-pagination-hidden",
                        progressbarFillClass: "swiper-pagination-progressbar-fill",
                        progressbarOppositeClass: "swiper-pagination-progressbar-opposite",
                        clickableClass: "swiper-pagination-clickable",
                        lockClass: "swiper-pagination-lock",
                    },
                },
                create: function() {
                    c.extend(this, {
                        pagination: {
                            init: rt.init.bind(this),
                            render: rt.render.bind(this),
                            update: rt.update.bind(this),
                            destroy: rt.destroy.bind(this),
                            dynamicBulletIndex: 0,
                        },
                    });
                },
                on: {
                    init: function() {
                        this.pagination.init(),
                            this.pagination.render(),
                            this.pagination.update();
                    },
                    activeIndexChange: function() {
                        (this.params.loop || void 0 === this.snapIndex) &&
                        this.pagination.update();
                    },
                    snapIndexChange: function() {
                        this.params.loop || this.pagination.update();
                    },
                    slidesLengthChange: function() {
                        this.params.loop &&
                            (this.pagination.render(), this.pagination.update());
                    },
                    snapGridLengthChange: function() {
                        this.params.loop ||
                            (this.pagination.render(), this.pagination.update());
                    },
                    destroy: function() {
                        this.pagination.destroy();
                    },
                    click: function(t) {
                        this.params.pagination.el &&
                            this.params.pagination.hideOnClick &&
                            this.pagination.$el.length > 0 &&
                            !r(t.target).hasClass(this.params.pagination.bulletClass) &&
                            (!0 ===
                                this.pagination.$el.hasClass(this.params.pagination.hiddenClass) ?
                                this.emit("paginationShow", this) :
                                this.emit("paginationHide", this),
                                this.pagination.$el.toggleClass(
                                    this.params.pagination.hiddenClass
                                ));
                    },
                },
            },
            {
                name: "scrollbar",
                params: {
                    scrollbar: {
                        el: null,
                        dragSize: "auto",
                        hide: !1,
                        draggable: !1,
                        snapOnRelease: !0,
                        lockClass: "swiper-scrollbar-lock",
                        dragClass: "swiper-scrollbar-drag",
                    },
                },
                create: function() {
                    c.extend(this, {
                        scrollbar: {
                            init: ot.init.bind(this),
                            destroy: ot.destroy.bind(this),
                            updateSize: ot.updateSize.bind(this),
                            setTranslate: ot.setTranslate.bind(this),
                            setTransition: ot.setTransition.bind(this),
                            enableDraggable: ot.enableDraggable.bind(this),
                            disableDraggable: ot.disableDraggable.bind(this),
                            setDragPosition: ot.setDragPosition.bind(this),
                            getPointerPosition: ot.getPointerPosition.bind(this),
                            onDragStart: ot.onDragStart.bind(this),
                            onDragMove: ot.onDragMove.bind(this),
                            onDragEnd: ot.onDragEnd.bind(this),
                            isTouched: !1,
                            timeout: null,
                            dragTimeout: null,
                        },
                    });
                },
                on: {
                    init: function() {
                        this.scrollbar.init(),
                            this.scrollbar.updateSize(),
                            this.scrollbar.setTranslate();
                    },
                    update: function() {
                        this.scrollbar.updateSize();
                    },
                    resize: function() {
                        this.scrollbar.updateSize();
                    },
                    observerUpdate: function() {
                        this.scrollbar.updateSize();
                    },
                    setTranslate: function() {
                        this.scrollbar.setTranslate();
                    },
                    setTransition: function(t) {
                        this.scrollbar.setTransition(t);
                    },
                    destroy: function() {
                        this.scrollbar.destroy();
                    },
                },
            },
            {
                name: "parallax",
                params: {
                    parallax: {
                        enabled: !1,
                    },
                },
                create: function() {
                    c.extend(this, {
                        parallax: {
                            setTransform: lt.setTransform.bind(this),
                            setTranslate: lt.setTranslate.bind(this),
                            setTransition: lt.setTransition.bind(this),
                        },
                    });
                },
                on: {
                    beforeInit: function() {
                        this.params.parallax.enabled &&
                            ((this.params.watchSlidesProgress = !0),
                                (this.originalParams.watchSlidesProgress = !0));
                    },
                    init: function() {
                        this.params.parallax.enabled && this.parallax.setTranslate();
                    },
                    setTranslate: function() {
                        this.params.parallax.enabled && this.parallax.setTranslate();
                    },
                    setTransition: function(t) {
                        this.params.parallax.enabled && this.parallax.setTransition(t);
                    },
                },
            },
            {
                name: "zoom",
                params: {
                    zoom: {
                        enabled: !1,
                        maxRatio: 3,
                        minRatio: 1,
                        toggle: !0,
                        containerClass: "swiper-zoom-container",
                        zoomedSlideClass: "swiper-slide-zoomed",
                    },
                },
                create: function() {
                    var t = this,
                        e = {
                            enabled: !1,
                            scale: 1,
                            currentScale: 1,
                            isScaling: !1,
                            gesture: {
                                $slideEl: void 0,
                                slideWidth: void 0,
                                slideHeight: void 0,
                                $imageEl: void 0,
                                $imageWrapEl: void 0,
                                maxRatio: 3,
                            },
                            image: {
                                isTouched: void 0,
                                isMoved: void 0,
                                currentX: void 0,
                                currentY: void 0,
                                minX: void 0,
                                minY: void 0,
                                maxX: void 0,
                                maxY: void 0,
                                width: void 0,
                                height: void 0,
                                startX: void 0,
                                startY: void 0,
                                touchesStart: {},
                                touchesCurrent: {},
                            },
                            velocity: {
                                x: void 0,
                                y: void 0,
                                prevPositionX: void 0,
                                prevPositionY: void 0,
                                prevTime: void 0,
                            },
                        };
                    "onGestureStart onGestureChange onGestureEnd onTouchStart onTouchMove onTouchEnd onTransitionEnd toggle enable disable in out"
                    .split(" ")
                        .forEach(function(i) {
                            e[i] = ct[i].bind(t);
                        }),
                        c.extend(t, {
                            zoom: e,
                        });
                    var i = 1;
                    Object.defineProperty(t.zoom, "scale", {
                        get: function() {
                            return i;
                        },
                        set: function(e) {
                            if (i !== e) {
                                var n = t.zoom.gesture.$imageEl ?
                                    t.zoom.gesture.$imageEl[0] :
                                    void 0,
                                    s = t.zoom.gesture.$slideEl ?
                                    t.zoom.gesture.$slideEl[0] :
                                    void 0;
                                t.emit("zoomChange", e, n, s);
                            }
                            i = e;
                        },
                    });
                },
                on: {
                    init: function() {
                        this.params.zoom.enabled && this.zoom.enable();
                    },
                    destroy: function() {
                        this.zoom.disable();
                    },
                    touchStart: function(t) {
                        this.zoom.enabled && this.zoom.onTouchStart(t);
                    },
                    touchEnd: function(t) {
                        this.zoom.enabled && this.zoom.onTouchEnd(t);
                    },
                    doubleTap: function(t) {
                        this.params.zoom.enabled &&
                            this.zoom.enabled &&
                            this.params.zoom.toggle &&
                            this.zoom.toggle(t);
                    },
                    transitionEnd: function() {
                        this.zoom.enabled &&
                            this.params.zoom.enabled &&
                            this.zoom.onTransitionEnd();
                    },
                    slideChange: function() {
                        this.zoom.enabled &&
                            this.params.zoom.enabled &&
                            this.params.cssMode &&
                            this.zoom.onTransitionEnd();
                    },
                },
            },
            {
                name: "lazy",
                params: {
                    lazy: {
                        enabled: !1,
                        loadPrevNext: !1,
                        loadPrevNextAmount: 1,
                        loadOnTransitionStart: !1,
                        elementClass: "swiper-lazy",
                        loadingClass: "swiper-lazy-loading",
                        loadedClass: "swiper-lazy-loaded",
                        preloaderClass: "swiper-lazy-preloader",
                    },
                },
                create: function() {
                    c.extend(this, {
                        lazy: {
                            initialImageLoaded: !1,
                            load: dt.load.bind(this),
                            loadInSlide: dt.loadInSlide.bind(this),
                        },
                    });
                },
                on: {
                    beforeInit: function() {
                        this.params.lazy.enabled &&
                            this.params.preloadImages &&
                            (this.params.preloadImages = !1);
                    },
                    init: function() {
                        this.params.lazy.enabled &&
                            !this.params.loop &&
                            0 === this.params.initialSlide &&
                            this.lazy.load();
                    },
                    scroll: function() {
                        this.params.freeMode &&
                            !this.params.freeModeSticky &&
                            this.lazy.load();
                    },
                    resize: function() {
                        this.params.lazy.enabled && this.lazy.load();
                    },
                    scrollbarDragMove: function() {
                        this.params.lazy.enabled && this.lazy.load();
                    },
                    transitionStart: function() {
                        this.params.lazy.enabled &&
                            (this.params.lazy.loadOnTransitionStart ||
                                (!this.params.lazy.loadOnTransitionStart &&
                                    !this.lazy.initialImageLoaded)) &&
                            this.lazy.load();
                    },
                    transitionEnd: function() {
                        this.params.lazy.enabled &&
                            !this.params.lazy.loadOnTransitionStart &&
                            this.lazy.load();
                    },
                    slideChange: function() {
                        this.params.lazy.enabled &&
                            this.params.cssMode &&
                            this.lazy.load();
                    },
                },
            },
            {
                name: "controller",
                params: {
                    controller: {
                        control: void 0,
                        inverse: !1,
                        by: "slide",
                    },
                },
                create: function() {
                    c.extend(this, {
                        controller: {
                            control: this.params.controller.control,
                            getInterpolateFunction: ut.getInterpolateFunction.bind(this),
                            setTranslate: ut.setTranslate.bind(this),
                            setTransition: ut.setTransition.bind(this),
                        },
                    });
                },
                on: {
                    update: function() {
                        this.controller.control &&
                            this.controller.spline &&
                            ((this.controller.spline = void 0),
                                delete this.controller.spline);
                    },
                    resize: function() {
                        this.controller.control &&
                            this.controller.spline &&
                            ((this.controller.spline = void 0),
                                delete this.controller.spline);
                    },
                    observerUpdate: function() {
                        this.controller.control &&
                            this.controller.spline &&
                            ((this.controller.spline = void 0),
                                delete this.controller.spline);
                    },
                    setTranslate: function(t, e) {
                        this.controller.control && this.controller.setTranslate(t, e);
                    },
                    setTransition: function(t, e) {
                        this.controller.control && this.controller.setTransition(t, e);
                    },
                },
            },
            {
                name: "a11y",
                params: {
                    a11y: {
                        enabled: !0,
                        notificationClass: "swiper-notification",
                        prevSlideMessage: "Previous slide",
                        nextSlideMessage: "Next slide",
                        firstSlideMessage: "This is the first slide",
                        lastSlideMessage: "This is the last slide",
                        paginationBulletMessage: "Go to slide {{index}}",
                    },
                },
                create: function() {
                    var t = this;
                    c.extend(t, {
                            a11y: {
                                liveRegion: r(
                                    '<span class="' +
                                    t.params.a11y.notificationClass +
                                    '" aria-live="assertive" aria-atomic="true"></span>'
                                ),
                            },
                        }),
                        Object.keys(ht).forEach(function(e) {
                            t.a11y[e] = ht[e].bind(t);
                        });
                },
                on: {
                    init: function() {
                        this.params.a11y.enabled &&
                            (this.a11y.init(), this.a11y.updateNavigation());
                    },
                    toEdge: function() {
                        this.params.a11y.enabled && this.a11y.updateNavigation();
                    },
                    fromEdge: function() {
                        this.params.a11y.enabled && this.a11y.updateNavigation();
                    },
                    paginationUpdate: function() {
                        this.params.a11y.enabled && this.a11y.updatePagination();
                    },
                    destroy: function() {
                        this.params.a11y.enabled && this.a11y.destroy();
                    },
                },
            },
            {
                name: "history",
                params: {
                    history: {
                        enabled: !1,
                        replaceState: !1,
                        key: "slides",
                    },
                },
                create: function() {
                    c.extend(this, {
                        history: {
                            init: pt.init.bind(this),
                            setHistory: pt.setHistory.bind(this),
                            setHistoryPopState: pt.setHistoryPopState.bind(this),
                            scrollToSlide: pt.scrollToSlide.bind(this),
                            destroy: pt.destroy.bind(this),
                        },
                    });
                },
                on: {
                    init: function() {
                        this.params.history.enabled && this.history.init();
                    },
                    destroy: function() {
                        this.params.history.enabled && this.history.destroy();
                    },
                    transitionEnd: function() {
                        this.history.initialized &&
                            this.history.setHistory(
                                this.params.history.key,
                                this.activeIndex
                            );
                    },
                    slideChange: function() {
                        this.history.initialized &&
                            this.params.cssMode &&
                            this.history.setHistory(
                                this.params.history.key,
                                this.activeIndex
                            );
                    },
                },
            },
            {
                name: "hash-navigation",
                params: {
                    hashNavigation: {
                        enabled: !1,
                        replaceState: !1,
                        watchState: !1,
                    },
                },
                create: function() {
                    c.extend(this, {
                        hashNavigation: {
                            initialized: !1,
                            init: ft.init.bind(this),
                            destroy: ft.destroy.bind(this),
                            setHash: ft.setHash.bind(this),
                            onHashCange: ft.onHashCange.bind(this),
                        },
                    });
                },
                on: {
                    init: function() {
                        this.params.hashNavigation.enabled && this.hashNavigation.init();
                    },
                    destroy: function() {
                        this.params.hashNavigation.enabled &&
                            this.hashNavigation.destroy();
                    },
                    transitionEnd: function() {
                        this.hashNavigation.initialized && this.hashNavigation.setHash();
                    },
                    slideChange: function() {
                        this.hashNavigation.initialized &&
                            this.params.cssMode &&
                            this.hashNavigation.setHash();
                    },
                },
            },
            {
                name: "autoplay",
                params: {
                    autoplay: {
                        enabled: !1,
                        delay: 3e3,
                        waitForTransition: !0,
                        disableOnInteraction: !0,
                        stopOnLastSlide: !1,
                        reverseDirection: !1,
                    },
                },
                create: function() {
                    var t = this;
                    c.extend(t, {
                        autoplay: {
                            running: !1,
                            paused: !1,
                            run: mt.run.bind(t),
                            start: mt.start.bind(t),
                            stop: mt.stop.bind(t),
                            pause: mt.pause.bind(t),
                            onVisibilityChange: function() {
                                "hidden" === document.visibilityState &&
                                    t.autoplay.running &&
                                    t.autoplay.pause(),
                                    "visible" === document.visibilityState &&
                                    t.autoplay.paused &&
                                    (t.autoplay.run(), (t.autoplay.paused = !1));
                            },
                            onTransitionEnd: function(e) {
                                t &&
                                    !t.destroyed &&
                                    t.$wrapperEl &&
                                    e.target === this &&
                                    (t.$wrapperEl[0].removeEventListener(
                                            "transitionend",
                                            t.autoplay.onTransitionEnd
                                        ),
                                        t.$wrapperEl[0].removeEventListener(
                                            "webkitTransitionEnd",
                                            t.autoplay.onTransitionEnd
                                        ),
                                        (t.autoplay.paused = !1),
                                        t.autoplay.running ? t.autoplay.run() : t.autoplay.stop());
                            },
                        },
                    });
                },
                on: {
                    init: function() {
                        this.params.autoplay.enabled &&
                            (this.autoplay.start(),
                                document.addEventListener(
                                    "visibilitychange",
                                    this.autoplay.onVisibilityChange
                                ));
                    },
                    beforeTransitionStart: function(t, e) {
                        this.autoplay.running &&
                            (e || !this.params.autoplay.disableOnInteraction ?
                                this.autoplay.pause(t) :
                                this.autoplay.stop());
                    },
                    sliderFirstMove: function() {
                        this.autoplay.running &&
                            (this.params.autoplay.disableOnInteraction ?
                                this.autoplay.stop() :
                                this.autoplay.pause());
                    },
                    touchEnd: function() {
                        this.params.cssMode &&
                            this.autoplay.paused &&
                            !this.params.autoplay.disableOnInteraction &&
                            this.autoplay.run();
                    },
                    destroy: function() {
                        this.autoplay.running && this.autoplay.stop(),
                            document.removeEventListener(
                                "visibilitychange",
                                this.autoplay.onVisibilityChange
                            );
                    },
                },
            },
            {
                name: "effect-fade",
                params: {
                    fadeEffect: {
                        crossFade: !1,
                    },
                },
                create: function() {
                    c.extend(this, {
                        fadeEffect: {
                            setTranslate: vt.setTranslate.bind(this),
                            setTransition: vt.setTransition.bind(this),
                        },
                    });
                },
                on: {
                    beforeInit: function() {
                        if ("fade" === this.params.effect) {
                            this.classNames.push(
                                this.params.containerModifierClass + "fade"
                            );
                            var t = {
                                slidesPerView: 1,
                                slidesPerColumn: 1,
                                slidesPerGroup: 1,
                                watchSlidesProgress: !0,
                                spaceBetween: 0,
                                virtualTranslate: !0,
                            };
                            c.extend(this.params, t), c.extend(this.originalParams, t);
                        }
                    },
                    setTranslate: function() {
                        "fade" === this.params.effect && this.fadeEffect.setTranslate();
                    },
                    setTransition: function(t) {
                        "fade" === this.params.effect && this.fadeEffect.setTransition(t);
                    },
                },
            },
            {
                name: "effect-cube",
                params: {
                    cubeEffect: {
                        slideShadows: !0,
                        shadow: !0,
                        shadowOffset: 20,
                        shadowScale: 0.94,
                    },
                },
                create: function() {
                    c.extend(this, {
                        cubeEffect: {
                            setTranslate: gt.setTranslate.bind(this),
                            setTransition: gt.setTransition.bind(this),
                        },
                    });
                },
                on: {
                    beforeInit: function() {
                        if ("cube" === this.params.effect) {
                            this.classNames.push(
                                    this.params.containerModifierClass + "cube"
                                ),
                                this.classNames.push(
                                    this.params.containerModifierClass + "3d"
                                );
                            var t = {
                                slidesPerView: 1,
                                slidesPerColumn: 1,
                                slidesPerGroup: 1,
                                watchSlidesProgress: !0,
                                resistanceRatio: 0,
                                spaceBetween: 0,
                                centeredSlides: !1,
                                virtualTranslate: !0,
                            };
                            c.extend(this.params, t), c.extend(this.originalParams, t);
                        }
                    },
                    setTranslate: function() {
                        "cube" === this.params.effect && this.cubeEffect.setTranslate();
                    },
                    setTransition: function(t) {
                        "cube" === this.params.effect && this.cubeEffect.setTransition(t);
                    },
                },
            },
            {
                name: "effect-flip",
                params: {
                    flipEffect: {
                        slideShadows: !0,
                        limitRotation: !0,
                    },
                },
                create: function() {
                    c.extend(this, {
                        flipEffect: {
                            setTranslate: yt.setTranslate.bind(this),
                            setTransition: yt.setTransition.bind(this),
                        },
                    });
                },
                on: {
                    beforeInit: function() {
                        if ("flip" === this.params.effect) {
                            this.classNames.push(
                                    this.params.containerModifierClass + "flip"
                                ),
                                this.classNames.push(
                                    this.params.containerModifierClass + "3d"
                                );
                            var t = {
                                slidesPerView: 1,
                                slidesPerColumn: 1,
                                slidesPerGroup: 1,
                                watchSlidesProgress: !0,
                                spaceBetween: 0,
                                virtualTranslate: !0,
                            };
                            c.extend(this.params, t), c.extend(this.originalParams, t);
                        }
                    },
                    setTranslate: function() {
                        "flip" === this.params.effect && this.flipEffect.setTranslate();
                    },
                    setTransition: function(t) {
                        "flip" === this.params.effect && this.flipEffect.setTransition(t);
                    },
                },
            },
            {
                name: "effect-coverflow",
                params: {
                    coverflowEffect: {
                        rotate: 50,
                        stretch: 0,
                        depth: 100,
                        modifier: 1,
                        slideShadows: !0,
                    },
                },
                create: function() {
                    c.extend(this, {
                        coverflowEffect: {
                            setTranslate: bt.setTranslate.bind(this),
                            setTransition: bt.setTransition.bind(this),
                        },
                    });
                },
                on: {
                    beforeInit: function() {
                        "coverflow" === this.params.effect &&
                            (this.classNames.push(
                                    this.params.containerModifierClass + "coverflow"
                                ),
                                this.classNames.push(this.params.containerModifierClass + "3d"),
                                (this.params.watchSlidesProgress = !0),
                                (this.originalParams.watchSlidesProgress = !0));
                    },
                    setTranslate: function() {
                        "coverflow" === this.params.effect &&
                            this.coverflowEffect.setTranslate();
                    },
                    setTransition: function(t) {
                        "coverflow" === this.params.effect &&
                            this.coverflowEffect.setTransition(t);
                    },
                },
            },
            {
                name: "thumbs",
                params: {
                    thumbs: {
                        swiper: null,
                        multipleActiveThumbs: !0,
                        autoScrollOffset: 0,
                        slideThumbActiveClass: "swiper-slide-thumb-active",
                        thumbsContainerClass: "swiper-container-thumbs",
                    },
                },
                create: function() {
                    c.extend(this, {
                        thumbs: {
                            swiper: null,
                            init: wt.init.bind(this),
                            update: wt.update.bind(this),
                            onThumbClick: wt.onThumbClick.bind(this),
                        },
                    });
                },
                on: {
                    beforeInit: function() {
                        var t = this.params.thumbs;
                        t && t.swiper && (this.thumbs.init(), this.thumbs.update(!0));
                    },
                    slideChange: function() {
                        this.thumbs.swiper && this.thumbs.update();
                    },
                    update: function() {
                        this.thumbs.swiper && this.thumbs.update();
                    },
                    resize: function() {
                        this.thumbs.swiper && this.thumbs.update();
                    },
                    observerUpdate: function() {
                        this.thumbs.swiper && this.thumbs.update();
                    },
                    setTransition: function(t) {
                        var e = this.thumbs.swiper;
                        e && e.setTransition(t);
                    },
                    beforeDestroy: function() {
                        var t = this.thumbs.swiper;
                        t && this.thumbs.swiperCreated && t && t.destroy();
                    },
                },
            },
        ];
    return (
        void 0 === X.use &&
        ((X.use = X.Class.use), (X.installModule = X.Class.installModule)),
        X.use(xt),
        X
    );
}),
(function(t) {
    "use strict";
    (t.fn.fitVids = function(e) {
        var i = {
            customSelector: null,
            ignore: null,
        };
        if (!document.getElementById("fit-vids-style")) {
            var n = document.head || document.getElementsByTagName("head")[0],
                s = document.createElement("div");
            (s.innerHTML =
                '<p>x</p><style id="fit-vids-style">.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>'),
            n.appendChild(s.childNodes[1]);
        }
        return (
            e && t.extend(i, e),
            this.each(function() {
                var e = [
                    'iframe[src*="player.vimeo.com"]',
                    'iframe[src*="youtube.com"]',
                    'iframe[src*="youtube-nocookie.com"]',
                    'iframe[src*="kickstarter.com"][src*="video.html"]',
                    "object",
                    "embed",
                ];
                i.customSelector && e.push(i.customSelector);
                var n = ".fitvidsignore";
                i.ignore && (n = n + ", " + i.ignore);
                var s = t(this).find(e.join(","));
                (s = (s = s.not("object object")).not(n)).each(function() {
                    var e = t(this);
                    if (!(
                            e.parents(n).length > 0 ||
                            ("embed" === this.tagName.toLowerCase() &&
                                e.parent("object").length) ||
                            e.parent(".fluid-width-video-wrapper").length
                        )) {
                        e.css("height") ||
                            e.css("width") ||
                            (!isNaN(e.attr("height")) && !isNaN(e.attr("width"))) ||
                            (e.attr("height", 9), e.attr("width", 16));
                        var i =
                            ("object" === this.tagName.toLowerCase() ||
                                (e.attr("height") && !isNaN(parseInt(e.attr("height"), 10))) ?
                                parseInt(e.attr("height"), 10) :
                                e.height()) /
                            (isNaN(parseInt(e.attr("width"), 10)) ?
                                e.width() :
                                parseInt(e.attr("width"), 10));
                        if (!e.attr("name")) {
                            var s = "fitvid" + t.fn.fitVids._count;
                            e.attr("name", s), t.fn.fitVids._count++;
                        }
                        e
                            .wrap('<div class="fluid-width-video-wrapper"></div>')
                            .parent(".fluid-width-video-wrapper")
                            .css("padding-top", 100 * i + "%"),
                            e.removeAttr("height").removeAttr("width");
                    }
                });
            })
        );
    }),
    (t.fn.fitVids._count = 0);
})(window.jQuery || window.Zepto),
(function(t, e, i, n) {
    "use strict";

    function s(t, e) {
        var n,
            s,
            a,
            r = [],
            o = 0;
        (t && t.isDefaultPrevented()) ||
        (t.preventDefault(),
            (e = e || {}),
            t && t.data && (e = p(t.data.options, e)),
            (n = e.$target || i(t.currentTarget).trigger("blur")),
            ((a = i.fancybox.getInstance()) && a.$trigger && a.$trigger.is(n)) ||
            (e.selector ?
                (r = i(e.selector)) :
                (s = n.attr("data-fancybox") || "") ?
                (r = (r = t.data ? t.data.items : []).length ?
                    r.filter('[data-fancybox="' + s + '"]') :
                    i('[data-fancybox="' + s + '"]')) :
                (r = [n]),
                (o = i(r).index(n)) < 0 && (o = 0),
                ((a = i.fancybox.open(r, e, o)).$trigger = n)));
    }
    if (
        ((t.console = t.console || {
                info: function(t) {},
            }),
            i)
    ) {
        if (i.fn.fancybox)
            return void console.info("fancyBox already initialized");
        var a = {
                closeExisting: !1,
                loop: !1,
                gutter: 50,
                keyboard: !0,
                preventCaptionOverlap: !0,
                arrows: !0,
                infobar: !0,
                smallBtn: "auto",
                toolbar: "auto",
                buttons: ["zoom", "slideShow", "thumbs", "close"],
                idleTime: 3,
                protect: !1,
                modal: !1,
                image: {
                    preload: !1,
                },
                ajax: {
                    settings: {
                        data: {
                            fancybox: !0,
                        },
                    },
                },
                iframe: {
                    tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" allowfullscreen="allowfullscreen" allow="autoplay; fullscreen" src=""></iframe>',
                    preload: !0,
                    css: {},
                    attr: {
                        scrolling: "auto",
                    },
                },
                video: {
                    tpl: '<video class="fancybox-video" controls controlsList="nodownload" poster="{{poster}}"><source src="{{src}}" type="{{format}}" />Sorry, your browser doesn\'t support embedded videos, <a href="{{src}}">download</a> and watch with your favorite video player!</video>',
                    format: "",
                    autoStart: !0,
                },
                defaultType: "image",
                animationEffect: "zoom",
                animationDuration: 366,
                zoomOpacity: "auto",
                transitionEffect: "fade",
                transitionDuration: 366,
                slideClass: "",
                baseClass: "",
                baseTpl: '<div class="fancybox-container" role="dialog" tabindex="-1"><div class="fancybox-bg"></div><div class="fancybox-inner"><div class="fancybox-infobar"><span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span></div><div class="fancybox-toolbar">{{buttons}}</div><div class="fancybox-navigation">{{arrows}}</div><div class="fancybox-stage"></div><div class="fancybox-caption"><div class="fancybox-caption__body"></div></div></div></div>',
                spinnerTpl: '<div class="fancybox-loading"></div>',
                errorTpl: '<div class="fancybox-error"><p>{{ERROR}}</p></div>',
                btnTpl: {
                    download: '<a download data-fancybox-download class="fancybox-button fancybox-button--download" title="{{DOWNLOAD}}" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.62 17.09V19H5.38v-1.91zm-2.97-6.96L17 11.45l-5 4.87-5-4.87 1.36-1.32 2.68 2.64V5h1.92v7.77z"/></svg></a>',
                    zoom: '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="{{ZOOM}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.7 17.3l-3-3a5.9 5.9 0 0 0-.6-7.6 5.9 5.9 0 0 0-8.4 0 5.9 5.9 0 0 0 0 8.4 5.9 5.9 0 0 0 7.7.7l3 3a1 1 0 0 0 1.3 0c.4-.5.4-1 0-1.5zM8.1 13.8a4 4 0 0 1 0-5.7 4 4 0 0 1 5.7 0 4 4 0 0 1 0 5.7 4 4 0 0 1-5.7 0z"/></svg></button>',
                    close: '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"/></svg></button>',
                    arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}"><div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.28 15.7l-1.34 1.37L5 12l4.94-5.07 1.34 1.38-2.68 2.72H19v1.94H8.6z"/></svg></div></button>',
                    arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}"><div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.4 12.97l-2.68 2.72 1.34 1.38L19 12l-4.94-5.07-1.34 1.38 2.68 2.72H5v1.94z"/></svg></div></button>',
                    smallBtn: '<button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="{{CLOSE}}"><svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"/></svg></button>',
                },
                parentEl: "body",
                hideScrollbar: !0,
                autoFocus: !0,
                backFocus: !0,
                trapFocus: !0,
                fullScreen: {
                    autoStart: !1,
                },
                touch: {
                    vertical: !0,
                    momentum: !0,
                },
                hash: null,
                media: {},
                slideShow: {
                    autoStart: !1,
                    speed: 3e3,
                },
                thumbs: {
                    autoStart: !1,
                    hideOnClose: !0,
                    parentEl: ".fancybox-container",
                    axis: "y",
                },
                wheel: "auto",
                onInit: i.noop,
                beforeLoad: i.noop,
                afterLoad: i.noop,
                beforeShow: i.noop,
                afterShow: i.noop,
                beforeClose: i.noop,
                afterClose: i.noop,
                onActivate: i.noop,
                onDeactivate: i.noop,
                clickContent: function(t, e) {
                    return "image" === t.type && "zoom";
                },
                clickSlide: "close",
                clickOutside: "close",
                dblclickContent: !1,
                dblclickSlide: !1,
                dblclickOutside: !1,
                mobile: {
                    preventCaptionOverlap: !1,
                    idleTime: !1,
                    clickContent: function(t, e) {
                        return "image" === t.type && "toggleControls";
                    },
                    clickSlide: function(t, e) {
                        return "image" === t.type ? "toggleControls" : "close";
                    },
                    dblclickContent: function(t, e) {
                        return "image" === t.type && "zoom";
                    },
                    dblclickSlide: function(t, e) {
                        return "image" === t.type && "zoom";
                    },
                },
                lang: "en",
                i18n: {
                    en: {
                        CLOSE: "Close",
                        NEXT: "Next",
                        PREV: "Previous",
                        ERROR: "The requested content cannot be loaded. <br/> Please try again later.",
                        PLAY_START: "Start slideshow",
                        PLAY_STOP: "Pause slideshow",
                        FULL_SCREEN: "Full screen",
                        THUMBS: "Thumbnails",
                        DOWNLOAD: "Download",
                        SHARE: "Share",
                        ZOOM: "Zoom",
                    },
                    de: {
                        CLOSE: "Schlie&szlig;en",
                        NEXT: "Weiter",
                        PREV: "Zur&uuml;ck",
                        ERROR: "Die angeforderten Daten konnten nicht geladen werden. <br/> Bitte versuchen Sie es sp&auml;ter nochmal.",
                        PLAY_START: "Diaschau starten",
                        PLAY_STOP: "Diaschau beenden",
                        FULL_SCREEN: "Vollbild",
                        THUMBS: "Vorschaubilder",
                        DOWNLOAD: "Herunterladen",
                        SHARE: "Teilen",
                        ZOOM: "Vergr&ouml;&szlig;ern",
                    },
                },
            },
            r = i(t),
            o = i(e),
            l = 0,
            c =
            t.requestAnimationFrame ||
            t.webkitRequestAnimationFrame ||
            t.mozRequestAnimationFrame ||
            t.oRequestAnimationFrame ||
            function(e) {
                return t.setTimeout(e, 1e3 / 60);
            },
            d =
            t.cancelAnimationFrame ||
            t.webkitCancelAnimationFrame ||
            t.mozCancelAnimationFrame ||
            t.oCancelAnimationFrame ||
            function(e) {
                t.clearTimeout(e);
            },
            u = (function() {
                var t,
                    i = e.createElement("fakeelement"),
                    n = {
                        transition: "transitionend",
                        OTransition: "oTransitionEnd",
                        MozTransition: "transitionend",
                        WebkitTransition: "webkitTransitionEnd",
                    };
                for (t in n)
                    if (void 0 !== i.style[t]) return n[t];
                return "transitionend";
            })(),
            h = function(t) {
                return t && t.length && t[0].offsetHeight;
            },
            p = function(t, e) {
                var n = i.extend(!0, {}, t, e);
                return (
                    i.each(e, function(t, e) {
                        i.isArray(e) && (n[t] = e);
                    }),
                    n
                );
            },
            f = function(t) {
                var n, s;
                return (!(!t || t.ownerDocument !== e) &&
                    (i(".fancybox-container").css("pointer-events", "none"),
                        (n = {
                            x: t.getBoundingClientRect().left + t.offsetWidth / 2,
                            y: t.getBoundingClientRect().top + t.offsetHeight / 2,
                        }),
                        (s = e.elementFromPoint(n.x, n.y) === t),
                        i(".fancybox-container").css("pointer-events", ""),
                        s)
                );
            },
            m = function(t, e, n) {
                var s = this;
                (s.opts = p({
                        index: n,
                    },
                    i.fancybox.defaults
                )),
                i.isPlainObject(e) && (s.opts = p(s.opts, e)),
                    i.fancybox.isMobile && (s.opts = p(s.opts, s.opts.mobile)),
                    (s.id = s.opts.id || ++l),
                    (s.currIndex = parseInt(s.opts.index, 10) || 0),
                    (s.prevIndex = null),
                    (s.prevPos = null),
                    (s.currPos = 0),
                    (s.firstRun = !0),
                    (s.group = []),
                    (s.slides = {}),
                    s.addContent(t),
                    s.group.length && s.init();
            };
        i.extend(m.prototype, {
                init: function() {
                    var n,
                        s,
                        a = this,
                        r = a.group[a.currIndex].opts;
                    r.closeExisting && i.fancybox.close(!0),
                        i("body").addClass("fancybox-active"), !i.fancybox.getInstance() &&
                        !1 !== r.hideScrollbar &&
                        !i.fancybox.isMobile &&
                        e.body.scrollHeight > t.innerHeight &&
                        (i("head").append(
                                '<style id="fancybox-style-noscroll" type="text/css">.compensate-for-scrollbar{margin-right:' +
                                (t.innerWidth - e.documentElement.clientWidth) +
                                "px;}</style>"
                            ),
                            i("body").addClass("compensate-for-scrollbar")),
                        (s = ""),
                        i.each(r.buttons, function(t, e) {
                            s += r.btnTpl[e] || "";
                        }),
                        (n = i(
                                a.translate(
                                    a,
                                    r.baseTpl
                                    .replace("{{buttons}}", s)
                                    .replace(
                                        "{{arrows}}",
                                        r.btnTpl.arrowLeft + r.btnTpl.arrowRight
                                    )
                                )
                            )
                            .attr("id", "fancybox-container-" + a.id)
                            .addClass(r.baseClass)
                            .data("FancyBox", a)
                            .appendTo(r.parentEl)),
                        (a.$refs = {
                            container: n,
                        }), [
                            "bg",
                            "inner",
                            "infobar",
                            "toolbar",
                            "stage",
                            "caption",
                            "navigation",
                        ].forEach(function(t) {
                            a.$refs[t] = n.find(".fancybox-" + t);
                        }),
                        a.trigger("onInit"),
                        a.activate(),
                        a.jumpTo(a.currIndex);
                },
                translate: function(t, e) {
                    var i = t.opts.i18n[t.opts.lang] || t.opts.i18n.en;
                    return e.replace(/\{\{(\w+)\}\}/g, function(t, e) {
                        return void 0 === i[e] ? t : i[e];
                    });
                },
                addContent: function(t) {
                    var e,
                        n = this,
                        s = i.makeArray(t);
                    i.each(s, function(t, e) {
                            var s,
                                a,
                                r,
                                o,
                                l,
                                c = {},
                                d = {};
                            i.isPlainObject(e) ?
                                ((c = e), (d = e.opts || e)) :
                                "object" === i.type(e) && i(e).length ?
                                ((d = (s = i(e)).data() || {}),
                                    ((d = i.extend(!0, {}, d, d.options)).$orig = s),
                                    (c.src = n.opts.src || d.src || s.attr("href")),
                                    c.type || c.src || ((c.type = "inline"), (c.src = e))) :
                                (c = {
                                    type: "html",
                                    src: e + "",
                                }),
                                (c.opts = i.extend(!0, {}, n.opts, d)),
                                i.isArray(d.buttons) && (c.opts.buttons = d.buttons),
                                i.fancybox.isMobile &&
                                c.opts.mobile &&
                                (c.opts = p(c.opts, c.opts.mobile)),
                                (a = c.type || c.opts.type),
                                (o = c.src || ""), !a &&
                                o &&
                                ((r = o.match(/\.(mp4|mov|ogv|webm)((\?|#).*)?$/i)) ?
                                    ((a = "video"),
                                        c.opts.video.format ||
                                        (c.opts.video.format =
                                            "video/" + ("ogv" === r[1] ? "ogg" : r[1]))) :
                                    o.match(
                                        /(^data:image\/[a-z0-9+\/=]*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg|ico)((\?|#).*)?$)/i
                                    ) ?
                                    (a = "image") :
                                    o.match(/\.(pdf)((\?|#).*)?$/i) ?
                                    ((a = "iframe"),
                                        (c = i.extend(!0, c, {
                                            contentType: "pdf",
                                            opts: {
                                                iframe: {
                                                    preload: !1,
                                                },
                                            },
                                        }))) :
                                    "#" === o.charAt(0) && (a = "inline")),
                                a ? (c.type = a) : n.trigger("objectNeedsType", c),
                                c.contentType ||
                                (c.contentType =
                                    i.inArray(c.type, ["html", "inline", "ajax"]) > -1 ?
                                    "html" :
                                    c.type),
                                (c.index = n.group.length),
                                "auto" == c.opts.smallBtn &&
                                (c.opts.smallBtn =
                                    i.inArray(c.type, ["html", "inline", "ajax"]) > -1),
                                "auto" === c.opts.toolbar && (c.opts.toolbar = !c.opts.smallBtn),
                                (c.$thumb = c.opts.$thumb || null),
                                c.opts.$trigger &&
                                c.index === n.opts.index &&
                                ((c.$thumb = c.opts.$trigger.find("img:first")),
                                    c.$thumb.length && (c.opts.$orig = c.opts.$trigger)),
                                (c.$thumb && c.$thumb.length) ||
                                !c.opts.$orig ||
                                (c.$thumb = c.opts.$orig.find("img:first")),
                                c.$thumb && !c.$thumb.length && (c.$thumb = null),
                                (c.thumb = c.opts.thumb || (c.$thumb ? c.$thumb[0].src : null)),
                                "function" === i.type(c.opts.caption) &&
                                (c.opts.caption = c.opts.caption.apply(e, [n, c])),
                                "function" === i.type(n.opts.caption) &&
                                (c.opts.caption = n.opts.caption.apply(e, [n, c])),
                                c.opts.caption instanceof i ||
                                (c.opts.caption =
                                    void 0 === c.opts.caption ? "" : c.opts.caption + ""),
                                "ajax" === c.type &&
                                (l = o.split(/\s+/, 2)).length > 1 &&
                                ((c.src = l.shift()), (c.opts.filter = l.shift())),
                                c.opts.modal &&
                                (c.opts = i.extend(!0, c.opts, {
                                    trapFocus: !0,
                                    infobar: 0,
                                    toolbar: 0,
                                    smallBtn: 0,
                                    keyboard: 0,
                                    slideShow: 0,
                                    fullScreen: 0,
                                    thumbs: 0,
                                    touch: 0,
                                    clickContent: !1,
                                    clickSlide: !1,
                                    clickOutside: !1,
                                    dblclickContent: !1,
                                    dblclickSlide: !1,
                                    dblclickOutside: !1,
                                })),
                                n.group.push(c);
                        }),
                        Object.keys(n.slides).length &&
                        (n.updateControls(),
                            (e = n.Thumbs) && e.isActive && (e.create(), e.focus()));
                },
                addEvents: function() {
                    var e = this;
                    e.removeEvents(),
                        e.$refs.container
                        .on("click.fb-close", "[data-fancybox-close]", function(t) {
                            t.stopPropagation(), t.preventDefault(), e.close(t);
                        })
                        .on(
                            "touchstart.fb-prev click.fb-prev",
                            "[data-fancybox-prev]",
                            function(t) {
                                t.stopPropagation(), t.preventDefault(), e.previous();
                            }
                        )
                        .on(
                            "touchstart.fb-next click.fb-next",
                            "[data-fancybox-next]",
                            function(t) {
                                t.stopPropagation(), t.preventDefault(), e.next();
                            }
                        )
                        .on("click.fb", "[data-fancybox-zoom]", function(t) {
                            e[e.isScaledDown() ? "scaleToActual" : "scaleToFit"]();
                        }),
                        r.on("orientationchange.fb resize.fb", function(t) {
                            t && t.originalEvent && "resize" === t.originalEvent.type ?
                                (e.requestId && d(e.requestId),
                                    (e.requestId = c(function() {
                                        e.update(t);
                                    }))) :
                                (e.current &&
                                    "iframe" === e.current.type &&
                                    e.$refs.stage.hide(),
                                    setTimeout(
                                        function() {
                                            e.$refs.stage.show(), e.update(t);
                                        },
                                        i.fancybox.isMobile ? 600 : 250
                                    ));
                        }),
                        o.on("keydown.fb", function(t) {
                            var n = (i.fancybox ? i.fancybox.getInstance() : null).current,
                                s = t.keyCode || t.which;
                            if (9 != s)
                                return !n.opts.keyboard ||
                                    t.ctrlKey ||
                                    t.altKey ||
                                    t.shiftKey ||
                                    i(t.target).is("input,textarea,video,audio,select") ?
                                    void 0 :
                                    8 === s || 27 === s ?
                                    (t.preventDefault(), void e.close(t)) :
                                    37 === s || 38 === s ?
                                    (t.preventDefault(), void e.previous()) :
                                    39 === s || 40 === s ?
                                    (t.preventDefault(), void e.next()) :
                                    void e.trigger("afterKeydown", t, s);
                            n.opts.trapFocus && e.focus(t);
                        }),
                        e.group[e.currIndex].opts.idleTime &&
                        ((e.idleSecondsCounter = 0),
                            o.on(
                                "mousemove.fb-idle mouseleave.fb-idle mousedown.fb-idle touchstart.fb-idle touchmove.fb-idle scroll.fb-idle keydown.fb-idle",
                                function(t) {
                                    (e.idleSecondsCounter = 0),
                                    e.isIdle && e.showControls(),
                                        (e.isIdle = !1);
                                }
                            ),
                            (e.idleInterval = t.setInterval(function() {
                                ++e.idleSecondsCounter >= e.group[e.currIndex].opts.idleTime &&
                                    !e.isDragging &&
                                    ((e.isIdle = !0),
                                        (e.idleSecondsCounter = 0),
                                        e.hideControls());
                            }, 1e3)));
                },
                removeEvents: function() {
                    var e = this;
                    r.off("orientationchange.fb resize.fb"),
                        o.off("keydown.fb .fb-idle"),
                        this.$refs.container.off(".fb-close .fb-prev .fb-next"),
                        e.idleInterval &&
                        (t.clearInterval(e.idleInterval), (e.idleInterval = null));
                },
                previous: function(t) {
                    return this.jumpTo(this.currPos - 1, t);
                },
                next: function(t) {
                    return this.jumpTo(this.currPos + 1, t);
                },
                jumpTo: function(t, e) {
                    var n,
                        s,
                        a,
                        r,
                        o,
                        l,
                        c,
                        d,
                        u,
                        p = this,
                        f = p.group.length;
                    if (!(p.isDragging || p.isClosing || (p.isAnimating && p.firstRun))) {
                        if (
                            ((t = parseInt(t, 10)), !(a = p.current ? p.current.opts.loop : p.opts.loop) &&
                                (t < 0 || t >= f))
                        )
                            return !1;
                        if (
                            ((n = p.firstRun = !Object.keys(p.slides).length),
                                (o = p.current),
                                (p.prevIndex = p.currIndex),
                                (p.prevPos = p.currPos),
                                (r = p.createSlide(t)),
                                f > 1 &&
                                ((a || r.index < f - 1) && p.createSlide(t + 1),
                                    (a || r.index > 0) && p.createSlide(t - 1)),
                                (p.current = r),
                                (p.currIndex = r.index),
                                (p.currPos = r.pos),
                                p.trigger("beforeShow", n),
                                p.updateControls(),
                                (r.forcedDuration = void 0),
                                i.isNumeric(e) ?
                                (r.forcedDuration = e) :
                                (e = r.opts[n ? "animationDuration" : "transitionDuration"]),
                                (e = parseInt(e, 10)),
                                (s = p.isMoved(r)),
                                r.$slide.addClass("fancybox-slide--current"),
                                n)
                        )
                            return (
                                r.opts.animationEffect &&
                                e &&
                                p.$refs.container.css("transition-duration", e + "ms"),
                                p.$refs.container.addClass("fancybox-is-open").trigger("focus"),
                                p.loadSlide(r),
                                void p.preload("image")
                            );
                        (l = i.fancybox.getTranslate(o.$slide)),
                        (c = i.fancybox.getTranslate(p.$refs.stage)),
                        i.each(p.slides, function(t, e) {
                                i.fancybox.stop(e.$slide, !0);
                            }),
                            o.pos !== r.pos && (o.isComplete = !1),
                            o.$slide.removeClass(
                                "fancybox-slide--complete fancybox-slide--current"
                            ),
                            s ?
                            ((u = l.left - (o.pos * l.width + o.pos * o.opts.gutter)),
                                i.each(p.slides, function(t, n) {
                                    n.$slide
                                        .removeClass("fancybox-animated")
                                        .removeClass(function(t, e) {
                                            return (e.match(/(^|\s)fancybox-fx-\S+/g) || []).join(
                                                " "
                                            );
                                        });
                                    var s = n.pos * l.width + n.pos * n.opts.gutter;
                                    i.fancybox.setTranslate(n.$slide, {
                                            top: 0,
                                            left: s - c.left + u,
                                        }),
                                        n.pos !== r.pos &&
                                        n.$slide.addClass(
                                            "fancybox-slide--" +
                                            (n.pos > r.pos ? "next" : "previous")
                                        ),
                                        h(n.$slide),
                                        i.fancybox.animate(
                                            n.$slide, {
                                                top: 0,
                                                left:
                                                    (n.pos - r.pos) * l.width +
                                                    (n.pos - r.pos) * n.opts.gutter,
                                            },
                                            e,
                                            function() {
                                                n.$slide
                                                    .css({
                                                        transform: "",
                                                        opacity: "",
                                                    })
                                                    .removeClass(
                                                        "fancybox-slide--next fancybox-slide--previous"
                                                    ),
                                                    n.pos === p.currPos && p.complete();
                                            }
                                        );
                                })) :
                            e &&
                            r.opts.transitionEffect &&
                            ((d =
                                    "fancybox-animated fancybox-fx-" + r.opts.transitionEffect),
                                o.$slide.addClass(
                                    "fancybox-slide--" + (o.pos > r.pos ? "next" : "previous")
                                ),
                                i.fancybox.animate(
                                    o.$slide,
                                    d,
                                    e,
                                    function() {
                                        o.$slide
                                            .removeClass(d)
                                            .removeClass(
                                                "fancybox-slide--next fancybox-slide--previous"
                                            );
                                    }, !1
                                )),
                            r.isLoaded ? p.revealContent(r) : p.loadSlide(r),
                            p.preload("image");
                    }
                },
                createSlide: function(t) {
                    var e,
                        n,
                        s = this;
                    return (
                        (n = (n = t % s.group.length) < 0 ? s.group.length + n : n), !s.slides[t] &&
                        s.group[n] &&
                        ((e = i('<div class="fancybox-slide"></div>').appendTo(
                                s.$refs.stage
                            )),
                            (s.slides[t] = i.extend(!0, {}, s.group[n], {
                                pos: t,
                                $slide: e,
                                isLoaded: !1,
                            })),
                            s.updateSlide(s.slides[t])),
                        s.slides[t]
                    );
                },
                scaleToActual: function(t, e, n) {
                    var s,
                        a,
                        r,
                        o,
                        l,
                        c = this,
                        d = c.current,
                        u = d.$content,
                        h = i.fancybox.getTranslate(d.$slide).width,
                        p = i.fancybox.getTranslate(d.$slide).height,
                        f = d.width,
                        m = d.height;
                    c.isAnimating ||
                        c.isMoved() ||
                        !u ||
                        "image" != d.type ||
                        !d.isLoaded ||
                        d.hasError ||
                        ((c.isAnimating = !0),
                            i.fancybox.stop(u),
                            (t = void 0 === t ? 0.5 * h : t),
                            (e = void 0 === e ? 0.5 * p : e),
                            ((s = i.fancybox.getTranslate(u)).top -= i.fancybox.getTranslate(
                                d.$slide
                            ).top),
                            (s.left -= i.fancybox.getTranslate(d.$slide).left),
                            (o = f / s.width),
                            (l = m / s.height),
                            (a = 0.5 * h - 0.5 * f),
                            (r = 0.5 * p - 0.5 * m),
                            f > h &&
                            ((a = s.left * o - (t * o - t)) > 0 && (a = 0),
                                a < h - f && (a = h - f)),
                            m > p &&
                            ((r = s.top * l - (e * l - e)) > 0 && (r = 0),
                                r < p - m && (r = p - m)),
                            c.updateCursor(f, m),
                            i.fancybox.animate(
                                u, {
                                    top: r,
                                    left: a,
                                    scaleX: o,
                                    scaleY: l,
                                },
                                n || 366,
                                function() {
                                    c.isAnimating = !1;
                                }
                            ),
                            c.SlideShow && c.SlideShow.isActive && c.SlideShow.stop());
                },
                scaleToFit: function(t) {
                    var e,
                        n = this,
                        s = n.current,
                        a = s.$content;
                    n.isAnimating ||
                        n.isMoved() ||
                        !a ||
                        "image" != s.type ||
                        !s.isLoaded ||
                        s.hasError ||
                        ((n.isAnimating = !0),
                            i.fancybox.stop(a),
                            (e = n.getFitPos(s)),
                            n.updateCursor(e.width, e.height),
                            i.fancybox.animate(
                                a, {
                                    top: e.top,
                                    left: e.left,
                                    scaleX: e.width / a.width(),
                                    scaleY: e.height / a.height(),
                                },
                                t || 366,
                                function() {
                                    n.isAnimating = !1;
                                }
                            ));
                },
                getFitPos: function(t) {
                    var e,
                        n,
                        s,
                        a,
                        r = t.$content,
                        o = t.$slide,
                        l = t.width || t.opts.width,
                        c = t.height || t.opts.height,
                        d = {};
                    return (!!(t.isLoaded && r && r.length) &&
                        ((e = i.fancybox.getTranslate(this.$refs.stage).width),
                            (n = i.fancybox.getTranslate(this.$refs.stage).height),
                            (e -=
                                parseFloat(o.css("paddingLeft")) +
                                parseFloat(o.css("paddingRight")) +
                                parseFloat(r.css("marginLeft")) +
                                parseFloat(r.css("marginRight"))),
                            (n -=
                                parseFloat(o.css("paddingTop")) +
                                parseFloat(o.css("paddingBottom")) +
                                parseFloat(r.css("marginTop")) +
                                parseFloat(r.css("marginBottom"))),
                            (l && c) || ((l = e), (c = n)),
                            (l *= s = Math.min(1, e / l, n / c)) > e - 0.5 && (l = e),
                            (c *= s) > n - 0.5 && (c = n),
                            "image" === t.type ?
                            ((d.top =
                                    Math.floor(0.5 * (n - c)) + parseFloat(o.css("paddingTop"))),
                                (d.left =
                                    Math.floor(0.5 * (e - l)) + parseFloat(o.css("paddingLeft")))) :
                            "video" === t.contentType &&
                            (c >
                                l /
                                (a =
                                    t.opts.width && t.opts.height ?
                                    l / c :
                                    t.opts.ratio || 16 / 9) ?
                                (c = l / a) :
                                l > c * a && (l = c * a)),
                            (d.width = l),
                            (d.height = c),
                            d)
                    );
                },
                update: function(t) {
                    var e = this;
                    i.each(e.slides, function(i, n) {
                        e.updateSlide(n, t);
                    });
                },
                updateSlide: function(t, e) {
                    var n = this,
                        s = t && t.$content,
                        a = t.width || t.opts.width,
                        r = t.height || t.opts.height,
                        o = t.$slide;
                    n.adjustCaption(t),
                        s &&
                        (a || r || "video" === t.contentType) &&
                        !t.hasError &&
                        (i.fancybox.stop(s),
                            i.fancybox.setTranslate(s, n.getFitPos(t)),
                            t.pos === n.currPos && ((n.isAnimating = !1), n.updateCursor())),
                        n.adjustLayout(t),
                        o.length &&
                        (o.trigger("refresh"),
                            t.pos === n.currPos &&
                            n.$refs.toolbar
                            .add(n.$refs.navigation.find(".fancybox-button--arrow_right"))
                            .toggleClass(
                                "compensate-for-scrollbar",
                                o.get(0).scrollHeight > o.get(0).clientHeight
                            )),
                        n.trigger("onUpdate", t, e);
                },
                centerSlide: function(t) {
                    var e = this,
                        n = e.current,
                        s = n.$slide;
                    !e.isClosing &&
                        n &&
                        (s.siblings().css({
                                transform: "",
                                opacity: "",
                            }),
                            s
                            .parent()
                            .children()
                            .removeClass("fancybox-slide--previous fancybox-slide--next"),
                            i.fancybox.animate(
                                s, {
                                    top: 0,
                                    left: 0,
                                    opacity: 1,
                                },
                                void 0 === t ? 0 : t,
                                function() {
                                    s.css({
                                            transform: "",
                                            opacity: "",
                                        }),
                                        n.isComplete || e.complete();
                                }, !1
                            ));
                },
                isMoved: function(t) {
                    var e,
                        n,
                        s = t || this.current;
                    return (!!s &&
                        ((n = i.fancybox.getTranslate(this.$refs.stage)),
                            (e = i.fancybox.getTranslate(s.$slide)), !s.$slide.hasClass("fancybox-animated") &&
                            (Math.abs(e.top - n.top) > 0.5 ||
                                Math.abs(e.left - n.left) > 0.5))
                    );
                },
                updateCursor: function(t, e) {
                    var n,
                        s,
                        a = this,
                        r = a.current,
                        o = a.$refs.container;
                    r &&
                        !a.isClosing &&
                        a.Guestures &&
                        (o.removeClass(
                                "fancybox-is-zoomable fancybox-can-zoomIn fancybox-can-zoomOut fancybox-can-swipe fancybox-can-pan"
                            ),
                            (s = !!(n = a.canPan(t, e)) || a.isZoomable()),
                            o.toggleClass("fancybox-is-zoomable", s),
                            i("[data-fancybox-zoom]").prop("disabled", !s),
                            n ?
                            o.addClass("fancybox-can-pan") :
                            s &&
                            ("zoom" === r.opts.clickContent ||
                                (i.isFunction(r.opts.clickContent) &&
                                    "zoom" == r.opts.clickContent(r))) ?
                            o.addClass("fancybox-can-zoomIn") :
                            r.opts.touch &&
                            (r.opts.touch.vertical || a.group.length > 1) &&
                            "video" !== r.contentType &&
                            o.addClass("fancybox-can-swipe"));
                },
                isZoomable: function() {
                    var t,
                        e = this,
                        i = e.current;
                    if (i && !e.isClosing && "image" === i.type && !i.hasError) {
                        if (!i.isLoaded) return !0;
                        if (
                            (t = e.getFitPos(i)) &&
                            (i.width > t.width || i.height > t.height)
                        )
                            return !0;
                    }
                    return !1;
                },
                isScaledDown: function(t, e) {
                    var n = !1,
                        s = this.current,
                        a = s.$content;
                    return (
                        void 0 !== t && void 0 !== e ?
                        (n = t < s.width && e < s.height) :
                        a &&
                        (n =
                            (n = i.fancybox.getTranslate(a)).width < s.width &&
                            n.height < s.height),
                        n
                    );
                },
                canPan: function(t, e) {
                    var n = this.current,
                        s = null,
                        a = !1;
                    return (
                        "image" === n.type &&
                        (n.isComplete || (t && e)) &&
                        !n.hasError &&
                        ((a = this.getFitPos(n)),
                            void 0 !== t && void 0 !== e ?
                            (s = {
                                width: t,
                                height: e,
                            }) :
                            n.isComplete && (s = i.fancybox.getTranslate(n.$content)),
                            s &&
                            a &&
                            (a =
                                Math.abs(s.width - a.width) > 1.5 ||
                                Math.abs(s.height - a.height) > 1.5)),
                        a
                    );
                },
                loadSlide: function(t) {
                    var e,
                        n,
                        s,
                        a = this;
                    if (!t.isLoading && !t.isLoaded) {
                        if (((t.isLoading = !0), !1 === a.trigger("beforeLoad", t)))
                            return (t.isLoading = !1), !1;
                        switch (
                            ((e = t.type),
                                (n = t.$slide)
                                .off("refresh")
                                .trigger("onReset")
                                .addClass(t.opts.slideClass),
                                e)
                        ) {
                            case "image":
                                a.setImage(t);
                                break;
                            case "iframe":
                                a.setIframe(t);
                                break;
                            case "html":
                                a.setContent(t, t.src || t.content);
                                break;
                            case "video":
                                a.setContent(
                                    t,
                                    t.opts.video.tpl
                                    .replace(/\{\{src\}\}/gi, t.src)
                                    .replace(
                                        "{{format}}",
                                        t.opts.videoFormat || t.opts.video.format || ""
                                    )
                                    .replace("{{poster}}", t.thumb || "")
                                );
                                break;
                            case "inline":
                                i(t.src).length ? a.setContent(t, i(t.src)) : a.setError(t);
                                break;
                            case "ajax":
                                a.showLoading(t),
                                    (s = i.ajax(
                                        i.extend({}, t.opts.ajax.settings, {
                                            url: t.src,
                                            success: function(e, i) {
                                                "success" === i && a.setContent(t, e);
                                            },
                                            error: function(e, i) {
                                                e && "abort" !== i && a.setError(t);
                                            },
                                        })
                                    )),
                                    n.one("onReset", function() {
                                        s.abort();
                                    });
                                break;
                            default:
                                a.setError(t);
                        }
                        return !0;
                    }
                },
                setImage: function(t) {
                    var n,
                        s = this;
                    setTimeout(function() {
                            var e = t.$image;
                            s.isClosing ||
                                !t.isLoading ||
                                (e && e.length && e[0].complete) ||
                                t.hasError ||
                                s.showLoading(t);
                        }, 50),
                        s.checkSrcset(t),
                        (t.$content = i('<div class="fancybox-content"></div>')
                            .addClass("fancybox-is-hidden")
                            .appendTo(t.$slide.addClass("fancybox-slide--image"))), !1 !== t.opts.preload &&
                        t.opts.width &&
                        t.opts.height &&
                        t.thumb &&
                        ((t.width = t.opts.width),
                            (t.height = t.opts.height),
                            ((n = e.createElement("img")).onerror = function() {
                                i(this).remove(), (t.$ghost = null);
                            }),
                            (n.onload = function() {
                                s.afterLoad(t);
                            }),
                            (t.$ghost = i(n)
                                .addClass("fancybox-image")
                                .appendTo(t.$content)
                                .attr("src", t.thumb))),
                        s.setBigImage(t);
                },
                checkSrcset: function(e) {
                    var i,
                        n,
                        s,
                        a,
                        r = e.opts.srcset || e.opts.image.srcset;
                    if (r) {
                        (s = t.devicePixelRatio || 1),
                        (a = t.innerWidth * s),
                        (n = r.split(",").map(function(t) {
                            var e = {};
                            return (
                                t
                                .trim()
                                .split(/\s+/)
                                .forEach(function(t, i) {
                                    var n = parseInt(t.substring(0, t.length - 1), 10);
                                    if (0 === i) return (e.url = t);
                                    n && ((e.value = n), (e.postfix = t[t.length - 1]));
                                }),
                                e
                            );
                        })),
                        n.sort(function(t, e) {
                            return t.value - e.value;
                        });
                        for (var o = 0; o < n.length; o++) {
                            var l = n[o];
                            if (
                                ("w" === l.postfix && l.value >= a) ||
                                ("x" === l.postfix && l.value >= s)
                            ) {
                                i = l;
                                break;
                            }
                        }!i && n.length && (i = n[n.length - 1]),
                            i &&
                            ((e.src = i.url),
                                e.width &&
                                e.height &&
                                "w" == i.postfix &&
                                ((e.height = (e.width / e.height) * i.value),
                                    (e.width = i.value)),
                                (e.opts.srcset = r));
                    }
                },
                setBigImage: function(t) {
                    var n = this,
                        s = e.createElement("img"),
                        a = i(s);
                    (t.$image = a
                        .one("error", function() {
                            n.setError(t);
                        })
                        .one("load", function() {
                            var e;
                            t.$ghost ||
                                (n.resolveImageSlideSize(
                                        t,
                                        this.naturalWidth,
                                        this.naturalHeight
                                    ),
                                    n.afterLoad(t)),
                                n.isClosing ||
                                (t.opts.srcset &&
                                    (((e = t.opts.sizes) && "auto" !== e) ||
                                        (e =
                                            (t.width / t.height > 1 && r.width() / r.height() > 1 ?
                                                "100" :
                                                Math.round((t.width / t.height) * 100)) + "vw"),
                                        a.attr("sizes", e).attr("srcset", t.opts.srcset)),
                                    t.$ghost &&
                                    setTimeout(function() {
                                        t.$ghost && !n.isClosing && t.$ghost.hide();
                                    }, Math.min(300, Math.max(1e3, t.height / 1600))),
                                    n.hideLoading(t));
                        })
                        .addClass("fancybox-image")
                        .attr("src", t.src)
                        .appendTo(t.$content)),
                    (s.complete || "complete" == s.readyState) &&
                    a.naturalWidth &&
                        a.naturalHeight ?
                        a.trigger("load") :
                        s.error && a.trigger("error");
                },
                resolveImageSlideSize: function(t, e, i) {
                    var n = parseInt(t.opts.width, 10),
                        s = parseInt(t.opts.height, 10);
                    (t.width = e),
                    (t.height = i),
                    n > 0 && ((t.width = n), (t.height = Math.floor((n * i) / e))),
                        s > 0 && ((t.width = Math.floor((s * e) / i)), (t.height = s));
                },
                setIframe: function(t) {
                    var e,
                        n = this,
                        s = t.opts.iframe,
                        a = t.$slide;
                    (t.$content = i(
                            '<div class="fancybox-content' +
                            (s.preload ? " fancybox-is-hidden" : "") +
                            '"></div>'
                        )
                        .css(s.css)
                        .appendTo(a)),
                    a.addClass("fancybox-slide--" + t.contentType),
                        (t.$iframe = e =
                            i(s.tpl.replace(/\{rnd\}/g, new Date().getTime()))
                            .attr(s.attr)
                            .appendTo(t.$content)),
                        s.preload ?
                        (n.showLoading(t),
                            e.on("load.fb error.fb", function(e) {
                                (this.isReady = 1),
                                t.$slide.trigger("refresh"),
                                    n.afterLoad(t);
                            }),
                            a.on("refresh.fb", function() {
                                var i,
                                    n = t.$content,
                                    r = s.css.width,
                                    o = s.css.height;
                                if (1 === e[0].isReady) {
                                    try {
                                        i = e.contents().find("body");
                                    } catch (t) {}
                                    i &&
                                        i.length &&
                                        i.children().length &&
                                        (a.css("overflow", "visible"),
                                            n.css({
                                                width: "100%",
                                                "max-width": "100%",
                                                height: "9999px",
                                            }),
                                            void 0 === r &&
                                            (r = Math.ceil(
                                                Math.max(i[0].clientWidth, i.outerWidth(!0))
                                            )),
                                            n.css("width", r || "").css("max-width", ""),
                                            void 0 === o &&
                                            (o = Math.ceil(
                                                Math.max(i[0].clientHeight, i.outerHeight(!0))
                                            )),
                                            n.css("height", o || ""),
                                            a.css("overflow", "auto")),
                                        n.removeClass("fancybox-is-hidden");
                                }
                            })) :
                        n.afterLoad(t),
                        e.attr("src", t.src),
                        a.one("onReset", function() {
                            try {
                                i(this)
                                    .find("iframe")
                                    .hide()
                                    .unbind()
                                    .attr("src", "//about:blank");
                            } catch (t) {}
                            i(this).off("refresh.fb").empty(),
                                (t.isLoaded = !1),
                                (t.isRevealed = !1);
                        });
                },
                setContent: function(t, e) {
                    var n = this;
                    n.isClosing ||
                        (n.hideLoading(t),
                            t.$content && i.fancybox.stop(t.$content),
                            t.$slide.empty(),
                            (function(t) {
                                return t && t.hasOwnProperty && t instanceof i;
                            })(e) && e.parent().length ?
                            ((e.hasClass("fancybox-content") ||
                                    e.parent().hasClass("fancybox-content")) &&
                                e.parents(".fancybox-slide").trigger("onReset"),
                                (t.$placeholder = i("<div>").hide().insertAfter(e)),
                                e.css("display", "inline-block")) :
                            t.hasError ||
                            ("string" === i.type(e) &&
                                (e = i("<div>").append(i.trim(e)).contents()),
                                t.opts.filter && (e = i("<div>").html(e).find(t.opts.filter))),
                            t.$slide.one("onReset", function() {
                                i(this).find("video,audio").trigger("pause"),
                                    t.$placeholder &&
                                    (t.$placeholder
                                        .after(e.removeClass("fancybox-content").hide())
                                        .remove(),
                                        (t.$placeholder = null)),
                                    t.$smallBtn && (t.$smallBtn.remove(), (t.$smallBtn = null)),
                                    t.hasError ||
                                    (i(this).empty(), (t.isLoaded = !1), (t.isRevealed = !1));
                            }),
                            i(e).appendTo(t.$slide),
                            i(e).is("video,audio") &&
                            (i(e).addClass("fancybox-video"),
                                i(e).wrap("<div></div>"),
                                (t.contentType = "video"),
                                (t.opts.width = t.opts.width || i(e).attr("width")),
                                (t.opts.height = t.opts.height || i(e).attr("height"))),
                            (t.$content = t.$slide
                                .children()
                                .filter("div,form,main,video,audio,article,.fancybox-content")
                                .first()),
                            t.$content.siblings().hide(),
                            t.$content.length ||
                            (t.$content = t.$slide
                                .wrapInner("<div></div>")
                                .children()
                                .first()),
                            t.$content.addClass("fancybox-content"),
                            t.$slide.addClass("fancybox-slide--" + t.contentType),
                            n.afterLoad(t));
                },
                setError: function(t) {
                    (t.hasError = !0),
                    t.$slide
                        .trigger("onReset")
                        .removeClass("fancybox-slide--" + t.contentType)
                        .addClass("fancybox-slide--error"),
                        (t.contentType = "html"),
                        this.setContent(t, this.translate(t, t.opts.errorTpl)),
                        t.pos === this.currPos && (this.isAnimating = !1);
                },
                showLoading: function(t) {
                    var e = this;
                    (t = t || e.current) &&
                    !t.$spinner &&
                        (t.$spinner = i(e.translate(e, e.opts.spinnerTpl))
                            .appendTo(t.$slide)
                            .hide()
                            .fadeIn("fast"));
                },
                hideLoading: function(t) {
                    (t = t || this.current) &&
                    t.$spinner &&
                        (t.$spinner.stop().remove(), delete t.$spinner);
                },
                afterLoad: function(t) {
                    var e = this;
                    e.isClosing ||
                        ((t.isLoading = !1),
                            (t.isLoaded = !0),
                            e.trigger("afterLoad", t),
                            e.hideLoading(t), !t.opts.smallBtn ||
                            (t.$smallBtn && t.$smallBtn.length) ||
                            (t.$smallBtn = i(e.translate(t, t.opts.btnTpl.smallBtn)).appendTo(
                                t.$content
                            )),
                            t.opts.protect &&
                            t.$content &&
                            !t.hasError &&
                            (t.$content.on("contextmenu.fb", function(t) {
                                    return 2 == t.button && t.preventDefault(), !0;
                                }),
                                "image" === t.type &&
                                i('<div class="fancybox-spaceball"></div>').appendTo(
                                    t.$content
                                )),
                            e.adjustCaption(t),
                            e.adjustLayout(t),
                            t.pos === e.currPos && e.updateCursor(),
                            e.revealContent(t));
                },
                adjustCaption: function(t) {
                    var e,
                        i = this,
                        n = t || i.current,
                        s = n.opts.caption,
                        a = n.opts.preventCaptionOverlap,
                        r = i.$refs.caption,
                        o = !1;
                    r.toggleClass("fancybox-caption--separate", a),
                        a &&
                        s &&
                        s.length &&
                        (n.pos !== i.currPos ?
                            ((e = r.clone().appendTo(r.parent()))
                                .children()
                                .eq(0)
                                .empty()
                                .html(s),
                                (o = e.outerHeight(!0)),
                                e.empty().remove()) :
                            i.$caption && (o = i.$caption.outerHeight(!0)),
                            n.$slide.css("padding-bottom", o || ""));
                },
                adjustLayout: function(t) {
                    var e,
                        i,
                        n,
                        s,
                        a = t || this.current;
                    a.isLoaded &&
                        !0 !== a.opts.disableLayoutFix &&
                        (a.$content.css("margin-bottom", ""),
                            a.$content.outerHeight() > a.$slide.height() + 0.5 &&
                            ((n = a.$slide[0].style["padding-bottom"]),
                                (s = a.$slide.css("padding-bottom")),
                                parseFloat(s) > 0 &&
                                ((e = a.$slide[0].scrollHeight),
                                    a.$slide.css("padding-bottom", 0),
                                    Math.abs(e - a.$slide[0].scrollHeight) < 1 && (i = s),
                                    a.$slide.css("padding-bottom", n))),
                            a.$content.css("margin-bottom", i));
                },
                revealContent: function(t) {
                    var e,
                        n,
                        s,
                        a,
                        r = this,
                        o = t.$slide,
                        l = !1,
                        c = !1,
                        d = r.isMoved(t),
                        u = t.isRevealed;
                    return (
                        (t.isRevealed = !0),
                        (e = t.opts[r.firstRun ? "animationEffect" : "transitionEffect"]),
                        (s =
                            t.opts[r.firstRun ? "animationDuration" : "transitionDuration"]),
                        (s = parseInt(
                            void 0 === t.forcedDuration ? s : t.forcedDuration,
                            10
                        )),
                        (!d && t.pos === r.currPos && s) || (e = !1),
                        "zoom" === e &&
                        (t.pos === r.currPos &&
                            s &&
                            "image" === t.type &&
                            !t.hasError &&
                            (c = r.getThumbPos(t)) ?
                            (l = r.getFitPos(t)) :
                            (e = "fade")),
                        "zoom" === e ?
                        ((r.isAnimating = !0),
                            (l.scaleX = l.width / c.width),
                            (l.scaleY = l.height / c.height),
                            "auto" == (a = t.opts.zoomOpacity) &&
                            (a = Math.abs(t.width / t.height - c.width / c.height) > 0.1),
                            a && ((c.opacity = 0.1), (l.opacity = 1)),
                            i.fancybox.setTranslate(
                                t.$content.removeClass("fancybox-is-hidden"),
                                c
                            ),
                            h(t.$content),
                            void i.fancybox.animate(t.$content, l, s, function() {
                                (r.isAnimating = !1), r.complete();
                            })) :
                        (r.updateSlide(t),
                            e ?
                            (i.fancybox.stop(o),
                                (n =
                                    "fancybox-slide--" +
                                    (t.pos >= r.prevPos ? "next" : "previous") +
                                    " fancybox-animated fancybox-fx-" +
                                    e),
                                o.addClass(n).removeClass("fancybox-slide--current"),
                                t.$content.removeClass("fancybox-is-hidden"),
                                h(o),
                                "image" !== t.type && t.$content.hide().show(0),
                                void i.fancybox.animate(
                                    o,
                                    "fancybox-slide--current",
                                    s,
                                    function() {
                                        o.removeClass(n).css({
                                                transform: "",
                                                opacity: "",
                                            }),
                                            t.pos === r.currPos && r.complete();
                                    }, !0
                                )) :
                            (t.$content.removeClass("fancybox-is-hidden"),
                                u ||
                                !d ||
                                "image" !== t.type ||
                                t.hasError ||
                                t.$content.hide().fadeIn("fast"),
                                void(t.pos === r.currPos && r.complete())))
                    );
                },
                getThumbPos: function(t) {
                    var e,
                        n,
                        s,
                        a,
                        r,
                        o = !1,
                        l = t.$thumb;
                    return (!(!l || !f(l[0])) &&
                        ((e = i.fancybox.getTranslate(l)),
                            (n = parseFloat(l.css("border-top-width") || 0)),
                            (s = parseFloat(l.css("border-right-width") || 0)),
                            (a = parseFloat(l.css("border-bottom-width") || 0)),
                            (r = parseFloat(l.css("border-left-width") || 0)),
                            (o = {
                                top: e.top + n,
                                left: e.left + r,
                                width: e.width - s - r,
                                height: e.height - n - a,
                                scaleX: 1,
                                scaleY: 1,
                            }),
                            e.width > 0 && e.height > 0 && o)
                    );
                },
                complete: function() {
                    var t,
                        e = this,
                        n = e.current,
                        s = {};
                    !e.isMoved() &&
                        n.isLoaded &&
                        (n.isComplete ||
                            ((n.isComplete = !0),
                                n.$slide.siblings().trigger("onReset"),
                                e.preload("inline"),
                                h(n.$slide),
                                n.$slide.addClass("fancybox-slide--complete"),
                                i.each(e.slides, function(t, n) {
                                    n.pos >= e.currPos - 1 && n.pos <= e.currPos + 1 ?
                                        (s[n.pos] = n) :
                                        n && (i.fancybox.stop(n.$slide), n.$slide.off().remove());
                                }),
                                (e.slides = s)),
                            (e.isAnimating = !1),
                            e.updateCursor(),
                            e.trigger("afterShow"),
                            n.opts.video.autoStart &&
                            n.$slide
                            .find("video,audio")
                            .filter(":visible:first")
                            .trigger("play")
                            .one("ended", function() {
                                Document.exitFullscreen ?
                                    Document.exitFullscreen() :
                                    this.webkitExitFullscreen && this.webkitExitFullscreen(),
                                    e.next();
                            }),
                            n.opts.autoFocus &&
                            "html" === n.contentType &&
                            ((t = n.$content.find("input[autofocus]:enabled:visible:first"))
                                .length ?
                                t.trigger("focus") :
                                e.focus(null, !0)),
                            n.$slide.scrollTop(0).scrollLeft(0));
                },
                preload: function(t) {
                    var e,
                        i,
                        n = this;
                    n.group.length < 2 ||
                        ((i = n.slides[n.currPos + 1]),
                            (e = n.slides[n.currPos - 1]) && e.type === t && n.loadSlide(e),
                            i && i.type === t && n.loadSlide(i));
                },
                focus: function(t, n) {
                    var s,
                        a,
                        r = this,
                        o = [
                            "a[href]",
                            "area[href]",
                            'input:not([disabled]):not([type="hidden"]):not([aria-hidden])',
                            "select:not([disabled]):not([aria-hidden])",
                            "textarea:not([disabled]):not([aria-hidden])",
                            "button:not([disabled]):not([aria-hidden])",
                            "iframe",
                            "object",
                            "embed",
                            "video",
                            "audio",
                            "[contenteditable]",
                            '[tabindex]:not([tabindex^="-"])',
                        ].join(",");
                    r.isClosing ||
                        ((s = (s = !t && r.current && r.current.isComplete ?
                                    r.current.$slide.find(
                                        "*:visible" + (n ? ":not(.fancybox-close-small)" : "")
                                    ) :
                                    r.$refs.container.find("*:visible"))
                                .filter(o)
                                .filter(function() {
                                    return (
                                        "hidden" !== i(this).css("visibility") &&
                                        !i(this).hasClass("disabled")
                                    );
                                })).length ?
                            ((a = s.index(e.activeElement)),
                                t && t.shiftKey ?
                                (a < 0 || 0 == a) &&
                                (t.preventDefault(), s.eq(s.length - 1).trigger("focus")) :
                                (a < 0 || a == s.length - 1) &&
                                (t && t.preventDefault(), s.eq(0).trigger("focus"))) :
                            r.$refs.container.trigger("focus"));
                },
                activate: function() {
                    var t = this;
                    i(".fancybox-container").each(function() {
                            var e = i(this).data("FancyBox");
                            e &&
                                e.id !== t.id &&
                                !e.isClosing &&
                                (e.trigger("onDeactivate"), e.removeEvents(), (e.isVisible = !1));
                        }),
                        (t.isVisible = !0),
                        (t.current || t.isIdle) && (t.update(), t.updateControls()),
                        t.trigger("onActivate"),
                        t.addEvents();
                },
                close: function(t, e) {
                    var n,
                        s,
                        a,
                        r,
                        o,
                        l,
                        d,
                        u = this,
                        p = u.current,
                        f = function() {
                            u.cleanUp(t);
                        };
                    return !(
                        u.isClosing ||
                        ((u.isClosing = !0), !1 === u.trigger("beforeClose", t) ?
                            ((u.isClosing = !1),
                                c(function() {
                                    u.update();
                                }),
                                1) :
                            (u.removeEvents(),
                                (a = p.$content),
                                (n = p.opts.animationEffect),
                                (s = i.isNumeric(e) ? e : n ? p.opts.animationDuration : 0),
                                p.$slide.removeClass(
                                    "fancybox-slide--complete fancybox-slide--next fancybox-slide--previous fancybox-animated"
                                ), !0 !== t ? i.fancybox.stop(p.$slide) : (n = !1),
                                p.$slide.siblings().trigger("onReset").remove(),
                                s &&
                                u.$refs.container
                                .removeClass("fancybox-is-open")
                                .addClass("fancybox-is-closing")
                                .css("transition-duration", s + "ms"),
                                u.hideLoading(p),
                                u.hideControls(!0),
                                u.updateCursor(),
                                "zoom" !== n ||
                                (a &&
                                    s &&
                                    "image" === p.type &&
                                    !u.isMoved() &&
                                    !p.hasError &&
                                    (d = u.getThumbPos(p))) ||
                                (n = "fade"),
                                "zoom" === n ?
                                (i.fancybox.stop(a),
                                    (r = i.fancybox.getTranslate(a)),
                                    (l = {
                                        top: r.top,
                                        left: r.left,
                                        scaleX: r.width / d.width,
                                        scaleY: r.height / d.height,
                                        width: d.width,
                                        height: d.height,
                                    }),
                                    (o = p.opts.zoomOpacity),
                                    "auto" == o &&
                                    (o =
                                        Math.abs(p.width / p.height - d.width / d.height) >
                                        0.1),
                                    o && (d.opacity = 0),
                                    i.fancybox.setTranslate(a, l),
                                    h(a),
                                    i.fancybox.animate(a, d, s, f),
                                    0) :
                                (n && s ?
                                    i.fancybox.animate(
                                        p.$slide
                                        .addClass("fancybox-slide--previous")
                                        .removeClass("fancybox-slide--current"),
                                        "fancybox-animated fancybox-fx-" + n,
                                        s,
                                        f
                                    ) :
                                    !0 === t ?
                                    setTimeout(f, s) :
                                    f(),
                                    0)))
                    );
                },
                cleanUp: function(e) {
                    var n,
                        s,
                        a,
                        r = this,
                        o = r.current.opts.$orig;
                    r.current.$slide.trigger("onReset"),
                        r.$refs.container.empty().remove(),
                        r.trigger("afterClose", e),
                        r.current.opts.backFocus &&
                        ((o && o.length && o.is(":visible")) || (o = r.$trigger),
                            o &&
                            o.length &&
                            ((s = t.scrollX),
                                (a = t.scrollY),
                                o.trigger("focus"),
                                i("html, body").scrollTop(a).scrollLeft(s))),
                        (r.current = null),
                        (n = i.fancybox.getInstance()) ?
                        n.activate() :
                        (i("body").removeClass(
                                "fancybox-active compensate-for-scrollbar"
                            ),
                            i("#fancybox-style-noscroll").remove());
                },
                trigger: function(t, e) {
                    var n,
                        s = Array.prototype.slice.call(arguments, 1),
                        a = this,
                        r = e && e.opts ? e : a.current;
                    if (
                        (r ? s.unshift(r) : (r = a),
                            s.unshift(a),
                            i.isFunction(r.opts[t]) && (n = r.opts[t].apply(r, s)), !1 === n)
                    )
                        return n;
                    "afterClose" !== t && a.$refs ?
                        a.$refs.container.trigger(t + ".fb", s) :
                        o.trigger(t + ".fb", s);
                },
                updateControls: function() {
                    var t = this,
                        n = t.current,
                        s = n.index,
                        a = t.$refs.container,
                        r = t.$refs.caption,
                        o = n.opts.caption;
                    n.$slide.trigger("refresh"),
                        o && o.length ?
                        ((t.$caption = r), r.children().eq(0).html(o)) :
                        (t.$caption = null),
                        t.hasHiddenControls || t.isIdle || t.showControls(),
                        a.find("[data-fancybox-count]").html(t.group.length),
                        a.find("[data-fancybox-index]").html(s + 1),
                        a
                        .find("[data-fancybox-prev]")
                        .prop("disabled", !n.opts.loop && s <= 0),
                        a
                        .find("[data-fancybox-next]")
                        .prop("disabled", !n.opts.loop && s >= t.group.length - 1),
                        "image" === n.type ?
                        a
                        .find("[data-fancybox-zoom]")
                        .show()
                        .end()
                        .find("[data-fancybox-download]")
                        .attr("href", n.opts.image.src || n.src)
                        .show() :
                        n.opts.toolbar &&
                        a.find("[data-fancybox-download],[data-fancybox-zoom]").hide(),
                        i(e.activeElement).is(":hidden,[disabled]") &&
                        t.$refs.container.trigger("focus");
                },
                hideControls: function(t) {
                    var e = ["infobar", "toolbar", "nav"];
                    (!t && this.current.opts.preventCaptionOverlap) || e.push("caption"),
                        this.$refs.container.removeClass(
                            e
                            .map(function(t) {
                                return "fancybox-show-" + t;
                            })
                            .join(" ")
                        ),
                        (this.hasHiddenControls = !0);
                },
                showControls: function() {
                    var t = this,
                        e = t.current ? t.current.opts : t.opts,
                        i = t.$refs.container;
                    (t.hasHiddenControls = !1),
                    (t.idleSecondsCounter = 0),
                    i
                        .toggleClass("fancybox-show-toolbar", !(!e.toolbar || !e.buttons))
                        .toggleClass(
                            "fancybox-show-infobar", !!(e.infobar && t.group.length > 1)
                        )
                        .toggleClass("fancybox-show-caption", !!t.$caption)
                        .toggleClass(
                            "fancybox-show-nav", !!(e.arrows && t.group.length > 1)
                        )
                        .toggleClass("fancybox-is-modal", !!e.modal);
                },
                toggleControls: function() {
                    this.hasHiddenControls ? this.showControls() : this.hideControls();
                },
            }),
            (i.fancybox = {
                version: "3.5.7",
                defaults: a,
                getInstance: function(t) {
                    var e = i(
                            '.fancybox-container:not(".fancybox-is-closing"):last'
                        ).data("FancyBox"),
                        n = Array.prototype.slice.call(arguments, 1);
                    return (
                        e instanceof m &&
                        ("string" === i.type(t) ?
                            e[t].apply(e, n) :
                            "function" === i.type(t) && t.apply(e, n),
                            e)
                    );
                },
                open: function(t, e, i) {
                    return new m(t, e, i);
                },
                close: function(t) {
                    var e = this.getInstance();
                    e && (e.close(), !0 === t && this.close(t));
                },
                destroy: function() {
                    this.close(!0), o.add("body").off("click.fb-start", "**");
                },
                isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                    navigator.userAgent
                ),
                use3d: (function() {
                    var i = e.createElement("div");
                    return (
                        t.getComputedStyle &&
                        t.getComputedStyle(i) &&
                        t.getComputedStyle(i).getPropertyValue("transform") &&
                        !(e.documentMode && e.documentMode < 11)
                    );
                })(),
                getTranslate: function(t) {
                    var e;
                    return (!(!t || !t.length) && {
                        top: (e = t[0].getBoundingClientRect()).top || 0,
                        left: e.left || 0,
                        width: e.width,
                        height: e.height,
                        opacity: parseFloat(t.css("opacity")),
                    });
                },
                setTranslate: function(t, e) {
                    var i = "",
                        n = {};
                    if (t && e)
                        return (
                            (void 0 === e.left && void 0 === e.top) ||
                            ((i =
                                    (void 0 === e.left ? t.position().left : e.left) +
                                    "px, " +
                                    (void 0 === e.top ? t.position().top : e.top) +
                                    "px"),
                                (i = this.use3d ?
                                    "translate3d(" + i + ", 0px)" :
                                    "translate(" + i + ")")),
                            void 0 !== e.scaleX && void 0 !== e.scaleY ?
                            (i += " scale(" + e.scaleX + ", " + e.scaleY + ")") :
                            void 0 !== e.scaleX && (i += " scaleX(" + e.scaleX + ")"),
                            i.length && (n.transform = i),
                            void 0 !== e.opacity && (n.opacity = e.opacity),
                            void 0 !== e.width && (n.width = e.width),
                            void 0 !== e.height && (n.height = e.height),
                            t.css(n)
                        );
                },
                animate: function(t, e, n, s, a) {
                    var r,
                        o = this;
                    i.isFunction(n) && ((s = n), (n = null)),
                        o.stop(t),
                        (r = o.getTranslate(t)),
                        t.on(u, function(l) {
                            (!l ||
                                !l.originalEvent ||
                                (t.is(l.originalEvent.target) &&
                                    "z-index" != l.originalEvent.propertyName)) &&
                            (o.stop(t),
                                i.isNumeric(n) && t.css("transition-duration", ""),
                                i.isPlainObject(e) ?
                                void 0 !== e.scaleX &&
                                void 0 !== e.scaleY &&
                                o.setTranslate(t, {
                                    top: e.top,
                                    left: e.left,
                                    width: r.width * e.scaleX,
                                    height: r.height * e.scaleY,
                                    scaleX: 1,
                                    scaleY: 1,
                                }) :
                                !0 !== a && t.removeClass(e),
                                i.isFunction(s) && s(l));
                        }),
                        i.isNumeric(n) && t.css("transition-duration", n + "ms"),
                        i.isPlainObject(e) ?
                        (void 0 !== e.scaleX &&
                            void 0 !== e.scaleY &&
                            (delete e.width,
                                delete e.height,
                                t.parent().hasClass("fancybox-slide--image") &&
                                t.parent().addClass("fancybox-is-scaling")),
                            i.fancybox.setTranslate(t, e)) :
                        t.addClass(e),
                        t.data(
                            "timer",
                            setTimeout(function() {
                                t.trigger(u);
                            }, n + 33)
                        );
                },
                stop: function(t, e) {
                    t &&
                        t.length &&
                        (clearTimeout(t.data("timer")),
                            e && t.trigger(u),
                            t.off(u).css("transition-duration", ""),
                            t.parent().removeClass("fancybox-is-scaling"));
                },
            }),
            (i.fn.fancybox = function(t) {
                var e;
                return (
                    (e = (t = t || {}).selector || !1) ?
                    i("body").off("click.fb-start", e).on(
                        "click.fb-start",
                        e, {
                            options: t,
                        },
                        s
                    ) :
                    this.off("click.fb-start").on(
                        "click.fb-start", {
                            items: this,
                            options: t,
                        },
                        s
                    ),
                    this
                );
            }),
            o.on("click.fb-start", "[data-fancybox]", s),
            o.on("click.fb-start", "[data-fancybox-trigger]", function(t) {
                i('[data-fancybox="' + i(this).attr("data-fancybox-trigger") + '"]')
                    .eq(i(this).attr("data-fancybox-index") || 0)
                    .trigger("click.fb-start", {
                        $trigger: i(this),
                    });
            }),
            (function() {
                var t = null;
                o.on(
                    "mousedown mouseup focus blur",
                    ".fancybox-button",
                    function(e) {
                        switch (e.type) {
                            case "mousedown":
                                t = i(this);
                                break;
                            case "mouseup":
                                t = null;
                                break;
                            case "focusin":
                                i(".fancybox-button").removeClass("fancybox-focus"),
                                    i(this).is(t) ||
                                    i(this).is("[disabled]") ||
                                    i(this).addClass("fancybox-focus");
                                break;
                            case "focusout":
                                i(".fancybox-button").removeClass("fancybox-focus");
                        }
                    }
                );
            })();
    }
})(window, document, jQuery),
(function(t) {
    "use strict";
    var e = {
            youtube: {
                matcher: /(youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(watch\?(.*&)?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*))(.*)/i,
                params: {
                    autoplay: 1,
                    autohide: 1,
                    fs: 1,
                    rel: 0,
                    hd: 1,
                    wmode: "transparent",
                    enablejsapi: 1,
                    html5: 1,
                },
                paramPlace: 8,
                type: "iframe",
                url: "https://www.youtube-nocookie.com/embed/$4",
                thumb: "https://img.youtube.com/vi/$4/hqdefault.jpg",
            },
            vimeo: {
                matcher: /^.+vimeo.com\/(.*\/)?([\d]+)(.*)?/,
                params: {
                    autoplay: 1,
                    hd: 1,
                    show_title: 1,
                    show_byline: 1,
                    show_portrait: 0,
                    fullscreen: 1,
                },
                paramPlace: 3,
                type: "iframe",
                url: "//player.vimeo.com/video/$2",
            },
            instagram: {
                matcher: /(instagr\.am|instagram\.com)\/p\/([a-zA-Z0-9_\-]+)\/?/i,
                type: "image",
                url: "//$1/p/$2/media/?size=l",
            },
            gmap_place: {
                matcher: /(maps\.)?google\.([a-z]{2,3}(\.[a-z]{2})?)\/(((maps\/(place\/(.*)\/)?\@(.*),(\d+.?\d+?)z))|(\?ll=))(.*)?/i,
                type: "iframe",
                url: function(t) {
                    return (
                        "//maps.google." +
                        t[2] +
                        "/?ll=" +
                        (t[9] ?
                            t[9] +
                            "&z=" +
                            Math.floor(t[10]) +
                            (t[12] ? t[12].replace(/^\//, "&") : "") :
                            t[12] + ""
                        ).replace(/\?/, "&") +
                        "&output=" +
                        (t[12] && t[12].indexOf("layer=c") > 0 ? "svembed" : "embed")
                    );
                },
            },
            gmap_search: {
                matcher: /(maps\.)?google\.([a-z]{2,3}(\.[a-z]{2})?)\/(maps\/search\/)(.*)/i,
                type: "iframe",
                url: function(t) {
                    return (
                        "//maps.google." +
                        t[2] +
                        "/maps?q=" +
                        t[5].replace("query=", "q=").replace("api=1", "") +
                        "&output=embed"
                    );
                },
            },
        },
        i = function(e, i, n) {
            if (e)
                return (
                    (n = n || ""),
                    "object" === t.type(n) && (n = t.param(n, !0)),
                    t.each(i, function(t, i) {
                        e = e.replace("$" + t, i || "");
                    }),
                    n.length && (e += (e.indexOf("?") > 0 ? "&" : "?") + n),
                    e
                );
        };
    t(document).on("objectNeedsType.fb", function(n, s, a) {
        var r,
            o,
            l,
            c,
            d,
            u,
            h,
            p = a.src || "",
            f = !1;
        (r = t.extend(!0, {}, e, a.opts.media)),
        t.each(r, function(e, n) {
                if ((l = p.match(n.matcher))) {
                    if (
                        ((f = n.type), (h = e), (u = {}), n.paramPlace && l[n.paramPlace])
                    ) {
                        "?" == (d = l[n.paramPlace])[0] && (d = d.substring(1)),
                        (d = d.split("&"));
                        for (var s = 0; s < d.length; ++s) {
                            var r = d[s].split("=", 2);
                            2 == r.length &&
                                (u[r[0]] = decodeURIComponent(r[1].replace(/\+/g, " ")));
                        }
                    }
                    return (
                        (c = t.extend(!0, {}, n.params, a.opts[e], u)),
                        (p =
                            "function" === t.type(n.url) ?
                            n.url.call(this, l, c, a) :
                            i(n.url, l, c)),
                        (o =
                            "function" === t.type(n.thumb) ?
                            n.thumb.call(this, l, c, a) :
                            i(n.thumb, l)),
                        "youtube" === e ?
                        (p = p.replace(/&t=((\d+)m)?(\d+)s/, function(t, e, i, n) {
                            return (
                                "&start=" +
                                ((i ? 60 * parseInt(i, 10) : 0) + parseInt(n, 10))
                            );
                        })) :
                        "vimeo" === e && (p = p.replace("&%23", "#")), !1
                    );
                }
            }),
            f ?
            (a.opts.thumb ||
                (a.opts.$thumb && a.opts.$thumb.length) ||
                (a.opts.thumb = o),
                "iframe" === f &&
                (a.opts = t.extend(!0, a.opts, {
                    iframe: {
                        preload: !1,
                        attr: {
                            scrolling: "no",
                        },
                    },
                })),
                t.extend(a, {
                    type: f,
                    src: p,
                    origSrc: a.src,
                    contentSource: h,
                    contentType: "image" === f ?
                        "image" : "gmap_place" == h || "gmap_search" == h ?
                        "map" : "video",
                })) :
            p && (a.type = a.opts.defaultType);
    });
    var n = {
        youtube: {
            src: "https://www.youtube.com/iframe_api",
            class: "YT",
            loading: !1,
            loaded: !1,
        },
        vimeo: {
            src: "https://player.vimeo.com/api/player.js",
            class: "Vimeo",
            loading: !1,
            loaded: !1,
        },
        load: function(t) {
            var e,
                i = this;
            this[t].loaded ?
                setTimeout(function() {
                    i.done(t);
                }) :
                this[t].loading ||
                ((this[t].loading = !0),
                    ((e = document.createElement("script")).type = "text/javascript"),
                    (e.src = this[t].src),
                    "youtube" === t ?
                    (window.onYouTubeIframeAPIReady = function() {
                        (i[t].loaded = !0), i.done(t);
                    }) :
                    (e.onload = function() {
                        (i[t].loaded = !0), i.done(t);
                    }),
                    document.body.appendChild(e));
        },
        done: function(e) {
            var i, n;
            "youtube" === e && delete window.onYouTubeIframeAPIReady,
                (i = t.fancybox.getInstance()) &&
                ((n = i.current.$content.find("iframe")),
                    "youtube" === e && void 0 !== YT && YT ?
                    new YT.Player(n.attr("id"), {
                        events: {
                            onStateChange: function(t) {
                                0 == t.data && i.next();
                            },
                        },
                    }) :
                    "vimeo" === e &&
                    void 0 !== Vimeo &&
                    Vimeo &&
                    new Vimeo.Player(n).on("ended", function() {
                        i.next();
                    }));
        },
    };
    t(document).on({
        "afterShow.fb": function(t, e, i) {
            e.group.length > 1 &&
                ("youtube" === i.contentSource || "vimeo" === i.contentSource) &&
                n.load(i.contentSource);
        },
    });
})(jQuery),
(function(t, e, i) {
    "use strict";
    var n =
        t.requestAnimationFrame ||
        t.webkitRequestAnimationFrame ||
        t.mozRequestAnimationFrame ||
        t.oRequestAnimationFrame ||
        function(e) {
            return t.setTimeout(e, 1e3 / 60);
        },
        s =
        t.cancelAnimationFrame ||
        t.webkitCancelAnimationFrame ||
        t.mozCancelAnimationFrame ||
        t.oCancelAnimationFrame ||
        function(e) {
            t.clearTimeout(e);
        },
        a = function(e) {
            var i = [];
            for (var n in (e =
                    (e = e.originalEvent || e || t.e).touches && e.touches.length ?
                    e.touches :
                    e.changedTouches && e.changedTouches.length ?
                    e.changedTouches : [e]))
                e[n].pageX ?
                i.push({
                    x: e[n].pageX,
                    y: e[n].pageY,
                }) :
                e[n].clientX &&
                i.push({
                    x: e[n].clientX,
                    y: e[n].clientY,
                });
            return i;
        },
        r = function(t, e, i) {
            return e && t ?
                "x" === i ?
                t.x - e.x :
                "y" === i ?
                t.y - e.y :
                Math.sqrt(Math.pow(t.x - e.x, 2) + Math.pow(t.y - e.y, 2)) :
                0;
        },
        o = function(t) {
            if (
                t.is(
                    'a,area,button,[role="button"],input,label,select,summary,textarea,video,audio,iframe'
                ) ||
                i.isFunction(t.get(0).onclick) ||
                t.data("selectable")
            )
                return !0;
            for (var e = 0, n = t[0].attributes, s = n.length; e < s; e++)
                if ("data-fancybox-" === n[e].nodeName.substr(0, 14)) return !0;
            return !1;
        },
        l = function(e) {
            var i = t.getComputedStyle(e)["overflow-y"],
                n = t.getComputedStyle(e)["overflow-x"],
                s =
                ("scroll" === i || "auto" === i) && e.scrollHeight > e.clientHeight,
                a = ("scroll" === n || "auto" === n) && e.scrollWidth > e.clientWidth;
            return s || a;
        },
        c = function(t) {
            for (
                var e = !1; !(e = l(t.get(0))) &&
                (t = t.parent()).length &&
                !t.hasClass("fancybox-stage") &&
                !t.is("body");

            );
            return e;
        },
        d = function(t) {
            var e = this;
            (e.instance = t),
            (e.$bg = t.$refs.bg),
            (e.$stage = t.$refs.stage),
            (e.$container = t.$refs.container),
            e.destroy(),
                e.$container.on(
                    "touchstart.fb.touch mousedown.fb.touch",
                    i.proxy(e, "ontouchstart")
                );
        };
    (d.prototype.destroy = function() {
        var t = this;
        t.$container.off(".fb.touch"),
            i(e).off(".fb.touch"),
            t.requestId && (s(t.requestId), (t.requestId = null)),
            t.tapped && (clearTimeout(t.tapped), (t.tapped = null));
    }),
    (d.prototype.ontouchstart = function(n) {
        var s = this,
            l = i(n.target),
            d = s.instance,
            u = d.current,
            h = u.$slide,
            p = u.$content,
            f = "touchstart" == n.type;
        if (
            (f && s.$container.off("mousedown.fb.touch"),
                (!n.originalEvent || 2 != n.originalEvent.button) &&
                h.length &&
                l.length &&
                !o(l) &&
                !o(l.parent()) &&
                (l.is("img") ||
                    !(n.originalEvent.clientX > l[0].clientWidth + l.offset().left)))
        ) {
            if (!u || d.isAnimating || u.$slide.hasClass("fancybox-animated"))
                return n.stopPropagation(), void n.preventDefault();
            (s.realPoints = s.startPoints = a(n)),
            s.startPoints.length &&
                (u.touch && n.stopPropagation(),
                    (s.startEvent = n),
                    (s.canTap = !0),
                    (s.$target = l),
                    (s.$content = p),
                    (s.opts = u.opts.touch),
                    (s.isPanning = !1),
                    (s.isSwiping = !1),
                    (s.isZooming = !1),
                    (s.isScrolling = !1),
                    (s.canPan = d.canPan()),
                    (s.startTime = new Date().getTime()),
                    (s.distanceX = s.distanceY = s.distance = 0),
                    (s.canvasWidth = Math.round(h[0].clientWidth)),
                    (s.canvasHeight = Math.round(h[0].clientHeight)),
                    (s.contentLastPos = null),
                    (s.contentStartPos = i.fancybox.getTranslate(s.$content) || {
                        top: 0,
                        left: 0,
                    }),
                    (s.sliderStartPos = i.fancybox.getTranslate(h)),
                    (s.stagePos = i.fancybox.getTranslate(d.$refs.stage)),
                    (s.sliderStartPos.top -= s.stagePos.top),
                    (s.sliderStartPos.left -= s.stagePos.left),
                    (s.contentStartPos.top -= s.stagePos.top),
                    (s.contentStartPos.left -= s.stagePos.left),
                    i(e)
                    .off(".fb.touch")
                    .on(
                        f ?
                        "touchend.fb.touch touchcancel.fb.touch" :
                        "mouseup.fb.touch mouseleave.fb.touch",
                        i.proxy(s, "ontouchend")
                    )
                    .on(
                        f ? "touchmove.fb.touch" : "mousemove.fb.touch",
                        i.proxy(s, "ontouchmove")
                    ),
                    i.fancybox.isMobile &&
                    e.addEventListener("scroll", s.onscroll, !0),
                    (((s.opts || s.canPan) &&
                            (l.is(s.$stage) || s.$stage.find(l).length)) ||
                        (l.is(".fancybox-image") && n.preventDefault(),
                            i.fancybox.isMobile &&
                            l.parents(".fancybox-caption").length)) &&
                    ((s.isScrollable = c(l) || c(l.parent())),
                        (i.fancybox.isMobile && s.isScrollable) || n.preventDefault(),
                        (1 === s.startPoints.length || u.hasError) &&
                        (s.canPan ?
                            (i.fancybox.stop(s.$content), (s.isPanning = !0)) :
                            (s.isSwiping = !0),
                            s.$container.addClass("fancybox-is-grabbing")),
                        2 === s.startPoints.length &&
                        "image" === u.type &&
                        (u.isLoaded || u.$ghost) &&
                        ((s.canTap = !1),
                            (s.isSwiping = !1),
                            (s.isPanning = !1),
                            (s.isZooming = !0),
                            i.fancybox.stop(s.$content),
                            (s.centerPointStartX =
                                0.5 * (s.startPoints[0].x + s.startPoints[1].x) -
                                i(t).scrollLeft()),
                            (s.centerPointStartY =
                                0.5 * (s.startPoints[0].y + s.startPoints[1].y) -
                                i(t).scrollTop()),
                            (s.percentageOfImageAtPinchPointX =
                                (s.centerPointStartX - s.contentStartPos.left) /
                                s.contentStartPos.width),
                            (s.percentageOfImageAtPinchPointY =
                                (s.centerPointStartY - s.contentStartPos.top) /
                                s.contentStartPos.height),
                            (s.startDistanceBetweenFingers = r(
                                s.startPoints[0],
                                s.startPoints[1]
                            )))));
        }
    }),
    (d.prototype.onscroll = function(t) {
        (this.isScrolling = !0),
        e.removeEventListener("scroll", this.onscroll, !0);
    }),
    (d.prototype.ontouchmove = function(t) {
        var e = this;
        return void 0 !== t.originalEvent.buttons &&
            0 === t.originalEvent.buttons ?
            void e.ontouchend(t) :
            e.isScrolling ?
            void(e.canTap = !1) :
            ((e.newPoints = a(t)),
                void(
                    (e.opts || e.canPan) &&
                    e.newPoints.length &&
                    e.newPoints.length &&
                    ((e.isSwiping && !0 === e.isSwiping) || t.preventDefault(),
                        (e.distanceX = r(e.newPoints[0], e.startPoints[0], "x")),
                        (e.distanceY = r(e.newPoints[0], e.startPoints[0], "y")),
                        (e.distance = r(e.newPoints[0], e.startPoints[0])),
                        e.distance > 0 &&
                        (e.isSwiping ?
                            e.onSwipe(t) :
                            e.isPanning ?
                            e.onPan() :
                            e.isZooming && e.onZoom()))
                ));
    }),
    (d.prototype.onSwipe = function(e) {
        var a,
            r = this,
            o = r.instance,
            l = r.isSwiping,
            c = r.sliderStartPos.left || 0;
        if (!0 !== l)
            "x" == l &&
            (r.distanceX > 0 &&
                (r.instance.group.length < 2 ||
                    (0 === r.instance.current.index && !r.instance.current.opts.loop)) ?
                (c += Math.pow(r.distanceX, 0.8)) :
                r.distanceX < 0 &&
                (r.instance.group.length < 2 ||
                    (r.instance.current.index === r.instance.group.length - 1 &&
                        !r.instance.current.opts.loop)) ?
                (c -= Math.pow(-r.distanceX, 0.8)) :
                (c += r.distanceX)),
            (r.sliderLastPos = {
                top: "x" == l ? 0 : r.sliderStartPos.top + r.distanceY,
                left: c,
            }),
            r.requestId && (s(r.requestId), (r.requestId = null)),
            (r.requestId = n(function() {
                r.sliderLastPos &&
                    (i.each(r.instance.slides, function(t, e) {
                            var n = e.pos - r.instance.currPos;
                            i.fancybox.setTranslate(e.$slide, {
                                top: r.sliderLastPos.top,
                                left: r.sliderLastPos.left +
                                    n * r.canvasWidth +
                                    n * e.opts.gutter,
                            });
                        }),
                        r.$container.addClass("fancybox-is-sliding"));
            }));
        else if (Math.abs(r.distance) > 10) {
            if (
                ((r.canTap = !1),
                    o.group.length < 2 && r.opts.vertical ?
                    (r.isSwiping = "y") :
                    o.isDragging ||
                    !1 === r.opts.vertical ||
                    ("auto" === r.opts.vertical && i(t).width() > 800) ?
                    (r.isSwiping = "x") :
                    ((a = Math.abs(
                            (180 * Math.atan2(r.distanceY, r.distanceX)) / Math.PI
                        )),
                        (r.isSwiping = a > 45 && a < 135 ? "y" : "x")),
                    "y" === r.isSwiping && i.fancybox.isMobile && r.isScrollable)
            )
                return void(r.isScrolling = !0);
            (o.isDragging = r.isSwiping),
            (r.startPoints = r.newPoints),
            i.each(o.slides, function(t, e) {
                    var n, s;
                    i.fancybox.stop(e.$slide),
                        (n = i.fancybox.getTranslate(e.$slide)),
                        (s = i.fancybox.getTranslate(o.$refs.stage)),
                        e.$slide
                        .css({
                            transform: "",
                            opacity: "",
                            "transition-duration": "",
                        })
                        .removeClass("fancybox-animated")
                        .removeClass(function(t, e) {
                            return (e.match(/(^|\s)fancybox-fx-\S+/g) || []).join(" ");
                        }),
                        e.pos === o.current.pos &&
                        ((r.sliderStartPos.top = n.top - s.top),
                            (r.sliderStartPos.left = n.left - s.left)),
                        i.fancybox.setTranslate(e.$slide, {
                            top: n.top - s.top,
                            left: n.left - s.left,
                        });
                }),
                o.SlideShow && o.SlideShow.isActive && o.SlideShow.stop();
        }
    }),
    (d.prototype.onPan = function() {
        var t = this;
        r(t.newPoints[0], t.realPoints[0]) < (i.fancybox.isMobile ? 10 : 5) ?
            (t.startPoints = t.newPoints) :
            ((t.canTap = !1),
                (t.contentLastPos = t.limitMovement()),
                t.requestId && s(t.requestId),
                (t.requestId = n(function() {
                    i.fancybox.setTranslate(t.$content, t.contentLastPos);
                })));
    }),
    (d.prototype.limitMovement = function() {
        var t,
            e,
            i,
            n,
            s,
            a,
            r = this,
            o = r.canvasWidth,
            l = r.canvasHeight,
            c = r.distanceX,
            d = r.distanceY,
            u = r.contentStartPos,
            h = u.left,
            p = u.top,
            f = u.width,
            m = u.height;
        return (
            (s = f > o ? h + c : h),
            (a = p + d),
            (t = Math.max(0, 0.5 * o - 0.5 * f)),
            (e = Math.max(0, 0.5 * l - 0.5 * m)),
            (i = Math.min(o - f, 0.5 * o - 0.5 * f)),
            (n = Math.min(l - m, 0.5 * l - 0.5 * m)),
            c > 0 && s > t && (s = t - 1 + Math.pow(-t + h + c, 0.8) || 0),
            c < 0 && s < i && (s = i + 1 - Math.pow(i - h - c, 0.8) || 0),
            d > 0 && a > e && (a = e - 1 + Math.pow(-e + p + d, 0.8) || 0),
            d < 0 && a < n && (a = n + 1 - Math.pow(n - p - d, 0.8) || 0), {
                top: a,
                left: s,
            }
        );
    }),
    (d.prototype.limitPosition = function(t, e, i, n) {
        var s = this.canvasWidth,
            a = this.canvasHeight;
        return (
            i > s ?
            (t = (t = t > 0 ? 0 : t) < s - i ? s - i : t) :
            (t = Math.max(0, s / 2 - i / 2)),
            n > a ?
            (e = (e = e > 0 ? 0 : e) < a - n ? a - n : e) :
            (e = Math.max(0, a / 2 - n / 2)), {
                top: e,
                left: t,
            }
        );
    }),
    (d.prototype.onZoom = function() {
        var e = this,
            a = e.contentStartPos,
            o = a.width,
            l = a.height,
            c = a.left,
            d = a.top,
            u = r(e.newPoints[0], e.newPoints[1]) / e.startDistanceBetweenFingers,
            h = Math.floor(o * u),
            p = Math.floor(l * u),
            f = (o - h) * e.percentageOfImageAtPinchPointX,
            m = (l - p) * e.percentageOfImageAtPinchPointY,
            v = (e.newPoints[0].x + e.newPoints[1].x) / 2 - i(t).scrollLeft(),
            g = (e.newPoints[0].y + e.newPoints[1].y) / 2 - i(t).scrollTop(),
            y = v - e.centerPointStartX,
            b = {
                top: d + (m + (g - e.centerPointStartY)),
                left: c + (f + y),
                scaleX: u,
                scaleY: u,
            };
        (e.canTap = !1),
        (e.newWidth = h),
        (e.newHeight = p),
        (e.contentLastPos = b),
        e.requestId && s(e.requestId),
            (e.requestId = n(function() {
                i.fancybox.setTranslate(e.$content, e.contentLastPos);
            }));
    }),
    (d.prototype.ontouchend = function(t) {
        var n = this,
            r = n.isSwiping,
            o = n.isPanning,
            l = n.isZooming,
            c = n.isScrolling;
        if (
            ((n.endPoints = a(t)),
                (n.dMs = Math.max(new Date().getTime() - n.startTime, 1)),
                n.$container.removeClass("fancybox-is-grabbing"),
                i(e).off(".fb.touch"),
                e.removeEventListener("scroll", n.onscroll, !0),
                n.requestId && (s(n.requestId), (n.requestId = null)),
                (n.isSwiping = !1),
                (n.isPanning = !1),
                (n.isZooming = !1),
                (n.isScrolling = !1),
                (n.instance.isDragging = !1),
                n.canTap)
        )
            return n.onTap(t);
        (n.speed = 100),
        (n.velocityX = (n.distanceX / n.dMs) * 0.5),
        (n.velocityY = (n.distanceY / n.dMs) * 0.5),
        o ? n.endPanning() : l ? n.endZooming() : n.endSwiping(r, c);
    }),
    (d.prototype.endSwiping = function(t, e) {
        var n = this,
            s = !1,
            a = n.instance.group.length,
            r = Math.abs(n.distanceX),
            o = "x" == t && a > 1 && ((n.dMs > 130 && r > 10) || r > 50);
        (n.sliderLastPos = null),
        "y" == t && !e && Math.abs(n.distanceY) > 50 ?
            (i.fancybox.animate(
                    n.instance.current.$slide, {
                        top: n.sliderStartPos.top + n.distanceY + 150 * n.velocityY,
                        opacity: 0,
                    },
                    200
                ),
                (s = n.instance.close(!0, 250))) :
            o && n.distanceX > 0 ?
            (s = n.instance.previous(300)) :
            o && n.distanceX < 0 && (s = n.instance.next(300)), !1 !== s || ("x" != t && "y" != t) || n.instance.centerSlide(200),
            n.$container.removeClass("fancybox-is-sliding");
    }),
    (d.prototype.endPanning = function() {
        var t,
            e,
            n,
            s = this;
        s.contentLastPos &&
            (!1 === s.opts.momentum || s.dMs > 350 ?
                ((t = s.contentLastPos.left), (e = s.contentLastPos.top)) :
                ((t = s.contentLastPos.left + 500 * s.velocityX),
                    (e = s.contentLastPos.top + 500 * s.velocityY)),
                ((n = s.limitPosition(
                    t,
                    e,
                    s.contentStartPos.width,
                    s.contentStartPos.height
                )).width = s.contentStartPos.width),
                (n.height = s.contentStartPos.height),
                i.fancybox.animate(s.$content, n, 366));
    }),
    (d.prototype.endZooming = function() {
        var t,
            e,
            n,
            s,
            a = this,
            r = a.instance.current,
            o = a.newWidth,
            l = a.newHeight;
        a.contentLastPos &&
            ((t = a.contentLastPos.left),
                (s = {
                    top: (e = a.contentLastPos.top),
                    left: t,
                    width: o,
                    height: l,
                    scaleX: 1,
                    scaleY: 1,
                }),
                i.fancybox.setTranslate(a.$content, s),
                o < a.canvasWidth && l < a.canvasHeight ?
                a.instance.scaleToFit(150) :
                o > r.width || l > r.height ?
                a.instance.scaleToActual(
                    a.centerPointStartX,
                    a.centerPointStartY,
                    150
                ) :
                ((n = a.limitPosition(t, e, o, l)),
                    i.fancybox.animate(a.$content, n, 150)));
    }),
    (d.prototype.onTap = function(e) {
        var n,
            s = this,
            r = i(e.target),
            o = s.instance,
            l = o.current,
            c = (e && a(e)) || s.startPoints,
            d = c[0] ? c[0].x - i(t).scrollLeft() - s.stagePos.left : 0,
            u = c[0] ? c[0].y - i(t).scrollTop() - s.stagePos.top : 0,
            h = function(t) {
                var n = l.opts[t];
                if ((i.isFunction(n) && (n = n.apply(o, [l, e])), n))
                    switch (n) {
                        case "close":
                            o.close(s.startEvent);
                            break;
                        case "toggleControls":
                            o.toggleControls();
                            break;
                        case "next":
                            o.next();
                            break;
                        case "nextOrClose":
                            o.group.length > 1 ? o.next() : o.close(s.startEvent);
                            break;
                        case "zoom":
                            "image" == l.type &&
                                (l.isLoaded || l.$ghost) &&
                                (o.canPan() ?
                                    o.scaleToFit() :
                                    o.isScaledDown() ?
                                    o.scaleToActual(d, u) :
                                    o.group.length < 2 && o.close(s.startEvent));
                    }
            };
        if (
            (!e.originalEvent || 2 != e.originalEvent.button) &&
            (r.is("img") || !(d > r[0].clientWidth + r.offset().left))
        ) {
            if (
                r.is(
                    ".fancybox-bg,.fancybox-inner,.fancybox-outer,.fancybox-container"
                )
            )
                n = "Outside";
            else if (r.is(".fancybox-slide")) n = "Slide";
            else {
                if (!o.current.$content ||
                    !o.current.$content.find(r).addBack().filter(r).length
                )
                    return;
                n = "Content";
            }
            if (s.tapped) {
                if (
                    (clearTimeout(s.tapped),
                        (s.tapped = null),
                        Math.abs(d - s.tapX) > 50 || Math.abs(u - s.tapY) > 50)
                )
                    return this;
                h("dblclick" + n);
            } else
                (s.tapX = d),
                (s.tapY = u),
                l.opts["dblclick" + n] &&
                l.opts["dblclick" + n] !== l.opts["click" + n] ?
                (s.tapped = setTimeout(function() {
                    (s.tapped = null), o.isAnimating || h("click" + n);
                }, 500)) :
                h("click" + n);
            return this;
        }
    }),
    i(e)
        .on("onActivate.fb", function(t, e) {
            e && !e.Guestures && (e.Guestures = new d(e));
        })
        .on("beforeClose.fb", function(t, e) {
            e && e.Guestures && e.Guestures.destroy();
        });
})(window, document, jQuery),
(function(t, e) {
    "use strict";
    e.extend(!0, e.fancybox.defaults, {
        btnTpl: {
            slideShow: '<button data-fancybox-play class="fancybox-button fancybox-button--play" title="{{PLAY_START}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.5 5.4v13.2l11-6.6z"/></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.33 5.75h2.2v12.5h-2.2V5.75zm5.15 0h2.2v12.5h-2.2V5.75z"/></svg></button>',
        },
        slideShow: {
            autoStart: !1,
            speed: 3e3,
            progress: !0,
        },
    });
    var i = function(t) {
        (this.instance = t), this.init();
    };
    e.extend(i.prototype, {
            timer: null,
            isActive: !1,
            $button: null,
            init: function() {
                var t = this,
                    i = t.instance,
                    n = i.group[i.currIndex].opts.slideShow;
                (t.$button = i.$refs.toolbar
                    .find("[data-fancybox-play]")
                    .on("click", function() {
                        t.toggle();
                    })),
                i.group.length < 2 || !n ?
                    t.$button.hide() :
                    n.progress &&
                    (t.$progress = e(
                        '<div class="fancybox-progress"></div>'
                    ).appendTo(i.$refs.inner));
            },
            set: function(t) {
                var i = this,
                    n = i.instance,
                    s = n.current;
                s && (!0 === t || s.opts.loop || n.currIndex < n.group.length - 1) ?
                    i.isActive &&
                    "video" !== s.contentType &&
                    (i.$progress &&
                        e.fancybox.animate(
                            i.$progress.show(), {
                                scaleX: 1,
                            },
                            s.opts.slideShow.speed
                        ),
                        (i.timer = setTimeout(function() {
                            n.current.opts.loop || n.current.index != n.group.length - 1 ?
                                n.next() :
                                n.jumpTo(0);
                        }, s.opts.slideShow.speed))) :
                    (i.stop(), (n.idleSecondsCounter = 0), n.showControls());
            },
            clear: function() {
                var t = this;
                clearTimeout(t.timer),
                    (t.timer = null),
                    t.$progress && t.$progress.removeAttr("style").hide();
            },
            start: function() {
                var t = this,
                    e = t.instance.current;
                e &&
                    (t.$button
                        .attr(
                            "title",
                            (e.opts.i18n[e.opts.lang] || e.opts.i18n.en).PLAY_STOP
                        )
                        .removeClass("fancybox-button--play")
                        .addClass("fancybox-button--pause"),
                        (t.isActive = !0),
                        e.isComplete && t.set(!0),
                        t.instance.trigger("onSlideShowChange", !0));
            },
            stop: function() {
                var t = this,
                    e = t.instance.current;
                t.clear(),
                    t.$button
                    .attr(
                        "title",
                        (e.opts.i18n[e.opts.lang] || e.opts.i18n.en).PLAY_START
                    )
                    .removeClass("fancybox-button--pause")
                    .addClass("fancybox-button--play"),
                    (t.isActive = !1),
                    t.instance.trigger("onSlideShowChange", !1),
                    t.$progress && t.$progress.removeAttr("style").hide();
            },
            toggle: function() {
                var t = this;
                t.isActive ? t.stop() : t.start();
            },
        }),
        e(t).on({
            "onInit.fb": function(t, e) {
                e && !e.SlideShow && (e.SlideShow = new i(e));
            },
            "beforeShow.fb": function(t, e, i, n) {
                var s = e && e.SlideShow;
                n
                    ?
                    s && i.opts.slideShow.autoStart && s.start() :
                    s && s.isActive && s.clear();
            },
            "afterShow.fb": function(t, e, i) {
                var n = e && e.SlideShow;
                n && n.isActive && n.set();
            },
            "afterKeydown.fb": function(i, n, s, a, r) {
                var o = n && n.SlideShow;
                !o ||
                    !s.opts.slideShow ||
                    (80 !== r && 32 !== r) ||
                    e(t.activeElement).is("button,a,input") ||
                    (a.preventDefault(), o.toggle());
            },
            "beforeClose.fb onDeactivate.fb": function(t, e) {
                var i = e && e.SlideShow;
                i && i.stop();
            },
        }),
        e(t).on("visibilitychange", function() {
            var i = e.fancybox.getInstance(),
                n = i && i.SlideShow;
            n && n.isActive && (t.hidden ? n.clear() : n.set());
        });
})(document, jQuery),
(function(t, e) {
    "use strict";
    var i = (function() {
        for (
            var e = [
                    [
                        "requestFullscreen",
                        "exitFullscreen",
                        "fullscreenElement",
                        "fullscreenEnabled",
                        "fullscreenchange",
                        "fullscreenerror",
                    ],
                    [
                        "webkitRequestFullscreen",
                        "webkitExitFullscreen",
                        "webkitFullscreenElement",
                        "webkitFullscreenEnabled",
                        "webkitfullscreenchange",
                        "webkitfullscreenerror",
                    ],
                    [
                        "webkitRequestFullScreen",
                        "webkitCancelFullScreen",
                        "webkitCurrentFullScreenElement",
                        "webkitCancelFullScreen",
                        "webkitfullscreenchange",
                        "webkitfullscreenerror",
                    ],
                    [
                        "mozRequestFullScreen",
                        "mozCancelFullScreen",
                        "mozFullScreenElement",
                        "mozFullScreenEnabled",
                        "mozfullscreenchange",
                        "mozfullscreenerror",
                    ],
                    [
                        "msRequestFullscreen",
                        "msExitFullscreen",
                        "msFullscreenElement",
                        "msFullscreenEnabled",
                        "MSFullscreenChange",
                        "MSFullscreenError",
                    ],
                ],
                i = {},
                n = 0; n < e.length; n++
        ) {
            var s = e[n];
            if (s && s[1] in t) {
                for (var a = 0; a < s.length; a++) i[e[0][a]] = s[a];
                return i;
            }
        }
        return !1;
    })();
    if (i) {
        var n = {
            request: function(e) {
                (e = e || t.documentElement)[i.requestFullscreen](
                    e.ALLOW_KEYBOARD_INPUT
                );
            },
            exit: function() {
                t[i.exitFullscreen]();
            },
            toggle: function(e) {
                (e = e || t.documentElement),
                this.isFullscreen() ? this.exit() : this.request(e);
            },
            isFullscreen: function() {
                return Boolean(t[i.fullscreenElement]);
            },
            enabled: function() {
                return Boolean(t[i.fullscreenEnabled]);
            },
        };
        e.extend(!0, e.fancybox.defaults, {
                btnTpl: {
                    fullScreen: '<button data-fancybox-fullscreen class="fancybox-button fancybox-button--fsenter" title="{{FULL_SCREEN}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5 16h3v3h2v-5H5zm3-8H5v2h5V5H8zm6 11h2v-3h3v-2h-5zm2-11V5h-2v5h5V8z"/></svg></button>',
                },
                fullScreen: {
                    autoStart: !1,
                },
            }),
            e(t).on(i.fullscreenchange, function() {
                var t = n.isFullscreen(),
                    i = e.fancybox.getInstance();
                i &&
                    (i.current &&
                        "image" === i.current.type &&
                        i.isAnimating &&
                        ((i.isAnimating = !1),
                            i.update(!0, !0, 0),
                            i.isComplete || i.complete()),
                        i.trigger("onFullscreenChange", t),
                        i.$refs.container.toggleClass("fancybox-is-fullscreen", t),
                        i.$refs.toolbar
                        .find("[data-fancybox-fullscreen]")
                        .toggleClass("fancybox-button--fsenter", !t)
                        .toggleClass("fancybox-button--fsexit", t));
            });
    }
    e(t).on({
        "onInit.fb": function(t, e) {
            i
                ?
                e && e.group[e.currIndex].opts.fullScreen ?
                (e.$refs.container.on(
                        "click.fb-fullscreen",
                        "[data-fancybox-fullscreen]",
                        function(t) {
                            t.stopPropagation(), t.preventDefault(), n.toggle();
                        }
                    ),
                    e.opts.fullScreen &&
                    !0 === e.opts.fullScreen.autoStart &&
                    n.request(),
                    (e.FullScreen = n)) :
                e && e.$refs.toolbar.find("[data-fancybox-fullscreen]").hide() :
                e.$refs.toolbar.find("[data-fancybox-fullscreen]").remove();
        },
        "afterKeydown.fb": function(t, e, i, n, s) {
            e &&
                e.FullScreen &&
                70 === s &&
                (n.preventDefault(), e.FullScreen.toggle());
        },
        "beforeClose.fb": function(t, e) {
            e &&
                e.FullScreen &&
                e.$refs.container.hasClass("fancybox-is-fullscreen") &&
                n.exit();
        },
    });
})(document, jQuery),
(function(t, e) {
    "use strict";
    var i = "fancybox-thumbs";
    e.fancybox.defaults = e.extend(!0, {
            btnTpl: {
                thumbs: '<button data-fancybox-thumbs class="fancybox-button fancybox-button--thumbs" title="{{THUMBS}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14.59 14.59h3.76v3.76h-3.76v-3.76zm-4.47 0h3.76v3.76h-3.76v-3.76zm-4.47 0h3.76v3.76H5.65v-3.76zm8.94-4.47h3.76v3.76h-3.76v-3.76zm-4.47 0h3.76v3.76h-3.76v-3.76zm-4.47 0h3.76v3.76H5.65v-3.76zm8.94-4.47h3.76v3.76h-3.76V5.65zm-4.47 0h3.76v3.76h-3.76V5.65zm-4.47 0h3.76v3.76H5.65V5.65z"/></svg></button>',
            },
            thumbs: {
                autoStart: !1,
                hideOnClose: !0,
                parentEl: ".fancybox-container",
                axis: "y",
            },
        },
        e.fancybox.defaults
    );
    var n = function(t) {
        this.init(t);
    };
    e.extend(n.prototype, {
            $button: null,
            $grid: null,
            $list: null,
            isVisible: !1,
            isActive: !1,
            init: function(t) {
                var e = this,
                    i = t.group,
                    n = 0;
                (e.instance = t),
                (e.opts = i[t.currIndex].opts.thumbs),
                (t.Thumbs = e),
                (e.$button = t.$refs.toolbar.find("[data-fancybox-thumbs]"));
                for (
                    var s = 0, a = i.length; s < a && (i[s].thumb && n++, !(n > 1)); s++
                );
                n > 1 && e.opts ?
                    (e.$button.removeAttr("style").on("click", function() {
                            e.toggle();
                        }),
                        (e.isActive = !0)) :
                    e.$button.hide();
            },
            create: function() {
                var t,
                    n = this,
                    s = n.instance,
                    a = n.opts.parentEl,
                    r = [];
                n.$grid ||
                    ((n.$grid = e(
                            '<div class="' + i + " " + i + "-" + n.opts.axis + '"></div>'
                        ).appendTo(s.$refs.container.find(a).addBack().filter(a))),
                        n.$grid.on("click", "a", function() {
                            s.jumpTo(e(this).attr("data-index"));
                        })),
                    n.$list ||
                    (n.$list = e('<div class="' + i + '__list">').appendTo(n.$grid)),
                    e.each(s.group, function(e, i) {
                        (t = i.thumb) || "image" !== i.type || (t = i.src),
                            r.push(
                                '<a href="javascript:;" tabindex="0" data-index="' +
                                e +
                                '"' +
                                (t && t.length ?
                                    ' style="background-image:url(' + t + ')"' :
                                    'class="fancybox-thumbs-missing"') +
                                "></a>"
                            );
                    }),
                    (n.$list[0].innerHTML = r.join("")),
                    "x" === n.opts.axis &&
                    n.$list.width(
                        parseInt(n.$grid.css("padding-right"), 10) +
                        s.group.length * n.$list.children().eq(0).outerWidth(!0)
                    );
            },
            focus: function(t) {
                var e,
                    i,
                    n = this,
                    s = n.$list,
                    a = n.$grid;
                n.instance.current &&
                    ((i = (e = s
                            .children()
                            .removeClass("fancybox-thumbs-active")
                            .filter('[data-index="' + n.instance.current.index + '"]')
                            .addClass("fancybox-thumbs-active")).position()),
                        "y" === n.opts.axis &&
                        (i.top < 0 || i.top > s.height() - e.outerHeight()) ?
                        s.stop().animate({
                                scrollTop: s.scrollTop() + i.top,
                            },
                            t
                        ) :
                        "x" === n.opts.axis &&
                        (i.left < a.scrollLeft() ||
                            i.left > a.scrollLeft() + (a.width() - e.outerWidth())) &&
                        s.parent().stop().animate({
                                scrollLeft: i.left,
                            },
                            t
                        ));
            },
            update: function() {
                var t = this;
                t.instance.$refs.container.toggleClass(
                        "fancybox-show-thumbs",
                        this.isVisible
                    ),
                    t.isVisible ?
                    (t.$grid || t.create(),
                        t.instance.trigger("onThumbsShow"),
                        t.focus(0)) :
                    t.$grid && t.instance.trigger("onThumbsHide"),
                    t.instance.update();
            },
            hide: function() {
                (this.isVisible = !1), this.update();
            },
            show: function() {
                (this.isVisible = !0), this.update();
            },
            toggle: function() {
                (this.isVisible = !this.isVisible), this.update();
            },
        }),
        e(t).on({
            "onInit.fb": function(t, e) {
                var i;
                e &&
                    !e.Thumbs &&
                    (i = new n(e)).isActive &&
                    !0 === i.opts.autoStart &&
                    i.show();
            },
            "beforeShow.fb": function(t, e, i, n) {
                var s = e && e.Thumbs;
                s && s.isVisible && s.focus(n ? 0 : 250);
            },
            "afterKeydown.fb": function(t, e, i, n, s) {
                var a = e && e.Thumbs;
                a && a.isActive && 71 === s && (n.preventDefault(), a.toggle());
            },
            "beforeClose.fb": function(t, e) {
                var i = e && e.Thumbs;
                i && i.isVisible && !1 !== i.opts.hideOnClose && i.$grid.hide();
            },
        });
})(document, jQuery),
(function(t, e) {
    "use strict";
    e.extend(!0, e.fancybox.defaults, {
            btnTpl: {
                share: '<button data-fancybox-share class="fancybox-button fancybox-button--share" title="{{SHARE}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M2.55 19c1.4-8.4 9.1-9.8 11.9-9.8V5l7 7-7 6.3v-3.5c-2.8 0-10.5 2.1-11.9 4.2z"/></svg></button>',
            },
            share: {
                url: function(t, e) {
                    return (
                        (!t.currentHash &&
                            "inline" !== e.type &&
                            "html" !== e.type &&
                            (e.origSrc || e.src)) ||
                        window.location
                    );
                },
                tpl: '<div class="fancybox-share"><h1>{{SHARE}}</h1><p><a class="fancybox-share__button fancybox-share__button--fb" href="https://www.facebook.com/sharer/sharer.php?u={{url}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m287 456v-299c0-21 6-35 35-35h38v-63c-7-1-29-3-55-3-54 0-91 33-91 94v306m143-254h-205v72h196" /></svg><span>Facebook</span></a><a class="fancybox-share__button fancybox-share__button--tw" href="https://twitter.com/intent/tweet?url={{url}}&text={{descr}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m456 133c-14 7-31 11-47 13 17-10 30-27 37-46-15 10-34 16-52 20-61-62-157-7-141 75-68-3-129-35-169-85-22 37-11 86 26 109-13 0-26-4-37-9 0 39 28 72 65 80-12 3-25 4-37 2 10 33 41 57 77 57-42 30-77 38-122 34 170 111 378-32 359-208 16-11 30-25 41-42z" /></svg><span>Twitter</span></a><a class="fancybox-share__button fancybox-share__button--pt" href="https://www.pinterest.com/pin/create/button/?url={{url}}&description={{descr}}&media={{media}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m265 56c-109 0-164 78-164 144 0 39 15 74 47 87 5 2 10 0 12-5l4-19c2-6 1-8-3-13-9-11-15-25-15-45 0-58 43-110 113-110 62 0 96 38 96 88 0 67-30 122-73 122-24 0-42-19-36-44 6-29 20-60 20-81 0-19-10-35-31-35-25 0-44 26-44 60 0 21 7 36 7 36l-30 125c-8 37-1 83 0 87 0 3 4 4 5 2 2-3 32-39 42-75l16-64c8 16 31 29 56 29 74 0 124-67 124-157 0-69-58-132-146-132z" fill="#fff"/></svg><span>Pinterest</span></a></p><p><input class="fancybox-share__input" type="text" value="{{url_raw}}" onclick="select()" /></p></div>',
            },
        }),
        e(t).on("click", "[data-fancybox-share]", function() {
            var t,
                i,
                n = e.fancybox.getInstance(),
                s = n.current || null;
            s &&
                ("function" === e.type(s.opts.share.url) &&
                    (t = s.opts.share.url.apply(s, [n, s])),
                    (i = s.opts.share.tpl
                        .replace(
                            /\{\{media\}\}/g,
                            "image" === s.type ? encodeURIComponent(s.src) : ""
                        )
                        .replace(/\{\{url\}\}/g, encodeURIComponent(t))
                        .replace(
                            /\{\{url_raw\}\}/g,
                            (function(t) {
                                var e = {
                                    "&": "&amp;",
                                    "<": "&lt;",
                                    ">": "&gt;",
                                    '"': "&quot;",
                                    "'": "&#39;",
                                    "/": "&#x2F;",
                                    "`": "&#x60;",
                                    "=": "&#x3D;",
                                };
                                return String(t).replace(/[&<>"'`=\/]/g, function(t) {
                                    return e[t];
                                });
                            })(t)
                        )
                        .replace(
                            /\{\{descr\}\}/g,
                            n.$caption ? encodeURIComponent(n.$caption.text()) : ""
                        )),
                    e.fancybox.open({
                        src: n.translate(n, i),
                        type: "html",
                        opts: {
                            touch: !1,
                            animationEffect: !1,
                            afterLoad: function(t, e) {
                                n.$refs.container.one("beforeClose.fb", function() {
                                        t.close(null, 0);
                                    }),
                                    e.$content.find(".fancybox-share__button").click(function() {
                                        return (
                                            window.open(this.href, "Share", "width=550, height=450"), !1
                                        );
                                    });
                            },
                            mobile: {
                                autoFocus: !1,
                            },
                        },
                    }));
        });
})(document, jQuery),
(function(t, e, i) {
    "use strict";

    function n() {
        var e = t.location.hash.substr(1),
            i = e.split("-"),
            n =
            (i.length > 1 &&
                /^\+?\d+$/.test(i[i.length - 1]) &&
                parseInt(i.pop(-1), 10)) ||
            1;
        return {
            hash: e,
            index: n < 1 ? 1 : n,
            gallery: i.join("-"),
        };
    }

    function s(t) {
        "" !== t.gallery &&
            i("[data-fancybox='" + i.escapeSelector(t.gallery) + "']")
            .eq(t.index - 1)
            .focus()
            .trigger("click.fb-start");
    }

    function a(t) {
        var e, i;
        return (!!t &&
            "" !==
            (i =
                (e = t.current ? t.current.opts : t.opts).hash ||
                (e.$orig ?
                    e.$orig.data("fancybox") || e.$orig.data("fancybox-trigger") :
                    "")) &&
            i
        );
    }
    i.escapeSelector ||
        (i.escapeSelector = function(t) {
            return (t + "").replace(
                /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g,
                function(t, e) {
                    return e ?
                        "\0" === t ?
                        "�" :
                        t.slice(0, -1) +
                        "\\" +
                        t.charCodeAt(t.length - 1).toString(16) +
                        " " :
                        "\\" + t;
                }
            );
        }),
        i(function() {
            !1 !== i.fancybox.defaults.hash &&
                (i(e).on({
                        "onInit.fb": function(t, e) {
                            var i, s;
                            !1 !== e.group[e.currIndex].opts.hash &&
                                ((i = n()),
                                    (s = a(e)) &&
                                    i.gallery &&
                                    s == i.gallery &&
                                    (e.currIndex = i.index - 1));
                        },
                        "beforeShow.fb": function(i, n, s, r) {
                            var o;
                            s &&
                                !1 !== s.opts.hash &&
                                (o = a(n)) &&
                                ((n.currentHash =
                                        o + (n.group.length > 1 ? "-" + (s.index + 1) : "")),
                                    t.location.hash !== "#" + n.currentHash &&
                                    (r && !n.origHash && (n.origHash = t.location.hash),
                                        n.hashTimer && clearTimeout(n.hashTimer),
                                        (n.hashTimer = setTimeout(function() {
                                            "replaceState" in t.history ?
                                                (t.history[r ? "pushState" : "replaceState"]({},
                                                        e.title,
                                                        t.location.pathname +
                                                        t.location.search +
                                                        "#" +
                                                        n.currentHash
                                                    ),
                                                    r && (n.hasCreatedHistory = !0)) :
                                                (t.location.hash = n.currentHash),
                                                (n.hashTimer = null);
                                        }, 300))));
                        },
                        "beforeClose.fb": function(i, n, s) {
                            s &&
                                !1 !== s.opts.hash &&
                                (clearTimeout(n.hashTimer),
                                    n.currentHash && n.hasCreatedHistory ?
                                    t.history.back() :
                                    n.currentHash &&
                                    ("replaceState" in t.history ?
                                        t.history.replaceState({},
                                            e.title,
                                            t.location.pathname +
                                            t.location.search +
                                            (n.origHash || "")
                                        ) :
                                        (t.location.hash = n.origHash)),
                                    (n.currentHash = null));
                        },
                    }),
                    i(t).on("hashchange.fb", function() {
                        var t = n(),
                            e = null;
                        i.each(i(".fancybox-container").get().reverse(), function(t, n) {
                                var s = i(n).data("FancyBox");
                                if (s && s.currentHash) return (e = s), !1;
                            }),
                            e ?
                            e.currentHash === t.gallery + "-" + t.index ||
                            (1 === t.index && e.currentHash == t.gallery) ||
                            ((e.currentHash = null), e.close()) :
                            "" !== t.gallery && s(t);
                    }),
                    setTimeout(function() {
                        i.fancybox.getInstance() || s(n());
                    }, 50));
        });
})(window, document, jQuery),
(function(t, e) {
    "use strict";
    var i = new Date().getTime();
    e(t).on({
        "onInit.fb": function(t, e, n) {
            e.$refs.stage.on(
                "mousewheel DOMMouseScroll wheel MozMousePixelScroll",
                function(t) {
                    var n = e.current,
                        s = new Date().getTime();
                    e.group.length < 2 ||
                        !1 === n.opts.wheel ||
                        ("auto" === n.opts.wheel && "image" !== n.type) ||
                        (t.preventDefault(),
                            t.stopPropagation(),
                            n.$slide.hasClass("fancybox-animated") ||
                            ((t = t.originalEvent || t),
                                s - i < 250 ||
                                ((i = s),
                                    e[
                                        (-t.deltaY || -t.deltaX || t.wheelDelta || -t.detail) < 0 ?
                                        "next" :
                                        "previous"
                                    ]())));
                }
            );
        },
    });
})(document, jQuery),
(function() {
    "use strict";
    /**
     * @preserve FastClick: polyfill to remove click delays on browsers with touch UIs.
     *
     * @codingstandard ftlabs-jsv2
     * @copyright The Financial Times Limited [All Rights Reserved]
     * @license MIT License (see LICENSE.txt)
     */
    function t(e, n) {
        var s;
        if (
            ((n = n || {}),
                (this.trackingClick = !1),
                (this.trackingClickStart = 0),
                (this.targetElement = null),
                (this.touchStartX = 0),
                (this.touchStartY = 0),
                (this.lastTouchIdentifier = 0),
                (this.touchBoundary = n.touchBoundary || 10),
                (this.layer = e),
                (this.tapDelay = n.tapDelay || 200),
                (this.tapTimeout = n.tapTimeout || 700), !t.notNeeded(e))
        ) {
            for (
                var a = [
                        "onMouse",
                        "onClick",
                        "onTouchStart",
                        "onTouchMove",
                        "onTouchEnd",
                        "onTouchCancel",
                    ],
                    r = this,
                    o = 0,
                    l = a.length; o < l; o++
            )
                r[a[o]] = c(r[a[o]], r);
            i &&
                (e.addEventListener("mouseover", this.onMouse, !0),
                    e.addEventListener("mousedown", this.onMouse, !0),
                    e.addEventListener("mouseup", this.onMouse, !0)),
                e.addEventListener("click", this.onClick, !0),
                e.addEventListener("touchstart", this.onTouchStart, !1),
                e.addEventListener("touchmove", this.onTouchMove, !1),
                e.addEventListener("touchend", this.onTouchEnd, !1),
                e.addEventListener("touchcancel", this.onTouchCancel, !1),
                Event.prototype.stopImmediatePropagation ||
                ((e.removeEventListener = function(t, i, n) {
                        var s = Node.prototype.removeEventListener;
                        "click" === t
                            ?
                            s.call(e, t, i.hijacked || i, n) :
                            s.call(e, t, i, n);
                    }),
                    (e.addEventListener = function(t, i, n) {
                        var s = Node.prototype.addEventListener;
                        "click" === t
                            ?
                            s.call(
                                e,
                                t,
                                i.hijacked ||
                                (i.hijacked = function(t) {
                                    t.propagationStopped || i(t);
                                }),
                                n
                            ) :
                            s.call(e, t, i, n);
                    })),
                "function" == typeof e.onclick &&
                ((s = e.onclick),
                    e.addEventListener(
                        "click",
                        function(t) {
                            s(t);
                        }, !1
                    ),
                    (e.onclick = null));
        }

        function c(t, e) {
            return function() {
                return t.apply(e, arguments);
            };
        }
    }
    var e = navigator.userAgent.indexOf("Windows Phone") >= 0,
        i = navigator.userAgent.indexOf("Android") > 0 && !e,
        n = /iP(ad|hone|od)/.test(navigator.userAgent) && !e,
        s = n && /OS 4_\d(_\d)?/.test(navigator.userAgent),
        a = n && /OS [6-7]_\d/.test(navigator.userAgent),
        r = navigator.userAgent.indexOf("BB10") > 0;
    (t.prototype.needsClick = function(t) {
        switch (t.nodeName.toLowerCase()) {
            case "button":
            case "select":
            case "textarea":
                if (t.disabled) return !0;
                break;
            case "input":
                if ((n && "file" === t.type) || t.disabled) return !0;
                break;
            case "label":
            case "iframe":
            case "video":
                return !0;
        }
        return /\bneedsclick\b/.test(t.className);
    }),
    (t.prototype.needsFocus = function(t) {
        switch (t.nodeName.toLowerCase()) {
            case "textarea":
                return !0;
            case "select":
                return !i;
            case "input":
                switch (t.type) {
                    case "button":
                    case "checkbox":
                    case "file":
                    case "image":
                    case "radio":
                    case "submit":
                        return !1;
                }
                return !t.disabled && !t.readOnly;
            default:
                return /\bneedsfocus\b/.test(t.className);
        }
    }),
    (t.prototype.sendClick = function(t, e) {
        var i, n;
        document.activeElement &&
            document.activeElement !== t &&
            document.activeElement.blur(),
            (n = e.changedTouches[0]),
            (i = document.createEvent("MouseEvents")).initMouseEvent(
                this.determineEventType(t), !0, !0,
                window,
                1,
                n.screenX,
                n.screenY,
                n.clientX,
                n.clientY, !1, !1, !1, !1,
                0,
                null
            ),
            (i.forwardedTouchEvent = !0),
            t.dispatchEvent(i);
    }),
    (t.prototype.determineEventType = function(t) {
        return i && "select" === t.tagName.toLowerCase() ?
            "mousedown" :
            "click";
    }),
    (t.prototype.focus = function(t) {
        var e;
        n &&
            t.setSelectionRange &&
            0 !== t.type.indexOf("date") &&
            "time" !== t.type &&
            "month" !== t.type &&
            "email" !== t.type ?
            ((e = t.value.length), t.setSelectionRange(e, e)) :
            t.focus();
    }),
    (t.prototype.updateScrollParent = function(t) {
        var e, i;
        if (!(e = t.fastClickScrollParent) || !e.contains(t)) {
            i = t;
            do {
                if (i.scrollHeight > i.offsetHeight) {
                    (e = i), (t.fastClickScrollParent = i);
                    break;
                }
                i = i.parentElement;
            } while (i);
        }
        e && (e.fastClickLastScrollTop = e.scrollTop);
    }),
    (t.prototype.getTargetElementFromEventTarget = function(t) {
        return t.nodeType === Node.TEXT_NODE ? t.parentNode : t;
    }),
    (t.prototype.onTouchStart = function(t) {
        var e, i, a;
        if (t.targetTouches.length > 1) return !0;
        if (
            ((e = this.getTargetElementFromEventTarget(t.target)),
                (i = t.targetTouches[0]),
                n)
        ) {
            if ((a = window.getSelection()).rangeCount && !a.isCollapsed)
                return !0;
            if (!s) {
                if (i.identifier && i.identifier === this.lastTouchIdentifier)
                    return t.preventDefault(), !1;
                (this.lastTouchIdentifier = i.identifier),
                this.updateScrollParent(e);
            }
        }
        return (
            (this.trackingClick = !0),
            (this.trackingClickStart = t.timeStamp),
            (this.targetElement = e),
            (this.touchStartX = i.pageX),
            (this.touchStartY = i.pageY),
            t.timeStamp - this.lastClickTime < this.tapDelay &&
            t.preventDefault(), !0
        );
    }),
    (t.prototype.touchHasMoved = function(t) {
        var e = t.changedTouches[0],
            i = this.touchBoundary;
        return (
            Math.abs(e.pageX - this.touchStartX) > i ||
            Math.abs(e.pageY - this.touchStartY) > i
        );
    }),
    (t.prototype.onTouchMove = function(t) {
        return (!this.trackingClick ||
            ((this.targetElement !==
                    this.getTargetElementFromEventTarget(t.target) ||
                    this.touchHasMoved(t)) &&
                ((this.trackingClick = !1), (this.targetElement = null)), !0)
        );
    }),
    (t.prototype.findControl = function(t) {
        return void 0 !== t.control ?
            t.control :
            t.htmlFor ?
            document.getElementById(t.htmlFor) :
            t.querySelector(
                "button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea"
            );
    }),
    (t.prototype.onTouchEnd = function(t) {
        var e,
            r,
            o,
            l,
            c,
            d = this.targetElement;
        if (!this.trackingClick) return !0;
        if (t.timeStamp - this.lastClickTime < this.tapDelay)
            return (this.cancelNextClick = !0), !0;
        if (t.timeStamp - this.trackingClickStart > this.tapTimeout) return !0;
        if (
            ((this.cancelNextClick = !1),
                (this.lastClickTime = t.timeStamp),
                (r = this.trackingClickStart),
                (this.trackingClick = !1),
                (this.trackingClickStart = 0),
                a &&
                ((c = t.changedTouches[0]),
                    ((d =
                            document.elementFromPoint(
                                c.pageX - window.pageXOffset,
                                c.pageY - window.pageYOffset
                            ) || d).fastClickScrollParent =
                        this.targetElement.fastClickScrollParent)),
                "label" === (o = d.tagName.toLowerCase()))
        ) {
            if ((e = this.findControl(d))) {
                if ((this.focus(d), i)) return !1;
                d = e;
            }
        } else if (this.needsFocus(d))
            return t.timeStamp - r > 100 ||
                (n && window.top !== window && "input" === o) ?
                ((this.targetElement = null), !1) :
                (this.focus(d),
                    this.sendClick(d, t),
                    (n && "select" === o) ||
                    ((this.targetElement = null), t.preventDefault()), !1);
        return (!(!n ||
                s ||
                !(l = d.fastClickScrollParent) ||
                l.fastClickLastScrollTop === l.scrollTop
            ) ||
            (this.needsClick(d) || (t.preventDefault(), this.sendClick(d, t)), !1)
        );
    }),
    (t.prototype.onTouchCancel = function() {
        (this.trackingClick = !1), (this.targetElement = null);
    }),
    (t.prototype.onMouse = function(t) {
        return (!this.targetElement ||
            !!t.forwardedTouchEvent ||
            !t.cancelable ||
            !(!this.needsClick(this.targetElement) || this.cancelNextClick) ||
            (t.stopImmediatePropagation ?
                t.stopImmediatePropagation() :
                (t.propagationStopped = !0),
                t.stopPropagation(),
                t.preventDefault(), !1)
        );
    }),
    (t.prototype.onClick = function(t) {
        var e;
        return this.trackingClick ?
            ((this.targetElement = null), (this.trackingClick = !1), !0) :
            ("submit" === t.target.type && 0 === t.detail) ||
            ((e = this.onMouse(t)) || (this.targetElement = null), e);
    }),
    (t.prototype.destroy = function() {
        var t = this.layer;
        i &&
            (t.removeEventListener("mouseover", this.onMouse, !0),
                t.removeEventListener("mousedown", this.onMouse, !0),
                t.removeEventListener("mouseup", this.onMouse, !0)),
            t.removeEventListener("click", this.onClick, !0),
            t.removeEventListener("touchstart", this.onTouchStart, !1),
            t.removeEventListener("touchmove", this.onTouchMove, !1),
            t.removeEventListener("touchend", this.onTouchEnd, !1),
            t.removeEventListener("touchcancel", this.onTouchCancel, !1);
    }),
    (t.notNeeded = function(t) {
        var e, n, s;
        if (void 0 === window.ontouchstart) return !0;
        if ((n = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1])) {
            if (!i) return !0;
            if ((e = document.querySelector("meta[name=viewport]"))) {
                if (-1 !== e.content.indexOf("user-scalable=no")) return !0;
                if (
                    n > 31 &&
                    document.documentElement.scrollWidth <= window.outerWidth
                )
                    return !0;
            }
        }
        if (
            r &&
            (s = navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/))[1] >=
            10 &&
            s[2] >= 3 &&
            (e = document.querySelector("meta[name=viewport]"))
        ) {
            if (-1 !== e.content.indexOf("user-scalable=no")) return !0;
            if (document.documentElement.scrollWidth <= window.outerWidth)
                return !0;
        }
        return (
            "none" === t.style.msTouchAction ||
            "manipulation" === t.style.touchAction ||
            !!(+(/Firefox\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1] >=
                27 &&
                (e = document.querySelector("meta[name=viewport]")) &&
                (-1 !== e.content.indexOf("user-scalable=no") ||
                    document.documentElement.scrollWidth <= window.outerWidth)
            ) ||
            "none" === t.style.touchAction ||
            "manipulation" === t.style.touchAction
        );
    }),
    (t.attach = function(e, i) {
        return new t(e, i);
    }),
    "function" == typeof define && "object" == typeof define.amd && define.amd ?
        define(function() {
            return t;
        }) :
        "undefined" != typeof module && module.exports ?
        ((module.exports = t.attach), (module.exports.FastClick = t)) :
        (window.FastClick = t);
})(),
(function(t) {
    var e = {};

    function i(n) {
        if (e[n]) return e[n].exports;
        var s = (e[n] = {
            i: n,
            l: !1,
            exports: {},
        });
        return t[n].call(s.exports, s, s.exports, i), (s.l = !0), s.exports;
    }
    (i.m = t),
    (i.c = e),
    (i.d = function(t, e, n) {
        i.o(t, e) ||
            Object.defineProperty(t, e, {
                enumerable: !0,
                get: n,
            });
    }),
    (i.r = function(t) {
        "undefined" != typeof Symbol &&
            Symbol.toStringTag &&
            Object.defineProperty(t, Symbol.toStringTag, {
                value: "Module",
            }),
            Object.defineProperty(t, "__esModule", {
                value: !0,
            });
    }),
    (i.t = function(t, e) {
        if ((1 & e && (t = i(t)), 8 & e)) return t;
        if (4 & e && "object" == typeof t && t && t.__esModule) return t;
        var n = Object.create(null);
        if (
            (i.r(n),
                Object.defineProperty(n, "default", {
                    enumerable: !0,
                    value: t,
                }),
                2 & e && "string" != typeof t)
        )
            for (var s in t)
                i.d(
                    n,
                    s,
                    function(e) {
                        return t[e];
                    }.bind(null, s)
                );
        return n;
    }),
    (i.n = function(t) {
        var e =
            t && t.__esModule ?

            function() {
                return t.default;
            } :
            function() {
                return t;
            };
        return i.d(e, "a", e), e;
    }),
    (i.o = function(t, e) {
        return Object.prototype.hasOwnProperty.call(t, e);
    }),
    (i.p = ""),
    i((i.s = 10));
})([, ,
    function(t, e) {
        t.exports = function(t) {
            "complete" === document.readyState ||
                "interactive" === document.readyState ?
                t.call() :
                document.attachEvent ?
                document.attachEvent("onreadystatechange", function() {
                    "interactive" === document.readyState && t.call();
                }) :
                document.addEventListener &&
                document.addEventListener("DOMContentLoaded", t);
        };
    },
    function(t, e, i) {
        (function(e) {
            var i =
                "undefined" != typeof window ?
                window :
                void 0 !== e ?
                e :
                "undefined" != typeof self ?
                self : {};
            t.exports = i;
        }.call(this, i(4)));
    },
    function(t, e) {
        function i(t) {
            return (i =
                "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ?

                function(t) {
                    return typeof t;
                } :
                function(t) {
                    return t &&
                        "function" == typeof Symbol &&
                        t.constructor === Symbol &&
                        t !== Symbol.prototype ?
                        "symbol" :
                        typeof t;
                })(t);
        }
        var n = (function() {
            return this;
        })();
        try {
            n = n || new Function("return this")();
        } catch (t) {
            "object" === ("undefined" == typeof window ? "undefined" : i(window)) &&
            (n = window);
        }
        t.exports = n;
    }, , , , , ,
    function(t, e, i) {
        t.exports = i(11);
    },
    function(t, e, i) {
        "use strict";
        i.r(e);
        var n = i(2),
            s = i.n(n),
            a = i(3),
            r = i(12);

        function o(t) {
            return (o =
                "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ?

                function(t) {
                    return typeof t;
                } :
                function(t) {
                    return t &&
                        "function" == typeof Symbol &&
                        t.constructor === Symbol &&
                        t !== Symbol.prototype ?
                        "symbol" :
                        typeof t;
                })(t);
        }
        var l,
            c,
            d = a.window.jarallax;
        (a.window.jarallax = r.default),
        (a.window.jarallax.noConflict = function() {
            return (a.window.jarallax = d), this;
        }),
        void 0 !== a.jQuery &&
            (((l = function() {
                    for (var t = arguments.length, e = new Array(t), i = 0; i < t; i++)
                        e[i] = arguments[i];
                    Array.prototype.unshift.call(e, this);
                    var n = r.default.apply(a.window, e);
                    return "object" !== o(n) ? n : this;
                }).constructor = r.default.constructor),
                (c = a.jQuery.fn.jarallax),
                (a.jQuery.fn.jarallax = l),
                (a.jQuery.fn.jarallax.noConflict = function() {
                    return (a.jQuery.fn.jarallax = c), this;
                })),
            s()(function() {
                Object(r.default)(document.querySelectorAll("[data-jarallax]"));
            });
    },
    function(t, e, i) {
        "use strict";
        i.r(e);
        var n = i(2),
            s = i.n(n),
            a = i(3);

        function r(t, e) {
            return (
                (function(t) {
                    if (Array.isArray(t)) return t;
                })(t) ||
                (function(t, e) {
                    if ("undefined" != typeof Symbol && Symbol.iterator in Object(t)) {
                        var i = [],
                            n = !0,
                            s = !1,
                            a = void 0;
                        try {
                            for (
                                var r, o = t[Symbol.iterator](); !(n = (r = o.next()).done) &&
                                (i.push(r.value), !e || i.length !== e); n = !0
                            );
                        } catch (t) {
                            (s = !0), (a = t);
                        } finally {
                            try {
                                n || null == o.return || o.return();
                            } finally {
                                if (s) throw a;
                            }
                        }
                        return i;
                    }
                })(t, e) ||
                (function(t, e) {
                    if (t) {
                        if ("string" == typeof t) return o(t, e);
                        var i = Object.prototype.toString.call(t).slice(8, -1);
                        return (
                            "Object" === i && t.constructor && (i = t.constructor.name),
                            "Map" === i || "Set" === i ?
                            Array.from(t) :
                            "Arguments" === i ||
                            /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i) ?
                            o(t, e) :
                            void 0
                        );
                    }
                })(t, e) ||
                (function() {
                    throw new TypeError(
                        "Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."
                    );
                })()
            );
        }

        function o(t, e) {
            (null == e || e > t.length) && (e = t.length);
            for (var i = 0, n = new Array(e); i < e; i++) n[i] = t[i];
            return n;
        }

        function l(t) {
            return (l =
                "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ?

                function(t) {
                    return typeof t;
                } :
                function(t) {
                    return t &&
                        "function" == typeof Symbol &&
                        t.constructor === Symbol &&
                        t !== Symbol.prototype ?
                        "symbol" :
                        typeof t;
                })(t);
        }

        function c(t, e) {
            for (var i = 0; i < e.length; i++) {
                var n = e[i];
                (n.enumerable = n.enumerable || !1),
                (n.configurable = !0),
                "value" in n && (n.writable = !0),
                    Object.defineProperty(t, n.key, n);
            }
        }
        var d,
            u,
            h = a.window.navigator,
            p = -1 < h.userAgent.indexOf("MSIE ") ||
            -1 < h.userAgent.indexOf("Trident/") ||
            -1 < h.userAgent.indexOf("Edge/"),
            f =
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                h.userAgent
            ),
            m = (function() {
                for (
                    var t = "transform WebkitTransform MozTransform".split(" "),
                        e = document.createElement("div"),
                        i = 0; i < t.length; i += 1
                )
                    if (e && void 0 !== e.style[t[i]]) return t[i];
                return !1;
            })();

        function v() {
            u = f ?
                (!d &&
                    document.body &&
                    (((d = document.createElement("div")).style.cssText =
                            "position: fixed; top: -9999px; left: 0; height: 100vh; width: 0;"),
                        document.body.appendChild(d)),
                    (d ? d.clientHeight : 0) ||
                    a.window.innerHeight ||
                    document.documentElement.clientHeight) :
                a.window.innerHeight || document.documentElement.clientHeight;
        }
        v(),
            a.window.addEventListener("resize", v),
            a.window.addEventListener("orientationchange", v),
            a.window.addEventListener("load", v),
            s()(function() {
                v();
            });
        var g = [];

        function y() {
            g.length &&
                (g.forEach(function(t, e) {
                        var i = t.instance,
                            n = t.oldData,
                            s = i.$item.getBoundingClientRect(),
                            r = {
                                width: s.width,
                                height: s.height,
                                top: s.top,
                                bottom: s.bottom,
                                wndW: a.window.innerWidth,
                                wndH: u,
                            },
                            o = !n ||
                            n.wndW !== r.wndW ||
                            n.wndH !== r.wndH ||
                            n.width !== r.width ||
                            n.height !== r.height,
                            l = o || !n || n.top !== r.top || n.bottom !== r.bottom;
                        (g[e].oldData = r), o && i.onResize(), l && i.onScroll();
                    }),
                    a.window.requestAnimationFrame(y));
        }

        function b(t, e) {
            ("object" ===
                ("undefined" == typeof HTMLElement ? "undefined" : l(HTMLElement)) ?
                t instanceof HTMLElement :
                t &&
                "object" === l(t) &&
                null !== t &&
                1 === t.nodeType &&
                "string" == typeof t.nodeName) && (t = [t]);
            for (
                var i,
                    n = t.length,
                    s = 0,
                    a = arguments.length,
                    r = new Array(2 < a ? a - 2 : 0),
                    o = 2; o < a; o++
            )
                r[o - 2] = arguments[o];
            for (; s < n; s += 1)
                if (
                    ("object" === l(e) || void 0 === e ?
                        t[s].jarallax || (t[s].jarallax = new x(t[s], e)) :
                        t[s].jarallax && (i = t[s].jarallax[e].apply(t[s].jarallax, r)),
                        void 0 !== i)
                )
                    return i;
            return t;
        }
        var w = 0,
            x = (function() {
                function t(e, i) {
                    !(function(t, e) {
                        if (!(t instanceof e))
                            throw new TypeError("Cannot call a class as a function");
                    })(this, t);
                    var n = this;
                    (n.instanceID = w),
                    (w += 1),
                    (n.$item = e),
                    (n.defaults = {
                        type: "scroll",
                        speed: 0.5,
                        imgSrc: null,
                        imgElement: ".jarallax-img",
                        imgSize: "cover",
                        imgPosition: "50% 50%",
                        imgRepeat: "no-repeat",
                        keepImg: !1,
                        elementInViewport: null,
                        zIndex: -100,
                        disableParallax: !1,
                        disableVideo: !1,
                        videoSrc: null,
                        videoStartTime: 0,
                        videoEndTime: 0,
                        videoVolume: 0,
                        videoLoop: !0,
                        videoPlayOnlyVisible: !0,
                        videoLazyLoading: !0,
                        onScroll: null,
                        onInit: null,
                        onDestroy: null,
                        onCoverImage: null,
                    });
                    var s,
                        a,
                        o = n.$item.dataset || {},
                        c = {};
                    Object.keys(o).forEach(function(t) {
                            var e = t.substr(0, 1).toLowerCase() + t.substr(1);
                            e && void 0 !== n.defaults[e] && (c[e] = o[t]);
                        }),
                        (n.options = n.extend({}, n.defaults, c, i)),
                        (n.pureOptions = n.extend({}, n.options)),
                        Object.keys(n.options).forEach(function(t) {
                            "true" === n.options[t] ?
                                (n.options[t] = !0) :
                                "false" === n.options[t] && (n.options[t] = !1);
                        }),
                        (n.options.speed = Math.min(
                            2,
                            Math.max(-1, parseFloat(n.options.speed))
                        )),
                        "string" == typeof n.options.disableParallax &&
                        (n.options.disableParallax = new RegExp(
                            n.options.disableParallax
                        )),
                        n.options.disableParallax instanceof RegExp &&
                        ((s = n.options.disableParallax),
                            (n.options.disableParallax = function() {
                                return s.test(h.userAgent);
                            })),
                        "function" != typeof n.options.disableParallax &&
                        (n.options.disableParallax = function() {
                            return !1;
                        }),
                        "string" == typeof n.options.disableVideo &&
                        (n.options.disableVideo = new RegExp(n.options.disableVideo)),
                        n.options.disableVideo instanceof RegExp &&
                        ((a = n.options.disableVideo),
                            (n.options.disableVideo = function() {
                                return a.test(h.userAgent);
                            })),
                        "function" != typeof n.options.disableVideo &&
                        (n.options.disableVideo = function() {
                            return !1;
                        });
                    var d = n.options.elementInViewport;
                    d && "object" === l(d) && void 0 !== d.length && (d = r(d, 1)[0]),
                        d instanceof Element || (d = null),
                        (n.options.elementInViewport = d),
                        (n.image = {
                            src: n.options.imgSrc || null,
                            $container: null,
                            useImgTag: !1,
                            position: /iPad|iPhone|iPod|Android/.test(h.userAgent) ?
                                "absolute" : "fixed",
                        }),
                        n.initImg() && n.canInitParallax() && n.init();
                }
                var e, i;
                return (
                    (e = t),
                    (i = [{
                            key: "css",
                            value: function(t, e) {
                                return "string" == typeof e ?
                                    a.window.getComputedStyle(t).getPropertyValue(e) :
                                    (e.transform && m && (e[m] = e.transform),
                                        Object.keys(e).forEach(function(i) {
                                            t.style[i] = e[i];
                                        }),
                                        t);
                            },
                        },
                        {
                            key: "extend",
                            value: function(t) {
                                for (
                                    var e = arguments.length,
                                        i = new Array(1 < e ? e - 1 : 0),
                                        n = 1; n < e; n++
                                )
                                    i[n - 1] = arguments[n];
                                return (
                                    (t = t || {}),
                                    Object.keys(i).forEach(function(e) {
                                        i[e] &&
                                            Object.keys(i[e]).forEach(function(n) {
                                                t[n] = i[e][n];
                                            });
                                    }),
                                    t
                                );
                            },
                        },
                        {
                            key: "getWindowData",
                            value: function() {
                                return {
                                    width: a.window.innerWidth ||
                                        document.documentElement.clientWidth,
                                    height: u,
                                    y: document.documentElement.scrollTop,
                                };
                            },
                        },
                        {
                            key: "initImg",
                            value: function() {
                                var t = this,
                                    e = t.options.imgElement;
                                return (
                                    e && "string" == typeof e && (e = t.$item.querySelector(e)),
                                    e instanceof Element ||
                                    (t.options.imgSrc ?
                                        ((e = new Image()).src = t.options.imgSrc) :
                                        (e = null)),
                                    e &&
                                    (t.options.keepImg ?
                                        (t.image.$item = e.cloneNode(!0)) :
                                        ((t.image.$item = e),
                                            (t.image.$itemParent = e.parentNode)),
                                        (t.image.useImgTag = !0)), !(!t.image.$item &&
                                        (null === t.image.src &&
                                            ((t.image.src =
                                                    "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"),
                                                (t.image.bgImage = t.css(t.$item, "background-image"))), !t.image.bgImage || "none" === t.image.bgImage)
                                    )
                                );
                            },
                        },
                        {
                            key: "canInitParallax",
                            value: function() {
                                return m && !this.options.disableParallax();
                            },
                        },
                        {
                            key: "init",
                            value: function() {
                                var t,
                                    e,
                                    i,
                                    n = this,
                                    s = {
                                        position: "absolute",
                                        top: 0,
                                        left: 0,
                                        width: "100%",
                                        height: "100%",
                                        overflow: "hidden",
                                    },
                                    r = {
                                        pointerEvents: "none",
                                        transformStyle: "preserve-3d",
                                        backfaceVisibility: "hidden",
                                        willChange: "transform,opacity",
                                    };
                                n.options.keepImg ||
                                    ((t = n.$item.getAttribute("style")) &&
                                        n.$item.setAttribute("data-jarallax-original-styles", t), !n.image.useImgTag ||
                                        ((e = n.image.$item.getAttribute("style")) &&
                                            n.image.$item.setAttribute(
                                                "data-jarallax-original-styles",
                                                e
                                            ))),
                                    "static" === n.css(n.$item, "position") &&
                                    n.css(n.$item, {
                                        position: "relative",
                                    }),
                                    "auto" === n.css(n.$item, "z-index") &&
                                    n.css(n.$item, {
                                        zIndex: 0,
                                    }),
                                    (n.image.$container = document.createElement("div")),
                                    n.css(n.image.$container, s),
                                    n.css(n.image.$container, {
                                        "z-index": n.options.zIndex,
                                    }),
                                    p &&
                                    n.css(n.image.$container, {
                                        opacity: 0.9999,
                                    }),
                                    n.image.$container.setAttribute(
                                        "id",
                                        "jarallax-container-".concat(n.instanceID)
                                    ),
                                    n.$item.appendChild(n.image.$container),
                                    n.image.useImgTag ?
                                    (r = n.extend({
                                            "object-fit": n.options.imgSize,
                                            "object-position": n.options.imgPosition,
                                            "font-family": "object-fit: "
                                                .concat(n.options.imgSize, "; object-position: ")
                                                .concat(n.options.imgPosition, ";"),
                                            "max-width": "none",
                                        },
                                        s,
                                        r
                                    )) :
                                    ((n.image.$item = document.createElement("div")),
                                        n.image.src &&
                                        (r = n.extend({
                                                "background-position": n.options.imgPosition,
                                                "background-size": n.options.imgSize,
                                                "background-repeat": n.options.imgRepeat,
                                                "background-image": n.image.bgImage ||
                                                    'url("'.concat(n.image.src, '")'),
                                            },
                                            s,
                                            r
                                        ))),
                                    ("opacity" !== n.options.type &&
                                        "scale" !== n.options.type &&
                                        "scale-opacity" !== n.options.type &&
                                        1 !== n.options.speed) ||
                                    (n.image.position = "absolute"),
                                    "fixed" === n.image.position &&
                                    ((i = (function(t) {
                                            for (var e = []; null !== t.parentElement;)
                                                1 === (t = t.parentElement).nodeType && e.push(t);
                                            return e;
                                        })(n.$item).filter(function(t) {
                                            var e = a.window.getComputedStyle(t),
                                                i =
                                                e["-webkit-transform"] ||
                                                e["-moz-transform"] ||
                                                e.transform;
                                            return (
                                                (i && "none" !== i) ||
                                                /(auto|scroll)/.test(
                                                    e.overflow + e["overflow-y"] + e["overflow-x"]
                                                )
                                            );
                                        })),
                                        (n.image.position = i.length ? "absolute" : "fixed")),
                                    (r.position = n.image.position),
                                    n.css(n.image.$item, r),
                                    n.image.$container.appendChild(n.image.$item),
                                    n.onResize(),
                                    n.onScroll(!0),
                                    n.options.onInit && n.options.onInit.call(n),
                                    "none" !== n.css(n.$item, "background-image") &&
                                    n.css(n.$item, {
                                        "background-image": "none",
                                    }),
                                    n.addToParallaxList();
                            },
                        },
                        {
                            key: "addToParallaxList",
                            value: function() {
                                g.push({
                                        instance: this,
                                    }),
                                    1 === g.length && a.window.requestAnimationFrame(y);
                            },
                        },
                        {
                            key: "removeFromParallaxList",
                            value: function() {
                                var t = this;
                                g.forEach(function(e, i) {
                                    e.instance.instanceID === t.instanceID && g.splice(i, 1);
                                });
                            },
                        },
                        {
                            key: "destroy",
                            value: function() {
                                var t = this;
                                t.removeFromParallaxList();
                                var e,
                                    i = t.$item.getAttribute("data-jarallax-original-styles");
                                t.$item.removeAttribute("data-jarallax-original-styles"),
                                    i ?
                                    t.$item.setAttribute("style", i) :
                                    t.$item.removeAttribute("style"),
                                    t.image.useImgTag &&
                                    ((e = t.image.$item.getAttribute(
                                            "data-jarallax-original-styles"
                                        )),
                                        t.image.$item.removeAttribute(
                                            "data-jarallax-original-styles"
                                        ),
                                        e ?
                                        t.image.$item.setAttribute("style", i) :
                                        t.image.$item.removeAttribute("style"),
                                        t.image.$itemParent &&
                                        t.image.$itemParent.appendChild(t.image.$item)),
                                    t.$clipStyles &&
                                    t.$clipStyles.parentNode.removeChild(t.$clipStyles),
                                    t.image.$container &&
                                    t.image.$container.parentNode.removeChild(
                                        t.image.$container
                                    ),
                                    t.options.onDestroy && t.options.onDestroy.call(t),
                                    delete t.$item.jarallax;
                            },
                        },
                        {
                            key: "clipContainer",
                            value: function() {
                                var t, e, i, n, s;
                                "fixed" === this.image.position &&
                                    ((i = (e = (t =
                                            this).image.$container.getBoundingClientRect()).width),
                                        (n = e.height),
                                        t.$clipStyles ||
                                        ((t.$clipStyles = document.createElement("style")),
                                            t.$clipStyles.setAttribute("type", "text/css"),
                                            t.$clipStyles.setAttribute(
                                                "id",
                                                "jarallax-clip-".concat(t.instanceID)
                                            ),
                                            (
                                                document.head ||
                                                document.getElementsByTagName("head")[0]
                                            ).appendChild(t.$clipStyles)),
                                        (s = "#jarallax-container-"
                                            .concat(t.instanceID, " {\n            clip: rect(0 ")
                                            .concat(i, "px ")
                                            .concat(n, "px 0);\n            clip: rect(0, ")
                                            .concat(i, "px, ")
                                            .concat(
                                                n,
                                                "px, 0);\n            -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);\n            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);\n        }"
                                            )),
                                        t.$clipStyles.styleSheet ?
                                        (t.$clipStyles.styleSheet.cssText = s) :
                                        (t.$clipStyles.innerHTML = s));
                            },
                        },
                        {
                            key: "coverImage",
                            value: function() {
                                var t,
                                    e = this,
                                    i = e.image.$container.getBoundingClientRect(),
                                    n = i.height,
                                    s = e.options.speed,
                                    a =
                                    "scroll" === e.options.type ||
                                    "scroll-opacity" === e.options.type,
                                    r = 0,
                                    o = n;
                                return (
                                    a &&
                                    (s < 0 ?
                                        ((r = s * Math.max(n, u)),
                                            u < n && (r -= s * (n - u))) :
                                        (r = s * (n + u)),
                                        1 < s ?
                                        (o = Math.abs(r - u)) :
                                        s < 0 ?
                                        (o = r / s + Math.abs(r)) :
                                        (o += (u - n) * (1 - s)),
                                        (r /= 2)),
                                    (e.parallaxScrollDistance = r),
                                    (t = a ? (u - o) / 2 : (n - o) / 2),
                                    e.css(e.image.$item, {
                                        height: "".concat(o, "px"),
                                        marginTop: "".concat(t, "px"),
                                        left: "fixed" === e.image.position ?
                                            "".concat(i.left, "px") : "0",
                                        width: "".concat(i.width, "px"),
                                    }),
                                    e.options.onCoverImage && e.options.onCoverImage.call(e), {
                                        image: {
                                            height: o,
                                            marginTop: t,
                                        },
                                        container: i,
                                    }
                                );
                            },
                        },
                        {
                            key: "isVisible",
                            value: function() {
                                return this.isElementInViewport || !1;
                            },
                        },
                        {
                            key: "onScroll",
                            value: function(t) {
                                var e,
                                    i,
                                    n,
                                    s,
                                    r,
                                    o,
                                    l,
                                    c,
                                    d,
                                    h,
                                    p = this,
                                    f = p.$item.getBoundingClientRect(),
                                    m = f.top,
                                    v = f.height,
                                    g = {},
                                    y = f;
                                p.options.elementInViewport &&
                                    (y = p.options.elementInViewport.getBoundingClientRect()),
                                    (p.isElementInViewport =
                                        0 <= y.bottom &&
                                        0 <= y.right &&
                                        y.top <= u &&
                                        y.left <= a.window.innerWidth),
                                    (t || p.isElementInViewport) &&
                                    ((e = Math.max(0, m)),
                                        (i = Math.max(0, v + m)),
                                        (n = Math.max(0, -m)),
                                        (s = Math.max(0, m + v - u)),
                                        (r = Math.max(0, v - (m + v - u))),
                                        (o = Math.max(0, -m + u - v)),
                                        (l = 1 - ((u - m) / (u + v)) * 2),
                                        (c = 1),
                                        v < u ?
                                        (c = 1 - (n || s) / v) :
                                        i <= u ?
                                        (c = i / u) :
                                        r <= u && (c = r / u),
                                        ("opacity" !== p.options.type &&
                                            "scale-opacity" !== p.options.type &&
                                            "scroll-opacity" !== p.options.type) ||
                                        ((g.transform = "translate3d(0,0,0)"), (g.opacity = c)),
                                        ("scale" !== p.options.type &&
                                            "scale-opacity" !== p.options.type) ||
                                        ((d = 1),
                                            p.options.speed < 0 ?
                                            (d -= p.options.speed * c) :
                                            (d += p.options.speed * (1 - c)),
                                            (g.transform = "scale(".concat(
                                                d,
                                                ") translate3d(0,0,0)"
                                            ))),
                                        ("scroll" !== p.options.type &&
                                            "scroll-opacity" !== p.options.type) ||
                                        ((h = p.parallaxScrollDistance * l),
                                            "absolute" === p.image.position && (h -= m),
                                            (g.transform = "translate3d(0,".concat(h, "px,0)"))),
                                        p.css(p.image.$item, g),
                                        p.options.onScroll &&
                                        p.options.onScroll.call(p, {
                                            section: f,
                                            beforeTop: e,
                                            beforeTopEnd: i,
                                            afterTop: n,
                                            beforeBottom: s,
                                            beforeBottomEnd: r,
                                            afterBottom: o,
                                            visiblePercent: c,
                                            fromViewportCenter: l,
                                        }));
                            },
                        },
                        {
                            key: "onResize",
                            value: function() {
                                this.coverImage(), this.clipContainer();
                            },
                        },
                    ]) && c(e.prototype, i),
                    t
                );
            })();
        (b.constructor = x), (e.default = b);
    },
])