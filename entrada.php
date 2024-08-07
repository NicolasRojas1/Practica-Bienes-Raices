<?php
    include './includes/templates/header.php';
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta frente al bosque</h1>

        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img src="build/img/destacada2.jpg" alt="imagen de la propiedad" loading="lazy">
        </picture>

        <p class="informacion-meta">Escrito el: <span>31/07/2024</span> por: <span>Admin</span></p>

        <div class="resumen-propiedad">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut optio aliquam sit excepturi voluptas inventore doloremque nisi ipsam et atque quam laudantium quibusdam incidunt, possimus molestiae dolor nobis iste dolorem!
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorem repellendus fugit quam voluptate iusto. Quae, error distinctio id in, praesentium accusantium odio aperiam, nam autem consequatur pariatur voluptates quis cupiditate?
            </p>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos rem tempora dolorem ut iste porro nihil quis impedit? Quo vero reprehenderit voluptates in minima reiciendis officia illum consectetur autem possimus.
            </p>
        </div>

    </main>

<?php
    include './includes/templates/footer.php';
?>