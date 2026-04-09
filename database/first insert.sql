USE SiteRPG;

INSERT INTO classes (classe)
VALUES 
('Guerreiro'),
('Paladino'),
('Sniper'),
("Invocador"),
('Bardo'),
('Mago'),
('Tank'),
('Healer'),
('Assasino'),
('Ladino'),
('Monge'),
('Barbaro'),
('Clerigo'),
('Destruidor'),
('Anti-Tank');

INSERT INTO energias (nome)
VALUES 
('Prana'),
("Energia Amaldicoada"),
('Aura');

INSERT INTO raridades (raridade)
VALUES 
('Comum'),
('Incomun'),
('Raro'),
('Epico'),
('Mitico'),
('Lendario');

INSERT INTO titulos (titulo)
VALUES 
('Graduado'),
('Ganancioso'),
('Pecado do Orgulho'),
('Mestre da Careta'),
('O Sortudo'),
('O Teimoso'),
('Pé de Pano'),
('Boca Suja'),
('Cara de Pedra'),
('Mão Rápida'),
('Sangue Frio'),
('Língua Solta'),
('Boa Praça'),
('Zé Ninguém'),
('O Persistente'),
('Casca Grossa'),
('O Sobrevivente'),
('Cabeça Dura'),
('O Silencioso'),
('O Barulhento'),
('Pé Ligeiro'),
('O Desconfiado'),
('O Brigão'),
('O Medroso'),
('O Calmo'),
('O Ambicioso'),
('O Observador'),
('O Falastrão'),
('O Leal'),
('O Traíra'),
('O Improvisador'),
('O Determinado'),
('O Insolente'),
('O Justo'),
('O Indomável'),
('O Cansado'),
('O Sonhador'),
('O Problema');

