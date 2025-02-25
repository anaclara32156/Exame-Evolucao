$("#formulario").validate(
	{
		rules:{
			email:{
				required:true
			},
			senha:{
				required:true	
			}					
		}, 
		messages:{
			email:{
				required:"Campo obrigatório"
			},
			senha:{
				required:"Campo obrigatório"
			}							   
		}
	}
);