$(document).ready(function(){
	$('#cpf').mask('999.999.999-99');
});

$("#formulario").validate({
	rules: {
		nome: {
			required: true  
		},
		cpf: {
			required: true,
			remote: {
				url: "usuarioVerificarCPF.php",
				type: "post",
				data: {
					id: function() {
						return $("#id").val();
				  	}
				}
			}		   
		},
		email: {
			required: true,
			email: true,
			remote: {
				url: "usuarioVerificarEmail.php",
				type: "post",
				data: {
					id: function() {
						return $("#id").val();
				  	}
				}
			}		   
		},	
		senha: {
			required: true	   
		}											
	}, 
	messages: {
		nome: {
			required: "Campo obrigatório"
		},		
		cpf: {
			required: "Campo obrigatório",
			remote: "O CPF informado já existe"
		},
		email: {
			required: "Campo obrigatório",
			email: "Informe um e-mail válido",
			remote: "O e-mail informado já existe"
		},	
		senha: {
			required: "Campo obrigatório"
		}			   
	},
	submitHandler: function(form) {
		// Desabilita o botão para evitar múltiplos cliques
		$('button[type="submit"]').prop('disabled', true);

		// Verifica se o email já existe antes de submeter o formulário
		$.ajax({
			url: "usuarioVerificarEmail.php",
			type: "post",
			data: {
				email: $("#email").val(),
				id: $("#id").val()
			},
			success: function(response) {
				var emailExists = response === "true";
				if (emailExists) {
					alert("O e-mail informado já existe. Por favor, utilize outro e-mail.");
					$('button[type="submit"]').prop('disabled', false); // Reabilita o botão
				} else {
					// Envia o formulário
					form.submit();
				}
			}
		});
	}
});
