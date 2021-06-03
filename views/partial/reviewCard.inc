<?php $reviewId = $data['reviewId']; ?>

<div class="card" style="margin-bottom: 10px;">
    <div class="card-header">
        <div class="row">
            <div class="col-10">
                <h5 class="card-title">Review by <?php $htmlOut($data['userName']); ?></h5>
                <h6 class="card-subtitle"><?php $htmlOut($data['dateTime']); ?></h6>
            </div>
            <div class="col-2 d-flex justify-content-end">
                <?php if ($data['canEdit']): ?>
                <button class="btn btn-outline-success m-1" type="button" data-bs-toggle="collapse" data-bs-target=".edit-review<?php echo $reviewId; ?>" aria-controls="edit display">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                    </svg>
                </button>
                <?php $beginForm('Review', 'Delete', array(
                        'eid' => $data['reviewId']
                )); ?>
                <button class="btn btn-outline-danger m-1" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </button>
                <?php $endForm(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="edit-review<?php echo $reviewId; ?> show" id="display">
            <p class="card-text"><?php $htmlOut($data['text']); ?></p>
            <?php $total = 5; for ($i = 1; $i <= $data['value']; $i++): ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
            <?php $total--; endfor;
            for ($i = 1; $i <= $total; $i++): ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                </svg>
            <?php endfor; ?>
        </div>
        <div class="edit-review<?php echo $reviewId; ?> collapse" id="edit">
            <?php $beginForm('Review', 'Edit'); ?>
            <textarea class="form-control" rows="3" id="etext" name="etext"><?php $htmlOut($data['text']); ?></textarea>
            <input type="hidden" name="eid" value="<?php $htmlOut($data['reviewId']); ?>">
            <div class="row mt-3">
                <div class="col-6">
                    <select class="form-control form-select" name="erating">
                        <option value="1" <?php if ($data['value'] == 1) echo 'selected';?>>1 - very bad</option>
                        <option value="2" <?php if ($data['value'] == 2) echo 'selected';?>>2 - bad</option>
                        <option value="3" <?php if ($data['value'] == 3) echo 'selected';?>>3 - medium</option>
                        <option value="4" <?php if ($data['value'] == 4) echo 'selected';?>>4 - good</option>
                        <option value="5" <?php if ($data['value'] == 5) echo 'selected';?>>5 - very good</option>
                    </select>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Save review</button>
                </div>
            </div>
            <?php $endForm(); ?>
        </div>
    </div>
</div>