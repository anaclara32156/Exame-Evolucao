package br.cefet.ExameEvolucao.model;


import org.springframework.boot.autoconfigure.domain.EntityScan;

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
public class TipoDeValor {
	private Long idTipoDeValor; 
	private String nomeTipoDeValor; 
}
