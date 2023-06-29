<?php
require '../banco.php';
//Acompanha os erros de validação

// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    $nomeMontadora = null;
    
    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
		
        if (!empty($_POST['nome'])) {
            $nomeMontadora = $_POST['nome'];
        } else {
            $nomeMontadoraErro = 'Por favor digite novamente o nome da Montadora!';
            $validacao = False;
        }

    }

//Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO montadora(nome) VALUES(?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nomeMontadora));
        Banco::desconectar();
        header("Location:/projeto/montadora/index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Adicionar Montadora</title>
</head>

<body>
<div class="container">
    <div clas="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Adicionar Montadora </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="create.php" method="post">

                    <div class="control-group  <?php echo !empty($nomeMontadoraErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Nome montadora*</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="nome" type="text" placeholder="Nome Montadora"
                                   value="<?php echo !empty($nomeMontadora) ? $nomeMontadora : ''; ?>">
                            <?php if (!empty($nomeMontadoraErro)): ?>
                                <span class="text-danger"><?php echo $nomeMontadoraErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                				
                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
            </div>
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

