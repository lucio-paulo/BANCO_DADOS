<?php
require '../banco.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}



//Acompanha os erros de validação
function formatCnpjCpf($value)
{
  $cnpj_cpf = preg_replace("/\D/", '', $value);
  
  if (strlen($cnpj_cpf) === 11) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } 
  
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}
// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    $cnpj_cpf_cliente = null;
    $telefon = null;
    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
		
        if (!empty($_POST['cnpj_cpf_cliente'])) {
            $cnpj_cpf_cliente = formatCnpjCpf($_POST['cnpj_cpf_cliente']);
        } else {
            $cnpj_cpf_clienteErro = 'Por favor digite novamente o cnpj_cpf_cliente!';
            $validacao = False;
        }
        if (!empty($_POST['telefon'])) {
            $telefon = $_POST['telefon'];
        } else {
            $telefonErro = 'Por favor digite novamente o telefon!';
            $validacao = False;
        }
        if (!empty($_POST['endereco'])) {
            $endereco = $_POST['endereco'];
        } else {
            $enderecoErro = 'Por favor digite novamente o endereco!';
            $validacao = False;
        }
        if (!empty($_POST['nome_cliente'])) {
            $nome_cliente = $_POST['nome_cliente'];
        } else {
            $nome_clienteErro = 'Por favor digite novamente o nome_cliente!';
            $validacao = False;
        }

    }

//Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE cliente SET  telefon = ?,endereco = ?, nome_cliente = ? WHERE cnpj_cpf_cliente = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($telefon,$endereco,$nome_cliente,$cnpj_cpf_cliente));
        Banco::desconectar();
       
        header("Location: index.php");
    }
}else {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM cliente WHERE cnpj_cpf_cliente = ?';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
	$cnpj_cpf_cliente = $data['cnpj_cpf_cliente'];
    $telefon = $data['telefon'];
    $endereco = $data['endereco'];
    $nome_cliente = $data['nome_cliente'];
	
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Adicionar Clinte</title>
</head>

<body>
<div class="container">
    <div clas="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Adicionar Cliente </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post">

                    <div class="control-group  <?php echo !empty($cnpj_cpf_clienteErro) ? 'error ' : ''; ?>">
                        <label class="control-label">cnpj cpf cliente*</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="cnpj_cpf_cliente" type="text" readonly placeholder="cnpj cpf cliente"
                                   value="<?php echo !empty($cnpj_cpf_cliente) ? $cnpj_cpf_cliente : ''; ?>">
                            <?php if (!empty($cnpj_cpf_clienteErro)): ?>
                                <span class="text-danger"><?php echo $cnpj_cpf_clienteErro; ?></span>
                            <?php endif; ?>
                        </div> 
                    </div>
                    <div class="control-group  <?php echo !empty($telefonErro) ? 'error ' : ''; ?>">
                        <label class="control-label">telefon*</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="telefon" type="text" placeholder="telefon"
                                   value="<?php echo !empty($telefon) ? $telefon : ''; ?>">
                            <?php if (!empty($telefonErro)): ?>
                                <span class="text-danger"><?php echo $telefonErro; ?></span>
                            <?php endif; ?>
                        </div> 
                    </div>
                    <div class="control-group  <?php echo !empty($enderecoErro) ? 'error ' : ''; ?>">
                        <label class="control-label">endereco*</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="endereco" type="text" placeholder="endereco"
                                   value="<?php echo !empty($endereco) ? $endereco : ''; ?>">
                            <?php if (!empty($enderecoErro)): ?>
                                <span class="text-danger"><?php echo $enderecoErro; ?></span>
                            <?php endif; ?>
                        </div> 
                    </div>            
                    <div class="control-group  <?php echo !empty($nome_clienteErro) ? 'error ' : ''; ?>">
                        <label class="control-label">nome_cliente*</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="nome_cliente" type="text" placeholder="nome_cliente"
                                   value="<?php echo !empty($nome_cliente) ? $nome_cliente : ''; ?>">
                            <?php if (!empty($nome_clienteErro)): ?>
                                <span class="text-danger"><?php echo $nome_clienteErro; ?></span>
                            <?php endif; ?>
                        </div> 
                    </div>			
                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Adicionar</button>
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

