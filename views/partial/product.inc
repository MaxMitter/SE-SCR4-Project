<?php if (isset($data['breadcrumb'])): ?>
<a href="<?php $htmlOut($data['breadcrumb']); ?>"> &#60; Back</a>
<?php endif; ?>
<h1><?php $htmlOut($data['product']->getName()); ?></h1>

<h5>Category: <?php $htmlOut($data['product']->getCategoryName()); ?> | created by: <?php $htmlOut($data['userName']); ?></h5>
<hr/>

<h4>Info:</h4>

<p>
    <?php $htmlOut($data['product']->getInfo()); ?>
</p>

<h4>Reviews:</h4>

<?php foreach ($data['reviews'] as $review): ?>

    <?php $render('partial/reviewCard', $review); ?>

<?php endforeach; ?>
