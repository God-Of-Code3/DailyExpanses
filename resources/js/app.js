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

const locate = (link, ev) => window.location.href = link;

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
	'doSelectedOptionAction': doSelectedOptionAction,
	'locate': locate,
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
	let value = $('.row[data-value]', select).dataset.value;

	selectableElements.forEach(el => {
		if (el.dataset.value == value) {
			el.classList.add('selected');
		}
		el.onclick = () => {
			selectInput.value = el.dataset.value;
			$$('.selected', select).forEach(selected => {
				selected.classList.remove('selected');
			});
			el.classList.add('selected');
		}
	});
});

// Tabs
$$('.tabs').forEach(tabsEl => {
	let tabs = $$('.tab', tabsEl);
	tabs.forEach(tab => {
		tab.addEventListener('click', () => {
			tabs.forEach(tb => tb.classList.remove('active'));
			tab.classList.add('active');
		})
	});
});

// Setting select default data
$$('select[value]').forEach(sel => {
	let options = $$('option', sel);
	let value = sel.getAttribute('value');
	options.forEach(option => {
		if (option.value == value) {
			option.setAttribute('selected', true);
		}
	});
});