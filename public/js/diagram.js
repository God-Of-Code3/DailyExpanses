/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/diagram.js ***!
  \*********************************/
var $ = function $(s) {
  var el = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : document;
  return el.querySelector(s);
};

var $$ = function $$(s) {
  var el = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : document;
  return el.querySelectorAll(s);
};

function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
  var angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0;
  return {
    x: centerX + radius * Math.cos(angleInRadians),
    y: centerY + radius * Math.sin(angleInRadians)
  };
}

var arc = 2;

function describeArc(x, y, radius1, radius2, startAngle, endAngle) {
  var start1 = polarToCartesian(x, y, radius1, endAngle);
  var end1 = polarToCartesian(x, y, radius1, startAngle);
  var start2 = polarToCartesian(x, y, radius2, startAngle);
  var end2 = polarToCartesian(x, y, radius2, endAngle);
  console.log(Math.abs(endAngle - startAngle), endAngle);
  var dX2 = -Math.cos(startAngle * Math.PI / 180 - Math.PI) * arc;
  var dY2 = -Math.sin(startAngle * Math.PI / 180 - Math.PI) * arc;
  var dX1 = Math.cos(endAngle * Math.PI / 180 - Math.PI) * arc;
  var dY1 = Math.sin(endAngle * Math.PI / 180 - Math.PI) * arc;

  if (Math.abs(endAngle - startAngle) < 10) {
    dX1 = 0;
    dY1 = 0;
    dX2 = 0;
    dY2 = 0;
  }

  var largeArcFlag = endAngle - startAngle <= 180 ? "0" : "1";
  var d = ["M".concat(start1.x + dX1, ",").concat(start1.y + dY1), "A".concat(radius1, ",").concat(radius1, " 0 ").concat(largeArcFlag, ",0 ").concat(end1.x + dX2, ",").concat(end1.y + dY2), "L".concat(start2.x + dX2, " ").concat(start2.y + dY2), "A".concat(radius2, ",").concat(radius2, " 0 ").concat(largeArcFlag, ",1 ").concat(end2.x + dX1, ",").concat(end2.y + dY1), "L".concat(start1.x + dX1, " ").concat(start1.y + dY1, " z")].join(" ");
  return d;
}

$$('.chart').forEach(function (chart) {
  i = 0;
  var ln = $$('path[data-sector-value]', chart).length / 2;
  var dist = 1;
  var degree = 0;
  $$('path[data-sector-value]', chart).forEach(function (path) {
    var d1 = degree;
    var d2 = degree + (Number(path.getAttribute('data-sector-value')) * 3.6 - dist);
    path.setAttribute('d', describeArc(35, 35, 25, 17, d1, d2));
    i += 1;

    if (i % 2 == 0) {
      degree = d2 + dist;
    }
  });
});
/******/ })()
;