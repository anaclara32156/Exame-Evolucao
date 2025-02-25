package br.cefet.ExameEvolucao.controller;

import java.util.List;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import br.cefet.ExameEvolucao.model.TipoDeValor;
import br.cefet.ExameEvolucao.service.TipoDeValorService;
import jakarta.validation.Valid;

@RequestMapping("/api/v1/tipoDeValor")
@RestController
@CrossOrigin("Access-Control-Allow-Methods:PUT, GET, DELETE, OPTIONS")
public class TipoDeValorController {
	private TipoDeValorService tipoDeValorService;

    public void TipoDeValorService(TipoDeValorService tipoDeValorService) {
        this.tipoDeValorService = tipoDeValorService;
    }

    @PostMapping({"/", ""})
    public ResponseEntity<TipoDeValor> inserir(@Valid @RequestBody TipoDeValor tv) {
        return ResponseEntity.ok(tipoDeValorService.inserir(tv));
    }

    @GetMapping({"/", ""})
    public ResponseEntity<List<TipoDeValor>> consultar() {
        return ResponseEntity.ok(tipoDeValorService.consultar());
    }

    @GetMapping("/{id}")
    public ResponseEntity<TipoDeValor> consultarPorId(@PathVariable Long idTipoDeValor) {
        return ResponseEntity.ok(tipoDeValorService.consultarPorId(idTipoDeValor));
    }
}
