package br.cefet.ExameEvolucao.service;

import java.util.List;

import org.jdbi.v3.core.Jdbi;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.server.ResponseStatusException;

import br.cefet.ExameEvolucao.dao.ExameDao;
import br.cefet.ExameEvolucao.model.Exame;
import br.cefet.ExameEvolucao.model.MarcadorUnidadeDTO;
@Service
public class ExameService {
    private final ExameDao exameDao;

    public ExameService(Jdbi jdbi) {
        this.exameDao = jdbi.onDemand(ExameDao.class);
    }

    public Exame inserir(Exame e) {
    	
        if (e.getId() != null) {
            throw new ResponseStatusException(HttpStatus.NOT_ACCEPTABLE, "Id - informacao ilegal.");
        }

        Long id = exameDao.inserir(e);
        e.setId(id);
        return e;
    }

    public List<Exame> consultar() {
        return exameDao.consultar();
    }

    public Exame consultarPorId(Long id) {
        return exameDao.consultarPorId(id);
    }
    
    public List<Exame> consultarPorCliente(Long idCliente) { 
		 return exameDao.consultarPorCliente(idCliente); 
	}
    
   
    public List<MarcadorUnidadeDTO> consultarMarcadoresUnicosComUnidade(Long idCliente) {
        return exameDao.consultarMarcadoresUnicosComUnidade(idCliente);
    }

    
    public List<Exame> consultarPorMarcadorEMedida(String marcador, Long idCliente, String medida) {
        return exameDao.consultarPorMarcadorEMedida(marcador, idCliente, medida);
    }

	/*
	 * public List<Exame> consultarPorUsuario(Long idUsuario) { return
	 * exameDao.consultarPorUsuario(idUsuario); }
	 */

    public Exame alterar(Exame e) {
 
        Long id = e.getId();
        if (id == null) {
            throw new ResponseStatusException(HttpStatus.PRECONDITION_FAILED, "Id eh informacao obrigatoria.");
        }

        Exame eAux = exameDao.consultarPorId(id);
        if (eAux == null) {
            throw new ResponseStatusException(HttpStatus.NOT_FOUND, "Exame nao encontrado com o id: " + id + ".");
        }

        int qtd = exameDao.alterar(e);

        if (qtd != 1) {
            throw new ResponseStatusException(HttpStatus.CONFLICT, "A quantidade de entidades alteradas eh " + qtd + ".");
        }

        eAux = exameDao.consultarPorId(id);
        return eAux;
    }

    public Exame excluir(Long id) {
    	Exame eAux = exameDao.consultarPorId(id);
        if (eAux == null) {
            throw new ResponseStatusException(HttpStatus.NOT_FOUND, "Exame nao encontrado com o id: " + id + ".");
        }

        int qtd = exameDao.excluir(id);

        if (qtd != 1) {
            throw new ResponseStatusException(HttpStatus.CONFLICT, "A quantidade de entidades alteradas eh " + qtd + ".");
        }

        return eAux;
    }


}
