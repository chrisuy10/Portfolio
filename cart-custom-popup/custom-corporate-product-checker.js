function check_product() {
    var check_prod = setInterval(function() {
      // This function is being executed repeatedly at regular intervals
      // (the interval is set by the setInterval function, which is set to 500 milliseconds)
  
      // Create an array to store product names
      var product_names = [];
      
      // Use jQuery to select all elements with class "tags" and get the inner text of each
      $('p.tags').each(function() {
        var innerText = $(this).text();
        // Push the inner text into the product_names array
        product_names.push(innerText);
      });
      
      // Define the search text we want to look for in the product_names array
      var searchText = "corporate&catering";
      
      // Calculate the dates that we want to disable in the date picker
      var day1_to_disabled = parseInt(dd) + 1;
      var day2_to_disabled = parseInt(dd) + 2;
      
      // Loop through each item in the product_names array
      product_names.forEach(function(name) {
        // Check if the current product name includes the search text
        if (name.includes(searchText)) {
          // If the product name includes the search text, use jQuery to select all elements with class "ui-state-default"
          $('a.ui-state-default').each(function() {
            var dateText = $(this).text();              
            // Check if the date text is equal to dd, day1_to_disabled, or day2_to_disabled
            if(dateText == dd || dateText == day1_to_disabled || dateText == day2_to_disabled) {
              // If the date text matches one of the disabled dates, use jQuery to add class "ui-datepicker-unselectable ui-state-disabled" to the closest "td" element
              $(this).closest('td').addClass(' ui-datepicker-unselectable ui-state-disabled ');
            }
          });
          // Check if the value of the first element in the datepick array includes dd, day1_to_disabled, or day2_to_disabled
          if (datepick[0].value.includes(dd) || datepick[0].value.includes(day1_to_disabled) || datepick[0].value.includes(day2_to_disabled)) {
            // If the value of the first element in the datepick array matches one of the disabled dates, clear its value
            datepick[0].value = "";
            // Reset the class of the first element with class "ui-state-default ui-state-active" to "ui-state-default"
            document.getElementsByClassName("ui-state-default ui-state-active")[0].className = 'ui-state-default';
          }
        }
      });
    }, 500);
  }