package br.cefet.ExameEvolucao.model;

import org.jdbi.v3.core.mapper.reflect.ColumnName;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

@AllArgsConstructor
@NoArgsConstructor
@Setter
@Getter
public class Valor {
    private Long idValor;
    private Long idTipoDeValor;
    private Long idMarcador;

    @ColumnName("eMaximo") // Garante que o Jdbi mapeie corretamente
    private String eMaximo;

    private String proprioValor;
    private String idadeInferior;
    private String idadeSuperior;
    private String sexoBiologico;
    private String unidadeDeMedida;
}
