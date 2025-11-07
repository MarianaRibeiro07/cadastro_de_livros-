<?php
$servername = "localhost";
$username = "root";
$password = "Senai@118";
$dbname = "bibliotecaa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// ---------- 1️⃣ Carregar dados do livro ----------
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM livro WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $livro = $result->fetch_assoc();

    if (!$livro) {
        die("Livro não encontrado!");
    }

    $stmt->close();
} else {
    die("ID não informado!");
}

// ---------- 2️⃣ Atualizar dados ----------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']); // agora vem do input hidden
    $nome = $_POST['nome'];
    $ano = intval($_POST['ano']);

    $sql = "UPDATE livro SET nome = ?, ano = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $nome, $ano, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Atualizar Livro</title>
</head>
<body>
    <h1>Atualizar Livro</h1>

    <form action="" method="POST">
        <!-- Campo oculto para manter o ID -->
        <input type="hidden" name="id" value="<?php echo $livro['id']; ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($livro['nome']); ?>" required>

        <label>Ano:</label>
        <input type="number" name="ano" value="<?php echo htmlspecialchars($livro['ano']); ?>" required>

        <input type="submit" value="Atualizar">
    </form>

    <a href="index.php">Cancelar</a>
</body>
</html>
