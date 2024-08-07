<?php
    include './includes/templates/header.php';
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source src="build/img/nosotros.webp" type="image/webp">
                    <source src="build/img/nosotros.jpg" type="image/jpeg">
                    <img src="build/img/nosotros.jpg" alt="Sobre nosotros" loading="lazy">
                </picture>
            </div>
            <div class="texto-nosotros">
                <blockquote>
                    25 Años de experiencia
                </blockquote>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut optio aliquam sit excepturi voluptas inventore doloremque nisi ipsam et atque quam laudantium quibusdam incidunt, possimus molestiae dolor nobis iste dolorem!
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorem repellendus fugit quam voluptate iusto. Quae, error distinctio id in, praesentium accusantium odio aperiam, nam autem consequatur pariatur voluptates quis cupiditate?
                </p>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos rem tempora dolorem ut iste porro nihil quis impedit? Quo vero reprehenderit voluptates in minima reiciendis officia illum consectetur autem possimus.
                </p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex quas dolor quam laboriosam, amet explicabo atque eligendi voluptatum reprehenderit dolorum in cum, ut eum, minima animi omnis quae. Aliquam, voluptatum?</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex quas dolor quam laboriosam, amet explicabo atque eligendi voluptatum reprehenderit dolorum in cum, ut eum, minima animi omnis quae. Aliquam, voluptatum?</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex quas dolor quam laboriosam, amet explicabo atque eligendi voluptatum reprehenderit dolorum in cum, ut eum, minima animi omnis quae. Aliquam, voluptatum?</p>
            </div>
        </div>
    </section>

<?php
    include './includes/templates/footer.php';
?>