$(document).ready(function () {
	 $('#tabela').DataTable({
		language: {
			url: 'assets/js/dataTables.pt_br.json'
	 	}
	 });
	 $('.cpf').mask('999.999.999-99');	
	$('.data').mask("00/00/0000");
});

function confirmarExclusao(codigo, idCliente) {
	var resposta = confirm('Confirma a exclusão do registro?');

	if (resposta) {		
		//realiza uma requisição remota (assíncrona) 
		$.ajax({
			url  : 'exameExcluir.php',
			type : 'post',
			data : {
				id : codigo,
				idCliente: idCliente 
			}
		})
		.done(function(resultado){
			if(resultado){
				alert('Registro excluído com sucesso!');
				window.location.replace('exame.php?idCliente=' + idCliente);
			}else{
				alert('Erro ao excluir o registro');
			}
		});  		
	}
}



