(self.webpackChunkrezfusion_components=self.webpackChunkrezfusion_components||[]).push([[933,80,437],{4564:(e,t,a)=>{"use strict";var n=a(862),r=a(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var u=r(a(885)),l=n(a(7294)),o=r(a(5697)),d=r(a(9163)),i=r(a(5936)),f=r(a(3452)),c=d.default.input.withConfig({displayName:"Coupon__StyledInput",componentId:"a7f5cb-0"})(["height:",";border:",";border-radius:",";background-color:",";width:100%;margin:1em 0;padding:0 1em;"],(function(e){return e.theme.buttonHeight}),(function(e){return e.theme.border}),(function(e){return e.theme.borderRadius}),(function(e){switch(e.status){case!0:return"#ecffc9";case!1:return"#ffd3c9";default:return"initial"}})),s=(0,d.default)(i.default).withConfig({displayName:"Coupon__StyledButton",componentId:"a7f5cb-1"})(["width:100%"]),m=d.default.p.withConfig({displayName:"Coupon__StyledP",componentId:"a7f5cb-2"})(["color:#ff3a3a;"]),p=function(e,t){return function(a){a.preventDefault(),t(e)}},b=function(e){var t=e.buttonText,a=e.className,n=(0,l.useContext)(f.default),r=n.promoCode,o=n.setPromoCode,d=n.promoStatus,i=(0,l.useState)(r||""),b=(0,u.default)(i,2),g=b[0],h=b[1];return l.default.createElement("form",{onSubmit:p(g,o),className:a},l.default.createElement("label",{htmlFor:"bt-coupon-code"},l.default.createElement(c,{id:"bt-coupon-code",placeholder:"Promo Code",type:"text",value:g,onChange:function(e){e.preventDefault(),h(e.target.value)},status:d})),l.default.createElement(s,{onClick:p(g,o)},t),!1===d?l.default.createElement(m,null,"Promo code was invalid"):null)};t.default=b,b.propTypes={className:o.default.string,buttonText:o.default.string},b.defaultProps={className:"",buttonText:"Submit"}},7265:(e,t,a)=>{"use strict";var n=a(862),r=a(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var u=r(a(4942)),l=r(a(885)),o=n(a(7294)),d=r(a(5697)),i=r(a(381)),f=r(a(9163)),c=a(6071),s=r(a(3452)),m=r(a(4564)),p=r(a(2719)),b=r(a(6567)),g=r(a(8291)),h=r(a(2282)),y=r(a(3685)),v=r(a(9997));function O(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),a.push.apply(a,n)}return a}function C(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?O(Object(a),!0).forEach((function(t){(0,u.default)(e,t,a[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):O(Object(a)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))}))}return e}var P=(0,f.default)(y.default).withConfig({displayName:"SearchForms__StyledBookButton",componentId:"sc-178y0s6-0"})(["width:100%;"]),w=(0,f.default)(h.default).withConfig({displayName:"SearchForms__StyledGuestsDialogContent",componentId:"sc-178y0s6-1"})(["width:100%;margin:1em 0;& > button{width:100%;}"]),q=function(e){var t=e.availOptions,a=e.anchorDirection,n=e.remoteId,r=(0,o.useContext)(v.default).settings,u=r.guid,d=r.components,i=d.SearchProvider.channels,f=d.AvailabilitySearchConsumer,h=f.spsDomain,y=f.confirmationPage,O=f.options,q=d.Checkout.options.exposePromo,E=(0,o.useContext)(s.default),D=E.quoteLoading,S=E.quoteError,_=E.orderQuote,x=E.dates,j=E.setDates,R=E.guests,k=E.setGuests,I=E.type,N=(0,o.useState)(!1),T=(0,l.default)(N,2),F=T[0],A=T[1],B=null;if(D)B=o.default.createElement(b.default,null);else if(S)B=o.default.createElement("p",null,"An error occurred while fetching quotes.");else if(_)if(_.total&&Array.isArray(_.charges)&&_.charges.length){var M=_.total,z=_.currency,G=_.tax,H=_.charges;B=o.default.createElement(o.default.Fragment,null,o.default.createElement("section",{className:"avail-quotes bt-avail-quotes"},o.default.createElement(g.default,{total:M,currency:z,tax:G,charges:H})),o.default.createElement(P,{label:"Book now",params:{rcav:{begin:(0,c.formatDate)(x.begin),end:(0,c.formatDate)(x.end),adult:"".concat(R.adult),child:"".concat(R.child)}},type:I,channel:i,provider:_.provider,source:_.source,guid:u,spsDomain:h,confPage:y,remoteId:n}))}else B=o.default.createElement(o.default.Fragment,null,o.default.createElement("p",null,"Could not get a quote for selected dates."),o.default.createElement("p",null,"Displayed availability and prices might be out of date."));var L=C(C({},t),O);return o.default.createElement("div",null,o.default.createElement(p.default,{options:L,type:"DateRangePicker",handleDatesChange:function(e,t){"".concat(e)==="".concat(x.begin)&&"".concat(t)==="".concat(x.end)||j({begin:e,end:t})},rcav:{begin:x.begin,end:x.end},anchorDirection:a}),o.default.createElement(w,{adultCount:R.adult,childCount:R.child,id:"item-avail-form",isOpen:F,handleApply:function(e,t){e===R.adult&&t===R.child||k({adult:e,child:t}),A(!1)},handleToggle:function(){A(!F)}}),q?o.default.createElement(m.default,null):null,B)};t.default=q,q.propTypes={anchorDirection:d.default.oneOf(["left","right"]),availOptions:d.default.shape({avail:d.default.arrayOf(d.default.exact({begin:d.default.instanceOf(i.default).isRequired,end:d.default.instanceOf(i.default).isRequired,available:d.default.bool,quantity:d.default.number,status:d.default.bool,extra:d.default.string})),availTurnoverBlocks:d.default.arrayOf(d.default.exact({begin:d.default.instanceOf(i.default).isRequired,end:d.default.instanceOf(i.default).isRequired,status:d.default.oneOf(["C","I","X","O"])})),restrictions:d.default.arrayOf(d.default.exact({begin:d.default.instanceOf(i.default).isRequired,end:d.default.instanceOf(i.default).isRequired,minStay:d.default.number,maxStay:d.default.number,increment:d.default.number,turnDay:d.default.arrayOf(d.default.oneOf([1,2,3,4,5,6,7]))})),prices:d.default.arrayOf(d.default.exact({begin:d.default.instanceOf(i.default).isRequired,end:d.default.instanceOf(i.default).isRequired,minStay:d.default.number,maxStay:d.default.number,price:d.default.number.isRequired,type:d.default.number.isRequired,currency:d.default.string,source:d.default.string.isRequired,provider:d.default.string.isRequired})),block:d.default.bool,dateFormat:d.default.string}).isRequired,remoteId:d.default.string.isRequired},q.defaultProps={anchorDirection:null}},3452:(e,t,a)=>{"use strict";var n=a(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var r=n(a(7294)).default.createContext();t.default=r},6567:(e,t,a)=>{"use strict";var n=a(5318);Object.defineProperty(t,"__esModule",{value:!0}),Object.defineProperty(t,"default",{enumerable:!0,get:function(){return r.default}});var r=n(a(2299))},4080:()=>{}}]);