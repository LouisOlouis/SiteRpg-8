<?php
include("conexao.php");
include("header.php");
include("admin_check.php");
require_admin();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Carrega listas de suporte
$classes   = $conn->query("SELECT id, classe FROM classes ORDER BY classe")->fetch_all(MYSQLI_ASSOC);
$energias  = $conn->query("SELECT id, nome FROM energias ORDER BY id")->fetch_all(MYSQLI_ASSOC);

// Valores padrão
$base     = ['nome'=>'','id_classe'=>1,'efeitos'=>''];
$dinheiro = ['dinheiro'=>0,'fragmento'=>0];
$status   = ['level'=>1,'hp'=>100,'forca'=>1,'velocidade'=>1,'agilidade'=>1,'durabilidade'=>1,'combate'=>1,'experiencia'=>0];
$energias_p = ['iq'=>100,'stamina'=>100,'energia'=>100,'aura'=>10];
$mente    = ['sanidade'=>100,'sanidadeMax'=>100,'stress'=>0,'traumas'=>0,'rm'=>10];

if ($id) {
    $s = $conn->prepare("SELECT nome, id_classe, efeitos FROM player_base WHERE id=?");
    $s->bind_param("i",$id); $s->execute();
    $base = $s->get_result()->fetch_assoc(); $s->close();

    $s = $conn->prepare("SELECT dinheiro, fragmento FROM player_dinheiro WHERE id_player=?");
    $s->bind_param("i",$id); $s->execute();
    $dinheiro = $s->get_result()->fetch_assoc() ?? $dinheiro; $s->close();

    $s = $conn->prepare("SELECT level,hp,forca,velocidade,agilidade,durabilidade,combate,experiencia FROM player_status WHERE id_player=?");
    $s->bind_param("i",$id); $s->execute();
    $status = $s->get_result()->fetch_assoc() ?? $status; $s->close();

    $s = $conn->prepare("SELECT iq,stamina,energia,aura FROM player_energias WHERE id_player=?");
    $s->bind_param("i",$id); $s->execute();
    $energias_p = $s->get_result()->fetch_assoc() ?? $energias_p; $s->close();

    $s = $conn->prepare("SELECT sanidade,sanidadeMax,stress,traumas,rm FROM player_mente WHERE id_player=?");
    $s->bind_param("i",$id); $s->execute();
    $mente = $s->get_result()->fetch_assoc() ?? $mente; $s->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim($_POST['nome']);
    $id_classe  = intval($_POST['id_classe']);
    $efeitos    = trim($_POST['efeitos']);

    if ($id) {
        $s = $conn->prepare("UPDATE player_base SET nome=?,id_classe=?,efeitos=? WHERE id=?");
        $s->bind_param("ssii",$nome,$efeitos,$id_classe,$id); // fix order
        // correct order:
        $s->close();
        $s = $conn->prepare("UPDATE player_base SET nome=?,id_classe=?,efeitos=? WHERE id=?");
        $s->bind_param("sisi",$nome,$id_classe,$efeitos,$id);
        $s->execute(); $s->close();

        $s = $conn->prepare("UPDATE player_dinheiro SET dinheiro=?,fragmento=? WHERE id_player=?");
        $s->bind_param("iii",$_POST['dinheiro'],$_POST['fragmento'],$id);
        $s->execute(); $s->close();

        $s = $conn->prepare("UPDATE player_status SET level=?,hp=?,forca=?,velocidade=?,agilidade=?,durabilidade=?,combate=?,experiencia=? WHERE id_player=?");
        $s->bind_param("iiiiiiiii",$_POST['level'],$_POST['hp'],$_POST['forca'],$_POST['velocidade'],$_POST['agilidade'],$_POST['durabilidade'],$_POST['combate'],$_POST['experiencia'],$id);
        $s->execute(); $s->close();

        $s = $conn->prepare("UPDATE player_energias SET iq=?,stamina=?,energia=?,aura=? WHERE id_player=?");
        $s->bind_param("iiiii",$_POST['iq'],$_POST['stamina'],$_POST['energia'],$_POST['aura'],$id);
        $s->execute(); $s->close();

        $s = $conn->prepare("UPDATE player_mente SET sanidade=?,sanidadeMax=?,stress=?,traumas=?,rm=? WHERE id_player=?");
        $s->bind_param("iiiiii",$_POST['sanidade'],$_POST['sanidadeMax'],$_POST['stress'],$_POST['traumas'],$_POST['rm'],$id);
        $s->execute(); $s->close();

    } else {
        $s = $conn->prepare("INSERT INTO player_base (nome,id_classe,efeitos) VALUES (?,?,?)");
        $s->bind_param("sis",$nome,$id_classe,$efeitos);
        $s->execute();
        $id = $conn->insert_id;
        $s->close();

        $s = $conn->prepare("INSERT INTO player_dinheiro (id_player,dinheiro,fragmento) VALUES (?,?,?)");
        $s->bind_param("iii",$id,$_POST['dinheiro'],$_POST['fragmento']);
        $s->execute(); $s->close();

        $s = $conn->prepare("INSERT INTO player_status (id_player,level,hp,forca,velocidade,agilidade,durabilidade,combate,experiencia) VALUES (?,?,?,?,?,?,?,?,?)");
        $s->bind_param("iiiiiiiii",$id,$_POST['level'],$_POST['hp'],$_POST['forca'],$_POST['velocidade'],$_POST['agilidade'],$_POST['durabilidade'],$_POST['combate'],$_POST['experiencia']);
        $s->execute(); $s->close();

        $s = $conn->prepare("INSERT INTO player_energias (id_player,iq,stamina,energia,aura) VALUES (?,?,?,?,?)");
        $s->bind_param("iiiii",$id,$_POST['iq'],$_POST['stamina'],$_POST['energia'],$_POST['aura']);
        $s->execute(); $s->close();

        $s = $conn->prepare("INSERT INTO player_mente (id_player,sanidade,sanidadeMax,stress,traumas,rm) VALUES (?,?,?,?,?,?)");
        $s->bind_param("iiiiii",$id,$_POST['sanidade'],$_POST['sanidadeMax'],$_POST['stress'],$_POST['traumas'],$_POST['rm']);
        $s->execute(); $s->close();
    }

    header("Location: fichaview.php?id=$id");
    exit();
}

