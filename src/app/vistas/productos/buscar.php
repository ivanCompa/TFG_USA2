<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<nav class="ruta text-xl font-semibold py-4 px-6 text-gray-700">
  Resultados de búsqueda
</nav>

<div class="bloque-superior bg-white border-b-2 border-[#bcd8f0] p-6 rounded-lg shadow-md">

  <!-- BUSCADOR -->
  <form action="<?= RUTA_URL ?>/productos/buscar" method="GET"
    class="busqueda flex flex-col md:flex-row md:items-center gap-4 mb-6">

    <label class="text-xl font-semibold">Buscar:</label>

    <div class="flex gap-3 items-center">

      <!-- BARRA DE BUSQUEDA -->
      <input type="text" name="buscar" placeholder="Buscar producto..." required
        value="<?= htmlspecialchars($datos['texto'] ?? '') ?>"
        class="border border-gray-400 rounded-lg px-4 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">

      <!-- FILTRO ORDENAR POR -->
      <select name="orden"
        class="border border-gray-400 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm"
        onchange="this.form.submit()">

        <option value="">Ordenar por...</option>
        <option value="az" <?= ($datos['orden'] ?? '') === 'az' ? 'selected' : '' ?>>Alfabéticamente ↑</option>
        <option value="za" <?= ($datos['orden'] ?? '') === 'za' ? 'selected' : '' ?>>Alfabéticamente ↓</option>
        <option value="precio_asc" <?= ($datos['orden'] ?? '') === 'precio_asc' ? 'selected' : '' ?>>Precio ↑</option>
        <option value="precio_desc" <?= ($datos['orden'] ?? '') === 'precio_desc' ? 'selected' : '' ?>>Precio ↓</option>

      </select>


      <!-- BOTON BUSCAR -->
      <button type="submit"
        class="bg-[#0077cc] text-white px-6 py-2 rounded-lg hover:bg-[#005fa3] transition shadow-md">
        Buscar
      </button>

    </div>
  </form>

  <!-- CATEGORIAS -->
  <aside class="categorias">
    <h3 class="text-2xl font-bold mb-4">Categorías:</h3>

    <div class="fila-categorias flex flex-wrap gap-4">
      <?php
      $cats = [
        "electronica" => "Electrónica",
        "hogar" => "Hogar",
        "bricolaje" => "Bricolaje",
        "juguetes" => "Juguetes",
        "moda" => "Moda",
        "libros" => "Libros"
      ];
      foreach ($cats as $slug => $nombre):
        ?>
        <a href="<?= RUTA_URL ?>/paginas/index?cat=<?= $slug ?>">
          <button
            class="px-5 py-3 text-lg bg-white border-2 border-[#a0b8d0] rounded-lg hover:bg-[#e6f2ff] transition shadow-sm">
            <?= $nombre ?>
          </button>
        </a>
      <?php endforeach; ?>
    </div>
  </aside>

</div>

<!-- RESULTADOS -->
<div
  class="destacados-box bg-[#e8d7ff] border-2 border-[#c7aef5] rounded-xl p-8 shadow-lg w-[calc(100%-40px)] mx-auto mt-8">

  <h3 class="text-2xl font-bold mb-6">
    Resultados para: "<?= htmlspecialchars($datos['texto']) ?>"
  </h3>

  <div class="productos flex flex-wrap justify-center gap-10">

    <?php if (!empty($datos['resultados'])): ?>
      <?php foreach ($datos['resultados'] as $p): ?>
        <a href="<?= RUTA_URL ?>/productos/detalle/<?= $p['producto_id'] ?>"
          class="producto bg-white border border-gray-300 rounded-xl p-4 shadow-md hover:shadow-xl transition transform hover:scale-105 text-center w-[200px]">

          <img src="<?= RUTA_URL ?>/img/productos/<?= $p['imagen'] ?>" alt="<?= htmlspecialchars($p['titulo']) ?>"
            class="rounded-lg mb-3 w-full h-[180px] object-contain bg-white p-2 shadow-sm">

          <p class="text-2xl font-bold"><?= $p['precio'] ?> €</p>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-lg text-gray-700">No hay productos que coincidan con la búsqueda.</p>
    <?php endif; ?>

  </div>
</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>