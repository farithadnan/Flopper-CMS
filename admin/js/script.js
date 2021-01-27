$(document).ready(function(){
	
	// EDITOR CKEDITOR START
	ClassicEditor
	.create( document.querySelector( '#body' ) )
	.catch( error => {
	    console.error( error );
	} );
	// EDITOR CKEDITOR END
});

