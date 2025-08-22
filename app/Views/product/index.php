<a href="<?php echo route('product.create') ?>">Create</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['price'] ?></td>
                <td>
                    <a href="<?php echo route('product.edit', ['id' => $product['id']]) ?>">Edit</a>
                    <a href="<?php echo route('product.delete', ['id' => $product['id']]) ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>