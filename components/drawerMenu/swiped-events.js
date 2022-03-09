/*!
 * swiped-events.js - v@version@
 * Pure JavaScript swipe events
 * https://github.com/john-doherty/swiped-events
 * @inspiration https://stackoverflow.com/questions/16348031/disable-scrolling-when-touch-moving-certain-element
 * @author John Doherty <www.johndoherty.info>
 * @license MIT
 */
(function(t,e){"use strict";function n(t){if(r===t.target){var e=parseInt(r.getAttribute("data-swipe-threshold")||"20",10),n=parseInt(r.getAttribute("data-swipe-timeout")||"500",10),u=Date.now()-c,a="";Math.abs(o)>Math.abs(s)?Math.abs(o)>e&&u<n&&(a=o>0?"swiped-left":"swiped-right"):Math.abs(s)>e&&u<n&&(a=s>0?"swiped-up":"swiped-down"),""!==a&&r.dispatchEvent(new CustomEvent(a,{bubbles:!0,cancelable:!0})),i=null,l=null,c=null}}function u(t){"true"!==t.target.getAttribute("data-swipe-ignore")&&(r=t.target,c=Date.now(),i=t.touches[0].clientX,l=t.touches[0].clientY,o=0,s=0)}function a(t){if(i&&l){var e=t.touches[0].clientX,n=t.touches[0].clientY;o=i-e,s=l-n}}"function"!=typeof t.CustomEvent&&(t.CustomEvent=function(t,n){n=n||{bubbles:!1,cancelable:!1,detail:void 0};var u=e.createEvent("CustomEvent");return u.initCustomEvent(t,n.bubbles,n.cancelable,n.detail),u},t.CustomEvent.prototype=t.Event.prototype),e.addEventListener("touchstart",u,!1),e.addEventListener("touchmove",a,!1),e.addEventListener("touchend",n,!1);var i=null,l=null,o=null,s=null,c=null,r=null})(window,document);