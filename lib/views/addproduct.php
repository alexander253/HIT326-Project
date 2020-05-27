<h1>Add a Product</h1>
<div>
<form action='/addproduct' method='POST'>
 <input type='hidden' name='_method' value='post' />

 <label for='num'>Product Number</label>
 <input type='number' id='num' name='num' />

 <label for='desc'>Description</label>
 <input type='text' id='desc' name='desc' />

 <label for='price'>Price</label>
 <input type='number' id='price' name='price' />

 <label for='cate'>Category</label>
 <input type='text' id='cate' name='cate' />

 <label for='col'>Colour</label>
 <input type='text' id='col' name='col' />

 <label for='size'>Size</label>
 <input type='text' id='size' name='size' />


 <input type='submit' value='Add product' />
</form>
</div>
