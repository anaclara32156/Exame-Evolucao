$(document).ready(function () {
	$('#tabela').DataTable({
		language: {
			url: 'assets/js/dataTables.pt_br.json'
		}
	});
	  
});

function confirmarExclusao(codigo) {
	var resposta = confirm('Confirma a exclusão do registro?');

	if (resposta) {		
		//realiza uma requisição remota (assíncrona) 
		$.ajax({
			url  : 'clienteExcluir.php',
			type : 'post',
			data : {
				id : codigo
			}
		})
		.done(function(resultado){
			if(resultado){
				alert('Registro excluído com sucesso!');
				window.location.replace('index.php');
			}else{
				alert('Erro ao excluir o registro');
			}
		});  		
	}
}

