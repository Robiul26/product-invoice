<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        input[readonly] {
            pointer-events: none;
            outline: none;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        {{-- List of Product --}}
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Product List</h5>
                        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">Add new Product</a>
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Product Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->unit }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create Invoice --}}
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Create Invoice</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between align-items-center gap-2">
                            {{-- <label for="product-select">Select Product:</label> --}}
                            <select id="product-select" class="form-control">

                            </select>
                            <div class="">
                                <button class="btn btn-primary btn-sm input-group-text" id="add-product-btn">+ Add
                                    More</button>
                            </div>
                        </div>
                        <form action="{{ route('invoice.store') }}" method="POST">
                            @csrf
                            <div class="card mb-2">
                                <div class="card-body">

                                    @if (session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                    <!-- Invoice Table -->
                                    <div class="table-responsive">
                                        <table class="table" id="invoice-table">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="fw-bold">Grand Total</td>
                                                    <td class="fw-bold">
                                                        <input id="grand-total"
                                                            class="bg-transparent border-0 form-control"
                                                            name="total_amount" readonly />
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success" id="save-invoice-btn">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- List of Invoice --}}
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Invoice List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Invoice Number</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $invoice->invoice_number }}</td>
                                            <td>{{ $invoice->total_amount }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#_{{ $invoice->id }}">
                                                    View Details
                                                </button>
                                                <div class="modal fade" id="_{{ $invoice->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h2>Invoice Number: {{ $invoice->invoice_number }}</h2>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Product Name</th>
                                                                                <th scope="col">Product Descriptions
                                                                                </th>
                                                                                <th scope="col">Unit Price</th>
                                                                                <th scope="col">QTY</th>
                                                                                <th scope="col">Sub Total</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $grandTotal = 0; // Initialize grand total
                                                                            @endphp
                                                                            @foreach ($invoice->details as $detail)
                                                                                @php
                                                                                    $productDescriptions = json_decode(
                                                                                        $detail->product_description,
                                                                                        true,
                                                                                    );
                                                                                    $grandTotal += $detail->total_price;
                                                                                @endphp

                                                                                <tr>
                                                                                    <th scope="row">
                                                                                        {{ $loop->iteration }}
                                                                                    </th>
                                                                                    <td>{{ $detail->product_name }}
                                                                                    </td>
                                                                                    <td>
                                                                                        <ul class="list-group">
                                                                                            @foreach ($productDescriptions as $description)
                                                                                                <li
                                                                                                    class="list-group-item">
                                                                                                    {{ $description }}
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </td>
                                                                                    <td>{{ $detail->unit_price }}</td>
                                                                                    <td>{{ $detail->quantity }}</td>
                                                                                    <td>{{ $detail->total_price }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr class="fw-bold">
                                                                                <td colspan="5">Grand Total</td>
                                                                                <td>{{ $grandTotal }}.00</td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productSelect = document.getElementById('product-select');
            const addProductBtn = document.getElementById('add-product-btn');
            const invoiceTableBody = document.querySelector('#invoice-table tbody');
            const grandTotalCell = document.getElementById('grand-total');

            let products = [];
            let grandTotal = 0;

            fetch('/get-products')
                .then(response => response.json())
                .then(data => {
                    products = data;
                    productSelect.innerHTML = products.map(product =>
                        `<option value="${product.id}">${product.name}</option>`
                    ).join('');
                });

            addProductBtn.addEventListener('click', () => {
                const productId = productSelect.value;
                const product = products.find(p => p.id == productId);
                const row = document.createElement('tr');
                const productIndex = document.querySelectorAll('#invoice-table tbody tr').length;
                row.innerHTML = `
                    <td><input class="form-control bg-transparent border-0" name="product_name[]" value="${product.name}" readonly/></td>
                    <td>
                        <ul class="list-group">
                        ${product.variants.map(v => `
                                        <li class="list-group-item">
                                            <input type="checkbox" name="product_description[${productIndex}][]" id="_${v.id}" value="${v.description}" data-price="${v.price}" class="variant-checkbox">
                                            
                                            <label class="form-check-label text-nowrap" for="_${v.id}">${v.description}</label>
                                        </li>
                                        `).join('')}
                        </ul>
                    </td>
                    <td><input class="product_price form-control bg-transparent border-0" name="unit_price[]" readonly/></td>
                    
                    <td><input type="number" name="quantity[]" class="quantity form-control" min="1" value="1"></td>
                    <td ><input class="subtotal bg-transparent border-0 form-control" name="total_price[]" readonly/></td>
                    <td><button class="btn btn-danger btn-sm remove-row">X</button></td>
                    `;
                invoiceTableBody.appendChild(row);
                updateGrandTotal();
            });

            invoiceTableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('variant-checkbox')) {
                    const row = e.target.closest('tr');

                    // Update the product price
                    const productPriceCell = row.querySelector('.product_price');
                    const currentProductPrice = parseFloat(productPriceCell.value) || 0;

                    // Add or subtract the variant price
                    const variantPrice = parseFloat(e.target.dataset.price);
                    const updatedProductPrice = e.target.checked ?
                        currentProductPrice + variantPrice :
                        currentProductPrice - variantPrice;
                    productPriceCell.value = updatedProductPrice.toFixed(2);

                    // Update the subtotal
                    const quantity = parseInt(row.querySelector('.quantity').value) || 1;
                    const subtotalCell = row.querySelector('.subtotal');
                    subtotalCell.value = (updatedProductPrice * quantity).toFixed(2);

                    // Update the grand total
                    updateGrandTotal();
                }

                if (e.target.classList.contains('quantity')) {
                    const row = e.target.closest('tr');

                    // Get the product price and quantity
                    const productPrice = parseFloat(row.querySelector('.product_price').value) || 0;
                    const quantity = parseInt(e.target.value) || 1;

                    // Update the subtotal
                    const subtotalCell = row.querySelector('.subtotal');
                    subtotalCell.value = (productPrice * quantity).toFixed(2);

                    // Update the grand total
                    updateGrandTotal();
                }
            });

            invoiceTableBody.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                    updateGrandTotal();
                }
            });

            function updateGrandTotal() {
                const subtotals = Array.from(document.querySelectorAll('.subtotal'));
                grandTotal = subtotals.reduce((acc, cell) => acc + parseFloat(cell.value), 0);
                grandTotalCell.value = (grandTotal ? grandTotal : 0).toFixed(2);
            }
        });
    </script>

</body>

</html>
