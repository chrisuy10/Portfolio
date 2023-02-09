// Add an event listener for the DOM content to be loaded - try edit - try pull
document.addEventListener('DOMContentLoaded', function() {
  
    // Add an event listener for the checkout button
    document.getElementById("checkout").addEventListener("click", function() {
      event.preventDefault(); // Prevent the default behavior of the click event
      document.getElementById("popup").style.display = "block"; // Display the popup element
      document.getElementById("background").style.display = "block"; // Display the background element
    });
    
      // Add an event listener for the add-to-cart button
    document.getElementById("add-to-cart").addEventListener("click", function() {  
      
      // Remove focus from all elements on the page
      document.querySelectorAll("*").forEach(function(element) {
        element.blur();
      });
      
      // Initialize an empty array to store the selected items
      var items = [];
      
      // Iterate over all the selected checkboxes
      $('input.checkbox:checked').each(function() {
        var idInput = $(this).closest('.col').find('input[name="id"]');
        var id = (idInput.length > 0) ? idInput[0].value : null;
    
        var quantityInput = $(this).closest('.col').find('input[name="quantity"]');
        var quantity = (quantityInput.length > 0) ? quantityInput[0].value : null;
    
        // Push the selected item's id and quantity to the items array
        items.push({ id: id, quantity: quantity });  
      });
      
      // Create a form data object to store the items array
      let formData = {
        'items': items
      };
      
      // Use fetch to send a POST request to add the items to the cart
      fetch(window.Shopify.routes.root + 'cart/add.js', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      })
      .then(response => {
        // Return the response as a JSON object
        return response.json();
      })
      .then(data => {
        // Refresh the page to reflect the updated cart
        //location.reload();
      })
      .catch((error) => {
        // Log the error in the console
        console.error('Error:', error);
      });
    });
  
  }); 
  
    //$('form.add_to_cart').on('submit', function(event){
              //debugger;
              
                
              //var postUrl = $(this).attr('action');
              //var postData = $(this).serialize('data');
  
              //console.log(postData); //check what your form posts
              
              //$.ajax({
              //    type: "POST",
              //    url: postUrl,
              //    data: postData,
              //    dataType: "json",
              //    success: function(data) {
              //        console.log('Product Added to Cart');
              //         //do other things..
              //    },
              //    error: function() {
              //       console.log('error handling here');
               //   }
              //});     
    //}); 
                            
