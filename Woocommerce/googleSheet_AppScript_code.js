const spreadsheetIds = {
  giftcard: '115BtTB0gq8y3lm71HoOXhXDS1vfKhb_APMp3MuLGbqk',
  rhinos: '1FNNKmNt4ZXGw8xZMLLb6T6ZuBLFrdbffnAEuAFN3R0E',
  rbirewards: '1eS5-QaEzfZZn77rtMdm_aML1kCpnhtRGkRWtD5xyamQ',
  rhinosCopy: '1yQIGb9QEYTY25VOCUw6Wrx9LthYEVGp6go2eYyKfIg8',
  rbiAcademy: '1tidlEcGciigxIwlGKY8dn_WRc1hsal-GxnLYT-zIHZA',
  rbiAcademyCopy: '1r-HSrkofYjuOQWUvMtNXqpuBOrSg275WMHzaJqb7Iv4',
  schoolHoliday: '1P522scJUvJUKzhE_dpva3zAC5rDxTOGCyB8hj4W9MmA',
  tball: '1Io6ERHyOI4NTmv1m2UrqhVLp0N3AtWST4WYAGPineBM',
  couponCode: '1CTUppFmDZpUK_JYQBQYSO8_5YaNz321-TC4glOuKGbM'
};

const sheetNames = {
  giftcard: 'Sheet1',
  rhinos: 'sheet1',
  rbirewards: 'Sheet1',
  rhinosCopy: 'sheet1',
  rbiAcademy: 'Sheet1',
  rbiAcademyCopy: 'Sheet1',
  schoolHoliday: 'Sheet1',
  tball: 'Sheet1',
  couponCode: 'Sheet1'
};

const textToCheck = [
  "sw rhinos slicker",
  "sw rhinos training shirt",
  "sw rhinos training shorts",
  "sw rhinos jersey",
  "sw rhinos hoodie"
];

const couponToCheck = [
  "testonly101",
  "katetest"
];

