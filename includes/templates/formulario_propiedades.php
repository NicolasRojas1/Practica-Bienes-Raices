<fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo ); ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo s( $propiedad->precio ); ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

            <?php if ($propiedad->imagen): ?>
                <img src="../../imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
            <?php endif; ?>

            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s( $propiedad->descripcion ); ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" 
            id="habitaciones" 
            name="propiedad[habitaciones]" 
            placeholder="Ej: 2" 
            min="1" max="9"
            value="<?php echo s( $propiedad->habitaciones );?>">

            <label for="wc">Baños:</label>
            <input type="number" 
            id="wc" 
            name="propiedad[wc]" 
            placeholder="Ej: 2" 
            min="1" max="9" 
            value="<?php echo s( $propiedad->wc );?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" 
            id="estacionamiento" 
            name="propiedad[estacionamiento]" 
            placeholder="Ej: 2" 
            min="1" max="9"
            value="<?php echo s( $propiedad->estacionamiento ); ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedorId">
                <option value="">-- Seleccione --</option>
                <?php while($row = mysqli_fetch_assoc($resultado)): ?> 
 
                <option <?php echo s($propiedad->vendedorId) === $row['id'] ? 'selected': ''; ?> value="<?php echo $row['id']; ?>"> <?php echo $row['nombre']. ' ' . $row['apellido']; ?></option>

                <?php endwhile; ?> 
            </select>
        </fieldset>