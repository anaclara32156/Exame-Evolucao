package br.cefet.ExameEvolucao.dao;

import java.util.List;

import org.jdbi.v3.sqlobject.config.RegisterBeanMapper;
import org.jdbi.v3.sqlobject.customizer.Bind;
import org.jdbi.v3.sqlobject.customizer.BindBean;
import org.jdbi.v3.sqlobject.statement.GetGeneratedKeys;
import org.jdbi.v3.sqlobject.statement.SqlQuery;
import org.jdbi.v3.sqlobject.statement.SqlUpdate;

import br.cefet.ExameEvolucao.model.Exame;
import br.cefet.ExameEvolucao.model.MarcadorUnidadeDTO;

@RegisterBeanMapper(Exame.class)
public interface ExameDao {
	
	@GetGeneratedKeys
    @SqlUpdate("INSERT INTO resultadoExame (marcador, grupo, dataColeta, resultado, idCliente, idMarcador, medida) "
            + "VALUES (:marcador, :grupo, :dataColeta, :resultado, :idCliente, :idMarcador, :medida);")
	
    Long inserir(@BindBean Exame e);

    @SqlQuery("SELECT * FROM resultadoExame;")
    List<Exame> consultar();
    
    @SqlQuery("SELECT * FROM resultadoExame WHERE id = :id;")
    Exame consultarPorId(@Bind Long id);
    
    @SqlQuery("SELECT * FROM resultadoExame WHERE idCliente = :idCliente;")
    List<Exame> consultarPorCliente(@Bind("idCliente") Long idCliente);
    

    @RegisterBeanMapper(MarcadorUnidadeDTO.class)
    @SqlQuery("SELECT marcador, medida " +
              "FROM resultadoExame " +
              "WHERE idCliente = :idCliente " +
              "GROUP BY marcador, medida")
    List<MarcadorUnidadeDTO> consultarMarcadoresUnicosComUnidade(@Bind("idCliente") Long idCliente);


    @SqlQuery("SELECT * FROM resultadoExame WHERE marcador = :marcador AND idCliente = :idCliente AND medida = :medida;")
    List<Exame> consultarPorMarcadorEMedida(@Bind("marcador") String marcador, @Bind("idCliente") Long idCliente, @Bind("medida") String medida);

    
//    @SqlQuery("SELECT * FROM cliente WHERE idUsuario = :idUsuario;")
//    List<Cliente> consultarPorUsuario(@Bind("idUsuario") Long idUsuario);

    @SqlUpdate("UPDATE resultadoExame SET marcador = :marcador, grupo = :grupo, dataColeta = :dataColeta, "
            + "resultado = :resultado, idCliente = :idCliente, idMarcador = :idMarcador, medida = :medida "
            + "WHERE id = :id;")
    int alterar(@BindBean Exame e);
    
    @SqlUpdate("DELETE FROM resultadoExame WHERE id = :id;")
    int excluir(@Bind Long id);
}
