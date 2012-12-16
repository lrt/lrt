// Init vars
var closedBoxesCookiePrefix = "SimplensoClosedBoxes_";
var boxPositionCookiePrefix = "SimplensoColumnBoxes_";
var deletedBoxesCookiePrefix = "SimplensoDeletedBoxes_";
var themeCookie = "SimplensoTheme";
var menuCookie = "SimplensoMenu";
var cookieExpiration = 365;

var screenWidth = $(document).width();
var screenHeigth =  $(document).height();

$(document).ready(function(){

	// Control funtion for portlet (box) buttons clicks
	function setControls(ui) {		
		//$('[class="box-btn"][title="toggle"]').click(function() {
		$('.box-btn').click(function() {
			var e = $(this);
			//var p = b.next('a');
			// Control functionality
			switch(e.attr('title').toLowerCase()) {
				case 'config':
					widgetConfig(b, p);
					break;
				
				case 'toggle':
					widgetToggle(e);
					break;
				
				case 'close':
					widgetClose(e);
					break;
			}
		});
	}
	
	// Toggle button widget
	function widgetToggle(e) {
		// Make sure the bottom of the box has rounded corners
		e.parent().toggleClass("round-all");
		e.parent().toggleClass("round-top");
		
		// replace plus for minus icon or the other way around
		if(e.html() == "<i class=\"icon-plus\"></i>") {
			e.html("<i class=\"icon-minus\"></i>");
		} else {
			e.html("<i class=\"icon-plus\"></i>");
		}
		
		// close or open box	
		e.parent().next(".box-container-toggle").toggleClass("box-container-closed");
		
		// store closed boxes in cookie
		var closedBoxes = [];
		var i = 0;
		$(".box-container-closed").each(function() 
		{
				closedBoxes[i] = $(this).parent(".box").attr("id");
				i++;		
		});
		//$.cookie(closedBoxesCookiePrefix + $("body").attr("id"), closedBoxes, { expires: cookieExpiration });
        
		//Prevent the browser jump to the link anchor
		return false; 
		
	}
	
	// Close button widget with dialog
	function widgetClose(e) {
		// get box element
		var box = e.parent().parent();
		
		// prompt user to confirm
		bootbox.confirm("Are you sure?", function(confirmed) {
			// remove box
			box.remove();
			
			// store removal in cookie
			$.cookie(deletedBoxesCookiePrefix + $("body").attr("id") + "_" + box.attr('id'), "yes", { expires: cookieExpiration });
   		});	
	}
	
	$('#box-close-modal .btn-success').click(function(e) {
		   // e is the element that triggered the event
		   console.log(e.target); // outputs an Object that you can then explore with Firebug/developer tool.
		   // for example e.target.firstChild.wholeText returns the text of the button
		});
	
	// Modify button widget
	function widgetConfig(w, p) {		
		$("#dialog-config-widget").dialog({
			resizable: false,
			modal: true,
			width: 500,
			buttons: {
				"Save changes": function(e, ui) {
					/* code the functionality here, could store in a cookie */					
					$(this).dialog("close");
				},
				Cancel: function() {					
					$(this).dialog("close");
				}
			}
		});
	}$('#tab').tab('show');
	
	// set portlet comtrols
	setControls();
});

