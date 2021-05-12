<?php $render('partial/header', $data); ?>

<h1>Order Form</h1>
<p>You have <?php $htmlOut($data['cartSize']); ?> item(s) in your cart.</p>
<p>Please provide your credit card details for payment:</p>
<?php $beginForm('Order', 'Create', method: 'post'); ?>
  <div class="mb-3">
    <label for="nameOnCard" class="form-label">Name on card</label>
    <input class="form-control" id="nameOnCard" name="noc" value="<?php $htmlOut($data['nameOnCard']); ?>">
  </div>
  <div class="mb-3">
    <label for="cardNumber" class="form-label">Card number</label>
    <input class="form-control" id="cardNumber" name="cn" value="<?php $htmlOut($data['cardNumber']); ?>">
  </div>
  <button class="btn btn-primary">Place order</button>
<?php $endForm(); ?>

<?php $render('partial/footer', $data); ?>