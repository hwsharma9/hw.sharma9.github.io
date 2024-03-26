<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>e-Shiksha - Gov. of Madhya Pradesh</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/img/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/img/favicon-32x32.png') }}" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('frontend/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <script>
        /*! modernizr 3.6.0 (Custom Build) | MIT *
         * https://modernizr.com/download/?-objectfit-touchevents-mq-setclasses-shiv !*/
        ! function(e, t, n) {
            function r(e, t) {
                return typeof e === t
            }

            function o() {
                var e, t, n, o, i, a, s;
                for (var l in C)
                    if (C.hasOwnProperty(l)) {
                        if (e = [], t = C[l], t.name && (e.push(t.name.toLowerCase()), t.options && t.options.aliases && t
                                .options.aliases.length))
                            for (n = 0; n < t.options.aliases.length; n++) e.push(t.options.aliases[n].toLowerCase());
                        for (o = r(t.fn, "function") ? t.fn() : t.fn, i = 0; i < e.length; i++) a = e[i], s = a.split("."),
                            1 === s.length ? Modernizr[s[0]] = o : (!Modernizr[s[0]] || Modernizr[s[
                                0]] instanceof Boolean || (Modernizr[s[0]] = new Boolean(Modernizr[s[0]])), Modernizr[s[
                                0]][
                                s[1]
                            ] = o), y.push((o ? "" : "no-") + s.join("-"))
                    }
            }

            function i(e) {
                var t = b.className,
                    n = Modernizr._config.classPrefix || "";
                if (E && (t = t.baseVal), Modernizr._config.enableJSClass) {
                    var r = new RegExp("(^|\\s)" + n + "no-js(\\s|$)");
                    t = t.replace(r, "$1" + n + "js$2")
                }
                Modernizr._config.enableClasses && (t += " " + n + e.join(" " + n), E ? b.className.baseVal = t : b
                    .className = t)
            }

            function a() {
                return "function" != typeof t.createElement ? t.createElement(arguments[0]) : E ? t.createElementNS.call(t,
                    "http://www.w3.org/2000/svg", arguments[0]) : t.createElement.apply(t, arguments)
            }

            function s() {
                var e = t.body;
                return e || (e = a(E ? "svg" : "body"), e.fake = !0), e
            }

            function l(e, n, r, o) {
                var i, l, u, c, f = "modernizr",
                    d = a("div"),
                    p = s();
                if (parseInt(r, 10))
                    for (; r--;) u = a("div"), u.id = o ? o[r] : f + (r + 1), d.appendChild(u);
                return i = a("style"), i.type = "text/css", i.id = "s" + f, (p.fake ? p : d).appendChild(i), p.appendChild(
                        d), i.styleSheet ? i.styleSheet.cssText = e : i.appendChild(t.createTextNode(e)), d.id = f, p
                    .fake && (p.style.background = "", p.style.overflow = "hidden", c = b.style.overflow, b.style.overflow =
                        "hidden", b.appendChild(p)), l = n(d, e), p.fake ? (p.parentNode.removeChild(p), b.style.overflow =
                        c, b.offsetHeight) : d.parentNode.removeChild(d), !!l
            }

            function u(e) {
                return e.replace(/([a-z])-([a-z])/g, function(e, t, n) {
                    return t + n.toUpperCase()
                }).replace(/^-/, "")
            }

            function c(e, t) {
                return !!~("" + e).indexOf(t)
            }

            function f(e, t) {
                return function() {
                    return e.apply(t, arguments)
                }
            }

            function d(e, t, n) {
                var o;
                for (var i in e)
                    if (e[i] in t) return n === !1 ? e[i] : (o = t[e[i]], r(o, "function") ? f(o, n || t) : o);
                return !1
            }

            function p(e) {
                return e.replace(/([A-Z])/g, function(e, t) {
                    return "-" + t.toLowerCase()
                }).replace(/^ms-/, "-ms-")
            }

            function m(t, n, r) {
                var o;
                if ("getComputedStyle" in e) {
                    o = getComputedStyle.call(e, t, n);
                    var i = e.console;
                    if (null !== o) r && (o = o.getPropertyValue(r));
                    else if (i) {
                        var a = i.error ? "error" : "log";
                        i[a].call(i, "getComputedStyle returning null, its possible modernizr test results are inaccurate")
                    }
                } else o = !n && t.currentStyle && t.currentStyle[r];
                return o
            }

            function h(t, r) {
                var o = t.length;
                if ("CSS" in e && "supports" in e.CSS) {
                    for (; o--;)
                        if (e.CSS.supports(p(t[o]), r)) return !0;
                    return !1
                }
                if ("CSSSupportsRule" in e) {
                    for (var i = []; o--;) i.push("(" + p(t[o]) + ":" + r + ")");
                    return i = i.join(" or "), l("@supports (" + i + ") { #modernizr { position: absolute; } }", function(
                        e) {
                        return "absolute" == m(e, null, "position")
                    })
                }
                return n
            }

            function v(e, t, o, i) {
                function s() {
                    f && (delete F.style, delete F.modElem)
                }
                if (i = r(i, "undefined") ? !1 : i, !r(o, "undefined")) {
                    var l = h(e, o);
                    if (!r(l, "undefined")) return l
                }
                for (var f, d, p, m, v, g = ["modernizr", "tspan", "samp"]; !F.style && g.length;) f = !0, F.modElem = a(g
                    .shift()), F.style = F.modElem.style;
                for (p = e.length, d = 0; p > d; d++)
                    if (m = e[d], v = F.style[m], c(m, "-") && (m = u(m)), F.style[m] !== n) {
                        if (i || r(o, "undefined")) return s(), "pfx" == t ? m : !0;
                        try {
                            F.style[m] = o
                        } catch (y) {}
                        if (F.style[m] != v) return s(), "pfx" == t ? m : !0
                    } return s(), !1
            }

            function g(e, t, n, o, i) {
                var a = e.charAt(0).toUpperCase() + e.slice(1),
                    s = (e + " " + z.join(a + " ") + a).split(" ");
                return r(t, "string") || r(t, "undefined") ? v(s, t, o, i) : (s = (e + " " + T.join(a + " ") + a).split(
                    " "), d(s, t, n))
            }
            var y = [],
                C = [],
                S = {
                    _version: "3.6.0",
                    _config: {
                        classPrefix: "",
                        enableClasses: !0,
                        enableJSClass: !0,
                        usePrefixes: !0
                    },
                    _q: [],
                    on: function(e, t) {
                        var n = this;
                        setTimeout(function() {
                            t(n[e])
                        }, 0)
                    },
                    addTest: function(e, t, n) {
                        C.push({
                            name: e,
                            fn: t,
                            options: n
                        })
                    },
                    addAsyncTest: function(e) {
                        C.push({
                            name: null,
                            fn: e
                        })
                    }
                },
                Modernizr = function() {};
            Modernizr.prototype = S, Modernizr = new Modernizr;
            var b = t.documentElement,
                E = "svg" === b.nodeName.toLowerCase();
            E || ! function(e, t) {
                function n(e, t) {
                    var n = e.createElement("p"),
                        r = e.getElementsByTagName("head")[0] || e.documentElement;
                    return n.innerHTML = "x<style>" + t + "</style>", r.insertBefore(n.lastChild, r.firstChild)
                }

                function r() {
                    var e = C.elements;
                    return "string" == typeof e ? e.split(" ") : e
                }

                function o(e, t) {
                    var n = C.elements;
                    "string" != typeof n && (n = n.join(" ")), "string" != typeof e && (e = e.join(" ")), C.elements =
                        n + " " + e, u(t)
                }

                function i(e) {
                    var t = y[e[v]];
                    return t || (t = {}, g++, e[v] = g, y[g] = t), t
                }

                function a(e, n, r) {
                    if (n || (n = t), f) return n.createElement(e);
                    r || (r = i(n));
                    var o;
                    return o = r.cache[e] ? r.cache[e].cloneNode() : h.test(e) ? (r.cache[e] = r.createElem(e))
                        .cloneNode() : r.createElem(e), !o.canHaveChildren || m.test(e) || o.tagUrn ? o : r.frag
                        .appendChild(o)
                }

                function s(e, n) {
                    if (e || (e = t), f) return e.createDocumentFragment();
                    n = n || i(e);
                    for (var o = n.frag.cloneNode(), a = 0, s = r(), l = s.length; l > a; a++) o.createElement(s[a]);
                    return o
                }

                function l(e, t) {
                    t.cache || (t.cache = {}, t.createElem = e.createElement, t.createFrag = e.createDocumentFragment, t
                        .frag = t.createFrag()), e.createElement = function(n) {
                        return C.shivMethods ? a(n, e, t) : t.createElem(n)
                    }, e.createDocumentFragment = Function("h,f",
                        "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + r().join()
                        .replace(/[\w\-:]+/g, function(e) {
                            return t.createElem(e), t.frag.createElement(e), 'c("' + e + '")'
                        }) + ");return n}")(C, t.frag)
                }

                function u(e) {
                    e || (e = t);
                    var r = i(e);
                    return !C.shivCSS || c || r.hasCSS || (r.hasCSS = !!n(e,
                        "article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}"
                    )), f || l(e, r), e
                }
                var c, f, d = "3.7.3",
                    p = e.html5 || {},
                    m = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,
                    h =
                    /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,
                    v = "_html5shiv",
                    g = 0,
                    y = {};
                ! function() {
                    try {
                        var e = t.createElement("a");
                        e.innerHTML = "<xyz></xyz>", c = "hidden" in e, f = 1 == e.childNodes.length || function() {
                            t.createElement("a");
                            var e = t.createDocumentFragment();
                            return "undefined" == typeof e.cloneNode || "undefined" == typeof e
                                .createDocumentFragment || "undefined" == typeof e.createElement
                        }()
                    } catch (n) {
                        c = !0, f = !0
                    }
                }();
                var C = {
                    elements: p.elements ||
                        "abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",
                    version: d,
                    shivCSS: p.shivCSS !== !1,
                    supportsUnknownElements: f,
                    shivMethods: p.shivMethods !== !1,
                    type: "default",
                    shivDocument: u,
                    createElement: a,
                    createDocumentFragment: s,
                    addElements: o
                };
                e.html5 = C, u(t), "object" == typeof module && module.exports && (module.exports = C)
            }("undefined" != typeof e ? e : this, t);
            var x = S._config.usePrefixes ? " -webkit- -moz- -o- -ms- ".split(" ") : ["", ""];
            S._prefixes = x;
            var _ = function() {
                var t = e.matchMedia || e.msMatchMedia;
                return t ? function(e) {
                    var n = t(e);
                    return n && n.matches || !1
                } : function(t) {
                    var n = !1;
                    return l("@media " + t + " { #modernizr { position: absolute; } }", function(t) {
                        n = "absolute" == (e.getComputedStyle ? e.getComputedStyle(t, null) : t
                            .currentStyle).position
                    }), n
                }
            }();
            S.mq = _;
            var w = S.testStyles = l;
            Modernizr.addTest("touchevents", function() {
                var n;
                if ("ontouchstart" in e || e.DocumentTouch && t instanceof DocumentTouch) n = !0;
                else {
                    var r = ["@media (", x.join("touch-enabled),("), "heartz", ")",
                        "{ #modernizr{top:9px;position:absolute}}"
                    ].join("");
                    w(r, function(e) {
                        n = 9 === e.offsetTop
                    })
                }
                return n
            });
            var j = "Moz O ms Webkit",
                z = S._config.usePrefixes ? j.split(" ") : [];
            S._cssomPrefixes = z;
            var N = function(t) {
                var r, o = x.length,
                    i = e.CSSRule;
                if ("undefined" == typeof i) return n;
                if (!t) return !1;
                if (t = t.replace(/^@/, ""), r = t.replace(/-/g, "_").toUpperCase() + "_RULE", r in i) return "@" + t;
                for (var a = 0; o > a; a++) {
                    var s = x[a],
                        l = s.toUpperCase() + "_" + r;
                    if (l in i) return "@-" + s.toLowerCase() + "-" + t
                }
                return !1
            };
            S.atRule = N;
            var T = S._config.usePrefixes ? j.toLowerCase().split(" ") : [];
            S._domPrefixes = T;
            var k = {
                elem: a("modernizr")
            };
            Modernizr._q.push(function() {
                delete k.elem
            });
            var F = {
                style: k.elem.style
            };
            Modernizr._q.unshift(function() {
                delete F.style
            }), S.testAllProps = g;
            var M = S.prefixed = function(e, t, n) {
                return 0 === e.indexOf("@") ? N(e) : (-1 != e.indexOf("-") && (e = u(e)), t ? g(e, t, n) : g(e, "pfx"))
            };
            Modernizr.addTest("objectfit", !!M("objectFit"), {
                aliases: ["object-fit"]
            }), o(), i(y), delete S.addTest, delete S.addAsyncTest;
            for (var P = 0; P < Modernizr._q.length; P++) Modernizr._q[P]();
            e.Modernizr = Modernizr
        }(window, document);
    </script>
    @stack('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <div id="topbar">
        <div class="d-flex align-items-center ">
            <div class="container-fluid d-flex justify-content-end">
                <ul class="d-flex align-items-center list-unstyled m-0 justify-content-end">
                    <li class="px-0">
                        <div class="theme-switch" data-toggle="tooltip" title="Change Theme">
                            <input class="theme-switch_toggle" id="themeSwitchToggle" type="checkbox">
                            <label class="theme-switch_label" for="themeSwitchToggle"></label>
                        </div>
                    </li>
                    <li class="px-0">
                        <a title="" href="javascript:void(0);" id="btn-decrease" class="js-font-decrease"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="A-">
                            A-
                        </a>
                    </li>
                    <li class="px-0">
                        <a title="" href="javascript:void(0);" id="btn-orig" class="js-font-normal"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="A">
                            A
                        </a>
                    </li>
                    <li class="px-0">
                        <a title="" href="javascript:void(0);" id="btn-increase" class="js-font-increase"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="A+">
                            A+
                        </a>
                    </li>
                </ul>
                <div class="contact-info d-flex align-items-center">
                    <a href="{{ route('root.page.show', ['page' => 'screen-reader']) }}" class="d-sm-hide"><i
                            class="fa fa-book px-2"></i> <span class="d-none-head">Screen
                            Reader</span></a>
                    <a href="#" class="d-sm-hide">
                        <i class="fa fa-fast-forward font-13 px-2"></i> <span class="d-none-head">Skip to Nav
                            Content</span>
                    </a>
                    <a href="#" class="d-sm-hide">
                        <i class="fa fa-fast-forward font-13 px-2"></i> <span class="d-none-head">Skip to Main
                            Content</span>
                    </a>
                    <a href="#" class="d-sm-hide dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-user font-13 px-2"></i> <span class="d-none-head">Login</span>
                    </a>
                    <ul class="dropdown-menu">
                        @if (auth('web')->check())
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Welcome
                                    {{ auth('web')->user()->first_name }}</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}">Student Login</a></li>
                        @endif
                        @if (auth('admin')->check())
                            <li><a class="dropdown-item" href="{{ route('manage.home') }}">Welcome
                                    {{ auth('admin')->user()->first_name }}</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('manage.login') }}">Department Login</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar Start -->

    <nav class="c-navbar shadow" id="js-navbar">
        <div class="container-fluid">
            <div class="row">
                <div class="c-navbar__container">
                    <div id="hs_cos_wrapper_navigation-primary"
                        class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_module"
                        data-hs-cos-general-type="widget" data-hs-cos-type="module">
                        <x-Front.menus />
                        <div class="navbar-2">
                            <a href="{{ route('dashboard') }}"
                                class="navbar-brand d-flex align-items-center px-4 p-4">
                                <img src="{{ asset('frontend/img/logo.png') }}" alt="" />
                                <div class="ml-2" style="margin-left: 10px">
                                    <p class="name">e-Shiksha</p>
                                    <span class="subhead">Govt. of Madhya Pradesh</span>
                                </div>
                            </a>
                        </div>
                        <div class="navbar-3 c-navbar__buttons ">

                            <a class="btn btn-primary py-2 px-4 fa-search-toggle" href="javascript:void(0)"
                                style=" border-radius: 40px; "><span class="d-none-head">Search</span> <i
                                    class="fas fa-search"></i></a>
                            <div class="search-box">
                                <input type="text" placeholder="">
                                <input type="button" value="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Page Content -->
    {{ $slot }}
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
        <div class="container-fluid py-3"
            style="background-color: #1e233d; border-bottom: 1px solid rgba(256, 256, 256, .1); ">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-12 col-md-12 text-center">
                    <x-front.menus placedon="Bottom Menus" />
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-4 col-lg-4 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">e-shiksha</a>, All Right Reserved.
                    </div>
                    <div class="col-md-4 col-lg-4 text-center">
                        Last Update On : 03 Nov 2023, 15:50
                    </div>
                    <div class="col-md-4 col-lg-4 text-center text-md-end">
                        <div class="footer-menu">
                            Designed and Developed By <a class="border-bottom" href="#">MPSEDC (CoE)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script src="{{ asset('frontend/js/global-min.js') }}"></script>
    <script>
        BEGlobal.Init();
        FEGlobal.Init();
    </script>

    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript">
        // Footer Slider js code start
        jQuery(document).ready(function($) {
            $('.fadeOut').owlCarousel({
                items: 6,
                animateOut: 'fadeOut',
                loop: true,
                margin: 0,
                autoplay: true,
                nav: false,
                dots: true,
                responsiveClass: true,
                navText: ["<img src='prevArrow.png'>", "<img src='nextArrow.png'>"]
            });
            $('.custom7').owlCarousel({
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                items: 6,
                margin: 0,
                stagePadding: 0,
                smartSpeed: 450,
                autoplay: true,
                loop: true,
                navText: ["<img src='prevArrow.png'>", "<img src='nextArrow.png'>"],
                dots: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false
                    },
                    600: {
                        items: 4,
                        nav: false
                    },
                    1000: {
                        items: 8,
                        nav: false,
                        loop: false,
                        margin: 0
                    }
                }
            });

        });
    </script>
    @stack('scripts')
</body>

</html>
