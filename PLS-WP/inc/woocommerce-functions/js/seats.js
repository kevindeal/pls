document.addEventListener('DOMContentLoaded', function() {
    // Find the quantity selector
    var quantitySelector = document.querySelector('.quantity input.qty');

    // Create a new span element
    var seatsSpan = document.createElement('span');
    seatsSpan.className = 'quantity-label';
    seatsSpan.textContent = ' seats';

    // Append the new span after the quantity selector
    if (quantitySelector && quantitySelector.parentNode) {
        quantitySelector.parentNode.insertBefore(seatsSpan, quantitySelector.nextSibling);
    }
});
