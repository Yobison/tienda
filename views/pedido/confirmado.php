<?php if(isset($_SESSION['pedido']) && $_SESSION['pedido'] == 'complete'): ?>

  <h1>Tu pedido se ha confirmado</h1>
  <p>Tu pedido ha sido guardado correctamente. Una vez que realices el pago a la cuenta 123456789ADD se procederá al envío.</p>
  <br>
  <?php if(isset($pedido)) : ?>
    <h3>Datos del pedido</h3>
      Numero de pedido: <?=$pedido->id?> <br>
      Total a pagar: <?=$pedido->coste?>€<br>
      Productos:
      <table>
        <tr>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Unidades</th>
        </tr>
        <?php while($producto = $productos->fetch_object()) : ?>

          <tr>
            <td>
              <?php if($producto->imagen != null) :?>
                <img src="<?=base_url?>uploads/images/<?=$producto->imagen?>" class="img_carrito" alt="foto camiseta">
              <?php else: ?>
                <img src="<?=base_url?>assets/img/camiseta.png" class="img_carrito" alt="foto camiseta">
              <?php endif; ?>
            </td>
            <td>
              <a href="<?=base_url?>producto/ver&id=<?=$producto->id?>"><?=$producto->nombre?></a>
            </td>
            <td>
              <?=$producto->precio?>
            </td>
            <td>
              <?=$producto->unidades?>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
  <?php endif; ?>

  <?php elseif(isset($_SESSION['pedido']) && $_SESSION['pedido'] != 'complete'): ?>
    <h1>Tu pedido NO ha podido procesarse.</h1>
  <?php endif; ?>