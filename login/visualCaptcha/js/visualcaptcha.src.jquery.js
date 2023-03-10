/*! visualCaptcha - v0.0.5 - 2014-03-13
 * http://visualcaptcha.net
 * Copyright (c) 2014 emotionLoop; Licensed MIT */

/**
 * @license almond 0.2.9 Copyright (c) 2011-2014, The Dojo Foundation All Rights Reserved.
 * Available via the MIT or new BSD license.
 * see: http://github.com/jrburke/almond for details
 */

(function (e, t) {
	typeof define == "function" && define.amd ? define(["jquery"], t) : t(e.jQuery)
})(this, function (e) {
	var t,
	n,
	r;
	(function (e) {
		function v(e, t) {
			return h.call(e, t)
		}
		function m(e, t) {
			var n,
			r,
			i,
			s,
			o,
			u,
			a,
			f,
			c,
			h,
			p,
			v = t && t.split("/"),
			m = l.map,
			g = m && m["*"] || {};
			if (e && e.charAt(0) === ".")
				if (t) {
					v = v.slice(0, v.length - 1),
					e = e.split("/"),
					o = e.length - 1,
					l.nodeIdCompat && d.test(e[o]) && (e[o] = e[o].replace(d, "")),
					e = v.concat(e);
					for (c = 0; c < e.length; c += 1) {
						p = e[c];
						if (p === ".")
							e.splice(c, 1), c -= 1;
						else if (p === "..") {
							if (c === 1 && (e[2] === ".." || e[0] === ".."))
								break;
							c > 0 && (e.splice(c - 1, 2), c -= 2)
						}
					}
					e = e.join("/")
				} else
					e.indexOf("./") === 0 && (e = e.substring(2));
			if ((v || g) && m) {
				n = e.split("/");
				for (c = n.length; c > 0; c -= 1) {
					r = n.slice(0, c).join("/");
					if (v)
						for (h = v.length; h > 0; h -= 1) {
							i = m[v.slice(0, h).join("/")];
							if (i) {
								i = i[r];
								if (i) {
									s = i,
									u = c;
									break
								}
							}
						}
					if (s)
						break;
					!a && g && g[r] && (a = g[r], f = c)
				}
				!s && a && (s = a, u = f),
				s && (n.splice(0, u, s), e = n.join("/"))
			}
			return e
		}
		function g(t, n) {
			return function () {
				return s.apply(e, p.call(arguments, 0).concat([t, n]))
			}
		}
		function y(e) {
			return function (t) {
				return m(t, e)
			}
		}
		function b(e) {
			return function (t) {
				a[e] = t
			}
		}
		function w(t) {
			if (v(f, t)) {
				var n = f[t];
				delete f[t],
				c[t] = !0,
				i.apply(e, n)
			}
			if (!v(a, t) && !v(c, t))
				throw new Error("No " + t);
			return a[t]
		}
		function E(e) {
			var t,
			n = e ? e.indexOf("!") : -1;
			return n > -1 && (t = e.substring(0, n), e = e.substring(n + 1, e.length)),
			[t, e]
		}
		function S(e) {
			return function () {
				return l && l.config && l.config[e] || {}

			}
		}
		var i,
		s,
		o,
		u,
		a = {},
		f = {},
		l = {},
		c = {},
		h = Object.prototype.hasOwnProperty,
		p = [].slice,
		d = /\.js$/;
		o = function (e, t) {
			var n,
			r = E(e),
			i = r[0];
			return e = r[1],
			i && (i = m(i, t), n = w(i)),
			i ? n && n.normalize ? e = n.normalize(e, y(t)) : e = m(e, t) : (e = m(e, t), r = E(e), i = r[0], e = r[1], i && (n = w(i))), {
				f : i ? i + "!" + e : e,
				n : e,
				pr : i,
				p : n
			}
		},
		u = {
			require : function (e) {
				return g(e)
			},
			exports : function (e) {
				var t = a[e];
				return typeof t != "undefined" ? t : a[e] = {}

			},
			module : function (e) {
				return {
					id : e,
					uri : "",
					exports : a[e],
					config : S(e)
				}
			}
		},
		i = function (t, n, r, i) {
			var s,
			l,
			h,
			p,
			d,
			m = [],
			y = typeof r,
			E;
			i = i || t;
			if (y === "undefined" || y === "function") {
				n = !n.length && r.length ? ["require", "exports", "module"] : n;
				for (d = 0; d < n.length; d += 1) {
					p = o(n[d], i),
					l = p.f;
					if (l === "require")
						m[d] = u.require(t);
					else if (l === "exports")
						m[d] = u.exports(t), E = !0;
					else if (l === "module")
						s = m[d] = u.module(t);
					else if (v(a, l) || v(f, l) || v(c, l))
						m[d] = w(l);
					else {
						if (!p.p)
							throw new Error(t + " missing " + l);
						p.p.load(p.n, g(i, !0), b(l), {}),
						m[d] = a[l]
					}
				}
				h = r ? r.apply(a[t], m) : undefined;
				if (t)
					if (s && s.exports !== e && s.exports !== a[t])
						a[t] = s.exports;
					else if (h !== e || !E)
						a[t] = h
			} else
				t && (a[t] = r)
		},
		t = n = s = function (t, n, r, a, f) {
			if (typeof t == "string")
				return u[t] ? u[t](n) : w(o(t, n).f);
			if (!t.splice) {
				l = t,
				l.deps && s(l.deps, l.callback);
				if (!n)
					return;
				n.splice ? (t = n, n = r, r = null) : t = e
			}
			return n = n || function () {},
			typeof r == "function" && (r = a, a = f),
			a ? i(e, t, n, r) : setTimeout(function () {
				i(e, t, n, r)
			}, 4),
			s
		},
		s.config = function (e) {
			return s(e)
		},
		t._defined = a,
		r = function (e, t, n) {
			t.splice || (n = t, t = []),
			!v(a, e) && !v(f, e) && (f[e] = [e, t, n])
		},
		r.amd = {
			jQuery : !0
		}
	})(),
	r("almond", function () {}),
	r("visualcaptcha/core", [], function () {
		var e,
		t,
		n,
		r,
		i,
		s,
		o,
		u;
		return e = function (e, t, n) {
			return n = n || [],
			e.namespace && e.namespace.length > 0 && n.push(e.namespaceFieldName + "=" + e.namespace),
			n.push(e.randomParam + "=" + e.randomNonce),
			t + "?" + n.join("&")
		},
		t = function (e) {
			var t = this,
			r;
			e.applyRandomNonce(),
			e.isLoading = !0,
			r = n(e),
			e.callbacks.loading && e.callbacks.loading(t),
			e.request(r, function (n) {
				n.audioFieldName && (e.audioFieldName = n.audioFieldName),
				n.imageFieldName && (e.imageFieldName = n.imageFieldName),
				n.imageName && (e.imageName = n.imageName),
				n.values && (e.imageValues = n.values),
				e.isLoading = !1,
				e.hasLoaded = !0,
				e.callbacks.loaded && e.callbacks.loaded(t)
			})
		},
		n = function (t) {
			var n = t.url + t.routes.start + "/" + t.numberOfImages;
			return e(t, n)
		},
		r = function (t, n) {
			var r = "",
			i = [];
			return n < 0 || n >= t.numberOfImages ? r : (this.isRetina() && i.push("retina=1"), r = t.url + t.routes.image + "/" + n, e(t, r, i))
		},
		i = function (t, n) {
			var r = t.url + t.routes.audio;
			return n && (r += "/ogg"),
			e(t, r)
		},
		s = function (e, t) {
			return t >= 0 && t < e.numberOfImages ? e.imageValues[t] : ""
		},
		o = function () {
			return window.devicePixelRatio !== undefined && window.devicePixelRatio > 1
		},
		u = function () {
			var e,
			t = !1;
			try {
				e = document.createElement("audio"),
				e.canPlayType && (t = !0)
			} catch (n) {}

			return t
		},
		function (e) {
			var n,
			a,
			f,
			l,
			c,
			h,
			p,
			d,
			v,
			m,
			g,
			y,
			b;
			return a = function () {
				return t.call(this, e)
			},
			f = function () {
				return e.isLoading
			},
			l = function () {
				return e.hasLoaded
			},
			c = function () {
				return e.imageValues.length
			},
			h = function () {
				return e.imageName
			},
			p = function (t) {
				return s.call(this, e, t)
			},
			d = function (t) {
				return r.call(this, e, t)
			},
			v = function (t) {
				return i.call(this, e, t)
			},
			m = function () {
				return e.imageFieldName
			},
			g = function () {
				return e.audioFieldName
			},
			y = function () {
				return e.namespace
			},
			b = function () {
				return e.namespaceFieldName
			},
			n = {
				refresh : a,
				isLoading : f,
				hasLoaded : l,
				numberOfImages : c,
				imageName : h,
				imageValue : p,
				imageUrl : d,
				audioUrl : v,
				imageFieldName : m,
				audioFieldName : g,
				namespace : y,
				namespaceFieldName : b,
				isRetina : o,
				supportsAudio : u
			},
			e.autoRefresh && n.refresh(),
			n
		}
	}),
	r("visualcaptcha/xhr-request", [], function () {
		var e = window.XMLHttpRequest;
		return function (t, n) {
			var r = new e;
			r.open("GET", t, !0),
			r.onreadystatechange = function () {
				var e;
				if (r.readyState !== 4 || r.status !== 200)
					return;
				e = JSON.parse(r.responseText),
				n(e)
			},
			r.send()
		}
	}),
	r("visualcaptcha/config", ["visualcaptcha/xhr-request"], function (e) {
		return function (t) {
			var n = window.location.href.split("/");
			n[n.length - 1] = "";
			var r = {
				request : e,
				url : n.join("/").slice(0, -1),
				namespace : "",
				namespaceFieldName : "namespace",
				routes : {
					start : "/login/visualCaptcha5/public/start",
					image : "/login/visualCaptcha5/public/image",
					audio : "/login/visualCaptcha5/public/audio"
				},
				isLoading : !1,
				hasLoaded : !1,
				autoRefresh : !0,
				numberOfImages : 6,
				randomNonce : "",
				randomParam : "r",
				audioFieldName : "",
				imageFieldName : "",
				imageName : "",
				imageValues : [],
				callbacks : {}

			};
			return r.applyRandomNonce = function () {
				return r.randomNonce = Math.random().toString(36).substring(2)
			},
			t.request && (r.request = t.request),
			t.url && (r.url = t.url),
			t.namespace && (r.namespace = t.namespace),
			t.namespaceFieldName && (r.namespaceFieldName = t.namespaceFieldName),
			typeof t.autoRefresh != "undefined" && (r.autoRefresh = t.autoRefresh),
			t.numberOfImages && (r.numberOfImages = t.numberOfImages),
			t.routes && (t.routes.start && (r.routes.start = t.routes.start), t.routes.image && (r.routes.image = t.routes.image), t.routes.audio && (r.routes.audio = t.routes.audio)),
			t.randomParam && (r.randomParam = t.randomParam),
			t.callbacks && (t.callbacks.loading && (r.callbacks.loading = t.callbacks.loading), t.callbacks.loaded && (r.callbacks.loaded = t.callbacks.loaded)),
			r
		}
	}),
	r("visualcaptcha", ["require", "visualcaptcha/core", "visualcaptcha/config"], function (e) {
		var t = e("visualcaptcha/core"),
		n = e("visualcaptcha/config");
		return function (e) {
			return e = e || {},
			t(n(e))
		}
	}),
	r("visualcaptcha/templates", [], function () {
		var e,
		t,
		n,
		r,
		i,
		s,
		o;
		return e = function (e, t) {
			for (var n in t)
				e = e.replace(new RegExp("{" + n + "}", "g"), t[n]);
			return e
		},
		t = function (t, n, r) {
			var i,
			s,
			o,
			u;
			return i = '<div class="visualCaptcha-accessibility-button"><img src="{path}accessibility{retinaExtra}.png" title="{accessibilityTitle}" alt="{accessibilityAlt}" /></div>',
			s = '<div class="visualCaptcha-refresh-button"><img src="{path}refresh{retinaExtra}.png" title="{refreshTitle}" alt="{refreshAlt}" /></div>',
			o = '<div class="visualCaptcha-button-group">' + s + (t.supportsAudio() ? i : "") + "</div>",
			u = {
				path : r || "",
				refreshTitle : n.refreshTitle,
				refreshAlt : n.refreshAlt,
				accessibilityTitle : n.accessibilityTitle,
				accessibilityAlt : n.accessibilityAlt,
				retinaExtra : t.isRetina() ? "@2x" : ""
			},
			e(o, u)
		},
		n = function (t, n) {
			var r,
			i;
			return t.supportsAudio() ? (r = '<div class="visualCaptcha-accessibility-wrapper visualCaptcha-hide"><div class="accessibility-description">{accessibilityDescription}</div><audio preload="preload"><source src="{audioURL}" type="audio/ogg" /><source src="{audioURL}" type="audio/mpeg" /></audio></div>', i = {
					accessibilityDescription : n.accessibilityDescription,
					audioURL : t.audioUrl(),
					audioFieldName : t.audioFieldName()
				}, e(r, i)) : ""
		},
		r = function (t, n) {
			var r = "",
			i,
			s;
			for (var o = 0, u = t.numberOfImages(); o < u; o++)
				i = '<div class="img"><img src="{imageUrl}" id="visualCaptcha-img-{i}" data-index="{i}" alt="" title="" /></div>', s = {
					imageUrl : t.imageUrl(o),
					i : o
				},
			r += e(i, s);
			return i = '<p class="visualCaptcha-explanation">{explanation}</p><div class="visualCaptcha-possibilities">{images}</div>',
			s = {
				imageFieldName : t.imageFieldName(),
				explanation : n.explanation.replace(/ANSWER/, t.imageName()),
				images : r
			},
			e(i, s)
		},
		i = function (t) {
			var n,
			r;
			return n = '<input class="form-control audioField" type="text" name="{audioFieldName}" value="" autocomplete="off" />',
			r = {
				audioFieldName : t.audioFieldName()
			},
			e(n, r)
		},
		s = function (t, n) {
			var r,
			i;
			return r = '<input class="form-control imageField" type="hidden" name="{imageFieldName}" value="{value}" readonly="readonly" />',
			i = {
				imageFieldName : t.imageFieldName(),
				value : t.imageValue(n)
			},
			e(r, i)
		},
		o = function (t) {
			var n,
			r,
			i = t.namespace();
			return !i || i.length === 0 ? "" : (n = '<input type="hidden" name="{fieldName}" value="{value}" />', r = {
					fieldName : t.namespaceFieldName(),
					value : i
				}, e(n, r))
		}, {
			buttons : t,
			accessibility : n,
			images : r,
			audioInput : i,
			imageInput : s,
			namespaceInput : o
		}
	}),
	r("visualcaptcha/language", [], function () {
		return {
			accessibilityAlt : "Sound icon",
			accessibilityTitle : "Accessibility option: listen to a question and answer it!",
			accessibilityDescription : "Type below the <strong>answer</strong> to what you hear. Numbers or words:",
			explanation : "Click or touch the <strong>ANSWER</strong>",
			refreshAlt : "Refresh/reload icon",
			refreshTitle : "Refresh/reload: get new images and accessibility option!"
		}
	}),
	r("visualcaptcha.jquery", ["jquery", "visualcaptcha", "visualcaptcha/templates", "visualcaptcha/language"], function (e, t, n, r) {
		var i,
		s,
		o,
		u,
		a,
		f,
		l;
		i = function (t, n) {
			e.get(t, n, "json")
		},
		s = function () {},
		o = function (e, t, r) {
			var i;
			i = n.namespaceInput(r) + n.accessibility(r, e.language) + n.images(r, e.language) + n.buttons(r, e.language, e.imgPath),
			t.html(i)
		},
		u = function () {
			var t = e(this).closest(".visualCaptcha"),
			r = t.find(".visualCaptcha-accessibility-wrapper"),
			i = t.find(".visualCaptcha-possibilities"),
			s = t.find(".visualCaptcha-explanation"),
			o = r.find("audio"),
			u;
			r.hasClass("visualCaptcha-hide") ? (i.toggleClass("visualCaptcha-hide"), s.toggleClass("visualCaptcha-hide"), i.find(".img").removeClass("visualCaptcha-selected"), s.find("input").val(""), u = n.audioInput(t.data("captcha")), e(u).insertBefore(o), r.toggleClass("visualCaptcha-hide"), o[0].load(), o[0].play()) : (o[0].pause(), r.toggleClass("visualCaptcha-hide"), r.find("input").remove(), s.toggleClass("visualCaptcha-hide"), i.toggleClass("visualCaptcha-hide"))
		},
		a = function () {
			var t = e(this),
			r = t.closest(".visualCaptcha"),
			i = r.find(".visualCaptcha-possibilities"),
			s = r.find(".visualCaptcha-explanation"),
			o,
			u,
			a;
			u = s.find("input"),
			u && (u.remove(), i.find(".img").removeClass("visualCaptcha-selected")),
			t.addClass("visualCaptcha-selected"),
			o = t.find("img").data("index"),
			a = n.imageInput(r.data("captcha"), o),
			s.append(e(a))
		},
		f = function () {
			var t = e(this).closest(".visualCaptcha");
			t.data("captcha").refresh()
		},
		l = function (e) {
			var t = e.find(".imageField"),
			n = e.find(".audioField"),
			r = !!t.val() || !!n.val();
			return r ? {
				valid : r,
				name : t.val() ? t.attr("name") : n.attr("name"),
				value : t.val() ? t.val() : n.val()
			}
			 : {
				valid : r
			}
		},
		e.fn.visualCaptcha = function (n) {
			var c;
			return c = e.extend({
					imgPath : "/",
					language : r,
					captcha : {
						request : i
					}
				}, n),
			this.addClass("visualCaptcha").on("click", ".visualCaptcha-accessibility-button", u).on("click", ".visualCaptcha-refresh-button", f).on("click", ".visualCaptcha-possibilities .img", a),
			this.each(function () {
				var n = e(this),
				r,
				i;
				i = e.extend(c.captcha, {
						callbacks : {
							loading : s.bind(null, c, n),
							loaded : o.bind(null, c, n)
						}
					}),
				typeof n.data("namespace") != "undefined" && (i.namespace = n.data("namespace")),
				r = t(i),
				r.getCaptchaData = l.bind(null, n),
				n.data("captcha", r)
			})
		}
	}),
	r("jquery", function () {
		return e
	}),
	n("visualcaptcha.jquery")
});
