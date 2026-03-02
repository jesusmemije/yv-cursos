'use strict'
$(function () {
    const gatewaySelectors = {
        paypal: ['.paypal_conversion_rate', '.paypal_currency'],
        bank: ['.bank_conversion_rate', '.bank_currency'],
        stripe: ['.stripe_conversion_rate', '.stripe_currency'],
        openpay: ['.openpay_conversion_rate', '.openpay_currency'],
        razorpay: ['.razorpay_conversion_rate', '.razorpay_currency'],
        instamojo: ['.instamojo_conversion_rate', '.instamojo_currency'],
        mollie: ['.mollie_conversion_rate', '.mollie_currency'],
        mercadopago: ['.mercado_conversion_rate', '.mercado_currency'],
        flutterwave: ['.flutterwave_conversion_rate', '.flutterwave_currency'],
        sslcommerz: ['.sslcommerz_conversion_rate', '.sslcommerz_currency'],
        paystack: ['.paystack_conversion_rate', '.paystack_currency'],
        coinbase: ['.coinbase_conversion_rate', '.coinbase_currency'],
        zitopay: ['.zitopay_conversion_rate', '.zitopay_currency'],
        iyzipay: ['.iyzipay_conversion_rate', '.iyzipay_currency'],
        bitpay: ['.bitpay_conversion_rate', '.bitpay_currency'],
        braintree: ['.braintree_conversion_rate', '.braintree_currency']
    };

    function toNumber(value) {
        return parseFloat(String(value || '').replace(/[^0-9.]/g, '')) || 0;
    }

    function setGatewayPrice(rate, currency, grandTotal) {
        const calculated = (grandTotal * toNumber(rate)).toFixed(2);
        $('.selected_conversation_rate').html(rate || '0');
        $('.selected_currency').html(currency || '');
        $('.gateway_calculated_rate_currency').html(currency || '');
        $('.gateway_calculated_rate_price').html(calculated);
    }

    function updateSelectedGateway() {
        const payment_method = $('input[name="payment_method"]:checked').val();
        const grand_total = toNumber($('.grand_total').text());

        $("#openpay-form").addClass("d-none");
        if (payment_method === 'sslcommerz') {
            $(".sslcz-btn").removeClass('d-none');
            $(".regular-btn").addClass('d-none');
        } else {
            $(".sslcz-btn").addClass('d-none');
            $(".regular-btn").removeClass('d-none');
        }

        if (payment_method && gatewaySelectors[payment_method]) {
            const selectors = gatewaySelectors[payment_method];
            const rate = $(selectors[0]).val();
            const currency = $(selectors[1]).val();
            setGatewayPrice(rate, currency, grand_total);
        }

        if (payment_method === 'openpay') {
            $("#openpay-form").removeClass("d-none");
        }
    }

    $('input[type=radio][name=payment_method]').on('change', updateSelectedGateway);
    updateSelectedGateway();

    $('form.require-validation').on('submit', function (e) {
        const payment_method = $('input[name="payment_method"]:checked').val();

        if (payment_method === 'razorpay') {
            e.preventDefault();
            $("#razorpay_payment").trigger('submit');
            return;
        }

        if (payment_method === 'paystack') {
            e.preventDefault();
            $("#paystack_payment").trigger('submit');
            return;
        }

        if (payment_method === 'openpay') {
            e.preventDefault();

            const cardNumber = $("#card_number");
            const holderName = $("#holder_name");
            const expirationYear = $("#expiration_year");
            const expirationMonth = $("#expiration_month");
            const cvv2 = $("#cvv2");
            const isValidForm = cardNumber.val() !== ''
                && holderName.val() !== ''
                && expirationYear.val() !== ''
                && expirationMonth.val() !== ''
                && cvv2.val() !== '';

            if (!isValidForm) {
                toastr.error("Invalid data");
                return;
            }

            const cardData = {
                card_number: cardNumber.val(),
                holder_name: holderName.val(),
                expiration_year: expirationYear.val(),
                expiration_month: expirationMonth.val(),
                cvv2: cvv2.val()
            };

            OpenPay.token.create(cardData, (response) => {
                $("#token_id").val(response.data.id);
                this.submit();
            }, (error) => {
                const message = error && error.data && error.data.description
                    ? error.data.description
                    : "Openpay error";
                toastr.error(message);
                $("#token_id").val("");
            });
        }
    });

    $('.appDemo').click(function () {
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.error("This is a demo version! You can get full access after purchasing the application.")
    });

    $('#bank_id').change(function () {
        var bank_id = $('#bank_id').val();
        var fetchBankRoute = $('.fetchBankRoute').val();
        $.ajax({
            type: "GET",
            url: fetchBankRoute,
            data: { 'bank_id': bank_id },
            datatype: "json",
            success: function (response) {
                $('.account_number').val(response.account_number);
            },
            error: function (error) {

            },
        });


    });
});
