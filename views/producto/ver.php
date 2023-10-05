<h1></h1>
<?php if(isset($product)) :?>
  <h1><?=$product->nombre?></h1>
  <div id="detail-product">
    <div class="image">
      <?php if($product->imagen != null) :?>
        <img src="<?=base_url?>uploads/images/<?=$product->imagen?>" alt="foto camiseta">
      <?php else: ?>
        <img src="<?=base_url?>assets/img/camiseta.png" alt="foto camiseta">
      <?php endif; ?>
    </div>
    <div class="data">
      <p class="description"><?=$product->descripcion?></p>
      <p class="price"><?=$product->precio?>€</p>
        <a href="<?=base_url?>carrito/add&id=<?=$product->id?>"class="button">Comprar</a>
    </div>
  </div>

<?php else :?>
  <h1>La producto no existe</h1>
<?php endif;?>