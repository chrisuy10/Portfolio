<?php
// Add this code snippet to your theme's functions.php file

add_action('wp_footer', 'display_popup_on_homepage');

function display_popup_on_homepage() {
    if (is_front_page()) { // Check if it's the homepage
        // Check if the transient exists
        if (!get_transient('popup_displayed')) {
            // Set the transient to indicate the popup was displayed
            set_transient('popup_displayed', true, 6 * HOUR_IN_SECONDS); // 6 hours
            
            ?>
            <!-- Popup HTML -->
            <div class="popup" id="popup" style="display: none;">
                <div class="popup-content">
                    <img src="https://rbiaustralia.com.au/wp-content/uploads/2023/12/pop-up-800-x-800-1.webp" alt="Popup Image" class="popup-image">
                    <button onclick="closePopup()" class="close-button">Continue</button>
                </div>
            </div>

            <!-- CSS -->
            <style>
                .popup {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.7); /* Darkens the background */
                    justify-content: center;
                    align-items: center; /* Align the content to the bottom */
                    z-index: 9999;
                }

                .popup-content {
                    position: relative;
                    text-align: center;                
                }

                .popup-image {
                    max-width: 75%;
                    max-height: 75%;
                    display: inline-block;
                }

                .close-button {
                    padding: 10px 20px;
                    background-color: #ca2026;
                    color: #fff;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 28px;
                    position: absolute;
                    bottom: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                }

                .close-button:hover {
                    background-color: #23527c;
                }
                @media screen and (max-width: 768px){
                    .close-button {
                        padding: 10px 20px;                                        
                        font-size: 24px;                    
                        bottom: 10px;                                        
                    }
                    .popup-image {
                        max-width: 95%;
                        max-height: 95%;                    
                    }
                }
            </style>

            <!-- JavaScript -->
            <script>
                function openPopup() {
                    document.getElementById("popup").style.display = "flex";
                }

                function closePopup() {
                    document.getElementById("popup").style.display = "none";
                }

                function displayPopupAfterDelay() {
                    setTimeout(openPopup, 2000); // 2000 milliseconds = 2 seconds
                }

                window.onload = displayPopupAfterDelay;
            </script>
            <?php
        }
    }
}
?>
