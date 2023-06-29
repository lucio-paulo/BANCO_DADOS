<!DOCTYPE html>
<html lang="pt-br">

<?php
require '../banco.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}
   
?>
<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Página Inicial</title>
</head>

<body>
        <center>
            <h1> LUPA SOLUÇÕES TÉCNICAS DE MANUTENÇÃO</h1>    
            <img src="lupa.png" width="422" height="200"> 
        </center>
        <div class="container">
          <div class="jumbotron">
            <center><h1>CONSULTA ORDENS DE SERVIÇOS</h1></center>
            <div class="row">
            </div>
          </div>
            </br>
            <div class="row">
            <p>
                <a class="btn btn-success"href="index.php" >Ordem de Serviço</a>
                <a class="btn btn-primary" href="index.php" >Voltar</a>
            </p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!--<th scope="col">Id</th>-->
                            <th scope="col">NÚMERO DA 'OS'</th>
                            <th scope="col">SITUAÇÃO</th>
                            <th scope="col">Nome do Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pdo = Banco::conectar();
                        $sql = 'SELECT numero, situacao, nome_cliente FROM ordem_servico os inner join cliente c on os.cnpj_cpf_cliente = c.cnpj_cpf_cliente  WHERE numero = ? ORDER BY numero ASC';
                        $q = $pdo->prepare($sql);
                        $q->execute(array($id));
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        
                        echo '<tr>';
                        echo '<th scope="row">'. $row['numero'] . '</th>';
                        echo '<td>'. $row['situacao'] . '</td>';
                        echo '<td>'. $row['nome_cliente'] . '</td>';
                        echo '</tr>';
                        Banco::desconectar();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>
