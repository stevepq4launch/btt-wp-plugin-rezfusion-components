(self.webpackChunkrezfusion_components=self.webpackChunkrezfusion_components||[]).push([[89,686,699,644],{7699:(e,t,n)=>{var r;self,e.exports=(r=n(381),function(){"use strict";var e={192:function(e){e.exports=r}},t={};function n(r){var a=t[r];if(void 0!==a)return a.exports;var i=t[r]={exports:{}};return e[r](i,i.exports,n),i.exports}n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,{a:t}),t},n.d=function(e,t){for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})};var a={};return function(){n.r(a),n.d(a,{DATE_FORMAT:function(){return r},TurnoverStatus:function(){return i},TurnoverClass:function(){return o},wrapDates:function(){return s},dateDiffDays:function(){return c},findApplicableDateRange:function(){return d},isDateTurnDay:function(){return l},getMaxStay:function(){return f},getMinStay:function(){return p},getMaxAdvance:function(){return b},getMinAdvance:function(){return g},getIncrement:function(){return m},datesSatisfyMinStay:function(){return y},datesSatisfyMaxStay:function(){return v},dateSatisfiesMinAdvance:function(){return A},dateSatisfiesMaxAdvance:function(){return S},datesSatisfyIncrement:function(){return h},getApplicableAvail:function(){return x},getApplicablePrices:function(){return I},getApplicableRestriction:function(){return O},getApplicableTurnover:function(){return C},isDateAvailable:function(){return E},isDateRangeAvailable:function(){return T},isPriceRangeAvailable:function(){return M},isDateSelectable:function(){return D},getAvailClasses:function(){return P}});var e=n(192),t=n.n(e);const r=["YYYY-MM-DD","YYYY-MM-DDT00:00:00"];var i,o;!function(e){e.Closed="X",e.In="I",e.Out="O",e.Open="C"}(i||(i={})),function(e){e.Closed="closed",e.In="in",e.Out="out",e.Open="open"}(o||(o={}));const u=(e,n="date")=>{if(!t().isMoment(e)||!e.isValid())throw new TypeError(`Invalid ${n} for moment object`)},s=e=>{const n={...e,begin:null,end:null};return Object.keys(e).forEach((a=>{"begin"!==a&&"end"!==a||(n[a]=e[a]?t()(e[a],r,!0).hour(0).minute(0).second(0):null)})),n},c=(e,t)=>{u(e,"start date"),u(t,"end date");const n=e.clone().hour(0);return t.clone().hour(0).diff(n,"day")},d=(e,t)=>{if(u(e),t&&Array.isArray(t))return t.find((({begin:t,end:n})=>e.isBetween(t,n,"day","[]")))},l=(e,t,n,r="checkin")=>{if(u(e),!t&&!n)return!0;if(n){const{status:e}=n;return"checkin"===r?"C"===e||"I"===e:"C"===e||"O"===e}if(!t)return!0;const{turnDays:a,datedTurnDays:i}=t,o=e.day()+1;if(!Array.isArray(a)||!a.length){if(!Array.isArray(i)||!i.length)return!0;const t=d(e,i);return!t||!Array.isArray(t.turnDays)||t.turnDays.includes(o)}return a.includes(o)},f=(e,t=0,n)=>(u(e),n&&n.maxStay&&Number.isInteger(n.maxStay)?n.maxStay:t&&Number.isInteger(t)?t:0),p=(e,t=0,n)=>(u(e),n&&n.minStay&&Number.isInteger(n.minStay)?n.minStay:t&&t&&Number.isInteger(t)?t:0),b=(e,t=0,n)=>(u(e),n&&n.maxAdvance&&Number.isInteger(n.maxAdvance)?n.maxAdvance:t&&Number.isInteger(t)?t:0),g=(e,t=0,n)=>(u(e),n&&n.minAdvance&&Number.isInteger(n.minAdvance)?n.minAdvance:t&&Number.isInteger(t)?t:0),m=(e,t=1,n)=>(u(e),n&&n.increment&&Number.isInteger(n.increment)?n.increment:t&&Number.isInteger(t)?t:1),y=(e,t,n=0)=>(u(e,"start date"),u(t,"end date"),!n||n<=c(e,t)),v=(e,t,n=0)=>(u(e,"start date"),u(t,"end date"),!n||n>=c(e,t)),A=(e,n=0)=>(u(e),!n||n<=c(t()(),e)),S=(e,n=0)=>(u(e),!n||c(t()(),e)<=n),h=(e,t,n=1)=>(u(e,"start date"),u(t,"end date"),!n||1===n||c(e,t)%n==0),x=(e,t)=>t?d(e,t):void 0,I=(e,t)=>d(e,t),O=(e,t)=>d(e,t),C=(e,t)=>d(e,t),E=(e,n,r,a)=>{if(!a)return e.isSameOrAfter(t()(),"day");const i=x(e,a);if(n){const t=I(e,r);return!!(i&&i.available&&t&&"number"==typeof t.price)}return!(!i||!i.available)},T=(e,t,n)=>{if(t.isSameOrBefore(e))return!1;if(!n)return!0;let r=e.clone();for(;r.isBefore(t,"days");){const e=x(r,n);if(!e||!e.available)return!1;if(!e.end)return e.available;r=e.end.clone().add("1","days")}return!0},M=(e,t,n)=>{let r=e;for(;r.isBefore(t);){const e=I(r,n);if(!e)return!1;if(!e.end)break;r=e.end.clone().add("1","days")}return!0},D=(e,t,n=!1,r,a)=>{if(!t){const t=E(e,n,r,a),i=e.clone().subtract(1,"days"),o=E(i,n,r,a);return t||o}if(e.isBefore(t))return!1;const i=T(t,e,a);return a&&n?i&&M(t,e,r):i},P=(e,t,n=!1,r,a,u)=>{const s=D(e,t,n,r,a);let c;const d=[];return d.push("CalendarDayContent"),c=s?u?((e,t)=>{const n=C(e,t);if(n)switch(n.status){case i.Closed:return o.Closed;case i.In:return o.In;case i.Out:return o.Out;case i.Open:return o.Open}return o.Closed})(e,u):((e,t,n=!1,r,a)=>{const i=e.clone().subtract(1,"days"),u=e.clone().add(1,"days"),s=E(e,n,r,a),c=E(i,n,r,a),d=D(u,t,n,r,a);switch(!0){case!D(e,t,n,r,a):return o.Closed;case!s:return o.Out;case c&&d:return o.Open;case!c:return o.In;case!d:return o.Out;default:return o.Closed}})(e,t,n,r,a):o.Closed,d.push(`CalendarDayContent--${c}`),{availType:c,className:d.join(" ")}}}(),a}())},6686:(e,t,n)=>{"use strict";var r=n(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.defaultThemeShape=t.defaultTheme=t.sizes=t.breakpoints=t.XXLARGE=t.XLARGE=t.LARGE=t.MEDIUM=t.SMALL=t.TINY=t.SIZE_XXLARGE=t.SIZE_XLARGE=t.SIZE_LARGE=t.SIZE_MEDIUM=t.SIZE_SMALL=t.SIZE_TINY=t.searchFontFamily=t.boxShadow=t.border=t.dateRangeInputHeight=void 0;var a=r(n(5697));t.dateRangeInputHeight="48px",t.border="1px solid #ccc",t.boxShadow="0px 2px 3px 0 rgba(0,0,0,.125)",t.searchFontFamily="Open Sans, Helvetica, Arial, sans-serif",t.SIZE_TINY=500,t.SIZE_SMALL=700,t.SIZE_MEDIUM=1e3,t.SIZE_LARGE=1200,t.SIZE_XLARGE=1800,t.SIZE_XXLARGE=2400;const i="tiny";t.TINY=i;const o="small";t.SMALL=o;const u="medium";t.MEDIUM=u;const s="large";t.LARGE=s;const c="xlarge";t.XLARGE=c;const d="xxlarge";t.XXLARGE=d;const l={[i]:"500px",[o]:"700px",[u]:"1000px",[s]:"1200px",[c]:"1800px",[d]:"2400px"};t.breakpoints=l;const f={[i]:`(min-width: ${l.tiny})`,[o]:`(min-width: ${l.small})`,[u]:`(min-width: ${l.medium})`,[s]:`(min-width: ${l.large})`,[c]:`(min-width: ${l.xlarge})`,[d]:`(min-width: ${l.xxlarge})`};t.sizes=f,t.defaultTheme={buttonHeight:"48px",buttonTextSize:"14px",border:"1px solid #9A9A9A",borderRadius:"0",buttonIconSize:"20px",buttonAccentColor:"#888",buttonClearBackground:"#F5F5F5",buttonCTAColor:"#888",buttonCTATextColor:"#fff",rangeSize:"36px"};const p=a.default.exact({buttonHeight:a.default.string,buttonTextSize:a.default.string,border:a.default.string,borderRadius:a.default.string,buttonIconSize:a.default.string,buttonAccentColor:a.default.string,buttonClearBackground:a.default.string,buttonCTAColor:a.default.string,buttonCTATextColor:a.default.string,rangeSize:a.default.string});t.defaultThemeShape=p},7105:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>b});var r=n(4942),a=n(7294),i=n(5697),o=n.n(i),u=n(9163),s=n(6686),c=n(4175),d=n(5100),l=n(3796);function f(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function p(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?f(Object(n),!0).forEach((function(t){(0,r.default)(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):f(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}var b=function(e){var t=e.children,n=e.userProviderConfig,r=e.searchProviderCallback;return a.createElement(l.default,{userProvided:n},a.createElement(u.ThemeProvider,{theme:p(p({},s.defaultTheme),(0,c.getConfigOption)(["settings","theme"]))},a.createElement(d.SearchProvider,{channels:(0,c.getConfigOption)(["settings","components","SearchProvider","channels"]),endpoint:(0,c.getConfigOption)(["settings","components","SearchProvider","endpoint"]),query:"",mountCallback:function(e){"function"==typeof r&&r({component:e})}},t)))};b.propTypes={children:o().node.isRequired,userProviderConfig:void 0,searchProviderCallback:o().func},b.defaultProps={userProviderConfig:{},searchProviderCallback:null}},9644:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>r});const r=n(7294).createContext(null)}}]);