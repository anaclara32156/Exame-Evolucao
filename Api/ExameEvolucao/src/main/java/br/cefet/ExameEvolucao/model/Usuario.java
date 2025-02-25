package br.cefet.ExameEvolucao.model;

import org.springframework.boot.autoconfigure.domain.EntityScan;

import jakarta.validation.constraints.NotBlank;
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
public class Usuario {		
	    private Long id;
	    @NotBlank(message = "Nome é obrigatório")
	    private String nome; 
	    private String cpf; 
	    private String email; 
	    private String senha; 
}
