<?php

function item_card($productname,$proddesc,$price,$img,$productid){
    $element = "
        
<div class='col-lg-3 col-md-4 col-sm-6 my-3 '>
    <form action='menu.php' method='post'>
        <div class='card shadow'>
            <div>
                <img src='img/$img' alt='Image1' class='img-fluid card-img-top'>
            </div>
            <div class='card-body'>
                <h6 class='card-title' name='product_name'>$productname<br></h6>
                <p class='card-text'>
                $proddesc
                </p>
                <h6>
                    <span name='product_price'>Rs.$price</span>
                </h6>
                <button type='submit' class='btn btn-warning my-3' name='add'>Add to Basket  <i class='fa fa-shopping-basket'></i></button>
                <input type='hidden' name='product_id' value='$productid'>
            </div>
        </div>
    </form>
</div>
";
echo $element;
}

function cart_item($img,$productname,$price,$productid){
    $element = "
        
    <div class='border  p-3 mt-3 clearfix item'>
    <div class='row one-item'>
      <div class='col-4'>
        <img src='img/$img' alt='' class='img-fluid'>
      </div>
      <div class='col-lg-5 col-5 text-lg-left'>
        <h3 class='h6 mb-0'>$productname<br></h3>
        
      </div>
      <div class='product-price d-none'><i class='fa fa-inr' aria-hidden='true'></i>$price</div>
      <div class='pass-quantity col-lg-3 col-md-4 col-sm-3'>
      <input type='hidden' name='product_id' class = 'prodid' value='$productid'>
        <label for='pass-quantity' class='pass-quantity'>Quantity</label>
        <input class='form-control' type='number' name='qty' value='1' min='1'>
     
        </div>


      <div class='col-lg-2 col-md-1 col-sm-2 product-line-price pt-4'>
        <span class='product-line-price'><i class='fa fa-inr' aria-hidden='true'></i>$price
        </span>
      </div>
      <div class='remove-item pt-4'>
      <form action='shopcart.php?action=remove&id=$productid' method='post' class='cart-items'>

        <button type='submit' class='remove-product btn btn-danger' name='remove'><i class='fa fa-times' aria-hidden='true'></i>  Remove</button>
          
        </button>
        </form>
      </div>
    


      </div>
    </div>
";
echo $element;
}

?>