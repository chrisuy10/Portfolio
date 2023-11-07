//custom code for adding type of waste -chris 
$('#wastetype, #bin-address').change(function() {
    var wastetypevalue = $('#wastetype').val();
    Cookies.set("waste-type", wastetypevalue);
    
    
});


function get_wastetype(){
    var waste_type = Cookies.get("waste-type");

		// Check if the stored value exists
		if (waste_type) {
		  // Use the stored value in your function
		  return waste_type;
		} else {
		  console.log("No selected value found.");
		}
}