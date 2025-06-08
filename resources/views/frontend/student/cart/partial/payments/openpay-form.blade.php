<form id="payment-form" method="POST" name="payment-form">
    <div style="display: flex;">
        <div class="card-expl">
            <div class="credit"><span>Tarjetas de crédito</span></div>
            <div class="debit"><span>Tarjetas de débito</span></div>
        </div>
    </div>
    @csrf
    <div>
        <label class="label-text-title color-heading font-medium font-16 mt-3" for="holder_name">Nombre del titular</label>
        <input class="form-control" type="text" id="holder_name" name="holder_name" placeholder="Nombre del titular" novalidate>
    </div>
    <div>
        <label class="label-text-title color-heading font-medium font-16 mt-3" for="card_number">Número de tarjeta</label>
        <input type="number" class="form-control" id="card_number" name="card_number" placeholder="Número de tarjeta" novalidate>
    </div>
    <div class="d-flex gap-16 pt-3">
        <div class="flex-50">
            <label class="label-text-title color-heading font-medium font-16 mt-3" for="expiration_month">Mes de expiración</label>
            <input type="number" class="form-control" name="expiration_month" id="expiration_month" placeholder="MM" novalidate>
        </div>
        <div class="flex-50">
            <label class="label-text-title color-heading font-medium font-16 mt-3" for="expiration_year">Año de expiración</label>
            <input type="number" name="expiration_year" class="form-control" id="expiration_year" placeholder="AA" novalidate>
        </div>    
    </div>

    <div>
        <label class="label-text-title color-heading font-medium font-16 mt-3" for="cvv2">CVV</label>
        <input type="password" class="form-control" name="cvv2" id="cvv2" placeholder="CVV" novalidate autocomplete="off">
    </div>

    <input type="hidden" name="device_session_id">
    <small>Transacciones realizadas via openpay</small>
</form>

<style>
    .gap-16{
        gap:16px
    }
    .flex-50{
        flex: 1 1 50%;
    }
    .card-expl {
        float: left;
        height: 80px;
        margin: 20px 0;
        display: flex;
    }
    .card-expl div {
        background-position: left 45px;
        background-repeat: no-repeat;
        height: 70px;
        padding-top: 10px;
    }
    .card-expl div.debit {
        background-image: url("../frontend/assets/img/student-profile-img/cards2.png");
        width: 540px;
        margin-left: 9px;
    }
    .card-expl div.credit {
        background-image: url("../frontend/assets/img/student-profile-img/cards1.png");
        border-right: 1px solid #ccc;
        width: 200px;
    }
    .card-expl h4 {
        font-weight: 400;
        margin: 0;
    }
</style>