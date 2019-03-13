/*! http://mths.be/placeholder v2.0.7 by @mathias */
;(function (h, j, e) {
    var a = "placeholder" in j.createElement("input");
    var f = "placeholder" in j.createElement("textarea");
    var k = e.fn;
    var d = e.valHooks;
    var b = e.propHooks;
    var m;
    var l;
    if (a && f) {
        l = k.placeholder = function () {
            return this
        };
        l.input = l.textarea = true
    } else {
        l = k.placeholder = function () {
            var n = this;
            n.filter((a ? "textarea" : ":input") + "[placeholder]").not(".placeholder").bind({
                "focus.placeholder": c,
                "blur.placeholder": g
            }).data("placeholder-enabled", true).trigger("blur.placeholder");
            return n
        };
        l.input = a;
        l.textarea = f;
        m = {
            get: function (o) {
                var n = e(o);
                var p = n.data("placeholder-password");
                if (p) {
                    return p[0].value
                }
                return n.data("placeholder-enabled") && n.hasClass("placeholder") ? "" : o.value
            }, set: function (o, q) {
                var n = e(o);
                var p = n.data("placeholder-password");
                if (p) {
                    return p[0].value = q
                }
                if (!n.data("placeholder-enabled")) {
                    return o.value = q
                }
                if (q == "") {
                    o.value = q;
                    if (o != j.activeElement) {
                        g.call(o)
                    }
                } else {
                    if (n.hasClass("placeholder")) {
                        c.call(o, true, q) || (o.value = q)
                    } else {
                        o.value = q
                    }
                }
                return n
            }
        };
        if (!a) {
            d.input = m;
            b.value = m
        }
        if (!f) {
            d.textarea = m;
            b.value = m
        }
        e(function () {
            e(j).delegate("form", "submit.placeholder", function () {
                var n = e(".placeholder", this).each(c);
                setTimeout(function () {
                    n.each(g)
                }, 10)
            })
        });
        e(h).bind("beforeunload.placeholder", function () {
            e(".placeholder").each(function () {
                this.value = ""
            })
        })
    }
    
    function i(o) {
        var n = {};
        var p = /^jQuery\d+$/;
        e.each(o.attributes, function (r, q) {
            if (q.specified && !p.test(q.name)) {
                n[q.name] = q.value
            }
        });
        return n
    }
    
    function c(o, p) {
        var n = this;
        var q = e(n);
        if (n.value == q.attr("placeholder") && q.hasClass("placeholder")) {
            if (q.data("placeholder-password")) {
                q = q.hide().next().show().attr("id", q.removeAttr("id").data("placeholder-id"));
                if (o === true) {
                    return q[0].value = p
                }
                q.focus()
            } else {
                n.value = "";
                q.removeClass("placeholder");
                n == j.activeElement && n.select()
            }
        }
    }
    
    function g() {
        var r;
        var n = this;
        var q = e(n);
        var p = this.id;
        if (n.value == "") {
            if (n.type == "password") {
                if (!q.data("placeholder-textinput")) {
                    try {
                        r = q.clone().attr({type: "text"})
                    } catch (o) {
                        r = e("<input>").attr(e.extend(i(this), {type: "text"}))
                    }
                    r.removeAttr("name").data({
                        "placeholder-password": q,
                        "placeholder-id": p
                    }).bind("focus.placeholder", c);
                    q.data({"placeholder-textinput": r, "placeholder-id": p}).before(r)
                }
                q = q.removeAttr("id").hide().prev().attr("id", p).show()
            }
            q.addClass("placeholder");
            q[0].value = q.attr("placeholder")
        } else {
            q.removeClass("placeholder")
        }
    }
}(this, document, jQuery));

// data-shift api 
+function ($) {
    "use strict";
    
    /* SHIFT CLASS DEFINITION
     * ====================== */
    
    var Shift = function (element) {
        this.$element = $(element)
        this.$prev = this.$element.prev()
        !this.$prev.length && (this.$parent = this.$element.parent())
    }
    
    Shift.prototype = {
        constructor: Shift
        
        , init: function () {
            var $el = this.$element
                , method = $el.data()['toggle'].split(':')[1]
                , $target = $el.data('target')
            $el.hasClass('in') || $el[method]($target).addClass('in')
        }
        , reset: function () {
            this.$parent && this.$parent['prepend'](this.$element)
            !this.$parent && this.$element['insertAfter'](this.$prev)
            this.$element.removeClass('in')
        }
    }
    
    /* SHIFT PLUGIN DEFINITION
     * ======================= */
    
    $.fn.shift = function (option) {
        return this.each(function () {
            var $this = $(this)
                , data = $this.data('shift')
            if (!data) $this.data('shift', (data = new Shift(this)))
            if (typeof option == 'string') data[option]()
        })
    }
    
    $.fn.shift.Constructor = Shift
}(jQuery);

Date.now = Date.now || function () {
    return +new Date;
};

