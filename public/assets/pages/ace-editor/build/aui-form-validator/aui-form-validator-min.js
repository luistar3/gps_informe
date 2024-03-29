AUI.add(
    "aui-form-validator",
    function (s) {
        var ap = s.Lang,
            z = s.Object,
            O = ap.isBoolean,
            H = ap.isDate,
            x = z.isEmpty,
            t = ap.isFunction,
            Z = ap.isObject,
            o = ap.isString,
            d = ap.trim,
            l = function (A) {
                return A instanceof s.Node;
            },
            W = s.DOM._getRegExp,
            q = "form-validator",
            F = ".",
            D = "",
            y = "input,select,textarea,button",
            c = "Invalid Date",
            I = "|",
            n = "blur",
            N = "errorField",
            ab = "input",
            G = "submitError",
            k = "validateField",
            C = "validField",
            ao = "aria-required",
            ak = "boundingBox",
            i = "checkbox",
            g = "container",
            ah = "containerErrorClass",
            S = "containerValidClass",
            Q = "error",
            al = "errorClass",
            an = "extractRules",
            r = "field",
            af = "fieldContainer",
            Y = "fieldStrings",
            aj = "focus",
            ai = "labelCssClass",
            X = "message",
            b = "messageContainer",
            P = "name",
            V = "radio",
            p = "rules",
            aa = "selectText",
            ae = "showAllMessages",
            B = "showMessages",
            M = "stack",
            m = "stackErrorContainer",
            a = "strings",
            f = "submit",
            u = "type",
            ad = "valid",
            U = "validClass",
            E = "validateOnBlur",
            T = "validateOnInput",
            j = s.getClassName,
            am = j(q, Q),
            w = j(q, Q, g),
            h = j(q, ad),
            ac = j(q, ad, g),
            J = j(r),
            e = j(q, X),
            v = j(q, M, Q),
            ag = '<div class="' + e + '" role="alert"></div>',
            R = '<label class="' + v + '"></label>';
        YUI.AUI.defaults.FormValidator = {
            STRINGS: {
                DEFAULT: 'Por favor, arregle este campo.',
                acceptFiles: 'Por favor, introduzca un valor con una extensión válida ({0}).',
                alpha: 'Por favor, introduzca sólo caracteres alfabéticos.',
                alphanum: 'Por favor, introduzca sólo caracteres alfanuméricos.',
                date: 'Por favor, introduzca una fecha válida.',
                digits: 'Por favor, introduzca sólo dígitos.',
                email: 'Por favor, introduzca una dirección de correo electrónico válida.',
                equalTo: 'Por favor, introduzca el mismo valor.',
                iri: 'Por favor, introduzca un IRI válido.',
                max: 'Por favor, introduzca un valor menor o igual a {0}.',
                maxLength: 'Por favor, no introduzca más de {0} caracteres.',
                min: 'Por favor, introduzca un valor mayor o igual a {0}..',
                minLength: 'Por favor, introduzca al menos {0} caracteres.',
                number: 'Por favor, introduzca un número válido.',
                range: 'Por favor, introduzca un valor entre {0} y {1}.',
                rangeLength: 'Por favor, introduzca un valor entre {0} y {1} caracteres.',
                required: 'Este campo es obligatorio',
                url: 'Por favor, introduzca una URL válida.'
            },
            REGEX: {
                alpha: /^[a-z_]+$/i,
                alphanum: /^\w+$/,
                digits: /^\d+$/,
                email: /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,
                iri: /^([a-z]([a-z]|\d|\+|-|\.)*):(\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?((\[(|(v[\da-f]{1,}\.(([a-z]|\d|-|\.|_|~)|[!\$&'\(\)\*\+,;=]|:)+))\])|((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=])*)(:\d*)?)(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*|(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)){0})(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                number: /^[+\-]?(\d+([.,]\d+)?)+$/,
                url: /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)*(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
            },
            RULES: {
                acceptFiles: function (at, ar, au) {
                    var aq = null;
                    if (o(au)) {
                        var A = au.replace(/\./g, "").split(/,\s*|\b\s*/);
                        A = s.Array.map(A, s.Escape.regex);
                        aq = W("[.](" + A.join(I) + ")$", "i");
                    }
                    return aq && aq.test(at);
                },
                date: function (ar, aq, at) {
                    var A = new Date(ar);
                    return H(A) && A !== c && !isNaN(A);
                },
                equalTo: function (ar, aq, at) {
                    var A = s.one(at);
                    return A && d(A.val()) === ar;
                },
                max: function (aq, A, ar) {
                    return ap.toFloat(aq) <= ar;
                },
                maxLength: function (aq, A, ar) {
                    return aq.length <= ar;
                },
                min: function (aq, A, ar) {
                    return ap.toFloat(aq) >= ar;
                },
                minLength: function (aq, A, ar) {
                    return aq.length >= ar;
                },
                range: function (ar, aq, at) {
                    var A = ap.toFloat(ar);
                    return A >= at[0] && A <= at[1];
                },
                rangeLength: function (ar, aq, at) {
                    var A = ar.length;
                    return A >= at[0] && A <= at[1];
                },
                required: function (au, ar, av) {
                    var A = this;
                    if (s.FormValidator.isCheckable(ar)) {
                        var aq = ar.get(P),
                            at = s.all(A.getFieldsByName(aq));
                        return at.filter(":checked").size() > 0;
                    } else {
                        return !!au;
                    }
                },
            },
        };
        var L = YUI.AUI.defaults.FormValidator;
        var K = s.Component.create({
            NAME: q,
            ATTRS: {
                boundingBox: { setter: s.one },
                containerErrorClass: { value: w, validator: o },
                containerValidClass: { value: ac, validator: o },
                errorClass: { value: am, validator: o },
                extractRules: { value: true, validator: O },
                fieldContainer: { value: F + J },
                fieldStrings: { value: {}, validator: Z },
                labelCssClass: { validator: o, value: "aui-field-label" },
                messageContainer: {
                    getter: function (A) {
                        return s.Node.create(A).clone();
                    },
                    value: ag,
                },
                strings: {
                    valueFn: function () {
                        return L.STRINGS;
                    },
                },
                rules: {
                    getter: function (aq) {
                        var A = this;
                        if (!A._rulesAlreadyExtracted) {
                            A._extractRulesFromMarkup(aq);
                        }
                        return aq;
                    },
                    validator: Z,
                    value: {},
                },
                selectText: { value: true, validator: O },
                showMessages: { value: true, validator: O },
                showAllMessages: { value: false, validator: O },
                stackErrorContainer: {
                    getter: function (A) {
                        return s.Node.create(A).clone();
                    },
                    value: R,
                },
                validateOnBlur: { value: true, validator: O },
                validateOnInput: { value: false, validator: O },
                validClass: { value: h, validator: o },
            },
            isCheckable: function (aq) {
                var A = aq.get(u).toLowerCase();
                return A === i || A === V;
            },
            EXTENDS: s.Base,
            prototype: {
                initializer: function () {
                    var A = this;
                    A.errors = {};
                    A._blurHandlers = null;
                    A._inputHandlers = null;
                    A._rulesAlreadyExtracted = false;
                    A._stackErrorContainers = {};
                    A.bindUI();
                    A._uiSetValidateOnBlur(A.get(E));
                    A._uiSetValidateOnInput(A.get(T));
                },
                bindUI: function () {
                    var A = this,
                        aq = A.get(ak);
                    var ar = aq.delegate(
                        aj,
                        function (at) {
                            A._setARIARoles();
                            ar.detach();
                        },
                        y
                    );
                    A.publish({ errorField: { defaultFn: A._defErrorFieldFn }, validField: { defaultFn: A._defValidFieldFn }, validateField: { defaultFn: A._defValidateFieldFn } });
                    aq.on({ reset: s.bind(A._onFormReset, A), submit: s.bind(A._onFormSubmit, A) });
                    A.after("extractRulesChange", A._afterExtractRulesChange);
                    A.after("validateOnBlurChange", A._afterValidateOnBlurChange);
                    A.after("validateOnInputChange", A._afterValidateOnInputChange);
                },
                addFieldError: function (at, ar) {
                    var A = this,
                        au = A.errors,
                        aq = at.get(P);
                    if (!au[aq]) {
                        au[aq] = [];
                    }
                    au[aq].push(ar);
                },
                clearFieldError: function (aq) {
                    var A = this;
                    var ar = l(aq) ? aq.get(P) : aq;
                    if (o(ar)) {
                        delete A.errors[ar];
                    }
                },
                eachRule: function (aq) {
                    var A = this;
                    s.each(A.get(p), function (ar, at) {
                        if (t(aq)) {
                            aq.apply(A, [ar, at]);
                        }
                    });
                },
                findFieldContainer: function (aq) {
                    var A = this,
                        ar = A.get(af);
                    if (ar) {
                        return aq.ancestor(ar);
                    }
                },
                focusInvalidField: function () {
                    var A = this,
                        aq = A.get(ak),
                        ar = aq.one(F + am);
                    if (ar) {
                        if (A.get(aa)) {
                            ar.selectText();
                        }
                        ar.focus();
                    }
                },
                getField: function (aq) {
                    var A = this;
                    if (o(aq)) {
                        aq = A.getFieldsByName(aq);
                        if (aq && aq.length && !aq.name) {
                            aq = aq[0];
                        }
                    }
                    return s.one(aq);
                },
                getFieldsByName: function (ar) {
                    var A = this,
                        aq = A.get(ak).getDOM();
                    return aq.elements[ar];
                },
                getFieldError: function (aq) {
                    var A = this;
                    return A.errors[aq.get(P)];
                },
                getFieldStackErrorContainer: function (at) {
                    var A = this,
                        aq = l(at) ? at.get(P) : at,
                        ar = A._stackErrorContainers;
                    if (!ar[aq]) {
                        ar[aq] = A.get(m);
                    }
                    return ar[aq];
                },
                getFieldErrorMessage: function (av, au) {
                    var aw = this,
                        ay = av.get(P),
                        aq = aw.get(Y)[ay] || {},
                        A = aw.get(p)[ay],
                        ax = aw.get(a),
                        at = {};
                    if (au in A) {
                        var ar = s.Array(A[au]);
                        s.each(ar, function (aB, aA) {
                            at[aA] = [aB].join(D);
                        });
                    }
                    var az = aq[au] || ax[au] || ax.DEFAULT;
                    return ap.sub(az, at);
                },
                hasErrors: function () {
                    var A = this;
                    return !x(A.errors);
                },
                highlight: function (at, ar) {
                    var A = this,
                        au,
                        av,
                        aq;
                    if (at) {
                        au = A.findFieldContainer(at);
                        av = at.get(P);
                        if (this.validatable(at)) {
                            aq = s.all(A.getFieldsByName(av));
                            aq.each(function (aw) {
                                A._highlightHelper(aw, A.get(al), A.get(U), ar);
                            });
                            if (au) {
                                A._highlightHelper(au, A.get(ah), A.get(S), ar);
                            }
                        } else {
                            if (!at.val()) {
                                A.resetField(av);
                            }
                        }
                    }
                },
                normalizeRuleValue: function (aq) {
                    var A = this;
                    return t(aq) ? aq.apply(A) : aq;
                },
                unhighlight: function (aq) {
                    var A = this;
                    A.highlight(aq, true);
                },
                printStackError: function (ar, aq, at) {
                    var A = this;
                    if (!A.get(ae)) {
                        at = at.slice(0, 1);
                    }
                    aq.empty();
                    s.each(at, function (av, au) {
                        var aw = A.getFieldErrorMessage(ar, av),
                            ax = A.get(b).addClass(av);
                        aq.append(ax.html(aw));
                    });
                },
                resetAllFields: function () {
                    var A = this;
                    A.eachRule(function (aq, ar) {
                        A.resetField(ar);
                    });
                },
                resetField: function (at) {
                    var A = this,
                        au,
                        ar,
                        aq;
                    au = l(at) ? at.get(P) : at;
                    A.clearFieldError(au);
                    aq = A.getFieldStackErrorContainer(au);
                    aq.remove();
                    ar = s.all(A.getFieldsByName(au));
                    ar.each(function (av) {
                        A.resetFieldCss(av);
                    });
                },
                resetFieldCss: function (ar) {
                    var aq = this,
                        at = aq.findFieldContainer(ar);
                    var A = function (av, au) {
                        if (av) {
                            s.each(au, function (aw) {
                                av.removeClass(aq.get(aw));
                            });
                        }
                    };
                    A(ar, [U, al]);
                    A(at, [S, ah]);
                },
                validatable: function (ar) {
                    var A = this,
                        aq = false,
                        au = A.get(p)[ar.get(P)];
                    if (au) {
                        var at = A.normalizeRuleValue(au.required);
                        aq = at || (!at && L.RULES.required.apply(A, [ar.val(), ar])) || au.custom;
                    }
                    return !!aq;
                },
                validate: function () {
                    var A = this;
                    A.eachRule(function (aq, ar) {
                        A.validateField(ar);
                    });
                    A.focusInvalidField();
                },
                validateField: function (at) {
                    var A = this;
                    A.resetField(at);
                    var ar = o(at) ? A.getField(at) : at;
                    if (l(ar)) {
                        var aq = A.validatable(ar);
                        if (aq) {
                            A.fire(k, { validator: { field: ar } });
                        }
                    }
                },
                _afterExtractRulesChange: function (aq) {
                    var A = this;
                    A._uiSetExtractRules(aq.newVal);
                },
                _afterValidateOnInputChange: function (aq) {
                    var A = this;
                    A._uiSetValidateOnInput(aq.newVal);
                },
                _afterValidateOnBlurChange: function (aq) {
                    var A = this;
                    A._uiSetValidateOnBlur(aq.newVal);
                },
                _defErrorFieldFn: function (au) {
                    var A = this,
                        ar,
                        ax,
                        av,
                        at,
                        aw,
                        aq;
                    aq = au.validator;
                    ax = aq.field;
                    A.highlight(ax);
                    if (A.get(B)) {
                        aw = ax;
                        at = A.getFieldStackErrorContainer(ax);
                        av = ax.get("nextSibling");
                        if (av && av.get("nodeType") === 3) {
                            ar = ax.ancestor();
                            if (ar && ar.hasClass(A.get(ai))) {
                                aw = av;
                            }
                        }
                        aw.placeAfter(at);
                        A.printStackError(ax, at, aq.errors);
                    }
                },
                _defValidFieldFn: function (aq) {
                    var A = this;
                    var ar = aq.validator.field;
                    A.unhighlight(ar);
                },
                _defValidateFieldFn: function (ar) {
                    var aq = this;
                    var at = ar.validator.field;
                    var au = aq.get(p)[at.get(P)];
                    s.each(au, function (ay, aw) {
                        var ax = L.RULES[aw];
                        var av = d(at.val());
                        ay = aq.normalizeRuleValue(ay);
                        if (t(ax) && !ax.apply(aq, [av, at, ay])) {
                            aq.addFieldError(at, aw);
                        }
                    });
                    var A = aq.getFieldError(at);
                    if (A) {
                        aq.fire(N, { validator: { field: at, errors: A } });
                    } else {
                        aq.fire(C, { validator: { field: at } });
                    }
                },
                _highlightHelper: function (at, A, aq, ar) {
                    if (ar) {
                        at.removeClass(A).addClass(aq);
                    } else {
                        at.removeClass(aq).addClass(A);
                    }
                },
                _extractRulesFromMarkup: function (aF) {
                    var aD = this,
                        ay = aD.get(ak).getDOM(),
                        aq = ay.elements,
                        ax = z.keys(L.RULES),
                        aC = ax.join("|"),
                        aB = W("aui-field-(" + aC + ")", "g"),
                        aw,
                        at,
                        aG = [],
                        A = function (aI, aH) {
                            aG.push(aH);
                        };
                    for (aw = 0, at = aq.length; aw < at; aw++) {
                        var ar = aq[aw],
                            aE = ar.name;
                        ar.className.replace(aB, A);
                        if (aG.length) {
                            var au = aF[aE],
                                av,
                                az;
                            if (!au) {
                                au = {};
                                aF[aE] = au;
                            }
                            for (av = 0, az = aG.length; av < az; av++) {
                                var aA = aG[av];
                                if (!(aA in au)) {
                                    au[aA] = true;
                                }
                            }
                            aG.length = 0;
                        }
                    }
                    aD._rulesAlreadyExtracted = true;
                },
                _onFieldInput: function (aq) {
                    var A = this;
                    A.validateField(aq.target);
                },
                _onFormSubmit: function (aq) {
                    var A = this;
                    var ar = { validator: { formEvent: aq } };
                    A.validate();
                    if (A.hasErrors()) {
                        ar.validator.errors = A.errors;
                        A.fire(G, ar);
                        aq.halt();
                    } else {
                        A.fire(f, ar);
                    }
                },
                _onFormReset: function (aq) {
                    var A = this;
                    A.resetAllFields();
                },
                _setARIARoles: function () {
                    var A = this;
                    A.eachRule(function (ar, at) {
                        if (ar.required) {
                            var aq = A.getField(at);
                            if (aq && !aq.attr(ao)) {
                                aq.attr(ao, true);
                            }
                        }
                    });
                },
                _uiSetExtractRules: function (aq) {
                    var A = this;
                    if (aq) {
                        A._extractRulesFromMarkup(A.get(p));
                    }
                },
                _uiSetValidateOnInput: function (ar) {
                    var A = this,
                        aq = A.get(ak);
                    if (ar) {
                        if (!A._inputHandlers) {
                            A._inputHandlers = aq.delegate(ab, A._onFieldInput, y, A);
                        }
                    } else {
                        if (A._inputHandlers) {
                            A._inputHandlers.detach();
                        }
                    }
                },
                _uiSetValidateOnBlur: function (ar) {
                    var A = this,
                        aq = A.get(ak);
                    if (ar) {
                        if (!A._blurHandlers) {
                            A._blurHandlers = aq.delegate(n, A._onFieldInput, y, A);
                        }
                    } else {
                        if (A._blurHandlers) {
                            A._blurHandlers.detach();
                        }
                    }
                },
            },
        });
        s.each(L.REGEX, function (aq, A) {
            L.RULES[A] = function (at, ar, au) {
                return L.REGEX[A].test(at);
            };
        });
        s.FormValidator = K;
    },
    "@VERSION@",
    { skinnable: false, requires: ["aui-base", "aui-event-input", "escape", "selector-css3"] }
);
