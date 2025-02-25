package br.cefet.ExameEvolucao.service;

import java.util.List;

import org.jdbi.v3.core.Jdbi;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.server.ResponseStatusException;

import br.cefet.ExameEvolucao.dao.ClienteDao;
import br.cefet.ExameEvolucao.model.Cliente;

@Service
public class ClienteService {
    private final ClienteDao clienteDao;

    public ClienteService(Jdbi jdbi) {
        this.clienteDao = jdbi.onDemand(ClienteDao.class);
    }

    public Cliente inserir(Cliente c) {
        if (c.getId() != null) {
            throw new ResponseStatusException(HttpStatus.NOT_ACCEPTABLE, "Id - informacao ilegal.");
        }

        Long id = clienteDao.inserir(c);
        c.setId(id);
        return c;
    }

    public List<Cliente> consultar() {
        return clienteDao.consultar();
    }

    public Cliente consultarPorId(Long id) {
        return clienteDao.consultarPorId(id);
    }

    public List<Cliente> consultarPorUsuario(Long idUsuario) {
        return clienteDao.consultarPorUsuario(idUsuario);
    }

    public Cliente alterar(Cliente c) {
        Long id = c.getId();
        if (id == null) {
            throw new ResponseStatusException(HttpStatus.PRECONDITION_FAILED, "Id eh informacao obrigatoria.");
        }

        Cliente cAux = clienteDao.consultarPorId(id);
        if (cAux == null) {
            throw new ResponseStatusException(HttpStatus.NOT_FOUND, "Cliente nao encontrado com o id: " + id + ".");
        }

        int qtd = clienteDao.alterar(c);

        if (qtd != 1) {
            throw new ResponseStatusException(HttpStatus.CONFLICT, "A quantidade de entidades alteradas eh " + qtd + ".");
        }

        cAux = clienteDao.consultarPorId(id);
        return cAux;
    }

    public Cliente excluir(Long id) {
        Cliente cAux = clienteDao.consultarPorId(id);
        if (cAux == null) {
            throw new ResponseStatusException(HttpStatus.NOT_FOUND, "Cliente nao encontrado com o id: " + id + ".");
        }

        int qtd = clienteDao.excluir(id);

        if (qtd != 1) {
            throw new ResponseStatusException(HttpStatus.CONFLICT, "A quantidade de entidades alteradas eh " + qtd + ".");
        }

        return cAux;
    }
}