+function ($) {
    
    $(function () {
        
        // toogle fullscreen
        $(document).on('click', "[data-toggle=fullscreen]", function (e) {
            if (screenfull.enabled) {
                screenfull.request();
            }
        });
        
        // placeholder
        $('input[placeholder], textarea[placeholder]').placeholder();
        
        // popover
        $("[data-toggle=popover]").popover();
        $(document).on('click', '.popover-title .close', function (e) {
            var $target = $(e.target), $popover = $target.closest('.popover').prev();
            $popover && $popover.popover('hide');
        });
        
        // ajax modal
        $(document).on('click', '[data-toggle="ajaxModal"]',
            function (e) {
                $('#ajaxModal').remove();
                e.preventDefault();
                var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal" id="ajaxModal"><div class="modal-body"></div></div>');
                $('body').append($modal);
                $modal.modal();
                $modal.load($remote);
            }
        );
        
        // dropdown menu
        $.fn.dropdown.Constructor.prototype.change = function (e) {
            e.preventDefault();
            var $item = $(e.target), $select, $checked = false, $menu, $label;
            !$item.is('a') && ($item = $item.closest('a'));
            $menu = $item.closest('.dropdown-menu');
            $label = $menu.parent().find('.dropdown-label');
            $labelHolder = $label.text();
            $select = $item.find('input');
            $checked = $select.is(':checked');
            if ($select.is(':disabled')) return;
            if ($select.attr('type') == 'radio' && $checked) return;
            if ($select.attr('type') == 'radio') $menu.find('li').removeClass('active');
            $item.parent().removeClass('active');
            !$checked && $item.parent().addClass('active');
            $select.prop("checked", !$select.prop("checked"));
            
            $items = $menu.find('li > a > input:checked');
            if ($items.length) {
                $text = [];
                $items.each(function () {
                    var $str = $(this).parent().text();
                    $str && $text.push($.trim($str));
                });
                
                $text = $text.length < 4 ? $text.join(', ') : $text.length + ' selected';
                $label.html($text);
            } else {
                $label.html($label.data('placeholder'));
            }
        }
        $(document).on('click.dropdown-menu', '.dropdown-select > li > a', $.fn.dropdown.Constructor.prototype.change);
        
        // tooltip
        $("[data-toggle=tooltip]").tooltip();
        
        // class
        $(document).on('click', '[data-toggle^="class"]', function (e) {
            e && e.preventDefault();
            var $this = $(e.target), $class, $target, $tmp, $classes, $targets;
            !$this.data('toggle') && ($this = $this.closest('[data-toggle^="class"]'));
            $class = $this.data()['toggle'];
            $target = $this.data('target') || $this.attr('href');
            $class && ($tmp = $class.split(':')[1]) && ($classes = $tmp.split(','));
            $target && ($targets = $target.split(','));
            $targets && $targets.length && $.each($targets, function (index, value) {
                ($targets[index] != '#') && $($targets[index]).toggleClass($classes[index]);
            });
            $this.toggleClass('active');
        });
        
        // panel toggle
        $(document).on('click', '.panel-toggle', function (e) {
            e && e.preventDefault();
            var $this = $(e.target), $class = 'collapse', $target;
            if (!$this.is('a')) $this = $this.closest('a');
            $target = $this.closest('.panel');
            $target.find('.panel-body').toggleClass($class);
            $this.toggleClass('active');
        });
        
        // carousel
        $('.carousel.auto').carousel();
        
        // button loading
        $(document).on('click.button.data-api', '[data-loading-text]', function (e) {
            var $this = $(e.target);
            $this.is('i') && ($this = $this.parent());
            $this.button('loading');
        });
        
        var scrollToTop = function () {
            !location.hash && setTimeout(function () {
                if (!pageYOffset) window.scrollTo(0, 0);
            }, 1000);
        };
        
        var $window = $(window);
        // mobile
        var mobile = function (option) {
            if (option == 'reset') {
                $('[data-toggle^="shift"]').shift('reset');
                return true;
            }
            scrollToTop();
            $('[data-toggle^="shift"]').shift('init');
            return true;
        };
        // unmobile
        $window.width() < 768 && mobile();
        // resize
        var $resize;
        $window.resize(function () {
            clearTimeout($resize);
            $resize = setTimeout(function () {
                $window.width() < 767 && mobile();
                $window.width() >= 768 && mobile('reset') && fixVbox();
            }, 500);
        });
        
        // fix vbox
        var fixVbox = function () {
            $('.ie11 .vbox').each(function () {
                $(this).height($(this).parent().height());
            });
        }
        fixVbox();
        
        // collapse nav
        $(document).on('click', '.nav-primary a', function (e) {
            var $this = $(e.target), $active;
            $this.is('a') || ($this = $this.closest('a'));
            if ($('.nav-vertical').length) {
                return;
            }
            
            $active = $this.parent().siblings(".active");
            $active && $active.find('> a').toggleClass('active') && $active.toggleClass('active').find('> ul:visible').slideUp(200);
            
            ($this.hasClass('active') && $this.next().slideUp(200)) || $this.next().slideDown(200);
            $this.toggleClass('active').parent().toggleClass('active');
            
            $this.next().is('ul') && e.preventDefault();
            
            setTimeout(function () {
                $(document).trigger('updateNav');
            }, 300);
        });
        
        // dropdown still
        $(document).on('click.bs.dropdown.data-api', '.dropdown .on, .dropup .on', function (e) {
            e.stopPropagation()
        });
        
    });
}(jQuery);