$(document).ready(function(){
$(".button").click(async function() {
   var discount_code= $("#text_discount").val();
    try {
       
        const response = await $.ajax({
            url: 'https://hydrogen-test-dinesh.myshopify.com/discount/'+ discount_code,
        });

        if (response) {
      
            const res = await fetch("/?section_id=cart-drawer");
            const text = await res.text();
            const html = document.createElement("div");
            html.innerHTML = text;

            const newBox = html.querySelector("#CartDrawer").innerHTML;

            document.querySelector("#CartDrawer").innerHTML = newBox;
        } else {
            alert('discount_not_added');
        }
    } catch (error) {
        alert('An error occurred: ' + error.message);
    }
});


});