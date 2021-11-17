"use strict";(self.webpackChunkrezfusion_components=self.webpackChunkrezfusion_components||[]).push([[202,686],{3373:(e,t,a)=>{var n=a(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;const i=n(a(7294)).default.createContext();t.default=i},8375:(e,t,a)=>{var n=a(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i=function(e,t){if(e&&e.__esModule)return e;if(null===e||"object"!=typeof e&&"function"!=typeof e)return{default:e};var a=s(t);if(a&&a.has(e))return a.get(e);var n={},i=Object.defineProperty&&Object.getOwnPropertyDescriptor;for(var l in e)if("default"!==l&&Object.prototype.hasOwnProperty.call(e,l)){var r=i?Object.getOwnPropertyDescriptor(e,l):null;r&&(r.get||r.set)?Object.defineProperty(n,l,r):n[l]=e[l]}return n.default=e,a&&a.set(e,n),n}(a(7294)),l=n(a(9163)),r=n(a(3373)),o=a(6686);function s(e){if("function"!=typeof WeakMap)return null;var t=new WeakMap,a=new WeakMap;return(s=function(e){return e?a:t})(e)}const d=l.default.div.withConfig({displayName:"CategoriesDisplay__DetailsAmenitiesWrapper",componentId:"sc-1b06rzm-0"})(["display:flex;flex-flow:row wrap;"]),u=l.default.div.withConfig({displayName:"CategoriesDisplay__DetailsAmenityCategory",componentId:"sc-1b06rzm-1"})(["width:100%;"]),c=l.default.ul.withConfig({displayName:"CategoriesDisplay__DetailsAmenityCategoryList",componentId:"sc-1b06rzm-2"})(["@media ","{column-count:2;}@media ","{column-count:3;}"],o.sizes.small,o.sizes.large);t.default=()=>{const{categories:e}=(0,i.useContext)(r.default),t=Object.keys(e);return t.length?i.default.createElement("section",{className:"bt-details__amenities"},i.default.createElement("h2",{className:"bt-details__section-header"},"Amenities"),i.default.createElement(d,{className:"bt-amenities-wrapper"},t.map((t=>{const{name:a,values:n,description:l}=e[t];return i.default.createElement(u,{className:"bt-amenity-category",key:a},i.default.createElement("h3",{className:"bt-amenity-category__name"},a),l?i.default.createElement("p",{className:"bt-amenity-category__description"},l):null,i.default.createElement(c,{className:"bt-amenity-category__list"},n.map((e=>i.default.createElement("li",{className:"bt-amenity-category__list-item",key:e.id},e.listing_display?i.default.createElement("span",{className:"bt-amenity-category__listing-display "+(e.available?"bt-amenity-category__listing-display--included":"bt-amenity-category__listing-display--excluded")},e.available?"Yes ":"No "):null,e.description?`${e.name}: ${e.description}`:e.name)))))})))):null}},6686:(e,t,a)=>{var n=a(5318);Object.defineProperty(t,"__esModule",{value:!0}),t.defaultThemeShape=t.defaultTheme=t.sizes=t.breakpoints=t.XXLARGE=t.XLARGE=t.LARGE=t.MEDIUM=t.SMALL=t.TINY=t.SIZE_XXLARGE=t.SIZE_XLARGE=t.SIZE_LARGE=t.SIZE_MEDIUM=t.SIZE_SMALL=t.SIZE_TINY=t.searchFontFamily=t.boxShadow=t.border=t.dateRangeInputHeight=void 0;var i=n(a(5697));t.dateRangeInputHeight="48px",t.border="1px solid #ccc",t.boxShadow="0px 2px 3px 0 rgba(0,0,0,.125)",t.searchFontFamily="Open Sans, Helvetica, Arial, sans-serif",t.SIZE_TINY=500,t.SIZE_SMALL=700,t.SIZE_MEDIUM=1e3,t.SIZE_LARGE=1200,t.SIZE_XLARGE=1800,t.SIZE_XXLARGE=2400;const l="tiny";t.TINY=l;const r="small";t.SMALL=r;const o="medium";t.MEDIUM=o;const s="large";t.LARGE=s;const d="xlarge";t.XLARGE=d;const u="xxlarge";t.XXLARGE=u;const c={[l]:"500px",[r]:"700px",[o]:"1000px",[s]:"1200px",[d]:"1800px",[u]:"2400px"};t.breakpoints=c;const m={[l]:`(min-width: ${c.tiny})`,[r]:`(min-width: ${c.small})`,[o]:`(min-width: ${c.medium})`,[s]:`(min-width: ${c.large})`,[d]:`(min-width: ${c.xlarge})`,[u]:`(min-width: ${c.xxlarge})`};t.sizes=m,t.defaultTheme={buttonHeight:"48px",buttonTextSize:"14px",border:"1px solid #9A9A9A",borderRadius:"0",buttonIconSize:"20px",buttonAccentColor:"#888",buttonClearBackground:"#F5F5F5",buttonCTAColor:"#888",buttonCTATextColor:"#fff",rangeSize:"36px"};const p=i.default.exact({buttonHeight:i.default.string,buttonTextSize:i.default.string,border:i.default.string,borderRadius:i.default.string,buttonIconSize:i.default.string,buttonAccentColor:i.default.string,buttonClearBackground:i.default.string,buttonCTAColor:i.default.string,buttonCTATextColor:i.default.string,rangeSize:i.default.string});t.defaultThemeShape=p}}]);