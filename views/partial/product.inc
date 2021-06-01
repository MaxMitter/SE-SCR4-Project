<a href="javascript:history.go(-1)"> &#60; Back</a>
<div class="row">
    <div class="col-11">
        <h1><?php $htmlOut($data['product']->getName()); ?></h1>
    </div>
    <div class="col-1 d-flex justify-content-end">
        <?php if ($data['canEdit']):
            $beginForm('Products', 'NewProduct', array(
                    'eId' => $data['product']->getProductId(),
                    'cname' => $data['product']->getName(),
                    'cinfo' => $data['product']->getInfo(),
                    'cproducer' => $data['product']->getProducerName(),
                    'ccategory' => $data['product']->getCategoryName()
            )); ?>
            <button class="btn btn-outline-success m-1" type="submit" value="">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg>
            </button>
        <?php $endForm();

            $beginForm('Products', 'Delete', array(
                    'pid' => $data['product']->getProductId()
            )); ?>
            <button class="btn btn-outline-danger m-1" type="submit" value="">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </button>
        <?php $endForm();
                endif; ?>
    </div>
</div>

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
