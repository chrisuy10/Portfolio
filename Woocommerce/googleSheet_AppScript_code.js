var SPREADSHEET_ID = '1FNNKmNt4ZXGw8xZMLLb6T6ZuBLFrdbffnAEuAFN3R0E';
var SHEET_NAME = 'Sheet1';

// Define the specific text strings to check for in product names
var textToCheck = [
  "SW Rhinos Slicker",
  "SW Rhinos Training Shirt",
  "SW Rhinos Training Shorts",
  "SW Rhinos Jersey",
  "SW Rhinos Hoodie"
];


function doPost(e) {
  var sheet = SpreadsheetApp.openById(SPREADSHEET_ID).getSheetByName(SHEET_NAME);
  var data = JSON.parse(e.postData.contents);

  // Extract product details
  var productNames = data.line_items.map(function (item) {
    return item.name;
  });

  // Check if any of the product names contain the specific text
  var shouldSaveOrder = productNames.some(function (productName) {
    return textToCheck.some(function (text) {
      return productName.includes(text);
    });
  });

  var orderId_tocheck = data.id;
  var orderStatus_tocheck = data.status;

  // Search for the row in the spreadsheet that matches the order ID
  var orderRow = findOrderRow(sheet, orderId_tocheck);

  if (orderRow > 0) {
    // Update the order status in the corresponding row
    sheet.getRange(orderRow, 3).setValue(orderStatus_tocheck);
  }else{

    if (shouldSaveOrder) {
      // Extract order details (rest of your existing code)
      var orderId = data.id;
      var orderDate = new Date(data.date_created);
      var orderStatus = data.status;
      var customerName = data.billing.first_name + ' ' + data.billing.last_name;
      var customerPhone = data.billing.phone;
      var customerEmail = data.billing.email;
      var shippingAddress = data.shipping.address_1 + ' ' + data.shipping.address_2 + ' ' + data.shipping.city + ' ' + data.shipping.state + ' ' + data.shipping.postcode + ' ' + data.shipping.country;
      var shippingMethod = data.shipping_lines[0].method_title; // Assuming there's only one shipping line
      var shippingPrice = data.shipping_lines[0].total; // Assuming there's only one shipping line
      var shippingTax = data.shipping_lines[0].total_tax;
      var totalItemsTax = data.total_tax;
      var totalItemsPrice = data.total;
      var paymentMethod = data.payment_method + ' ' + data.payment_method_title;
      var paymentStatus = data.payment_status; // Add payment status
      var discountCode = data.coupon_lines.length > 0 ? data.coupon_lines[0].code : 'N/A';
      var discountAmount = data.coupon_lines.length > 0 ? parseFloat(data.coupon_lines[0].discount) : 0;
      var discountTax = data.coupon_lines.length > 0 ? parseFloat(data.coupon_lines[0].discount_tax) : 0;
      var discountTotal = discountAmount + discountTax;
      var jerseyDetail = data.meta_data.find(item => item.key === 'jersey_details');

      // Set order details in the spreadsheet cells
      var lastRow = 2; // Set to the second row (the top of the spreadsheet)
      sheet.insertRowBefore(lastRow); // Insert a new row at the top
      sheet.getRange(lastRow, 1).setValue(orderId);
      sheet.getRange(lastRow, 2).setValue(orderDate);
      sheet.getRange(lastRow, 3).setValue(orderStatus);
      sheet.getRange(lastRow, 4).setValue(customerName);
      sheet.getRange(lastRow, 5).setValue(customerPhone);
      sheet.getRange(lastRow, 6).setValue(customerEmail);
      sheet.getRange(lastRow, 7).setValue(shippingAddress); 
      sheet.getRange(lastRow, 8).setValue(shippingMethod); 
      sheet.getRange(lastRow, 9).setValue(shippingPrice); 
      sheet.getRange(lastRow, 10).setValue(shippingTax); 
      sheet.getRange(lastRow, 14).setValue(totalItemsPrice);
      sheet.getRange(lastRow, 15).setValue(totalItemsTax); 
      sheet.getRange(lastRow, 16).setValue(paymentMethod); 
      sheet.getRange(lastRow, 17).setValue(paymentStatus);
      sheet.getRange(lastRow, 18).setValue(discountCode); 
      //sheet.getRange(lastRow, 15).setValue(discountAmount); 
      //sheet.getRange(lastRow, 16).setValue(discountTax); 
      sheet.getRange(lastRow, 19).setValue(discountTotal); 
      
      if (jerseyDetail) {
        sheet.getRange(lastRow, 20).setValue(jerseyDetail.value);
      } else {
        sheet.getRange(lastRow, 20).setValue("N/A");
      }


      // Extract and add product details to separate rows
      data.line_items.forEach(function(item, index) {
        var productName = item.name;
        var productQuantity = item.quantity;
        var productPrice = item.price;
        var productSize = item.meta_data.find(item => item.key === 'pa_size');
 
        if (productName.includes('Jersey')){
          sheet.getRange(lastRow, 11).setValue(productName + ' Jersey Surname: ' + jerseyDetail.value); // Product Name
        } else {
          sheet.getRange(lastRow, 11).setValue(productName); // Product Name
        } 
        
        sheet.getRange(lastRow, 12).setValue(productQuantity); // Product Quantity
        sheet.getRange(lastRow, 13).setValue(productPrice); // Product Price
        
        if (productSize) {
          sheet.getRange(lastRow, 21).setValue(productSize.value);
        } else {
          sheet.getRange(lastRow, 21).setValue("N/A");
        }

        if (index < data.line_items.length - 1) {
          // Insert a row before the next item, unless it's the last item
          lastRow++;
          sheet.insertRowBefore(lastRow);
        }
      });


    } 
  } 
}

function findOrderRow(sheet, orderId) {
  // Search for the row in the spreadsheet that contains the given order ID
  var data = sheet.getDataRange().getValues();
  for (var i = 1; i < data.length; i++) {
    if (data[i][0] == orderId) {
      return i + 1; // Adding 1 to account for header row
    }
  }
  return -1; // Order ID not found in the spreadsheet
}

