package br.cefet.ExameEvolucao.dao;

import java.util.List;

import org.jdbi.v3.sqlobject.config.RegisterBeanMapper;
import org.jdbi.v3.sqlobject.customizer.Bind;
import org.jdbi.v3.sqlobject.customizer.BindBean;
import org.jdbi.v3.sqlobject.statement.GetGeneratedKeys;
import org.jdbi.v3.sqlobject.statement.SqlQuery;
import org.jdbi.v3.sqlobject.statement.SqlUpdate;

import br.cefet.ExameEvolucao.model.Cliente;

@RegisterBeanMapper(Cliente.class)
public interface ClienteDao {
    
    @GetGeneratedKeys
    @SqlUpdate("INSERT INTO cliente (nome, cpf, email, dataNascimento, sexo, tel, idUsuario) "
            + "VALUES (:nome, :cpf, :email, :dataNascimento, :sexo, :tel, :idUsuario);")
    Long inserir(@BindBean Cliente c);

    @SqlQuery("SELECT * FROM cliente;")
    List<Cliente> consultar();
    
    @SqlQuery("SELECT * FROM cliente WHERE id = :id;")
    Cliente consultarPorId(@Bind Long id);
    
    @SqlQuery("SELECT * FROM cliente WHERE idUsuario = :idUsuario;")
    List<Cliente> consultarPorUsuario(@Bind("idUsuario") Long idUsuario);

    @SqlUpdate("UPDATE cliente SET nome = :nome, cpf = :cpf, email = :email, "
            + "dataNascimento = :dataNascimento, sexo = :sexo, tel = :tel, idUsuario = :idUsuario "
            + "WHERE id = :id;")
    int alterar(@BindBean Cliente c);
    
    @SqlUpdate("DELETE FROM cliente WHERE id = :id;")
    int excluir(@Bind Long id);
}
