function createParcel() {
    $.ajax({
        type: "GET",
        url: "create",
        success: function (data) {
            $('#createParcelModal').html(data);
            $('#modal-create-parcel').modal('show');
        }
    });
}

function updateParcel(id){
    $.ajax({
        type: "GET",
        url: "update",
        data: {
            id : id,
        },
        success: function (data) {
            $('#updateParcelContent').html(data);
            $('#modal-update-parcel').modal('show');
        }
    });
}

function viewParcel(id){
    $.ajax({
        type: "GET",
        url: "view",
        data: {
            id : id,
        },
        success: function (data) {
            $('#viewParcelContent').html(data);
            $('#modal-view-parcel').modal('show');
        }
    });
}

function scanCode(id){
    $.ajax({
        type: "GET",
        url: "qr-scan",
        data: {
            id : id,
        },
        success: function (data) {
            $('#qrCodeParcelContent').html(data);
            $('#modal-qrScan-parcel').modal('show');
        }
    });
}

/**
 * @param heading
 * @param text
 * @param type - success, warning, error.
*/
function showNotification(heading,text,type){
    $.toast({
        heading: heading,
        text: text,
        showHideTransition: 'slide',
        icon: type,
        hideAfter : 5000,
    });
}