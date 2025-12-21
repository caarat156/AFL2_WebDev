console.log('cart.js loaded!');

function initCart() {
    console.debug('initCart running');

    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const itemsCount = document.getElementById('itemsCount');
    const subtotalAmount = document.getElementById('subtotalAmount');
    const totalAmount = document.getElementById('totalAmount');

    // get CSRF token from meta tag in the layout
    const meta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = meta ? meta.content : null;

    // Function to format number as Rupiah
    function formatRupiah(number) {
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Function to calculate total (reads current quantity inputs when available)
    function calculateTotal() {
        console.debug('calculateTotal start');
        let total = 0;
        let count = 0;

        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const cartId = checkbox.value;
                // Prefer reading current value from input (live), fallback to data-quantity
                const input = document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`);
                let quantity = 0;
                if (input) {
                    quantity = parseInt(input.value) || 0;
                } else {
                    quantity = parseInt(checkbox.dataset.quantity) || 0;
                }

                const price = parseInt(checkbox.dataset.price) || (input ? parseInt(input.dataset.price) : 0);
                total += price * quantity;
                count++;
                console.debug('included item', { cartId, price, quantity, lineTotal: price * quantity });
            }
        });

        if (itemsCount) itemsCount.textContent = count;
        if (subtotalAmount) subtotalAmount.textContent = formatRupiah(total);
        if (totalAmount) totalAmount.textContent = formatRupiah(total);

        // Enable/disable checkout button
        if (checkoutBtn) checkoutBtn.disabled = count === 0;
        console.debug('calculateTotal end', { count, total });
    }

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            console.debug('selectAll toggled', this.checked);
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            calculateTotal();
        });
    }

    // Individual checkbox change (delegated) — handle dynamically too
    document.addEventListener('change', function(e) {
        const target = e.target;
        if (target && target.matches('.item-checkbox')) {
            console.debug('checkbox changed', { value: target.value, checked: target.checked });
            // update selectAll state
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            if (selectAllCheckbox) selectAllCheckbox.checked = allChecked;
            calculateTotal();
        }
    });

    // Update quantity button
    document.querySelectorAll('.update-quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.dataset.cartId;
            const input = document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`);
            const quantity = input.value;
            const price = parseInt(input.dataset.price);

            console.debug('sending update quantity', { cartId, quantity });

            // Kirim AJAX request (menggunakan token dari meta tag)
            fetch(`/user/cart/${cartId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    _method: 'PATCH',
                    quantity: quantity
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.debug('update response', data);
                // Update data-quantity di checkbox
                const checkbox = document.querySelector(`.item-checkbox[value="${cartId}"]`);
                if (checkbox) {
                    checkbox.dataset.quantity = quantity;
                }

                // Update subtotal di row
                const row = input.closest('tr');
                const subtotalElement = row.querySelector('.item-subtotal');
                if (subtotalElement) {
                    const newSubtotal = price * quantity;
                    subtotalElement.textContent = formatRupiah(newSubtotal);
                }

                // Recalculate total
                calculateTotal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update quantity. Please try again.');
            });
        });
    });

    // Live update when user edits quantity input (updates subtotal and recalculates totals)
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function() {
            const cartId = this.dataset.cartId;
            const price = parseInt(this.dataset.price) || 0;
            const quantity = parseInt(this.value) || 0;

            console.debug('quantity input', { cartId, price, quantity });

            // Update corresponding subtotal cell (live, without saving to server)
            const row = this.closest('tr');
            const subtotalElement = row ? row.querySelector('.item-subtotal') : null;
            if (subtotalElement) {
                subtotalElement.textContent = formatRupiah(price * quantity);
            }

            // Update checkbox dataset so calculateTotal can use it if needed
            const checkbox = document.querySelector(`.item-checkbox[value="${cartId}"]`);
            if (checkbox) {
                checkbox.dataset.quantity = quantity;
            }

            // Recalculate totals if that item is checked
            if (checkbox && checkbox.checked) {
                calculateTotal();
            }
        });
    });

    // Delete item using fetch to avoid submitting the outer checkout form
    async function handleDelete(cartId, row) {
        if (!cartId) {
            console.error('handleDelete called without cartId');
            return;
        }

        try {
            console.debug('handleDelete', { cartId });

            if (!csrfToken) console.warn('No CSRF token found when attempting delete');

            const url = `/user/cart/${cartId}`;
            console.debug('Deleting URL:', url);
            // visible debug alert while debugging
            alert(`Deleting item ${cartId}...`);

            const resp = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            console.debug('delete response status', resp.status);

            if (!resp.ok) {
                let body = '';
                try { body = await resp.json(); } catch (e) { body = await resp.text(); }
                alert('Delete failed: ' + resp.status + ' — see console for details');
                throw new Error(`Delete failed: ${resp.status} ${JSON.stringify(body)}`);
            }

            console.debug('delete successful', { cartId });
            alert('Item removed');

            if (row && row.parentNode) row.parentNode.removeChild(row);
            calculateTotal();
        } catch (err) {
            console.error('Error deleting item:', err);
            alert('Failed to remove item. Please try again.');
        }
    }

    // direct listeners for delete buttons
    document.querySelectorAll('.delete-item-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const cartId = this.dataset.cartId;
            if (!confirm('Are you sure you want to remove this item?')) return;
            const row = this.closest('tr');
            handleDelete(cartId, row);
        });
    });

    // delegated delete handler (covers dynamically added buttons)
    document.addEventListener('click', function (e) {
        const target = e.target.closest ? e.target.closest('.delete-item-btn') : null;
        if (!target) return;
        e.preventDefault();
        console.debug('delegated delete click', { cartId: target.dataset.cartId });
        if (!confirm('Are you sure you want to remove this item?')) return;
        const cartId = target.dataset.cartId;
        const row = target.closest('tr');
        handleDelete(cartId, row);
    });

    // Initial calculation
    if (itemCheckboxes.length > 0) {
        calculateTotal();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCart);
} else {
    initCart();
}
