<?php
include '../config.php';
session_start();
include '../scripts/bd.php';
if (isset($_SESSION['usuario'])) {
    $idUsuario = $_SESSION['usuario'];
    $role = $_SESSION['role'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" CONTENT="Gabriel Vich">
    <meta name="description" content="Contacto">
    <meta name="category" content="Bar">
    <link rel="icon" type="image/jpg" href="../photos/favicon.ico">
    <link rel="stylesheet" href="../style/main.css">
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
    <title>Noticias ohnigiri</title>
    
    <script>
    function toggleForm(idNoticia) {
        var formInfo = document.getElementById('form_info-' + idNoticia);
        var formEdit = document.getElementById('form-' + idNoticia);
        if (formEdit.style.display === 'none') {
            formEdit.style.display = 'block';
            formInfo.style.display = 'none';
        } else {
            formEdit.style.display = 'none';
            formInfo.style.display = 'block';
        }
        }
    </script>
</head>
<body>
    <?php include('../scripts/selector_de_barras.php'); ?>

    <main>
        <section>
        <div class="container p-2 bg-light">
        <?php include('../scripts/mensaje_cambio.php'); ?>
        
            <?php if (isset($role) && $role == 'admin') { ?>
                <h2>Subir una noticia</h2>
                <form action="/htdocs/views/noticias/subir_noticia.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <input class="form-control" type="text" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="cuerpo">Cuerpo de la noticia:</label>
                        <textarea class="form-control" id="cuerpo" name="cuerpo" rows="7" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen:</label><br>
                        <input type="file" name="imagen" id="imagen"><br>
                        <input class="btn btn-secondary mt-2" type="submit" value="Subir noticia">
                    <p>(Solo se soportan imágenes de formato jpeg y png de máximo 2MB)</p>
                    </div>
                </form>
            <?php } ?>
        </div>

        <?php
        // Consulta para obtener las noticias y el nombre del usuario que las creó
        $query = "
            SELECT noticias.idNoticia, noticias.titulo, noticias.imagen, noticias.cuerpo, noticias.fecha, usuarios.nombre 
            FROM noticias
            JOIN usuarios ON noticias.idUserFK = usuarios.idUsuario
            ORDER BY noticias.fecha DESC
        ";

        $result = $conn->query($query);

        if ($result === false) {
            die("Error en la consulta: " . $conn->error);
        }
        ?>

        <div class="news-container container d-flex flex-column justify-content-center text-center bg-light">
        <h1>Noticias</h1>
        <p class="text-center">¡Estate al tanto de nuestras últimas noticias!</p>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $idNoticia = $row['idNoticia'];
                    ?>
                    <div class="news-item" id="form_info-<?php echo $idNoticia; ?>">
                        <h2><?php echo htmlspecialchars($row['titulo']); ?></h2>
                        <img src="/htdocs/<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen de la noticia" class="news-image">
                        <p><?php echo nl2br(htmlspecialchars($row['cuerpo'])); ?></p>
                        <hr>
                        <p class="news-author">Autor: <?php echo htmlspecialchars($row['nombre']); ?><br>
                        <span class="news-date">Publicado el: <?php echo htmlspecialchars($row['fecha']); ?></span></p>
                        <?php if (isset($role) && $role == 'admin') { ?>
                            <button class="btn btn-secondary" type="button" onclick="toggleForm(<?php echo $idNoticia; ?>)">Modificar</button>
                        <?php } ?>
                    </div>
                    
                    <!-- Formulario para modificar la noticia -->
                    <div class="news-item-form" id="form-<?php echo $idNoticia; ?>" style="display: none;">
                        <form action="noticias/modificar_noticia.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idNoticia" value="<?php echo $idNoticia; ?>">
                            <label for="titulo" class="m-2">Título:</label>
                            <input type="text" name="titulo" value="<?php echo htmlspecialchars($row['titulo']); ?>" required><br>
                            
                            <label for="imagen">Imagen:</label><br>
                            <img src="/htdocs/<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen actual" class="news-image">
                            <input type="file" name="imagen" class="m-2"><br>
                            
                            <label for="cuerpo">Cuerpo:</label><br>
                            <textarea name="cuerpo" class="form-control" rows="6" required><?php echo htmlspecialchars($row['cuerpo']); ?></textarea><br>
                            
                            <button class="btn btn-dark" type="submit" name="accion" value="actualizar">Guardar cambios</button>
                            <button class="btn btn-dark" type="submit" name="accion" value="eliminar">Eliminar noticia</button>
                        </form>
                        <button class="btn btn-secondary" type="button" onclick="toggleForm(<?php echo $idNoticia; ?>)">Cancelar</button>
                    </div>
                    <hr>
                    <?php
                }
            } else {
                echo "<p>No hay noticias disponibles.</p>";
            }
            ?>
        </div>
        </section>
    </main>
    <?php include 'barras/footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
