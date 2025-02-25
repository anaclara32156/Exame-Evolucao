package br.cefet.ExameEvolucao.controller;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

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

import br.cefet.ExameEvolucao.model.Marcador;
import br.cefet.ExameEvolucao.model.ValorDTO;
import br.cefet.ExameEvolucao.service.MarcadorService;
import jakarta.validation.Valid;

@RequestMapping("/api/v1/marcador")
@CrossOrigin("Access-Control-Allow-Methods:PUT, GET, DELETE, OPTIONS")
@RestController
public class MarcadorController {
	private final MarcadorService marcadorService;

    public MarcadorController(MarcadorService marcadorService) {
        this.marcadorService = marcadorService;
    }

    @PostMapping({"/", ""})
    public ResponseEntity<Marcador> inserir(@Valid @RequestBody ValorDTO dto) {
        System.out.println("eMaximo recebido: " + dto.getEMaximo());
        System.out.println("Marcador recebido: " + dto.getNomeMarcador());
        System.out.println("Id Tipo de valorr ===== recebido: " + dto.getIdTipoDeValor());
        
        return ResponseEntity.ok(marcadorService.inserir(dto));
    }
    
    @PostMapping({"/existente"})
    public ResponseEntity<Map<String, String>> verificarExistente(@Valid @RequestBody ValorDTO dto) {
        String mensagem = marcadorService.verificarExistente(dto);
        
        Map<String, String> response = new HashMap<>();
        response.put("mensagem", mensagem);
        
        return ResponseEntity.ok(response);
    }



    @GetMapping({"/", ""})
    public ResponseEntity<List<Marcador>> consultar() {
        return ResponseEntity.ok(marcadorService.consultar());
    }

    @GetMapping("/{id}")
    public ResponseEntity<Marcador> consultarPorId(@PathVariable Long id) {
        return ResponseEntity.ok(marcadorService.consultarPorId(id));
    }
    
    @GetMapping("/usuario/{idUsuario}/grupo/{grupo}")
    public ResponseEntity<List<Marcador>> consultarPorUsuarioEGrupo(@PathVariable Long idUsuario, @PathVariable String grupo) {
        return ResponseEntity.ok(marcadorService.consultarPorUsuarioEGrupo(idUsuario, grupo));
    }

    @PutMapping({"/", ""})
    public ResponseEntity<Marcador> alterar(@Valid @RequestBody Marcador m) {
        return ResponseEntity.ok(marcadorService.alterar(m));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Marcador> excluir(@PathVariable Long id) {
        return ResponseEntity.ok(marcadorService.excluir(id));
    }
}
