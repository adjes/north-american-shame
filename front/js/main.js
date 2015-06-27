var core = function (core) {
   	
	// get subj&art, session

	var config = {
		dataSource : "http://imgsz/"
	};

	var cache = {};

	var ajax = {
		getData : function () {
			return  $.ajax ({
				url: config.dataSource,
				type: 'GET',
				beforeSend: function (xhr) {
				  xhr.setRequestHeader('Accept', 'application/json; charset=utf-8');
				},	
				data: {},
				success: function(data) {
					cache.data = data;
					return this;
				}
			});
		},
		getSession : function () {
			return $.get(src || config.dataSource, function (data) {
				cache.session = data;
				return this;
			});
		}
	};

	function init () {

		ajax.getData();

	}

	init();

   	return {
   		config : config,
   		cache : cache,
   		init : init
   	};

}({});
