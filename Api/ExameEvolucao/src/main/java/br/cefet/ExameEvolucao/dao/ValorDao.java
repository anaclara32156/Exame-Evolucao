package br.cefet.ExameEvolucao.dao;

import java.util.List;

import org.jdbi.v3.sqlobject.config.RegisterBeanMapper;
import org.jdbi.v3.sqlobject.customizer.Bind;
import org.jdbi.v3.sqlobject.customizer.BindBean;
import org.jdbi.v3.sqlobject.statement.GetGeneratedKeys;
import org.jdbi.v3.sqlobject.statement.SqlQuery;
import org.jdbi.v3.sqlobject.statement.SqlUpdate;

import br.cefet.ExameEvolucao.model.Valor;


@RegisterBeanMapper(Valor.class)
public interface ValorDao {
	@GetGeneratedKeys
	@SqlUpdate("INSERT INTO valor (idTipoDeValor, idMarcador, eMaximo, proprioValor, idadeInferior, idadeSuperior, sexoBiologico, unidadeDeMedida) "
	         + "VALUES (:idTipoDeValor, :idMarcador, :eMaximo, :proprioValor, :idadeInferior, :idadeSuperior, :sexoBiologico, :unidadeDeMedida);")
	public Long inserir(@Bind("idTipoDeValor") Long idTipoDeValor,
	             @Bind("idMarcador") Long idMarcador,
	             @Bind("eMaximo") String eMaximo,
	             @Bind("proprioValor") String proprioValor,
	             @Bind("idadeInferior") String idadeInferior,
	             @Bind("idadeSuperior") String idadeSuperior,
	             @Bind("sexoBiologico") String sexoBiologico,
	             @Bind("unidadeDeMedida") String unidadeDeMedida);
	
	@SqlQuery("""
		    SELECT * FROM valor 
		    WHERE idMarcador = (
		        SELECT id FROM marcador WHERE nomeMarcador = :nomeMarcador AND grupo = :grupo AND (idUsuario = :idUsuario OR idUsuario = 1)
		    )
		    AND idTipoDeValor = :idTipoDeValor
		    AND proprioValor = :proprioValor
		    AND eMaximo = :eMaximo
		    AND sexoBiologico = :sexoBiologico
		    AND idadeInferior = :idadeInferior
		    AND idadeSuperior = :idadeSuperior
		    AND unidadeDeMedida = :unidadeDeMedida
		""")
		List<Valor> verificarExistente(
		    @Bind("nomeMarcador") String nomeMarcador,
		    @Bind("grupo") String grupo,
		    @Bind("idTipoDeValor") Long idTipoDeValor,
		    @Bind("proprioValor") String proprioValor,
		    @Bind("eMaximo") String eMaximo,
		    @Bind("sexoBiologico") String sexoBiologico,
		    @Bind("idadeInferior") String idadeInferior,
		    @Bind("idadeSuperior") String idadeSuperior,
		    @Bind("unidadeDeMedida") String unidadeDeMedida,
		    @Bind("idUsuario") Long idUsuario
		);



	@SqlQuery(" select * from valor;")
	public List<Valor> consultar();
	
	@SqlQuery(" select * from valor "
			+ " where idValor = :idValor;")
	public Valor consultarPorId(@Bind Long idValor);
	
	@SqlQuery("SELECT proprioValor, eMaximo " +
	          "FROM valor " +
	          "WHERE idMarcador = :idMarcador " +
	          "AND unidadeDeMedida = :unidadeDeMedida " +
	          "AND (sexoBiologico = :sexoBiologico OR sexoBiologico = 'U')")
	List<Valor> consultarPorMarcadorUnidadeDeMedidaESexo(@Bind("idMarcador") Long idMarcador,
	                                                   @Bind("unidadeDeMedida") String unidadeDeMedida,
	                                                   @Bind("sexoBiologico") String sexoBiologico);


	
	@SqlQuery("SELECT DISTINCT unidadeDeMedida " +
	          "FROM valor " +
	          "WHERE idMarcador = :idMarcador")
	List<String> consultarUnidadesDeMedidaPorMarcador(@Bind("idMarcador") Long idMarcador);

}
