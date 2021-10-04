"use strict";


import Echo from 'laravel-echo';
require('select2');
require('../../../core/js/vendors/plugins/select2.init.js');

var getCsrfToken = function () {
    return $('meta[name=csrf-token]').attr('content')
}
// Class definition
var KTApp = function () {
    var initPageLoader = function () {
        // CSS3 Transitions only after page load(.page-loading class added to body tag and remove with JS on page load)
        KTUtil.removeClass(document.body, 'page-loading');
    }



    var initBootstrapTooltip = function (el, options) {
        var delay = {};
        // Handle delay options
        if (el.hasAttribute('data-bs-delay-hide')) {
            delay['hide'] = el.getAttribute('data-bs-delay-hide');
        }

        if (el.hasAttribute('data-bs-delay-show')) {
            delay['show'] = el.getAttribute('data-bs-delay-show');
        }

        if (delay) {
            options['delay'] = delay;
        }

        // Check dismiss options
        if (el.hasAttribute('data-bs-dismiss') && el.getAttribute('data-bs-dismiss') == 'click') {
            options['dismiss'] = 'click';
        }

        // Initialize popover
        var tp = new bootstrap.Tooltip(el, options);

        // Handle dismiss
        if (options['dismiss'] && options['dismiss'] === 'click') {
            // Hide popover on element click
            el.addEventListener("click", function (e) {
                tp.hide();
            });
        }

        return tp;
    }

    var initBootstrapTooltips = function (el, options) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            initBootstrapTooltip(tooltipTriggerEl, {});
        });
    }

    var initBootstrapPopover = function (el, options) {
        var delay = {};

        // Handle delay options
        if (el.hasAttribute('data-bs-delay-hide')) {
            delay['hide'] = el.getAttribute('data-bs-delay-hide');
        }

        if (el.hasAttribute('data-bs-delay-show')) {
            delay['show'] = el.getAttribute('data-bs-delay-show');
        }

        if (delay) {
            options['delay'] = delay;
        }

        // Handle dismiss option
        if (el.getAttribute('data-bs-dismiss') == 'true') {
            options['dismiss'] = true;
        }

        if (options['dismiss'] === true) {
            options['template'] = '<div class="popover" role="tooltip"><div class="popover-arrow"></div><span class="popover-dismiss btn btn-icon"><i class="bi bi-x fs-2"></i></span><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        }

        // Initialize popover
        var popover = new bootstrap.Popover(el, options);

        // Handle dismiss click
        if (options['dismiss'] === true) {
            var dismissHandler = function (e) {
                popover.hide();
            }

            el.addEventListener('shown.bs.popover', function () {
                var dismissEl = document.getElementById(el.getAttribute('aria-describedby'));
                dismissEl.addEventListener('click', dismissHandler);
            });

            el.addEventListener('hide.bs.popover', function () {
                var dismissEl = document.getElementById(el.getAttribute('aria-describedby'));
                dismissEl.removeEventListener('click', dismissHandler);
            });
        }

        return popover;
    }

    var initBootstrapPopovers = function () {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));

        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            initBootstrapPopover(popoverTriggerEl, {});
        });
    }

    var initScrollSpy = function () {
        var elements = [].slice.call(document.querySelectorAll('[data-bs-spy="scroll"]'));

        elements.map(function (element) {
            var sel = element.getAttribute('data-bs-target');
            var scrollContent = document.querySelector(element.getAttribute('data-bs-target'));
            var scrollSpy = bootstrap.ScrollSpy.getInstance(scrollContent);
            if (scrollSpy) {
                scrollSpy.refresh();
            }
        });
    }

    var initButtons = function () {
        var buttonsGroup = [].slice.call(document.querySelectorAll('[data-kt-buttons="true"]'));

        buttonsGroup.map(function (group) {
            var selector = group.hasAttribute('data-kt-buttons-target') ? group.getAttribute('data-kt-buttons-target') : '.btn';

            // Toggle Handler
            KTUtil.on(group, selector, 'click', function (e) {
                var buttons = [].slice.call(group.querySelectorAll(selector + '.active'));

                buttons.map(function (button) {
                    button.classList.remove('active');
                });

                this.classList.add('active');
            });
        });
    }

    var initCheck = function () {
        // Toggle Handler
        KTUtil.on(document.body, '[data-kt-check="true"]', 'change', function (e) {
            var check = this;
            var targets = document.querySelectorAll(check.getAttribute('data-kt-check-target'));

            KTUtil.each(targets, function (target) {
                if (target.type == 'checkbox') {
                    target.checked = check.checked;
                } else {
                    target.classList.toggle('active');
                }
            });
        });
    }

    var initSelect2 = function () {
        var elements = [].slice.call(document.querySelectorAll('[data-control="select2"], [data-kt-select2="true"]'));

        elements.map(function (element) {
            var options = {
                dir: document.body.getAttribute('direction')
            };

            if (element.getAttribute('data-hide-search') == 'true') {
                options.minimumResultsForSearch = Infinity;
            }

            $(element).select2(options);
        });
    }

    var initAutosize = function () {
        var inputs = [].slice.call(document.querySelectorAll('[data-kt-autosize="true"]'));

        inputs.map(function (input) {
            autosize(input);
        });
    }

    var initCountUp = function () {
        var elements = [].slice.call(document.querySelectorAll('[data-kt-countup="true"]:not(.counted)'));

        elements.map(function (element) {
            if (KTUtil.isInViewport(element) && KTUtil.visible(element)) {
                var options = {};

                var value = element.getAttribute('data-kt-countup-value');
                value = parseFloat(value.replace(/,/, ''));

                if (element.hasAttribute('data-kt-countup-start-val')) {
                    options.startVal = parseFloat(element.getAttribute('data-kt-countup-start-val'));
                }

                if (element.hasAttribute('data-kt-countup-duration')) {
                    options.duration = parseInt(element.getAttribute('data-kt-countup-duration'));
                }

                if (element.hasAttribute('data-kt-countup-decimal-places')) {
                    options.decimalPlaces = parseInt(element.getAttribute('data-kt-countup-decimal-places'));
                }

                if (element.hasAttribute('data-kt-countup-prefix')) {
                    options.prefix = element.getAttribute('data-kt-countup-prefix');
                }

                if (element.hasAttribute('data-kt-countup-suffix')) {
                    options.suffix = element.getAttribute('data-kt-countup-suffix');
                }

                var count = new countUp.CountUp(element, value, options);

                count.start();

                element.classList.add('counted');
            }
        });
    }

    var initCountUpTabs = function () {
        // Initial call
        initCountUp();

        // Window scroll event handler
        window.addEventListener('scroll', initCountUp);

        // Tabs shown event handler
        var tabs = [].slice.call(document.querySelectorAll('[data-kt-countup-tabs="true"][data-bs-toggle="tab"]'));
        tabs.map(function (tab) {
            tab.addEventListener('shown.bs.tab', initCountUp);
        });
    }

    var initTinySliders = function () {
        // Init Slider
        var initSlider = function (el) {
            if (!el) {
                return;
            }

            const tnsOptions = {};

            // Convert string boolean
            const checkBool = function (val) {
                if (val === 'true') {
                    return true;
                }
                if (val === 'false') {
                    return false;
                }
                return val;
            };

            // get extra options via data attributes
            el.getAttributeNames().forEach(function (attrName) {
                // more options; https://github.com/ganlanyuan/tiny-slider#options
                if ((/^data-tns-.*/g).test(attrName)) {
                    let optionName = attrName.replace('data-tns-', '').toLowerCase().replace(/(?:[\s-])\w/g, function (match) {
                        return match.replace('-', '').toUpperCase();
                    });

                    if (attrName === 'data-tns-responsive') {
                        // fix string with a valid json
                        const jsonStr = el.getAttribute(attrName).replace(/(\w+:)|(\w+ :)/g, function (matched) {
                            return '"' + matched.substring(0, matched.length - 1) + '":';
                        });
                        try {
                            // convert json string to object
                            tnsOptions[optionName] = JSON.parse(jsonStr);
                        }
                        catch (e) {
                        }
                    }
                    else {
                        tnsOptions[optionName] = checkBool(el.getAttribute(attrName));
                    }
                }
            });

            const opt = Object.assign({}, {
                container: el,
                slideBy: 'page',
                autoplay: true,
                autoplayButtonOutput: false,
            }, tnsOptions);

            if (el.closest('.tns')) {
                KTUtil.addClass(el.closest('.tns'), 'tns-initiazlied');
            }

            return tns(opt);
        }

        // Sliders
        const elements = Array.prototype.slice.call(document.querySelectorAll('[data-tns="true"]'), 0);

        if (!elements && elements.length === 0) {
            return;
        }

        elements.forEach(function (el) {
            initSlider(el);
        });
    }

    var initSmoothScroll = function () {
        if (SmoothScroll) {
            new SmoothScroll('a[data-kt-scroll-toggle][href*="#"]', {
                offset: function (anchor, toggle) {
                    // Integer or Function returning an integer. How far to offset the scrolling anchor location in pixels
                    // This example is a function, but you could do something as simple as `offset: 25`

                    // An example returning different values based on whether the clicked link was in the header nav or not
                    if (anchor.hasAttribute('data-kt-scroll-offset')) {
                        var val = KTUtil.getResponsiveValue(anchor.getAttribute('data-kt-scroll-offset'));

                        return val;
                    } else {
                        return 0;
                    }
                }
            });
        }
    }
    var initDebug = function (e) {
        $('.dropdown-menu').on('click', function (e) {
            e.stopPropagation();
        });
        $('.table-responsive').on('show.bs.dropdown', function () {
            $('.table-responsive').css("overflow", "inherit");
        });
        $('.table-responsive').on('hide.bs.dropdown', function () {
            $('.table-responsive').css("overflow", "auto");
        })
    }

   
    var initAjaxModal = function () {
        // Ajax modal 
        $('body').on('click', '[data-act=ajax-modal]', function () {
            var data = { ajaxModal: 1, "_token": getCsrfToken() },
                url = $(this).attr('data-action-url'),
                // crud = $(this).attr('data-crud'),
                isLargeModal = $(this).attr('data-modal-lg'),
                title = $(this).attr('data-title'),
                $this = $("#ajax-modal");
            if (!url) {
                console.log('Ajax Modal: Set data-action-url!');
                return false;
            }
            if (title) {
                $("#ajax-modal-title").html(title);
            } else {
                $("#ajax-modal-title").text($("#ajax-modal-title").attr('title'));
            }

            $("#ajax-modal-content").html($("#ajax-modal-original-content").html());
            $("#ajax-modal-original-content").css("display", "none");
            $("#ajax-modal-content").find(".original-modal-body").removeClass("original-modal-body").addClass("modal-body");

            $(this).each(function () {
                $.each(this.attributes, function () {
                    if (this.specified && this.name.match("^data-post-")) {
                        var dataName = this.name.replace("data-post-", "");
                        data[dataName] = this.value;
                    }
                });
            });
            $("#trigger-ajax-modal").trigger("click")
            $.ajax({
                url: url,
                data: data,
                cache: false,
                type: 'POST',
                success: function (response) {

                    $this.find('.modal-dialog').removeClass("modal-sm");
                    if (isLargeModal) {
                        $this.find('.modal-dialog').addClass("modal-lg")
                    }
                    $("#ajax-modal-content").html(response);

                    // $("#ajax-modal-content").addClass("scroll h-"+600+"px px-5")
                },
                statusCode: {
                    404: function () {
                        $("#ajax-modal-content").find('.modal-body modal-body-content').html("");
                        // appAlert.error("404:  Page or url action not found.", { container: '.modal-body', animate: false });
                    }
                },
                error: function () {
                    $("#ajax-modal-content").find('.modal-body modal-body-content').html("");
                    // appAlert.error("500: Internal Server Error.", { container: '.modal-body', animate: false });
                }
            });
            return false;
        });



    }

    var initLaravelEcho = function () {
        window.Pusher = require('pusher-js');
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: process.env.MIX_PUSHER_APP_KEY,
            cluster: process.env.MIX_PUSHER_APP_CLUSTER,
            forceTLS: true
        });
    }
    var listingLaravelEcho = function () {
        console.log("listLaravelEcho")
        window.Echo.private('App.Models.User.' + authUser.id)
            .notification((notification) => {
                hadleNotification(notification)
            });
    }

    return {
        init: function () {
            this.initPageLoader();

            this.initBootstrapTooltips();

            this.initBootstrapPopovers();

            this.initScrollSpy();


            this.initButtons();

            this.initCheck();

            this.initSelect2();

            this.initCountUp();

            this.initCountUpTabs();

            this.initAutosize();

            this.initTinySliders();

            this.initSmoothScroll();

            this.initAjaxModal();

            this.initLaravelEcho();
           
            this.listingLaravelEcho();

            this.initDebug();



        },
        initAjaxModal: function () {
            initAjaxModal()
        },
        initPageLoader: function () {
            initPageLoader();
        },

        initBootstrapTooltip: function (el, options) {
            return initBootstrapTooltip(el, options);
        },

        initBootstrapTooltips: function () {
            initBootstrapTooltips();
        },

        initBootstrapPopovers: function () {
            initBootstrapPopovers();
        },

        initBootstrapPopover: function (el, options) {
            return initBootstrapPopover(el, options);
        },

        initScrollSpy: function () {
            initScrollSpy();
        },

        initButtons: function () {
            initButtons();
        },

        initCheck: function () {
            initCheck();
        },

        initSelect2: function () {
            initSelect2();
        },

        initCountUp: function () {
            initCountUp();
        },

        initCountUpTabs: function () {
            initCountUpTabs();
        },

        initAutosize: function () {
            initAutosize();
        },

        initTinySliders: function () {
            initTinySliders();
        },

        initSmoothScroll: function () {
            initSmoothScroll();
        },

        isDarkMode: function () {
            return document.body.classList.contains('dark-mode');
        },

        initAjaxModal: function () {
            initAjaxModal()
        },

        initDebug: function () {
            initDebug()
        },
        initLaravelEcho: function () {
            initLaravelEcho()
        },
        listingLaravelEcho: function () {
            listingLaravelEcho()
        },

    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTApp.init();
});

// On window load
window.addEventListener("load", function () {
    KTApp.initPageLoader();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = KTApp;
}
