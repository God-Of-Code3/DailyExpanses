const $ = (s, el=document) => el.querySelector(s);
const $$ = (s, el=document) => el.querySelectorAll(s);

function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
	var angleInRadians = (angleInDegrees-90) * Math.PI / 180.0;

	return {
	x: centerX + (radius * Math.cos(angleInRadians)),
	y: centerY + (radius * Math.sin(angleInRadians))
	};
}

let arc = 2;

function describeArc(x, y, radius1, radius2, startAngle, endAngle){

	var start1 = polarToCartesian(x, y, radius1, endAngle);
	var end1 = polarToCartesian(x, y, radius1, startAngle);

	var start2 = polarToCartesian(x, y, radius2, startAngle);
	var end2 = polarToCartesian(x, y, radius2, endAngle);

	

	console.log(Math.abs(endAngle - startAngle), endAngle);
	

	let dX2 = -Math.cos(startAngle * Math.PI / 180 - Math.PI) * arc;
	let dY2 = -Math.sin(startAngle * Math.PI / 180 - Math.PI) * arc;

	let dX1 = Math.cos(endAngle * Math.PI / 180 - Math.PI) * arc;
	let dY1 = Math.sin(endAngle * Math.PI / 180 - Math.PI) * arc;

	if (Math.abs(endAngle - startAngle) < 10) {
		dX1 = 0;
		dY1 = 0;
		dX2 = 0;
		dY2 = 0;
	}

	var largeArcFlag = endAngle - startAngle <= 180 ? "0" : "1";

	var d = [
		`M${start1.x + dX1},${start1.y + dY1}`,
		`A${radius1},${radius1} 0 ${largeArcFlag},0 ${end1.x + dX2},${end1.y + dY2}`,
		`L${start2.x + dX2} ${start2.y + dY2}`,
		`A${radius2},${radius2} 0 ${largeArcFlag},1 ${end2.x + dX1},${end2.y + dY1}`,
		`L${start1.x + dX1} ${start1.y + dY1} z`,
	].join(" ");

	return d;
}

$$('.chart').forEach(chart => {
	
	i = 0;
	let ln = $$('path[data-sector-value]', chart).length / 2;
	let dist = 1;

	let degree = 0;
	$$('path[data-sector-value]', chart).forEach(path => {
		let d1 = degree;
		let d2 = degree + (Number(path.getAttribute('data-sector-value')) * 3.6 - dist);

		path.setAttribute('d', describeArc(35, 35, 25, 17, d1, d2));
		i += 1;

		if (i % 2 == 0) {
			degree = d2 + dist;
		}
	});
});