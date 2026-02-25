CREATE DATABASE SiteRPG;
USE SiteRPG;

CREATE TABLE senhas (
	id INT auto_increment PRIMARY KEY,
    senha VARCHAR(25) NOT NULL
);

CREATE TABLE usuarios (
	id INT auto_increment PRIMARY KEY,
    nome VARCHAR(25) unique not null,
    id_senha INT,
    foreign key (id_senha) references senhas(id)
);

CREATE TABLE classes (
	id INT auto_increment PRIMARY KEY,
    classe varchar(15) not null
	);
    
CREATE TABLE energias (
	id INT auto_increment PRIMARY KEY,
    nome VARCHAR(25) NOT NULL
);

CREATE TABLE raridades (
	id INT auto_increment PRIMARY KEY,
    raridade varchar(15) not null
);

CREATE TABLE titulos (
	id INT auto_increment PRIMARY KEY,
    titulo varchar(25) not null
);

CREATE TABLE encantamentos (
	id INT auto_increment PRIMARY KEY,
    encantamento varchar(25) not null,
    descricao text
    );

CREATE TABLE itens (
	id INT auto_increment PRIMARY KEY,
	item varchar(30) not null,
    id_raridade INT,
    descricao text,
    foreign key (id_raridade) references raridades(id)
    );

CREATE TABLE estilos_luta (
	id INT auto_increment PRIMARY KEY,
	nome VARCHAR(30) NOT NULL,
	descricao text
);

-- players
CREATE TABLE fichas (
	id INT auto_increment PRIMARY KEY,
    nome VARCHAR(30) not null,
    id_classe INT,
    foreign key (id_classe) references classes(id),
    efeitos VARCHAR(50),
    dinheiro INT not null,
    level INT not null,
    forca INT not null,
    velocidade INT not null,
    agilidade INT not null,
    durabilidade INT not null,
    combate INT not null,
    ea INT not null,
    stamina INT not null,
    iq INT not null,
    aura INT not null,
	sanidade INT not null,
    sanidadeMax INT not null,
	stress INT not null,
    traumas INT not null,
    rm INT not null
    
);

-- varias pessoas podem ter varios titulos
CREATE TABLE R_player_titulo (
	id INT auto_increment PRIMARY KEY,
	id_player INT not null,
    foreign key (id_player) references fichas(id),
    id_titulo INT not null,
    foreign key (id_titulo) references titulos(id)
);

-- varias pessoas podem ter varios items
CREATE TABLE R_player_item (
	id INT auto_increment PRIMARY KEY,
	id_player INT not null,
    foreign key (id_player) references fichas(id),
    id_item INT not null,
    foreign key (id_item) references itens(id)
    
);

-- varios itens de varias pessoas podem ter varios encantamentos
CREATE TABLE R_item_player_encantamento (
	id INT auto_increment PRIMARY KEY,
    id_item_player INT,
    foreign key (id_item_player) references R_player_item(id),
    id_encantamentos INT,
    foreign key (id_encantamentos) references encantamentos(id)
    );

-- varias pessoas podem ter varios encantamentos
CREATE TABLE R_player_encantamento (
	id INT auto_increment PRIMARY KEY,
    id_player INT,
	foreign key (id_player) references fichas(id),
	id_encantamentos INT,
    foreign key (id_encantamentos) references encantamentos(id)
    );
    
-- varias pessoas podem ter varios estilos de luta
CREATE TABLE R_player_estiloluta (
	id INT auto_increment PRIMARY KEY,
    id_player INT,
	foreign key (id_player) references fichas(id),
	id_estiloluta INT,
    foreign key (id_estiloluta) references estilos_luta(id)
    );
    
-- sistema dos poderes
    
CREATE TABLE talentos (
	id INT auto_increment PRIMARY KEY,
	id_player INT,
	foreign key (id_player) references fichas(id),
	nome VARCHAR(25) NOT NULL,
	descricao text
    );

CREATE TABLE tecnicas (
	id INT auto_increment PRIMARY KEY,
	id_player INT,
	foreign key (id_player) references fichas(id),
    nome VARCHAR(15) NOT NULL
    );


CREATE TABLE jutsus (
	id INT auto_increment PRIMARY KEY,
    id_tecnica INT,
	foreign key (id_tecnica) references tecnicas(id),
	nome VARCHAR(25) NOT NULL,
    custo INT,
    id_energia_custo INT,
    foreign key (id_energia_custo) references energias(id),
	descricao text
);

CREATE TABLE habilidades_classe (
	id INT auto_increment PRIMARY KEY,
	id_classe INT,
    foreign key (id_classe) references classes(id),
	nome VARCHAR(25) NOT NULL,
    custo INT,
    id_energia_custo INT,
    foreign key (id_energia_custo) references energias(id),
	descricao text
);

CREATE TABLE R_player_habilidade_classe (
	id INT auto_increment PRIMARY KEY,
	id_player INT,
	foreign key (id_player) references fichas(id),
    id_habiliade_classe INT,
	foreign key (id_habilidade_classe) references habilidades__classe(id),
    level INT
);


    
    
    
    
    
    
    
    
