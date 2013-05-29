/**
 * Handles toggling the main navigation menu for small screens.
 */
jQuery("#mobile-view").click(function(){
	jQuery("#secondary").slideToggle();
	jQuery(this).toggleClass('show-menu');
});
jQuery(window).resize(function() {
	if( window.innerWidth > 800){
		document.getElementById('secondary').style.display = '';
		document.getElementById('mobile-view').className = '';
	} else {
		document.getElementById('secondary').style.display = 'none';
		document.getElementById('mobile-view').className = '';
	}
})
