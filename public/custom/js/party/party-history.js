$(document).ready(function () {
    $('#party_id').on('change', function () {
        const customerId = $(this).val();

        if (!customerId) return; // guard clause

        $.ajax({
            url: '{{ route("get.customer.history") }}', // Laravel route
            method: 'GET',
            data: { customer_id: customerId },
            success: function (response) {
                $('#customer-history').html(response.html); // assuming you're returning HTML
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                $('#customer-history').html('<p class="text-danger">Failed to fetch history.</p>');
            }
        });
    });
});