<?php
$title = 'Productos';
require_once __DIR__ . '/components/header.php';
?>

<body>
	<?php require_once __DIR__ . '/components/navbar.php'; ?>

	<section class="py-20 bg-gray-50">
		<div class="container mx-auto px-6">
			<h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Productos</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
				<?php foreach ($products as $product) : ?>
					<div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300">
						<div class="text-indigo-500 mb-4">
							<i class="fas fa-box
							text-4xl"></i>
						</div>
						<h3 class="text-xl font-semibold mb-2 text-gray-600"><?= $product['name'] ?></h3>
						<p class="text-gray-600">
							<?= $product['description'] ?>
						</p>
						<p class="text-gray-600 mt-4 font-semibold">
							$<?= $product['price'] ?>
						</p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</body>