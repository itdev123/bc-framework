var builder = {
	sortableObj:{
		'.container':{
			items : 'section'
		}, 
		'ul.nav': {
			items : 'li',
			connectWith : 'ul.nav'
		}, 
		'.row': {
			items : 'col-3, col-6, col-4',
			connectWith : '.row'
		}, 
		'section': {
			items : 'h1, h2, h3, h4, h5, p',
			connectWith : 'section'
		}},
	init : function(){

	},
	applySortable : function() {
		for(var object in this.sortableObj) {
			$(object).sortable(this.sortableObj[object]);
		}
	}
}

$(document).ready(function() {
	var dragStartIndex, dragNewIndex;

	builder.applySortable();

	$(document).on('DOMNodeInserted', function(e) {
		var target = e.target;
		if ( $(target).hasClass('template_list') && $(target).prop("tagName") == 'LI') {
			setTimeout(function(){
				builder.applySortable();
			}, 500);
			
		}
	});
});



