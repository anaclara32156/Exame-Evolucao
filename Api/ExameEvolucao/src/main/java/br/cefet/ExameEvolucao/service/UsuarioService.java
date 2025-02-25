package br.cefet.ExameEvolucao.service;

import java.util.List;

import org.jdbi.v3.core.Jdbi;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.server.ResponseStatusException;

import br.cefet.ExameEvolucao.dao.UsuarioDao;
import br.cefet.ExameEvolucao.model.Usuario;

@Service
public class UsuarioService {
	private final UsuarioDao usuarioDao;
	
	public UsuarioService(Jdbi jdbi) {
        this.usuarioDao = jdbi.onDemand(UsuarioDao.class);
    }
	
	public Usuario inserir(Usuario u) {
        if (u.getId() != null) {
            throw new ResponseStatusException(HttpStatus.NOT_ACCEPTABLE, "Id - informacao ilegal.");
        }

        Long id = usuarioDao.inserir(u);
        u.setId(id);
        return u;
    }

    public List<Usuario> consultar() {
        return usuarioDao.consultar();
    }

    public Usuario consultarPorId(Long id) {
        return usuarioDao.consultarPorId(id);
    }
    
    public Usuario alterar(Usuario u) {
        //Validacoes extras das informacoes
        Long id = u.getId();
        if (id == null) {
            throw new ResponseStatusException(HttpStatus.PRECONDITION_FAILED, "Id eh informacao obrigatoria.");
        }
        
        Usuario uAux = usuarioDao.consultarPorId(id);
        if (uAux == null){
            throw new ResponseStatusException(HttpStatus.NOT_FOUND, "Usuario nao encontrado com o id: " +id+ ".");
        }
        
        //Alteracao da entidade
        int qtd = usuarioDao.alterar(u);
        
        //Validar se a entidade foi alterada corretamente.
        if (qtd != 1){
            throw new ResponseStatusException(HttpStatus.CONFLICT, "A quantidade de entidades alteradas eh " +qtd+ ".");
        }
        
        //Retornar a informacao alterada no banco de dados.
        uAux = usuarioDao.consultarPorId(id);
        return uAux;
    }

    public Usuario excluir(Long id) {
        //Validacoes extras das informacoes
        Usuario uAux = usuarioDao.consultarPorId(id);
        if (uAux == null){
            throw new ResponseStatusException(HttpStatus.NOT_FOUND, "Usuario nao encontrado com o id: " +id+ ".");
        }
        
        //Alteracao da entidade
        int qtd = usuarioDao.excluir(id);
        
        //Validar se a entidade foi alterada corretamente.
        if (qtd != 1){
            throw new ResponseStatusException(HttpStatus.CONFLICT, "A quantidade de entidades alteradas eh " +qtd+ ".");
        }
        
        return uAux;
    }
}
