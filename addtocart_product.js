// Attach a click event listener to the button
addToCartButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior
  
    quantities.forEach(quantityId => {
      const checkbox = document.getElementById("checkbox_" + quantityId.slice(9));
      const quantity = document.getElementById(quantityId);
  
      if (!checkbox.checked) {
        quantity.value = 1;
      }
    });
  
    const selectedOption = card.options[card.selectedIndex];
    const dataId = selectedOption.getAttribute('data-id');
    console.log('Selected data-id:', dataId);
  
    const id = dataId;
    const quantity = 1;
    const text = textArea.value;
    const properties = {
      'Card Message': text
    };
  
    //const data = JSON.stringify({ id: id, quantity: quantity, properties: properties });
    const data = JSON.stringify({ id: id, quantity: quantity });
    addToCart(data, event.target.closest('form'));
  
    // Resume the form submission after setting quantities
    //event.target.closest('form').submit();
    //event.form.submit();
  });
  
  
  function addToCart(data, form) {
      // Perform an AJAX request to add the product to the cart
      fetch(window.Shopify.routes.root + 'cart/add.js', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: data
        })
        .then(response => {
          // Return the response as a JSON object
          return response.json();
        })
        .then(data => {
          // Refresh the page to reflect the updated cart
          //location.reload();
          form.submit();
        })
        .catch((error) => {
          // Log the error in the console
          console.error('Error:', error);
        });
    }