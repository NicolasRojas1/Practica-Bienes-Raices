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

            <label for="vendedor">Vendedor</label>
            <!-- 
            1. le damos el nombre del vendedorId de la columna en la db
            2. id= "vendedor" es para vincularlo con el label de for="vendedor"
            3. se itera entre los vendedores con el foreach
            4. se llama la funcion s, para sanitizar.
            5. Se utiliza la sintaxis de flecha para crear objetos para active record
            6. Cada opcion debe tener un value para la db
            7. Con el operador ternario se marca el id seleccionado con el atributo de selected con el fin de mantenerlo al recargar el formulario
            -->
            <select name="propiedad[vendedorId]" id="vendedor">
                <option selected value=""> --- Selecciona ---</option>
        
                <?php foreach($vendedores as $vendedor): ?>
                    <option
                        value="<?php echo s($vendedor->id) ?>"
                        <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : '' ?>
                    >                       
                         <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?> 
                    </option>
                <?php endforeach; ?>
                
            </select>
        </fieldset>