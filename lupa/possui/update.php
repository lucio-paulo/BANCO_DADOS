<?php

require '../banco.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}

if (!empty($_POST)) {

    $idmontadoraErro = null;
    $nomemontadoraErro = null;
   
    $idmontadora = $_POST['id'];
   	$nomemontadora = $_POST['nome'];

    //Validação
    $validacao = true;
	
    if (empty($idmontadora)) {
        $idmontadoraErro = 'Por favor digite o nome do projeto!';
        $validacao = false;
    }

    if (empty($nomemontadora)) {
        $nomemontadoraErro = 'Por favor digite o nome do gerente do projeto!';
        $validacao = false;
    }

    // update data
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE montadora set id = ?, nome = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($idmontadora, $nomemontadora, $id));
        Banco::desconectar();
        header("Location: index.php");
    }
} else {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT id,nome FROM montadora WHERE id = ? ORDER BY id ASC';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
	
	$idmontadora = $data['id'];
    $nomemontadora = $data['nome'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- using new bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Atualizar Montadora</title>
</head>

<body>
<div class="container">

    <div class="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Atualizar Montadora </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post">

                    <div class="control-group  <?php echo !empty($nomemontadoraErro) ? 'error ' : ''; ?>">
                        <label class="control-label">id Montadora*</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="id" type="text" placeholder="id"
                                   value="<?php echo !empty($idmontadora) ? $idmontadora : ''; ?>">
                            <?php if (!empty($idmontadoraErro)): ?>
                                <span class="text-danger"><?php echo $nomeErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($nomemontadoraErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Nome Montadora*</label>
                        <div class="controls">
                            <input size="80" class="form-control" name="nome" type="text" placeholder="nome"
                                   value="<?php echo !empty($nomemontadora) ? $nomemontadora : ''; ?>">
                            <?php if (!empty($gerenteProjetoErro)): ?>
                                <span class="text-danger"><?php echo $nomemontadoraErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                		
                <?php
                       /* ESSE CARA INCLUI A SETA DE ESCOLHA DE ALGUMA COLUNA
                       
                       $sql = 'SELECT * from montadora';
						$selected = "";
						
						echo '<select name="montadora" size="1">';
                        foreach($pdo->query($sql)as $row)
                        {
							if($row['id'] == $montadora){
								$selected = " selected";
							}else{
								$selected = "";
							}
                            echo '<option value="'. $row['id'] .'"'.$selected.'>'. $row['nome'] . '</option>';
                        }
						
						echo '</select>';*/
                        Banco::desconectar();
             ?>
								   
                            <?php if (!empty($montadoraErro)): ?>
                                <span class="text-danger"><?php echo $montadoraErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
								
		 <!-- -->
                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Atualizar</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>
