const waitForElementLoad = (callback) => {
    const checkElementsLoaded = () => {
      const nextLoaded = document.querySelector('.slick-next') !== null;

      
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
    const nextbutton = document.querySelector('.slick-next');
    const intervalId = setInterval(function() {
      nextbutton.click();
    }, 3000);
  });

  

  