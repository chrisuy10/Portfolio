//when customer click on the popup, they will copied the discount code to clipboard and show a message that says discount code copy to clipboard.
const waitForElementLoad = (callback) => {
    const checkElementsLoaded = () => {
      const nextLoaded = document.querySelector('#sgpb-popup-dialog-main-div') !== null;
      if (nextLoaded) {
        callback(); // Execute the callback if elements are loaded
        console.log('loaded')
      } else {
        setTimeout(checkElementsLoaded, 100); // Check again after 100 milliseconds
        console.log('loading')
      }
    };
    checkElementsLoaded();
};

waitForElementLoad(() => {
    //do something
    // Set an interval to trigger the next slide every 3 seconds
    const element = document.querySelector('#sgpb-popup-dialog-main-div');
    element.addEventListener('click', function() {
      // Copy "EOFY15" to clipboard
      const textToCopy = 'EOFY15';
        console.log('mouse click')
      // Create a temporary input element
      const tempInput = document.createElement('input');
      tempInput.setAttribute('value', textToCopy);
      document.body.appendChild(tempInput);

      // Select the text in the input element
      tempInput.select();
      tempInput.setSelectionRange(0, 99999); // For mobile devices

      // Copy the selected text to clipboard
      document.execCommand('copy');

      // Remove the temporary input element
      document.body.removeChild(tempInput);

      // Alert the user that the text has been copied
      //alert('Coupon Code "EOFY15" has been copied to your clipboard!');

        const statusMessage = document.createElement('div');
        statusMessage.textContent = 'Coupon code copied!';
        statusMessage.style.marginTop = '10px';
        statusMessage.style.color = '#F27622'; // Set font color to #F27622
        statusMessage.style.fontSize = '18px'; // Set font size to 16px
        element.parentNode.appendChild(statusMessage);
    });
});