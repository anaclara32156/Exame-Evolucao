package br.cefet.ExameEvolucao.controller;

import java.util.List;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import br.cefet.ExameEvolucao.model.Exame;
import br.cefet.ExameEvolucao.model.ProprioValorDTO;
import br.cefet.ExameEvolucao.model.Valor;
import br.cefet.ExameEvolucao.model.ValorDTO;
import br.cefet.ExameEvolucao.service.ValorService;
import jakarta.validation.Valid;

@RequestMapping("/api/v1/valor")
@RestController
@CrossOrigin("Access-Control-Allow-Methods:PUT, GET, DELETE, OPTIONS") 
public class ValorController {
	private final ValorService valorService;

    public ValorController(ValorService valorService) {
        this.valorService = valorService;
    }

    @PostMapping({"/", ""})
    public ResponseEntity<Valor> inserir(@Valid @RequestBody Valor v) {
        return ResponseEntity.ok(valorService.inserir(v));
    }

    @GetMapping({"/", ""})
    public ResponseEntity<List<Valor>> consultar() {
        return ResponseEntity.ok(valorService.consultar());
    }

    @GetMapping("/{id}")
    public ResponseEntity<Valor> consultarPorId(@PathVariable Long idValor) {
        return ResponseEntity.ok(valorService.consultarPorId(idValor));
    }
    
    @GetMapping("/marcador/{idMarcador}/sexoBiologico/{sexoBiologico}")
    public ResponseEntity<List<ProprioValorDTO>> consultarPorMarcadorUnidadeDeMedidaESexo(@PathVariable Long idMarcador,
    		@PathVariable String sexoBiologico,
    		@RequestParam String unidadeDeMedida) {
        List<ProprioValorDTO> ProprioValorDTOs = valorService.consultarPorMarcadorUnidadeDeMedidaESexo(idMarcador, unidadeDeMedida, sexoBiologico);
        System.out.println("⚠️ ________________________ sexo recebido: " + ProprioValorDTOs);
        if (ProprioValorDTOs.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(ProprioValorDTOs);
    }
    
    @GetMapping("/unidades/{idMarcador}")
    public ResponseEntity<List<String>> listarUnidadesDeMedidaPorMarcador(@PathVariable Long idMarcador) {
        List<String> unidadesDeMedida = valorService.listarUnidadesDeMedidaPorMarcador(idMarcador);
        if (unidadesDeMedida.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(unidadesDeMedida);
    }


}
