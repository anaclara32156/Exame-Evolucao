package br.cefet.ExameEvolucao.model;

import java.sql.Date;

import org.springframework.boot.autoconfigure.domain.EntityScan;

import com.fasterxml.jackson.annotation.JsonFormat;

import jakarta.validation.constraints.NotBlank;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import lombok.ToString;
import jakarta.validation.constraints.Size;

@ToString
@AllArgsConstructor
@NoArgsConstructor
@Setter
@Getter
@EntityScan
public class Cliente {
	 private Long id;
	    @NotBlank(message = "Nome é obrigatório")
	    @Size(min=3, max=40)
	    private String nome; 
	    private String cpf; 
	    private String email; 
	    @JsonFormat(pattern="yyyy-MM-dd",timezone = "GMT-3")
	    private Date dataNascimento;
	    private String sexo; 
	    private String tel; 
	    private Long idUsuario; 

}
