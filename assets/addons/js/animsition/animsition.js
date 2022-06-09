/*!
 * animsition v4.0.2
 * A simple and easy jQuery plugin for CSS animated page transitions.
 * http://blivesta.github.io/animsition
 * License : MIT
 * Author : blivesta (http://blivesta.com/)
 */
! function(t) { "use strict"; "function" == typeof define && define.amd ? define(["jquery"], t) : "object" == typeof exports ? module.exports = t(require("jquery")) : t(jQuery) }((function(t) {
    "use strict";
    var e = "animsition",
        i = {
            init: function(n) {
                n = t.extend({ inClass: "fade-in", outClass: "fade-out", inDuration: 1500, outDuration: 800, linkElement: ".animsition-link", loading: !0, loadingParentElement: "body", loadingClass: "animsition-loading", loadingInner: "", timeout: !1, timeoutCountdown: 5e3, onLoadEvent: !0, browser: ["animation-duration", "-webkit-animation-duration"], overlay: !1, overlayClass: "animsition-overlay-slide", overlayParentElement: "body", transition: function(t) { window.location.href = t } }, n), i.settings = { timer: !1, data: { inClass: "animsition-in-class", inDuration: "animsition-in-duration", outClass: "animsition-out-class", outDuration: "animsition-out-duration", overlay: "animsition-overlay" }, events: { inStart: "animsition.inStart", inEnd: "animsition.inEnd", outStart: "animsition.outStart", outEnd: "animsition.outEnd" } };
                var s = i.supportCheck.call(this, n);
                return s || !(n.browser.length > 0) || s && this.length ? (i.optionCheck.call(this, n) && t("." + n.overlayClass).length <= 0 && i.addOverlay.call(this, n), n.loading && t("." + n.loadingClass).length <= 0 && i.addLoading.call(this, n), this.each((function() {
                    var s = this,
                        a = t(this),
                        r = t(window),
                        o = t(document);
                    a.data(e) || (n = t.extend({}, n), a.data(e, { options: n }), n.timeout && i.addTimer.call(s), n.onLoadEvent && r.on("load." + e, (function() { i.settings.timer && clearTimeout(i.settings.timer), i.in.call(s) })), r.on("pageshow." + e, (function(t) { t.originalEvent.persisted && i.in.call(s) })), r.on("unload." + e, (function() {})), o.on("click." + e, n.linkElement, (function(e) {
                        e.preventDefault();
                        var n = t(this),
                            a = n.attr("href");
                        2 === e.which || e.metaKey || e.shiftKey || -1 !== navigator.platform.toUpperCase().indexOf("WIN") && e.ctrlKey ? window.open(a, "_blank") : i.out.call(s, n, a)
                    })))
                }))) : ("console" in window || (window.console = {}, window.console.log = function(t) { return t }), this.length || console.log("Animsition: Element does not exist on page."), s || console.log("Animsition: Does not support this browser."), i.destroy.call(this))
            },
            addOverlay: function(e) { t(e.overlayParentElement).prepend('<div class="' + e.overlayClass + '"></div>') },
            addLoading: function(e) { t(e.loadingParentElement).append('<div class="' + e.loadingClass + '">' + e.loadingInner + "</div>") },
            removeLoading: function() {
                var i = t(this).data(e).options;
                t(i.loadingParentElement).children("." + i.loadingClass).fadeOut().remove()
            },
            addTimer: function() {
                var n = this,
                    s = t(this).data(e).options;
                i.settings.timer = setTimeout((function() { i.in.call(n), t(window).off("load." + e) }), s.timeoutCountdown)
            },
            supportCheck: function(e) {
                var i = t(this),
                    n = e.browser,
                    s = n.length,
                    a = !1;
                0 === s && (a = !0);
                for (var r = 0; s > r; r++)
                    if ("string" == typeof i.css(n[r])) { a = !0; break }
                return a
            },
            optionCheck: function(e) { var n = t(this); return !(!e.overlay && !n.data(i.settings.data.overlay)) },
            animationCheck: function(i, n, s) {
                var a = t(this).data(e).options,
                    r = typeof i,
                    o = !n && "number" === r,
                    l = n && "string" === r && i.length > 0;
                return o || l ? i = i : n && s ? i = a.inClass : !n && s ? i = a.inDuration : n && !s ? i = a.outClass : n || s || (i = a.outDuration), i
            },
            in: function() {
                var n = this,
                    s = t(this),
                    a = s.data(e).options,
                    r = s.data(i.settings.data.inDuration),
                    o = s.data(i.settings.data.inClass),
                    l = i.animationCheck.call(n, r, !1, !0),
                    c = i.animationCheck.call(n, o, !0, !0),
                    d = i.optionCheck.call(n, a),
                    u = s.data(e).outClass;
                a.loading && i.removeLoading.call(n), u && s.removeClass(u), d ? i.inOverlay.call(n, c, l) : i.inDefault.call(n, c, l)
            },
            inDefault: function(e, n) {
                var s = t(this);
                s.css({ "animation-duration": n + "ms" }).addClass(e).trigger(i.settings.events.inStart).animateCallback((function() { s.removeClass(e).css({ opacity: 1 }).trigger(i.settings.events.inEnd) }))
            },
            inOverlay: function(n, s) {
                var a = t(this),
                    r = a.data(e).options;
                a.css({ opacity: 1 }).trigger(i.settings.events.inStart), t(r.overlayParentElement).children("." + r.overlayClass).css({ "animation-duration": s + "ms" }).addClass(n).animateCallback((function() { a.trigger(i.settings.events.inEnd) }))
            },
            out: function(n, s) {
                var a = this,
                    r = t(this),
                    o = r.data(e).options,
                    l = n.data(i.settings.data.outClass),
                    c = r.data(i.settings.data.outClass),
                    d = n.data(i.settings.data.outDuration),
                    u = r.data(i.settings.data.outDuration),
                    h = l || c,
                    p = d || u,
                    f = i.animationCheck.call(a, h, !0, !1),
                    m = i.animationCheck.call(a, p, !1, !1),
                    v = i.optionCheck.call(a, o);
                r.data(e).outClass = f, v ? i.outOverlay.call(a, f, m, s) : i.outDefault.call(a, f, m, s)
            },
            outDefault: function(n, s, a) {
                var r = t(this),
                    o = r.data(e).options;
                r.css({ "animation-duration": s + 1 + "ms" }).addClass(n).trigger(i.settings.events.outStart).animateCallback((function() { r.trigger(i.settings.events.outEnd), o.transition(a) }))
            },
            outOverlay: function(n, s, a) {
                var r = t(this),
                    o = r.data(e).options,
                    l = r.data(i.settings.data.inClass),
                    c = i.animationCheck.call(this, l, !0, !0);
                t(o.overlayParentElement).children("." + o.overlayClass).css({ "animation-duration": s + 1 + "ms" }).removeClass(c).addClass(n).trigger(i.settings.events.outStart).animateCallback((function() { r.trigger(i.settings.events.outEnd), o.transition(a) }))
            },
            destroy: function() {
                return this.each((function() {
                    var i = t(this);
                    t(window).off("." + e), i.css({ opacity: 1 }).removeData(e)
                }))
            }
        };
    t.fn.animateCallback = function(e) {
        var i = "animationend webkitAnimationEnd";
        return this.each((function() {
            var n = t(this);
            n.on(i, (function() { return n.off(i), e.call(this) }))
        }))
    }, t.fn.animsition = function(n) { return i[n] ? i[n].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof n && n ? void t.error("Method " + n + " does not exist on jQuery." + e) : i.init.apply(this, arguments) }
})),
function(t, e) { "object" == typeof exports && "undefined" != typeof module ? e(exports) : "function" == typeof define && define.amd ? define(["exports"], e) : e((t = t || self).window = t.window || {}) }(this, (function(t) {
    "use strict";

    function e(t, e) { t.prototype = Object.create(e.prototype), (t.prototype.constructor = t).__proto__ = e }

    function i(t) { if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); return t }

    function n(t) { return "string" == typeof t }

    function s(t) { return "function" == typeof t }

    function a(t) { return "number" == typeof t }

    function r(t) { return void 0 === t }

    function o(t) { return "object" == typeof t }

    function l(t) { return !1 !== t }

    function c() { return "undefined" != typeof window }

    function d(t) { return s(t) || n(t) }

    function u(t) { return (mt = oe(t, Zt)) && ai }

    function h(t, e) { return console.warn("Invalid property", t, "set to", e, "Missing plugin? gsap.registerPlugin()") }

    function p(t, e) { return !e && console.warn(t) }

    function f(t, e) { return t && (Zt[t] = e) && mt && (mt[t] = e) || Zt }

    function m() { return 0 }

    function v(t) {
        var e, i, n = t[0];
        if (o(n) || s(n) || (t = [t]), !(e = (n._gsap || {}).harness)) {
            for (i = ae.length; i-- && !ae[i].targetTest(n););
            e = ae[i]
        }
        for (i = t.length; i--;) t[i] && (t[i]._gsap || (t[i]._gsap = new Pe(t[i], e))) || t.splice(i, 1);
        return t
    }

    function g(t) { return t._gsap || v(he(t))[0]._gsap }

    function y(t, e) { var i = t[e]; return s(i) ? t[e]() : r(i) && t.getAttribute(e) || i }

    function b(t, e) { return (t = t.split(",")).forEach(e) || t }

    function w(t) { return Math.round(1e5 * t) / 1e5 || 0 }

    function x(t, e) { for (var i = e.length, n = 0; t.indexOf(e[n]) < 0 && ++n < i;); return n < i }

    function T(t, e, i) {
        var n, s = a(t[1]),
            r = (s ? 2 : 1) + (e < 2 ? 0 : 1),
            o = t[r];
        if (s && (o.duration = t[1]), o.parent = i, e) {
            for (n = o; i && !("immediateRender" in n);) n = i.vars.defaults || {}, i = l(i.vars.inherit) && i.parent;
            o.immediateRender = l(n.immediateRender), e < 2 ? o.runBackwards = 1 : o.startAt = t[r - 1]
        }
        return o
    }

    function S() {
        var t, e, i = te.length,
            n = te.slice(0);
        for (ee = {}, t = te.length = 0; t < i; t++)(e = n[t]) && e._lazy && (e.render(e._lazy[0], e._lazy[1], !0)._lazy = 0)
    }

    function C(t, e, i, n) { te.length && S(), t.render(e, i, n), te.length && S() }

    function E(t) { var e = parseFloat(t); return (e || 0 === e) && (t + "").match(Qt).length < 2 ? e : t }

    function k(t) { return t }

    function M(t, e) { for (var i in e) i in t || (t[i] = e[i]); return t }

    function _(t, e) { for (var i in e) i in t || "duration" === i || "ease" === i || (t[i] = e[i]) }

    function P(t, e) { for (var i in e) t[i] = o(e[i]) ? P(t[i] || (t[i] = {}), e[i]) : e[i]; return t }

    function $(t, e) { var i, n = {}; for (i in t) i in e || (n[i] = t[i]); return n }

    function A(t) {
        var e = t.parent || ut,
            i = t.keyframes ? _ : M;
        if (l(t.inherit))
            for (; e;) i(t, e.vars.defaults), e = e.parent;
        return t
    }

    function L(t, e, i, n) {
        void 0 === i && (i = "_first"), void 0 === n && (n = "_last");
        var s = e._prev,
            a = e._next;
        s ? s._next = a : t[i] === e && (t[i] = a), a ? a._prev = s : t[n] === e && (t[n] = s), e._next = e._prev = e.parent = null
    }

    function I(t, e) {!t.parent || e && !t.parent.autoRemoveChildren || t.parent.remove(t), t._act = 0 }

    function z(t) { for (var e = t; e;) e._dirty = 1, e = e.parent; return t }

    function O(t) { return t._repeat ? le(t._tTime, t = t.duration() + t._rDelay) * t : 0 }

    function D(t, e) { return (t - e._start) * e._ts + (0 <= e._ts ? 0 : e._dirty ? e.totalDuration() : e._tDur) }

    function F(t) { return t._end = w(t._start + (t._tDur / Math.abs(t._ts || t._pauseTS || Ft) || 0)) }

    function R(t, e) {
        var i;
        if ((e._time || e._initted && !e._dur) && (i = D(t.rawTime(), e), (!e._dur || de(0, e.totalDuration(), i) - e._tTime > Ft) && e.render(i, !0)), z(t)._dp && t._initted && t._time >= t._dur && t._ts) {
            if (t._dur < t.duration())
                for (i = t; i._dp;) 0 <= i.rawTime() && i.totalTime(i._tTime), i = i._dp;
            t._zTime = -Ft
        }
    }

    function B(t, e, i, n) {
        return e.parent && I(e), e._start = w(i + e._delay), e._end = w(e._start + (e.totalDuration() / Math.abs(e.timeScale()) || 0)),
            function(t, e, i, n, s) {
                void 0 === i && (i = "_first"), void 0 === n && (n = "_last");
                var a, r = t[n];
                if (s)
                    for (a = e[s]; r && r[s] > a;) r = r._prev;
                r ? (e._next = r._next, r._next = e) : (e._next = t[i], t[i] = e), e._next ? e._next._prev = e : t[n] = e, e._prev = r, e.parent = e._dp = t
            }(t, e, "_first", "_last", t._sort ? "_start" : 0), t._recent = e, n || R(t, e), t
    }

    function j(t, e, i, n) { return De(t, e), t._initted ? !i && t._pt && (t._dur && !1 !== t.vars.lazy || !t._dur && t.vars.lazy) && gt !== be.frame ? (te.push(t), t._lazy = [e, n], 1) : void 0 : 1 }

    function N(t, e, i) {
        var n = t._repeat,
            s = w(e);
        return t._dur = s, t._tDur = n ? n < 0 ? 1e12 : w(s * (n + 1) + t._rDelay * n) : s, i || z(t.parent), t.parent && F(t), t
    }

    function V(t) { return t instanceof Le ? z(t) : N(t, t._dur) }

    function H(t, e) {
        var i, s, a = t.labels,
            r = t._recent || ce,
            o = t.duration() >= Dt ? r.endTime(!1) : t._dur;
        return n(e) && (isNaN(e) || e in a) ? "<" === (i = e.charAt(0)) || ">" === i ? ("<" === i ? r._start : r.endTime(0 <= r._repeat)) + (parseFloat(e.substr(1)) || 0) : (i = e.indexOf("=")) < 0 ? (e in a || (a[e] = o), a[e]) : (s = +(e.charAt(i - 1) + e.substr(i + 1)), 1 < i ? H(t, e.substr(0, i - 1)) + s : o + s) : null == e ? o : +e
    }

    function Y(t, e) { return t || 0 === t ? e(t) : e }

    function q(t) { return (t + "").substr((parseFloat(t) + "").length) }

    function X(t, e) { return t && o(t) && "length" in t && (!e && !t.length || t.length - 1 in t && o(t[0])) && !t.nodeType && t !== ht }

    function W(t) { return t.sort((function() { return .5 - Math.random() })) }

    function G(t) {
        if (s(t)) return t;
        var e = o(t) ? t : { each: t },
            i = Ee(e.ease),
            a = e.from || 0,
            r = parseFloat(e.base) || 0,
            l = {},
            c = 0 < a && a < 1,
            d = isNaN(a) || c,
            u = e.axis,
            h = a,
            p = a;
        return n(a) ? h = p = { center: .5, edges: .5, end: 1 }[a] || 0 : !c && d && (h = a[0], p = a[1]),
            function(t, n, s) {
                var o, c, f, m, v, g, y, b, x, T = (s || e).length,
                    S = l[T];
                if (!S) {
                    if (!(x = "auto" === e.grid ? 0 : (e.grid || [1, Dt])[1])) {
                        for (y = -Dt; y < (y = s[x++].getBoundingClientRect().left) && x < T;);
                        x--
                    }
                    for (S = l[T] = [], o = d ? Math.min(x, T) * h - .5 : a % x, c = d ? T * p / x - .5 : a / x | 0, b = Dt, g = y = 0; g < T; g++) f = g % x - o, m = c - (g / x | 0), S[g] = v = u ? Math.abs("y" === u ? m : f) : Nt(f * f + m * m), y < v && (y = v), v < b && (b = v);
                    "random" === a && W(S), S.max = y - b, S.min = b, S.v = T = (parseFloat(e.amount) || parseFloat(e.each) * (T < x ? T - 1 : u ? "y" === u ? T / x : x : Math.max(x, T / x)) || 0) * ("edges" === a ? -1 : 1), S.b = T < 0 ? r - T : r, S.u = q(e.amount || e.each) || 0, i = i && T < 0 ? Ce(i) : i
                }
                return T = (S[t] - S.min) / S.max || 0, w(S.b + (i ? i(T) : T) * S.v) + S.u
            }
    }

    function U(t) { var e = t < 1 ? Math.pow(10, (t + "").length - 2) : 1; return function(i) { return ~~(Math.round(parseFloat(i) / t) * t * e) / e + (a(i) ? 0 : q(i)) } }

    function K(t, e) { var i, n, r = Yt(t); return !r && o(t) && (i = r = t.radius || Dt, t.values ? (t = he(t.values), (n = !a(t[0])) && (i *= i)) : t = U(t.increment)), Y(e, r ? s(t) ? function(e) { return n = t(e), Math.abs(n - e) <= i ? n : e } : function(e) { for (var s, r, o = parseFloat(n ? e.x : e), l = parseFloat(n ? e.y : 0), c = Dt, d = 0, u = t.length; u--;)(s = n ? (s = t[u].x - o) * s + (r = t[u].y - l) * r : Math.abs(t[u] - o)) < c && (c = s, d = u); return d = !i || c <= i ? t[d] : e, n || d === e || a(e) ? d : d + q(e) } : U(t)) }

    function Q(t, e, i, n) { return Y(Yt(t) ? !e : !0 === i ? !!(i = 0) : !n, (function() { return Yt(t) ? t[~~(Math.random() * t.length)] : (i = i || 1e-5) && (n = i < 1 ? Math.pow(10, (i + "").length - 2) : 1) && ~~(Math.round((t + Math.random() * (e - t)) / i) * i * n) / n })) }

    function Z(t, e, i) { return Y(i, (function(i) { return t[~~e(i)] })) }

    function J(t) { for (var e, i, n, s, a = 0, r = ""; ~(e = t.indexOf("random(", a));) n = t.indexOf(")", e), s = "[" === t.charAt(e + 7), i = t.substr(e + 7, n - e - 7).match(s ? Qt : qt), r += t.substr(a, e - a) + Q(s ? i : +i[0], +i[1], +i[2] || 1e-5), a = n + 1; return r + t.substr(a, t.length - a) }

    function tt(t, e, i) {
        var n, s, a, r = t.labels,
            o = Dt;
        for (n in r)(s = r[n] - e) < 0 == !!i && s && o > (s = Math.abs(s)) && (a = n, o = s);
        return a
    }

    function et(t) { return I(t), t.progress() < 1 && fe(t, "onInterrupt"), t }

    function it(t, e, i) { return (6 * (t = t < 0 ? t + 1 : 1 < t ? t - 1 : t) < 1 ? e + (i - e) * t * 6 : t < .5 ? i : 3 * t < 2 ? e + (i - e) * (2 / 3 - t) * 6 : e) * me + .5 | 0 }

    function nt(t, e, i) {
        var n, s, r, o, l, c, d, u, h, p, f = t ? a(t) ? [t >> 16, t >> 8 & me, t & me] : 0 : ve.black;
        if (!f) {
            if ("," === t.substr(-1) && (t = t.substr(0, t.length - 1)), ve[t]) f = ve[t];
            else if ("#" === t.charAt(0)) 4 === t.length && (t = "#" + (n = t.charAt(1)) + n + (s = t.charAt(2)) + s + (r = t.charAt(3)) + r), f = [(t = parseInt(t.substr(1), 16)) >> 16, t >> 8 & me, t & me];
            else if ("hsl" === t.substr(0, 3))
                if (f = p = t.match(qt), e) { if (~t.indexOf("=")) return f = t.match(Xt), i && f.length < 4 && (f[3] = 1), f } else o = +f[0] % 360 / 360, l = f[1] / 100, n = 2 * (c = f[2] / 100) - (s = c <= .5 ? c * (l + 1) : c + l - c * l), 3 < f.length && (f[3] *= 1), f[0] = it(o + 1 / 3, n, s), f[1] = it(o, n, s), f[2] = it(o - 1 / 3, n, s);
            else f = t.match(qt) || ve.transparent;
            f = f.map(Number)
        }
        return e && !p && (n = f[0] / me, s = f[1] / me, r = f[2] / me, c = ((d = Math.max(n, s, r)) + (u = Math.min(n, s, r))) / 2, d === u ? o = l = 0 : (h = d - u, l = .5 < c ? h / (2 - d - u) : h / (d + u), o = d === n ? (s - r) / h + (s < r ? 6 : 0) : d === s ? (r - n) / h + 2 : (n - s) / h + 4, o *= 60), f[0] = ~~(o + .5), f[1] = ~~(100 * l + .5), f[2] = ~~(100 * c + .5)), i && f.length < 4 && (f[3] = 1), f
    }

    function st(t) {
        var e = [],
            i = [],
            n = -1;
        return t.split(ge).forEach((function(t) {
            var s = t.match(Wt) || [];
            e.push.apply(e, s), i.push(n += s.length + 1)
        })), e.c = i, e
    }

    function at(t, e, i) {
        var n, s, a, r, o = "",
            l = (t + o).match(ge),
            c = e ? "hsla(" : "rgba(",
            d = 0;
        if (!l) return t;
        if (l = l.map((function(t) { return (t = nt(t, e, 1)) && c + (e ? t[0] + "," + t[1] + "%," + t[2] + "%," + t[3] : t.join(",")) + ")" })), i && (a = st(t), (n = i.c).join(o) !== a.c.join(o)))
            for (r = (s = t.replace(ge, "1").split(Wt)).length - 1; d < r; d++) o += s[d] + (~n.indexOf(d) ? l.shift() || c + "0,0,0,0)" : (a.length ? a : l.length ? l : i).shift());
        if (!s)
            for (r = (s = t.split(ge)).length - 1; d < r; d++) o += s[d] + l[d];
        return o + s[r]
    }

    function rt(t) { var e, i = t.join(" "); if (ge.lastIndex = 0, ge.test(i)) return e = ye.test(i), t[1] = at(t[1], e), t[0] = at(t[0], e, st(t[1])), !0 }

    function ot(t, e, i, n) { void 0 === i && (i = function(t) { return 1 - e(1 - t) }), void 0 === n && (n = function(t) { return t < .5 ? e(2 * t) / 2 : 1 - e(2 * (1 - t)) / 2 }); var s, a = { easeIn: e, easeOut: i, easeInOut: n }; return b(t, (function(t) { for (var e in xe[t] = Zt[t] = a, xe[s = t.toLowerCase()] = i, a) xe[s + ("easeIn" === e ? ".in" : "easeOut" === e ? ".out" : ".inOut")] = xe[t + "." + e] = a[e] })), a }

    function lt(t) { return function(e) { return e < .5 ? (1 - t(1 - 2 * e)) / 2 : .5 + t(2 * (e - .5)) / 2 } }

    function ct(t, e, i) {
        function n(t) { return 1 === t ? 1 : s * Math.pow(2, -10 * t) * Ht((t - r) * a) + 1 }
        var s = 1 <= e ? e : 1,
            a = (i || (t ? .3 : .45)) / (e < 1 ? e : 1),
            r = a / Rt * (Math.asin(1 / s) || 0),
            o = "out" === t ? n : "in" === t ? function(t) { return 1 - n(1 - t) } : lt(n);
        return a = Rt / a, o.config = function(e, i) { return ct(t, e, i) }, o
    }

    function dt(t, e) {
        function i(t) { return t ? --t * t * ((e + 1) * t + e) + 1 : 0 }
        void 0 === e && (e = 1.70158);
        var n = "out" === t ? i : "in" === t ? function(t) { return 1 - i(1 - t) } : lt(i);
        return n.config = function(e) { return dt(t, e) }, n
    }
    var ut, ht, pt, ft, mt, vt, gt, yt, bt, wt, xt, Tt, St, Ct, Et, kt, Mt, _t, Pt, $t, At, Lt, It, zt = { autoSleep: 120, force3D: "auto", nullTargetWarn: 1, units: { lineHeight: "" } },
        Ot = { duration: .5, overwrite: !1, delay: 0 },
        Dt = 1e8,
        Ft = 1 / Dt,
        Rt = 2 * Math.PI,
        Bt = Rt / 4,
        jt = 0,
        Nt = Math.sqrt,
        Vt = Math.cos,
        Ht = Math.sin,
        Yt = Array.isArray,
        qt = /(?:-?\.?\d|\.)+/gi,
        Xt = /[-+=.]*\d+[.e\-+]*\d*[e\-\+]*\d*/g,
        Wt = /[-+=.]*\d+[.e-]*\d*[a-z%]*/g,
        Gt = /[-+=.]*\d+(?:\.|e-|e)*\d*/gi,
        Ut = /\(([^()]+)\)/i,
        Kt = /[+-]=-?[\.\d]+/,
        Qt = /[#\-+.]*\b[a-z\d-=+%.]+/gi,
        Zt = {},
        Jt = {},
        te = [],
        ee = {},
        ie = {},
        ne = {},
        se = 30,
        ae = [],
        re = "",
        oe = function(t, e) { for (var i in e) t[i] = e[i]; return t },
        le = function(t, e) { return (t /= e) && ~~t === t ? ~~t - 1 : ~~t },
        ce = { _start: 0, endTime: m },
        de = function(t, e, i) { return i < t ? t : e < i ? e : i },
        ue = [].slice,
        he = function(t, e) { return !n(t) || e || !pt && we() ? Yt(t) ? function(t, e, i) { return void 0 === i && (i = []), t.forEach((function(t) { return n(t) && !e || X(t, 1) ? i.push.apply(i, he(t)) : i.push(t) })) || i }(t, e) : X(t) ? ue.call(t, 0) : t ? [t] : [] : ue.call(ft.querySelectorAll(t), 0) },
        pe = function(t, e, i, n, s) {
            var a = e - t,
                r = n - i;
            return Y(s, (function(e) { return i + (e - t) / a * r }))
        },
        fe = function(t, e, i) {
            var n, s, a = t.vars,
                r = a[e];
            if (r) return n = a[e + "Params"], s = a.callbackScope || t, i && te.length && S(), n ? r.apply(s, n) : r.call(s)
        },
        me = 255,
        ve = { aqua: [0, me, me], lime: [0, me, 0], silver: [192, 192, 192], black: [0, 0, 0], maroon: [128, 0, 0], teal: [0, 128, 128], blue: [0, 0, me], navy: [0, 0, 128], white: [me, me, me], olive: [128, 128, 0], yellow: [me, me, 0], orange: [me, 165, 0], gray: [128, 128, 128], purple: [128, 0, 128], green: [0, 128, 0], red: [me, 0, 0], pink: [me, 192, 203], cyan: [0, me, me], transparent: [me, me, me, 0] },
        ge = function() { var t, e = "(?:\\b(?:(?:rgb|rgba|hsl|hsla)\\(.+?\\))|\\B#(?:[0-9a-f]{3}){1,2}\\b"; for (t in ve) e += "|" + t + "\\b"; return new RegExp(e + ")", "gi") }(),
        ye = /hsl[a]?\(/,
        be = (Ct = Date.now, Et = 500, kt = 33, Mt = Ct(), _t = Mt, $t = Pt = 1 / 240, St = {
            time: 0,
            frame: 0,
            tick: function() { ke(!0) },
            wake: function() { vt && (!pt && c() && (ht = pt = window, ft = ht.document || {}, Zt.gsap = ai, (ht.gsapVersions || (ht.gsapVersions = [])).push(ai.version), u(mt || ht.GreenSockGlobals || !ht.gsap && ht || {}), Tt = ht.requestAnimationFrame), wt && St.sleep(), xt = Tt || function(t) { return setTimeout(t, 1e3 * ($t - St.time) + 1 | 0) }, bt = 1, ke(2)) },
            sleep: function() {
                (Tt ? ht.cancelAnimationFrame : clearTimeout)(wt), bt = 0, xt = m
            },
            lagSmoothing: function(t, e) { Et = t || 1e8, kt = Math.min(e, Et, 0) },
            fps: function(t) { Pt = 1 / (t || 240), $t = St.time + Pt },
            add: function(t) { At.indexOf(t) < 0 && At.push(t), we() },
            remove: function(t) { var e;~(e = At.indexOf(t)) && At.splice(e, 1) },
            _listeners: At = []
        }),
        we = function() { return !bt && be.wake() },
        xe = {},
        Te = /^[\d.\-M][\d.\-,\s]/,
        Se = /["']/g,
        Ce = function(t) { return function(e) { return 1 - t(1 - e) } },
        Ee = function(t, e) {
            return t && (s(t) ? t : xe[t] || function(t) {
                var e = (t + "").split("("),
                    i = xe[e[0]];
                return i && 1 < e.length && i.config ? i.config.apply(null, ~t.indexOf("{") ? [function(t) { for (var e, i, n, s = {}, a = t.substr(1, t.length - 3).split(":"), r = a[0], o = 1, l = a.length; o < l; o++) i = a[o], e = o !== l - 1 ? i.lastIndexOf(",") : i.length, n = i.substr(0, e), s[r] = isNaN(n) ? n.replace(Se, "").trim() : +n, r = i.substr(e + 1).trim(); return s }(e[1])] : Ut.exec(t)[1].split(",").map(E)) : xe._CE && Te.test(t) ? xe._CE("", t) : i
            }(t)) || e
        };

    function ke(t) {
        var e, i, n = Ct() - _t,
            s = !0 === t;
        Et < n && (Mt += n - kt), _t += n, St.time = (_t - Mt) / 1e3, (0 < (e = St.time - $t) || s) && (St.frame++, $t += e + (Pt <= e ? .004 : Pt - e), i = 1), s || (wt = xt(ke)), i && At.forEach((function(e) { return e(St.time, n, St.frame, t) }))
    }

    function Me(t) { return t < It ? Lt * t * t : t < .7272727272727273 ? Lt * Math.pow(t - 1.5 / 2.75, 2) + .75 : t < .9090909090909092 ? Lt * (t -= 2.25 / 2.75) * t + .9375 : Lt * Math.pow(t - 2.625 / 2.75, 2) + .984375 }
    b("Linear,Quad,Cubic,Quart,Quint,Strong", (function(t, e) {
        var i = e < 5 ? e + 1 : e;
        ot(t + ",Power" + (i - 1), e ? function(t) { return Math.pow(t, i) } : function(t) { return t }, (function(t) { return 1 - Math.pow(1 - t, i) }), (function(t) { return t < .5 ? Math.pow(2 * t, i) / 2 : 1 - Math.pow(2 * (1 - t), i) / 2 }))
    })), xe.Linear.easeNone = xe.none = xe.Linear.easeIn, ot("Elastic", ct("in"), ct("out"), ct()), Lt = 7.5625, It = 1 / 2.75, ot("Bounce", (function(t) { return 1 - Me(1 - t) }), Me), ot("Expo", (function(t) { return t ? Math.pow(2, 10 * (t - 1)) : 0 })), ot("Circ", (function(t) { return -(Nt(1 - t * t) - 1) })), ot("Sine", (function(t) { return 1 - Vt(t * Bt) })), ot("Back", dt("in"), dt("out"), dt()), xe.SteppedEase = xe.steps = Zt.SteppedEase = {
        config: function(t, e) {
            void 0 === t && (t = 1);
            var i = 1 / t,
                n = t + (e ? 0 : 1),
                s = e ? 1 : 0;
            return function(t) { return ((n * de(0, .99999999, t) | 0) + s) * i }
        }
    }, Ot.ease = xe["quad.out"], b("onComplete,onUpdate,onStart,onRepeat,onReverseComplete,onInterrupt", (function(t) { return re += t + "," + t + "Params," }));
    var _e, Pe = function(t, e) { this.id = jt++, (t._gsap = this).target = t, this.harness = e, this.get = e ? e.get : y, this.set = e ? e.getSetter : Xe },
        $e = ((_e = Ae.prototype).delay = function(t) { return t || 0 === t ? (this._delay = t, this) : this._delay }, _e.duration = function(t) { return arguments.length ? N(this, t) : this.totalDuration() && this._dur }, _e.totalDuration = function(t) { return arguments.length ? (this._dirty = 0, N(this, this._repeat < 0 ? t : (t - this._repeat * this._rDelay) / (this._repeat + 1))) : this._tDur }, _e.totalTime = function(t, e) { if (we(), !arguments.length) return this._tTime; var i = this.parent || this._dp; if (i && i.smoothChildTiming && this._ts) { for (this._start = w(i._time - (0 < this._ts ? t / this._ts : ((this._dirty ? this.totalDuration() : this._tDur) - t) / -this._ts)), F(this), i._dirty || z(i); i.parent;) i.parent._time !== i._start + (0 <= i._ts ? i._tTime / i._ts : (i.totalDuration() - i._tTime) / -i._ts) && i.totalTime(i._tTime, !0), i = i.parent;!this.parent && this._dp.autoRemoveChildren && B(this._dp, this, this._start - this._delay) } return (this._tTime !== t || !this._dur && !e || this._initted && Math.abs(this._zTime) === Ft) && (this._ts || (this._pTime = t), C(this, t, e)), this }, _e.time = function(t, e) { return arguments.length ? this.totalTime(Math.min(this.totalDuration(), t + O(this)) % this._dur || (t ? this._dur : 0), e) : this._time }, _e.totalProgress = function(t, e) { return arguments.length ? this.totalTime(this.totalDuration() * t, e) : this.totalDuration() ? Math.min(1, this._tTime / this._tDur) : this.ratio }, _e.progress = function(t, e) { return arguments.length ? this.totalTime(this.duration() * (!this._yoyo || 1 & this.iteration() ? t : 1 - t) + O(this), e) : this.duration() ? Math.min(1, this._time / this._dur) : this.ratio }, _e.iteration = function(t, e) { var i = this.duration() + this._rDelay; return arguments.length ? this.totalTime(this._time + (t - 1) * i, e) : this._repeat ? le(this._tTime, i) + 1 : 1 }, _e.timeScale = function(t) {
            if (!arguments.length) return this._ts || this._pauseTS || 0;
            if (null !== this._pauseTS) return this._pauseTS = t, this;
            var e = this.parent && this._ts ? D(this.parent._time, this) : this._tTime;
            return this._ts = t,
                function(t) { for (var e = t.parent; e && e.parent;) e._dirty = 1, e.totalDuration(), e = e.parent; return t }(this.totalTime(e, !0))
        }, _e.paused = function(t) { var e = !this._ts; return arguments.length ? (e !== t && (t ? (this._pauseTS = this._ts, this._pTime = this._tTime || Math.max(-this._delay, this.rawTime()), this._ts = this._act = 0) : (we(), this._ts = this._pauseTS || 1, this._pauseTS = null, this.totalTime(this.parent && !this.parent.smoothChildTiming ? this.rawTime() : this._tTime || this._pTime, 1 === this.progress() && (this._tTime -= Ft) && Math.abs(this._zTime) !== Ft))), this) : e }, _e.startTime = function(t) { return arguments.length ? (this.parent && this.parent._sort && B(this.parent, this, t - this._delay), this) : this._start }, _e.endTime = function(t) { return this._start + (l(t) ? this.totalDuration() : this.duration()) / Math.abs(this._ts) }, _e.rawTime = function(t) { var e = this.parent || this._dp; return e ? t && (!this._ts || this._repeat && this._time && this.totalProgress() < 1) ? this._tTime % (this._dur + this._rDelay) : this._ts ? D(e.rawTime(t), this) : this._tTime : this._tTime }, _e.repeat = function(t) { return arguments.length ? (this._repeat = t, V(this)) : this._repeat }, _e.repeatDelay = function(t) { return arguments.length ? (this._rDelay = t, V(this)) : this._rDelay }, _e.yoyo = function(t) { return arguments.length ? (this._yoyo = t, this) : this._yoyo }, _e.seek = function(t, e) { return this.totalTime(H(this, t), l(e)) }, _e.restart = function(t, e) { return this.play().totalTime(t ? -this._delay : 0, l(e)) }, _e.play = function(t, e) { return null != t && this.seek(t, e), this.reversed(!1).paused(!1) }, _e.reverse = function(t, e) { return null != t && this.seek(t || this.totalDuration(), e), this.reversed(!0).paused(!1) }, _e.pause = function(t, e) { return null != t && this.seek(t, e), this.paused(!0) }, _e.resume = function() { return this.paused(!1) }, _e.reversed = function(t) { var e = this._ts || this._pauseTS || 0; return arguments.length ? (t !== this.reversed() && (this[null === this._pauseTS ? "_ts" : "_pauseTS"] = Math.abs(e) * (t ? -1 : 1), this.totalTime(this._tTime, !0)), this) : e < 0 }, _e.invalidate = function() { return this._initted = 0, this._zTime = -Ft, this }, _e.isActive = function(t) {
            var e, i = this.parent || this._dp,
                n = this._start;
            return !(i && !(this._ts && (this._initted || !t) && i.isActive(t) && (e = i.rawTime(!0)) >= n && e < this.endTime(!0) - Ft))
        }, _e.eventCallback = function(t, e, i) { var n = this.vars; return 1 < arguments.length ? (e ? (n[t] = e, i && (n[t + "Params"] = i), "onUpdate" === t && (this._onUpdate = e)) : delete n[t], this) : n[t] }, _e.then = function(t) {
            var e = this;
            return new Promise((function(i) {
                function n() {
                    var t = e.then;
                    e.then = null, s(a) && (a = a(e)) && (a.then || a === e) && (e.then = t), i(a), e.then = t
                }
                var a = s(t) ? t : k;
                e._initted && 1 === e.totalProgress() && 0 <= e._ts || !e._tTime && e._ts < 0 ? n() : e._prom = n
            }))
        }, _e.kill = function() { et(this) }, Ae);

    function Ae(t, e) {
        var i = t.parent || ut;
        this.vars = t, this._delay = +t.delay || 0, (this._repeat = t.repeat || 0) && (this._rDelay = t.repeatDelay || 0, this._yoyo = !!t.yoyo || !!t.yoyoEase), this._ts = t.reversed ? -1 : 1, N(this, +t.duration, 1), this.data = t.data, bt || be.wake(), i && B(i, this, e || 0 === e ? e : i._time, 1), t.paused && this.paused(!0)
    }
    M($e.prototype, { _time: 0, _start: 0, _end: 0, _tTime: 0, _tDur: 0, _dirty: 0, _repeat: 0, _yoyo: !1, parent: null, _initted: !1, _rDelay: 0, _ts: 1, _dp: 0, ratio: 0, _zTime: -Ft, _prom: 0, _pauseTS: null });
    var Le = function(t) {
        function r(e, n) { var s; return void 0 === e && (e = {}), (s = t.call(this, e, n) || this).labels = {}, s.smoothChildTiming = !!e.smoothChildTiming, s.autoRemoveChildren = !!e.autoRemoveChildren, s._sort = l(e.sortChildren), s.parent && R(s.parent, i(s)), s }
        e(r, t);
        var o = r.prototype;
        return o.to = function(t, e, i, n) { return new je(t, T(arguments, 0, this), H(this, a(e) ? n : i)), this }, o.from = function(t, e, i, n) { return new je(t, T(arguments, 1, this), H(this, a(e) ? n : i)), this }, o.fromTo = function(t, e, i, n, s) { return new je(t, T(arguments, 2, this), H(this, a(e) ? s : n)), this }, o.set = function(t, e, i) { return e.duration = 0, e.parent = this, A(e).repeatDelay || (e.repeat = 0), e.immediateRender = !!e.immediateRender, new je(t, e, H(this, i), 1), this }, o.call = function(t, e, i) { return B(this, je.delayedCall(0, t, e), H(this, i)) }, o.staggerTo = function(t, e, i, n, s, a, r) { return i.duration = e, i.stagger = i.stagger || n, i.onComplete = a, i.onCompleteParams = r, i.parent = this, new je(t, i, H(this, s)), this }, o.staggerFrom = function(t, e, i, n, s, a, r) { return i.runBackwards = 1, A(i).immediateRender = l(i.immediateRender), this.staggerTo(t, e, i, n, s, a, r) }, o.staggerFromTo = function(t, e, i, n, s, a, r, o) { return n.startAt = i, A(n).immediateRender = l(n.immediateRender), this.staggerTo(t, e, n, s, a, r, o) }, o.render = function(t, e, i) {
            var n, s, a, r, o, l, c, d, u, h, p, f, m = this._time,
                v = this._dirty ? this.totalDuration() : this._tDur,
                g = this._dur,
                y = this !== ut && v - Ft < t && 0 <= t ? v : t < Ft ? 0 : t,
                b = this._zTime < 0 != t < 0 && (this._initted || !g);
            if (y !== this._tTime || i || b) {
                if (m !== this._time && g && (y += this._time - m, t += this._time - m), n = y, u = this._start, l = !(d = this._ts), b && (g || (m = this._zTime), !t && e || (this._zTime = t)), this._repeat && (p = this._yoyo, (g < (n = w(y % (o = g + this._rDelay))) || v === y) && (n = g), (r = ~~(y / o)) && r === y / o && (n = g, r--), p && 1 & r && (n = g - n, f = 1), r !== (h = le(this._tTime, o)) && !this._lock)) {
                    var x = p && 1 & h,
                        T = x === (p && 1 & r);
                    if (r < h && (x = !x), m = x ? 0 : g, this._lock = 1, this.render(m, e, !g)._lock = 0, !e && this.parent && fe(this, "onRepeat"), this.vars.repeatRefresh && !f && (this.invalidate()._lock = 1), m !== this._time || l != !this._ts) return this;
                    if (T && (this._lock = 2, m = x ? g + 1e-4 : -1e-4, this.render(m, !0), this.vars.repeatRefresh && !f && this.invalidate()), this._lock = 0, !this._ts && !l) return this
                }
                if (this._hasPause && !this._forcing && this._lock < 2 && (c = function(t, e, i) {
                        var n;
                        if (e < i)
                            for (n = t._first; n && n._start <= i;) {
                                if (!n._dur && "isPause" === n.data && n._start > e) return n;
                                n = n._next
                            } else
                                for (n = t._last; n && n._start >= i;) {
                                    if (!n._dur && "isPause" === n.data && n._start < e) return n;
                                    n = n._prev
                                }
                    }(this, w(m), w(n))) && (y -= n - (n = c._start)), this._tTime = y, this._time = n, this._act = !d, this._initted || (this._onUpdate = this.vars.onUpdate, this._initted = 1, this._zTime = t), m || !n || e || fe(this, "onStart"), m <= n && 0 <= t)
                    for (s = this._first; s;) {
                        if (a = s._next, (s._act || n >= s._start) && s._ts && c !== s) { if (s.parent !== this) return this.render(t, e, i); if (s.render(0 < s._ts ? (n - s._start) * s._ts : (s._dirty ? s.totalDuration() : s._tDur) + (n - s._start) * s._ts, e, i), n !== this._time || !this._ts && !l) { c = 0, a && (y += this._zTime = -Ft); break } }
                        s = a
                    } else {
                        s = this._last;
                        for (var S = t < 0 ? t : n; s;) {
                            if (a = s._prev, (s._act || S <= s._end) && s._ts && c !== s) { if (s.parent !== this) return this.render(t, e, i); if (s.render(0 < s._ts ? (S - s._start) * s._ts : (s._dirty ? s.totalDuration() : s._tDur) + (S - s._start) * s._ts, e, i), n !== this._time || !this._ts && !l) { c = 0, a && (y += this._zTime = S ? -Ft : Ft); break } }
                            s = a
                        }
                    }
                if (c && !e && (this.pause(), c.render(m <= n ? 0 : -Ft)._zTime = m <= n ? 1 : -1, this._ts)) return this._start = u, F(this), this.render(t, e, i);
                this._onUpdate && !e && fe(this, "onUpdate", !0), (y === v && v >= this.totalDuration() || !y && this._ts < 0) && (u !== this._start && Math.abs(d) === Math.abs(this._ts) || (!t && g || !(t && 0 < this._ts || !y && this._ts < 0) || I(this, 1), e || t < 0 && !m || (fe(this, y === v ? "onComplete" : "onReverseComplete", !0), this._prom && this._prom())))
            }
            return this
        }, o.add = function(t, e) {
            var i = this;
            if (a(e) || (e = H(this, e)), !(t instanceof $e)) {
                if (Yt(t)) return t.forEach((function(t) { return i.add(t, e) })), z(this);
                if (n(t)) return this.addLabel(t, e);
                if (!s(t)) return this;
                t = je.delayedCall(0, t)
            }
            return this !== t ? B(this, t, e) : this
        }, o.getChildren = function(t, e, i, n) { void 0 === t && (t = !0), void 0 === e && (e = !0), void 0 === i && (i = !0), void 0 === n && (n = -Dt); for (var s = [], a = this._first; a;) a._start >= n && (a instanceof je ? e && s.push(a) : (i && s.push(a), t && s.push.apply(s, a.getChildren(!0, e, i)))), a = a._next; return s }, o.getById = function(t) {
            for (var e = this.getChildren(1, 1, 1), i = e.length; i--;)
                if (e[i].vars.id === t) return e[i]
        }, o.remove = function(t) { return n(t) ? this.removeLabel(t) : s(t) ? this.killTweensOf(t) : (L(this, t), t === this._recent && (this._recent = this._last), z(this)) }, o.totalTime = function(e, i) { return arguments.length ? (this._forcing = 1, this.parent || this._dp || !this._ts || (this._start = w(be.time - (0 < this._ts ? e / this._ts : (this.totalDuration() - e) / -this._ts))), t.prototype.totalTime.call(this, e, i), this._forcing = 0, this) : this._tTime }, o.addLabel = function(t, e) { return this.labels[t] = H(this, e), this }, o.removeLabel = function(t) { return delete this.labels[t], this }, o.addPause = function(t, e, i) { var n = je.delayedCall(0, e || m, i); return n.data = "isPause", this._hasPause = 1, B(this, n, H(this, t)) }, o.removePause = function(t) { var e = this._first; for (t = H(this, t); e;) e._start === t && "isPause" === e.data && I(e), e = e._next }, o.killTweensOf = function(t, e, i) { for (var n = this.getTweensOf(t, i), s = n.length; s--;) ze !== n[s] && n[s].kill(t, e); return this }, o.getTweensOf = function(t, e) { for (var i, n = [], s = he(t), a = this._first; a;) a instanceof je ? !x(a._targets, s) || e && !a.isActive("started" === e) || n.push(a) : (i = a.getTweensOf(s, e)).length && n.push.apply(n, i), a = a._next; return n }, o.tweenTo = function(t, e) {
            e = e || {};
            var i = this,
                n = H(i, t),
                s = e.startAt,
                a = e.onStart,
                r = e.onStartParams,
                o = je.to(i, M(e, {
                    ease: "none",
                    lazy: !1,
                    time: n,
                    duration: e.duration || Math.abs(n - (s && "time" in s ? s.time : i._time)) / i.timeScale() || Ft,
                    onStart: function() {
                        i.pause();
                        var t = e.duration || Math.abs(n - i._time) / i.timeScale();
                        o._dur !== t && N(o, t).render(o._time, !0, !0), a && a.apply(o, r || [])
                    }
                }));
            return o
        }, o.tweenFromTo = function(t, e, i) { return this.tweenTo(e, M({ startAt: { time: H(this, t) } }, i)) }, o.recent = function() { return this._recent }, o.nextLabel = function(t) { return void 0 === t && (t = this._time), tt(this, H(this, t)) }, o.previousLabel = function(t) { return void 0 === t && (t = this._time), tt(this, H(this, t), 1) }, o.currentLabel = function(t) { return arguments.length ? this.seek(t, !0) : this.previousLabel(this._time + Ft) }, o.shiftChildren = function(t, e, i) {
            void 0 === i && (i = 0);
            for (var n, s = this._first, a = this.labels; s;) s._start >= i && (s._start += t), s = s._next;
            if (e)
                for (n in a) a[n] >= i && (a[n] += t);
            return z(this)
        }, o.invalidate = function() { var e = this._first; for (this._lock = 0; e;) e.invalidate(), e = e._next; return t.prototype.invalidate.call(this) }, o.clear = function(t) { void 0 === t && (t = !0); for (var e, i = this._first; i;) e = i._next, this.remove(i), i = e; return this._time = this._tTime = 0, t && (this.labels = {}), z(this) }, o.totalDuration = function(t) {
            var e, i, n, s, a = 0,
                r = this,
                o = r._last,
                l = Dt;
            if (arguments.length) return r._repeat < 0 ? r : r.timeScale(r.totalDuration() / t);
            if (r._dirty) {
                for (s = r.parent; o;) e = o._prev, o._dirty && o.totalDuration(), l < (n = o._start) && r._sort && o._ts && !r._lock ? (r._lock = 1, B(r, o, n - o._delay, 1)._lock = 0) : l = n, n < 0 && o._ts && (a -= n, (!s && !r._dp || s && s.smoothChildTiming) && (r._start += n / r._ts, r._time -= n, r._tTime -= n), r.shiftChildren(-n, !1, -1e20), l = 0), a < (i = F(o)) && o._ts && (a = i), o = e;
                N(r, r === ut && r._time > a ? r._time : Math.min(Dt, a), 1), r._dirty = 0
            }
            return r._tDur
        }, r.updateRoot = function(t) {
            if (ut._ts && (C(ut, D(t, ut)), gt = be.frame), be.frame >= se) {
                se += zt.autoSleep || 120;
                var e = ut._first;
                if ((!e || !e._ts) && zt.autoSleep && be._listeners.length < 2) {
                    for (; e && !e._ts;) e = e._next;
                    e || be.sleep()
                }
            }
        }, r
    }($e);

    function Ie(t, e, i, a, r, l) {
        var c, d, u, h;
        if (ie[t] && !1 !== (c = new ie[t]).init(r, c.rawVars ? e[t] : function(t, e, i, a, r) { if (s(t) && (t = Fe(t, r, e, i, a)), !o(t) || t.style && t.nodeType || Yt(t)) return n(t) ? Fe(t, r, e, i, a) : t; var l, c = {}; for (l in t) c[l] = Fe(t[l], r, e, i, a); return c }(e[t], a, r, l, i), i, a, l) && (i._pt = d = new ti(i._pt, r, t, 0, 1, c.render, c, 0, c.priority), i !== yt))
            for (u = i._ptLookup[i._targets.indexOf(r)], h = c._props.length; h--;) u[c._props[h]] = d;
        return c
    }
    M(Le.prototype, { _lock: 0, _hasPause: 0, _forcing: 0 });
    var ze, Oe = function(t, e, i, a, r, o, l, c, d) {
            s(a) && (a = a(r || 0, t, o));
            var u, p = t[e],
                f = "get" !== i ? i : s(p) ? d ? t[e.indexOf("set") || !s(t["get" + e.substr(3)]) ? e : "get" + e.substr(3)](d) : t[e]() : p,
                m = s(p) ? d ? qe : Ye : He;
            if (n(a) && (~a.indexOf("random(") && (a = J(a)), "=" === a.charAt(1) && (a = parseFloat(f) + parseFloat(a.substr(2)) * ("-" === a.charAt(0) ? -1 : 1) + (q(f) || 0))), f !== a) return isNaN(f + a) ? (p || e in t || h(e, a), function(t, e, i, n, s, a, r) {
                var o, l, c, d, u, h, p, f, m = new ti(this._pt, t, e, 0, 1, Ue, null, s),
                    v = 0,
                    g = 0;
                for (m.b = i, m.e = n, i += "", (p = ~(n += "").indexOf("random(")) && (n = J(n)), a && (a(f = [i, n], t, e), i = f[0], n = f[1]), l = i.match(Gt) || []; o = Gt.exec(n);) d = o[0], u = n.substring(v, o.index), c ? c = (c + 1) % 5 : "rgba(" === u.substr(-5) && (c = 1), d !== l[g++] && (h = parseFloat(l[g - 1]) || 0, m._pt = { _next: m._pt, p: u || 1 === g ? u : ",", s: h, c: "=" === d.charAt(1) ? parseFloat(d.substr(2)) * ("-" === d.charAt(0) ? -1 : 1) : parseFloat(d) - h, m: c && c < 4 ? Math.round : 0 }, v = Gt.lastIndex);
                return m.c = v < n.length ? n.substring(v, n.length) : "", m.fp = r, (Kt.test(n) || p) && (m.e = 0), this._pt = m
            }.call(this, t, e, f, a, m, c || zt.stringFilter, d)) : (u = new ti(this._pt, t, e, +f || 0, a - (f || 0), "boolean" == typeof p ? Ge : We, 0, m), d && (u.fp = d), l && u.modifier(l, this, t), this._pt = u)
        },
        De = function t(e, i) {
            var n, s, a, r, o, c, d, u, h, p, f, m, y = e.vars,
                b = y.ease,
                w = y.startAt,
                x = y.immediateRender,
                T = y.lazy,
                C = y.onUpdate,
                E = y.onUpdateParams,
                k = y.callbackScope,
                _ = y.runBackwards,
                P = y.yoyoEase,
                A = y.keyframes,
                L = y.autoRevert,
                z = e._dur,
                O = e._startAt,
                D = e._targets,
                F = e.parent,
                R = F && "nested" === F.data ? F.parent._targets : D,
                B = "auto" === e._overwrite,
                j = e.timeline;
            if (!j || A && b || (b = "none"), e._ease = Ee(b, Ot.ease), e._yEase = P ? Ce(Ee(!0 === P ? b : P, Ot.ease)) : 0, P && e._yoyo && !e._repeat && (P = e._yEase, e._yEase = e._ease, e._ease = P), !j) {
                if (O && O.render(-1, !0).kill(), w) {
                    if (I(e._startAt = je.set(D, M({ data: "isStart", overwrite: !1, parent: F, immediateRender: !0, lazy: l(T), startAt: null, delay: 0, onUpdate: C, onUpdateParams: E, callbackScope: k, stagger: 0 }, w))), x)
                        if (0 < i) L || (e._startAt = 0);
                        else if (z) return
                } else if (_ && z)
                    if (O) L || (e._startAt = 0);
                    else if (i && (x = !1), I(e._startAt = je.set(D, oe($(y, Jt), { overwrite: !1, data: "isFromStart", lazy: x && l(T), immediateRender: x, stagger: 0, parent: F }))), x) { if (!i) return } else t(e._startAt, Ft);
                for (n = $(y, Jt), m = (u = D[e._pt = 0] ? g(D[0]).harness : 0) && y[u.prop], T = z && l(T) || T && !z, s = 0; s < D.length; s++) {
                    if (d = (o = D[s])._gsap || v(D)[s]._gsap, e._ptLookup[s] = p = {}, ee[d.id] && S(), f = R === D ? s : R.indexOf(o), u && !1 !== (h = new u).init(o, m || n, e, f, R) && (e._pt = r = new ti(e._pt, o, h.name, 0, 1, h.render, h, 0, h.priority), h._props.forEach((function(t) { p[t] = r })), h.priority && (c = 1)), !u || m)
                        for (a in n) ie[a] && (h = Ie(a, n, e, f, o, R)) ? h.priority && (c = 1) : p[a] = r = Oe.call(e, o, a, "get", n[a], f, R, 0, y.stringFilter);
                    e._op && e._op[s] && e.kill(o, e._op[s]), B && e._pt && (ze = e, ut.killTweensOf(o, p, "started"), ze = 0), e._pt && T && (ee[d.id] = 1)
                }
                c && Je(e), e._onInit && e._onInit(e)
            }
            e._from = !j && !!y.runBackwards, e._onUpdate = C, e._initted = 1
        },
        Fe = function(t, e, i, a, r) { return s(t) ? t.call(e, i, a, r) : n(t) && ~t.indexOf("random(") ? J(t) : t },
        Re = re + "repeat,repeatDelay,yoyo,repeatRefresh,yoyoEase",
        Be = (Re + ",id,stagger,delay,duration,paused").split(","),
        je = function(t) {
            function s(e, n, s, r) {
                var c;
                "number" == typeof n && (s.duration = n, n = s, s = null);
                var u, h, f, g, y, b, w, x, T = (c = t.call(this, r ? n : A(n), s) || this).vars,
                    S = T.duration,
                    C = T.delay,
                    E = T.immediateRender,
                    k = T.stagger,
                    _ = T.overwrite,
                    P = T.keyframes,
                    $ = T.defaults,
                    L = c.parent,
                    I = (Yt(e) ? a(e[0]) : "length" in n) ? [e] : he(e);
                if (c._targets = I.length ? v(I) : p("GSAP target " + e + " not found. https://greensock.com", !zt.nullTargetWarn) || [], c._ptLookup = [], c._overwrite = _, P || k || d(S) || d(C)) {
                    if (n = c.vars, (u = c.timeline = new Le({ data: "nested", defaults: $ || {} })).kill(), u.parent = i(c), P) M(u.vars.defaults, { ease: "none" }), P.forEach((function(t) { return u.to(I, t, ">") }));
                    else {
                        if (g = I.length, w = k ? G(k) : m, o(k))
                            for (y in k) ~Re.indexOf(y) && ((x = x || {})[y] = k[y]);
                        for (h = 0; h < g; h++) {
                            for (y in f = {}, n) Be.indexOf(y) < 0 && (f[y] = n[y]);
                            f.stagger = 0, x && oe(f, x), n.yoyoEase && !n.repeat && (f.yoyoEase = n.yoyoEase), b = I[h], f.duration = +Fe(S, i(c), h, b, I), f.delay = (+Fe(C, i(c), h, b, I) || 0) - c._delay, !k && 1 === g && f.delay && (c._delay = C = f.delay, c._start += C, f.delay = 0), u.to(b, f, w(h, b, I))
                        }
                        S = C = 0
                    }
                    S || c.duration(S = u.duration())
                } else c.timeline = 0;
                return !0 === _ && (ze = i(c), ut.killTweensOf(I), ze = 0), L && R(L, i(c)), (E || !S && !P && c._start === L._time && l(E) && function t(e) { return !e || e._ts && t(e.parent) }(i(c)) && "nested" !== L.data) && (c._tTime = -Ft, c.render(Math.max(0, -C))), c
            }
            e(s, t);
            var r = s.prototype;
            return r.render = function(t, e, i) {
                var n, s, a, r, o, l, c, d, u, h = this._time,
                    p = this._tDur,
                    f = this._dur,
                    m = p - Ft < t && 0 <= t ? p : t < Ft ? 0 : t;
                if (f) {
                    if (m !== this._tTime || !t || i || this._startAt && this._zTime < 0 != t < 0) {
                        if (n = m, d = this.timeline, this._repeat) {
                            if ((f < (n = w(m % (r = f + this._rDelay))) || p === m) && (n = f), (a = ~~(m / r)) && a === m / r && (n = f, a--), (l = this._yoyo && 1 & a) && (u = this._yEase, n = f - n), o = le(this._tTime, r), n === h && !i && this._initted) return this;
                            a !== o && (!this.vars.repeatRefresh || l || this._lock || (this._lock = i = 1, this.render(r * a, !0).invalidate()._lock = 0))
                        }
                        if (!this._initted && j(this, n, i, e)) return this._tTime = 0, this;
                        for (this._tTime = m, this._time = n, !this._act && this._ts && (this._act = 1, this._lazy = 0), this.ratio = c = (u || this._ease)(n / f), this._from && (this.ratio = c = 1 - c), h || !n || e || fe(this, "onStart"), s = this._pt; s;) s.r(c, s.d), s = s._next;
                        d && d.render(t < 0 ? t : !n && l ? -Ft : d._dur * c, e, i) || this._startAt && (this._zTime = t), this._onUpdate && !e && (t < 0 && this._startAt && this._startAt.render(t, !0, i), fe(this, "onUpdate")), this._repeat && a !== o && this.vars.onRepeat && !e && this.parent && fe(this, "onRepeat"), m !== this._tDur && m || this._tTime !== m || (t < 0 && this._startAt && !this._onUpdate && this._startAt.render(t, !0, i), !t && f || !(t && 0 < this._ts || !m && this._ts < 0) || I(this, 1), e || t < 0 && !h || m < p && 0 < this.timeScale() || (fe(this, m === p ? "onComplete" : "onReverseComplete", !0), this._prom && this._prom()))
                    }
                } else ! function(t, e, i, n) {
                    var s, a = t._zTime < 0 ? 0 : 1,
                        r = e < 0 ? 0 : 1,
                        o = t._rDelay,
                        l = 0;
                    if (o && t._repeat && (l = de(0, t._tDur, e), le(l, o) !== le(t._tTime, o) && (a = 1 - r, t.vars.repeatRefresh && t._initted && t.invalidate())), (t._initted || !j(t, e, n, i)) && (r !== a || n || t._zTime === Ft || !e && t._zTime)) { for (t._zTime = e || (i ? Ft : 0), t.ratio = r, t._from && (r = 1 - r), t._time = 0, t._tTime = l, i || fe(t, "onStart"), s = t._pt; s;) s.r(r, s.d), s = s._next;!r && t._startAt && !t._onUpdate && t._start && t._startAt.render(e, !0, n), t._onUpdate && (i || fe(t, "onUpdate")), l && t._repeat && !i && t.parent && fe(t, "onRepeat"), (e >= t._tDur || e < 0) && t.ratio === r && (t.ratio && I(t, 1), i || (fe(t, t.ratio ? "onComplete" : "onReverseComplete", !0), t._prom && t._prom())) }
                }(this, t, e, i);
                return this
            }, r.targets = function() { return this._targets }, r.invalidate = function() { return this._pt = this._op = this._startAt = this._onUpdate = this._act = this._lazy = 0, this._ptLookup = [], this.timeline && this.timeline.invalidate(), t.prototype.invalidate.call(this) }, r.kill = function(t, e) {
                if (void 0 === e && (e = "all"), !(t || e && "all" !== e) && (this._lazy = 0, this.parent)) return et(this);
                if (this.timeline) return this.timeline.killTweensOf(t, e, ze && !0 !== ze.vars.overwrite), this;
                var i, s, a, r, o, l, c, d = this._targets,
                    u = t ? he(t) : d,
                    h = this._ptLookup,
                    p = this._pt;
                if ((!e || "all" === e) && function(t, e) { for (var i = t.length, n = i === e.length; n && i-- && t[i] === e[i];); return i < 0 }(d, u)) return et(this);
                for (i = this._op = this._op || [], "all" !== e && (n(e) && (o = {}, b(e, (function(t) { return o[t] = 1 })), e = o), e = function(t, e) {
                        var i, n, s, a, r = t[0] ? g(t[0]).harness : 0,
                            o = r && r.aliases;
                        if (!o) return e;
                        for (n in i = oe({}, e), o)
                            if (n in i)
                                for (s = (a = o[n].split(",")).length; s--;) i[a[s]] = i[n];
                        return i
                    }(d, e)), c = d.length; c--;)
                    if (~u.indexOf(d[c]))
                        for (o in s = h[c], "all" === e ? (i[c] = e, r = s, a = {}) : (a = i[c] = i[c] || {}, r = e), r)(l = s && s[o]) && ("kill" in l.d && !0 !== l.d.kill(o) || L(this, l, "_pt"), delete s[o]), "all" !== a && (a[o] = 1);
                return this._initted && !this._pt && p && et(this), this
            }, s.to = function(t, e, i) { return new s(t, e, i) }, s.from = function(t, e) { return new s(t, T(arguments, 1)) }, s.delayedCall = function(t, e, i, n) { return new s(e, 0, { immediateRender: !1, lazy: !1, overwrite: !1, delay: t, onComplete: e, onReverseComplete: e, onCompleteParams: i, onReverseCompleteParams: i, callbackScope: n }) }, s.fromTo = function(t, e, i) { return new s(t, T(arguments, 2)) }, s.set = function(t, e) { return e.duration = 0, e.repeatDelay || (e.repeat = 0), new s(t, e) }, s.killTweensOf = function(t, e, i) { return ut.killTweensOf(t, e, i) }, s
        }($e);

    function Ne(t, e, i) { return t.setAttribute(e, i) }

    function Ve(t, e, i, n) { n.mSet(t, e, n.m.call(n.tween, i, n.mt), n) }
    M(je.prototype, { _targets: [], _lazy: 0, _startAt: 0, _op: 0, _onInit: 0 }), b("staggerTo,staggerFrom,staggerFromTo", (function(t) {
        je[t] = function() {
            var e = new Le,
                i = ue.call(arguments, 0);
            return i.splice("staggerFromTo" === t ? 5 : 4, 0, 0), e[t].apply(e, i)
        }
    }));
    var He = function(t, e, i) { return t[e] = i },
        Ye = function(t, e, i) { return t[e](i) },
        qe = function(t, e, i, n) { return t[e](n.fp, i) },
        Xe = function(t, e) { return s(t[e]) ? Ye : r(t[e]) && t.setAttribute ? Ne : He },
        We = function(t, e) { return e.set(e.t, e.p, Math.round(1e4 * (e.s + e.c * t)) / 1e4, e) },
        Ge = function(t, e) { return e.set(e.t, e.p, !!(e.s + e.c * t), e) },
        Ue = function(t, e) {
            var i = e._pt,
                n = "";
            if (!t && e.b) n = e.b;
            else if (1 === t && e.e) n = e.e;
            else {
                for (; i;) n = i.p + (i.m ? i.m(i.s + i.c * t) : Math.round(1e4 * (i.s + i.c * t)) / 1e4) + n, i = i._next;
                n += e.c
            }
            e.set(e.t, e.p, n, e)
        },
        Ke = function(t, e) { for (var i = e._pt; i;) i.r(t, i.d), i = i._next },
        Qe = function(t, e, i, n) { for (var s, a = this._pt; a;) s = a._next, a.p === n && a.modifier(t, e, i), a = s },
        Ze = function(t) { for (var e, i, n = this._pt; n;) i = n._next, n.p === t && !n.op || n.op === t ? L(this, n, "_pt") : n.dep || (e = 1), n = i; return !e },
        Je = function(t) {
            for (var e, i, n, s, a = t._pt; a;) {
                for (e = a._next, i = n; i && i.pr > a.pr;) i = i._next;
                (a._prev = i ? i._prev : s) ? a._prev._next = a: n = a, (a._next = i) ? i._prev = a : s = a, a = e
            }
            t._pt = n
        },
        ti = (ei.prototype.modifier = function(t, e, i) { this.mSet = this.mSet || this.set, this.set = Ve, this.m = t, this.mt = i, this.tween = e }, ei);

    function ei(t, e, i, n, s, a, r, o, l) { this.t = e, this.s = n, this.c = s, this.p = i, this.r = a || We, this.d = r || this, this.set = o || He, this.pr = l || 0, (this._next = t) && (t._prev = this) }
    b(re + "parent,duration,ease,delay,overwrite,runBackwards,startAt,yoyo,immediateRender,repeat,repeatDelay,data,paused,reversed,lazy,callbackScope,stringFilter,id,yoyoEase,stagger,inherit,repeatRefresh,keyframes,autoRevert", (function(t) { return Jt[t] = 1 })), Zt.TweenMax = Zt.TweenLite = je, Zt.TimelineLite = Zt.TimelineMax = Le, ut = new Le({ sortChildren: !1, defaults: Ot, autoRemoveChildren: !0, id: "root", smoothChildTiming: !0 }), zt.stringFilter = rt;
    var ii = {
        registerPlugin: function() {
            for (var t = arguments.length, e = new Array(t), i = 0; i < t; i++) e[i] = arguments[i];
            e.forEach((function(t) {
                return function(t) {
                    var e = (t = !t.name && t.default || t).name,
                        i = s(t),
                        n = e && !i && t.init ? function() { this._props = [] } : t,
                        a = { init: m, render: Ke, add: Oe, kill: Ze, modifier: Qe, rawVars: 0 },
                        r = { targetTest: 0, get: 0, getSetter: Xe, aliases: {}, register: 0 };
                    if (we(), t !== n) {
                        if (ie[e]) return;
                        M(n, M($(t, a), r)), oe(n.prototype, oe(a, $(t, r))), ie[n.prop = e] = n, t.targetTest && (ae.push(n), Jt[e] = 1), e = ("css" === e ? "CSS" : e.charAt(0).toUpperCase() + e.substr(1)) + "Plugin"
                    }
                    f(e, n), t.register && t.register(ai, n, ti)
                }(t)
            }))
        },
        timeline: function(t) { return new Le(t) },
        getTweensOf: function(t, e) { return ut.getTweensOf(t, e) },
        getProperty: function(t, e, i, s) {
            n(t) && (t = he(t)[0]);
            var a = g(t || {}).get,
                r = i ? k : E;
            return "native" === i && (i = ""), t ? e ? r((ie[e] && ie[e].get || a)(t, e, i, s)) : function(e, i, n) { return r((ie[e] && ie[e].get || a)(t, e, i, n)) } : t
        },
        quickSetter: function(t, e, i) {
            if (1 < (t = he(t)).length) {
                var n = t.map((function(t) { return ai.quickSetter(t, e, i) })),
                    s = n.length;
                return function(t) { for (var e = s; e--;) n[e](t) }
            }
            t = t[0] || {};
            var a = ie[e],
                r = g(t),
                o = a ? function(e) {
                    var n = new a;
                    yt._pt = 0, n.init(t, i ? e + i : e, yt, 0, [t]), n.render(1, n), yt._pt && Ke(1, yt)
                } : r.set(t, e);
            return a ? o : function(n) { return o(t, e, i ? n + i : n, r, 1) }
        },
        isTweening: function(t) { return 0 < ut.getTweensOf(t, !0).length },
        defaults: function(t) { return t && t.ease && (t.ease = Ee(t.ease, Ot.ease)), P(Ot, t || {}) },
        config: function(t) { return P(zt, t || {}) },
        registerEffect: function(t) {
            var e = t.name,
                i = t.effect,
                n = t.plugins,
                s = t.defaults,
                a = t.extendTimeline;
            (n || "").split(",").forEach((function(t) { return t && !ie[t] && !Zt[t] && p(e + " effect requires " + t + " plugin.") })), ne[e] = function(t, e) { return i(he(t), M(e || {}, s)) }, a && (Le.prototype[e] = function(t, i, n) { return this.add(ne[e](t, o(i) ? i : (n = i) && {}), n) })
        },
        registerEase: function(t, e) { xe[t] = Ee(e) },
        parseEase: function(t, e) { return arguments.length ? Ee(t, e) : xe },
        getById: function(t) { return ut.getById(t) },
        exportRoot: function(t, e) { void 0 === t && (t = {}); var i, n, s = new Le(t); for (s.smoothChildTiming = l(t.smoothChildTiming), ut.remove(s), s._dp = 0, s._time = s._tTime = ut._time, i = ut._first; i;) n = i._next, !e && !i._dur && i instanceof je && i.vars.onComplete === i._targets[0] || B(s, i, i._start - i._delay), i = n; return B(ut, s, 0), s },
        utils: {
            wrap: function t(e, i, n) { var s = i - e; return Yt(e) ? Z(e, t(0, e.length), i) : Y(n, (function(t) { return (s + (t - e) % s) % s + e })) },
            wrapYoyo: function t(e, i, n) {
                var s = i - e,
                    a = 2 * s;
                return Yt(e) ? Z(e, t(0, e.length - 1), i) : Y(n, (function(t) { return e + (s < (t = (a + (t - e) % a) % a) ? a - t : t) }))
            },
            distribute: G,
            random: Q,
            snap: K,
            normalize: function(t, e, i) { return pe(t, e, 0, 1, i) },
            getUnit: q,
            clamp: function(t, e, i) { return Y(i, (function(i) { return de(t, e, i) })) },
            splitColor: nt,
            toArray: he,
            mapRange: pe,
            pipe: function() { for (var t = arguments.length, e = new Array(t), i = 0; i < t; i++) e[i] = arguments[i]; return function(t) { return e.reduce((function(t, e) { return e(t) }), t) } },
            unitize: function(t, e) { return function(i) { return t(parseFloat(i)) + (e || q(i)) } },
            interpolate: function t(e, i, s, a) {
                var r = isNaN(e + i) ? 0 : function(t) { return (1 - t) * e + t * i };
                if (!r) {
                    var o, l, c, d, u, h = n(e),
                        p = {};
                    if (!0 === s && (a = 1) && (s = null), h) e = { p: e }, i = { p: i };
                    else if (Yt(e) && !Yt(i)) {
                        for (c = [], d = e.length, u = d - 2, l = 1; l < d; l++) c.push(t(e[l - 1], e[l]));
                        d--, r = function(t) { t *= d; var e = Math.min(u, ~~t); return c[e](t - e) }, s = i
                    } else a || (e = oe(Yt(e) ? [] : {}, e));
                    if (!c) {
                        for (o in i) Oe.call(p, e, o, "get", i[o]);
                        r = function(t) { return Ke(t, p) || (h ? e.p : e) }
                    }
                }
                return Y(s, r)
            },
            shuffle: W
        },
        install: u,
        effects: ne,
        ticker: be,
        updateRoot: Le.updateRoot,
        plugins: ie,
        globalTimeline: ut,
        core: { PropTween: ti, globals: f, Tween: je, Timeline: Le, Animation: $e, getCache: g, _removeLinkedListItem: L }
    };

    function ni(t, e) { for (var i = t._pt; i && i.p !== e && i.op !== e && i.fp !== e;) i = i._next; return i }

    function si(t, e) {
        return {
            name: t,
            rawVars: 1,
            init: function(t, i, s) {
                s._onInit = function(t) {
                    var s, a;
                    if (n(i) && (s = {}, b(i, (function(t) { return s[t] = 1 })), i = s), e) {
                        for (a in s = {}, i) s[a] = e(i[a]);
                        i = s
                    }! function(t, e) {
                        var i, n, s, a = t._targets;
                        for (i in e)
                            for (n = a.length; n--;)(s = (s = t._ptLookup[n][i]) && s.d) && (s._pt && (s = ni(s, i)), s && s.modifier && s.modifier(e[i], t, a[n], i))
                    }(t, i)
                }
            }
        }
    }
    b("to,from,fromTo,delayedCall,set,killTweensOf", (function(t) { return ii[t] = je[t] })), be.add(Le.updateRoot), yt = ii.to({}, { duration: 0 });
    var ai = ii.registerPlugin({ name: "attr", init: function(t, e, i, n, s) { for (var a in e) this.add(t, "setAttribute", (t.getAttribute(a) || 0) + "", e[a], n, s, 0, 0, a), this._props.push(a) } }, { name: "endArray", init: function(t, e) { for (var i = e.length; i--;) this.add(t, i, t[i] || 0, e[i]) } }, si("roundProps", U), si("modifiers"), si("snap", K)) || ii;

    function ri(t, e) { return e.set(e.t, e.p, Math.round(1e4 * (e.s + e.c * t)) / 1e4 + e.u, e) }

    function oi(t, e) { return e.set(e.t, e.p, 1 === t ? e.e : Math.round(1e4 * (e.s + e.c * t)) / 1e4 + e.u, e) }

    function li(t, e) { return e.set(e.t, e.p, t ? Math.round(1e4 * (e.s + e.c * t)) / 1e4 + e.u : e.b, e) }

    function ci(t, e) {
        var i = e.s + e.c * t;
        e.set(e.t, e.p, ~~(i + (i < 0 ? -.5 : .5)) + e.u, e)
    }

    function di(t, e) { return e.set(e.t, e.p, t ? e.e : e.b, e) }

    function ui(t, e) { return e.set(e.t, e.p, 1 !== t ? e.b : e.e, e) }

    function hi(t, e, i) { return t.style[e] = i }

    function pi(t, e, i) { return t.style.setProperty(e, i) }

    function fi(t, e, i) { return t._gsap[e] = i }

    function mi(t, e, i) { return t._gsap.scaleX = t._gsap.scaleY = i }

    function vi(t, e, i, n, s) {
        var a = t._gsap;
        a.scaleX = a.scaleY = i, a.renderTransform(s, a)
    }

    function gi(t, e, i, n, s) {
        var a = t._gsap;
        a[e] = i, a.renderTransform(s, a)
    }

    function yi(t, e) { var i = ji.createElementNS ? ji.createElementNS((e || "http://www.w3.org/1999/xhtml").replace(/^https/, "http"), t) : ji.createElement(t); return i.style ? i : ji.createElement(t) }

    function bi(t, e, i) { var n = getComputedStyle(t); return n[e] || n.getPropertyValue(e.replace(vn, "-$1").toLowerCase()) || n.getPropertyValue(e) || !i && bi(t, Sn(e) || e, 1) || "" }

    function wi() { "undefined" == typeof window || (Bi = window, ji = Bi.document, Ni = ji.documentElement, Hi = yi("div") || { style: {} }, Yi = yi("div"), wn = Sn(wn), xn = Sn(xn), Hi.style.cssText = "border-width:0;line-height:0;position:absolute;padding:0", Xi = !!Sn("perspective"), Vi = 1) }

    function xi(t) {
        var e, i = yi("svg", this.ownerSVGElement && this.ownerSVGElement.getAttribute("xmlns") || "http://www.w3.org/2000/svg"),
            n = this.parentNode,
            s = this.nextSibling,
            a = this.style.cssText;
        if (Ni.appendChild(i), i.appendChild(this), this.style.display = "block", t) try { e = this.getBBox(), this._gsapBBox = this.getBBox, this.getBBox = xi } catch (t) {} else this._gsapBBox && (e = this._gsapBBox());
        return n && (s ? n.insertBefore(this, s) : n.appendChild(this)), Ni.removeChild(i), this.style.cssText = a, e
    }

    function Ti(t, e) {
        for (var i = e.length; i--;)
            if (t.hasAttribute(e[i])) return t.getAttribute(e[i])
    }

    function Si(t) { var e; try { e = t.getBBox() } catch (i) { e = xi.call(t, !0) } return e && (e.width || e.height) || t.getBBox === xi || (e = xi.call(t, !0)), !e || e.width || e.x || e.y ? e : { x: +Ti(t, ["x", "cx", "x1"]) || 0, y: +Ti(t, ["y", "cy", "y1"]) || 0, width: 0, height: 0 } }

    function Ci(t) { return !(!t.getCTM || t.parentNode && !t.ownerSVGElement || !Si(t)) }

    function Ei(t, e) {
        if (e) {
            var i = t.style;
            e in hn && (e = wn), i.removeProperty ? ("ms" !== e.substr(0, 2) && "webkit" !== e.substr(0, 6) || (e = "-" + e), i.removeProperty(e.replace(vn, "-$1").toLowerCase())) : i.removeAttribute(e)
        }
    }

    function ki(t, e, i, n, s, a) { var r = new ti(t._pt, e, i, 0, 1, a ? ui : di); return (t._pt = r).b = n, r.e = s, t._props.push(i), r }

    function Mi(t, e, i, n) {
        var s, a, r, o, l = parseFloat(i) || 0,
            c = (i + "").trim().substr((l + "").length) || "px",
            d = Hi.style,
            u = gn.test(e),
            h = "svg" === t.tagName.toLowerCase(),
            p = (h ? "client" : "offset") + (u ? "Width" : "Height"),
            f = "px" === n;
        return n === c || !l || Cn[n] || Cn[c] ? l : (o = t.getCTM && Ci(t), "%" === n && (hn[e] || ~e.indexOf("adius")) ? w(l / (o ? t.getBBox()[u ? "width" : "height"] : t[p]) * 100) : (d[u ? "width" : "height"] = 100 + (f ? c : n), a = ~e.indexOf("adius") || "em" === n && t.appendChild && !h ? t : t.parentNode, o && (a = (t.ownerSVGElement || {}).parentNode), a && a !== ji && a.appendChild || (a = ji.body), (r = a._gsap) && "%" === n && r.width && u && r.time === be.time ? w(l / r.width * 100) : (a === t && (d.position = "static"), a.appendChild(Hi), s = Hi[p], a.removeChild(Hi), d.position = "absolute", u && "%" === n && ((r = g(a)).time = be.time, r.width = a[p]), w(f ? s * l / 100 : 100 / s * l))))
    }

    function _i(t, e, i, n) { var s; return Vi || wi(), e in bn && "transform" !== e && ~(e = bn[e]).indexOf(",") && (e = e.split(",")[0]), hn[e] && "transform" !== e ? (s = Pn(t, n), s = "transformOrigin" !== e ? s[e] : $n(bi(t, xn)) + " " + s.zOrigin + "px") : (s = t.style[e]) && "auto" !== s && !n && !~(s + "").indexOf("calc(") || (s = kn[e] && kn[e](t, e, i) || bi(t, e) || y(t, e) || ("opacity" === e ? 1 : 0)), i && !~(s + "").indexOf(" ") ? Mi(t, e, s, i) + i : s }

    function Pi(t, e, i, n) {
        if (!i || "none" === i) {
            var s = Sn(e, t, 1),
                a = s && bi(t, s, 1);
            a && a !== i && (e = s, i = a)
        }
        var r, o, l, c, d, u, h, p, f, m, v, g, y = new ti(this._pt, t.style, e, 0, 1, Ue),
            b = 0,
            w = 0;
        if (y.b = i, y.e = n, i += "", "auto" == (n += "") && (t.style[e] = n, n = bi(t, e) || n, t.style[e] = i), rt(r = [i, n]), n = r[1], l = (i = r[0]).match(Wt) || [], (n.match(Wt) || []).length) {
            for (; o = Wt.exec(n);) h = o[0], f = n.substring(b, o.index), d ? d = (d + 1) % 5 : "rgba(" !== f.substr(-5) && "hsla(" !== f.substr(-5) || (d = 1), h !== (u = l[w++] || "") && (c = parseFloat(u) || 0, v = u.substr((c + "").length), (g = "=" === h.charAt(1) ? +(h.charAt(0) + "1") : 0) && (h = h.substr(2)), p = parseFloat(h), m = h.substr((p + "").length), b = Wt.lastIndex - m.length, m || (m = m || zt.units[e] || v, b === n.length && (n += m, y.e += m)), v !== m && (c = Mi(t, e, u, m) || 0), y._pt = { _next: y._pt, p: f || 1 === w ? f : ",", s: c, c: g ? g * p : p - c, m: d && d < 4 ? Math.round : 0 });
            y.c = b < n.length ? n.substring(b, n.length) : ""
        } else y.r = "display" === e && "none" === n ? ui : di;
        return Kt.test(n) && (y.e = 0), this._pt = y
    }

    function $i(t) {
        var e = t.split(" "),
            i = e[0],
            n = e[1] || "50%";
        return "top" !== i && "bottom" !== i && "left" !== n && "right" !== n || (t = i, i = n, n = t), e[0] = En[i] || i, e[1] = En[n] || n, e.join(" ")
    }

    function Ai(t, e) {
        if (e.tween && e.tween._time === e.tween._dur) {
            var i, n, s, a = e.t,
                r = a.style,
                o = e.u,
                l = a._gsap;
            if ("all" === o || !0 === o) r.cssText = "", n = 1;
            else
                for (s = (o = o.split(",")).length; - 1 < --s;) i = o[s], hn[i] && (n = 1, i = "transformOrigin" === i ? xn : wn), Ei(a, i);
            n && (Ei(a, wn), l && (l.svg && a.removeAttribute("transform"), Pn(a, 1), l.uncache = 1))
        }
    }

    function Li(t) { return "matrix(1, 0, 0, 1, 0, 0)" === t || "none" === t || !t }

    function Ii(t) { var e = bi(t, wn); return Li(e) ? Mn : e.substr(7).match(Xt).map(w) }

    function zi(t, e) {
        var i, n, s, a, r = t._gsap || g(t),
            o = t.style,
            l = Ii(t);
        return r.svg && t.getAttribute("transform") ? "1,0,0,1,0,0" === (l = [(s = t.transform.baseVal.consolidate().matrix).a, s.b, s.c, s.d, s.e, s.f]).join(",") ? Mn : l : (l !== Mn || t.offsetParent || t === Ni || r.svg || (s = o.display, o.display = "block", (i = t.parentNode) && t.offsetParent || (a = 1, n = t.nextSibling, Ni.appendChild(t)), l = Ii(t), s ? o.display = s : Ei(t, "display"), a && (n ? i.insertBefore(t, n) : i ? i.appendChild(t) : Ni.removeChild(t))), e && 6 < l.length ? [l[0], l[1], l[4], l[5], l[12], l[13]] : l)
    }

    function Oi(t, e, i, n, s, a) {
        var r, o, l, c = t._gsap,
            d = s || zi(t, !0),
            u = c.xOrigin || 0,
            h = c.yOrigin || 0,
            p = c.xOffset || 0,
            f = c.yOffset || 0,
            m = d[0],
            v = d[1],
            g = d[2],
            y = d[3],
            b = d[4],
            w = d[5],
            x = e.split(" "),
            T = parseFloat(x[0]) || 0,
            S = parseFloat(x[1]) || 0;
        i ? d !== Mn && (o = m * y - v * g) && (l = T * (-v / o) + S * (m / o) - (m * w - v * b) / o, T = T * (y / o) + S * (-g / o) + (g * w - y * b) / o, S = l) : (T = (r = Si(t)).x + (~x[0].indexOf("%") ? T / 100 * r.width : T), S = r.y + (~(x[1] || x[0]).indexOf("%") ? S / 100 * r.height : S)), n || !1 !== n && c.smooth ? (b = T - u, w = S - h, c.xOffset = p + (b * m + w * g) - b, c.yOffset = f + (b * v + w * y) - w) : c.xOffset = c.yOffset = 0, c.xOrigin = T, c.yOrigin = S, c.smooth = !!n, c.origin = e, c.originIsAbsolute = !!i, t.style[xn] = "0px 0px", a && (ki(a, c, "xOrigin", u, T), ki(a, c, "yOrigin", h, S), ki(a, c, "xOffset", p, c.xOffset), ki(a, c, "yOffset", f, c.yOffset)), t.setAttribute("data-svg-origin", T + " " + S)
    }

    function Di(t, e, i) { var n = q(e); return w(parseFloat(e) + parseFloat(Mi(t, "x", i + "px", n))) + n }

    function Fi(t, e, i, s, a, r) {
        var o, l, c = 360,
            d = n(a),
            u = parseFloat(a) * (d && ~a.indexOf("rad") ? pn : 1),
            h = r ? u * r : u - s,
            p = s + h + "deg";
        return d && ("short" === (o = a.split("_")[1]) && (h %= c) != h % 180 && (h += h < 0 ? c : -c), "cw" === o && h < 0 ? h = (h + 36e9) % c - ~~(h / c) * c : "ccw" === o && 0 < h && (h = (h - 36e9) % c - ~~(h / c) * c)), t._pt = l = new ti(t._pt, e, i, s, h, oi), l.e = p, l.u = "deg", t._props.push(i), l
    }

    function Ri(t, e, i) {
        var n, s, a, r, o, l, c, d = Yi.style,
            u = i._gsap;
        for (s in d.cssText = getComputedStyle(i).cssText + ";position:absolute;display:block;", d[wn] = e, ji.body.appendChild(Yi), n = Pn(Yi, 1), hn)(a = u[s]) !== (r = n[s]) && "perspective,force3D,transformOrigin,svgOrigin".indexOf(s) < 0 && (o = q(a) !== (c = q(r)) ? Mi(i, s, a, c) : parseFloat(a), l = parseFloat(r), t._pt = new ti(t._pt, u, s, o, l - o, ri), t._pt.u = c || 0, t._props.push(s));
        ji.body.removeChild(Yi)
    }
    je.version = Le.version = ai.version = "3.2.4", vt = 1, c() && we();
    var Bi, ji, Ni, Vi, Hi, Yi, qi, Xi, Wi = xe.Power0,
        Gi = xe.Power1,
        Ui = xe.Power2,
        Ki = xe.Power3,
        Qi = xe.Power4,
        Zi = xe.Linear,
        Ji = xe.Quad,
        tn = xe.Cubic,
        en = xe.Quart,
        nn = xe.Quint,
        sn = xe.Strong,
        an = xe.Elastic,
        rn = xe.Back,
        on = xe.SteppedEase,
        ln = xe.Bounce,
        cn = xe.Sine,
        dn = xe.Expo,
        un = xe.Circ,
        hn = {},
        pn = 180 / Math.PI,
        fn = Math.PI / 180,
        mn = Math.atan2,
        vn = /([A-Z])/g,
        gn = /(?:left|right|width|margin|padding|x)/i,
        yn = /[\s,\(]\S/,
        bn = { autoAlpha: "opacity,visibility", scale: "scaleX,scaleY", alpha: "opacity" },
        wn = "transform",
        xn = wn + "Origin",
        Tn = "O,Moz,ms,Ms,Webkit".split(","),
        Sn = function(t, e, i) {
            var n = (e || Hi).style,
                s = 5;
            if (t in n && !i) return t;
            for (t = t.charAt(0).toUpperCase() + t.substr(1); s-- && !(Tn[s] + t in n););
            return s < 0 ? null : (3 === s ? "ms" : 0 <= s ? Tn[s] : "") + t
        },
        Cn = { deg: 1, rad: 1, turn: 1 },
        En = { top: "0%", bottom: "100%", left: "0%", right: "100%", center: "50%" },
        kn = { clearProps: function(t, e, i, n, s) { if ("isFromStart" !== s.data) { var a = t._pt = new ti(t._pt, e, i, 0, 0, Ai); return a.u = n, a.pr = -10, a.tween = s, t._props.push(i), 1 } } },
        Mn = [1, 0, 0, 1, 0, 0],
        _n = {},
        Pn = function(t, e) {
            var i = t._gsap || new Pe(t);
            if ("x" in i && !e && !i.uncache) return i;
            var n, s, a, r, o, l, c, d, u, h, p, f, m, v, g, y, b, x, T, S, C, E, k, M, _, P, $, A, L, I, z, O, D = t.style,
                F = i.scaleX < 0,
                R = "deg",
                B = bi(t, xn) || "0";
            return n = s = a = l = c = d = u = h = p = 0, r = o = 1, i.svg = !(!t.getCTM || !Ci(t)), v = zi(t, i.svg), i.svg && (M = !i.uncache && t.getAttribute("data-svg-origin"), Oi(t, M || B, !!M || i.originIsAbsolute, !1 !== i.smooth, v)), f = i.xOrigin || 0, m = i.yOrigin || 0, v !== Mn && (x = v[0], T = v[1], S = v[2], C = v[3], n = E = v[4], s = k = v[5], 6 === v.length ? (r = Math.sqrt(x * x + T * T), o = Math.sqrt(C * C + S * S), l = x || T ? mn(T, x) * pn : 0, (u = S || C ? mn(S, C) * pn + l : 0) && (o *= Math.cos(u * fn)), i.svg && (n -= f - (f * x + m * S), s -= m - (f * T + m * C))) : (O = v[6], I = v[7], $ = v[8], A = v[9], L = v[10], z = v[11], n = v[12], s = v[13], a = v[14], c = (g = mn(O, L)) * pn, g && (M = E * (y = Math.cos(-g)) + $ * (b = Math.sin(-g)), _ = k * y + A * b, P = O * y + L * b, $ = E * -b + $ * y, A = k * -b + A * y, L = O * -b + L * y, z = I * -b + z * y, E = M, k = _, O = P), d = (g = mn(-S, L)) * pn, g && (y = Math.cos(-g), z = C * (b = Math.sin(-g)) + z * y, x = M = x * y - $ * b, T = _ = T * y - A * b, S = P = S * y - L * b), l = (g = mn(T, x)) * pn, g && (M = x * (y = Math.cos(g)) + T * (b = Math.sin(g)), _ = E * y + k * b, T = T * y - x * b, k = k * y - E * b, x = M, E = _), c && 359.9 < Math.abs(c) + Math.abs(l) && (c = l = 0, d = 180 - d), r = w(Math.sqrt(x * x + T * T + S * S)), o = w(Math.sqrt(k * k + O * O)), g = mn(E, k), u = 2e-4 < Math.abs(g) ? g * pn : 0, p = z ? 1 / (z < 0 ? -z : z) : 0), i.svg && (v = t.getAttribute("transform"), i.forceCSS = t.setAttribute("transform", "") || !Li(bi(t, wn)), v && t.setAttribute("transform", v))), 90 < Math.abs(u) && Math.abs(u) < 270 && (F ? (r *= -1, u += l <= 0 ? 180 : -180, l += l <= 0 ? 180 : -180) : (o *= -1, u += u <= 0 ? 180 : -180)), i.x = ((i.xPercent = n && Math.round(t.offsetWidth / 2) === Math.round(-n) ? -50 : 0) ? 0 : n) + "px", i.y = ((i.yPercent = s && Math.round(t.offsetHeight / 2) === Math.round(-s) ? -50 : 0) ? 0 : s) + "px", i.z = a + "px", i.scaleX = w(r), i.scaleY = w(o), i.rotation = w(l) + R, i.rotationX = w(c) + R, i.rotationY = w(d) + R, i.skewX = u + R, i.skewY = h + R, i.transformPerspective = p + "px", (i.zOrigin = parseFloat(B.split(" ")[2]) || 0) && (D[xn] = $n(B)), i.xOffset = i.yOffset = 0, i.force3D = zt.force3D, i.renderTransform = i.svg ? Dn : Xi ? On : An, i.uncache = 0, i
        },
        $n = function(t) { return (t = t.split(" "))[0] + " " + t[1] },
        An = function(t, e) { e.z = "0px", e.rotationY = e.rotationX = "0deg", e.force3D = 0, On(t, e) },
        Ln = "0deg",
        In = "0px",
        zn = ") ",
        On = function(t, e) {
            var i = e || this,
                n = i.xPercent,
                s = i.yPercent,
                a = i.x,
                r = i.y,
                o = i.z,
                l = i.rotation,
                c = i.rotationY,
                d = i.rotationX,
                u = i.skewX,
                h = i.skewY,
                p = i.scaleX,
                f = i.scaleY,
                m = i.transformPerspective,
                v = i.force3D,
                g = i.target,
                y = i.zOrigin,
                b = "",
                w = "auto" === v && t && 1 !== t || !0 === v;
            if (y && (d !== Ln || c !== Ln)) {
                var x, T = parseFloat(c) * fn,
                    S = Math.sin(T),
                    C = Math.cos(T);
                T = parseFloat(d) * fn, a = Di(g, a, S * (x = Math.cos(T)) * -y), r = Di(g, r, -Math.sin(T) * -y), o = Di(g, o, C * x * -y + y)
            }
            m !== In && (b += "perspective(" + m + zn), (n || s) && (b += "translate(" + n + "%, " + s + "%) "), !w && a === In && r === In && o === In || (b += o !== In || w ? "translate3d(" + a + ", " + r + ", " + o + ") " : "translate(" + a + ", " + r + zn), l !== Ln && (b += "rotate(" + l + zn), c !== Ln && (b += "rotateY(" + c + zn), d !== Ln && (b += "rotateX(" + d + zn), u === Ln && h === Ln || (b += "skew(" + u + ", " + h + zn), 1 === p && 1 === f || (b += "scale(" + p + ", " + f + zn), g.style[wn] = b || "translate(0, 0)"
        },
        Dn = function(t, e) {
            var i, n, s, a, r, o = e || this,
                l = o.xPercent,
                c = o.yPercent,
                d = o.x,
                u = o.y,
                h = o.rotation,
                p = o.skewX,
                f = o.skewY,
                m = o.scaleX,
                v = o.scaleY,
                g = o.target,
                y = o.xOrigin,
                b = o.yOrigin,
                x = o.xOffset,
                T = o.yOffset,
                S = o.forceCSS,
                C = parseFloat(d),
                E = parseFloat(u);
            h = parseFloat(h), p = parseFloat(p), (f = parseFloat(f)) && (p += f = parseFloat(f), h += f), h || p ? (h *= fn, p *= fn, i = Math.cos(h) * m, n = Math.sin(h) * m, s = Math.sin(h - p) * -v, a = Math.cos(h - p) * v, p && (f *= fn, r = Math.tan(p - f), s *= r = Math.sqrt(1 + r * r), a *= r, f && (r = Math.tan(f), i *= r = Math.sqrt(1 + r * r), n *= r)), i = w(i), n = w(n), s = w(s), a = w(a)) : (i = m, a = v, n = s = 0), (C && !~(d + "").indexOf("px") || E && !~(u + "").indexOf("px")) && (C = Mi(g, "x", d, "px"), E = Mi(g, "y", u, "px")), (y || b || x || T) && (C = w(C + y - (y * i + b * s) + x), E = w(E + b - (y * n + b * a) + T)), (l || c) && (C = w(C + l / 100 * (r = g.getBBox()).width), E = w(E + c / 100 * r.height)), r = "matrix(" + i + "," + n + "," + s + "," + a + "," + C + "," + E + ")", g.setAttribute("transform", r), S && (g.style[wn] = r)
        };
    b("padding,margin,Width,Radius", (function(t, e) {
        var i = "Right",
            n = "Bottom",
            s = "Left",
            a = (e < 3 ? ["Top", i, n, s] : ["Top" + s, "Top" + i, n + i, n + s]).map((function(i) { return e < 2 ? t + i : "border" + i + t }));
        kn[1 < e ? "border" + t : t] = function(t, e, i, n, s) {
            var r, o;
            if (arguments.length < 4) return r = a.map((function(e) { return _i(t, e, i) })), 5 === (o = r.join(" ")).split(r[0]).length ? r[0] : o;
            r = (n + "").split(" "), o = {}, a.forEach((function(t, e) { return o[t] = r[e] = r[e] || r[(e - 1) / 2 | 0] })), t.init(e, o, s)
        }
    }));
    var Fn, Rn, Bn = {
        name: "css",
        register: wi,
        targetTest: function(t) { return t.style && t.nodeType },
        init: function(t, e, i, n, s) {
            var a, r, o, l, c, d, u, p, f, m, v, g, y, b, w, x = this._props,
                T = t.style;
            for (u in Vi || wi(), e)
                if ("autoRound" !== u && (r = e[u], !ie[u] || !Ie(u, e, i, n, t, s)))
                    if (c = typeof r, d = kn[u], "function" === c && (c = typeof(r = r.call(i, n, t, s))), "string" === c && ~r.indexOf("random(") && (r = J(r)), d) d(this, t, u, r, i) && (w = 1);
                    else if ("--" === u.substr(0, 2)) this.add(T, "setProperty", getComputedStyle(t).getPropertyValue(u) + "", r + "", n, s, 0, 0, u);
            else {
                if (a = _i(t, u), l = parseFloat(a), (m = "string" === c && "=" === r.charAt(1) ? +(r.charAt(0) + "1") : 0) && (r = r.substr(2)), o = parseFloat(r), u in bn && ("autoAlpha" === u && (1 === l && "hidden" === _i(t, "visibility") && o && (l = 0), ki(this, T, "visibility", l ? "inherit" : "hidden", o ? "inherit" : "hidden", !o)), "scale" !== u && "transform" !== u && ~(u = bn[u]).indexOf(",") && (u = u.split(",")[0])), v = u in hn)
                    if (g || ((y = t._gsap).renderTransform || Pn(t), b = !1 !== e.smoothOrigin && y.smooth, (g = this._pt = new ti(this._pt, T, wn, 0, 1, y.renderTransform, y, 0, -1)).dep = 1), "scale" === u) this._pt = new ti(this._pt, y, "scaleY", y.scaleY, m ? m * o : o - y.scaleY), x.push("scaleY", u), u += "X";
                    else { if ("transformOrigin" === u) { r = $i(r), y.svg ? Oi(t, r, 0, b, 0, this) : ((f = parseFloat(r.split(" ")[2]) || 0) !== y.zOrigin && ki(this, y, "zOrigin", y.zOrigin, f), ki(this, T, u, $n(a), $n(r))); continue } if ("svgOrigin" === u) { Oi(t, r, 1, b, 0, this); continue } if (u in _n) { Fi(this, y, u, l, r, m); continue } if ("smoothOrigin" === u) { ki(this, y, "smooth", y.smooth, r); continue } if ("force3D" === u) { y[u] = r; continue } if ("transform" === u) { Ri(this, r, t); continue } }
                else u in T || (u = Sn(u) || u);
                if (v || (o || 0 === o) && (l || 0 === l) && !yn.test(r) && u in T)(p = (a + "").substr((l + "").length)) !== (f = (r + "").substr(((o = o || 0) + "").length) || (u in zt.units ? zt.units[u] : p)) && (l = Mi(t, u, a, f)), this._pt = new ti(this._pt, v ? y : T, u, l, m ? m * o : o - l, "px" !== f || !1 === e.autoRound || v ? ri : ci), this._pt.u = f || 0, p !== f && (this._pt.b = a, this._pt.r = li);
                else if (u in T) Pi.call(this, t, u, a, r);
                else {
                    if (!(u in t)) { h(u, r); continue }
                    this.add(t, u, t[u], r, n, s)
                }
                x.push(u)
            }
            w && Je(this)
        },
        get: _i,
        aliases: bn,
        getSetter: function(t, e, i) { var n = bn[e]; return n && n.indexOf(",") < 0 && (e = n), e in hn && e !== xn && (t._gsap.x || _i(t, "x")) ? i && qi === i ? "scale" === e ? mi : fi : (qi = i || {}) && ("scale" === e ? vi : gi) : t.style && !r(t.style[e]) ? hi : ~e.indexOf("-") ? pi : Xe(t, e) },
        core: { _removeProperty: Ei, _getMatrix: zi }
    };
    ai.utils.checkPrefix = Sn, Rn = b("x,y,z,scale,scaleX,scaleY,xPercent,yPercent" + "," + (Fn = "rotation,rotationX,rotationY,skewX,skewY") + ",transform,transformOrigin,svgOrigin,force3D,smoothOrigin,transformPerspective", (function(t) { hn[t] = 1 })), b(Fn, (function(t) { zt.units[t] = "deg", _n[t] = 1 })), bn[Rn[13]] = "x,y,z,scale,scaleX,scaleY,xPercent,yPercent," + Fn, b("0:translateX,1:translateY,2:translateZ,8:rotate,8:rotationZ,8:rotateZ,9:rotateX,10:rotateY", (function(t) {
        var e = t.split(":");
        bn[e[1]] = Rn[e[0]]
    })), b("x,y,z,top,right,bottom,left,width,height,fontSize,padding,margin,perspective", (function(t) { zt.units[t] = "px" })), ai.registerPlugin(Bn);
    var jn = ai.registerPlugin(Bn) || ai,
        Nn = jn.core.Tween;
    t.Back = rn, t.Bounce = ln, t.CSSPlugin = Bn, t.Circ = un, t.Cubic = tn, t.Elastic = an, t.Expo = dn, t.Linear = Zi, t.Power0 = Wi, t.Power1 = Gi, t.Power2 = Ui, t.Power3 = Ki, t.Power4 = Qi, t.Quad = Ji, t.Quart = en, t.Quint = nn, t.Sine = cn, t.SteppedEase = on, t.Strong = sn, t.TimelineLite = Le, t.TimelineMax = Le, t.TweenLite = je, t.TweenMax = Nn, t.default = jn, t.gsap = jn, "undefined" == typeof window || window !== t ? Object.defineProperty(t, "__esModule", { value: !0 }) : delete t.default
})),
function(t) {
    "use strict";
    var e, i, n, s, a, r, o, l, c, d, u, h, p, f = (e = "dimas-breadcrumb", i = "dimas-js-enabled", n = "dimas-with-ul", s = "dimas-arrows", t(window).on("load", (function() { t("body").children().on("click.superclick", (function() { t(".dimas-js-enabled").superclick("reset") })) })), a = function(t, e) {
        var n = i;
        e.cssArrows && (n += " " + s), t.toggleClass(n)
    }, r = function(t, e) { t.children(e.actionElement).toggleClass(n) }, o = function(t) {
        var e = t.css("ms-touch-action");
        e = "pan-y" === e ? "auto" : "pan-y", t.css("ms-touch-action", e)
    }, l = function(e) {
        var i, n = t(this),
            s = n.siblings(e.data.popUpSelector);
        if (s.length) return i = s.is(":hidden") ? c : d, t.proxy(i, n.parent("li"))(), i != c
    }, c = function() {
        var e = t(this);
        p(e), e.siblings().superclick("hide").end().superclick("show")
    }, d = function() {
        var e = t(this),
            i = p(e);
        t.proxy(u, e, i)()
    }, u = function(e) { e.retainPath = t.inArray(this[0], e.$path) > -1, this.superclick("hide"), this.parents("." + e.activeClass).length || (e.onIdle.call(h(this)), e.$path.length && t.proxy(c, e.$path)()) }, h = function(t) { return t.closest("." + i) }, p = function(t) { return h(t).data("dimas-options") }, {
        hide: function(e) {
            if (this.length) {
                var i = p(this);
                if (!i) return this;
                var n = !0 === i.retainPath ? i.$path : "",
                    s = this.find("li." + i.activeClass).add(this).not(n).removeClass(i.activeClass).children(i.popUpSelector),
                    a = i.speedOut;
                e && (s.show(), a = 0), i.retainPath = !1, i.onBeforeHide.call(s), s.stop(!0, !0).animate(i.animationOut, a, (function() {
                    var e = t(this);
                    i.onHide.call(e)
                }))
            }
            return this
        },
        show: function() { var t = p(this); if (!t) return this; var e = this.addClass(t.activeClass).children(t.popUpSelector); return t.onBeforeShow.call(e), e.stop(!0, !0).animate(t.animation, t.speed, (function() { t.onShow.call(e) })), this },
        destroy: function() {
            return this.each((function() {
                var i, n = t(this),
                    s = n.data("dimas-options");
                if (!s) return !1;
                i = n.find(s.popUpSelector).parent("li"), a(n, s), r(i, s), o(n), n.off(".superclick"), i.children(s.popUpSelector).attr("style", (function(t, e) { return e.replace(/display[^;]+;?/g, "") })), s.$path.removeClass(s.activeClass + " " + e).addClass(s.pathClass), n.find("." + s.activeClass).removeClass(s.activeClass), s.onDestroy.call(n), n.removeData("dimas-options")
            }))
        },
        reset: function() {
            return this.each((function() {
                var e = t(this),
                    i = p(e);
                t(e.find("." + i.activeClass).toArray().reverse()).children(i.actionElement).trigger("click")
            }))
        },
        init: function(i) {
            return this.each((function() {
                var n = t(this);
                if (n.data("dimas-options")) return !1;
                var s = t.extend({}, t.fn.superclick.defaults, i),
                    c = n.find(s.popUpSelector).parent("li");
                s.$path = function(i, n) { return i.find("li." + n.pathClass).slice(0, n.pathLevels).addClass(n.activeClass + " " + e).filter((function() { return t(this).children(n.popUpSelector).hide().show().length })).removeClass(n.pathClass) }(n, s), n.data("dimas-options", s), a(n, s), r(c, s), o(n), n.on("click.superclick", s.actionElement, s, l), c.not("." + e).superclick("hide", !0), s.onInit.call(this)
            }))
        }
    });
    t.fn.superclick = function(e, i) { return f[e] ? f[e].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof e && e ? t.error("Method " + e + " does not exist on jQuery.fn.superclick") : f.init.apply(this, arguments) }, t.fn.superclick.defaults = { popUpSelector: "ul,.dimas-mega", activeClass: "sfHover", pathClass: "overrideThisToUse", pathLevels: 1, actionElement: "a", animation: { opacity: "show" }, animationOut: { opacity: "hide" }, speed: "normal", speedOut: "fast", cssArrows: !0, onInit: t.noop, onBeforeShow: t.noop, onShow: t.noop, onBeforeHide: t.noop, onHide: t.noop, onIdle: t.noop, onDestroy: t.noop }
}(jQuery)