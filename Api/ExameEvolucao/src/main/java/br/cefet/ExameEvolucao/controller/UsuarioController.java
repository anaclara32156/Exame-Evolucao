package br.cefet.ExameEvolucao.controller;
import java.util.List;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import br.cefet.ExameEvolucao.model.Usuario;
import br.cefet.ExameEvolucao.service.UsuarioService;
import jakarta.validation.Valid;

@RequestMapping("/api/v1/usuario")
@RestController 
@CrossOrigin("http://localhost:*") 
public class UsuarioController {

	    private final UsuarioService usuarioService;

	    public UsuarioController(UsuarioService usuarioService) {
	        this.usuarioService = usuarioService;
	    }

	    @PostMapping({"/", ""})
	    public ResponseEntity<Usuario> inserir(@Valid @RequestBody Usuario u) {
	        return ResponseEntity.ok(usuarioService.inserir(u));
	    }

	    @GetMapping({"/", ""})
	    public ResponseEntity<List<Usuario>> consultar() {
	        return ResponseEntity.ok(usuarioService.consultar());
	    }

	    @GetMapping({"/{id}"})
	    public ResponseEntity<Usuario> consultarPorId(@PathVariable Long id) {
	        return ResponseEntity.ok(usuarioService.consultarPorId(id));
	    }
	    
	    @PutMapping({"/", ""})
	    public ResponseEntity<Usuario> alterar(@Valid @RequestBody Usuario u) {
	        return ResponseEntity.ok(usuarioService.alterar(u));
	    }
	    
	    @DeleteMapping({"/{id}"})
	    public ResponseEntity<Usuario> excluir(@PathVariable Long id) {
	        return ResponseEntity.ok(usuarioService.excluir(id));
	    }
}