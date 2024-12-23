const stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}');
const elements = stripe.elements();
const card = elements.create('card');
card.mount('#card-element');

const paymentForm = document.getElementById('payment-form');
const paymentMethodInput = document.getElementById('payment_method_id');
const stripePaymentMethod = document.getElementById('stripe-payment-method');

document.addEventListener('livewire:initialized', () => {
    const shippingFeeInput = document.getElementById('form_shipping_fee');
    const totalInput = document.getElementById('form_total');
    window.Livewire.on('shipping-calculated', (eventData) => {
        console.log('Shipping data received:', eventData[0].fee);
        if (shippingFeeInput && totalInput) {
            shippingFeeInput.value = eventData[0].fee;
            console.log('Updated shipping fee:', shippingFeeInput.value);
            totalInput.value = eventData[0].total;
            console.log('Updated total:', totalInput.value);

            console.log('Updated values:', {
                shippingFee: shippingFeeInput,
                total: totalInput
            });
        }
    });
});
paymentForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    const shippingFee = document.getElementById('form_shipping_fee').value;
    const total = document.getElementById('form_total').value;

    console.log('Submitting with values:', {
        shippingFee: shippingFee,
        total: total
    });
    if (!shippingFee || parseFloat(shippingFee) <= 0) {
        alert('Please calculate shipping before proceeding.');
        return;
    }
    document.getElementById('form_shipping_fee').value = shippingFee;
    document.getElementById('form_total').value = total;



    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

    if (paymentMethod === 'stripe') {
        const {
            paymentMethod,
            error
        } = await stripe.createPaymentMethod({
            type: 'card',
            card: card,
        });

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            paymentMethodInput.value = paymentMethod.id;
            paymentForm.submit();
        }
    } else {
        paymentForm.submit();
    }
});

document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
    input.addEventListener('change', (event) => {
        if (event.target.value === 'stripe') {
            stripePaymentMethod.style.display = 'block';
        } else {
            stripePaymentMethod.style.display = 'none';
        }
    });
});