USE SiteRPG;

CREATE TABLE invocacao_base (
	id INT auto_increment PRIMARY KEY,
    nome VARCHAR(30) not null,
    id_classe INT,
    foreign key (id_classe) references classes(id),
    efeitos VARCHAR(50)
);


CREATE TABLE invocacao_status (
    id INT auto_increment PRIMARY KEY,
    id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
    level INT not null,
    hp INT not null,
    forca INT not null,
    velocidade INT not null,
    agilidade INT not null,
    durabilidade INT not null,
    combate INT not null,
    experiencia INT not null
);

CREATE TABLE invocacao_energias (
    id INT auto_increment PRIMARY KEY,
    id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
    iq INT not null,
    stamina INT not null,
    energia INT not null,
    aura INT not null
);

CREATE TABLE invocacao_mente (
    id INT auto_increment PRIMARY KEY,
    id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
    sanidade INT not null,
    sanidadeMax INT not null,
	stress INT not null,
    traumas INT not null,
    rm INT not null
);





CREATE TABLE R_invocacao_estiloluta (
	id INT auto_increment PRIMARY KEY,
    id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
	id_estiloluta INT,
    foreign key (id_estiloluta) references estilos_luta(id)
    );
    


CREATE TABLE R_invocacao_encantamento (
	id INT auto_increment PRIMARY KEY,
    id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
	id_encantamentos INT,
    foreign key (id_encantamentos) references encantamentos(id)
    );

CREATE TABLE invocacao_talentos (
	id INT auto_increment PRIMARY KEY,
	id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
	nome VARCHAR(25) NOT NULL,
	descricao text
    );

CREATE TABLE invocacao_tecnicas (
	id INT auto_increment PRIMARY KEY,
	id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
    nome VARCHAR(15) NOT NULL,
    descricao text
    );


CREATE TABLE invocacao_jutsus (
	id INT auto_increment PRIMARY KEY,
    id_tecnica INT,
	foreign key (id_tecnica) references invocacao_tecnicas(id),
	nome VARCHAR(25) NOT NULL,
    custo INT,
    id_energia_custo INT,
    foreign key (id_energia_custo) references energias(id),
	descricao text
);

CREATE TABLE R_invocacao_habilidades_basicas (
    id INT auto_increment PRIMARY KEY,
	id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
    id_habilidade_basica INT,
	foreign key (id_habilidade_basica) references habilidades_basicas(id),
    level INT
);

CREATE TABLE R_invocacao_habilidade_classe (
	id INT auto_increment PRIMARY KEY,
	id_invocacao INT,
    foreign key (id_invocacao) references invocacao_base(id),
    id_habilidade_classe INT,
	foreign key (id_habilidade_classe) references habilidades_classe(id),
    level INT
);