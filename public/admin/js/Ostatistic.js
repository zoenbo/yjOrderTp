$(function(){
	$('input.number').numberspinner({
		width : 80,
		height : 30,
		min : 0
	});
	
	$('input.date').datebox({
		width : 115,
		height : 30,
		editable : false
	});
	
	$('.list table').freezeHeader();
});