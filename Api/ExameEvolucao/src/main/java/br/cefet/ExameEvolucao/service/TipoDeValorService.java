package br.cefet.ExameEvolucao.service;

import java.util.List;

import org.jdbi.v3.core.Jdbi;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.server.ResponseStatusException;

import br.cefet.ExameEvolucao.dao.TipoDeValorDao;
import br.cefet.ExameEvolucao.model.TipoDeValor;

@Service
public class TipoDeValorService {
	private final TipoDeValorDao tipoDeValorDao;

    public TipoDeValorService(Jdbi jdbi) {
        this.tipoDeValorDao = jdbi.onDemand(TipoDeValorDao.class);
    }

    public TipoDeValor inserir(TipoDeValor tv) {
        if (tv.getIdTipoDeValor() != null) {
            throw new ResponseStatusException(HttpStatus.NOT_ACCEPTABLE, "Id - informacao ilegal.");
        }

        Long idTipoDeValor = tipoDeValorDao.inserir(tv);
        tv.setIdTipoDeValor(idTipoDeValor);
        return tv;
    }

    public List<TipoDeValor> consultar() {
    	 return tipoDeValorDao.consultar();
    }

    public TipoDeValor consultarPorId(Long idTipoDeValor) {
        return tipoDeValorDao.consultarPorId(idTipoDeValor);
    }
}
