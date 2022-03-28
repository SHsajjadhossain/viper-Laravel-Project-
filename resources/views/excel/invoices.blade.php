<table>
    <thead>
    <tr>
        <th>Order ID</th>
        <th>Cart Total</th>
        <th>Discount Total</th>
        <th>Sub Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->cart_total }}</td>
            <td>{{ $invoice->discount_total }}</td>
            <td>{{ $invoice->sub_total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
