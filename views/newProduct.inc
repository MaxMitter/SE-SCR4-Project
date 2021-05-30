<?php $render('partial/header', $data); ?>
    <h1>New Product</h1>
    <div class="my-3">
        <?php $beginForm('Products', 'Create'); ?>
            <div class="mb-3">
                <label for="cname" class="form-label">Product name:</label>
                <input type="text" class="form-control" placeholder="Name" name="cname" id="cname" required />
            </div>
            <div class="mb-3">
                <label for="cinfo" class="form-label">Product info:</label>
                <textarea class="form-control" rows="3" id="cinfo" name="cinfo"></textarea>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col">
                        <label for="cproducer" class="form-label">Producer:</label>
                        <select class="form-select" name="cproducer" id="cproducer">
                            <?php foreach ($data['producers'] as $pr){
                                echo '<option value="'.$pr->getProducerId().'">'.
                                     $pr->getName().'</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="ccategory" class="form-label">Producer:</label>
                        <select class="form-select" name="ccategory" id="ccategory">
                            <?php foreach ($data['categories'] as $pr){
                                echo '<option value="'.$pr->getId().'">'.
                                    $pr->getName().'</option>';
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary">Submit</button>
            </div>
        <?php $endForm(); ?>
    </div>

<?php $render('partial/footer', $data); ?>