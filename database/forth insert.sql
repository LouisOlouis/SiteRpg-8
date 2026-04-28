USE SiteRPG;

INSERT INTO R_player_encantamento (id_player, id_encantamentos, level)
VALUES

(1,36,1),
(1,24,1),
(1,33,1),
(5,24,1),
(8,35,3),
(8,24,3),
(8,31,7);

INSERT INTO R_player_estiloluta (id_player, id_estiloluta)
VALUES

(1,1),
(2,3),
(3,1),
(4,1),
(5,1),
(6,1),
(7,3),
(8,1),
(9,1);

INSERT INTO player_talentos (id_player, nome, descricao)
VALUES
(1,"Runa","Proteção II (+2 DE DURABILIDADE)."),
(2,"Aprendizagem Rápida", "Aprende rapido"),
(4,"Benção da Pedra Ancestral", "Corpo de Rocha Viva: o portador ganha resistência absurda. Pele se torna semelhante a pedra rúnica. Cortar isso dá trabalho. +9 Força, Durabilidade, Stamina e RM ao ativar o poder da benção (CD: 30 turnos)."),
(7,"Seis Olhos","Permitem ao usuário enxergar e analisar com precisão absoluta os fluxos de Energia Amaldiçoada, Prana, Aura e Force, compreendendo qualquer técnica apenas ao observá-la e identificando contratos, pactos e bênçãos. Esse poder reduz em 50% o custo de Energia Amaldiçoada, concede +5 em testes de reação e percepção e garante controle refinado do uso energético. Em contrapartida, o excesso de informações causa fadiga mental, exigindo o uso de vendas ou óculos escuros para limitar a sobrecarga, e o uso prolongado sem descanso pode resultar em cegueira temporária."),
