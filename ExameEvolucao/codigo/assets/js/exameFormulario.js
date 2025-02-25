$(document).ready(function() {
    // Máscara de CPF, caso seja necessário
    $('#cpf').mask('999.999.999-99');

    // Inicializa o validador do formulário
    $("#formulario").validate({
        rules: {
            grupo: {
                required: true
            },
            dataColeta: {
                required: true
            },
            "nomeMarcador[]": {
                required: true
            },
            "resultado[]": {
                required: true
            },
            "medida[]": {
                required: true
            }
        },
        messages: {
            grupo: {
                required: "Campo obrigatório"
            },
            dataColeta: {
                required: "Campo obrigatório"
            },
            "nomeMarcador[]": {
                required: "Campo obrigatório"
            },
            "resultado[]": {
                required: "Campo obrigatório"
            },
            "medida[]": {
                required: "Campo obrigatório"
            }
        },
        submitHandler: function(form) {
            // Desabilita o botão para evitar múltiplos cliques
            $('button[type="submit"]').prop('disabled', true);

            // Envia o formulário
            form.submit();
        }
    });
});
