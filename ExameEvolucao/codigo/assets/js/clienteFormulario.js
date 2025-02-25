$(document).ready(function(){
	$('#cpf').mask('999.999.999-99');
	$('#tel').mask('(99) 99999-9999');
});

$("#formulario").submit(function() {
	if ($('#formulario').valid()){
		$("#cpf").unmask();
		$("#tel").unmask();
	}
});

$("#formulario").validate(
	{
		rules:{
			nome:{
				required:true
			},
			dataNascimento:{
				required:true
			},
			cpf:{
				required:true,   
			},
			sexo:{
				required:true
			},
			email:{
				required:true,
				email: true,
			},						
		}, 
		messages:{
			nome:{
				required:"Campo obrigatório"
			},
			dataNascimento:{
				required:"Campo obrigatório"
			},
			cpf:{
				required:"Campo obrigatório",
				remote:"O CPF informado já existe"
			},
			sexo:{
				required:"Campo obrigatório"
			},
			email:{
				required:"Campo obrigatório",
				remote:"O e-mail informado já existe"
			},			   
		}
	}
);