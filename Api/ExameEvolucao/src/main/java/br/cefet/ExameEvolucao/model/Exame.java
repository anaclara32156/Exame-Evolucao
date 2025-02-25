package br.cefet.ExameEvolucao.model;
import java.sql.Date;
import org.springframework.boot.autoconfigure.domain.EntityScan;

import com.fasterxml.jackson.annotation.JsonFormat;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import lombok.ToString;

@ToString
@AllArgsConstructor
@NoArgsConstructor
@Setter
@Getter
@EntityScan
public class Exame {
	private Long id;
    private String marcador; 
    private String grupo; 
    @JsonFormat(pattern="yyyy-MM-dd",timezone = "GMT-3")
    private Date dataColeta; 
    private double resultado; 
    private Long idCliente; 
    private Long idMarcador; 
    private String medida; 
}