function field($label, $name, $value, $type='number') {
    echo "<label>$label</label>";
    echo "<input type='$type' name='$name' value='" . htmlspecialchars($value) . "' required>";
}
?>

<div class="content">
    <form class="admin-form" method="post">
        <h2><?= $id ? 'Editar Ficha' : 'Nova Ficha' ?></h2>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Informações</h3>
            <label>Nome</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($base['nome']) ?>" required>

            <label>Classe</label>
            <select name="id_classe">
                <?php foreach ($classes as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $base['id_classe'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['classe']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Efeitos</label>
            <input type="text" name="efeitos" value="<?= htmlspecialchars($base['efeitos']) ?>">
        </div>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Dinheiro</h3>
            <?php field('Dinheiro','dinheiro',$dinheiro['dinheiro']); ?>
            <?php field('Fragmentos','fragmento',$dinheiro['fragmento']); ?>
        </div>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Status</h3>
            <?php
            field('Level','level',$status['level']);
            field('HP','hp',$status['hp']);
            field('Força','forca',$status['forca']);
            field('Velocidade','velocidade',$status['velocidade']);
            field('Agilidade','agilidade',$status['agilidade']);
            field('Durabilidade','durabilidade',$status['durabilidade']);
            field('Combate','combate',$status['combate']);
            field('Experiência','experiencia',$status['experiencia']);
            ?>
        </div>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Energias</h3>
            <?php
            field('IQ','iq',$energias_p['iq']);
            field('Stamina','stamina',$energias_p['stamina']);
            field('Energia','energia',$energias_p['energia']);
            field('Aura','aura',$energias_p['aura']);
            ?>
        </div>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Mente</h3>
            <?php
            field('Sanidade','sanidade',$mente['sanidade']);
            field('Sanidade Máx','sanidadeMax',$mente['sanidadeMax']);
            field('Stress','stress',$mente['stress']);
            field('Traumas','traumas',$mente['traumas']);
            field('RM','rm',$mente['rm']);
            ?>
        </div>

        <button type="submit" class="btn-admin btn-save">Salvar</button>
        <a href="fichas.php" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
    </form>
</div>
</body>
</html>
