package br.cefet.ExameEvolucao.model;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

@AllArgsConstructor
@NoArgsConstructor
@Setter
@Getter
public class ValorDTO {
    @JsonProperty("nomeMarcador")
    private String nomeMarcador;

    @JsonProperty("grupo")
    private String grupo;

    @JsonProperty("idTipoDeValor")
    private Long idTipoDeValor;

    @JsonProperty("unidadeDeMedida")
    private String unidadeDeMedida;

    @JsonProperty("sexoBiologico")
    private String sexoBiologico;

    @JsonProperty("eMaximo")
    private String eMaximo;

    @JsonProperty("proprioValor")
    private String proprioValor;

    @JsonProperty("idadeInferior")
    private String idadeInferior;

    @JsonProperty("idadeSuperior")
    private String idadeSuperior;
    
    @JsonProperty("idUsuario")
    private Long idUsuario;
}
