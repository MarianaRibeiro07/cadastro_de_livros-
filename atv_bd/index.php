<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

</body>

<?php

$servername = "localhost";
$username = "root";
$password = "Senai@118";
$dbname = "bibliotecaa";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

echo "<h1>Cadastros de Livros📖</h1>";
$sql = "CREATE TABLE IF NOT EXISTS livro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    ano INT
)";
$conn->query($sql);


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo '
    <form method="POST">
        Nome: <input type="text" name="nome"><br>
        Ano: <input type="number" name="ano"><br>
        <input type="submit" value="Enviar">
    </form>
    ';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $ano = $_POST["ano"];

    if ($nome == "" || $ano == "" || $ano <= 0) {
        echo "Preencha os campos corretamente.<br>";
    } else {
        $sqlInsert = "INSERT INTO livro (nome, ano) VALUES ('$nome', $ano)";
        if ($conn->query($sqlInsert) === TRUE) {
            echo "Livro inserido com sucesso!<br>";

           
            $ultimo_id = $conn->insert_id;
            $sqlSelect = "SELECT * FROM livro WHERE id = $ultimo_id";
            $resultado = $conn->query($sqlSelect);
            $livro = $resultado->fetch_assoc();
            echo "ID: ".$livro['id']." Nome ".$livro['nome']." Ano: ".$livro['ano']."<br>";
        } else {
            echo "Erro ao inserir: " . $conn->error . "<br>";
        }
    }
}


echo "<h3>Livros cadastrados</h3>";
$sqlAll = "SELECT * FROM livro";
$result = $conn->query($sqlAll);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Nome</th><th>Ano</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["nome"]."</td>
                <td>".$row["ano"]."</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum livro cadastrado.<br>";
}
echo "<h3>Livros ordenados pelo ano</h3>";
$sqlOrder = "SELECT * FROM livro ORDER BY ano";
$resOrder = $conn->query($sqlOrder);
if ($resOrder->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Nome</th><th>Ano</th></tr>";
    while ($row = $resOrder->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["nome"]."</td>
                <td>".$row["ano"]."</td>
            </tr>";
    }
    echo "</table>";
}


$sqlCount = "SELECT COUNT(*) AS total FROM livro";
$resCount = $conn->query($sqlCount);
$linhaCount = $resCount->fetch_assoc();
echo "<br>Total de livros cadastrados: " . $linhaCount['total'] . "<br>";

$conn->close();
?>


</body>
</html>