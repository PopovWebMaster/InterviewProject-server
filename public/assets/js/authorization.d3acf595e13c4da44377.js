!function(e){function t(t){for(var r,o,i=t[0],c=t[1],u=t[2],f=0,p=[];f<i.length;f++)o=i[f],Object.prototype.hasOwnProperty.call(a,o)&&a[o]&&p.push(a[o][0]),a[o]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(e[r]=c[r]);for(l&&l(t);p.length;)p.shift()();return s.push.apply(s,u||[]),n()}function n(){for(var e,t=0;t<s.length;t++){for(var n=s[t],r=!0,i=1;i<n.length;i++){var c=n[i];0!==a[c]&&(r=!1)}r&&(s.splice(t--,1),e=o(o.s=n[0]))}return e}var r={},a={1:0,5:0},s=[];function o(t){if(r[t])return r[t].exports;var n=r[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,o),n.l=!0,n.exports}o.m=e,o.c=r,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)o.d(n,r,function(t){return e[t]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="";var i=window.webpackJsonp=window.webpackJsonp||[],c=i.push.bind(i);i.push=t,i=i.slice();for(var u=0;u<i.length;u++)t(i[u]);var l=c;s.push([128,0]),n()}({120:function(e,t,n){var r=n(9),a=n(121);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[e.i,a,""]]);var s={insert:"head",singleton:!1};r(a,s);e.exports=a.locals||{}},121:function(e,t,n){},128:function(e,t,n){"use strict";n.r(t);var r=n(0),a=n.n(r),s=n(12),o=n.n(s),i=n(10),c=n.n(i),u=n(5),l=n.n(u),f=n(6),p=n.n(f),h=n(2),m=n.n(h),d=n(7),v=n.n(d),b=n(8),_=n.n(b),g=n(1),y=n.n(g),E=(n(26),n(120),n(4)),S=n(17),k=n(16),M=n(21),R=n(22),N=n(3),O=n(15);function A(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=y()(e);if(t){var a=y()(this).constructor;n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments);return _()(this,n)}}var I=function(e){v()(n,e);var t=A(n);function n(e){var r,a;return l()(this,n),(a=t.call(this,e)).state=(r={},c()(r,E.b.EMAIL,{value:a.props.massage[E.b.EMAIL].value,isError:a.props.massage[E.b.EMAIL].isError,errorMassage:a.props.massage[E.b.EMAIL].errorMassage,valueIsShecked:!1}),c()(r,E.b.PASSWORD,{value:a.props.massage[E.b.PASSWORD].value,isError:a.props.massage[E.b.PASSWORD].isError,errorMassage:a.props.massage[E.b.PASSWORD].errorMassage,valueIsShecked:!1}),c()(r,"is_email_confirmed",a.props.massage.is_email_confirmed),r),a.handler_submit_success=a.handler_submit_success.bind(m()(a)),a.handler_submit_unsuccess=a.handler_submit_unsuccess.bind(m()(a)),a.send_email_again=a.send_email_again.bind(m()(a)),a}return p()(n,[{key:"handler_submit_success",value:function(e){window.location.href=e.href}},{key:"handler_submit_unsuccess",value:function(e){if(Object(N.a)(e.is_email_confirmed)){var t=void 0;"boolean"==typeof e.is_email_confirmed?t=e.is_email_confirmed:"true"===e.is_email_confirmed?t=!0:"false"===e.is_email_confirmed&&(t=!1),void 0!==t&&this.setState({is_email_confirmed:t})}this.setInputResponseFromServer(e.inputResponse),Object(R.a)()}},{key:"send_email_again",value:function(){var e=this.props.massage.href_for_post,t=this.props.massage.action.confirmEmailAgain,n={inputName:"email",value:this.state[E.b.EMAIL].value};Object(O.a)({href:e,action:t,data:n,successCallback:function(e){e.ok?window.location.href=e.href:console.error(e.errorMassage)},errorCallback:function(){console.log("Ошибка, что-то при отправке на сервер не сработало")}})}},{key:"render",value:function(){return a.a.createElement("div",{className:E.a.AUTH_FORM},a.a.createElement("div",{className:E.a.FORM_NAME},"Вход на сайт"),this.state.is_email_confirmed?"":a.a.createElement("div",{className:E.a.AUTH_MASSAGE},a.a.createElement("p",null,"Данный e-mail адрес не был подтверждён. ",a.a.createElement("br",null),a.a.createElement("span",{onClick:this.send_email_again},"Отправить письмо подтверждения повторно?"))),a.a.createElement("form",{role:"form"},a.a.createElement(k.a,{label:"E-Mail",inputName:E.b.EMAIL,type:"email",setValue:this.setValue,resetTheError:this.resetTheError,checkTheValue:this.checkTheValue,autocomplete:"off",max:this.getMaxLength(E.b.EMAIL),value:this.state[E.b.EMAIL].value,isError:this.state[E.b.EMAIL].isError,errorMassage:this.state[E.b.EMAIL].errorMassage,showSpin:this.state[E.b.EMAIL].valueIsShecked}),a.a.createElement(k.a,{label:"Пароль",inputName:E.b.PASSWORD,type:"password",setValue:this.setValue,resetTheError:this.resetTheError,checkTheValue:this.checkTheValue,autocomplete:"off",max:this.getMaxLength(E.b.PASSWORD),value:this.state[E.b.PASSWORD].value,isError:this.state[E.b.PASSWORD].isError,errorMassage:this.state[E.b.PASSWORD].errorMassage,showSpin:this.state[E.b.PASSWORD].valueIsShecked}),a.a.createElement(M.a,{submit:this.submit}),a.a.createElement("div",{className:E.a.LINK},a.a.createElement("a",{href:this.props.massage.href_to_register},"Регистрация"),""===this.props.massage.href_to_reset_password?"":a.a.createElement("a",{href:this.props.massage.href_to_reset_password},"Забыли пароль?"))))}}]),n}(S.a),T=n(13).store.getState().massageFromServer;o.a.render(a.a.createElement(I,{massage:T}),document.getElementById(T.section_id_name))},13:function(e,t,n){"use strict";n.r(t),n.d(t,"store",(function(){return te}));var r=n(0),a=n.n(r),s=(n(12),n(5)),o=n.n(s),i=n(6),c=n.n(i),u=n(7),l=n.n(u),f=n(8),p=n.n(f),h=n(1),m=n.n(h);function d(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=m()(e);if(t){var a=m()(this).constructor;n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments);return p()(this,n)}}r.Component;var v=n(2),b=n.n(v),_=function(){var e=!0;switch(ACTIVE_PAGE){case"registration":case"authorization":case"reset_password":e=!1}return e};function g(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=m()(e);if(t){var a=m()(this).constructor;n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments);return p()(this,n)}}r.Component;function y(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=m()(e);if(t){var a=m()(this).constructor;n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments);return p()(this,n)}}r.Component;var E="leftMenu",S="close_button",k="itemMenu",M="menu_start_button",R="menu_auth_button",N="data-open-status",O="cubic-bezier(0.445, 0.05, 0.55, 0.95)",A=n(3),I=function(){var e,t=document.getElementById(E).getAttribute(N);return Object(A.a)(t)?"true"===t?e=!0:"false"===t&&(e=!1):e=!1,e},T=function(){var e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],t=300,n=O;return e?"\n            opacity: 1;\n            left: 0em;\n            transition: left ".concat(t,"ms ").concat(n," 0s, opacity 0ms ").concat(n," 0ms;\n            \n        "):"\n            opacity: 1;\n            left: 0em;\n            transition: left 0ms ".concat(n," 0s, opacity 0ms ").concat(n," 0ms;\n        ")},w=function(e){var t=window.getComputedStyle(e);return(Math.abs(Number(parseFloat(t.width)))+Math.abs(Number(parseFloat(t.borderLeftWidth)))+Math.abs(Number(parseFloat(t.borderRightWidth)))+Math.abs(Number(parseFloat(t.paddingLeft)))+Math.abs(Number(parseFloat(t.paddingRight)))+Math.abs(Number(parseFloat(t.marginLeft)))+Math.abs(Number(parseFloat(t.marginRight))))/Math.abs(Number(parseFloat(t.fontSize)))},C=function(){var e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],t=document.getElementById(E),n=w(t),r=300,a=O;return e?"\n            opacity: 0;\n            left: -".concat(n,"em;\n            transition: left ").concat(r,"ms ").concat(a," 0s, opacity 0ms ").concat(a," ").concat(r,"ms;\n        "):"\n            opacity: 0;\n            left: -".concat(n,"em;\n            transition: left 0ms ").concat(a," 0s, opacity 0ms ").concat(a," 0ms;\n        ")},P=function(){var e,t;e=document.getElementById(E),t=I(),e.style.cssText=t?T(!1):C(!1)},x=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=document.getElementById(E),n=t.getAttribute(N);Object(A.a)(e)?t.setAttribute(N,e):Object(A.a)(n)?"true"===n?t.setAttribute(N,!1):"false"===n&&t.setAttribute(N,!0):t.setAttribute(N,!1)},L=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=document.getElementById(E),n=I();n&&(t.style.cssText=C(!0)),x(!1);var r=setTimeout((function(){t.style.display="none",Object(A.a)(e)&&"function"==typeof e&&e(),clearTimeout(r)}),300)},j=function(){!function(){var e=document.getElementById(E),t=I();if(e.style.display="flex",!t)var n=setTimeout((function(){e.style.cssText=T(!0),clearTimeout(n)}),100);x(!0)}()},D=function(){L()},V=function(e){(function(e){var t=!0;if(I()){var n=e.target;(n.closest("#".concat(E))||"menu_logo"===n.id)&&(t=!1)}else t=!1;return t})(e)&&L()};var F=function(e){var t=e.replace("menu_","");t=t.trim();var n=document.getElementById(t);if(null!==n){var r=n.offsetTop;window.scrollTo({top:r,behavior:"smooth"})}},B=function(e){L((function(){var t=e.target.id;if("/"===window.location.pathname)F(t);else{sessionStorage.setItem("section_id_name",t);var n=window.location.origin;window.location.href=n}}))},W=function(e){e.preventDefault(),L((function(){var e=document.getElementsByClassName(M)[0].querySelector("a").href;window.location.href=e}))},U=function(e){e.preventDefault(),L((function(){var e=document.getElementsByClassName(R)[0].querySelector("a").href;window.location.href=e}))},G=function(){var e=document.getElementById("menu_logo");e.addEventListener("click",j)},q=function(){var e=document.getElementsByClassName(S)[0];e.addEventListener("click",D)},H=function(){var e=document.getElementsByTagName("body")[0];e.addEventListener("click",V)},J=function(){for(var e=document.getElementsByClassName(k),t=0;t<e.length;t++)e[t].addEventListener("click",B)},K=function(){document.getElementsByClassName(M)[0].addEventListener("click",W)},z=function(){var e=document.getElementsByClassName(R)[0];Object(A.a)(e)&&e.addEventListener("click",U)},Q=(n(18),n(11)),X={},Y=Object(Q.a)({massageFromServer:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:X,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case"SET_MASSAGE_FROM_SERVER":return t.payload;default:return e}}}),Z={},$=document.getElementById("jsonMassage");Z=Object(A.a)($)?JSON.parse($.textContent):{error:"В html документе не обнаружен div#jsonMassage"},console.dir(Z);var ee=Z,te=Object(Q.b)(Y);te.dispatch(function(e){return{type:"SET_MASSAGE_FROM_SERVER",payload:e}}(ee)),function(){if(x(!1),P(),G(),q(),H(),J(),K(),z(),"/"===window.location.pathname){var e=sessionStorage.getItem("section_id_name");Object(A.a)(e)&&(F(e),sessionStorage.removeItem("section_id_name"))}}()},15:function(e,t,n){"use strict";n.d(t,"a",(function(){return c}));var r=n(20),a=n.n(r),s=n(23),o=n.n(s),i=n(3),c=function(e){var t=function(e){var t,n,r,a,s,o,c=!1,u=[];function l(e){c=!0,u.push(e)}if(t=function(){var e=null,t=document.querySelector('meta[name="csrf-token"]');Object(i.a)(t)&&(e=t.content);return e}(),!Object(i.a)(t)){l("Проблемы с токеном")}if(Object(i.a)(e.href))n=e.href;else{l("Не указан путь для отправки данных на сервер"),n=""}r=Object(i.a)(e.action)?e.action:"";a=Object(i.a)(e.data)?e.data:"";s=Object(i.a)(e.successCallback)?e.successCallback:function(){};o=Object(i.a)(e.errorCallback)?e.errorCallback:function(){};return{fail:c,errors:u,token:t,href:n,action:r,data:a,successCallback:s,errorCallback:o}}(e);if(t.fail)return console.error("Операция отправки данных на сервер остановлена"),void console.dir(t.errors);!function(e,t){u.apply(this,arguments)}(t.href,{_token:t.token,action:t.action,data:t.data,successCallback:t.successCallback,errorCallback:t.errorCallback})};function u(){return(u=o()(a.a.mark((function e(t,n){var r,s;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,fetch(t,{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({_token:n._token,action:n.action,data:n.data})});case 3:if(!(r=e.sent).ok){e.next=11;break}return e.next=7,r.json();case 7:s=e.sent,n.successCallback(s),e.next=13;break;case 11:n.errorCallback(),console.error("Ошибка HTTP: ".concat(r.status,"."));case 13:e.next=19;break;case 16:e.prev=16,e.t0=e.catch(0),console.error("Ошибка: ".concat(e.t0,". При попытке вызвать fetch"));case 19:case 20:case"end":return e.stop()}}),e,null,[[0,16]])})))).apply(this,arguments)}},16:function(e,t,n){"use strict";n.d(t,"a",(function(){return S}));var r=n(5),a=n.n(r),s=n(6),o=n.n(s),i=n(2),c=n.n(i),u=n(7),l=n.n(u),f=n(8),p=n.n(f),h=n(1),m=n.n(h),d=n(0),v=n.n(d),b=n(4),_=(n(28),".".concat(b.a.INPUT_WRAP," div input")),g=function(e){var t=function(e){for(var t=document.querySelectorAll(_),n=void 0,r=0;r<t.length;r++){if(t[r].id===e){n=r;break}}return n}(e.currentTarget.id);if(void 0!==t){var n=document.querySelectorAll(_),r=t+1;n[t].blur(),n.length>r&&n[r].focus()}else console.error('Ошибка в методе "set_the_focus_to_the_next_input()" при попытке установить focus на следующий input')};var y=n(3);function E(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=m()(e);if(t){var a=m()(this).constructor;n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments);return p()(this,n)}}var S=function(e){l()(n,e);var t=E(n);function n(e){var r;return a()(this,n),(r=t.call(this,e)).getInputClassName=r.getInputClassName.bind(c()(r)),r.setValue=r.setValue.bind(c()(r)),r.resetTheError=r.resetTheError.bind(c()(r)),r.checkTheValue=r.checkTheValue.bind(c()(r)),r.keydown_enter=r.keydown_enter.bind(c()(r)),r}return o()(n,[{key:"getInputClassName",value:function(e){return e?b.a.INPUT.INVALID:b.a.INPUT.VALID}},{key:"setValue",value:function(e){this.resetTheError(),this.props.setValue({inputName:this.props.inputName,value:e.target.value})}},{key:"resetTheError",value:function(){this.props.resetTheError({inputName:this.props.inputName})}},{key:"checkTheValue",value:function(){this.props.checkTheValue({inputName:this.props.inputName})}},{key:"keydown_enter",value:function(e){13===e.which&&(g(e),Object(y.a)(this.props.keydown_enter)&&this.props.keydown_enter())}},{key:"render",value:function(){return v.a.createElement("div",{className:b.a.INPUT_WRAP},v.a.createElement("label",{htmlFor:this.props.inputName},this.props.label+" ",this.props.showSpin?v.a.createElement("span",{className:b.a.SPIN}):""),v.a.createElement("div",null,v.a.createElement("input",{id:this.props.inputName,className:this.getInputClassName(this.props.isError),type:this.props.type,value:this.props.value,autoComplete:this.props.autocomplete,maxLength:this.props.max,onChange:this.setValue,onBlur:this.checkTheValue,onKeyDown:this.keydown_enter}),v.a.createElement("span",{className:b.a.ERROR_MASSAGE},v.a.createElement("strong",null,this.props.errorMassage))))}}]),n}(d.Component)},17:function(e,t,n){"use strict";n.d(t,"a",(function(){return k}));var r=n(10),a=n.n(r),s=n(5),o=n.n(s),i=n(6),c=n.n(i),u=n(2),l=n.n(u),f=n(7),p=n.n(f),h=n(8),m=n.n(h),d=n(1),v=n.n(d),b=n(0),_=n(4),g=n(15),y=n(3),E=function(){var e={};for(var t in _.b){e[_.b[t]]=!0}return e};function S(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=v()(e);if(t){var a=v()(this).constructor;n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments);return m()(this,n)}}var k=function(e){p()(n,e);var t=S(n);function n(e){var r;return o()(this,n),(r=t.call(this,e)).setValue=r.setValue.bind(l()(r)),r.resetTheError=r.resetTheError.bind(l()(r)),r.checkTheValue=r.checkTheValue.bind(l()(r)),r.get_params_to_send_to_the_server=r.get_params_to_send_to_the_server.bind(l()(r)),r.checking_for_errors=r.checking_for_errors.bind(l()(r)),r.submit=r.submit.bind(l()(r)),r.getMaxLength=r.getMaxLength.bind(l()(r)),r.setInputResponseFromServer=r.setInputResponseFromServer.bind(l()(r)),r.reset_input_values=r.reset_input_values.bind(l()(r)),r}return c()(n,[{key:"setInputResponseFromServer",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;if(Object(y.a)(e))for(var t in e)this.setState(a()({},t,{value:e[t].value,isError:e[t].isError,errorMassage:e[t].errorMassage,valueIsShecked:!1}));else console.error("Что-то не так с попыткой записать ответ от сервера в state")}},{key:"reset_input_values",value:function(){for(var e in _.b){var t=_.b[e];Object(y.a)(this.state[t])&&this.setState(a()({},t,{value:"",isError:!1,errorMassage:"",valueIsShecked:!1}))}}},{key:"getMaxLength",value:function(e){return Object(y.a)(this.props.massage.inputMaxLength)?Object(y.a)(this.props.massage.inputMaxLength[e])?Number(this.props.massage.inputMaxLength[e]):(console.error("Ошибка. Источник: getMaxLength(). Что-то не так с объектом inputMaxLength"),0):(console.error("Ошибка. Источник: getMaxLength().Отсутствует объект inputMaxLength"),0)}},{key:"setValue",value:function(e){var t=e.inputName,n=e.value,r=this.state[t];r.value=n,this.setState(a()({},t,r))}},{key:"resetTheError",value:function(e){var t=e.inputName,n=this.state[t];n.isError=!1,n.errorMassage="",this.setState(a()({},t,n))}},{key:"checkTheValue",value:function(e){var t=this,n=e.inputName,r=this.state[n];r.valueIsShecked=!0,this.setState(a()({},n,r));var s=this.props.massage.href_for_post,o=this.props.massage.action.checkField,i={inputName:n,value:this.state[n].value};Object(g.a)({href:s,action:o,data:i,successCallback:function(e){var n=e.inputName,r=e.value,s=e.isError,o=e.errorMassage;t.setState(a()({},n,{value:r,isError:s,errorMassage:o,valueIsShecked:!1})),n===_.b.CONFIRM_PASSWORD&&t.state[_.b.CONFIRM_PASSWORD].value!==t.state[_.b.PASSWORD].value&&t.setState(a()({},n,{value:r,isError:!0,errorMassage:"Была допущена ошибка при повторном вводе пароля",valueIsShecked:!1}))},errorCallback:function(){var e=t.state[n];e.valueIsShecked=!1,t.setState(a()({},n,e)),console.log("Ошибка, что-то не сработало во время отправки на сервер при проверке инпута")}})}},{key:"get_params_to_send_to_the_server",value:function(){return function(e){var t=e.state,n=E(),r={};for(var a in t)Object(y.a)(n[a])&&(r[a]=t[a].value);return r}({state:this.state})}},{key:"checking_for_errors",value:function(){var e=E(),t=!1;for(var n in this.state)if(Object(y.a)(e[n])&&!0===this.state[n].isError){t=!0;break}return t}},{key:"submit",value:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:void 0,n=this.props.massage.href_for_post,r=this.props.massage.action.tryToAccept,a=this.get_params_to_send_to_the_server(),s=function(n){void 0!==t&&t(),n.ok?e.handler_submit_success(n):e.handler_submit_unsuccess(n)},o=function(){void 0!==t&&t(),console.log("Ошибка, что-то при отправке на сервер не сработало")};Object(g.a)({href:n,action:r,data:a,successCallback:s,errorCallback:o})}}]),n}(b.Component)},18:function(e,t,n){var r=n(9),a=n(19);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[e.i,a,""]]);var s={insert:"head",singleton:!1};r(a,s);e.exports=a.locals||{}},19:function(e,t,n){},21:function(e,t,n){"use strict";n.d(t,"a",(function(){return g}));var r=n(5),a=n.n(r),s=n(6),o=n.n(s),i=n(2),c=n.n(i),u=n(7),l=n.n(u),f=n(8),p=n.n(f),h=n(1),m=n.n(h),d=n(0),v=n.n(d),b=(n(30),n(4));function _(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=m()(e);if(t){var a=m()(this).constructor;n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments);return p()(this,n)}}var g=function(e){l()(n,e);var t=_(n);function n(e){var r;return a()(this,n),(r=t.call(this,e)).state={data_is_being_sent:!1},r.actionSubmit=r.actionSubmit.bind(c()(r)),r}return o()(n,[{key:"actionSubmit",value:function(e){var t=this;e.preventDefault(),this.state.data_is_being_sent||(this.setState({data_is_being_sent:!0}),this.props.submit((function(){t.setState({data_is_being_sent:!1})})))}},{key:"render",value:function(){return v.a.createElement("button",{className:b.a.BUTTON,onClick:this.actionSubmit,onKeyDown:function(e){e.preventDefault()}},this.state.data_is_being_sent?v.a.createElement("span",{className:b.a.SPIN}):"Отправить")}}]),n}(n(17).a)},22:function(e,t,n){"use strict";n.d(t,"a",(function(){return s}));var r=n(4),a=".".concat(r.a.INPUT_WRAP," div input"),s=function(){for(var e=document.querySelectorAll(a),t=0;t<e.length;t++){var n=e[t];if(n.className===r.a.INPUT.INVALID){n.focus();break}}}},26:function(e,t,n){var r=n(9),a=n(27);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[e.i,a,""]]);var s={insert:"head",singleton:!1};r(a,s);e.exports=a.locals||{}},27:function(e,t,n){},28:function(e,t,n){var r=n(9),a=n(29);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[e.i,a,""]]);var s={insert:"head",singleton:!1};r(a,s);e.exports=a.locals||{}},29:function(e,t,n){},3:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var r=function(e){return null!=e}},30:function(e,t,n){var r=n(9),a=n(31);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[e.i,a,""]]);var s={insert:"head",singleton:!1};r(a,s);e.exports=a.locals||{}},31:function(e,t,n){},4:function(e,t,n){"use strict";n.d(t,"a",(function(){return r})),n.d(t,"b",(function(){return a}));var r={AUTH_FORM:"authForm",FORM_NAME:"formName",INPUT_WRAP:"input_wrap",INPUT:{VALID:"valid",INVALID:"invalid"},AUTH_MASSAGE:"massageConfirmed",ERROR_MASSAGE:"errorMassage",SPIN:"icon-spin4 animate-spin",BUTTON:"formButton",LINK:"formLink"},a={NAME:"name",EMAIL:"email",PASSWORD:"password",CONFIRM_PASSWORD:"password_confirmation",SECRET_CODE:"secret_code"}}});