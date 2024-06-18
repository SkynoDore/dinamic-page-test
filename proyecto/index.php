<?php
include('config.php');
session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" CONTENT="Gabriel Vich">
    <meta name="description" content="Restaurante de Ohnigiri, para deleitar tu paladar">
    <meta name="category" content="Bar">
    <link rel="icon" type="image/jpg" href="photos/favicon.ico">
    <!-- ESTILO-->
    <link rel="stylesheet" href="style/main.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
    <title>Oh-nigiri!</title>
</head>

<body>
    <?php
    include('scripts/selector_de_barras.php');
    ?>


    <main>
        <?php
        include('views/barras/bienvenido.php');
        ?>
        <section class="w-100">
            <div class="container w-75 p-5 pt-1 bg-light d-block d-none d-md-block">
                <img class="d-flex mx-auto py-0" src="photos/logoprov.png" alt="logo">
                <p>
                <h1 class="pb-4">¡Conoce los Ohnigiris!</h1>
                    ¡Bienvenido a nuestra historia del sushi, donde cada rollo es una obra maestra de amor y dedicación,
                    desde la cocina hasta tu puerta!
                    Nuestros talentosos cocineros se sumergen en una tradición centenaria, preparando cada pieza con
                    cuidado
                    y pasión.
                    Desde el cuidadoso lavado y la cocción perfecta del arroz hasta la selección de los ingredientes más
                    frescos y sabrosos, cada paso se realiza con amor y atención al detalle.
                </p>
                <p>
                    Con manos expertas y corazones apasionados, nuestros chefs dan forma a cada pieza de sushi con
                    precisión
                    y destreza, creando una experiencia culinaria que despierta los sentidos y deleita el alma.
                    Cada rollo es una expresión de creatividad y dedicación, destinado a llevar alegría y satisfacción a
                    cada cliente.
                </p>
                <p>
                    Desde nuestra cocina hasta tu mesa, cada rollo de Ohnigiri es un viaje de sabores y emociones,
                    cuidadosamente elaborado con amor para deleitar tu paladar y llenar tu corazón de felicidad.
                    ¡Disfruta de esta experiencia gastronómica única y deja que nuestros cocineros te lleven en un viaje
                    culinario que nunca olvidarás!
                </p>
                <?php if (!isset($_SESSION["valido"]) || $_SESSION["valido"] !== TRUE) {
                        echo " <h2>Hazte miembro</h2>
                            <p>¿Quieres reservar o acceder a promociones especiales? Hazte miembro gratuitamente y disfruta los ohnigiris a otro nivel.
                            <p>No tiene cuenta? <a href='views/pagina_registro.php'>regístrate aquí</a></p>
                            <p>Ya tiene cuenta? <a href='views/pagina_registro.php'>Accede aquí</a></p>
                    ";}
                    ?>
            </div>
            <div class="w-100 p-5 pt-1 bg-light d-block d-block d-md-none">
                <img class="d-flex mx-auto py-0" src="photos/logoprov.png" alt="logo">
                <!-- ESTO ES SOLAMENTE PARA MOVILES-->
                <h1 class="pb-4">¡Conoce los Ohnigiris!</h1>
                <p>
                    ¡Bienvenido a nuestra historia del sushi, donde cada rollo es una obra maestra de amor y dedicación,
                    desde la cocina hasta tu puerta!
                    Nuestros talentosos cocineros se sumergen en una tradición centenaria, preparando cada pieza con
                    cuidado
                    y pasión.
                    Desde el cuidadoso lavado y la cocción perfecta del arroz hasta la selección de los ingredientes más
                    frescos y sabrosos, cada paso se realiza con amor y atención al detalle.
                </p>
                <p>
                    Con manos expertas y corazones apasionados, nuestros chefs dan forma a cada pieza de sushi con
                    precisión
                    y destreza, creando una experiencia culinaria que despierta los sentidos y deleita el alma.
                    Cada rollo es una expresión de creatividad y dedicación, destinado a llevar alegría y satisfacción a
                    cada cliente.
                </p>
                <p>
                    Desde nuestra cocina hasta tu mesa, cada rollo de Ohnigiri es un viaje de sabores y emociones,
                    cuidadosamente elaborado con amor para deleitar tu paladar y llenar tu corazón de felicidad.
                    ¡Disfruta de esta experiencia gastronómica única y deja que nuestros cocineros te lleven en un viaje
                    culinario que nunca olvidarás!
                </p>
            </div>

        </section>
        <section class="bg-secondary m-0">
            <div id="carouselExampleIndicators" class="carousel slide w-75 mx-auto" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="photos/carrousel1.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Prueba nuestros combos</h5>
                            <p>Ofrecemos variedades únicas para deleitarte.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="photos/carrousel2.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Sabores extravagantes que te sorprenderán</h5>
                            <p>Nuestros chefs se la pasan innovando.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="photos/carrousel5.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Ohnigiris especiales</h5>
                            <p>Para satisfacer hasta el hambre más voraz.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="photos/carrousel3.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Ohnigiris especiales</h5>
                            <p>Para darle un detalle a alguien especial.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="photos/carrousel4.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Ohnigiris temáticos</h5>
                            <p>Para que celebres en grande.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

    </main>

    <?php include 'views/barras/footer.php' ?>
</body>

</html>