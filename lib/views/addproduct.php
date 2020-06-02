<h1>Add a Product</h1>
<div>
<form action='/addproduct' method='POST'>
 <input type='hidden' name='_method' value='post' />


 <label for='desc'>Description</label>
 <input type='text' id='desc' name='desc' />

 <label for='price'>Price</label>
 <input type='number' id='price' name='price' />

 <label for='col'>Colour</label>
 <input type='text' id='col' name='col' />

<label for="cate">Category:</label>
<select name="cate" id="cate">
  <option value="Common">Common</option>
  <option value="Rare">Rare</option>
  <option value="Ulra Rare">Ultra Rare</option>
</select> <br>

<label for="size">Size:</label>
<select name="size" id="size">
  <option value="Small">Small</option>
  <option value="Medium">Medium</option>
  <option value="Large">Large</option>
  <option value="Extra Large">Extra Large</option>
</select>


 <input type='submit' value='Add product' />
</form>
</div>
