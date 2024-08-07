<?php
    include './includes/templates/header.php';
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jpeg">
                    <img src="build/img/blog1.jpg" alt="Texto Entrada Blog" loading="lazy">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Terraza en el techo de tu casa</h4>
                    <p>Escrito el: <span>30/07/2024</span> por: <span>Admin</span></p>
                    <p>
                        Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando dinero.
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp">
                    <source srcset="build/img/blog2.jpg" type="image/jpeg">
                    <img src="build/img/blog2.jpg" alt="Texto Entrada Blog" loading="lazy">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Construye una piscina en tu hogar</h4>
                    <p>Escrito el: <span>30/07/2024</span> por: <span>Admin</span></p>
                    <p>
                        Maximiza el espacio en tu hogar con esta guía, aprende a como se debe construir una piscina sin fallar en el intento.
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog3.webp" type="image/webp">
                    <source srcset="build/img/blog3.jpg" type="image/jpeg">
                    <img src="build/img/blog3.jpg" alt="Texto Entrada Blog" loading="lazy">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Guía para la decoración de tu hogar</h4>
                    <p>Escrito el: <span>30/07/2024</span> por: <span>Admin</span></p>
                    <p>
                        Optimiza el espacio en tu hogar con esta guía, aprende a combinar muebles y colores para darle vida a tu hogar.
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog4.webp" type="image/webp">
                    <source srcset="build/img/blog4.jpg" type="image/jpeg">
                    <img src="build/img/blog4.jpg" alt="Texto Entrada Blog" loading="lazy">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Guía para la decoración de tu habitación</h4>
                    <p>Escrito el: <span>30/07/2024</span> por: <span>Admin</span></p>
                    <p>
                        Aprende a combinar muebles y colores para darle vida a tu habitación
                    </p>
                </a>
            </div>
        </article>

    </main>

    <footer class="footer seccion">
        <div class="contenedor contenido-footer">
            <nav class="navegacion">
                <a href="nosotros.html">Nosotros</a>
                <a href="anuncios.html">Anuncios</a>
                <a href="blog.html">Blog</a>
                <a href="contacto.html">Contacto</a>
            </nav>
        </div>
        <p class="copyright">Todos los derechos reservador 2024 &copy;</p>
    </footer>

    <script src="build/js/bundle.min.js"></script>
</body>

</html>