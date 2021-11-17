(self.webpackChunkrezfusion_components=self.webpackChunkrezfusion_components||[]).push([[639,699],{7699:(e,n,t)=>{var r;self,e.exports=(r=t(381),function(){"use strict";var e={192:function(e){e.exports=r}},n={};function t(r){var i=n[r];if(void 0!==i)return i.exports;var a=n[r]={exports:{}};return e[r](a,a.exports,t),a.exports}t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,{a:n}),n},t.d=function(e,n){for(var r in n)t.o(n,r)&&!t.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:n[r]})},t.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})};var i={};return function(){t.r(i),t.d(i,{DATE_FORMAT:function(){return r},TurnoverStatus:function(){return a},TurnoverClass:function(){return s},wrapDates:function(){return u},dateDiffDays:function(){return c},findApplicableDateRange:function(){return d},isDateTurnDay:function(){return l},getMaxStay:function(){return f},getMinStay:function(){return p},getMaxAdvance:function(){return y},getMinAdvance:function(){return g},getIncrement:function(){return m},datesSatisfyMinStay:function(){return v},datesSatisfyMaxStay:function(){return b},dateSatisfiesMinAdvance:function(){return h},dateSatisfiesMaxAdvance:function(){return O},datesSatisfyIncrement:function(){return _},getApplicableAvail:function(){return S},getApplicablePrices:function(){return w},getApplicableRestriction:function(){return A},getApplicableTurnover:function(){return I},isDateAvailable:function(){return D},isDateRangeAvailable:function(){return P},isPriceRangeAvailable:function(){return j},isDateSelectable:function(){return x},getAvailClasses:function(){return C}});var e=t(192),n=t.n(e);const r=["YYYY-MM-DD","YYYY-MM-DDT00:00:00"];var a,s;!function(e){e.Closed="X",e.In="I",e.Out="O",e.Open="C"}(a||(a={})),function(e){e.Closed="closed",e.In="in",e.Out="out",e.Open="open"}(s||(s={}));const o=(e,t="date")=>{if(!n().isMoment(e)||!e.isValid())throw new TypeError(`Invalid ${t} for moment object`)},u=e=>{const t={...e,begin:null,end:null};return Object.keys(e).forEach((i=>{"begin"!==i&&"end"!==i||(t[i]=e[i]?n()(e[i],r,!0).hour(0).minute(0).second(0):null)})),t},c=(e,n)=>{o(e,"start date"),o(n,"end date");const t=e.clone().hour(0);return n.clone().hour(0).diff(t,"day")},d=(e,n)=>(o(e),n&&Array.isArray(n)&&n.find((({begin:n,end:t})=>e.isBetween(n,t,"day","[]")))||!1),l=(e,n,t,r="checkin")=>{if(o(e),!n&&!t)return!0;if(t){const{status:e}=t;return"checkin"===r?"C"===e||"I"===e:"C"===e||"O"===e}if(!n)return!0;const{turnDays:i,datedTurnDays:a}=n,s=e.day()+1;if(!Array.isArray(i)||!i.length){if(!Array.isArray(a)||!a.length)return!0;const n=d(e,a);return!n||!Array.isArray(n.turnDays)||n.turnDays.includes(s)}return i.includes(s)},f=(e,n=0,t)=>(o(e),t&&t.maxStay&&Number.isInteger(t.maxStay)?t.maxStay:n&&Number.isInteger(n)?n:0),p=(e,n=0,t)=>(o(e),t&&t.minStay&&Number.isInteger(t.minStay)?t.minStay:n&&n&&Number.isInteger(n)?n:0),y=(e,n=0,t)=>(o(e),t&&t.maxAdvance&&Number.isInteger(t.maxAdvance)?t.maxAdvance:n&&Number.isInteger(n)?n:0),g=(e,n=0,t)=>(o(e),t&&t.minAdvance&&Number.isInteger(t.minAdvance)?t.minAdvance:n&&Number.isInteger(n)?n:0),m=(e,n=1,t)=>(o(e),t&&t.increment&&Number.isInteger(t.increment)?t.increment:n&&Number.isInteger(n)?n:1),v=(e,n,t=0)=>(o(e,"start date"),o(n,"end date"),!t||t<=c(e,n)),b=(e,n,t=0)=>(o(e,"start date"),o(n,"end date"),!t||t>=c(e,n)),h=(e,t=0)=>(o(e),!t||t<=c(n()(),e)),O=(e,t=0)=>(o(e),!t||c(n()(),e)<=t),_=(e,n,t=1)=>(o(e,"start date"),o(n,"end date"),!t||1===t||c(e,n)%t==0),S=(e,n)=>!!n&&d(e,n),w=(e,n)=>d(e,n),A=(e,n)=>d(e,n),I=(e,n)=>d(e,n),D=(e,t,r,i)=>{if(!i)return e.isSameOrAfter(n()(),"day");const a=S(e,i);if(t){const n=w(e,r);return a&&a.available&&n&&"number"==typeof n.price}return a&&a.available},P=(e,n,t)=>{if(n.isSameOrBefore(e))return!1;if(!t)return!0;let r=e.clone();for(;r.isBefore(n,"days");){const e=S(r,t);if(!e||!1===e.available)return!1;r=e.end.clone().add("1","days")}return!0},j=(e,n,t)=>{let r=e;for(;r.isBefore(n);){const e=w(r,t);if(!e)return!1;r=e.end.clone().add("1","days")}return!0},x=(e,n,t=!1,r,i)=>{if(!n){const n=D(e,t,r,i),a=e.clone().subtract(1,"days"),s=D(a,t,r,i);return n||s}if(e.isBefore(n))return!1;const a=P(n,e,i);return i&&t?a&&j(n,e,r):a},C=(e,n,t,r,i,o)=>{const u=x(e,n,t,r,i);let c;const d=[];return d.push("CalendarDayContent"),c=u?o?((e,n)=>{const t=I(e,n);if(t)switch(t.status){case a.Closed:return s.Closed;case a.In:return s.In;case a.Out:return s.Out;case a.Open:return s.Open}return s.Closed})(e,o):((e,n,t,r,i)=>{const a=e.clone().subtract(1,"days"),o=e.clone().add(1,"days"),u=D(e,t,r,i),c=D(a,t,r,i),d=x(o,n,t,r,i);switch(!0){case!x(e,n,t,r,i):return s.Closed;case!u:return s.Out;case c&&d:return s.Open;case!c:return s.In;case!d:return s.Out;default:return s.Closed}})(e,n,t,r,i):s.Closed,d.push(`CalendarDayContent--${c}`),{availType:c,className:d.join(" ")}}}(),i}())},3373:(e,n,t)=>{"use strict";var r=t(5318);Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;const i=r(t(7294)).default.createContext();n.default=i},3639:(e,n,t)=>{"use strict";var r=t(5318);Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var i=r(t(4942)),a=function(e,n){if(e&&e.__esModule)return e;if(null===e||"object"!=typeof e&&"function"!=typeof e)return{default:e};var t=l(n);if(t&&t.has(e))return t.get(e);var r={},i=Object.defineProperty&&Object.getOwnPropertyDescriptor;for(var a in e)if("default"!==a&&Object.prototype.hasOwnProperty.call(e,a)){var s=i?Object.getOwnPropertyDescriptor(e,a):null;s&&(s.get||s.set)?Object.defineProperty(r,a,s):r[a]=e[a]}return r.default=e,t&&t.set(e,r),r}(t(7294)),s=r(t(5697)),o=t(7699),u=r(t(9644)),c=r(t(3373)),d=t(7124);function l(e){if("function"!=typeof WeakMap)return null;var n=new WeakMap,t=new WeakMap;return(l=function(e){return e?t:n})(e)}function f(e,n){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);n&&(r=r.filter((function(n){return Object.getOwnPropertyDescriptor(e,n).enumerable}))),t.push.apply(t,r)}return t}function p(e){for(var n=1;n<arguments.length;n++){var t=null!=arguments[n]?arguments[n]:{};n%2?f(Object(t),!0).forEach((function(n){(0,i.default)(e,n,t[n])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):f(Object(t)).forEach((function(n){Object.defineProperty(e,n,Object.getOwnPropertyDescriptor(t,n))}))}return e}const y=e=>e.map((e=>(0,o.wrapDates)(e))),g=e=>{const{children:n,itemId:t}=e,{settings:r}=(0,a.useContext)(u.default),[i,s]=(0,a.useState)(),[o,l]=(0,a.useState)(),[f,g]=(0,a.useState)(),[m,v]=(0,a.useState)(!0),[b,h]=(0,a.useState)(),{channels:O,endpoint:_,enableReviews:S}=(0,d.at)("components","SearchProvider")(r);(0,a.useEffect)((()=>{const e=new URLSearchParams(window.location.search),n=t||e.get("pms_id");s(n);const r={channels:{url:O},itemIds:[n]};var i;(0,d.fetchData)((i=S,`\nquery($channels: ChannelFilter!, $itemIds: [String]) {\n  categoryInfo(channels: $channels) {\n    categories {\n      id,\n      name,\n      description,\n      values {\n        id,\n        name,\n        description,\n        options {\n          show_details,\n        }\n      },\n      options {\n        show_details,\n        listing_display,\n      }\n    }\n  },\n  lodgingProducts(channels: $channels, itemIds: $itemIds) {\n    results {\n      id,\n      beds,\n      baths,\n      half_baths,\n      occ_total,\n      item {\n        hasStays,\n        availability {\n          begin,\n          end,\n          available,\n          quantity,\n          status\n        }\n        restrictions {\n          begin,\n          end,\n          minStay,\n          maxStay,\n          turnDay,\n          increment\n        }\n        turnover {\n          begin,\n          end,\n          status\n        }\n        prices {\n          begin,\n          end,\n          minStay,\n          maxStay,\n          type,\n          price,\n          currency\n        }\n        images {\n          url,\n          derivatives,\n          description,\n          title\n        }\n        location {\n          latitude,\n          longitude,\n          city,\n          province\n        }\n        tour {\n          url\n        },\n        ${i?"\nreviews {\n  rating,\n  headline,\n  arrival,\n  departure,\n  review_date,\n  response,\n  guest_name,\n  comment,\n  id\n}\nreviewSummary {\n  average,\n  count\n}\n":""}\n        id,\n        type,\n        name,\n        remote_id,\n        description,\n        category_values {\n          value {\n            id,\n            category {\n              id,\n            }\n          }\n        }\n        engine {\n          plain_text_descriptions\n        }\n        rooms {\n          name,\n          bunk_beds,\n          child_beds,\n          cribs,\n          double_beds,\n          king_beds,\n          murphy_beds,\n          queen_beds,\n          sofa_beds,\n          single_beds,\n          other_beds,\n        }\n      }\n    }\n  }\n}\n`),r,_).then((e=>e.json())).then((e=>{if(e.data.lodgingProducts.results){const n=e.data.lodgingProducts.results[0];g(p(p({},n),{},{item:p(p({},n.item),{},{availability:y(n.item.availability),restrictions:y(n.item.restrictions),turnover:y(n.item.turnover),prices:y(n.item.prices)})}));const{categoryInfo:t}=e.data,r=t.categories.filter((e=>e.options&&e.options.show_details)).filter((e=>(n.item.category_values?n.item.category_values:[]).reduce(((n,t)=>(t.value.category.id===e.id&&n.push(t.value.category.id),n)),[]).indexOf(e.id)>=0)).map((e=>p(p({},e),{},{values:e.values.filter((e=>e.options&&e.options.show_details)).filter((t=>!(!e.options||!e.options.listing_display||"show_all"!==e.options.listing_display)||(n.item.category_values?n.item.category_values:[]).reduce(((e,n)=>(n.value.id===t.id&&e.push(n.value.id),e)),[]).indexOf(t.id)>=0)).map((t=>{const r=(n.item.category_values?n.item.category_values:[]).reduce(((e,n)=>(n.value.id===t.id&&e.push(n.value.id),e)),[]).indexOf(t.id)>=0;return p(p({},t),{},{listing_display:e.options&&e.options.listing_display&&"show_all"===e.options.listing_display,available:r})}))})));l(r)}else console.error("Lodging product data missing."),h("Lodging product data not found.")})).catch((e=>{console.error(e),h("Lodging product data not found.")})).finally((()=>{v(!1)}))}),[]);const w={itemId:i,categories:o,lodgingItem:f,loading:m,error:b};return a.default.createElement(c.default.Provider,{value:w},n)};n.default=g,g.propTypes={children:s.default.node.isRequired,itemId:s.default.string},g.defaultProps={itemId:null}},9644:(e,n,t)=>{"use strict";t.r(n),t.d(n,{default:()=>r});const r=t(7294).createContext(null)}}]);