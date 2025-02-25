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

import br.cefet.ExameEvolucao.model.Cliente;
import br.cefet.ExameEvolucao.service.ClienteService;
import jakarta.validation.Valid;

@RequestMapping("/api/v1/cliente")
@RestController
@CrossOrigin("Access-Control-Allow-Methods:PUT, GET, DELETE, OPTIONS") 
public class ClienteController {
    private final ClienteService clienteService;

    public ClienteController(ClienteService clienteService) {
        this.clienteService = clienteService;
    }

    @PostMapping({"/", ""})
    public ResponseEntity<Cliente> inserir(@Valid @RequestBody Cliente c) {
        return ResponseEntity.ok(clienteService.inserir(c));
    }

    @GetMapping({"/", ""})
    public ResponseEntity<List<Cliente>> consultar() {
        return ResponseEntity.ok(clienteService.consultar());
    }

    @GetMapping("/{id}")
    public ResponseEntity<Cliente> consultarPorId(@PathVariable Long id) {
        return ResponseEntity.ok(clienteService.consultarPorId(id));
    }

    @GetMapping("/usuario/{idUsuario}")
    public ResponseEntity<List<Cliente>> consultarPorUsuario(@PathVariable Long idUsuario) {
        List<Cliente> clientes = clienteService.consultarPorUsuario(idUsuario);
        if (clientes.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(clientes);
    }

    @PutMapping({"/", ""})
    public ResponseEntity<Cliente> alterar(@Valid @RequestBody Cliente c) {
        return ResponseEntity.ok(clienteService.alterar(c));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Cliente> excluir(@PathVariable Long id) {
        return ResponseEntity.ok(clienteService.excluir(id));
    }
}
