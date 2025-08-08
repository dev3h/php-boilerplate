<?php $errors = flash('errors'); ?>
<form action="<?php echo route('product.store') ?>" method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo old('name') ?>" required>
        <?php if (isset($errors['name'][0])): ?>
            <div class="error"><?php echo $errors['name'][0] ?></div>
        <?php endif; ?>
    </div>
    
   <div>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo old('price') ?>" required>
        <?php if (isset($errors['price'])): ?>
            <div class="error"><?php echo implode(', ', $errors['price']); ?></div>
        <?php endif; ?>
   </div>
    
    <button type="submit">Create</button>
</form>