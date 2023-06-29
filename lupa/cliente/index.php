<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Página Inicial</title>
</head>

<body>
        <center>
            <img src="lupa.png" width="316" height="150"> 
            <h1> LUPA SOLUÇÕES TÉCNICAS DE MANUTENÇÃO</h1>
        </center>
 <!-- Latest compiled and minified JavaScript -->
        <div class="container">
          <div class="jumbotron">
           <div class="row" style="margin: auto; width: 50%;padding: 10px;" >
                <h2 >Cadastro de Cliente</h2>
            </div>
          </div>
            </br>
            <div class="row">
                <p>
                    <a class="btn btn-success" href="create.php">Novo Cliente</a>
                    <a class="btn btn-primary" href="../index.php">Voltar</a> 
                </p>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">cnpj_cpf_cliente</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">endereco</th>
                            <th scope="col">nome_cliente</th>
                            <th scope="col">Ação</th> <!--ação dos botoes-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../banco.php';
                        $pdo = Banco::conectar();
                        $sql = 'SELECT * FROM cliente ORDER BY nome_cliente ASC';

                        foreach($pdo->query($sql)as $row)
                        {
                            echo '<tr>';
			                echo '<th scope="row">'. $row['cnpj_cpf_cliente'] . '</th>';
                            echo '<td>'. $row['telefon'] . '</td>';
                            echo '<td>'. $row['endereco'] . '</td>';
                            echo '<td>'. $row['nome_cliente'] . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn btn-primary" href="read.php?id='.$row['cnpj_cpf_cliente'].'">Info</a>';
                            echo ' ';
                            echo '<a class="btn btn-warning" href="update.php?id='.$row['cnpj_cpf_cliente'].'">Editar</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$row['cnpj_cpf_cliente'].'">Excluir</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
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
