package br.cefet.ExameEvolucao.service;

import java.util.List;
import java.util.stream.Collectors;

import org.jdbi.v3.core.Jdbi;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.server.ResponseStatusException;

import br.cefet.ExameEvolucao.dao.ValorDao;
import br.cefet.ExameEvolucao.model.Exame;
import br.cefet.ExameEvolucao.model.ProprioValorDTO;
import br.cefet.ExameEvolucao.model.Valor;
import br.cefet.ExameEvolucao.model.ValorDTO;

@Service
public class ValorService {
	private final ValorDao valorDao;

    public ValorService(Jdbi jdbi) {
        this.valorDao = jdbi.onDemand(ValorDao.class);
    }

    public Valor inserir(Valor v) {
        if (v.getIdValor() != null) {
            throw new ResponseStatusException(HttpStatus.NOT_ACCEPTABLE, "Id - informacao ilegal.");
        }

        Long id = valorDao.inserir(
            v.getIdTipoDeValor(),
            v.getIdMarcador(),
            v.getEMaximo(), 
            v.getProprioValor(),
            v.getIdadeInferior(),
            v.getIdadeSuperior(),
            v.getSexoBiologico(),
            v.getUnidadeDeMedida()
        );

        v.setIdValor(id);
        return v;
    }


    public List<Valor> consultar() {
        return valorDao.consultar();
    }

    public Valor consultarPorId(Long idValor) {
        return valorDao.consultarPorId(idValor);
    }
    
    public List<ProprioValorDTO> consultarPorMarcadorUnidadeDeMedidaESexo(Long idMarcador, String unidadeDeMedida, String sexoBiologico) {
        List<Valor> valores = valorDao.consultarPorMarcadorUnidadeDeMedidaESexo(idMarcador, unidadeDeMedida, sexoBiologico);
        
        // Mapeando para uma lista de ValorDTO
        List<ProprioValorDTO> ProprioValorDTOs = valores.stream()
                                          .map(v -> new ProprioValorDTO(v.getProprioValor(), v.getEMaximo()))
                                          .collect(Collectors.toList());
        return ProprioValorDTOs;
    }



    
    public List<String> listarUnidadesDeMedidaPorMarcador(Long idMarcador) {
        if (idMarcador == null) {
            throw new ResponseStatusException(HttpStatus.BAD_REQUEST, "ID do marcador é obrigatório.");
        }

        return valorDao.consultarUnidadesDeMedidaPorMarcador(idMarcador);
    }


}
