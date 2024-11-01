/*
 *  Project: jquery.upnmTabs.js
 *  Description: A plugin that creates responsive tabs, optimized for all devices.
 *  Author: ACh (Hello@ACh.li)
 *  Version: 1.0.0
 *  License: MIT
 */
 
(function(e, t, n) {
    function i(t, n) {
        this.element = t;
        this.$element = e(t);
        this.tabs = [];
        this.state = "";
        this.rotateInterval = 0;
        this.$queue = e({});
        this.options = e.extend({}, r, n);
        this.init()
    }
    var r = {
        active: null,
        disabled: [],
        collapsible: "accordion",
        startCollapsed: !1,
        rotate: !1,
        setHash: !1,
        animation: "default",
        duration: 500,
        activate: function() {},
        deactivate: function() {},
        load: function() {},
        activateState: function() {},
        classes: {
            stateDefault: "upnm-tabs-state-default",
            stateActive: "upnm-tabs-state-active",
            stateDisabled: "upnm-tabs-state-disabled",
            stateExcluded: "upnm-tabs-state-excluded",
            tab: "upnm-tabs-tab",
            anchor: "upnm-tabs-anchor",
            panel: "upnm-tabs-panel",
            accordionTitle: "upnm-tabs-accordion-title"
        }
    };
    i.prototype.init = function() {
        var n = this;
        this.tabs = this._loadElements();
        this._loadClasses();
        this._loadEvents();
        e(t).on("resize", function(e) {
            n._setState(e)
        });
        e(t).on("hashchange", function(e) {
            var r = n._getTabRefBySelector(t.location.hash),
                i = n._getTab(r);
            r >= 0 && !i._ignoreHashChange && !i.disabled && n._openTab(e, n._getTab(r), !0)
        });
        this.options.rotate !== !1 && this.startRotation();
        this.$element.bind("tabs-activate", function(e, t) {
            n.options.activate.call(this, e, t)
        });
        this.$element.bind("tabs-deactivate", function(e, t) {
            n.options.deactivate.call(this, e, t)
        });
        this.$element.bind("tabs-activate-state", function(e, t) {
            n.options.activateState.call(this, e, t)
        });
        this.$element.bind("tabs-load", function(e) {
            var r = n._getTabRefBySelector(t.location.hash),
                i;
            n._setState(e);
            if (n.options.startCollapsed !== !0 && (n.options.startCollapsed !== "accordion" || n.state !== "accordion")) {
                r >= 0 && !n._getTab(r).disabled ? i = n._getTab(r) : n.options.active > 0 && !n._getTab(n.options.active).disabled ? i = n._getTab(n.options.active) : i = n._getTab(0);
                n._openTab(e, i);
                n.options.load.call(this, e, i)
            }
        });
        this.$element.trigger("tabs-load")
    };
    i.prototype._loadElements = function() {
        var t = this,
            n = this.$element.children("ul"),
            r = [],
            i = 0;
        this.$element.addClass("upnm-tabs");
        n.addClass("upnm-tabs-nav");
        e("li", n).each(function() {
            var n = e(this),
                s = n.hasClass(t.options.classes.stateExcluded),
                o, u, a, f, l;
            if (!s) {
                o = e("a", n);
                l = o.attr("href");
                u = e(l);
                a = e("<div></div>").insertBefore(u);
                f = e("<a></a>").attr("href", l).html(o.html()).appendTo(a);
                var c = {
                    _ignoreHashChange: !1,
                    id: i,
                    disabled: e.inArray(i, t.options.disabled) !== -1,
                    tab: e(this),
                    anchor: e("a", n),
                    panel: u,
                    selector: l,
                    accordionTab: a,
                    accordionAnchor: f,
                    active: !1
                };
                i++;
                r.push(c)
            }
        });
        return r
    };
    i.prototype._loadClasses = function() {
        for (var e = 0; e < this.tabs.length; e++) {
            this.tabs[e].tab.addClass(this.options.classes.stateDefault).addClass(this.options.classes.tab);
            this.tabs[e].anchor.addClass(this.options.classes.anchor);
            this.tabs[e].panel.addClass(this.options.classes.stateDefault).addClass(this.options.classes.panel);
            this.tabs[e].accordionTab.addClass(this.options.classes.accordionTitle);
            this.tabs[e].accordionAnchor.addClass(this.options.classes.anchor);
            if (this.tabs[e].disabled) {
                this.tabs[e].tab.removeClass(this.options.classes.stateDefault).addClass(this.options.classes.stateDisabled);
                this.tabs[e].accordionTab.removeClass(this.options.classes.stateDefault).addClass(this.options.classes.stateDisabled)
            }
        }
    };
    i.prototype._loadEvents = function() {
        var e = this,
            n = function(n) {
                var r = e._getCurrentTab(),
                    i = n.data.tab;
                n.preventDefault();
                if (!i.disabled) {
                    e.options.setHash && (t.location.hash = i.selector);
                    n.data.tab._ignoreHashChange = !0;
                    if (r !== i || e._isCollapisble()) {
                        e._closeTab(n, r);
                        (r !== i || !e._isCollapisble()) && e._openTab(n, i, !1, !0)
                    }
                }
            };
        for (var r = 0; r < this.tabs.length; r++) {
            this.tabs[r].anchor.on("click", {
                tab: e.tabs[r]
            }, n);
            this.tabs[r].accordionAnchor.on("click", {
                tab: e.tabs[r]
            }, n)
        }
    };
    i.prototype._setState = function() {
        var t = e("ul", this.$element),
            n = this.state;
        t.is(":visible") ? this.state = "tabs" : this.state = "accordion";
        this.state !== n && this.$element.trigger("tabs-activate-state", {
            oldState: n,
            newState: this.state
        })
    };
    i.prototype._openTab = function(e, t, n, r) {
        var i = this;
        n && this._closeTab(e, this._getCurrentTab());
        r && this.rotateInterval > 0 && this.stopRotation();
        t.active = !0;
        t.tab.removeClass(i.options.classes.stateDefault).addClass(i.options.classes.stateActive);
        t.accordionTab.removeClass(i.options.classes.stateDefault).addClass(i.options.classes.stateActive);
        i._doTransition(t.panel, i.options.animation, "open", function() {
            t.panel.removeClass(i.options.classes.stateDefault).addClass(i.options.classes.stateActive)
        });
        this.$element.trigger("tabs-activate", t)
    };
    i.prototype._closeTab = function(e, t) {
        var r = this;
        if (t !== n) {
            t.active = !1;
            t.tab.removeClass(r.options.classes.stateActive).addClass(r.options.classes.stateDefault);
            r._doTransition(t.panel, r.options.animation, "close", function() {
                t.accordionTab.removeClass(r.options.classes.stateActive).addClass(r.options.classes.stateDefault);
                t.panel.removeClass(r.options.classes.stateActive).addClass(r.options.classes.stateDefault)
            }, !0);
            this.$element.trigger("tabs-deactivate", t)
        }
    };
    i.prototype._doTransition = function(e, t, n, r, i) {
        var s, o = this;
        switch (t) {
            case "slide":
                s = n === "open" ? "slideDown" : "slideUp";
                break;
            case "fade":
                s = n === "open" ? "fadeIn" : "fadeOut";
                break;
            default:
                s = n === "open" ? "show" : "hide";
                o.options.duration = 0
        }
        this.$queue.queue("responsive-tabs", function(i) {
            e[s]({
                duration: o.options.duration,
                complete: function() {
                    r.call(e, t, n);
                    i()
                }
            })
        });
        (n === "open" || i) && this.$queue.dequeue("responsive-tabs")
    };
    i.prototype._isCollapisble = function() {
        return typeof this.options.collapsible == "boolean" && this.options.collapsible || typeof this.options.collapsible == "string" && this.options.collapsible === this.getState()
    };
    i.prototype._getTab = function(e) {
        return this.tabs[e]
    };
    i.prototype._getTabRefBySelector = function(e) {
        for (var t = 0; t < this.tabs.length; t++)
            if (this.tabs[t].selector === e) return t;
        return -1
    };
    i.prototype._getCurrentTab = function() {
        return this._getTab(this._getCurrentTabRef())
    };
    i.prototype._getNextTabRef = function(e) {
        var t = e || this._getCurrentTabRef(),
            n = t === this.tabs.length - 1 ? 0 : t + 1;
        return this._getTab(n).disabled ? this._getNextTabRef(n) : n
    };
    i.prototype._getPreviousTabRef = function() {
        return this._getCurrentTabRef() === 0 ? this.tabs.length - 1 : this._getCurrentTabRef() - 1
    };
    i.prototype._getCurrentTabRef = function() {
        for (var e = 0; e < this.tabs.length; e++)
            if (this.tabs[e].active) return e;
        return -1
    };
    i.prototype.activate = function(e, t) {
        var n = jQuery.Event("tabs-activate"),
            r = this._getTab(e);
        r.disabled || this._openTab(n, r, !0, t || !0)
    };
    i.prototype.deactivate = function(e) {
        var t = jQuery.Event("tabs-dectivate"),
            n = this._getTab(e);
        n.disabled || this._closeTab(t, n)
    };
    i.prototype.getState = function() {
        return this.state
    };
    i.prototype.startRotation = function(t) {
        var n = this;
        if (!(this.tabs.length > this.options.disabled.length)) throw new Error("Rotation is not possible if all tabs are disabled");
        this.rotateInterval = setInterval(function() {
            var e = jQuery.Event("rotate");
            n._openTab(e, n._getTab(n._getNextTabRef()), !0)
        }, t || (e.isNumeric(n.options.rotate) ? n.options.rotate : 4e3))
    };
    i.prototype.stopRotation = function() {
        t.clearInterval(this.rotateInterval);
        this.rotateInterval = 0
    };
    e.fn.responsiveTabs = function(t) {
        var r = arguments;
        if (t === n || typeof t == "object") return this.each(function() {
            e.data(this, "responsivetabs") || e.data(this, "responsivetabs", new i(this, t))
        });
        if (typeof t == "string" && t[0] !== "_" && t !== "init") return this.each(function() {
            var n = e.data(this, "responsivetabs");
            n instanceof i && typeof n[t] == "function" && n[t].apply(n, Array.prototype.slice.call(r, 1));
            t === "destroy" && e.data(this, "responsivetabs", null)
        })
    }
})(jQuery, window);

jQuery(
	function(){

		/* Responsive Tabs */
		jQuery( '#ach-upnm-tabs' ).show().responsiveTabs(
			{
				startCollapsed: 'accordion'
			}
		);

	}
);
