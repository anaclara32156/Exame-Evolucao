package br.cefet.ExameEvolucao.dao;

import java.util.List;

import org.jdbi.v3.sqlobject.config.RegisterBeanMapper;
import org.jdbi.v3.sqlobject.customizer.Bind;
import org.jdbi.v3.sqlobject.customizer.BindBean;
import org.jdbi.v3.sqlobject.statement.GetGeneratedKeys;
import org.jdbi.v3.sqlobject.statement.SqlQuery;
import org.jdbi.v3.sqlobject.statement.SqlUpdate;

import br.cefet.ExameEvolucao.model.Usuario;


@RegisterBeanMapper(Usuario.class)
public interface UsuarioDao {
	
	@GetGeneratedKeys
	@SqlUpdate(" insert into usuario (nome, cpf, email, senha) "
			+ " values (:nome, :cpf, :email, :senha);")
	public Long inserir(@BindBean Usuario u);

	@SqlQuery(" select * from usuario;")
	public List<Usuario> consultar();
	
	@SqlQuery(" select * from usuario "
			+ " where id = :id;")
	public Usuario consultarPorId(@Bind Long id);
	
	@SqlUpdate(" update usuario "
	         + "  set nome = :nome, "
	         + "  cpf = :cpf, "
	         + "  email = :email, "
	         + "  senha = :senha "
	         + " where id = :id;")
	public int alterar(@BindBean Usuario u);
	
	@SqlUpdate(" delete from usuario "
			+ " where id = :id;")
	public int excluir(@Bind Long id);
}
