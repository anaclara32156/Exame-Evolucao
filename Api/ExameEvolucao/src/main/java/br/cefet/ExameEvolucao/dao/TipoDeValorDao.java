package br.cefet.ExameEvolucao.dao;

import java.util.List;

import org.jdbi.v3.sqlobject.config.RegisterBeanMapper;
import org.jdbi.v3.sqlobject.customizer.Bind;
import org.jdbi.v3.sqlobject.customizer.BindBean;
import org.jdbi.v3.sqlobject.statement.GetGeneratedKeys;
import org.jdbi.v3.sqlobject.statement.SqlQuery;
import org.jdbi.v3.sqlobject.statement.SqlUpdate;

import br.cefet.ExameEvolucao.model.TipoDeValor;

@RegisterBeanMapper(TipoDeValor.class)
public interface TipoDeValorDao {
	@GetGeneratedKeys
	@SqlUpdate(" insert into tipoDeValor (nomeTipoDeValor) "
			+ " values (:nomeTipoDeValor);")
	public Long inserir(@BindBean TipoDeValor tv);

	@SqlQuery(" select * from tipoDeValor;")
	public List<TipoDeValor> consultar();
	
	@SqlQuery(" select * from tipoDeValor "
			+ " where idTipoDeValor = :idTipoDeValor;")
	public TipoDeValor consultarPorId(@Bind Long idTipoDeValor);
	
}