function doPost(e) {
  const data = JSON.parse(e.postData.contents);
  const productNames = data.line_items.map(item => item.name.toLowerCase());
  const couponCodeUse = data.coupon_lines.length > 0 ? data.coupon_lines[0].code : 'N/A';

  const orderHas = {
    giftVouchers: productNames.some(name => name.includes("rbi online gift vouchers")),
    rhinos: productNames.some(name => textToCheck.some(text => name.includes(text))),
    rbiDiscount: data.fee_lines.some(fee => fee.name.toLowerCase().includes("rbi member")),
    rhinosCopy: productNames.some(name => textToCheck.some(text => name.includes(text))),
    rbiAcademy: productNames.some(name => name.includes("rbi academy 8 week")),
    schoolHoliday: productNames.some(name => name.includes("rbi academy school")),
    tball: productNames.some(name => name.includes("rbi academy t-ball")),
    couponCode: couponToCheck.includes(couponCodeUse)
  };

  const updateGiftcard = (sheet, orderRow, orderStatusToCheck) => {
    if (orderRow) {
      sheet.getRange(orderRow, 3).setValue(orderStatusToCheck);
    } else {
      var orderDate = new Date(data.date_created);
      var orderId = data.id;
      var orderStatus = data.status;
      var customerName = data.billing.first_name + ' ' + data.billing.last_name;
      var customerEmail = data.billing.email;
      var rawJsonString = JSON.stringify(data);
      
      
      let lastRow = 2; // Set to the second row (the top of the spreadsheet)
      sheet.insertRowBefore(lastRow); // Insert a new row at the top
      
      sheet.getRange(lastRow, 1).setValue(orderId);
      sheet.getRange(lastRow, 2).setValue(orderDate);
      sheet.getRange(lastRow, 3).setValue(orderStatus);
      sheet.getRange(lastRow, 4).setValue(customerName);
      sheet.getRange(lastRow, 5).setValue(customerEmail);
      //sheet.getRange(lastRow, 10).setValue(rawJsonString);

      // Set line items
      data.line_items.forEach((item, index) => {
        const gcQuantity = item.quantity;
        const gcValue = item.meta_data.find(meta => meta.key === 'pa_value');
        const gcType = item.meta_data.find(meta => meta.key === 'pa_voucher-type');
        
        sheet.getRange(lastRow, 6).setValue(gcQuantity);
        sheet.getRange(lastRow, 7).setValue(gcValue.display_value);
        sheet.getRange(lastRow, 8).setValue(gcType.display_value);

        if (index < data.line_items.length - 1) {
          // Insert a row before the next item, unless it's the last item
          lastRow++;
          sheet.insertRowBefore(lastRow);
        }
      });
    }
  };
/*
  const updateRhinos = (sheet, orderRow, orderStatusToCheck) => {
    if (orderRow) {
      sheet.getRange(orderRow, 3).setValue(orderStatusToCheck);
      if (orderStatusToCheck === 'cancelled'){
        updateSpreadsheet(spreadsheetIds.rhinosCopy, sheetNames.rhinosCopy, updateRhinosCopy);
      }
    } else {
      // Extract order details (rest of your existing code)
      const orderId = data.id;
      const orderDate = new Date(data.date_created);
      const orderStatus = data.status;
      const customerName = data.billing.first_name + ' ' + data.billing.last_name;
      const customerPhone = data.billing.phone;
      const customerEmail = data.billing.email;
      const shippingAddress = data.shipping.address_1 + ' ' + data.shipping.address_2 + ' ' + data.shipping.city + ' ' + data.shipping.state + ' ' + data.shipping.postcode + ' ' + data.shipping.country;
      const shippingMethod = data.shipping_lines[0].method_title; // Assuming there's only one shipping line
      const shippingPrice = data.shipping_lines[0].total; 
      const shippingTax = data.shipping_lines[0].total_tax;
      const shippingCost = parseFloat(shippingPrice) + parseFloat(shippingTax);
      const totalItemsTax = data.total_tax;
      const totalItemsPrice = data.total;
      const paymentMethod = data.payment_method + ' ' + data.payment_method_title;
      const paymentStatus = data.payment_status; // Add payment status
      const discountCode = data.coupon_lines.length > 0 ? data.coupon_lines[0].code : 'N/A';
      const discountAmount = data.coupon_lines.length > 0 ? parseFloat(data.coupon_lines[0].discount) : 0;
      const discountTax = data.coupon_lines.length > 0 ? parseFloat(data.coupon_lines[0].discount_tax) : 0;
      const discountTotal = discountAmount + discountTax;
      const jerseyDetail = data.meta_data.find(item => item.key === 'jersey_details');

      
      let lastRow = 2; 
      sheet.insertRowBefore(lastRow); // Insert a new row at the top
      sheet.getRange(lastRow, 1).setValue(orderId);
      sheet.getRange(lastRow, 2).setValue(orderDate);
      sheet.getRange(lastRow, 3).setValue(orderStatus);
      sheet.getRange(lastRow, 4).setValue(customerName);
      sheet.getRange(lastRow, 5).setValue(customerPhone);
      sheet.getRange(lastRow, 6).setValue(customerEmail);
      sheet.getRange(lastRow, 7).setValue(shippingAddress); 
      sheet.getRange(lastRow, 8).setValue(shippingMethod); 
      sheet.getRange(lastRow, 9).setValue(shippingCost); 
      sheet.getRange(lastRow, 13).setValue(totalItemsPrice);
      sheet.getRange(lastRow, 14).setValue(paymentMethod); 
      sheet.getRange(lastRow, 15).setValue(discountCode);  
      sheet.getRange(lastRow, 16).setValue(discountTotal);       
      sheet.getRange(lastRow, 17).setValue(jerseyDetail ? jerseyDetail.value : "N/A");

      data.line_items.forEach(function(item, index) {
        var productName = item.name;
        var productQuantity = item.quantity;
        var productPrice = parseFloat(item.subtotal) + parseFloat(item.subtotal_tax);
        var productSize = item.meta_data.find(item => item.key === 'pa_size');
 
        sheet.getRange(lastRow, 10).setValue(productName.includes('Jersey') ? productName + ' Jersey Surname: ' + jerseyDetail.value : productName);       
        sheet.getRange(lastRow, 11).setValue(productQuantity); // Product Quantity
        sheet.getRange(lastRow, 12).setValue(productPrice); // Product Price        
        sheet.getRange(lastRow, 18).setValue(productSize ? productSize.value : "N/A");

        if (index < data.line_items.length - 1) {
          // Insert a row before the next item, unless it's the last item
          lastRow++;
          sheet.insertRowBefore(lastRow);
        }
      });
      updateSpreadsheet(spreadsheetIds.rhinosCopy, sheetNames.rhinosCopy, updateRhinosCopy);
    }
  };

  const updateRhinosCopy = (sheet, orderRow, orderStatusToCheck) => {
    var statusCheck = data.status;
    const sizeToColumnMap = {
      jerseysizeToColumn: {'29998': 2,'29999': 3,'30000': 4,'30001': 5,'30002': 6,'30003': 7,'30004': 8,'30005': 9,'30006': 10,'30007': 11,'30008': 12,'30009': 13,'30010': 14},
      shirtsizeToColumn: {'29979': 2,'29980': 3,'29981': 4,'29982': 5,'29983': 6,'29984': 7,'29985': 8,'29986': 9,'29987': 10,'29988': 11,'29989': 12,'29990': 13,'29991': 14,'29992': 15,'29993': 16},
      shortsizeToColumn: {'30014': 2,'30015': 3,'30016': 4,'30017': 5,'30018': 6,'30019': 7,'30020': 8,'30021': 9,'30022': 10,'30023': 11,'30024': 12,'30025': 13},
      slickersizeToColumn: {'30029': 2,'30030': 3,'30031': 4,'30032': 5,'30033': 6,'30034': 7,'30035': 8,'30036': 9,'30037': 10,'30038': 11},
      hoodiesizeToColumn: {'28829': 2,'28830': 3,'28831': 4,'28832': 5,'28833': 6,'28834': 7,'28835': 8,'28836': 9,'28837': 10,'28838': 11,'28839': 12,'28840': 13,'28841': 14,'28842': 15}
    };

    function updateQuantity(productName, variantId, productQuantity, rowIndexOffset, status) {
      const sizeMap = sizeToColumnMap[productName];
      if (sizeMap && variantId) {
        const columnIndex = sizeMap[variantId];
        if (columnIndex) {
          const currentQty = sheet.getRange(rowIndexOffset, columnIndex).getValue();
          let newQty = parseInt(currentQty);

          if (status === 'processing' || status === 'on-hold' ) {
            newQty = newQty + parseInt(productQuantity); // Add quantity for processing status
          } else if (status === 'cancelled') {
            if (newQty > 0) {
              newQty = newQty - parseInt(productQuantity); // Deduct quantity for cancelled status
            } else {
              newQty = -1; // Set to -1 if current quantity is already zero
            }
          }
          sheet.getRange(rowIndexOffset, columnIndex).setValue(newQty >= 0 ? newQty : 0);
        }
      }
    }

    data.line_items.forEach(function(item) {
      const productName = item.name;
      const productQuantity = item.quantity;
      const variantId = item.variation_id;

      if (productName.includes('Jersey')) {
        updateQuantity('jerseysizeToColumn', variantId, productQuantity, 3, statusCheck);
      } else if (productName.includes('Training Shirt')) {
        updateQuantity('shirtsizeToColumn', variantId, productQuantity, 6, statusCheck);
      } else if (productName.includes('Training Shorts')) {
        updateQuantity('shortsizeToColumn', variantId, productQuantity, 9, statusCheck);
      } else if (productName.includes('Slicker')) {
        updateQuantity('slickersizeToColumn', variantId, productQuantity, 12, statusCheck);
      } else if (productName.includes('Hoodie')) {
        updateQuantity('hoodiesizeToColumn', variantId, productQuantity, 15, statusCheck);
      }
    });      
  };
*/  
  const updateRbiRewards = (sheet, orderRow, orderStatusToCheck) => {
    if (!orderRow) {
      var orderDate = new Date(data.date_created);
      var orderId = data.id;
      var customerName = data.billing.first_name + ' ' + data.billing.last_name;
      var customerEmail = data.billing.email;
      var totalItemsPrice = data.total;
      var rawJsonString = JSON.stringify(data);

      var lastRow = 2; // Set to the second row (the top of the spreadsheet)
      sheet.insertRowBefore(lastRow); // Insert a new row at the top

      data.fee_lines.forEach(function(fee) {
        var feeName = fee.name;
        var feeAmount = fee.total;

        if (feeName.toLowerCase().includes("rbi member")) {
          sheet.getRange(lastRow, 5).setValue(feeName); // Fee Name
          sheet.getRange(lastRow, 6).setValue(feeAmount); // Fee Amount
          //rowOffset++;
        }
      });
      
      sheet.getRange(lastRow, 1).setValue(orderId);
      sheet.getRange(lastRow, 2).setValue(orderDate);
      sheet.getRange(lastRow, 3).setValue(customerName);
      sheet.getRange(lastRow, 4).setValue(customerEmail);
      sheet.getRange(lastRow, 7).setValue(totalItemsPrice);
      sheet.getRange(lastRow, 10).setValue(rawJsonString);
    }  
  };

  const updateRbiAcademy = (sheet, orderRow, orderStatusToCheck) => {
    if (orderRow) {
      sheet.getRange(orderRow, 3).setValue(orderStatusToCheck);
      if (orderStatusToCheck == 'cancelled'){
        updateSpreadsheet(spreadsheetIds.rbiAcademyCopy, sheetNames.rbiAcademyCopy, updateRbiAcademyCopy);
      }
    } else {
      var orderDate = new Date(data.date_created);
      var orderId = data.id;
      var orderStatus = data.status;
      var customerName = data.billing.first_name + ' ' + data.billing.last_name;
      var customerEmail = data.billing.email;
      var rawJsonString = JSON.stringify(data);

      var metaDataList = data.meta_data || [];

      // Define a mapping of keys to variables
      var keyToVariableMap = {
          'custom_playername': 'customPlayerName',
          'custom_playerclub': 'customPlayerClub',
          'custom_playerdateofbirth': 'customPlayerDateOfBirth',
          'custom_playerposition': 'customPlayerPosition',
          'custom_playerexperience': 'customPlayerExperience',
          'custom_playershirt': 'customPlayerShirt',
          'custom_playershort': 'customPlayerShort',
          'custom_parentname': 'customParentName',
          'custom_parentcontact': 'customParentContact',
          'custom_parentemail': 'customParentEmail',
          'custom_parentconsent': 'customParentConsent',
          'custom_playerconditions': 'customPlayerConditions',
          'custom_parentinfosource': 'customParentInfoSource'
      };
      // Extract custom data based on the key using the mapping
      metaDataList.forEach(function(item) {
          var key = item.key;
          var value = item.value;

          // Check if the key is in the mapping
          if (keyToVariableMap[key] !== undefined) {
              // Assign the value to the corresponding variable
              eval(keyToVariableMap[key] + ' = value');
          }
      });



      var lastRow = 2; // Set to the second row (the top of the spreadsheet)
      sheet.insertRowBefore(lastRow); // Insert a new row at the top
      
      sheet.getRange(lastRow, 1).setValue(orderId);
      sheet.getRange(lastRow, 2).setValue(orderDate);
      sheet.getRange(lastRow, 3).setValue(orderStatus);
      sheet.getRange(lastRow, 4).setValue(customerName);
      sheet.getRange(lastRow, 5).setValue(customerEmail);

      sheet.getRange(lastRow, 6).setValue(customPlayerName);
      sheet.getRange(lastRow, 7).setValue(customPlayerClub);
      sheet.getRange(lastRow, 8).setValue(customPlayerDateOfBirth);
      sheet.getRange(lastRow, 9).setValue(customPlayerPosition);
      sheet.getRange(lastRow, 10).setValue(customPlayerExperience);
      sheet.getRange(lastRow, 11).setValue(customPlayerShirt);
      sheet.getRange(lastRow, 12).setValue(customPlayerShort);
      sheet.getRange(lastRow, 13).setValue(customParentName);
      sheet.getRange(lastRow, 14).setValue(customParentContact);
      sheet.getRange(lastRow, 15).setValue(customParentEmail);
      sheet.getRange(lastRow, 16).setValue(customParentConsent);
      sheet.getRange(lastRow, 17).setValue(customPlayerConditions);
      sheet.getRange(lastRow, 18).setValue(customParentInfoSource);            
      //sheet.getRange(lastRow, 10).setValue(rawJsonString);

      updateSpreadsheet(spreadsheetIds.rbiAcademyCopy, sheetNames.rbiAcademyCopy, updateRbiAcademyCopy);
    }
  }

  const updateRbiAcademyCopy = (sheet, orderRow, orderStatusToCheck) => {
    var statusCheck = data.status;
    var orderId = data.id;

    const UniformsizeToColumn = {
        'Youth 6': 2,
        'Youth 8': 3,
        'Youth 10': 4,
        'Youth 12': 5,
        'Youth 14': 6,
        'Youth 16': 7,
        'Youth 16 / Mens XS': 7,
        'Mens S': 8,
        'Mens M': 9,
        'Mens L': 10
    };

    var metaDataList = data.meta_data || [];
    var ShirtRow = 4;
    var ShortRow = 5;

    metaDataList.forEach(function (item) {
        var key = item.key;
        var value = item.value;

        var sizeColumn = parseInt(UniformsizeToColumn[value]);
        var newqty = 0;

        if (key === 'custom_playershirt' || key === 'custom_playershort') {
            var currentQty = sheet.getRange(key === 'custom_playershirt' ? ShirtRow : ShortRow, sizeColumn).getValue();
        }

        

        switch (statusCheck) {
            case 'processing':
                if (key === 'custom_playershirt' || key === 'custom_playershort') {
                    newqty = parseInt(currentQty) + 1;
                }
                break;
            case 'cancelled':
                if (key === 'custom_playershirt' || key === 'custom_playershort') {
                    newqty = Math.max(currentQty - 1, 0);  // Ensure newqty is non-negative
                }
                break;
            // Add more cases for other order statuses if needed
            default:
                // If no cases match, set newqty to currentqty
                newqty = currentQty;
        }

        if (key === 'custom_playershirt') {
            sheet.getRange(ShirtRow, sizeColumn).setValue(newqty);
            //orderShirtsize = value;
        }
        if (key === 'custom_playershort') {
            sheet.getRange(ShortRow, sizeColumn).setValue(newqty);
            //orderShortsize = value;
        }
    });
  }

  const updateSchoolHoliday = (sheet, orderRow, orderStatusToCheck) => {
    if (orderRow) {
      sheet.getRange(orderRow, 3).setValue(orderStatusToCheck);
    } else {
      var orderDate = new Date(data.date_created);
      var orderId = data.id;
      var orderStatus = data.status;
      var customerName = data.billing.first_name + ' ' + data.billing.last_name;
      var customerEmail = data.billing.email;
      //var rawJsonString = JSON.stringify(data);

      var metaDataList = data.meta_data || [];

      // Define a mapping of keys to variables
      var keyToVariableMap = {
          'custom_playername': 'customPlayerName',
          'custom_playerclub': 'customPlayerClub',
          'custom_playerdateofbirth': 'customPlayerDateOfBirth',
          'custom_playerposition': 'customPlayerPosition',
          'custom_playerexperience': 'customPlayerExperience',
          'custom_parentname': 'customParentName',
          'custom_parentcontact': 'customParentContact',
          'custom_parentemail': 'customParentEmail',
          'custom_parentconsent': 'customParentConsent',
          'custom_playerconditions': 'customPlayerConditions',
          'custom_parentinfosource': 'customParentInfoSource',
          'custom_playeragegroup': 'customPlayerAgeGroup'
      };
      // Extract custom data based on the key using the mapping
      metaDataList.forEach(function(item) {
          var key = item.key;
          var value = item.value;

          // Check if the key is in the mapping
          if (keyToVariableMap[key] !== undefined) {
              // Assign the value to the corresponding variable
              eval(keyToVariableMap[key] + ' = value');
          }
      });



      var lastRow = 2; // Set to the second row (the top of the spreadsheet)
      sheet.insertRowBefore(lastRow); // Insert a new row at the top
      
      sheet.getRange(lastRow, 1).setValue(orderId);
      sheet.getRange(lastRow, 2).setValue(orderDate);
      sheet.getRange(lastRow, 3).setValue(orderStatus);
      sheet.getRange(lastRow, 4).setValue(customerName);
      sheet.getRange(lastRow, 5).setValue(customerEmail);

      sheet.getRange(lastRow, 6).setValue(customPlayerName);
      sheet.getRange(lastRow, 7).setValue(customPlayerClub);
      sheet.getRange(lastRow, 8).setValue(customPlayerDateOfBirth);
      sheet.getRange(lastRow, 9).setValue(customPlayerPosition);
      sheet.getRange(lastRow, 10).setValue(customPlayerExperience);
      sheet.getRange(lastRow, 11).setValue(customPlayerAgeGroup);
      sheet.getRange(lastRow, 12).setValue(customParentName);
      sheet.getRange(lastRow, 13).setValue(customParentContact);
      sheet.getRange(lastRow, 14).setValue(customParentEmail);
      sheet.getRange(lastRow, 15).setValue(customParentConsent);
      sheet.getRange(lastRow, 16).setValue(customPlayerConditions);
      sheet.getRange(lastRow, 17).setValue(customParentInfoSource);            
      //sheet.getRange(lastRow, 18).setValue(rawJsonString);
    }
  }

  const updateTBall = (sheet, orderRow, orderStatusToCheck) => {
    if (orderRow) {
      sheet.getRange(orderRow, 3).setValue(orderStatusToCheck);

    } else {
      var orderDate = new Date(data.date_created);
      var orderId = data.id;
      var orderStatus = data.status;
      var customerName = data.billing.first_name + ' ' + data.billing.last_name;
      var customerEmail = data.billing.email;
      //var rawJsonString = JSON.stringify(data);

      var metaDataList = data.meta_data || [];

      // Define a mapping of keys to variables
      var keyToVariableMap = {
          'custom_playername': 'customPlayerName',
          'custom_playerclub': 'customPlayerClub',
          'custom_playerdateofbirth': 'customPlayerDateOfBirth',
          'custom_playerposition': 'customPlayerPosition',
          'custom_playerexperience': 'customPlayerExperience',
          'custom_parentname': 'customParentName',
          'custom_parentcontact': 'customParentContact',
          'custom_parentemail': 'customParentEmail',
          'custom_parentconsent': 'customParentConsent',
          'custom_playerconditions': 'customPlayerConditions',
          'custom_parentinfosource': 'customParentInfoSource'
      };
      // Extract custom data based on the key using the mapping
      metaDataList.forEach(function(item) {
          var key = item.key;
          var value = item.value;

          // Check if the key is in the mapping
          if (keyToVariableMap[key] !== undefined) {
              // Assign the value to the corresponding variable
              eval(keyToVariableMap[key] + ' = value');
          }
      });



      var lastRow = 2; // Set to the second row (the top of the spreadsheet)
      sheet.insertRowBefore(lastRow); // Insert a new row at the top
      
      sheet.getRange(lastRow, 1).setValue(orderId);
      sheet.getRange(lastRow, 2).setValue(orderDate);
      sheet.getRange(lastRow, 3).setValue(orderStatus);
      sheet.getRange(lastRow, 4).setValue(customerName);
      sheet.getRange(lastRow, 5).setValue(customerEmail);

      sheet.getRange(lastRow, 6).setValue(customPlayerName);
      sheet.getRange(lastRow, 7).setValue(customPlayerClub);
      sheet.getRange(lastRow, 8).setValue(customPlayerDateOfBirth);
      sheet.getRange(lastRow, 9).setValue(customPlayerPosition);
      sheet.getRange(lastRow, 10).setValue(customPlayerExperience);
      sheet.getRange(lastRow, 11).setValue(customParentName);
      sheet.getRange(lastRow, 12).setValue(customParentContact);
      sheet.getRange(lastRow, 13).setValue(customParentEmail);
      sheet.getRange(lastRow, 14).setValue(customParentConsent);
      sheet.getRange(lastRow, 15).setValue(customPlayerConditions);
      sheet.getRange(lastRow, 16).setValue(customParentInfoSource);            
      //sheet.getRange(lastRow, 19).setValue(rawJsonString);

    }
  }

  const updateCouponCode = (sheet, orderRow, orderStatusToCheck) => {
    if (!orderRow) {
      const orderId = data.id;
      const orderDate = new Date(data.date_created);
      const customerName = data.billing.first_name + ' ' + data.billing.last_name;
      const customerEmail = data.billing.email;
      const totalItemsPrice = data.total;
      const paymentMethod = data.payment_method + ' ' + data.payment_method_title;
      const discountCode = data.coupon_lines[0].code;
      const discountTotal = parseFloat(data.coupon_lines[0].discount) + parseFloat(data.coupon_lines[0].discount_tax);

      let lastRow = 2; 
      sheet.insertRowBefore(lastRow); // Insert a new row at the top
      sheet.getRange(lastRow, 1).setValue(orderId);
      sheet.getRange(lastRow, 2).setValue(orderDate);
      sheet.getRange(lastRow, 3).setValue(customerName);
      sheet.getRange(lastRow, 4).setValue(customerEmail);
      sheet.getRange(lastRow, 5).setValue(totalItemsPrice);
      sheet.getRange(lastRow, 6).setValue(paymentMethod);
      sheet.getRange(lastRow, 7).setValue(discountCode);  
      sheet.getRange(lastRow, 8).setValue(discountTotal); 
    }
  }

  const updateSpreadsheet = (spreadsheetId, sheetName, updateFunction) => {
    const sheet = SpreadsheetApp.openById(spreadsheetId).getSheetByName(sheetName);
    const orderIdToCheck = data.id;
    const orderStatusToCheck = data.status;
    const orderRow = findOrderRow(sheet, orderIdToCheck);

    if (orderRow > 0) {
      updateFunction(sheet, orderRow, orderStatusToCheck);
    } else {
      updateFunction(sheet, null);
    }
  };


  if (orderHas.giftVouchers) {
    updateSpreadsheet(spreadsheetIds.giftcard, sheetNames.giftcard, updateGiftcard);
  }

  //if (orderHas.rhinos) {
  //  updateSpreadsheet(spreadsheetIds.rhinos, sheetNames.rhinos, updateRhinos);
  //}

  if (orderHas.rbiDiscount) {
    updateSpreadsheet(spreadsheetIds.rbirewards, sheetNames.rbirewards, updateRbiRewards);
  }

  if (orderHas.rbiAcademy) {
    updateSpreadsheet(spreadsheetIds.rbiAcademy, sheetNames.rbiAcademy, updateRbiAcademy);
  }

  if (orderHas.schoolHoliday) {
    updateSpreadsheet(spreadsheetIds.schoolHoliday, sheetNames.schoolHoliday, updateSchoolHoliday);
  }
  
  if (orderHas.tball) {
    updateSpreadsheet(spreadsheetIds.tball, sheetNames.tball, updateTBall);
  }

  if (orderHas.couponCode) {
    updateSpreadsheet(spreadsheetIds.couponCode, sheetNames.couponCode, updateCouponCode);
  }
}

function findOrderRow(sheet, orderId) {
  const data = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (data[i][0] == orderId) {
      return i + 1;
    }
  }
  return -1;
}
