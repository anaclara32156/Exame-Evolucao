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
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import br.cefet.ExameEvolucao.model.Exame;
import br.cefet.ExameEvolucao.model.MarcadorUnidadeDTO;
import br.cefet.ExameEvolucao.service.ExameService;
import jakarta.validation.Valid;

@RequestMapping("/api/v1/exame")
@RestController
@CrossOrigin("http://localhost:*") 
public class ExameController {
	private final ExameService exameService;

    public ExameController(ExameService exameService) {
        this.exameService = exameService;
    }

    @PostMapping({"/", ""})
    public ResponseEntity<Exame> inserir(@Valid @RequestBody Exame e) {
        return ResponseEntity.ok(exameService.inserir(e));
    }

    @GetMapping({"/", ""})
    public ResponseEntity<List<Exame>> consultar() {
        return ResponseEntity.ok(exameService.consultar());
    }

    @GetMapping("/{id}")
    public ResponseEntity<Exame> consultarPorId(@PathVariable Long id) {
        return ResponseEntity.ok(exameService.consultarPorId(id));
    }

    //@GetMapping("/usuario/{idUsuario}")
   // public ResponseEntity<List<Exame>> consultarPorUsuario(@PathVariable Long idUsuario) {
      //  List<Cliente> clientes = exameService.consultarPorUsuario(idUsuario);
      //  if (clientes.isEmpty()) {
       //     return ResponseEntity.noContent().build();
       // }
      //  return ResponseEntity.ok(clientes);
   // }

    @GetMapping("/cliente/{idCliente}")
    public ResponseEntity<List<Exame>> consultarPorCliente(@PathVariable Long idCliente) {
        List<Exame> exames = exameService.consultarPorCliente(idCliente);
      if (exames.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(exames);
   }
    

    @GetMapping("/cliente/{idCliente}/unicos")
    public ResponseEntity<List<MarcadorUnidadeDTO>> consultarMarcadoresUnicosComUnidade(@PathVariable Long idCliente) {
        List<MarcadorUnidadeDTO> marcadores = exameService.consultarMarcadoresUnicosComUnidade(idCliente);
        if (marcadores.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(marcadores);
    }

    
    @GetMapping("/marcador/{marcador}/idCliente/{idCliente}")
    public ResponseEntity<List<Exame>> consultarPorMarcadorEMedida(
            @PathVariable String marcador,
            @PathVariable Long idCliente,
            @RequestParam String medida) {
        List<Exame> exames = exameService.consultarPorMarcadorEMedida(marcador, idCliente, medida);
        if (exames.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(exames);
    }



    
    @PutMapping({"/", ""})
    public ResponseEntity<Exame> alterar(@Valid @RequestBody Exame e) {
        return ResponseEntity.ok(exameService.alterar(e));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Exame> excluir(@PathVariable Long id) {
        return ResponseEntity.ok(exameService.excluir(id));
    }
}