INSERT INTO encantamentos (encantamento, descricao)
VALUES 
('Sussurro de Aço', 'Faz a arma cortar como se visse fraqueza: +1 de perfuração por ataque; ao ativar, 1 acerto crítico adicional se rolar 18+. Aplicável em armas; recarga 3 turnos; arma perde 1 ponto de durabilidade por uso.'),
('Manto da Névoa', 'Cria uma névoa parcial ao redor do usuário, dando +2 em esquiva por 2 turnos. Somente vestimentas/acessórios; dura X rodadas = resultado do dado/2; inimigos com visão mágica ignoram.'),
('Eco de Ferro', 'Ao bloquear, converte 25% do dano bloqueado em um pulso que atordoa o atacante por 1 turno. Escudos e armaduras; chance de atordoamento 50%; recarga 2 turnos.'),
('Fome de Lâminas', 'Adiciona acúmulo: cada acerto aumenta dano futuro em 5%, acumulando até 5 vezes. Aplicável em armas; stacks resetam se ficar 3 turnos sem atacar.'),
('Seda Silenciosa', 'Reduz som de passos; movimentos furtivos têm vantagem automática em testes simples. Vestimentas/acessórios; não funciona se correr.'),
('Ressonância Lunar', 'Ataques noturnos ganham dano adicional de energia lunar; durante o dia é neutro. Armas e amuletos; funciona entre pôr e nascer do sol.'),
('Casulo de Cobre', 'Transforma temporariamente o equipamento em liga resistente (+10% resistência física) e emite leve brilho que interfere em furtividade. Vestimentas; 1 uso por combate.'),
('Sangue do Homúnculo', 'Gera um pequeno autômato que absorve um ataque inimigo por combate. Acessórios; autômato desaparece após receber dano.'),
('Fio do Engodo', 'Envia uma ilusão do portador 5 metros à frente por 1 turno, atraindo ataques. Armas ou vestes; recarga 4 turnos.'),
('Pó de Restauração', 'Cura 10% do HP máximo do usuário em 1 turno, mas causa 2 turnos de lentidão. Acessórios/vestimentas; uso único por descanso.'),
('Chave do Vento', 'Permite abrir cadeados mágicos simples e cria corrente curta para puxar objetos leves. Amuleto; falha contra resistência mágica alta.'),
('Vínculo de Sombras', 'Vincula-se a uma criatura inimiga por 3 turnos; 30% do dano recebido por ela é transferido ao usuário. Exige teste de controle; falha pode reverter o efeito.'),
('Lâmina Retórica', 'Provocações reduzem moral inimiga, aplicando -1 em ataques por 2 turnos. Não funciona em bestas.'),
('Fagulha de Origem', 'Ao eliminar um inimigo, gera chama que cura 2% do HP por 3 turnos. Não funciona em chefes.'),
('Relógio da Volta', 'Permite voltar 2 turnos no estado do usuário uma vez por combate, mas imobiliza o item por 1 turno após uso.'),
('Semente de Pedra', 'Cria barreira de pedra que bloqueia projéteis por 1 ataque. 2 usos por descanso.'),
('Olho do Errante', 'Concede visão de pontos cegos por 3 turnos e detecta armadilhas em área curta. Não revela ilusões superiores.'),
('Vento Cortante', 'Projéteis disparam lâminas de ar adicionais com chance de sangramento leve (1d4 por turno por 2 turnos).'),
('Cordão do Peregrino', 'Reduz custo de fadiga ao viajar e marca um ponto de teleporte único dentro de 500m. Teleporte único por descanso longo.'),
('Rede de Níquel', 'Projeta rede que reduz velocidade inimiga pela metade por 2 turnos. Não afeta inimigos gigantes.'),
('Sombras Fugitivas', 'Ao receber golpe fatal, há 30% de chance de se tornar intangível por 1 turno em vez de morrer.'),
('Coroa de Cinzas', 'Aliados próximos ganham +1 moral; usuário recebe 5% a mais de dano enquanto ativo.'),
('Chamariz de Ouro', 'Converte loot de inimigos em moedas com 25% de redução no valor real.'),
('Espectro de Chamas', 'Permite envolver a arma em chamas, transformando ataques físicos em ataques de fogo, tambem permite utilizar poderes de fogo.'),
('Excamur', 'Transforma item de ataque em escudo de escamas temporário; após alguns ataques a arma retorna ao normal.'),
('Golden', 'Concede magia de cura e transforma vestimentas em liga metálica de bronze.'),
('Traidor', 'Permite roubar HP de aliados ou animais de estimação quando aplicado em arma ou vestimenta.'),
('Tramontina', 'Permite romper defesas com um ataque perfurante quando usado em arma corpo a corpo.'),
('Electrolux', 'Permite ataque perfurante elétrico mesmo se o inimigo defender o golpe.'),
('Cherin de Café Cuado', 'Emite feromônio de cafeína que aumenta atenção e agilidade; após efeito causa penalidade física temporária.'),
('Enigma', 'Permite ficar invisível ou parcialmente transparente; percepção depende de teste de dado.'),
('Mozart', 'Quando a vida está baixa, libera grito sônico que afasta inimigos ao redor.'),
('Brilho Crescente', 'Inicialmente vulnerável a certos ataques, adapta-se após ser atingido algumas vezes tornando-se resistente ou invulnerável.'),
('Cifrão', 'Transforma um item inútil em arma poderosa uma única vez; pode ser usado em qualquer item.'),
('Poseidon', 'Torna vestimentas impermeáveis, protege contra ataques de água e permite respirar debaixo d''água.'),
('Glitch', 'Pode tornar ataques impossíveis de desviar se rolar acima de 18 no dado.'),
('Pacto', 'Transforma arma em demônio aliado temporário; ao fim do efeito remove metade do HP do usuário.'),
('Metamorfose', 'Transforma item em inseto ou enxame controlável por tempo determinado pelo dado; desaparece se trocar de arma.'),
('Âncora', 'Permite marcar localizações e retornar se estiver com pouca vida dentro de 1km; item deve ser deixado no local.'),
('Pulso de Obsidiana', 'Ataques perfurantes ignoram 10% da armadura do alvo; item aquece e prejudica desempenho em ambientes frios.'),
('Luz do Guia', 'Torna o usuário imune à perda de direção e concede bônus em navegação.'),
('Marca do Forasteiro', 'Permite atravessar fronteiras de facções menores sem confronto automático, mas marca o usuário para espiões.'),
('Sopro do Titã', 'Empurrão poderoso em área frontal que derruba inimigos se falharem teste de força; recarga 4 turnos.'),
('Fagulha da Memória', 'Grava último diálogo ou ação e reproduz uma vez para auxiliar em enigmas.'),
('Pele de Vidro', 'Converte parte do dano mágico recebido em proteção física temporária; causa tontura após uso.'),
('Rastro de Cinza', 'Ao fugir, deixa rastro ilusório que confunde perseguidores por 2 turnos; não funciona em terreno aberto sem cobertura.'),
('Infinidade', 'Permite que o item utilize munição sem consumi-la. Desde que o portador possua ao menos uma unidade de munição.'),
('Raios', 'Concede dano elétrico adicional e pequena chance de paralisar o alvo por 1 turno. Ataques podem saltar para um inimigo próximo.'),
('Água', 'Imbuí o item com a fluidez da água, permitindo que seus ataques se moldem e atinjam com força líquida e adaptável.'),
('Vento', 'Infunde o item com a leveza e velocidade do vento, tornando seus golpes mais rápidos e difíceis de conter.');

