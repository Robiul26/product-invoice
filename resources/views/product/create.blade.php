<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add new Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Add Product</h5>
                        <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm">Product List</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Product Name">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-control" name="unit" id="unit" placeholder="Product Unit">
                                    <option value="">Select Unit</option>
                                    <option value="liter">Liter</option>
                                    <option value="kg">Kg</option>
                                    <option value="box">Box</option>
                                </select>
                                @error('unit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <h2>Product Variant</h2>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <table class="table" id="variant-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Price</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="variant-row">
                                                <td>
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="number" name="price[]" class="form-control"
                                                        id="price" placeholder="Product price">
                                                    @error('price')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" name="description[]" id="description" placeholder="Product Description"></textarea>
                                                    @error('description')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <td><button class="btn btn-danger btn-sm remove-variant"
                                                        type="button">X</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        <button class="btn btn-sm btn-primary" id="add-variant-btn" type="button">+ Add
                                            more Variant</button>
                                    </div>
                                </div>
                            </div>







                            <button type="submit" class="btn btn-success">Submit</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>



    <script>
        document.getElementById('add-variant-btn').addEventListener('click', function() {
            // Get the table body and the template row
            const tableBody = document.querySelector('#variant-table tbody');
            const newRow = document.querySelector('.variant-row').cloneNode(true); // Clone the first row

            // Clear the inputs in the cloned row
            const inputs = newRow.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.value = '';
            });

            // Append the cloned row to the table
            tableBody.appendChild(newRow);
        });

        // Add event listener to remove a variant row
        document.querySelector('#variant-table').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('tr').remove(); // Remove the clicked row
            }
        });
    </script>
</body>

</html>
