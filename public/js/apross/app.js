var AppClass = (function() {
	var listeners = [
		{
			id: 'btn-print-content',
			ev: 'click',
			method: bindPrintButton,
		},
	];

	function init() {
		setListeners();
	}

	function setListeners() {
		for (var i = 0; i < listeners.length; i++) {
			var elem = document.getElementById(listeners[i].id);
			elem.addEventListener(listeners[i].ev, listeners[i].method);
		}
	}

	function getOriginalPath(target) {
		var pathName = window.location.pathname;
		var pathToAdd = target ? target : '';
		return pathName.split('forms/')[0] + pathToAdd;
	}

	function bindContentLinkClick(e) {
		e.preventDefault();
		window.location.href = getOriginalPath(e.target.hash);
	}

	function createContentLinks(name) {
		if (!name) return;

		var forms = {
			osecac: [
				{
					text: '3.1 - Planilla de Ingreso de Facturación',
					src: getOriginalPath('forms/osecac/3.1.html'),
				},
				{
					text: '3.2 Planilla de Asistencia Mensual',
					src: getOriginalPath('forms/osecac/3.2.html'),
				},
				{
					text: '3.3  Planilla de Asistencia Mensual – Instituciones',
					src: getOriginalPath('forms/osecac/3.3.html'),
				},
				{
					text:
						'3.4 Planilla de Asistencia Mensual - Apoyo a la Integración Escolar',
					src: getOriginalPath('forms/osecac/3.4.html'),
				},
				{
					text:
						'3.5 Planilla de Asistencia Mensual - Maestro de Apoyo (valor módulo)',
					src: getOriginalPath('forms/osecac/3.5.html'),
				},
				{
					text: '3.6 PLANILLA DE ASISTENCIA MENSUAL - TRANSPORTE',
					src: getOriginalPath('forms/osecac/3.6.html'),
				},
				{
					text: '3.7 INFORMACIÓN BANCARIA PARA EL COBRO DE FACTURACIONES',
					src: getOriginalPath('forms/osecac/3.7.html'),
				},
				{
					text: 'Anexo 8.4 Presupuesto Tratamientos / Maestra de Apoyo',
					src: getOriginalPath('forms/osecac/8.4.html'),
				},
				{
					text: 'Anexo 8.5 - Presupuesto Transporteo',
					src: getOriginalPath('forms/osecac/8.5.html'),
				},
				{
					text: 'Anexo 8.6 Planilla de solicitud de transporte',
					src: getOriginalPath('forms/osecac/8.6.html'),
				},
			],
			apross: [
				{
					text: 'Planilla de integración escolar',
					src: getOriginalPath('forms/appross/integracion.html'),
				},
				{
					text: 'PLANILLA DE ASISTENCIA DIARIA - REHABILITACIÓN',
					src: getOriginalPath('forms/appross/rehabilitacion.html'),
				},
				{
					text: 'REGLAMENTACIÓN DE COBERTURA TRANSPORTE SAID- ANEXO I',
					src: getOriginalPath('forms/appross/consent.html'),
				},
			],
		};

		if (!forms[name] || forms[name] === []) return;

		var mainLinks = document.getElementById('index-main-links');
		mainLinks.innerHTML = '';

		var targetLinks = forms[name];

		for (var i = 0; i < targetLinks.length; i++) {
			var aTag = document.createElement('a');
			var textNode = document.createTextNode(targetLinks[i].text);
			aTag.setAttribute('href', targetLinks[i].src);
			aTag.setAttribute('class', 'btn secondary-outline main-link');
			aTag.appendChild(textNode);

			mainLinks.appendChild(aTag);
		}
	}

	function bindPrintButton(e) {
		e.preventDefault();

		var header = document.getElementsByTagName('header')[0];
		var body = document.getElementsByTagName('body')[0];
		header.remove();

		window.print();
		try {
			body.prepend(header);
		} catch (err) {
			window.location.reload();
		}
	}

	function createNumberThRows(selector, style, quantity, start, texts) {
		var tableElem = document.getElementById(selector);
		var theadElem = tableElem.getElementsByTagName('thead')[0];
		var trElem = document.createElement('tr');

		for (var i = 0; i < quantity; i++) {
			var thElem = document.createElement('th');
			var text =
				texts && texts.length ? texts[i] : start ? start + i + 1 : i + 1;
			var textElem = document.createTextNode(text);

			thElem.setAttribute('style', style);
			thElem.appendChild(textElem);
			trElem.appendChild(thElem);
		}

		theadElem.appendChild(trElem);
	}

	function createTableRows(
		selector,
		quantityRows,
		quantityColumns,
		tdWidths,
		tdHeight
	) {
		var tableElem = document.getElementById(selector);
		var tbodyElem = document.createElement('tbody');

		tdWidths = tdWidths ? tdWidths : [];

		for (var i = 0; i < quantityRows; i++) {
			var trElem = document.createElement('tr');

			for (var j = 0; j < quantityColumns; j++) {
				var tdWidth = tdWidths[j] ? tdWidths[j] : null;

				var tdElem = document.createElement('td');
				var inputElem = document.createElement('input');

				if (tdWidth) {
					tdElem.setAttribute('style', 'width: ' + tdWidth + '%');
				}

				if (tdHeight) {
					tdElem.setAttribute('style', 'height:' + tdHeight + 'px');
				}

				inputElem.setAttribute('type', 'text');
				inputElem.setAttribute('id', 'table-input-' + (j + 1));
				inputElem.setAttribute('class', 'table-input');

				tdElem.appendChild(inputElem);
				trElem.appendChild(tdElem);
			}

			tbodyElem.appendChild(trElem);
		}

		tableElem.appendChild(tbodyElem);
	}

	function bindInputCheck(e) {
		e.preventDefault();

		var target = e.target;
		var checked = parseInt(target.dataset.checked);

		if (checked) {
			target.dataset.checked = 0;
			target.innerHTML = '';
			return;
		}

		target.innerHTML = 'X';
		target.dataset.checked = 1;
	}

	return {
		init: init,
		bindContentLinkClick: bindContentLinkClick,
		createContentLinks: createContentLinks,
		createNumberThRows: createNumberThRows,
		createTableRows: createTableRows,
		bindInputCheck: bindInputCheck,
	};
})();

AppClass.init();
