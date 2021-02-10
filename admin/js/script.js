$(document).ready(function(){
	
	// EDITOR CKEDITOR START
	ClassicEditor
	.create( document.querySelector( '#body' ) )
	.catch( error => {
	    console.error( error );
	} );
	// EDITOR CKEDITOR END

	//Select all checkbox (post) start
	$('#selectAllBoxes').click(function(event){
		if(this.checked) 
		{
			//this checkboxes is actually refer to the class in the view all post page
			$('.checkBoxes').each(function(){
				this.checked = true;
			});
		} else {
			$('.checkBoxes').each(function(){
				this.checked = false;
			});
		}
	});
	//Select all checkbox (post) end



	var div_box = "<div id='load-screen'><div id='loading'></div></div>";
	$("body").prepend(div_box);

	$('#load-screen').delay(700).fadeOut(600, function(){
		$(this).remove();
	});
});


function loadUsersOnline() {

	$.get("functions.php?onlineusers=result", function(data){
		$(".usersonline").text(data);
	});

}

setInterval(function(){

	 loadUsersOnline();

},500);