INSERT INTO itens (item, id_raridade, descricao) 
VALUES
-- Comuns (sem descrição)
('Espada', 1, ''),
('Lança', 1, ''),
('Porrete de madeira', 1, ''),
('Arco', 1, ''),
('Escudo', 1, ''),
('Cajado de metal', 1, ''),
('Chicote com ponteira', 1, ''),
('Estrelas ninja', 1, ''),
('Facas', 1, ''),
('Martelos de guerra', 1, ''),
('Estilingue', 1, ''),
('38', 1, ''),
('Pistolas', 1, ''),
('Revólveres', 1, ''),
('Metralhadoras', 1, ''),
('Espingardas', 1, ''),
('Rifles', 1, ''),
('Fuzis', 1, ''),
('Carabinas', 1, ''),
('Submetralhadoras', 1, ''),
('Lança-mísseis Javelin', 1, ''),
('S&W40', 1, ''),

-- Incomuns (sem descrição)
('Lança Machado', 2, ''),
('Luneta quebrada', 2, ''),
('Ponteiro de torre do relógio', 2, ''),
('Lança mísseis quebrado', 2, ''),
('Arma d''água cheia de gasolina', 2, ''),
('Jarra de suco', 2, ''),
('Porta de guarda roupa', 2, ''),
('Roda de carroça', 2, ''),
('Leque LGBT',2,'um leque de ferro com a bandeira lgbt'),
('Bazuca air frier', 2, 'Cria uma bolha de vapor comprimido que causa queimaduras.'),
('Turbina de avião', 2, 'Lança uma rajada de vento cortante após acelerar os motores.'),
('Catapulta astral', 2, 'Cria uma catapulta invisível capaz de arremessar objetos de peso limitado.'),
('Geladeira Eletrolux', 2, 'Causa ataque em área semelhante a chuva de granizo, podendo congelar o usuário se usada excessivamente.'),
('Motorola Moto E32', 2, 'Lança lasers quando balançado repetidamente, com risco de explosão.');

