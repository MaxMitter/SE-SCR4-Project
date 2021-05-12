<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>In Cart</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data['books'] as $b): ?>
            <tr>
                <td><?php $htmlOut($b->getTitle()); ?></td>
                <td><?php $htmlOut($b->getAuthor()); ?></td>
                <td><?php $htmlOut($b->getPrice()); ?></td>
                <td><?php $htmlOut($b->getCartCount()); ?></td>
                <td>
                    <div class="d-flex">
                        <?php $beginForm('Cart', 'Add', array('bid' => $b->getId(), 'ctx' => $data['context']), 'post', 'form-inline'); ?>
                            <button class="btn btn-link">Add to cart</button>
                        <?php $endForm(); ?>

                        <?php if ($b->isInCart()) : ?>
                            <?php $beginForm('Cart', 'Remove', array('bid' => $b->getId(), 'ctx' => $data['context']), 'post', 'form-inline'); ?>
                                <button class="btn btn-link">Remove from cart</button>
                            <?php $endForm(); ?>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>