package br.cefet.ExameEvolucao.dao;

import java.util.List;

import org.jdbi.v3.sqlobject.config.RegisterBeanMapper;
import org.jdbi.v3.sqlobject.customizer.Bind;
import org.jdbi.v3.sqlobject.customizer.BindBean;
import org.jdbi.v3.sqlobject.statement.GetGeneratedKeys;
import org.jdbi.v3.sqlobject.statement.SqlQuery;
import org.jdbi.v3.sqlobject.statement.SqlUpdate;
import org.springframework.web.bind.annotation.BindParam;

import br.cefet.ExameEvolucao.model.Marcador;

@RegisterBeanMapper(Marcador.class)
public interface MarcadorDao {
	@GetGeneratedKeys
	@SqlUpdate(" insert into marcador (nomeMarcador, grupo, idUsuario) "
			+ " values (:nomeMarcador, :grupo, :idUsuario);")
	public Long inserir(@BindBean Marcador m);


	@SqlQuery(" select * from marcador;")
	public List<Marcador> consultar();
	
	@SqlQuery(" select * from marcador "
			+ " where id = :id;")
	public Marcador consultarPorId(@Bind Long id);
	
	@SqlQuery("""
		    SELECT * FROM marcador 
		    WHERE (idUsuario = :idUsuario OR idUsuario = 1)
		    AND grupo = :grupo
		    ORDER BY nomeMarcador ASC
		""")
		List<Marcador> consultarPorUsuarioEGrupo(@Bind("idUsuario") Long idUsuario, @Bind("grupo") String grupo);


	
	 @SqlQuery("""
		        SELECT m.*, v.* FROM marcador m
		        JOIN valor v ON m.id = v.idMarcador
		        JOIN resultadoexame re ON v.idMarcador = re.idMarcador
		        JOIN cliente c ON re.idCliente = c.id
		        WHERE c.idUsuario = :idUsuario
		    """)
	    List<Marcador> consultarPorUsuario(@BindParam("idUsuario") Long idUsuario);
	
	 @SqlQuery("""
			    SELECT * FROM marcador 
			    WHERE nomeMarcador = :nomeMarcador AND grupo = :grupo
			    LIMIT 1
			""")
			Marcador consultarPorNomeEGrupo(@Bind("nomeMarcador") String nomeMarcador, @Bind("grupo") String grupo);

	 
	@SqlUpdate(" update marcador "
	         + "  set nomeMarcador = :nomeMarcador, "
	         + "  grupo = :grupo "
	         + " where id = :id;")
	public int alterar(@BindBean Marcador m);
	
	@SqlUpdate(" delete from marcador "
			+ " where id = :id;")
	public int excluir(@Bind Long id);
}
