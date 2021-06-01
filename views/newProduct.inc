<?php $render('partial/header', $data); ?>
    <?php if (isset($data['isEdit'])): ?>
        <h1>Edit Product</h1>
    <?php else: ?>
        <h1>New Product</h1>
    <?php endif; ?>
    <div class="my-3">
        <?php
            if (isset($data['isEdit']))
                $beginForm('Products', 'Edit');
            else
                $beginForm('Products', 'Create');
            ?>
            <div class="mb-3">
                <label for="cname" class="form-label">Product name:</label>
                <input type="text" class="form-control" placeholder="Name" name="cname" id="cname" value="<?php if (isset($data['name'])) echo $data['name']; ?>" required />
            </div>
            <div class="mb-3">
                <label for="cinfo" class="form-label">Product info:</label>
                <textarea class="form-control" rows="3" id="cinfo" name="cinfo"><?php if (isset($data['info'])) echo $data['info']; else echo ''; ?></textarea>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col">
                        <label for="cproducer" class="form-label">Producer:</label>
                        <select class="form-select" name="cproducer" id="cproducer">
                            <?php foreach ($data['producers'] as $pr){
                                echo '<option value="'.$pr->getProducerId().'" '.((isset($data['cproducer']) && $data['cproducer'] == $pr->getName()) ? 'selected' : '').'>'.
                                     $pr->getName().'</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="ccategory" class="form-label">Category:</label>
                        <select class="form-select" name="ccategory" id="ccategory">
                            <?php foreach ($data['categories'] as $pr){
                                echo '<option value="'.$pr->getId().'" '.((isset($data['ccategory']) && $data['ccategory'] == $pr->getName()) ? ' selected' : '').'>'.
                                    $pr->getName().'</option>';
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <input type="hidden" name="eId" value="<?php if (isset($data['eId'])) echo $data['eId']; else echo 'help'; ?>">
                <button class="btn btn-primary">Submit</button>
            </div>
        <?php $endForm(); ?>
    </div>

<?php $render('partial/footer', $data); ?>