-- Raras
INSERT INTO itens (item, id_raridade, descricao) 
VALUES
('Escudo Devorar', 3, 'Pode engolir até 3 adversários por dia.'),
('Incensário', 3, 'Cria uma parede de fumaça tóxica que pode deixar inimigos atordoados.'),
('Crucifixo de Cabeça pra Baixo', 3, 'Aumenta a defesa do usuário em 20% contra membros da igreja ou santos e drena energia de ataques.'),
('Prancha de Surf', 3, 'Pode ser usada como arma e causa 30% de dano adicional se estiver molhada.'),
('Martelo Moedor', 3, 'Possui dois metros de altura e pesa quatro toneladas, mas torna-se leve para seu portador.'),
('Ioiô Fênix', 3, 'Possui corda de 10 metros e pode se transformar em bola de fogo que retorna ao usuário e pode ser usado para locomoção.'),
('Lança-chamas de Rexona', 3, 'Improviso que lança fogo contínuo.'),
('Shotgan 650', 3, 'Tiros têm alta chance de ricochetear e ganhar velocidade adicional.'),
('Livro escolar', 3, 'Lança efeito de preguiça que enfraquece os ataques do adversário.'),
('Flauta', 3, 'Projeta notas musicais físicas que atacam conforme ritmo e intensidade.'),
('Rifle de três cabeças', 3, 'Possui três canos e dispara três projéteis simultaneamente.'),
('Roleta russa Gyrojet', 3, 'Pode disparar um tiro extremamente mais forte de forma aleatória.'),
('Canhão de mão', 3, 'Arma de fogo primitiva baseada em tubo metálico com pólvora.'),

-- Épicas
('Espada de Duas Lâminas', 4, 'Pode cortar quase qualquer coisa se a defesa for inferior a 3. Quest: derrote um líder dragão e use suas presas como lâmina.'),
('Luva Cataclisma', 4, 'Dissolve objetos inanimados ao toque e pode causar dano grave ao inimigo. Quest: destrua o comandante do exército demônio e devore seu coração.'),
('Óculos de Medusa', 4, 'Transforma o oponente em pedra por uma rodada; se o usuário ver seu reflexo o efeito se volta contra ele. Quest: derrote uma medusa e use seus olhos como lente.'),
('Cetro Cristal', 4, 'Cria barreiras de energia que causam dano. Quest: ser treinado por um mago experiente.'),
('Besta de granadas', 4, 'Dispara duas granadas por vez que explodem ao contato.'),
('Caixinha JBL', 4, 'Emite ondas de choque capazes de causar abalos dependendo da música.'),
('Poltergeist', 4, 'Envolve o alvo em bolha de energia que o prende ou protege temporariamente.'),
('Lança rede elétrica', 4, 'Dispara uma rede energizada que imobiliza e eletrocuta o alvo.');

-- Mítico
INSERT INTO itens (item, id_raridade, descricao) 
VALUES
('Anel do Desbravador', 5, 'Permite usar uma habilidade do portador em nível máximo por um ataque.'),
('Berrante do General', 5, 'Pode reagrupar tropas e teleportar exércitos inteiros.'),
('Varinha da Fada Madrinha', 5, 'Cria uma única coisa imaginada que não tenha vida nem possa tirar vidas; dura até a meia-noite.'),
('Chernobyl', 5, 'Permite lançar esferas de radiação que causam queimaduras e envenenamento tóxico. Quest: derrotar o Leviatã do rio Tietê.'),
('Cajado merliniano', 5, 'Permite criar ataques mágicos em área e disparar chamas azuis à distância. Quest: derrotar um golem de cristal e usar seu coração como núcleo.'),

-- Lendária
('Relógio de Bolso', 6, 'Permite voltar até 3 rodadas no tempo; após o uso desaparece.'),
('Peças de Dominó', 6, 'Pedras rúnicas capazes de lançar magias da natureza em nível mítico aleatoriamente; desaparecem uma a uma após uso.'),
('Coroa do Rei do Mundo', 6, 'Permite controlar pessoas e usar suas habilidades contra sua vontade, além de criar um exército com acesso às habilidades do portador.');

