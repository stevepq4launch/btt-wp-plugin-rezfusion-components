(self.webpackChunkrezfusion_components=self.webpackChunkrezfusion_components||[]).push([[219,654,678],{4564:(e,t,r)=>{"use strict";var a=r(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=function(e,t){if(e&&e.__esModule)return e;if(null===e||"object"!=typeof e&&"function"!=typeof e)return{default:e};var r=c(t);if(r&&r.has(e))return r.get(e);var a={},n=Object.defineProperty&&Object.getOwnPropertyDescriptor;for(var o in e)if("default"!==o&&Object.prototype.hasOwnProperty.call(e,o)){var l=n?Object.getOwnPropertyDescriptor(e,o):null;l&&(l.get||l.set)?Object.defineProperty(a,o,l):a[o]=e[o]}return a.default=e,r&&r.set(e,a),a}(r(7294)),o=a(r(5697)),l=a(r(9163)),u=a(r(5936)),i=a(r(3452));function c(e){if("function"!=typeof WeakMap)return null;var t=new WeakMap,r=new WeakMap;return(c=function(e){return e?r:t})(e)}const s=l.default.input.withConfig({displayName:"Coupon__StyledInput",componentId:"sc-a7f5cb-0"})(["height:",";border:",";border-radius:",";background-color:",";width:100%;margin:1em 0;padding:0 1em;"],(e=>e.theme.buttonHeight),(e=>e.theme.border),(e=>e.theme.borderRadius),(e=>{switch(e.status){case!0:return"#ecffc9";case!1:return"#ffd3c9";default:return"initial"}})),d=(0,l.default)(u.default).withConfig({displayName:"Coupon__StyledButton",componentId:"sc-a7f5cb-1"})(["width:100%"]),f=l.default.p.withConfig({displayName:"Coupon__StyledP",componentId:"sc-a7f5cb-2"})(["color:#ff3a3a;"]),p=(e,t)=>r=>{r.preventDefault(),t(e)},m=({buttonText:e,className:t})=>{const{promoCode:r,setPromoCode:a,promoStatus:o}=(0,n.useContext)(i.default),[l,u]=(0,n.useState)(r||"");return n.default.createElement("form",{onSubmit:p(l,a),className:t},n.default.createElement("label",{htmlFor:"bt-coupon-code"},n.default.createElement(s,{id:"bt-coupon-code",placeholder:"Promo Code",type:"text",value:l,onChange:e=>{e.preventDefault(),u(e.target.value)},status:o})),n.default.createElement(d,{onClick:p(l,a)},e),!1===o?n.default.createElement(f,null,"Promo code was invalid"):null)};t.default=m,m.propTypes={className:o.default.string,buttonText:o.default.string},m.defaultProps={className:"",buttonText:"Submit"}},3373:(e,t,r)=>{"use strict";var a=r(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;const n=a(r(7294)).default.createContext();t.default=n},7265:(e,t,r)=>{"use strict";var a=r(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=a(r(4942)),o=a(r(4925)),l=function(e,t){if(e&&e.__esModule)return e;if(null===e||"object"!=typeof e&&"function"!=typeof e)return{default:e};var r=O(t);if(r&&r.has(e))return r.get(e);var a={},n=Object.defineProperty&&Object.getOwnPropertyDescriptor;for(var o in e)if("default"!==o&&Object.prototype.hasOwnProperty.call(e,o)){var l=n?Object.getOwnPropertyDescriptor(e,o):null;l&&(l.get||l.set)?Object.defineProperty(a,o,l):a[o]=e[o]}return a.default=e,r&&r.set(e,a),a}(r(7294)),u=a(r(5697)),i=a(r(9163)),c=r(7124),s=a(r(3452)),d=a(r(4564)),f=a(r(2719)),p=a(r(6567)),m=a(r(8291)),h=a(r(2282)),y=a(r(2267)),b=a(r(9644)),g=a(r(3373));const v=["requirePrices","showNightlyPrices"];function O(e){if("function"!=typeof WeakMap)return null;var t=new WeakMap,r=new WeakMap;return(O=function(e){return e?r:t})(e)}function P(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,a)}return r}const w=(0,i.default)(y.default).withConfig({displayName:"SearchForms__StyledBookButton",componentId:"sc-178y0s6-0"})(["width:100%;"]),j=(0,i.default)(h.default).withConfig({displayName:"SearchForms__StyledGuestsDialogContent",componentId:"sc-178y0s6-1"})(["width:100%;margin:1em 0;& > button{width:100%;}"]),C=e=>{const{anchorDirection:t}=e,r=(0,l.useContext)(b.default),{settings:{guid:a,components:{SearchProvider:{channels:u},AvailabilitySearchConsumer:{spsDomain:i,confirmationPage:h,options:{requirePrices:y,showNightlyPrices:O}},Checkout:{options:{exposePromo:C}}}}}=r,_=(0,o.default)(r.settings.components.AvailabilitySearchConsumer.options,v),{lodgingItem:D}=(0,l.useContext)(g.default);if(null==D)return null;const{item:{availability:E,turnover:k,restrictions:S,prices:x,hasStays:M,remote_id:N}}=D,{quoteLoading:q,quoteError:I,orderQuote:T,dates:A,setDates:W,guests:$,setGuests:B,type:F}=(0,l.useContext)(s.default),[z,G]=(0,l.useState)(!1);let R=null;if(q)R=l.default.createElement(p.default,null);else if(I)R=l.default.createElement("p",null,"An error occurred while fetching quotes.");else if(T)if(T.total&&Array.isArray(T.charges)&&T.charges.length){const{total:e,currency:t,tax:r,charges:n}=T;R=l.default.createElement(l.default.Fragment,null,l.default.createElement("section",{className:"avail-quotes bt-avail-quotes"},l.default.createElement(m.default,{total:e,currency:t,tax:r,charges:n})),l.default.createElement(w,{label:"Book now",params:{rcav:{begin:(0,c.formatDate)(A.begin),end:(0,c.formatDate)(A.end),adult:`${$.adult}`,child:`${$.child}`}},type:F,channel:u,provider:T.provider,source:T.source,guid:a,spsDomain:i,confPage:h,remoteId:N}))}else R=l.default.createElement(l.default.Fragment,null,l.default.createElement("p",null,"Could not get a quote for selected dates."),l.default.createElement("p",null,"Displayed availability and prices might be out of date."));const H=function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?P(Object(r),!0).forEach((function(t){(0,n.default)(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):P(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}({avail:E,availTurnoverBlocks:k,restrictions:S,prices:x,requirePrices:!M&&y,showNightlyPrices:!M&&O},_);return l.default.createElement("div",null,l.default.createElement(f.default,{options:H,type:"DateRangePicker",handleDatesChange:(e,t)=>{`${e}`==`${A.begin}`&&`${t}`==`${A.end}`||W({begin:e,end:t})},rcav:{begin:A.begin,end:A.end,adult:$.adult,child:$.child},anchorDirection:t}),l.default.createElement(j,{adultCount:$.adult,childCount:$.child,id:"item-avail-form",isOpen:z,handleApply:(e,t)=>{e===$.adult&&t===$.child||B({adult:e,child:t}),G(!1)},handleToggle:()=>{G(!z)}}),C?l.default.createElement(d.default,null):null,R)};t.default=C,C.propTypes={anchorDirection:u.default.oneOf(["left","right"])},C.defaultProps={anchorDirection:null}},3452:(e,t,r)=>{"use strict";var a=r(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;const n=a(r(7294)).default.createContext();t.default=n},6567:(e,t,r)=>{"use strict";var a=r(5318);Object.defineProperty(t,"__esModule",{value:!0}),Object.defineProperty(t,"default",{enumerable:!0,get:function(){return n.default}});var n=a(r(2299))},4654:()=>{}}]);