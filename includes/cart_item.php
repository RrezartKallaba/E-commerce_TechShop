<div class="cart-box">
    <p style="position: fixed; margin: -270px 40px 0px 0px; border: 1px solid #c3e6cb; color: #721c24;background-color: #f8d7da;border-color: #f5c6cb;border-radius: 7px;padding: 5px;text-align:center; display: none;" id="demo-error-quantity"></p>
    <img src="pictures/<?php echo $row['image'] ?>" alt="image" class="cart-img">
    <div class="detail-box">
        <div class="cart-product-title"><?php echo $row['name'] ?></div>
        <span style="font-size: 13px;color: rgb(203, 28, 28,1);">Product Id: <?php echo $row['product_id'] ?></span>
        <span style="font-size: 13px;color: rgb(203, 28, 28,1);"> Max quantity: <?php echo $rowQuantity['quantity'] ?></span>
        <div class="cart-price"><?php echo $row['price'] . '€' ?></div>
        <div style="display: flex;flex-direction: row;">
            <p style="font-size: 15px;padding: 0px;margin:0px;">Quantity: </p><input class="cart-quantity" type="number" name="quantity" value="<?php echo $row['quantity'] ?>" min="1" max="<?php echo $availableQuantity; ?>" onchange="quantityChanged(event)" data-product-id="<?php echo $row['product_id']; ?>" />
        </div>
    </div>
    <a href="validate/delete_cart_product.php?cart_id=<?php echo $row['cart_id']; ?>" style="display: block;border: none; margin-right: 0px; padding: 0px; color: black; text-decoration: none;">
        <i class="bx bxs-trash-alt cart-remove"></i>
    </a>

</div>