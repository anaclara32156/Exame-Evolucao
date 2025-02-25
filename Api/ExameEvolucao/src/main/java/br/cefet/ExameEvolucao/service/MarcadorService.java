package br.cefet.ExameEvolucao.service;

import java.sql.Date;
import java.util.List;

import org.jdbi.v3.core.Jdbi;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.server.ResponseStatusException;

import br.cefet.ExameEvolucao.dao.MarcadorDao;
import br.cefet.ExameEvolucao.dao.ValorDao;
import br.cefet.ExameEvolucao.model.Marcador;
import br.cefet.ExameEvolucao.model.ValorDTO;
import br.cefet.ExameEvolucao.model.Valor;

@Service
public class MarcadorService {
    private final MarcadorDao marcadorDao;
    private final ValorDao valorDao;


    public MarcadorService(Jdbi jdbi) {
        this.marcadorDao = jdbi.onDemand(MarcadorDao.class);
        this.valorDao = jdbi.onDemand(ValorDao.class);
    }

    public Marcador inserir(ValorDTO dto) {
        // Verificar se já existe um marcador com o mesmo nome e grupo
        Marcador marcadorExistente = marcadorDao.consultarPorNomeEGrupo(dto.getNomeMarcador(), dto.getGrupo());

        Long idMarcador;
        Marcador marcador;

        if (marcadorExistente != null) {
            idMarcador = marcadorExistente.getId();
            marcador = marcadorExistente; // Reutiliza o marcador existente
            System.out.println("⚠️ Marcador já existente! ID reutilizado: " + idMarcador);
        } else {
            // Criar novo marcador se não existir
            marcador = new Marcador(null, dto.getIdUsuario(), dto.getNomeMarcador(), dto.getGrupo());
            idMarcador = marcadorDao.inserir(marcador);
            System.out.println("✅ Novo marcador criado! ID: " + idMarcador);
        }

        // Criar objeto Valor com o ID do marcador existente ou recém-criado
        Valor valor = new Valor(
            null, 
            dto.getIdTipoDeValor(), 
            idMarcador, 
            dto.getEMaximo(), 
            dto.getProprioValor(), 
            dto.getIdadeInferior(), 
            dto.getIdadeSuperior(), 
            dto.getSexoBiologico(), 
            dto.getUnidadeDeMedida()
        );

        System.out.println("📝 Valor a ser inserido no banco: " + valor);

        // Inserir o valor associado ao marcador correto
        valorDao.inserir(
            valor.getIdTipoDeValor(),
            valor.getIdMarcador(),
            valor.getEMaximo(),
            valor.getProprioValor(),
            valor.getIdadeInferior(),
            valor.getIdadeSuperior(),
            valor.getSexoBiologico(),
            valor.getUnidadeDeMedida()
        );

        return marcador;
    }


    public String verificarExistente(ValorDTO dto) {
        List<Valor> valoresExistentes = valorDao.verificarExistente(
                dto.getNomeMarcador(),
                dto.getGrupo(),
                dto.getIdTipoDeValor(),
                dto.getProprioValor(),
                dto.getEMaximo(),
                dto.getSexoBiologico(),
                dto.getIdadeInferior(),
                dto.getIdadeSuperior(),
                dto.getUnidadeDeMedida(),
                dto.getIdUsuario()
        );

        if (valoresExistentes.isEmpty()) {
            return "Valor não existente.";
        } else {
            return "Valor já existente.";
        }
    }


    public List<Marcador> consultar() {
        return marcadorDao.consultar();
    }
    
    public Marcador consultarPorId(Long id) {
        return marcadorDao.consultarPorId(id);
    }
    
    public List<Marcador> consultarPorUsuarioEGrupo(Long idUsuario, String grupo) {
        return marcadorDao.consultarPorUsuarioEGrupo(idUsuario, grupo);
    }

    public Marcador alterar(Marcador m) {
        Long id = m.getId();
        if (id == null) {
            throw new ResponseStatusException(HttpStatus.PRECONDITION_FAILED, "Id é informação obrigatória.");
        }

        Marcador mAux = marcadorDao.consultarPorId(id);
        if (mAux == null) {
            throw new ResponseStatusException(HttpStatus.NOT_FOUND, "Marcador não encontrado com o id: " + id + ".");
        }

        int qtd = marcadorDao.alterar(m);

        if (qtd != 1) {
            throw new ResponseStatusException(HttpStatus.CONFLICT, "A quantidade de entidades alteradas é " + qtd + ".");
        }

        return marcadorDao.consultarPorId(id);
    }

    public Marcador excluir(Long id) {
        Marcador mAux = marcadorDao.consultarPorId(id);
        if (mAux == null) {
            throw new ResponseStatusException(HttpStatus.NOT_FOUND, "Marcador não encontrado com o id: " + id + ".");
        }

        int qtd = marcadorDao.excluir(id);
        if (qtd != 1) {
            throw new ResponseStatusException(HttpStatus.CONFLICT, "A quantidade de entidades alteradas é " + qtd + ".");
        }

        return mAux;
    }
}