INSERT INTO estilos_luta (nome, descricao) 
VALUES
('Sem estilo', 'Estilo instintivo que cumpre seu propósito sem buffs e debuffs.'),
('Zooraquitem', 'Permite que o usuário corra ou ataque imitando movimentos e instintos de animais.'),
('Pro Player', 'Permite realizar dois ataques em sequência e melhora a velocidade geral do usuário.'),
('Capoeira', 'Permite desviar de ataques por um período determinado.'),
('Ginga', 'Semelhante à Capoeira, mas permite acertar ataques com maior precisão por um período determinado.'),
('Tango', 'Permite dançar entre ataques físicos e mágicos, desviando ou alterando suas trajetórias.'),
('Huka-Huka', 'Luta tradicional que permite saltos mais altos e técnicas de imobilização.'),
('Luta Dançante', 'Permite lutar e se defender na intensidade e velocidade da música.'),
('Luta Livre', 'Cria a sensação de um ringue imaginário, permitindo movimentos criativos como saltos e impactos teatrais.'),
('LGBTQIAPN+', 'Permite seduzir o oponente independentemente do gênero, desequilibrando a luta e aumentando a eficácia quando combinado com o item Leque.'),
('Karatê Kid', 'Permite trocar armamentos e armaduras instantaneamente durante a batalha.');

INSERT INTO player_base (nome, id_classe, efeitos) 
VALUES
('Lukis', 4, 'Compartilhando alma com Lilith'),
('Dio Spin Keiner', 1, 'Amaldiçoado'),
('Damian Jackson', 4, 'Invocador de sombras'),
('Adrian Kreuz', 4, 'Abençoado'),
('Aurelian Tempest', 6, '...'),
('Ikulian', 1, '...'),
('Bachira', 14,'Destruct (Impede de receber buffs)'),
('Yuri Konshkina',3, '...'),
('Koishi Komeiji',8, '...');

INSERT INTO player_dinheiro (id_player, dinheiro, fragmento)
VALUES
(1,847790,0),
(2,10175,0),
(3,478545,0),
(4,547940,0),
(5,530055,0),
(6, 7000,700),
(7,10000,525),
(8,1100,0),
(9,100,0);

INSERT INTO player_status (id_player,level, hp, forca, velocidade, agilidade, durabilidade, combate, experiencia)
VALUES
(1, 24, 201, 34, 21, 28, 48, 12, 10),
(2, 20,210, 30, 20, 20, 20, 8, 17),
(3, 11, 328, 8, 4, 5, 6, 9, 6),
(4, 20, 150, 12, 7, 12, 16, 3, 5),
(5, 23, 105, 2, 26, 25, 18, 2, 13),
(6, 22, 103, 25, 20, 17, 19, 9, 12),
(7, 21, 105, 21, 18, 13, 24, 5, 7),
(8, 4, 105, 3, 4, 2, 4, 3, 5),
(9, 1, 105, 1, 1, 1, 2, 1, 3);

INSERT INTO player_energias (id_player, energia, stamina, iq, aura)
VALUES
(1, 160, 100, 135, 12),
(2, 25, 55, 125, 38),
(3, 80, 35, 160, 4),
(4, 1180, 50, 110, 10),
(5, 160, 85, 110, 15),
(6, 125, 105, 130, 15),
(7, 145, 120, 105, 14),
(8, 65, 45, 120, 10),
(9, 25, 25, 105, 1);

INSERT INTO player_mente (id_player, sanidade, sanidadeMax, stress, traumas, rm)
VALUES
(1, 95, 100, 53, 1, 45),
(2, 57, 90, 80, 3, 28),
(3, 100, 100, 30, 0, 15),
(4, 85, 100, 58, 0, 35),
(5, 63, 90, 49, 2, 10),
(6, 92, 100, 52, 0, 10),
(7, 47, 90, 60, 0, 11),
(8, 110, 110, 15, 0, 15),
(9, 100, 100, 10, 0, 15);

INSERT INTO R_player_titulo (id_player, id_titulo)
VALUES
(1,1),
(1,2),
(2,1),
(2,3),
(2,4),
(3,1),
(4,1),
(5,1),
(6,1),
(7,1),
(8,1);

