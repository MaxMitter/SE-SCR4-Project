<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Info</th>
            <th>Producer</th>
            <th>Rating</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data['products'] as $b): ?>
            <tr>
                <td><?php $link($b->getName(), 'Products', 'Product', array('pid' => $b->getProductId(), 'brcr' => $data['context']), 'nav-item nav-link') ?></td>
                <td><?php $htmlOut($b->getInfo()); ?></td>
                <td><?php $htmlOut($b->getProducerName()); ?></td>
                <td><?php $htmlOut($b->getRating()); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>