<h1>Gestion de productos</h1>

<a class="button button-small" href="<?=base_url?>producto/crear">Crear producto</a>

<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
        <th>PRECIO</th>
        <th>STOCK</th>
    </tr>
    <?php while($pro = $productos->fetch_object()): ?>
        <tr>
            <td><?=$pro->id;?></td>
            <td><?=$pro->nombre;?></td>
            <td><?=$pro->precio;?></td>
            <td><?=$pro->stock;?></td>
        
        </tr>
    <?php endwhile; ?>
</table>