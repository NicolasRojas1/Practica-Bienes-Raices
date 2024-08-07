<?php
    //Require se utiliza para funciones, codigo mas complejo
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta frente al bosque</h1>

        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/jpeg">
            <img src="build/img/destacada.jpg" alt="imagen de la propiedad" loading="lazy">
        </picture>

        <div class="resumen-propiedad">
            <p class="precio">3'000.000</p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="Icono wc" loading="lazy">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="Icono estacionamiento" loading="lazy">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="Icono dormitorio" loading="lazy">
                    <p>4</p>
                </li>
            </ul>
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
    incluirTemplate('footer');
?>