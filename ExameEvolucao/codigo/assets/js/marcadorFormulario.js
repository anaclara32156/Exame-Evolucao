$(document).ready(function() {
    $("#formulario").validate({
        rules: {
            marcador: { required: true },
            sexo: { required: true },
            grupo: { required: true },
            "idTipoValor[]": { required: true },
            "medida[]": { required: true },
            "idadeMinima[]": { required: true },
            "valor[]": { required: true },
            "confirmacaoValorMaximo[]": { required: true },
            "idadeMaxima[]": { required: true }
        },
        messages: {
            marcador: { required: "Campo obrigatório" },
            sexo: { required: "Campo obrigatório" },
            grupo: { required: "Campo obrigatório" },
            "idTipoValor[]": { required: "Campo obrigatório" },
            "medida[]": { required: "Campo obrigatório" },
            "idadeMinima[]": { required: "Campo obrigatório" },
            "valor[]": { required: "Campo obrigatório" },
            "confirmacaoValorMaximo[]": { required: "Campo obrigatório" },
            "idadeMaxima[]": { required: "Campo obrigatório" }
        },
        submitHandler: function(form) {
            // Desabilita o botão para evitar múltiplos cliques
            $('button[type="submit"]').prop('disabled', true);
            form.submit();
        }
    });
});
