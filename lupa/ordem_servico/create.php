<?php
require '../banco.php';
//Acompanha os erros de validação

// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    $numeroErro = null;
    $situacaoErro = null;
    $cnpj_cpf_clienteErro = null;
   
    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
	
        if (!empty($_POST['cnpj_cpf_cliente'])) {
            $cnpj_cpf_cliente = $_POST['cnpj_cpf_cliente'];
        } else {
            $cnpj_cpf_clienteErro = 'CNPJ OU CPF inválido! Digite novamente.';
            $validacao = False;
        }

    }

//Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO ordem_servico(situacao,cnpj_cpf_cliente) VALUES('ABERTA',?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($cnpj_cpf_cliente));
        Banco::desconectar();
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Adicionar Projeto</title>
</head>

<body>
<div class="container">
    <div clas="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> CRIAR NOVA ORDEM DE SERVIÇO </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="create.php" method="post">

                    <div class="control-group <?php echo !empty($cnpj_cpf_clienteErro) ? 'error ' : ''; ?>">
                        <label class="control-label">SELECIONE O CLIENTE*</label>
                        <div class="controls">
                            
					<?php
                        $pdo = Banco::conectar();
                        $sql = 'SELECT cnpj_cpf_cliente,nome_cliente from cliente';

						echo '<select name="cnpj_cpf_cliente" size="1">';
                        foreach($pdo->query($sql)as $row)
                        {
                            echo '<option value="'. $row['cnpj_cpf_cliente'] .'">'. $row['nome_cliente'] . '</option>';
                        }
						
						echo '</select>';
                        Banco::desconectar();
                     ?>
							
                            <?php if (!empty($cnpj_cpf_clienteErro)): ?>
                                <span class="text-danger"><?php echo $cnpj_cpf_clienteErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Adicionar</button>   
                        <a class="btn btn-success" href="../cliente/create.php" type="btn" class="btn btn-default">Inserir novo Cliente</a>   
                        <a class="btn btn-primary" href="index.php">Voltar</a>    
                        <a class="btn btn-primary" href="../index.php">Tela principal</a>                         
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

