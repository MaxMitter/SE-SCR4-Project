<a href="javascript:history.go(-1)"> &#60; Back</a>
<h1><?php $htmlOut($data['product']->getName()); ?></h1>

<h5>Category: <?php $htmlOut($data['product']->getCategoryName()); ?> | created by: <?php $htmlOut($data['userName']); ?></h5>
<hr/>

<h4>Info:</h4>

<p>
    <?php $htmlOut($data['product']->getInfo()); ?>
</p>

<h4>Reviews:</h4>

<?php $hasLeftReview = false;
    if (!isset($data['user'])) {
        $hasLeftReview = true;
    } else {
        foreach ($data['reviews'] as $review) {
            if ($review['userName'] == $data['user']->getUserName()) {
                $hasLeftReview = true;
                break;
            }
        }
    }
     ?>

<?php if (!$hasLeftReview): ?>
<a class="btn btn-primary mb-2" data-bs-toggle="collapse" href="#newReview" role="button" aria-expanded="<?php echo isset($data['errors']); ?>" aria-controls="newReview">
    Add Review
</a>

<div class="collapse" id="newReview">
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <?php $beginForm('Review', 'NewReview') ?>
                <?php if (isset($data['errors'])) {?>
                    <p style="color: #bb2d3b"><?php $htmlOut($data['errors'][0]); ?></p>
                <?php }?>
                <label for="ctext" class="form-label">Text</label>
                <textarea class="form-control" id="ctext" name="ctext" cols="2"></textarea>
                <label for="crating" class="form-label">Rating</label>
                <select name="crating" id="crating" class="form-select">
                    <option value="1">1 - very bad</option>
                    <option value="2">2 - bad</option>
                    <option value="3">3 - medium</option>
                    <option value="4">4 - good</option>
                    <option value="5">5 - very good</option>
                </select>
                <input type="hidden" name="cproductId" value="<?php $htmlOut($data['product']->getProductId()); ?>" />
                <input type="hidden" name="cuserId" value="<?php $htmlOut($data['user']->getId()); ?>" />
                <button class="btn btn-primary form-control mt-2">Submit</button>
            <?php $endForm(); ?>
        </div>
    </div>
</div>

<?php endif; ?>

<?php foreach ($data['reviews'] as $review): ?>

    <?php $render('partial/reviewCard', $review); ?>

<?php endforeach; ?>
