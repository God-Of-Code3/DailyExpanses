const $ = (s, el=document) => el.querySelector(s);
const $$ = (s, el=document) => el.querySelectorAll(s);

// Action functions
const activate = id => {
	$(`#${id}`).classList.add('active');

}
const deactivate = id => $(`#${id}`).classList.remove('active');

const actionKeys = {
	'activate': activate,
	'deactivate': deactivate,
}

const actionTypes = {
	'click': (el, func) => el.onclick = func,
}

// Activation actions
$$('[data-action]').forEach(el => {

	for (let actionType in actionTypes) {
		let actionName = el.getAttribute(`data-action-${actionType}`);
		if (actionName) {
			let actionData = el.getAttribute(`data-action-${actionType}-data`);

			if (actionKeys[actionName]) {
				actionTypes[actionType](el, () => { actionKeys[actionName](actionData) });
			}
		}
		
	}
		
});