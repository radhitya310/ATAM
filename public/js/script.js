// // untuk function button alert transaction
// function closeButtonAlertFunc(){
//     document.getElementById('wadahCloseButtonAlert').style.display="none";
// }

// // untuk button confirm auto click
// // onload = untuk load otomatis
// window.onload = function(){

//     var button = document.getElementById('clickButtonConfirm');
//     button.click();

//     // document.getElementById('clickButtonConfirm').click();

//     // var button = document.getElementById('clickButtonConfirm');
//     // setInterval(function(){
//     //     button.click();
//     // }, 1000); // untuk auto click confirm selama 1000 miliseconds
// }


// // untuk selected service
// $(function(){
//     $('#service_id').change(function(){
//         $('#service_price').val($('#service_id option:selected').attr('data-price'));
//         document.getElementById('wadah_subTotalPrice').style.display="block";
//         document.getElementById('wadah_totalPrice').style.display="block";
//     });
// });


var quantity_Elm = document.querySelector('#quantity');
var serviceID_Elm = document.querySelector('#service_id');

serviceID_Elm.addEventListener('change', calculateTotal);
serviceID_Elm.addEventListener('change', viewPrice);
quantity_Elm.addEventListener('change', calculateTotal);

// function untuk nampilin price
function viewPrice(){
    document.getElementById('wadah_subTotalPrice').style.display="block";
    document.getElementById('wadah_totalPrice').style.display="block";
}

var qty = quantity_Elm.value;
if (qty == 0) {
    qty = 1;
    $('#quantity').val(1);
}

function calculateTotal(){
    $('#service_price').val($('#service_id option:selected').attr('data-price'));
    if (qty == 0) {
        $('#totalPrice').val($('#service_id option:selected').attr('data-price')*1);
    }
    else{
        $('#totalPrice').val($('#service_id option:selected').attr('data-price')*qty);
    }
}

function plusClick(){
    qty++;
    $('#quantity').val(qty);
    calculateTotal();
}

function minusClick(){
    if (qty > 1){
        qty--;
        $('#quantity').val(qty);
        calculateTotal();
    }
}
