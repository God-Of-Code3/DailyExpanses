const $ = (s, el=document) => el.querySelector(s);
const $$ = (s, el=document) => el.querySelectorAll(s);

// Action functions
const activate = (id, ev) => {
	let el = $(`#${id}`);
	if (el.dataset.activeGroup) {
		let activeGroup = el.dataset.activeGroup;
		$$(`[data-active-group=${activeGroup}]`).forEach(other => {
			other.classList.remove('active');
		});
	}
	el.classList.add('active');
}

const deactivate = (id, ev) => $(`#${id}`).classList.remove('active');

const doSelectedOptionAction = (data, ev) => {
	let select = ev.target;
	let value = select.value;
	let selected = $(`[value=${value}][data-action]`, select);
	if (selected) {
		let actionName = selected.getAttribute(`data-action-select-option`);
		let actionData = selected.getAttribute(`data-action-select-option-data`);

		actionKeys[actionName](actionData, ev);
	}
}

const actionKeys = {
	'activate': activate,
	'deactivate': deactivate,
	'doSelectedOptionAction': doSelectedOptionAction
}

const actionTypes = {
	'click': (el, func) => el.onclick = func,
	'change': (el, func) => el.onchange = func
}

// Activation actions
$$('[data-action]').forEach(el => {

	for (let actionType in actionTypes) {
		let actionName = el.getAttribute(`data-action-${actionType}`);
		if (actionName) {
			let actionData = el.getAttribute(`data-action-${actionType}-data`);
			if (actionKeys[actionName]) {
				actionTypes[actionType](el, (ev) => { actionKeys[actionName](actionData, ev) });
			}
		}
		
	}
		
});

// Material select
$$('[data-material-select]').forEach(select => {
	let selectableElements = $$('.selectable[data-value]', select);
	let selectInput = $('input[data-material-select-input]', select);

	selectableElements.forEach(el => {
		el.onclick = () => {
			selectInput.value = el.dataset.value;
			$$('.selected', select).forEach(selected => {
				selected.classList.remove('selected');
			});
			el.classList.add('selected');
		}
	});
});