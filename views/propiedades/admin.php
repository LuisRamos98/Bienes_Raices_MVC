<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>
    <?php $mensaje = mensajeNotificacion($resultado);?>
    <?php if($mensaje):?>
        <p class="alerta exito"><?php echo s($mensaje); ?></p>
    <?php endif; ?>

    <a href="/propiedades/crear" class="boton boton-verde">Crear Propiedad</a>
    <a href="/vendedores/crear" class="boton boton-amarillo">Registrar Vendedor(a)</a>

    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($propiedades as $propiedad):?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo; ?> </td>
                    <td><img src="../imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla" alt="Imagen Tabla"></td>
                    <td>$<?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100" action="/propiedades/eliminar">
                            <input type="hidden" name="id" value=<?php echo $propiedad->id;?> >
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/propiedades/actualizar?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <!-- VENDEDORES-->
    <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vendedores as $vendedor):?>
                    <tr>
                        <td> <?php echo $vendedor->id; ?> </td>
                        <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                        <td> <?php echo $vendedor->telefono; ?></td>
                        <td>
                            <form method="POST" class="w-100" action="/vendedores/eliminar">
                                <input type="hidden" name="id" value=<?php echo $vendedor->id;?> >
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            <a href="/vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
</main>