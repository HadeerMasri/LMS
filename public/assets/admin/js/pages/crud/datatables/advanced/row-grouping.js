"use strict";
var KTDatatablesAdvancedRowGrouping = function() {

	var init = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
			pageLength: 25,
			order: [[2, 'asc']],
			drawCallback: function(settings) {
				var api = this.api();
				var rows = api.rows({page: 'current'}).nodes();
				var last = null;

				api.column(3, {page: 'current'}).data().each(function(group, i) {
					if (last !== group) {
						$(rows).eq(i).before(
							'<tr class="group"><td colspan="10">' + group + '</td></tr>',
						);
						last = group;
					}
				});
			},
			columnDefs: [
				{
					// hide columns by index number
					targets: 3,
					visible: false,
				},
				{
					targets: 4,
					title: 'Actions',
					orderable: false,
					render: function(data, type, full, meta) {
						return '\
							<a href="" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
								<i class="la la-edit"></i>\
							</a>\
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">\
								<i class="la la-trash"></i>\
							</a>\
						';
					},
				},
				// {
				// 	targets: 8,
				// 	render: function(data, type, full, meta) {
				// 		var status = {
				// 			1: {'title': 'Pending', 'class': 'label-light-primary'},
				// 			2: {'title': 'Delivered', 'class': ' label-light-danger'},
				// 			3: {'title': 'Canceled', 'class': ' label-light-primary'},
				// 			4: {'title': 'Success', 'class': ' label-light-success'},
				// 			5: {'title': 'Info', 'class': ' label-light-info'},
				// 			6: {'title': 'Danger', 'class': ' label-light-danger'},
				// 			7: {'title': 'Warning', 'class': ' label-light-warning'},
				// 		};
				// 		if (typeof status[data] === 'undefined') {
				// 			return data;
				// 		}
				// 		return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
				// 	},
				// },
				// {
				// 	targets: 9,
				// 	render: function(data, type, full, meta) {
				// 		var status = {
				// 			1: {'title': 'Online', 'state': 'danger'},
				// 			2: {'title': 'Retail', 'state': 'primary'},
				// 			3: {'title': 'Direct', 'state': 'success'},
				// 		};
				// 		if (typeof status[data] === 'undefined') {
				// 			return data;
				// 		}
				// 		return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
				// 			'<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
				// 	},
				// },
			],
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			init();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesAdvancedRowGrouping.init();
});
