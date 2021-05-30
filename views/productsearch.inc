<?php $render('partial/header', $data); ?>
<h1>Search result</h1>

<div class="my-3">
    <?php $beginForm('Products', 'Search'); ?>
        <div class="row g-3">
            <div class="col-auto">
                <input class="form-control" name="f" />
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    <?php $endForm(); ?>
</div>

<?php if ($data['products'] !== null): ?>
    <?php if (sizeof($data['products']) > 0) {
        $render('partial/products', [
            'products' => $data['products'],
            'context' => $data['context']
        ]);
    } ?>
<?php endif; ?>

<?php $render('partial/footer', $data); ?>