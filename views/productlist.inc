<?php $render('partial/header', $data); ?>
    <h1>List of products</h1>
    
    <nav class="nav nav-pills my-3">
        <?php 
        foreach($data['categories'] as $cat) { ?>
            <?php $link($cat->getName(), 'Products', 'Index',
            array('cid' => $cat->getId()), 'nav-item nav-link' . ($cat->getId() == $data['selectedCategoryId'] ? ' active' : '')); ?>
        <?php } ?>
    </nav>

<?php if($data['selectedCategoryId'] !== null): ?>
    <?php if (sizeof($data['products']) > 0) { ?>

        <?php $render('partial/products', [
            'products' => $data['products'],
            'context' => $data['context']]); ?>

    <?php } else { ?>
        <p>No products in this category</p>
    <?php } ?>
<?php else: ?>
    <p>Please select a category</p>
<?php endif; ?>


<?php $render('partial/footer', $data); ?>