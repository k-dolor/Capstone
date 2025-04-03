console.log("✅ pos.js is successfully loaded!");
alert("JavaScript is working!");

function calculateChange() {
    let total = parseFloat(document.getElementById('total').textContent.replace(/[^0-9.]/g, '')) || 0;
    let pay = parseFloat(document.getElementById('pay').value) || 0;
    let change = pay - total;

    document.getElementById('change').value = change >= 0 ? `₱${change.toFixed(2)}` : "₱0.00";
}

document.getElementById("paymentForm").addEventListener("submit", function(event) {
    let total = parseFloat(document.getElementById('total').textContent.replace(/[^0-9.]/g, '')) || 0;
    let pay = parseFloat(document.getElementById('pay').value) || 0;

    if (pay < total) {
        event.preventDefault();  // Prevent form submission
        alert("Payment must be equal to or greater than the total amount!");
    }
});

// NEWWW --------------------

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".clickable-card").forEach(card => {
        card.addEventListener("click", function() {
            console.log("Adding to cart:", this.getAttribute("data-name"));

            // Create a form dynamically
            let form = document.createElement("form");
            form.method = "POST";
            form.action = addCartUrl; // Use global variable from Blade

            // CSRF Token
            let csrfInput = document.createElement("input");
            csrfInput.type = "hidden";
            csrfInput.name = "_token";
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            // Product ID
            let idInput = document.createElement("input");
            idInput.type = "hidden";
            idInput.name = "id";
            idInput.value = this.getAttribute("data-id");
            form.appendChild(idInput);

            // Product Name
            let nameInput = document.createElement("input");
            nameInput.type = "hidden";
            nameInput.name = "name";
            nameInput.value = this.getAttribute("data-name");
            form.appendChild(nameInput);

            // Product Price
            let priceInput = document.createElement("input");
            priceInput.type = "hidden";
            priceInput.name = "price";
            priceInput.value = this.getAttribute("data-price");
            form.appendChild(priceInput);

            // Append form to body and submit
            document.body.appendChild(form);
            form.submit();
        });
    });
    
    // Check if error message exists and show modal automatically
    if (document.getElementById("paymentError")) {
        var myModal = new bootstrap.Modal(document.getElementById("createInvoiceModal"));
        myModal.show(); // Show the modal automatically if an error occurs
    }
});

// ======================================================


function applyDiscount() {
// Get the selected discount value as a number (e.g., 5 for 5%)
var discountValue = parseFloat(document.getElementById("discount").value);

  // Use the same raw total that you expect
  var totalAmount = parseFloat("{{ Cart::subtotal(2, '.', '') }}");

// Calculate the discount amount (should be subtracted)
var discountAmount = (discountValue / 100) * totalAmount;

// Calculate the new total after subtracting the discount
var newTotal = totalAmount - discountAmount;

// Update the total amount in the modal (formatted to 2 decimals)
document.getElementById("total").textContent = newTotal.toFixed(2);
}




// Increase Quantity ==================

$(document).ready(function() {
    console.log("JavaScript Loaded");

    $(".increase-qty, .decrease-qty").click(function() {
        var rowId = $(this).data("rowid");
        var input = $(".qty-input[data-rowid='" + rowId + "']");
        var currentQty = parseInt(input.val());
        var newQty = $(this).hasClass("increase-qty") ? currentQty + 1 : Math.max(1, currentQty - 1);

        input.val(newQty); // Update input field instantly
        updateCart(rowId, newQty);
    });

    $(".qty-input").on("change", function() {
        var rowId = $(this).data("rowid");
        var newQty = parseInt($(this).val());

        if (newQty < 1 || isNaN(newQty)) {
            newQty = 1;
            $(this).val(newQty);
        }

        updateCart(rowId, newQty);
    });

    function updateCart(rowId, qty) {
        $.ajax({
            url: updateCartUrl.replace(':rowId', rowId), // Fix Blade Syntax issue
            type: "POST",
            data: {
                _token: csrfToken,
                qty: qty
            },
            beforeSend: function() {
                console.log("Updating cart...");
                $("#loading-spinner").show();
            },
            success: function(response) {
                console.log("Cart updated!", response);

                // Update subtotal for the product
                $(".subtotal[data-rowid='" + rowId + "']").text("₱" + response.subtotal);

                // ✅ Update cart totals in real-time
                $("#cart-subtotal").text(response.cartSubtotal);
                $("#cart-tax").text(response.cartTax);
                $("#cart-total").text(response.cartTotal);

                $("#loading-spinner").hide();
            },
            error: function(xhr, status, error) {
                console.error("Error updating cart:", xhr.responseText);
                alert("Error updating cart.");
                $("#loading-spinner").hide();
            }
        });
    }
});

$(document).ready(function() {
    console.log("JavaScript Loaded");

    $(".increase-qty, .decrease-qty").click(function() {
        var rowId = $(this).data("rowid");
        var input = $(".qty-input[data-rowid='" + rowId + "']");
        var currentQty = parseInt(input.val());
        var newQty = $(this).hasClass("increase-qty") ? currentQty + 1 : Math.max(1, currentQty - 1);

        input.val(newQty); // Update input field instantly
        updateCart(rowId, newQty);
    });

    $(".qty-input").on("change", function() {
        var rowId = $(this).data("rowid");
        var newQty = parseInt($(this).val());

        if (newQty < 1 || isNaN(newQty)) {
            newQty = 1;
            $(this).val(newQty);
        }

        updateCart(rowId, newQty);
    });

    function updateCart(rowId, qty) {
        $.ajax({
            url: updateCartUrl.replace(':rowId', rowId), // Fix Blade Syntax issue
            type: "POST",
            data: {
                _token: csrfToken,
                qty: qty
            },
            beforeSend: function() {
                console.log("Updating cart...");
                $("#loading-spinner").show();
            },
            success: function(response) {
                console.log("Cart updated!", response);

                // Update subtotal for the product
                $(".subtotal[data-rowid='" + rowId + "']").text("₱" + response.subtotal);

                // ✅ Update cart totals in real-time
                $("#cart-subtotal").text(response.cartSubtotal);
                $("#cart-tax").text(response.cartTax);
                $("#cart-total").text(response.cartTotal);

                $("#loading-spinner").hide();
            },
            error: function(xhr, status, error) {
                console.error("Error updating cart:", xhr.responseText);
                alert("Error updating cart.");
                $("#loading-spinner").hide();
            }
        });
    }
});


//*PAY NOW LESS THAN TOTAL --------//
function calculateChange() {
        let total = parseFloat(document.getElementById('total').textContent.replace(/[^0-9.]/g, '')) || 0;
        let pay = parseFloat(document.getElementById('pay').value) || 0;
        let change = pay - total;

        document.getElementById('change').value = change >= 0 ? `₱${change.toFixed(2)}` : "₱0.00";
    }

    document.getElementById("paymentForm").addEventListener("submit", function(event) {
        let total = parseFloat(document.getElementById('total').textContent.replace(/[^0-9.]/g, '')) || 0;
        let pay = parseFloat(document.getElementById('pay').value) || 0;

        if (pay < total) {
            event.preventDefault();  // Prevent form submission
            alert("Payment must be equal to or greater than the total amount!");
        }
    });

